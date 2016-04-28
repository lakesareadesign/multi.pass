<?php

/**
 * @author: Hoang Ngo
 */
class WD_Admin_Controller extends WD_Controller {
	/**
	 * constructor of this class
	 */
	public function __construct() {
		add_filter( 'custom_menu_order', '__return_true' );
		if ( $this->is_network_activate() ) {
			$this->add_action( 'network_admin_menu', 'admin_menu' );
		} else {
			$this->add_action( 'admin_menu', 'admin_menu' );
		}
		//add another action, for rename the menu
		$this->add_filter( 'menu_order', 'menu_order' );
		$this->add_ajax_action( 'wd_suggest_user_name', 'suggest_user_name' );
		$this->add_ajax_action( 'wd_add_recipient', 'add_recipient' );
		$this->add_ajax_action( 'wd_remove_recipient', 'remove_recipient' );

		$this->add_action( 'admin_enqueue_scripts', 'load_scripts' );
		$this->add_action( 'wp_loaded', 'toggle_showed_intro' );
		$this->add_action( 'wp_loaded', 'settings_save' );
		$this->add_action( 'wp_loaded', 'maybe_submit_result_to_api', 12 );
	}

	/**
	 * This will try to submit newest result to API
	 */
	public function maybe_submit_result_to_api() {
		if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
			return;
		}

		$is_force = false;
		if ( WD_Utils::get_setting( 'flag->submit_asap' ) ) {
			$is_force = true;
		}
		WD_Utils::do_submitting( $is_force );
	}

	public function settings_save() {

		if ( ! WD_Utils::check_permission() ) {
			return;
		}

		if ( ! wp_verify_nonce( WD_Utils::http_post( 'wd_settings_nonce' ), 'wd_settings' ) ) {
			return;
		}

		$defaults = WD_Utils::get_default_settings();
		foreach ( array_keys( $defaults ) as $key ) {
			$val = WD_Utils::http_post( $key );
			if ( strlen( $val ) > 0 ) {
				$val = stripslashes( $val );
				if ( is_array( json_decode( $val, true ) ) ) {
					$val = json_decode( $val, true );
					$val = array_unique( $val );
				} else {
					$val = wp_filter_kses( $val );
				}
				WD_Utils::update_setting( $key, $val );
			}
		}
		$this->flash( 'updated', __( "WP Defender’s settings have been updated", wp_defender()->domain ) );
		wp_redirect( network_admin_url( 'admin.php?page=wdf-settings' ) );
		exit;
	}

	public function remove_recipient() {
		if ( ! WD_Utils::check_permission() ) {
			return;
		}
		$id   = WD_Utils::http_post( 'id' );
		$user = get_user_by( 'id', $id );
		if ( is_object( $user ) ) {
			$lists = WD_Utils::get_setting( 'recipients', array() );
			unset( $lists[ array_search( $id, $lists ) ] );
			WD_Utils::update_setting( 'recipients', $lists );
		}
	}

	public function add_recipient() {
		if ( ! WD_Utils::check_permission() ) {
			return;
		}

		if ( ! wp_verify_nonce( WD_Utils::http_post( 'wd_settings_nonce' ), 'wd_add_recipient' ) ) {
			return;
		}

		$username = WD_Utils::http_post( 'username' );

		if ( strlen( trim( $username ) ) == 0 ) {
			wp_send_json( array(
				'status' => 0,
				'error'  => __( "The username can't be empty!", wp_defender()->domain )
			) );
		}

		$user = get_user_by( 'login', $username );
		if ( is_object( $user ) ) {
			$lists   = WD_Utils::get_setting( 'recipients', array() );
			$lists[] = $user->ID;
			$lists   = array_unique( $lists );
			WD_Utils::update_setting( 'recipients', $lists );
			wp_send_json( array(
				'status' => 1,
				'html'   => $this->display_recipients()
			) );
		} else {
			wp_send_json( array(
				'status' => 0,
				'error'  => sprintf( __( "The username <strong>%s</strong> doesn't exist!", wp_defender()->domain ), $username )
			) );
		}
	}

	public function display_recipients() {
		ob_start();
		?>
		<div id="wd-recipients">
			<?php foreach ( WD_Utils::get_setting( 'recipients', array() ) as $user_login ): ?>
				<?php $user = get_user_by( 'id', $user_login ) ?>
				<?php if ( is_object( $user ) ): ?>
					<div class="wd-recipient">
						<?php echo get_avatar( $user->ID, 24 ) ?>
						<p><?php echo WD_Utils::get_display_name( $user->ID ) ?></p>&nbsp;&nbsp;
						<?php if ( get_current_user_id() == $user->ID ): ?>
							<span class="wd-badge wd-badge-grey">
								<?php _e( "You", wp_defender()->domain ) ?>
							</span>
						<?php endif; ?>&nbsp;&nbsp;
						<a data-id="<?php echo esc_attr( $user->ID ) ?>" class="wd-remove-recipient"
						   href="#"><?php _e( "Remove", wp_defender()->domain ) ?></a>
					</div>
				<?php endif; ?>
			<?php endforeach; ?>
		</div>
		<?php
		return ob_get_clean();
	}

	/**
	 * Ajax to return the username
	 */
	public function suggest_user_name() {
		if ( ! WD_Utils::check_permission() ) {
			return;
		}
		$lists   = WD_Utils::get_setting( 'recipients', array() );
		$args    = array(
			'search'         => '*' . WD_Utils::http_post( 'term' ) . '*',
			'search_columns' => array( 'user_login' ),
			'exclude'        => $lists,
			'number'         => 10,
			'orderby'        => 'user_login',
			'order'          => 'ASC'
		);
		$query   = new WP_User_Query( $args );
		$results = array();
		foreach ( $query->get_results() as $row ) {
			$results[] = array(
				'id'    => $row->user_login,
				'label' => '<span class="name title">' . WD_Utils::get_full_name( $row->user_email ) . '</span> <span class="email">' . $row->user_email . '</span>',
				'thumb' => WD_Utils::get_avatar_url( get_avatar( $row->user_email ) )
			);
		}
		echo json_encode( $results );
		exit;
	}

	/**
	 * This only fired at a first time, then we will use anothe view for dashboard
	 */
	public function toggle_showed_intro() {
		if ( ! WD_Utils::check_permission() ) {
			return;
		}

		if ( ! wp_verify_nonce( WD_Utils::http_post( 'wd_dashboard_nonce' ), 'showed_intro' ) ) {
			return;
		}

		WD_Utils::update_setting( 'dashboard->showed_intro', 1 );
		$url = network_admin_url( 'admin.php?page=wp-defender' );
		wp_redirect( $url );
		exit;
	}

	/**
	 * Reorder the menu
	 */
	public function menu_order( $menu_order ) {
		global $submenu;

		if ( isset( $submenu['wp-defender'] ) ) {
			$defender_menu       = $submenu['wp-defender'];
			$defender_menu[6][4] = 'wd-menu-hide';
			$defender_menu[0][0] = __( "Dashboard", wp_defender()->domain );
			$settings            = $defender_menu[1];
			unset( $defender_menu[1] );
			$defender_menu[]        = $settings;
			$defender_menu          = array_values( $defender_menu );
			$submenu['wp-defender'] = $defender_menu;
		}

		return $menu_order;
	}

	public function admin_menu() {
		$cap = is_multisite() ? 'manage_network_options' : 'manage_options';
		add_menu_page( __( "Defender", wp_defender()->domain ), __( "Defender", wp_defender()->domain ), $cap, 'wp-defender', array(
			&$this,
			'main_admin_page'
		) );
		add_submenu_page( 'wp-defender', __( "Settings", wp_defender()->domain ), __( "Settings", wp_defender()->domain ), $cap, 'wdf-settings', array(
			&$this,
			'settings_page'
		) );
	}

	/**
	 * Dashboard page
	 */
	public function main_admin_page() {
		$args  = WD_Utils::get_automatic_scan_settings();
		$names = array();
		foreach ( WD_Utils::get_setting( 'recipients', array() ) as $user_login ) {
			$user    = get_user_by( 'id', $user_login );
			$names[] = $user->display_name;
		}
		$args['names'] = $names;
		$this->render( 'dashboard/main', $args, true );
	}

	/**
	 * Settings page
	 */
	public function settings_page() {
		//load the settings
		$settings = array();
		foreach ( WD_Utils::get_default_settings() as $key => $default ) {
			$val = WD_Utils::get_setting( $key, $default );
			$val = is_array( $val ) ? implode( ',', $val ) : $val;
			if ( in_array( $key, array(
				'completed_scan_email_content_error',
				'completed_scan_email_content_success'
			) ) ) {
				$settings[ $key ] = array(
					'field' => 'textarea',
					'value' => $val,
					'name'  => $key,
				);
			} else {
				$settings[ $key ] = array(
					'field' => 'text',
					'value' => $val,
					'name'  => $key,
				);
			}
		}
		$args['settings'] = $settings;
		$this->render( 'settings', $args, true );
	}

	/**
	 * Check if in right page, then load assets
	 */
	public function load_scripts() {
		if ( $this->is_in_page() ) {
			WDEV_Plugin_Ui::load( wp_defender()->get_plugin_url() . 'shared-ui/', false );
			wp_enqueue_style( 'wp-defender' );
			wp_enqueue_script( 'wp-defender' );
			wp_enqueue_script( 'wd-tag' );
			wp_enqueue_script( 'wd-tag-plugin' );
			wp_enqueue_script( 'jquery-ui-autocomplete' );
		}
	}

	/**
	 * check if this page is page of the plugin
	 * @return bool
	 */
	private function is_in_page() {
		$screen = get_current_screen();
		if ( is_object( $screen ) && in_array( $screen->id, array(
				'toplevel_page_wp-defender',
				'toplevel_page_wp-defender-network',
				'defender_page_wdf-settings',
				'defender_page_wdf-settings-network'
			) )
		) {
			return true;
		}

		return false;
	}
}