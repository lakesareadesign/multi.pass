<?php
/*
Copyright 2017-2018 Incsub (email: admin@incsub.com)
 */

if ( ! class_exists( 'ub_helper' ) ) {

	class ub_helper{
		protected $options = array();
		protected $data = null;
		protected $option_name = 'unknown';
		protected $url;
		protected $build;
		protected $tab;
		protected $tab_name;
		protected $deprecated_version = false;
		protected $file = __FILE__;
		protected $uba;

		/**
		 * Module name
		 *
		 * @since 1.9.4
		 */
		protected $module = 'ub_helper';

		public function __construct() {
			if ( empty( $this->build ) ) {
				global $ub_version;
				$this->build = $ub_version;
			}
			/**
			 * Check is deprecated?
			 */
			if (
				! empty( $this->deprecated_version )
				&& false === $this->deprecated_version
				/**
				 * avoid to compare with development version
				 */
				&& ! preg_match( '/^PLUGIN_VER/', $this->build )
			) {
				$compare = version_compare( $this->deprecated_version, $this->build );
				if ( 1 > $compare ) {
					return;
				}
			}
			/**
			 * admin
			 */
			if ( is_admin() ) {
				global $uba;
				$params = array(
					'page' => 'branding',
				);
				if ( is_a( $uba, 'UltimateBrandingAdmin' ) ) {
					$this->tab = $params['tab'] = $uba->get_current_tab();
					$this->uba = $uba;
				}
				$this->url = add_query_arg(
					$params,
					is_network_admin() ? network_admin_url( 'admin.php' ) : admin_url( 'admin.php' )
				);
			}
			add_filter( 'ultimate_branding_options_names', array( $this, 'add_option_name' ) );
			add_filter( 'ultimate_branding_get_option_name', array( $this, 'get_module_option_name' ), 10, 2 );
		}

		public function add_option_name( $options ) {
			if ( ! in_array( $this->option_name, $options ) ) {
				$options[] = $this->option_name;
			}
			return $options;
		}

		/**
		 * @since 1.9.1 added parameter $default
		 *
		 * @param mixed $default default value return if we do not have any.
		 */
		protected function get_value( $section = null, $name = null, $default = null ) {
			$this->set_data();
			$value = $this->data;
			if ( null == $section ) {
				return $value;
			}
			if ( null == $name && isset( $value[ $section ] ) ) {
				return $value[ $section ];
			}
			/**
			 * If default is empty, then try to return default defined by
			 * configuration.
			 *
			 * @since 1.9.5
			 */
			if (
				empty( $default )
				&& isset( $this->options )
				&& isset( $this->options[ $section ] )
				&& isset( $this->options[ $section ]['fields'] )
				&& isset( $this->options[ $section ]['fields'][ $name ] )
				&& isset( $this->options[ $section ]['fields'][ $name ]['default'] )
			) {
				$default = $this->options[ $section ]['fields'][ $name ]['default'];
			}
			if ( isset( $value[ $section ] ) ) {
				if ( empty( $name ) ) {
					return $value[ $section ];
				} else if ( isset( $value[ $section ][ $name ] )
				) {
					if ( is_string( $value[ $section ][ $name ] ) ) {
						return stripslashes( $value[ $section ][ $name ] );
					}
					return $value[ $section ][ $name ];
				}
			}
			return $default;
		}

		/**
		 * set value
		 *
		 * @since 2.1.0
		 *
		 * @param string $key key
		 * @param string $subkey subkey
		 * @param mixed $value Value to store.
		 */
		protected function set_value( $key, $subkey, $value = null ) {
			$data = $this->get_value();
			if ( null === $value ) {
				if ( isset( $data[ $key ] ) && isset( $data[ $key ][ $subkey ] ) ) {
					unset( $data[ $key ][ $subkey ] );
				}
			} else {
				if ( ! isset( $data[ $key ] ) ) {
					$data[ $key ] = array();
				}
				$data[ $key ][ $subkey ] = $value;
			}
			$this->update_value( $value );
		}

		public function admin_options_page() {
			$this->set_options();
			$this->set_data();
			$simple_options = new simple_options();
			do_action( 'ub_helper_admin_options_page_before_options', $this->option_name );
			echo $simple_options->build_options( $this->options, $this->data );
		}

		protected function set_data() {
			if ( null === $this->data ) {
				$value = ub_get_option( $this->option_name );
				if ( 'empty' !== $value ) {
					$this->data = $value;
				}
			}
		}

		/**
		 * Update settings
		 *
		 * @since 1.8.6
		 */
		public function update( $status ) {
			$value = $_POST['simple_options'];
			if ( $value == '' ) {
				$value = 'empty';
			}
			/**
			 * check empty options
			 */
			if ( empty( $this->options ) ) {
				$msg = sprintf( 'Ultimate Branding Admin: empty options array for %s variable. Please contact with plugin developers.', $this->option_name );
				error_log( $msg, 0 );
				return;
			}
			foreach ( $this->options as $section_key => $section_data ) {
				if ( ! isset( $section_data['fields'] ) ) {
					continue;
				}
				if ( isset( $section_data['sortable'] ) && isset( $value[ $section_key ] ) ) {
					$value[ '_'.$section_key.'_sortable' ] = array_keys( $value[ $section_key ] );
				}
				foreach ( $section_data['fields'] as $key => $data ) {
					if ( ! isset( $data['type'] ) ) {
						$data['type'] = 'text';
					}
					switch ( $data['type'] ) {
						case 'media':
							if ( isset( $value[ $section_key ][ $key ] ) && is_array( $value[ $section_key ][ $key ] ) ) {
								$value[ $section_key ][ $key ] = array_shift( $value[ $section_key ][ $key ] );
								$image = wp_get_attachment_image_src( $value[ $section_key ][ $key ], 'full' );
								if ( false !== $image ) {
									$value[ $section_key ][ $key.'_meta' ] = $image;
								}
							}
						break;
						case 'gallery':
							if ( isset( $value[ $section_key ][ $key ] ) && is_array( $value[ $section_key ][ $key ] ) ) {
								$gallery = array();
								foreach ( $value[ $section_key ][ $key ] as $id ) {
									if ( empty( $id ) ) {
										continue;
									}
									$one = array(
										'value' => $id,
										'meta' => array( $id ),
									);
									if ( preg_match( '/^\d+$/', $id ) ) {
										$image = wp_get_attachment_image_src( $id, 'full' );
										if ( false !== $image ) {
											$one['meta'] = $image;
										}
									}
									$gallery[] = $one;
								}
								$value[ $section_key ][ $key ] = $gallery;
							}
						break;
						case 'checkbox':
							if ( isset( $value[ $section_key ][ $key ] ) ) {
								$value[ $section_key ][ $key ] = 'on';
							} else {
								$value[ $section_key ][ $key ] = 'off';
							}
							break;
							/**
							 * save extra data if field is a wp_editor
							 */
						case 'wp_editor':
							$value[ $section_key ][ $key.'_meta' ] = wpautop( do_shortcode( stripslashes( $value[ $section_key ][ $key ] ) ) );
							break;
					}
				}
			}
			return $this->update_value( $value );
		}

		/**
		 * Update whole value
		 *
		 * @since 1.9.5
		 */
		protected function update_value( $value ) {
			ub_update_option( $this->option_name , $value );
			$this->data = $value;
			return true;
		}

		/**
		 * get base url
		 *
		 * @since 1.8.9
		 */
		protected function get_base_url() {
			$url = '';
			if ( ! is_admin() ) {
				return $url;
			}
			$screen = get_current_screen();
			if ( ! is_object( $screen ) ) {
				return $url;
			}
			$args = array(
				'page' => $screen->parent_base,
			);
			if ( isset( $_REQUEST['tab'] ) ) {
				$args['tab'] = $_REQUEST['tab'];
			}
			if ( is_network_admin() ) {
				$url = add_query_arg( $args, network_admin_url( 'admin.php' ) );
			} else {
				$url = add_query_arg( $args, admin_url( 'admin.php' ) );
			}
			return $url;
		}

		/**
		 * Admin notice wrapper
		 *
		 * @since 1.8.9
		 */
		protected function notice( $message, $class = 'info' ) {
			$allowed = array( 'error', 'warning', 'success', 'info' );
			if ( in_array( $class, $allowed ) ) {
				$class = 'notice-'.$class;
			} else {
				$class = '';
			}
			printf(
				'<div class="notice %s"><p>%s</p></div>',
				esc_attr( $class ),
				$message
			);
		}

		/**
		 * Handle filter for option name, it should be overwrite by module
		 * method.
		 *
		 * @since 1.9.2
		 */
		public function get_module_option_name( $option_name, $module ) {
			if ( $module === $this->module ) {
				return $this->option_name;
			}
			return $option_name;
		}

		/**
		 * Remove "Save Changes" button from page.
		 *
		 * @since 1.9.2
		 */
		public function disable_save() {
			add_filter( 'ultimatebranding_settings_panel_show_submit', '__return_false' );
		}

		/**
		 * get nonce action
		 *
		 * @since 1.9.4
		 *
		 * @param string $name nonce name
		 * @param integer $user_id User ID.
		 * @return nonce action name
		 */
		protected function get_nonce_action_name( $name = 'default', $user_id = 0 ) {
			if ( 0 === $user_id ) {
				$user_id = get_current_user_id();
			}
			$nonce_action = sprintf(
				'%s_%s_%d',
				__CLASS__,
				$name,
				$user_id
			);
			return $nonce_action;
		}

		/**
		 * Load SocialLogos style.
		 * https://wpcalypso.wordpress.com/devdocs/design/social-logos
		 *
		 * @since 1.9.7
		 */
		protected function load_social_logos_css() {
			$url = $this->get_social_logos_css_url();
			wp_enqueue_style( 'SocialLogos', $url, array(), '2.0.0', 'screen' );
		}

		/**
		 * Get SocialLogos style URL.
		 * https://wpcalypso.wordpress.com/devdocs/design/social-logos
		 *
		 * @since 1.9.7
		 */
		protected function get_social_logos_css_url() {
			$url = ub_url( 'external/icon-font/social-logos.css' );
			return $url;
		}

		/**
		 * SocialLogos social icons.
		 * https://wpcalypso.wordpress.com/devdocs/design/social-logos
		 *
		 * @since 1.9.7
		 */
		protected function get_social_media_array() {
			$social = array(
				'amazon'      => array( 'label' => __( 'Amazon', 'ub' ) ),
				'blogger'     => array( 'label' => __( 'Blogger', 'ub' ) ),
				'codepen'     => array( 'label' => __( 'CodePen', 'ub' ) ),
				'dribbble'    => array( 'label' => __( 'Dribbble', 'ub' ) ),
				'dropbox'     => array( 'label' => __( 'Dropbox', 'ub' ) ),
				'eventbrite'  => array( 'label' => __( 'Eventbrite', 'ub' ) ),
				'facebook'    => array( 'label' => __( 'Facebook', 'ub' ) ),
				'flickr'      => array( 'label' => __( 'Flickr', 'ub' ) ),
				'foursquare'  => array( 'label' => __( 'Foursquare', 'ub' ) ),
				'ghost'       => array( 'label' => __( 'Ghost', 'ub' ) ),
				'github'      => array( 'label' => __( 'Github', 'ub' ) ),
				'google'      => array( 'label' => __( 'G+', 'ub' ) ),
				'instagram'   => array( 'label' => __( 'Instagram', 'ub' ) ),
				'linkedin'    => array( 'label' => __( 'LinkedIn', 'ub' ) ),
				'mail'        => array( 'label' => __( 'Mail', 'ub' ) ),
				'pinterest'   => array( 'label' => __( 'Pinterest', 'ub' ) ),
				'pocket'      => array( 'label' => __( 'Pocket', 'ub' ) ),
				'polldaddy'   => array( 'label' => __( 'Polldaddy', 'ub' ) ),
				'reddit'      => array( 'label' => __( 'Reddit', 'ub' ) ),
				'skype'       => array( 'label' => __( 'Skype', 'ub' ) ),
				'spotify'     => array( 'label' => __( 'Spotify', 'ub' ) ),
				'squarespace' => array( 'label' => __( 'Squarespace', 'ub' ) ),
				'stumbleupon' => array( 'label' => __( 'Stumbleupon', 'ub' ) ),
				'telegram'    => array( 'label' => __( 'Telegram', 'ub' ) ),
				'tumblr'      => array( 'label' => __( 'Tumblr', 'ub' ) ),
				'twitter'     => array( 'label' => __( 'Twitter', 'ub' ) ),
				'vimeo'       => array( 'label' => __( 'Vimeo', 'ub' ) ),
				'whatsapp'    => array( 'label' => __( 'Whatsapp', 'ub' ) ),
				'wordpress'   => array( 'label' => __( 'WordPress', 'ub' ) ),
				'xanga'       => array( 'label' => __( 'Xanga', 'ub' ) ),
				'youtube'     => array( 'label' => __( 'Youtube', 'ub' ) ),
			);
			return $social;
		}

		/**
		 * Replace URL with protocol with related URL.
		 *
		 * @since 1.9.7
		 *
		 * @param string $url URL
		 * @return string $url
		 */
		protected function make_relative_url( $url ) {
			if ( empty( $url ) ) {
				return;
			}
			if ( ! is_string( $url ) ) {
				return;
			}
			$re = sprintf( '@^(%s|%s)@', set_url_scheme( home_url(), 'http' ),set_url_scheme( home_url(), 'https' ) );
			$to = set_url_scheme( home_url(), 'relative' );
			return preg_replace( $re, $to, $url );
		}

		/**
		 * CSS border style
		 *
		 * @since 1.9.7
		 */
		protected function css_border_options() {
			$options = array(
				'dotted' => __( 'Dotted', 'ub' ),
				'dashed' => __( 'Dashed', 'ub' ),
				'solid' => __( 'Solid', 'ub' ),
				'double' => __( 'Double', 'ub' ),
				'groove' => __( '3D grooved', 'ub' ),
				'ridge' => __( '3D ridged', 'ub' ),
				'inset' => __( '3D inset', 'ub' ),
				'outset' => __( '3D outset', 'ub' ),
			);
			return $options;
		}

		protected function css_background_color( $color ) {
			if ( empty( $color ) ) {
				$color = 'transparent';
			}
			return sprintf( 'background-color: %s;', $color );
		}

		protected function css_color( $color ) {
			if ( empty( $color ) ) {
				$color = 'inherit';
			}
			return sprintf( 'color: %s;', $color );
		}

		protected function css_width( $width, $units = 'px' ) {
			if ( empty( $width ) ) {
				return '';
			}
			return sprintf( 'width: %s%s;', $width, $units );
		}

		protected function css_height( $height, $units = 'px' ) {
			if ( empty( $height ) ) {
				return '';
			}
			return sprintf( 'height: %s%s;', $height, $units );
		}

		/**
		 * CSS Radius
		 *
		 * @since 2.2.0
		 */
		protected function css_radius( $radius, $units = 'px' ) {
			if ( empty( $radius ) ) {
				return '';
			}
			$keys = array( '-webkit-border-radius', '-moz-border-radius', 'border-radius' );
			$content = '';
			foreach ( $keys as $key ) {
				$content .= sprintf( '%s: %s%s;', $key, esc_attr( $radius ), esc_attr( $units ) );
			}
			return $content;
		}

		/**
		 * CSS color.
		 *
		 * @since 1.9.6
		 *
		 * @param array $data Configuration data.
		 * @param string $key Configuration key.
		 * @param string $selector CSS selector.
		 * @param boolean $echo Print or return data.
		 *
		 */
		protected function css_color_from_data( $data, $key, $selector, $echo = true ) {
			$css = '';
			if ( isset( $data[ $key ] ) && ! empty( $data[ $key ] ) ) {
				$css .= sprintf( '%s{color:%s}', $selector, $data[ $key ] );
				if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
					$css .= PHP_EOL;
				}
			}
			if ( $echo ) {
				echo $css;
				return;
			}
			return $css;
		}

		/**
		 * CSS background color.
		 *
		 * @since 1.9.6
		 *
		 * @param array $data Configuration data.
		 * @param string $key Configuration key.
		 * @param string $selector CSS selector.
		 * @param boolean $echo Print or return data.
		 *
		 */
		protected function css_background_color_from_data( $data, $key, $selector, $echo = true ) {
			return $this->css_background_transparency( $data, $key, 100, $selector, $echo );
		}

		/**
		 * CSS background color with transparency.
		 *
		 * @since 1.9.6
		 *
		 * @param array $data Configuration data.
		 * @param string $key Configuration key.
		 * @param number $transparency CSS transparency.
		 * @param string $selector CSS selector.
		 * @param boolean $echo Print or return data.
		 *
		 */
		protected function css_background_transparency( $data, $key, $transparency, $selector, $echo = true ) {
			$css = '';
			$change = false;
			$bg_color = 'none';
			$bg_transparency = 0;
			if ( isset( $data[ $key ] ) ) {
				$bg_color = $data[ $key ];
				$change = true;
			}
			if ( isset( $data[ $transparency ] ) ) {
				$bg_transparency = $data[ $transparency ];
				$change = true;
			}
			if ( $change ) {
				if ( 'none' != $bg_color ) {
					$css .= $selector;
					$css .= '{';
					if ( 0 < $bg_transparency && 100 !== $bg_transparency ) {
						$bg_color = $this->convert_hex_to_rbg( $bg_color );
						$css .= sprintf( 'background-color:rgba(%s,%0.2f)', implode( ',', $bg_color ), $bg_transparency / 100 );
					} else {
						$css .= sprintf( 'background-color:%s', $bg_color );
					}
					$css .= '}';
					if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
						$css .= PHP_EOL;
					}
				}
			}
			if ( $echo ) {
				echo $css;
				return;
			}
			return $css;
		}

		/**
		 * Convert color from RGB to HEX.
		 *
		 * @since 1.9.6
		 */
		protected function convert_hex_to_rbg( $hex ) {
			if ( preg_match( '/^#.{6}$/', $hex ) ) {
				return sscanf( $hex, '#%02x%02x%02x' );
			}
			return $hex;
		}

		/**
		 * Helper to enqueue scripts/styles
		 *
		 * @since 1.9.9
		 */
		protected function enqueue( $src, $version = false, $core = false ) {
			if ( $core ) {
				$src = get_site_url().'/wp-includes/js/'.$src;
			} else {
				$src = plugins_url( 'assets/'.$src, $this->file );
			}
			if ( preg_match( '/js$/', $src ) ) {
				return sprintf(
					'<script type="text/javascript" src="%s?version=%s"></script>%s',
					$this->make_relative_url( $src ),
					$version? $version:$this->build,
					PHP_EOL
				);
			}
			if ( preg_match( '/css$/', $src ) ) {
				return sprintf(
					'<link rel="stylesheet" href="%s?version=%s" type="text/css" media="all" />%s',
					$this->make_relative_url( $src ),
					$version? $version:$this->build,
					PHP_EOL
				);
			}
			return '';
		}

		/**
			* get the template
			*
			* @since 2.0.0
		 */
		protected function get_template( $file = 'index' ) {
			$file = sprintf(
				'%s/assets/templates/%s.html',
				dirname( $this->file ),
				sanitize_title( $file )
			);
			if ( is_file( $file ) && is_readable( $file ) ) {
				$file = file_get_contents( $file );
				return $file;
			}
			return __( 'Something went wrong!', 'ub' );
		}
	}
}
