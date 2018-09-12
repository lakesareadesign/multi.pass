<?php
if ( ! class_exists( 'ub_db_error_page' ) ) {

	class ub_db_error_page extends ub_helper {
		protected $option_name = 'ub_db_error_page';
		private $is_ready = false;
		private $is_ready_dir = false;
		private $is_ready_file = false;
		private $db_error_file;
		private $db_error_dir;
		protected $file = __FILE__;

		public function __construct() {
			parent::__construct();
			$this->check();
			$this->module = 'db_error_page';
			$this->set_options();
			/**
			 * hooks
			 */
			add_action( 'ultimatebranding_settings_db_error_page', array( $this, 'admin_options_page' ) );
			if ( $this->is_ready ) {
				add_filter( 'ultimatebranding_settings_db_error_page_process', array( $this, 'update' ), 10, 1 );
				add_filter( 'ultimatebranding_settings_db_error_page_process', array( $this, 'update_file' ), 999, 1 );
			}
		}

		/**
		 * Create or update `wp-content/db-error.php` is possible.
		 *
		 * @since 2.0.0
		 */
		public function update_file( $state ) {
			/**
			 * set data
			 */
			$template = $this->get_template();
			$body_classes = array( 'ultimate-branding-settings-db-error-page' );
			$javascript = $php = $css = $head = $logo = '';
			$this->set_data();
			/**
			 * Add defaults.
			 */
			if ( empty( $this->data['document']['title'] ) && empty( $this->data['document']['content'] ) ) {
				$this->data['document']['title'] = __( 'We&rsquo;ll be back soon!', 'ub' );
				$this->data['document']['content'] = wpautop( __( 'We\'re currently experiencing technical issues &mdash; Please check back soon...', 'ub' ) );
				$this->data['document']['content_meta'] = $this->data['document']['content'];
			}
			/**
			 * template
			 */
			$php = '<?php';
			$php .= PHP_EOL;
			$php .= 'header(\'HTTP/1.1 503 Service Temporarily Unavailable\');';
			$php .= PHP_EOL;
			$php .= 'header(\'Status: 503 Service Temporarily Unavailable\');';
			$php .= PHP_EOL;
			$php .= 'header(\'Retry-After: 3600\');';
			$php .= PHP_EOL;
			$send_email = $this->get_value( 'mail', 'send' );
			if ( 'on' === $send_email ) {
				$email = $this->get_value( 'mail', 'to' );
				if ( ! empty( $email ) ) {
					$mail_content = esc_html__( 'There is a problem with the database!', 'ub' );
					$mail_content .= PHP_EOL;
					$mail_content .= PHP_EOL;
					$mail_content .= sprintf( _x( 'Site URL: %s', 'DB Error module: mail', 'ub' ), home_url() );
					$mail_content .= PHP_EOL;
					$mail_content .= sprintf( _x( 'Site Name: %s', 'DB Error module: mail', 'ub' ), get_bloginfo( 'name' ) );
					$php .= sprintf(
						'mail("%s", "%s", "%s", "From: %s");',
						esc_attr( $email ),
						esc_html__( 'Database Error', 'ub' ),
						$mail_content,
						get_bloginfo( 'name' )
					);
					$php .= PHP_EOL;
				}
			}
			$php .= '?>';
			/**
			 * Logo
			 */
			$show = $this->get_value( 'logo', 'show', false );
			if ( 'on' == $show ) {
				/**
				 * Logo position
				 */
				$position = $this->get_value( 'logo', 'position', false );
				$margin = '0 auto';
				switch ( $position ) {
					case 'left':
						$margin = '0 auto 0 0';
					break;
					case 'right':
						$margin = '0 0 0 auto';
					break;
				}
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
    margin: %s;
}
', esc_url( $image_meta[0] ), $width, $height, $margin );
					$logo = '<div id="logo"></div>';
				}
			}
			/**
			 * social_media
			 */
			$social_media = '';
			$v = $this->get_value( 'social_media_settings' );
			if ( isset( $v['show'] ) && 'on' === $v['show'] ) {
				if ( isset( $v['colors'] ) && 'on' === $v['colors'] ) {
					$body_classes[] = 'use-color';
				}
				$target = ( isset( $v['social_media_link_in_new_tab'] ) && 'on' === $v['social_media_link_in_new_tab'] )? ' target="_blank"':'';
				$v = $this->get_value( 'social_media' );
				if ( ! empty( $v ) ) {
					foreach ( $v as $key => $url ) {
						if ( empty( $url ) ) {
							continue;
						}
						$social_media .= sprintf(
							'<li><a href="%s"%s><span class="social-logo social-logo-%s"></span>',
							esc_url( $url ),
							$target,
							esc_attr( $key )
						);
					}
					if ( ! empty( $social_media ) ) {
						$body_classes[] = 'has-social';
						$social_media = '<ul>'.$social_media.'</ul>';
						$head .= sprintf(
							'<link rel="stylesheet" id="social-logos-css" href="%s" type="text/css" media="all" />',
							$this->make_relative_url( $this->get_social_logos_css_url() )
						);
					}
				}
			}
			/**
			 * page
			 */
			$v = $this->get_value( 'document' );
			$css .= $this->css_background_transparency( $v, 'background', 'background_transparency', '.page', false );
			$css .= $this->css_color_from_data( $v, 'color', '.page', false );
			$css .= '.page{';
			if ( isset( $v['width'] ) && ! empty( $v['width'] ) ) {
				$css .= $this->css_width( $v['width'] );
			} else {
				$css .= $this->css_width( 100, '%' );
			}
			$css .= '}';
			/**
			 * Background Color
			 */
			$v = $this->get_value( 'background', 'color' );
			if ( ! empty( $v ) ) {
				$css .= sprintf( 'body{%s}', $this->css_background_color( $v ) );
			}
			$v = $this->get_value( 'background', 'image' );
			if ( 0 < count( $v ) && isset( $v[0]['meta'] ) ) {
				$mode = $this->get_value( 'background', 'mode' );
				$id = 0;
				do {
					$id = rand( 0, count( $v ) - 1 );
				} while ( ! isset( $v[ $id ]['meta'] ) );
				$meta = $v[ $id ]['meta'];
				$css .= sprintf('
html {
    background-image: url(%s);
}
body {
    background-color: transparent;
}', esc_url( $meta[0] ) );
				if ( 'slideshow' === $mode && 1 < count( $v ) ) {
					$images = array();
					foreach ( $v as $one ) {
						if ( isset( $one['meta'] ) ) {
							$images[] = $one['meta'][0];
						}
					}
					if ( count( $images ) ) {
						$duration = intval( $this->get_value( 'background', 'duration' ) );
						if ( 0 > $duration ) {
							$duration = 10;
						}
						$duration = MINUTE_IN_SECONDS * $duration * 1000;
						$javascript .= sprintf( 'var imgs = %s;', json_encode( $images ) );
						$javascript .= 'var opacity, ub_fade;
var ub_animate_background = setInterval( function( ) {
    var imgUrl = imgs[Math.floor(Math.random()*imgs.length)];
    var mask = document.getElementsByClassName(\'mask\')[0];
    var html = document.getElementsByTagName(\'html\')[0];
    if ( "" === html.style.backgroundImage ) {
        html.style.backgroundImage = \'url(\' + imgs[0] + \')\';
    }
    mask.style.backgroundImage = html.style.backgroundImage;
    html.style.backgroundImage = \'url(\' + imgUrl + \')\';
    mask.style.opacity = opacity = 1;
    ub_fade = setInterval( function() {
        if ( 0 > opacity ) {
            clearTimeout( ub_fade );
            opacity = 1;
            return;
        }
        opacity -= 0.01;
        mask.style.opacity = opacity;
    }, 20 );
}, '.$duration.' );
';
					}
				}
			}
			/**
			 * replace
			 */
			foreach ( $this->data as $section => $data ) {
				foreach ( $data as $name => $value ) {
					if ( empty( $value ) ) {
						$value = '';
					}
					if ( ! is_string( $value ) ) {
						$value = '';
					}
					if ( ! empty( $value ) ) {
						switch ( $section ) {
							case 'document':
								switch ( $name ) {
									case 'title':
										$show = $this->get_value( 'document', 'title_show' );
										if ( 'off' === $show ) {
											$value = '';
										} else {
											$value = sprintf( '<h1>%s</h1>', esc_html( $value ) );
										}
									break;
									case 'content_meta':
										$show = $this->get_value( 'document', 'content_show' );
										if ( 'off' === $show ) {
											$value = '';
										} else {
											$value = sprintf( '<div class="content">%s</div>', $value );
										}
									break;
								}
							break;
						}
					}
					$re = sprintf( '/{%s_%s}/', $section, $name );
					$template = preg_replace( $re, stripcslashes( $value ), $template );
				}
			}
			$template = preg_replace( '/{language}/', get_bloginfo( 'language' ), $template );
			if ( ! empty( $social_media ) ) {
				$social_media = sprintf( '<div id="social">%s</div>', $social_media );
			}
			$template = preg_replace( '/{social_media}/', $social_media, $template );
			$template = preg_replace( '/{title}/', get_bloginfo( 'name' ), $template );
			/**
			 * body classes
			 */
			$template = preg_replace( '/{body_class}/', implode( $body_classes, ' ' ), $template );
			/**
			 * head
			 */
			$head .= $this->enqueue( 'db-error-page.css' );
			$template = preg_replace( '/{head}/', $head, $template );
			/**
			 * replace css
			 */
			$template = preg_replace( '/{css}/', $css, $template );
			/**
			 * replace javascript
			 */
			$template = preg_replace( '/{javascript}/', $javascript, $template );
			/**
			 * logo
			 */
			$template = preg_replace( '/{logo}/', $logo, $template );
			/**
			 * replace php
			 */
			$template = preg_replace( '/{php}/', $php, $template );
			/**
			 * write
			 */
			$result = file_put_contents( $this->db_error_file, $template );
			if ( false === $result ) {
				return $result;
			}
			return $state;
		}

		/**
		 * Check that create od file is possible.
		 *
		 * @since 2.0.0
		 */
		private function check() {
			$this->db_error_dir = dirname( get_theme_root() );
			$this->db_error_file = $this->db_error_dir .'/db-error.php';
			if ( ! is_dir( $this->db_error_dir ) || ! is_writable( $this->db_error_dir ) ) {
				return;
			}
			$this->is_ready_dir = true;
			if ( is_file( $this->db_error_file ) && ! is_writable( $this->db_error_file ) ) {
				return;
			}
			$this->is_ready_file = true;
			$this->is_ready = true;
		}

		/**
		 * Set options
		 *
		 * @since 2.0.0
		 */
		protected function set_options() {
			$this->module = 'db-error-page';
			if ( ! $this->is_ready ) {
				$value = __( 'Whoops! Something went wrong.', 'ub' );
				if ( false == $this->is_ready_dir ) {
					$value = sprintf(
						__( 'Directory %s is not writable, we are unable to create db-error.php file.', 'ub' ),
						sprintf( '<code>%s</code>', $this->db_error_dir )
					);
				} else if ( false === $this->is_ready_file ) {
					$value = sprintf(
						__( 'File %s is not writable, we are unable to change it.', 'ub' ),
						sprintf( '<code>%s</code>', $this->db_error_file )
					);
				}
				$options = array(
					'settings' => array(
						'hide-reset' => true,
						'title' => __( 'DB Error Page', 'ub' ),
						'fields' => array(
							'message' => array(
								'type' => 'description',
								'label' => __( 'Error', 'ub' ),
								'value' => $value,
								'classes' => array( 'message', 'message-error' ),
							),
						),
					),
				);
				$this->options = $options;
				return;
			}
			/**
			 * options
			 */
			$options = array(
				/**
				 * document
				 */
				'document' => array(
					'title' => __( 'Document', 'ub' ),
					'fields' => array(
						'title_show' => array(
							'type' => 'checkbox',
							'label' => __( 'Show title', 'ub' ),
							'description' => __( 'Would you like to show title?', 'ub' ),
							'options' => array(
								'on' => __( 'On', 'ub' ),
								'off' => __( 'Off', 'ub' ),
							),
							'default' => 'off',
							'classes' => array( 'switch-button' ),
							'slave-class' => 'title',
						),
						'title' => array(
							'label' => __( 'Title', 'ub' ),
							'description' => __( 'Enter a headline for your page.', 'ub' ),
							'default' => __( '503 Service Temporarily Unavailable', 'ub' ),
							'master' => 'title',
						),
						'content_show' => array(
							'type' => 'checkbox',
							'label' => __( 'Show content', 'ub' ),
							'description' => __( 'Would you like to show content?', 'ub' ),
							'options' => array(
								'on' => __( 'On', 'ub' ),
								'off' => __( 'Off', 'ub' ),
							),
							'default' => 'off',
							'classes' => array( 'switch-button' ),
							'slave-class' => 'content',
						),
						'content' => array(
							'type' => 'wp_editor',
							'label' => __( 'Content', 'ub' ),
							'master' => 'content',
							'default' => wpautop( __( 'We\'re currently experiencing technical issues &mdash; Please check back soon...', 'ub' ) ),
						),
						'color' => array(
							'type' => 'color',
							'label' => __( 'Color', 'ub' ),
							'default' => '#000000',
						),
						'background' => array(
							'type' => 'color',
							'label' => __( 'Background color', 'ub' ),
							'default' => '#f1f1f1',
						),
						'background_transparency' => array(
							'type' => 'number',
							'label' => __( 'background transparency', 'ub' ),
							'min' => 0,
							'max' => 100,
							'default' => 0,
							'classes' => array( 'ui-slider' ),
							'after' => '%',
						),
						'width' => array(
							'type' => 'number',
							'label' => __( 'Width', 'ub' ),
							'default' => 600,
							'min' => 0,
							'max' => 2000,
							'classes' => array( 'ui-slider' ),
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
						'mode' => array(
							'type' => 'select',
							'label' => __( 'Multiple images mode', 'ub' ),
							'options' => array(
								'slideshow' => __( 'Slideshow', 'ub' ),
								'random' => __( 'Random', 'ub' ),
							),
							'default' => 'Slideshow',
						),
						'image' => array(
							'type' => 'gallery',
							'label' => __( 'Background Image', 'ub' ),
							'description' => __( 'You can upload a background image here. The image will stretch to fit the page, and will automatically resize as the window size changes. You\'ll have the best results by using images with a minimum width of 1024px.', 'ub' ),
						),
						'duration' => array(
							'type' => 'number',
							'label' => __( 'Slideshow duration', 'ub' ),
							'description' => __( 'Duration in minutes, we strongly recommended do not use less than 5 minutes.', 'ub' ),
							'default' => 10,
							'min' => 1,
							'max' => 60,
							'after' => __( 'minutes', 'ub' ),
							'classes' => array( 'ui-slider' ),
						),
					),
				),

				/**
				 * settings
				 */
				'mail' => array(
					'title' => __( 'Send Mail Settings', 'ub' ),
					'fields' => array(
						'send' => array(
							'type' => 'checkbox',
							'label' => __( 'Send mail?', 'ub' ),
							'description' => __( 'Try to send mail when somebody enter a site and a db problem is occured.', 'ub' ),
							'options' => array(
								'on' => __( 'On', 'ub' ),
								'off' => __( 'Off', 'ub' ),
							),
							'default' => 'off',
							'classes' => array( 'switch-button' ),
							'slave-class' => 'send',
						),
						'to' => array(
							'label' => __( 'To', 'ub' ),
							'master' => 'send',
						),
					),
				),
				'social_media_settings' => array(
					'title' => __( 'Social Media Settings', 'ub' ),
					'fields' => array(
						'show' => array(
							'type' => 'checkbox',
							'label' => __( 'Show on front-end', 'ub' ),
							'description' => __( 'Would you like to show social media?', 'ub' ),
							'options' => array(
								'on' => __( 'Show', 'ub' ),
								'off' => __( 'Hide', 'ub' ),
							),
							'default' => 'on',
							'classes' => array( 'switch-button' ),
							'slave-class' => 'social-media',
						),
						'colors' => array(
							'type' => 'checkbox',
							'label' => __( 'Colors', 'ub' ),
							'description' => __( 'Would you like show colored icons?', 'ub' ),
							'options' => array(
								'on' => __( 'Colors', 'ub' ),
								'off' => __( 'Monochrome', 'ub' ),
							),
							'default' => 'off',
							'classes' => array( 'switch-button' ),
							'master' => 'social-media',
						),
						'social_media_link_in_new_tab' => array(
							'type' => 'checkbox',
							'label' => __( 'Open links', 'ub' ),
							'description' => __( 'Would you like open link in new or the same window/tab?', 'ub' ),
							'options' => array(
								'on' => __( 'new', 'ub' ),
								'off' => __( 'the same', 'ub' ),
							),
							'default' => 'off',
							'classes' => array( 'switch-button' ),
							'master' => 'social-media',
						),
					),
				),
				'social_media' => array(
					'title' => __( 'Social Media', 'ub' ),
					'fields' => array(),
					'sortable' => true,
					'master' => array(
						'section' => 'social_media_settings',
						'field' => 'show',
						'value' => 'on',
					),
				),
				/**
				'delete' => array(
					'title' => __( 'Delete', 'ub' ),
					'hide-reset' => true,
					'fields' => array(
						'send' => array(
							'type' => 'button',
							'value' => __( 'Delete custom page', 'ub' ),
							'data' => array(
								'nonce' => wp_create_nonce( $this->module ),
							),
						),
					),
				),
				 */
			);
			$social = $this->get_social_media_array();
			$order = $this->get_value( '_social_media_sortable' );
			if ( is_array( $order ) ) {
				foreach ( $order as $key ) {
					if ( isset( $social[ $key ] ) ) {
						$options['social_media']['fields'][ $key ] = $social[ $key ];
						unset( $social[ $key ] );
					}
				}
			}
			$options['social_media']['fields'] += $social;
			$this->options = $options;
		}
	}
}
new ub_db_error_page();
