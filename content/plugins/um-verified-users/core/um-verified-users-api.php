<?php

class UM_Verified_API_Core {

	function __construct() {

		add_action('init', array(&$this, 'request_verification'), 5);

		add_action( 'show_user_profile',        array( $this, 'verification_field'   ) );
		add_action( 'edit_user_profile',        array( $this, 'verification_field'   ) );
		add_action( 'personal_options_update',  array( $this, 'update_verification_field'       ) );
		add_action( 'edit_user_profile_update', array( $this, 'update_verification_field'       ) );

		add_action('um_admin_before_save_role', array( $this, 'um_admin_before_save_role'  ), 1000, 2 );
		add_action('um_after_user_role_is_updated', array( $this, 'um_after_user_role_is_updated'  ), 1000, 2 );

		add_action('um_admin_before_access_settings', array( $this, 'um_admin_before_access_settings' ) );
		add_action('template_redirect',  array(&$this, 'template_redirect'), 5000 );

	}

	/**
	 * Disable content for non-verified
	 */
	function template_redirect() {
		global $post;
		if (! isset( $post->ID ) ) return;
		$post_id = $post->ID;

		$locked = get_post_meta( $post_id, '_um_locked_to_verified', true );
		if  ( absint( $locked ) == 1 ) {
			if ( !is_user_logged_in() )
				exit( wp_redirect( um_get_option('verified_redirect') ) );

			if ( !um_is_verified( get_current_user_id() ) )
				exit( wp_redirect( um_get_option('verified_redirect') ) );
		}
	}

	/**
	 * Settings in access widget
	 */
	function um_admin_before_access_settings() {
		$metabox = new UM_Admin_Metabox();
		$metabox->is_loaded = true;
		?>

		<h4><?php _e('Lock content to verified accounts only?','um-verified'); ?></h4>

		<p>
			<span><?php $metabox->ui_on_off('_um_locked_to_verified', 0); ?></span>
		</p>

		<?php
	}

	/**
	 * Auto-verify role's account
	 */
	function um_after_user_role_is_updated( $user_id, $role ) {
		global $ultimatemember;
		$meta = $ultimatemember->query->role_data( $role );
		$meta = apply_filters('um_user_permissions_filter', $meta, $user_id);
		if ( isset( $meta['verified_by_role'] ) && $meta['verified_by_role'] ) {
			um_verify( $user_id );
		} else {
			um_unverify( $user_id );
		}
	}

	/**
	 * Save user group as verified accounts one time
	 */
	function um_admin_before_save_role( $post_id, $post ) {

		$v = absint( $_POST['_um_verified_by_role'] );
		if ( $v == 1 && ! get_option('um_verified_' . $post->post_name ) ) {

			$args = array( 'fields' => 'ID', 'number' => 0 );
			$args['meta_query'][] = array( array( 'key' => 'role', 'value' => $post->post_name, 'compare' => '=' ) );

			$users = new WP_User_Query( $args );

			if ( isset( $users->results ) ) {
				foreach( $users->results as $user_id ) {
					um_verify( $user_id );
				}
			}

			update_option( 'um_verified_'. $post->post_name, 'done' );

		}

	}

	/**
	 * Verify/unverify from backend profile
	 */
	function verification_field( $user ) {
		if ( current_user_can( 'edit_users' ) && current_user_can( 'edit_user', $user->ID ) ) {
			$user = get_userdata( $user->ID );
			?>
			<table class="form-table">
				<tbody>
					<tr>
						<th>
							<label for="um_set_verification"><?php _e( 'Account Verification', 'um-verified' ); ?></label>
						</th>
						<td>
							<select name="um_set_verification" id="um_set_verification">
								<option value='0' <?php selected( 0, um_is_verified( $user->ID ) ); ?>><?php _e('Unverified Account','um-verified'); ?></option>
								<option value='1'  <?php selected( 1, um_is_verified( $user->ID ) ); ?>><?php _e('Verified Account','um-verified'); ?></option>
							</select>
						</td>
					</tr>
				</tbody>
			</table>
		<?php }
	}

	/**
	 * Save backend profile
	 */
	public function update_verification_field( $user_id ) {
		if ( current_user_can( 'edit_user', $user_id ) && isset( $_POST['um_set_verification'] ) ) {

			$user = get_userdata( $user_id );

			$state = (int) um_is_verified( $user_id );

			if ( $_POST['um_set_verification'] == 1 && $state == 0 ) {
				um_verify( $user_id );
			} else if ( $state == 1 && $_POST['um_set_verification'] == 0 ) {
				um_unverify( $user_id );
			}
		}
	}

	/***
	***	@
	***/
	function request_verification() {

		if ( !is_user_logged_in() )
			return;

		if ( isset( $_REQUEST['request_verification'] ) && isset( $_REQUEST['uid'] ) ) {
			$user_id = absint( $_REQUEST['uid'] );

			if ( $user_id != get_current_user_id() || um_verified_status( $user_id ) != 'unverified' )
				wp_die( __('Unauthorized.','um-verified') );

			um_fetch_user( $user_id );
			
			if ( um_user('verified_req_disallowed') )
				wp_die( __('You are not allowed to do this action.','um-verified') );

			update_user_meta( $user_id, '_um_verified', 'pending' );
			do_action('um_after_user_request_verification', $user_id );

			if ( um_get_option('verified_notify_admin') ) {
				UM_Mail( um_admin_email(), __('New Account Verification Request','um-verified'), 'verification-request', um_verified_path . 'templates/email/',
				array(
					'tags' => array('{verify_approve}','{verify_reject}'),
					'tags_replace' => array( um_verify_user_url( $user_id ), um_unverify_user_url( $user_id ) )
				) );
			}

			exit( wp_redirect( esc_attr( $_REQUEST['redirect_to'] ) ) );
		}

		if ( isset( $_REQUEST['request_verification_undo'] ) && isset( $_REQUEST['uid'] ) ) {
			$user_id = absint( $_REQUEST['uid'] );

			if ( $user_id != get_current_user_id() || um_verified_status( $user_id ) != 'pending' )
				wp_die( __('Unauthorized.','um-verified') );

			um_fetch_user( $user_id );

			update_user_meta( $user_id, '_um_verified', 'unverified' );
			do_action('um_after_user_undo_request_verification', $user_id );

			exit( wp_redirect( esc_attr( $_REQUEST['redirect_to'] ) ) );
		}

	}

	/***
	***	@
	***/
	function get_request_verify_url( $user_id ) {
		$url = get_bloginfo('url');
		$url = add_query_arg( 'request_verification', 'true', $url );
		$url = add_query_arg( 'uid', $user_id, $url );
		return $url;
	}

	/***
	***	@
	***/
	function get_cancel_request_verify_url( $user_id ) {
		$url = get_bloginfo('url');
		$url = add_query_arg( 'request_verification_undo', 'true', $url );
		$url = add_query_arg( 'uid', $user_id, $url );
		return $url;
	}

}
