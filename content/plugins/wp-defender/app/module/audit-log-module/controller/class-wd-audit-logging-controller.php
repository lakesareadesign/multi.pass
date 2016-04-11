<?php

/**
 * @author: Hoang Ngo
 */
class WD_Audit_Logging_Controller extends WD_Controller {
	const CACHE_THEME_TRANSIENT = 'wd_cache_theme_transient';

	public function __construct() {
		if ( is_multisite() ) {
			$this->add_action( 'network_admin_menu', 'admin_menu', 12 );
		} else {
			$this->add_action( 'admin_menu', 'admin_menu', 12 );
		}
		$this->add_action( 'admin_enqueue_scripts', 'load_scripts' );
		/*//cache for theme deleted
		$this->add_action( 'delete_site_transient_update_themes', 'cache_theme_transient' );

		$hooks = WD_Audit_API::get_hooks();
		foreach ( $hooks as $key => $hook ) {
			if ( version_compare( PHP_VERSION, '5.3', '>=' ) ) {
				$func = function () use ( $key ) {
					$args      = func_get_args();
					$hook_name = $key;
					WD_Audit_API::build_and_submit( $hook_name, $args );
				};
			} else {
				//$func_args = implode( ',', $hook['args'] );
				//$func      = create_function( $func_args, "var_dump('" . $hook['hook'] . "');var_dump(func_get_args());die;" );
			}

			add_action( $key, $func, 11, count( $hook['args'] ) );
		}*/
	}

	/**
	 * before delete a theme, we placed a cache, and after theme
	 */
	public function cache_theme_transient() {
		set_site_transient( self::CACHE_THEME_TRANSIENT, get_transient( 'update_themes' ) );
	}

	public function admin_menu() {
		$cap = is_multisite() ? 'manage_network_options' : 'manage_options';
		add_submenu_page( 'wp-defender', __( "Audit Logging", wp_defender()->domain ), __( "Audit Log", wp_defender()->domain ), $cap, 'wdf-logging', array(
			$this,
			'display_main'
		) );
	}

	public function display_main() {
		$this->render( 'soon', array(), true );
	}

	/**
	 * Check if in right page, then load assets
	 */
	public function load_scripts() {
		if ( $this->is_in_page() ) {
			WDEV_Plugin_Ui::load( wp_defender()->get_plugin_url() . 'shared-ui/', false );
			wp_enqueue_style( 'wp-defender' );
			wp_enqueue_script( 'wp-defender' );
		}
	}

	/**
	 * check if this page is page of the plugin
	 * @return bool
	 */
	private function is_in_page() {
		$screen = get_current_screen();
		if ( is_object( $screen ) && in_array( $screen->id, array(
				'defender_page_wdf-logging',
				'defender_page_wdf-logging-network'
			) )
		) {
			return true;
		}

		return false;
	}
}