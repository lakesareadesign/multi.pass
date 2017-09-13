<?php
/*
Plugin Name: Coming Soon Page & Maintenance Mode
Description: Customize the Maintenance Mode page and create Coming Soon Page.
License: GNU General Public License (Version 2 - GPLv2)
Copyright 2017 Incsub (http://incsub.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License (Version 2 - GPLv2) as published by
the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

if ( ! class_exists( 'ub_maintenance' ) ) {

	class ub_maintenance extends ub_helper {
		protected $option_name = 'ub_maintenance';

		public function __construct() {
			parent::__construct();
			$this->set_options();
			add_action( 'ultimatebranding_settings_maintenance', array( $this, 'admin_options_page' ) );
			add_filter( 'ultimatebranding_settings_maintenance_process', array( $this, 'update' ), 10, 1 );

			add_action( 'template_redirect', array( $this, 'render' ),0 );
			add_filter( 'rest_authentication_errors', array( $this, 'only_allow_logged_in_rest_access' ) );
		}

		protected function set_options() {

			$description = array(
				__( 'A Coming Soon should be used when a domain is new and you are building out the site.', 'ub' ),
				__( 'Maintenance should only be used when your established site is truly down for maintenance.', 'ub' ),
				__( 'Maintenance Mode returns a special header code (503) to notify search engines that your site is currently down so it does not negatively affect your site’s reputation.', 'ub' ),
			);

			$this->options = array(
				'mode' => array(
					'title' => __( 'Working mode', 'ub' ),
					'fields' => array(
						'mode' => array(
							'type' => 'radio',
							'label' => __( 'Mode', 'ub' ),
							'options' => array(
								'off' => __( 'Off', 'ub' ),
								'coming-soon' => __( 'Coming Soon', 'ub' ),
								'maintenance' => __( 'Maintenance', 'ub' ),
							),
							'default' => 'off',
							'description' => implode( ' ', $description ),
						),
					),
				),
				'logo' => array(
					'title' => __( 'Logo', 'ub' ),
					'fields' => array(
						'show' => array(
							'type' => 'checkbox',
							'label' => __( 'Logo', 'ub' ),
							'description' => __( 'Would you like to show the logo?', 'ub' ),
							'options' => array(
								'on' => __( 'Show', 'ub' ),
								'off' => __( 'Hide', 'ub' ),
							),
							'default' => 'on',
							'classes' => array( 'switch-button' ),
							'slave-class' => 'logo-related',
						),
						'image' => array(
							'type' => 'media',
							'label' => __( 'Logo image', 'ub' ),
							'description' => __( 'Upload your own logo.', 'ub' ),
							'master' => 'logo-related',
						),
						'width' => array(
							'type' => 'number',
							'label' => __( 'Logo width', 'ub' ),
							'default' => 84,
							'min' => 0,
							'classes' => array( 'ui-slider' ),
							'master' => 'logo-related',
						),
						'position' => array(
							'type' => 'radio',
							'label' => __( 'Logo Position', 'ub' ),
							'options' => array(
								'left' => __( 'Left', 'ub' ),
								'center' => __( 'Center', 'ub' ),
								'right' => __( 'Right', 'ub' ),
							),
							'default' => 'center',
							'master' => 'logo-related',
						),
					),
				),
				'background' => array(
					'title' => __( 'Background', 'ub' ),
					'fields' => array(
						'color' => array(
							'type' => 'color',
							'label' => __( 'Background color', 'ub' ),
							'default' => '#210101',
						),
						'image' => array(
							'type' => 'media',
							'label' => __( 'Background Image', 'ub' ),
							'description' => __( 'You can upload a background image here. The image will stretch to fit the page, and will automatically resize as the window size changes. You\'ll have the best results by using images with a minimum width of 1024px.', 'ub' ),
						),
					),
				),
				'document' => array(
					'title' => __( 'Document', 'ub' ),
					'fields' => array(
						'title' => array(
							'type' => 'text',
							'label' => __( 'Title', 'ub' ),
							'description' => __( 'Enter a headline for your page.', 'ub' ),
						),
						'content' => array(
							'type' => 'wp_editor',
							'label' => __( 'content', 'ub' ),
						),
						'background' => array(
							'type' => 'color',
							'label' => __( 'Background color', 'ub' ),
							'default' => '#f1f1f1',
						),
						'width' => array(
							'type' => 'number',
							'label' => __( 'Content width', 'ub' ),
							'default' => 600,
							'min' => 0,
							'classes' => array( 'ui-slider' ),
						),
					),
				),
			);
		}
		/**
		 * Display the default template
		 */
		function get_default_template() {
			$file = file_get_contents( dirname( __FILE__ ).'/template.html' );
			return $file;
		}
		/**
		 * Display the coming soon page
		 */
		public function render() {
			/**
			 * do not render for logged users
			 */
			$logged = is_user_logged_in();
			if ( $logged ) {
				return;
			}
			/**
			 * check status
			 */
			$status = $this->get_value( 'mode', 'mode' );
			if ( 'off' == $status ) {
				return;
			}

			$title = $this->get_value( 'document', 'title' );
			$content = $this->get_value( 'document', 'content' );

			if ( empty( $title ) && empty( $content ) ) {
				$message = __( 'Please configure "Coming Soon Page" first!', 'ub' );
				if ( 'maintenance' == $status ) {
					$message = __( 'Please configure "Maintenance Page" first!', 'ub' );
				}
				$err = new WP_Error( 'error', $message );
				echo $err->get_error_message();
				exit();
			}

			// set headers
			if ( 'maintenance' == $status ) {
				header( 'HTTP/1.1 503 Service Temporarily Unavailable' );
				header( 'Status: 503 Service Temporarily Unavailable' );
				header( 'Retry-After: 86400' ); // retry in a day
				$maintenance_file = WP_CONTENT_DIR.'/maintenance.php';
				if ( ! empty( $enable_maintenance_php ) and file_exists( $maintenance_file ) ) {
					include_once( $maintenance_file );
					exit();
				}
			}

			// Prevetn Plugins from caching
			// Disable caching plugins. This should take care of:
			//   - W3 Total Cache
			//   - WP Super Cache
			//   - ZenCache (Previously QuickCache)
			if ( ! defined( 'DONOTCACHEPAGE' ) ) {
				define( 'DONOTCACHEPAGE', true );
			}
			if ( ! defined( 'DONOTCDN' ) ) {
				define( 'DONOTCDN', true );
			}
			if ( ! defined( 'DONOTCACHEDB' ) ) {
				define( 'DONOTCACHEDB', true );
			}
			if ( ! defined( 'DONOTMINIFY' ) ) {
				define( 'DONOTMINIFY', true );
			}
			if ( ! defined( 'DONOTCACHEOBJECT' ) ) {
				define( 'DONOTCACHEOBJECT', true );
			}
			header( 'Cache-Control: max-age=0; private' );

			$template = $this->get_default_template();

			$this->set_data();

			foreach ( $this->data as $section => $data ) {
				foreach ( $data as $name => $value ) {
					if ( empty( $value ) ) {
						$value = '';
					}
					if ( ! is_string( $value ) ) {
						continue;
					}
					$re = sprintf( '/{%s_%s}/', $section, $name );
					$template = preg_replace( $re, $value, $template );
				}
			}
			/**
			 * css
			 */
			$css = '';
			/**
			 * Background
			 */

			$v = $this->get_value( 'background', 'image_meta' );
			if ( isset( $v[0] ) ) {
				$css .= sprintf('
html {
    background: url(%s) no-repeat center center fixed;
    -webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    background-size: cover;
}
body {
    background-color: transparent;
}', esc_url( $v[0] ) );
			}
			/**
			 * Logo
			 */
			$logo = '';
			$show = $this->get_value( 'logo', 'show', false );
			if ( 'on' == $show ) {
				$image_meta = $this->get_value( 'logo', 'image_meta' );
				if ( is_array( $image_meta ) && 4 == count( $image_meta ) ) {
					$width = $this->get_value( 'logo', 'width' );
					$height = $image_meta[2] * $width / $image_meta[1];
					$css .= sprintf('
#logo {
    background: url(%s) no-repeat center center;
    -webkit-background-size: contain;
    -moz-background-size: contain;
    -o-background-size: contain;
    background-size: contain;
    width: %dpx;
    height: %dpx;
    display: block;
    margin: 5px auto;
}
', esc_url( $image_meta[0] ), $width, $height );
					$logo = '<div id="logo"></div>';
				}
			}
			$template = preg_replace( '/{logo}/', $logo, $template );
			/**
			 * replace css
			 */
			$template = preg_replace( '/{css}/', $css, $template );
			echo $template;
			exit();

		}

		function only_allow_logged_in_rest_access( $access ) {
			$current_WP_version = get_bloginfo( 'version' );
			if ( version_compare( $current_WP_version, '4.7', '>=' ) ) {

				if ( ! is_user_logged_in() ) {
					return new WP_Error( 'rest_cannot_access', __( 'Only authenticated users can access the REST API.', 'coming-soon' ), array( 'status' => rest_authorization_required_code() ) );
				}
			}
			return $access;

		}
	}
}
new ub_maintenance();
