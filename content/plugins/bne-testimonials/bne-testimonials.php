<?php
/*
 * Plugin Name: BNE Testimonials
 * Version: 2.0
 * Description: Display testimonials on any page or widget area as list or slider. Upgrade to PRO for additional layouts, themes, API, 5-star ratings and schema markup.
 * Author: Kerry Kline
 * Author URI: https://www.bnecreative.com
 * Requires at least: 4.7
 * Text Domain: bne-testimonials
 * License: GPL2

    Copyright (C) 2013-2017 BNE Creative

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License version 2,
    as published by the Free Software Foundation.

    You may NOT assume that you can use any other version of the GPL.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    The license for this software can likely be found here:
    http://www.gnu.org/licenses/gpl-2.0.html

*/


// Exit if accessed directly
if ( !defined('ABSPATH')) exit;


// INIT Class
class BNE_Testimonials {

	
    /*
     * 	Constructor
     *
     *	@since 		v2.0
     *
    */
	function __construct() {
		
		// Set Constants
		define( 'BNE_TESTIMONIALS_VERSION', '2.0' );
		define( 'BNE_TESTIMONIALS_DIR', dirname( __FILE__ ) );
		define( 'BNE_TESTIMONIALS_URI', plugins_url( '', __FILE__ ) );
		define( 'BNE_TESTIMONIALS_BASENAME', plugin_basename( __FILE__ ) );
		define( 'BNE_TESTIMONIALS_TEXTDOMAIN', 'bne-testimonials' );
		
		// Textdomain
		add_action( 'plugins_loaded', array( $this, 'text_domain' ) );
		
		// Setup Includes / Files
		add_action( 'after_setup_theme', array( $this, 'setup' ) );
		
		// Scripts 
		add_action( 'wp_enqueue_scripts', array( $this, 'frontend_scripts' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ), 11, 1 );

	}




	/*
	 * 	Textdomain for Localization
	 *
	 * 	@since 		v2.0
	 *
	*/
	function text_domain() {
		load_plugin_textdomain( BNE_TESTIMONIALS_TEXTDOMAIN, false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
	}




	/*
	 *	Plugin Setup
	 *	
	 * 	@since 		v2.0
	 *
	*/
	function setup() {

		// Admin Only Pages
		if( is_admin() ) {
			
			// Libraries
			include_once( BNE_TESTIMONIALS_DIR . '/includes/lib/cmb2/init.php' );
			
			// Admin Help Page
			include_once( BNE_TESTIMONIALS_DIR . '/includes/help/help.php' );
		}

		// Locals
		include_once( BNE_TESTIMONIALS_DIR . '/includes/locals.php' );

		// CPT
		include_once( BNE_TESTIMONIALS_DIR . '/includes/lib/bne_cpt-class.php' );
		include_once( BNE_TESTIMONIALS_DIR . '/includes/cpt-main.php' );

		// Shortcodes
		include_once( BNE_TESTIMONIALS_DIR . '/includes/shortcode-display.php' );
		

		/*
		 *	Thumbnail Support
		 *
		 *	Because some themes will selectively choose what post types
		 *	can use post-thumbnails, we will first remove support to
		 *	basically reset the option, then we will add it back.
		 *
		 *	This may seem link backwards thinking, but works.
		 *	
		*/
		remove_theme_support( 'post-thumbnails' );
		if( !current_theme_supports( 'post-thumbnails' ) ) {
			add_theme_support( 'post-thumbnails' );
		}

		
		/*
		 *	v1.x legacy Shortcodes and Widgets
		 *
		 *	Prior to v2.0, Testimonials used a customizable filter set
		 *	to output the data. This allowed devs to re-arrange and customize
		 *	how the testimonials are displayed. With v2.0+ we have removed all
		 *	of this in favor of matching to the pro version (which uses themes/layouts).
		 *
		 *	To prevent confusion and disruption of customizations, we have moved these functions here
		 *	and can only be called using the legacy shortcode variants and widgets.
		 *
		 *	Shortcodes using this structure:
		 *	[bne_testimonials_list]
		 *	[bne_testimonials_slider]
		 *
		*/
		include_once( BNE_TESTIMONIALS_DIR . '/includes/legacy/testimonial-output.php' );
		include_once( BNE_TESTIMONIALS_DIR . '/includes/legacy/shortcode-list.php' );
		include_once( BNE_TESTIMONIALS_DIR . '/includes/legacy/shortcode-slider.php' );	
		include_once( BNE_TESTIMONIALS_DIR . '/includes/legacy/widget-list.php' );
		include_once( BNE_TESTIMONIALS_DIR . '/includes/legacy/widget-slider.php' );

	}


	/*
	 *	Register frontend CSS and JS
	 *
	 *	@since 		v1.0
	 *	@updated 	v2.0
	 *
	*/
	function frontend_scripts() {
		
		$min = ( defined('WP_DEBUG') && true === WP_DEBUG ) ? '' : '.min';
		
		// CSS
		wp_register_style( 'bne-testimonials-css', BNE_TESTIMONIALS_URI . '/assets/css/bne-testimonials'.$min.'.css', '', BNE_TESTIMONIALS_VERSION, 'all' );
				
		// Check if we're on a BNE WordPress Theme...
		if( !defined('BNE_FRAMEWORK_VERSION') ) {
			// Flexslider
			wp_register_script( 'flexslider', BNE_TESTIMONIALS_URI . '/assets/js/flexslider.min.js', array('jquery'), '2.2.2', true );
		}
	
		// Load the plugin CSS
		wp_enqueue_style( 'bne-testimonials-css');
	
	}




	/*
	 *	
	 *	Register Admin CSS and JS
	 *
	 *	@since 		v2.0
	 *
	*/
	function admin_scripts( $hook ) {
		
		global $post;
		
		if( $hook == 'post-new.php' || $hook == 'post.php' ) {
			
			// Crosscheck with our Post Type list.
			if( 'bne_testimonials' == $post->post_type ) {     
				
				// Finally, check if we're not on a BNE theme as this is already available from there.
				if( !defined('BNE_FRAMEWORK_VERSION') ) {
					wp_enqueue_style( 'bne-cmb-admin-css', BNE_TESTIMONIALS_URI . '/assets/css/bne-cmb-admin.css', '', BNE_TESTIMONIALS_VERSION, 'all'  );
				}
			
			}
		}
	}


} // END Class

	
// Initiate the Class
$BNE_Testimonials = new BNE_Testimonials();