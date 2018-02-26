<?php

if ( ! class_exists( 'Smartcrawl_Model_IO' ) ) { require_once( dirname( __FILE__ ) . '/class_wds_model_io.php' ); }

class Smartcrawl_Reset extends Smartcrawl_Model_IO {

	public static function reset() {
		$me = new self;
		return $me->_reset();
	}

	private function _reset() {
		foreach ( $this->get_sections() as $section ) {
			if ( ! is_callable( array( $this, "reset_{$section}" ) ) ) { continue; }
			call_user_func( array( $this, "reset_{$section}" ) );
		}
	}

	public function reset_options() {
		delete_site_option( 'wds_blog_tabs' );
		delete_site_option( 'wds_sitewide_mode' );

		delete_option( 'wds_engine_notification' );
		delete_option( 'wds_sitemap_dashboard' );

		delete_site_option( 'wds-onboarding-done' );

		return Smartcrawl_Settings::reset_options();
	}

	public function reset_ignores() {
		if ( ! class_exists( 'Smartcrawl_Model_Ignores' ) ) { require_once SMARTCRAWL_PLUGIN_DIR . '/core/class_wds_model_ignores.php'; }
		delete_site_option( Smartcrawl_Model_Ignores::IGNORES_STORAGE );
		delete_option( Smartcrawl_Model_Ignores::IGNORES_STORAGE );
	}

	public function reset_extra_urls() {
		if ( ! class_exists( 'Smartcrawl_Xml_Sitemap' ) ) { require_once SMARTCRAWL_PLUGIN_DIR . '/tools/sitemaps.php'; }
		delete_site_option( Smartcrawl_Xml_Sitemap::EXTRAS_STORAGE );
		delete_option( Smartcrawl_Xml_Sitemap::EXTRAS_STORAGE );
	}

	public function reset_postmeta() {
		global $wpdb;
		$wpdb->query( "DELETE FROM {$wpdb->postmeta} WHERE meta_key LIKE '_wds%'" );
	}

	public function reset_taxmeta() {
		delete_site_option( 'wds_taxonomy_meta' );
		delete_option( 'wds_taxonomy_meta' );
	}

	public function reset_redirects() {
		if ( ! class_exists( 'Smartcrawl_Model_Redirection' ) ) {
			require_once SMARTCRAWL_PLUGIN_DIR . '/core/class_wds_model_redirection.php';
		}
		delete_site_option( Smartcrawl_Model_Redirection::OPTIONS_KEY );
		delete_option( Smartcrawl_Model_Redirection::OPTIONS_KEY );

		delete_site_option( Smartcrawl_Model_Redirection::OPTIONS_KEY_TYPES );
		delete_option( Smartcrawl_Model_Redirection::OPTIONS_KEY_TYPES );
	}

}