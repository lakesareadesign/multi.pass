<?php

/**
 * Class WP_Hummingbird_Admin
 *
 * Manage the admin core functionality
 */
class WP_Hummingbird_Admin {

	public $pages = array();

	public function __construct() {
		$this->includes();

		add_action( 'admin_menu', array( $this, 'add_menu_pages' ) );
		add_action( 'network_admin_menu', array( $this, 'add_network_menu_pages' ) );

		if ( defined( 'DOING_AJAX' ) && DOING_AJAX )
			new WP_Hummingbird_Admin_AJAX();

		add_action( 'admin_footer', array( $this, 'maybe_check_files' ) );
		add_action( 'admin_footer', array( $this, 'maybe_check_report' ) );

		add_filter( 'network_admin_plugin_action_links_wp-hummingbird/wp-hummingbird.php', array( $this, 'add_plugin_action_links' ) );
		add_filter( 'plugin_action_links_wp-hummingbird/wp-hummingbird.php', array( $this, 'add_plugin_action_links' ) );

		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_icon_styles' ) );

		/**
		 * Triggered when Hummingbird Admin is loaded
		 */
		do_action( 'wphb_admin_loaded' );
	}

	public function enqueue_icon_styles() {
		wp_enqueue_style( 'wphb-fonts', wphb_plugin_url() . 'admin/assets/css/wphb-font.css', array() );
	}

	public function add_plugin_action_links( $actions ) {
		if ( current_user_can( wphb_get_admin_capability() ) ) {
			if ( is_multisite() && ! is_network_admin() ) {
				$url = network_admin_url( 'admin.php?page=wphb' );
			}
			else {
				$url = wphb_get_admin_menu_url( '' );
			}
			$actions['dashboard'] = '<a href="' . $url . '" aria-label="' . esc_attr( __( 'Go to WP Hummingbird Dashboard', 'wphb' ) ) . '">' . esc_html__( 'Settings', 'wphb' ) . '</a>';
		}

		return $actions;
	}

	private function includes() {
		include_once( 'abstract-class-admin-page.php' );
		include_once( 'class-dashboard-page.php' );
		include_once( 'class-performance-page.php' );
		include_once( 'class-minification-page.php' );
		include_once( 'class-caching-page.php' );
		include_once( 'class-gzip-page.php' );
		include_once( 'class-uptime-page.php' );

		if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
			include_once( 'class-admin-ajax.php' );
		}
	}


	/**
	 * Add all the menu pages in admin for the plugin
	 */
	public function add_menu_pages() {
		$module = wphb_get_module( 'minify' );

		if ( ! is_multisite() ) {
			$this->pages['wphb'] = new WP_Hummingbird_Dashboard_Page( 'wphb', __( 'Hummingbird', 'wphb' ), __( 'Hummingbird', 'wphb' ), false, false );
			$this->pages['wphb-dashboard'] = new WP_Hummingbird_Dashboard_Page( 'wphb', __( 'Dashboard', 'wphb' ), __( 'Dashboard', 'wphb' ), 'wphb' );
			$this->pages['wphb-performance'] = new WP_Hummingbird_Performance_Report_Page( 'wphb-performance', __( 'Performance Report', 'wphb' ), __( 'Performance Report', 'wphb' ), 'wphb' );

			if ( $module->can_execute_php() ) {
				$this->pages['wphb-minification'] = new WP_Hummingbird_Minification_Page( 'wphb-minification', __( 'Minification', 'wphb' ), __( 'Minification', 'wphb' ), 'wphb' );
			}
			$this->pages['wphb-caching'] = new WP_Hummingbird_Caching_Page( 'wphb-caching', __( 'Browser Caching', 'wphb' ), __( 'Browser Caching', 'wphb' ), 'wphb' );
			$this->pages['wphb-gzip'] = new WP_Hummingbird_GZIP_Page( 'wphb-gzip', __( 'GZIP Compression', 'wphb' ), __( 'GZIP Compression', 'wphb' ), 'wphb' );
			$this->pages['wphb-uptime'] = new WP_Hummingbird_Uptime_Page( 'wphb-uptime', __( 'Uptime Monitoring', 'wphb' ), __( 'Uptime', 'wphb' ), 'wphb' );
			$this->add_cloudflare_submenu();
		}
		else {
			$minify = wphb_get_setting( 'minify' );

			if ( $module->can_execute_php() ) {
				if (
					( 'super-admins' === $minify && is_super_admin() )
					|| ( true === $minify )
				) {
					$this->pages['wphb-minification'] = new WP_Hummingbird_Minification_Page( 'wphb-minification', __( 'Minification', 'wphb' ), __( 'Hummingbird', 'wphb' ), false );
				}
				elseif ( isset( $_GET['page'] ) && 'wphb-minification' === $_GET['page'] ) {
					// Minification is off, and is a network, let's redirect to network admin
					$url = network_admin_url( 'admin.php?page=wphb#wphb-box-dashboard-minification-network-module' );
					$url = add_query_arg( 'minify-instructions', 'true', $url );
					wp_redirect( $url );
					exit;
				}
			}

		}

	}

	public function add_network_menu_pages() {
		$this->pages['wphb'] = new WP_Hummingbird_Dashboard_Page( 'wphb', __( 'Hummingbird', 'wphb' ), __( 'Hummingbird', 'wphb' ), false, false );
		$this->pages['wphb-dashboard'] = new WP_Hummingbird_Dashboard_Page( 'wphb', __( 'Dashboard', 'wphb' ), __( 'Dashboard', 'wphb' ), 'wphb' );
		$this->pages['wphb-performance'] = new WP_Hummingbird_Performance_Report_Page( 'wphb-performance', __( 'Performance Report', 'wphb' ), __( 'Performance Report', 'wphb' ), 'wphb' );
		$this->pages['wphb-caching'] = new WP_Hummingbird_Caching_Page( 'wphb-caching', __( 'Browser Caching', 'wphb' ), __( 'Browser Caching', 'wphb' ), 'wphb' );
		$this->pages['wphb-gzip'] = new WP_Hummingbird_GZIP_Page( 'wphb-gzip', __( 'GZIP Compression', 'wphb' ), __( 'GZIP Compression', 'wphb' ), 'wphb' );
		$this->pages['wphb-uptime'] = new WP_Hummingbird_Uptime_Page( 'wphb-uptime', __( 'Uptime', 'wphb' ), __( 'Uptime Monitoring', 'wphb' ), 'wphb' );
		$this->add_cloudflare_submenu();
	}

	private function add_cloudflare_submenu() {
		/** @var WP_Hummingbird_Module_Cloudflare $cloudflare */
		$cloudflare = wphb_get_module( 'cloudflare' );
		if ( $cloudflare->is_active() ) {
			add_submenu_page( 'wphb', 'CloudFlare', 'CloudFlare', wphb_get_admin_capability(), 'admin.php?page=wphb#wphb-box-dashboard-cloudflare' );
		}
	}


	/**
	 * Return an instannce of a WP Hummingbird Admin Page
	 *
	 * @param string $page_slug
	 *
	 * @return bool|WP_Hummingbird_Admin_Page
	 */
	public function get_admin_page( $page_slug ) {
		if ( isset( $this->pages[ $page_slug ] ) ) {
			return $this->pages[ $page_slug ];
		}

		return false;
	}

	public function maybe_check_files() {
		if ( ! is_user_logged_in() )
			return;

		$checking_files = wphb_minification_is_checking_files();

		// If we are checking files, continue with it
		if ( ! $checking_files )
			return;

		$enqueued = wp_script_is( 'wphb-admin', 'enqueued' );

		if ( ! $enqueued )
			wphb_enqueue_admin_scripts();

		// If we are in minification page, we should redirect when checking files is finished
		$screen = get_current_screen();
		$minification_screen_id = isset( $this->pages['wphb-minification']->page_id ) ? $this->pages['wphb-minification']->page_id : false;
		$dashboard_screen_id = ! empty( $this->pages['wphb']->page_id ) ? $this->pages['wphb']->page_id : '';

		$redirect = '';
		if ( $screen->id === $minification_screen_id ) {
			// The minification screen will do it for us
			return;
		}

		if ( $screen->id === $dashboard_screen_id ) {
			$redirect = wphb_get_admin_menu_url( '' );
		}

		?>
		<script>
			jQuery( document ).ready( function() {
				var module = WPHB_Admin.getModule( 'minification' );
				module.minificationStarted = true;
				module.checkFiles( '<?php echo $redirect; ?>' );
			});
		</script>
		<?php
	}

	public function maybe_check_report() {
		if ( ! is_user_logged_in() )
			return;

		$doing_report = wphb_performance_is_doing_report();

		// If we are checking files, continue with it
		if ( ! $doing_report )
			return;

		if ( wphb_performance_stopped_report() ) {
			return;
		}

		$enqueued = wp_script_is( 'wphb-admin', 'enqueued' );

		if ( ! $enqueued )
			wphb_enqueue_admin_scripts();

		// If we are in minification page, we should redirect when checking files is finished
		$screen = get_current_screen();
		$performance_screen_id = isset( $this->pages['wphb-performance'] ) && isset( $this->pages['wphb-performance']->page_id ) ? $this->pages['wphb-performance']->page_id : false;
		$dashboard_screen_id = isset( $this->pages['wphb'] ) && isset( $this->pages['wphb']->page_id ) ? $this->pages['wphb']->page_id : false;


		$redirect = '';
		if ( $screen->id === $performance_screen_id || $screen->id === $performance_screen_id . '-network' ) {
			$redirect = wphb_get_admin_menu_url( 'performance' );
		}

		if ( $screen->id === $dashboard_screen_id || $screen->id === $dashboard_screen_id . '-network' ) {
			$redirect = wphb_get_admin_menu_url( '' );
		}

		?>
		<script>
			jQuery( document ).ready( function() {
				var module = WPHB_Admin.getModule( 'performance' );
				module.performanceTest( '<?php echo $redirect; ?>' );
			});
		</script>
		<?php
	}

}


