<?php

class UM_Profile_Completeness_API {

	function __construct() {

		$this->plugin_inactive = false;
		
		add_action('init', array(&$this, 'plugin_check'), 1);
		
		add_action('init', array(&$this, 'init'), 1);
		
		require_once um_profile_completeness_path . 'core/um-profile-completeness-widget.php';
		add_action( 'widgets_init', array(&$this, 'widgets_init' ) );

	}
	
	/***
	***	@Check plugin requirements
	***/
	function plugin_check(){
		
		if ( !class_exists('UM_API') ) {
			
			$this->add_notice( sprintf(__('The <strong>%s</strong> extension requires the Ultimate Member plugin to be activated to work properly. You can download it <a href="https://wordpress.org/plugins/ultimate-member">here</a>','um-profile-completeness'), um_profile_completeness_extension) );
			$this->plugin_inactive = true;
		
		} else if ( !version_compare( ultimatemember_version, um_profile_completeness_extension, '>=' ) ) {
			
			$this->add_notice( sprintf(__('The <strong>%s</strong> extension requires a <a href="https://wordpress.org/plugins/ultimate-member">newer version</a> of Ultimate Member to work properly.','um-profile-completeness'), um_profile_completeness_extension) );
			$this->plugin_inactive = true;
		
		}
		
	}
	
	/***
	***	@Add notice
	***/
	function add_notice( $msg ) {
		
		if ( !is_admin() ) return;
		
		echo '<div class="error"><p>' . $msg . '</p></div>';
		
	}
	
	/***
	***	@Init
	***/
	function init() {
		
		if ( $this->plugin_inactive ) return;

		delete_user_meta( 1, 'birthdate');
		
		// Required classes
		require_once um_profile_completeness_path . 'core/um-profile-completeness-admin.php';
		require_once um_profile_completeness_path . 'core/um-profile-completeness-shortcode.php';
		require_once um_profile_completeness_path . 'core/um-profile-completeness-enqueue.php';
		require_once um_profile_completeness_path . 'core/um-profile-completeness-restrict.php';

		$this->admin = new UM_Profile_Completeness_Admin();
		$this->shortcode = new UM_Profile_Completeness_Shortcode();
		$this->enqueue = new UM_Profile_Completeness_Enqueue();
		$this->restrict = new UM_Profile_Completeness_Restrict();

		require_once um_profile_completeness_path . 'core/um-profile-completeness-metaboxes.php';
		require_once um_profile_completeness_path . 'core/um-profile-completeness-ajax.php';
		require_once um_profile_completeness_path . 'core/um-profile-completeness-profile.php';
		require_once um_profile_completeness_path . 'core/um-profile-completeness-fields.php';
		require_once um_profile_completeness_path . 'core/um-profile-completeness-directory.php';

	}
	
	/***
	***	@get factors that increase completion
	***/
	function get_metrics( $post_id ) {
		$meta = get_post_custom( $post_id );
		foreach( $meta as $k => $v ) {
			if ( strstr( $k, '_um_progress_' ) ) {
				$k = str_replace( '_um_progress_', '', $k );
				if ( $k == 'profile_photo' ) {
					$array['synced_profile_photo'] = $v[0];
				}
					$array[ $k ] = $v[0];
			}
		}
		return ( isset( $array ) ) ? $array : false;
	}
	
	/***
	***	@get user profile progress
	***/
	function get_progress( $user_id ) {
		global $wpdb, $ultimatemember;

		$role = get_user_meta( $user_id, 'role', true );
		
		if ( !$role && um_user('role') ) {
			$role = um_user('role');
		}
		
		if ( !$role )
			return -1;
		
		$post_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE post_status = 'publish' AND post_type = 'um_role' AND post_name = '$role'");
		
		if ( get_post_meta( $post_id, '_um_profilec', true ) != 1 )
			return -1;
		
		// get factors
		$array = $this->get_metrics( $post_id );
		if ( !$array ) {
			
			$result = array(
				'req_progress' => get_post_meta( $post_id, '_um_profilec_pct', true ),
				'progress' => 100,
				'steps' => '',
				'prevent_browse' => get_post_meta( $post_id, '_um_profilec_prevent_browse', true),
				'prevent_profileview' => get_post_meta( $post_id, '_um_profilec_prevent_profileview', true),
				'prevent_comment' => get_post_meta( $post_id, '_um_profilec_prevent_comment', true),
				'prevent_bb' => get_post_meta( $post_id, '_um_profilec_prevent_bb', true)
			);
			
			update_user_meta( $user_id, '_profile_progress', $result );
			update_user_meta( $user_id, '_completed', 100 );
			return $result;
		}
		
		// see what user has completed
		$profile_progress = 0;
		$completed = array();
		foreach( $array as $key => $value ) {
			if ( get_user_meta( $user_id, $key, true ) ) {
				$profile_progress = $profile_progress + (int)$value;
				$completed[] = $key;
			}
		}
		
		$result = array(
			'req_progress' => get_post_meta( $post_id, '_um_profilec_pct', true ),
			'progress' => $profile_progress,
			'steps' => $array,
			'completed' => $completed,
			'prevent_browse' => get_post_meta( $post_id, '_um_profilec_prevent_browse', true),
			'prevent_profileview' => get_post_meta( $post_id, '_um_profilec_prevent_profileview', true),
			'prevent_comment' => get_post_meta( $post_id, '_um_profilec_prevent_comment', true),
			'prevent_bb' => get_post_meta( $post_id, '_um_profilec_prevent_bb', true)
		);
		
		update_user_meta( $user_id, '_profile_progress', $result );
		update_user_meta( $user_id, '_completed', $profile_progress );
		
		$profile_percentage = get_post_meta( $post_id, '_um_profilec_pct', true );

		if( empty( $profile_percentage ) ){
			$profile_percentage = 100;
		}

		if ( $profile_progress >= $profile_percentage && get_post_meta( $post_id, '_um_profilec_upgrade_role', true ) ) {
			$new_role = get_post_meta( $post_id, '_um_profilec_upgrade_role', true );
			um_fetch_user( $user_id );
			$ultimatemember->user->set_role( $new_role );
		}
		
		return $result;
	}

	function widgets_init() {
		
		register_widget( 'um_profile_completeness' );
		register_widget( 'um_profile_progress_bar' );

	}

}

$um_profile_completeness = new UM_Profile_Completeness_API();