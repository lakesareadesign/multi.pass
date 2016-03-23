<?php

/**
 * Class WP_Hummingbird_Core
 */
class WP_Hummingbird_Core {

	/**
	 * Saves the modules object instances
	 *
	 * @var array
	 */
	public $modules = array();

	public function __construct() {
		$this->includes();

		// Init the API
		/** @noinspection PhpIncludeInspection */
		include_once( wphb_plugin_dir() . 'core/api/class-wp-hummingbird-api.php' );
		$this->api = new WP_Hummingbird_API();

		$this->load_modules();
	}

	private function includes() {
		/** @noinspection PhpIncludeInspection */
		include_once( wphb_plugin_dir() . 'core/api/class-wp-hummingbird-api.php' );
		/** @noinspection PhpIncludeInspection */
		include_once( wphb_plugin_dir() . 'core/settings-hooks.php' );
		/** @noinspection PhpIncludeInspection */
		include_once( wphb_plugin_dir() . 'core/modules-hooks.php' );
	}

	/**
	 * Load WP Hummingbird modules
	 */
	private function load_modules() {
		/**
		 * Filters the modules slugs list
		 */
		$modules = apply_filters( 'wp_hummingbird_modules', array(
			'minify' =>     __( 'Minify', 'wphb' ),
			'gzip' =>       'Gzip',
			'caching' =>    __( 'Caching', 'wphb' ),
			'performance' => __( 'Performance', 'wphb' ),
			'uptime' => __( 'Uptime', 'wphb' ),
			'smush' => __( 'Smush', 'wphb' )
		) );

		/** @noinspection PhpIncludeInspection */
		include_once wphb_plugin_dir() . 'core/class-abstract-module.php';
		include_once wphb_plugin_dir() . 'core/class-abstract-module-server.php';

		array_walk( $modules, array( $this, 'load_module' ) );
	}

	/**
	 * Load a single module
	 *
	 * @param string $name Module Name
	 * @param string $module Module slug
	 */
	public function load_module( $name, $module ) {
		$class_name = 'WP_Hummingbird_Module_' . ucfirst( $module );

		// Default modules files
		$filename = wphb_plugin_dir() . 'core/modules/class-module-' . $module . '.php';
		if ( file_exists( $filename ) ) {
			include_once $filename;
		}

		if ( class_exists( $class_name ) ) {
			$module_obj = new $class_name( $module, $name );

			/** @var WP_Hummingbird_Module $module_obj */
			if ( $module_obj->is_active() ) {
				$this->modules[ $module ] = $module_obj;
				$module_obj->run();
			}

			$this->modules[ $module ] = $module_obj;
		}
	}



}