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
		$this->flash( 'updated', esc_html__( "WP Defender’s settings have been updated", wp_defender()->domain ) );
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
				'error'  => esc_html__( "The username can't be empty!", wp_defender()->domain )
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
						<p><?php echo esc_html( WD_Utils::get_display_name( $user->ID ) ) ?></p>&nbsp;&nbsp;
						<?php if ( get_current_user_id() == $user->ID ): ?>
							<span class="wd-badge wd-badge-grey">
								<?php esc_html_e( "You", wp_defender()->domain ) ?>
							</span>
						<?php endif; ?>&nbsp;&nbsp;
						<a data-id="<?php echo esc_attr( $user->ID ) ?>" class="wd-remove-recipient"
						   href="#"><?php esc_html_e( "Remove", wp_defender()->domain ) ?></a>
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
				'label' => '<span class="name title">' . esc_html( WD_Utils::get_full_name( $row->user_email ) ) . '</span> <span class="email">' . esc_html( $row->user_email ) . '</span>',
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
			$defender_menu = $submenu['wp-defender'];
			//$defender_menu[6][4] = 'wd-menu-hide';
			$defender_menu[0][0] = esc_html__( "Dashboard", wp_defender()->domain );
			$settings            = $defender_menu[1];
			unset( $defender_menu[1] );
			$defender_menu[]        = $settings;
			$defender_menu          = array_values( $defender_menu );
			$submenu['wp-defender'] = $defender_menu;
		}

		return $menu_order;
	}

	public function admin_menu() {
		$cap        = is_multisite() ? 'manage_network_options' : 'manage_options';
		$menu_title = esc_html__( "Defender%s", wp_defender()->domain );
		if ( ( $count = WD_Utils::get_setting( 'info->issues_count', 0 ) ) == 0 ) {
			$menu_title = sprintf( $menu_title, ' <span class="update-plugins wd-issue-indicator-sidebar"></span>' );
		} else {
			$menu_title = sprintf( $menu_title, ' <span class="update-plugins wd-issue-indicator-sidebar count-' . $count . '"><span>' . ( $count > 99 ? '99+' : $count ) . '</span></span>' );	  	 	   	 		 		 				
		}
		add_menu_page( esc_html__( "Defender", wp_defender()->domain ), $menu_title, $cap, 'wp-defender', array(
			&$this,
			'main_admin_page'
		), $this->get_menu_icon() );
		add_submenu_page( 'wp-defender', esc_html__( "Settings", wp_defender()->domain ), esc_html__( "Settings", wp_defender()->domain ), $cap, 'wdf-settings', array(
			&$this,
			'settings_page'
		) );
	}

	private function get_menu_icon() {
		ob_start();
		?>
		<svg width="17px" height="18px" viewBox="10 397 17 18" version="1.1" xmlns="http://www.w3.org/2000/svg"
		     xmlns:xlink="http://www.w3.org/1999/xlink">
			<!-- Generator: Sketch 3.8.3 (29802) - http://www.bohemiancoding.com/sketch -->
			<desc>Created with Sketch.</desc>
			<defs></defs>
			<path
				d="M24.8009393,403.7962 L23.7971393,410.1724 C23.7395393,410.5372 23.5313393,410.8528 23.2229393,411.0532 L18.4001393,413.6428 L13.5767393,411.0532 C13.2683393,410.8528 13.0601393,410.5372 13.0019393,410.1724 L11.9993393,403.7962 L11.6153393,401.3566 C12.5321393,402.9514 14.4893393,405.5518 18.4001393,408.082 C22.3115393,405.5518 24.2675393,402.9514 25.1855393,401.3566 L24.8009393,403.7962 Z M26.5985393,398.0644 C25.7435393,397.87 22.6919393,397.2106 19.9571393,397 L19.9571393,403.4374 L18.4037393,404.5558 L16.8431393,403.4374 L16.8431393,397 C14.1077393,397.2106 11.0561393,397.87 10.2011393,398.0644 C10.0685393,398.0938 9.98213933,398.221 10.0031393,398.3536 L10.8875393,403.969 L11.8913393,410.3446 C12.0071393,411.0796 12.4559393,411.7192 13.1105393,412.0798 L16.8431393,414.1402 L18.4001393,415 L19.9571393,414.1402 L23.6891393,412.0798 C24.3431393,411.7192 24.7925393,411.0796 24.9083393,410.3446 L25.9121393,403.969 L26.7965393,398.3536 C26.8175393,398.221 26.7311393,398.0938 26.5985393,398.0644 L26.5985393,398.0644 Z"
				id="Defender-Icon" stroke="none" fill="#FFFFFF" fill-rule="evenodd"></path>
		</svg>
		<?php
		$svg = ob_get_clean();

		return 'data:image/svg+xml;base64,' . base64_encode( $svg );
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
		$page = WD_Utils::http_get( 'page' );
		if ( in_array( $page, array(
			'wdf-settings',
			'wp-defender'
		) )
		) {
			return true;
		}

		return false;
	}
}