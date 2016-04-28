<?php

/**
 * @author: Hoang Ngo
 */
class WD_Hardener_Controller extends WD_Controller {
	protected $module;

	/**
	 * This will contain all index about all hardener modules
	 * Format
	 * array(
	 *   array(
	 *      'class'=>'CLASS',
	 *      'path'=>'PATH'
	 *   )
	 * )
	 *
	 *
	 * @var array
	 * @since 1.0
	 */
	private $_modules = array();

	/**
	 * @param $module
	 */
	public function __construct( $module ) {
		$this->module = $module;
		//define the view template
		$this->template = 'layouts/hardener';
		if ( is_multisite() ) {
			$this->add_action( 'network_admin_menu', 'admin_menu', 11 );
		} else {
			$this->add_action( 'admin_menu', 'admin_menu', 11 );
		}
		/**
		 * loads all hardener modules without init
		 */
		$this->add_action( 'admin_enqueue_scripts', 'load_scripts' );
		$this->add_action( 'wp_loaded', 'load_modules', 9 );
		if ( WD_Utils::get_setting( 'disable_ping_back->remove_pingback', 0 ) == 1 ) {
			$this->add_filter( 'wp_headers', 'remove_pingback' );
		}
	}

	/**
	 * @return bool
	 */
	private function is_in_page() {
		$screen = get_current_screen();
		if ( is_object( $screen ) && in_array( $screen->id, array(
				'defender_page_wdf-hardener',
				'defender_page_wdf-hardener-network'
			) )
		) {
			return true;
		}

		return false;
	}

	/**
	 * Load hardener scripts
	 */
	public function load_scripts() {
		if ( $this->is_in_page() ) {
			WDEV_Plugin_Ui::load( wp_defender()->get_plugin_url() . 'shared-ui/', false );
			wp_enqueue_style( 'wp-defender' );
			wp_enqueue_script( 'wd-rotate' );
		}
	}

	/**
	 * Remove header pingback
	 *
	 * @param $headers
	 *
	 * @return mixed
	 */
	public function remove_pingback( $headers ) {
		unset( $headers['X-Pingback'] );

		return $headers;
	}

	/**
	 *
	 */
	public function load_modules() {
		$files = WD_Utils::get_dir_tree( $this->module->get_module_path() . 'component/', true, false, array(), array(
			'ext' => array( 'php' )
		), false );
		foreach ( $files as $file ) {
			$info = get_file_data( $file, array(
				'Class' => 'Class',
			), 'hardener' );
			if ( ! empty( $info['Class'] ) ) {
				$class = $info['Class'];
				if ( ! class_exists( $class ) ) {
					include_once $file;
				}
				$mod                        = new $class;
				$this->_modules[ $mod->id ] = $mod;
			}
		}
		//sort modules
		usort( $this->_modules, array( &$this, 'sort_modules' ) );
	}

	public function sort_modules( $a, $b ) {
		return strcmp( $a->title, $b->title );
	}

	/**
	 *
	 */
	public function update_results() {
		$results = array(
			'fixed' => array(),
			'issue' => array()
		);

		if ( empty( $this->_modules ) ) {
			$this->load_modules();
		}

		foreach ( $this->_modules as $module ) {
			if ( $module->check() ) {
				$results['fixed'][] = get_class( $module );
			} else {
				$results['issue'][] = get_class( $module );
			}
		}

		WD_Utils::update_setting( 'hardener->results', $results );
	}

	/**
	 * add hardener menu under main menu
	 */
	public function admin_menu() {
		$cap = is_multisite() ? 'manage_network_options' : 'manage_options';
		add_submenu_page( 'wp-defender', __( "Hardener", wp_defender()->domain ), __( "Hardener", wp_defender()->domain ), $cap, 'wdf-hardener', array(
			$this,
			'display_main'
		) );
	}

	/**
	 * This will load the main template of hardener and show up
	 */
	public function display_main() {
		$this->_modules = apply_filters( 'wd_hardener_modules', $this->_modules );

		$resolved = array();
		$issues   = array();
		$ignored  = array();

		foreach ( $this->_modules as $obj ) {
			if ( $obj->is_ignored() ) {
				$ignored[] = $obj;
			} elseif ( $obj->check() === true ) {
				$resolved[] = $obj;
			} else {
				$issues[] = $obj;
			}
		}

		usort( $resolved, array( &$this, 'sort_resolved' ) );
		$this->render( 'main', array(
			'resolved' => $resolved,
			'issues'   => $issues,
			'ignored'  => $ignored
		), true );
	}

	public function sort_resolved( $a, $b ) {
		return $a->last_processed < $b->last_processed;
	}

	/**
	 * @return array
	 */
	public function get_loaded_modules() {
		return $this->_modules;
	}

	public function run_all() {
		$data = array();
		foreach ( $this->_modules as $module ) {
			if ( ! class_exists( $module['class'] ) ) {
				include_once $module['path'];
			}
			$obj = new $module['class']();
			$obj->display();
		}
	}
}