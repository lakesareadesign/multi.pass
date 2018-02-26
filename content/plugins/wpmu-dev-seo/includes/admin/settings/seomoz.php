<?php

class Smartcrawl_Seomoz_Settings extends Smartcrawl_Settings_Admin {


	private static $_instance;

	public static function get_instance() {
		if ( empty( self::$_instance ) ) {
			self::$_instance = new self;
		}
		return self::$_instance;
	}

	public function validate( $input ) {
		return $inpt; }

	public function init() {
		require_once( SMARTCRAWL_PLUGIN_DIR . 'tools/seomoz/api.php' );

		$this->option_name     = 'wds_seomoz_options';
		$this->name            = Smartcrawl_Settings::COMP_SEOMOZ;
		$this->slug            = Smartcrawl_Settings::TAB_SEOMOZ;
		$this->action_url      = admin_url( 'options.php' );
		$this->title           = __( 'Moz', 'wds' );
		$this->page_title      = __( 'SmartCrawl Wizard: Moz', 'wds' );

		parent::init();
	}

	/**
	 * Add admin settings page
	 */
	public function options_page() {
		parent::options_page();
		$this->_render_page( 'seomoz-settings' );
	}

	/**
	 * Default settings
	 */
	public function defaults() {
		if ( is_multisite() && SMARTCRAWL_SITEWIDE ) {
			$this->options = get_site_option( $this->option_name );
		} else {
			$this->options = get_option( $this->option_name );
		}

		if ( empty( $this->options['access-id'] ) ) {
			$this->options['access-id'] = '';
		}

		if ( empty( $this->options['secret-key'] ) ) {
			$this->options['secret-key'] = '';
		}

		if ( is_multisite() && SMARTCRAWL_SITEWIDE ) {
			update_site_option( $this->option_name, $this->options );
		} else {
			update_option( $this->option_name, $this->options );
		}
	}

}
