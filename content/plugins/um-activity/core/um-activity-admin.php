<?php

class UM_Activity_Admin {

	function __construct() {
	
		$this->slug = 'ultimatemember';
		$this->pagehook = 'toplevel_page_ultimatemember';
		
		add_action('um_extend_admin_menu',  array(&$this, 'um_extend_admin_menu'), 5);
		
		add_action('admin_enqueue_scripts',  array(&$this, 'admin_enqueue_scripts'), 10);
		
		add_filter('views_edit-um_activity', array(&$this, 'views_um_activity') );
		
		add_action( 'load-post-new.php', array(&$this, 'prevent_backend_new'), 9 );

		add_filter('parse_query', array(&$this, 'parse_query') );
		
	}
	
	function parse_query($q) {
		global $pagenow;

		if ($pagenow == 'edit.php' && isset($_GET['post_type']) && $_GET['post_type']=='um_activity' ) {

			if ( isset( $_REQUEST['status'] ) && !empty( $_REQUEST['status'] ) ) {
				
				if ( $_REQUEST['status'] == 'flagged' ) {
					$q->set( 'meta_key', '_reported' );
					$q->set( 'meta_value', 0 );
					$q->set( 'meta_compare', '>' );
				}

			}
			
		}
		
		return $q;
		
	}
	
	/***
	***	@
	***/
	function prevent_backend_new() {
		global $current_screen;
		if( $current_screen->id == 'um_activity'){
			wp_die( __('This can be done from the frontend only.','um-activity') );
		}
	}
	
	/***
	***	@
	***/
	function views_um_activity( $views ) {
		global $ultimatemember, $query;

		$array['flagged'] = __('Flagged','um-reviews');
		
		foreach( $array as $view => $name ) {
			if ( isset( $_REQUEST['status'] ) && $_REQUEST['status'] == $view || ( !isset( $_REQUEST['status'] ) && $view == 'all' ) ) {
				$class = 'current';
			} else {
				$class = '';
			}
			$count = (int)get_option("um_activity_{$view}");
			$views[ $view ] = '<a href="?post_type=um_activity&status='.$view.'" class="'.$class.'">' . $name . ' <span class="count">('.$count.')</span></a>';
		}
		
		return $views;
	}

	/***
	***	@
	***/
	function um_extend_admin_menu() {

		$t_count = (int) get_option('um_activity_flagged');
		
		$count = '<span class="awaiting-mod update-plugins count-' . $t_count . '"><span class="processing-count">' . number_format_i18n( $t_count ) . '</span></span>';
		
		add_submenu_page( $this->slug, __('Social Activity','um-activity'), sprintf(__('Social Activity %s','um-activity'), $count ), 'manage_options', 'edit.php?post_type=um_activity', '', '' );
		
		add_submenu_page( $this->slug, __('Hashtags','um-activity'), __('Hashtags','um-activity'), 'manage_options', 'edit-tags.php?taxonomy=um_hashtag', '', '' );
		
	}
	
	/***
	***	@
	***/
	function admin_enqueue_scripts() {
		$screen = get_current_screen();
		
		if ( !isset( $screen->id ) ) return;
		if ( !strstr( $screen->id, 'um_activity' ) ) return;

		wp_register_style('um_admin_activity', um_activity_url . 'admin/assets/css/um-admin-activity.css' );
		wp_enqueue_style('um_admin_activity');
		
		wp_register_script('um_admin_activity', um_activity_url . 'admin/assets/js/um-admin-activity.js', '', '', true );
		wp_enqueue_script('um_admin_activity');
		
	}

}