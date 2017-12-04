<?php
/*
Plugin Name: WPMU DEV Videos
Plugin URI: https://premium.wpmudev.org/project/unbranded-video-tutorials/
Description: A simple way to integrate WPMU DEV's over 40 unbranded support videos into your websites.
Author: WPMU DEV
Version: 1.5.5
Author URI: https://premium.wpmudev.org/
Network: true
WDP ID: 248
*/

/*
Copyright 2007-2017 Incsub (http://incsub.com)
Author - Aaron Edwards
Contributors - Jeffri, Joshua Dailey

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License (Version 2 - GPLv2) as published by
the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

class WPMUDEV_Videos {

	//------------------------------------------------------------------------//
	//---Config---------------------------------------------------------------//
	//------------------------------------------------------------------------//

	var $version = '1.5.4';
	var $api_url = 'https://premium.wpmudev.org/video-api-register.php';
	var $video_list;
	var $video_cats;
	var $page_url;

	function __construct() {

		add_action( 'admin_menu', array( &$this, 'plug_pages' ), 20 );
		add_action( 'network_admin_menu', array( &$this, 'plug_pages' ) ); //for 3.1

		add_action( 'admin_enqueue_scripts', array( &$this, 'wpmudev_videos_settings_styles' ) );

		//localize the plugin
		load_plugin_textdomain( 'wpmudev_vids', false, dirname( plugin_basename( __FILE__ ) ) . '/includes/languages/' );

		//attach videos to contextual help dropdowns if set
		if ( $this->get_setting( 'contextual_help', 1 ) ) {
			include_once( dirname( __FILE__ ) . '/includes/contextual-help.php' );
		}

		add_shortcode( 'wpmudev-video', array( &$this, 'handle_shortcode' ) );

		//default settings
		$this->video_list = array(
			'add-heading'                  => __( 'Heading Styles', 'wpmudev_vids' ),
			'add-image-from-media-library' => __( 'Adding Images From Media Library', 'wpmudev_vids' ),
			'add-image-from-pc'            => __( 'Uploading Images', 'wpmudev_vids' ),
			'add-image-from-url'           => __( 'Add Image From URL', 'wpmudev_vids' ),
			'image-gallery'                => __( 'Image Galleries', 'wpmudev_vids' ),
			'add-media'                    => __( 'Adding Media', 'wpmudev_vids' ),
			'add-new-page'                 => __( 'Adding New Pages', 'wpmudev_vids' ),
			'add-new-post'                 => __( 'Adding New Posts', 'wpmudev_vids' ),
			'add-paragraph'                => __( 'Using Paragraphs', 'wpmudev_vids' ),
			'admin-bar'                    => __( 'The Admin Bar', 'wpmudev_vids' ),
			'categories'                   => __( 'Categories', 'wpmudev_vids' ),
			'change-password'              => __( 'Changing Your Password', 'wpmudev_vids' ),
			'comments'                     => __( 'Managing Comments', 'wpmudev_vids' ),
			'dashboard'                    => __( 'The Dashboard', 'wpmudev_vids' ),
			'delete-image'                 => __( 'Deleting Images', 'wpmudev_vids' ),
			'edit-image'                   => __( 'Editing Images', 'wpmudev_vids' ),
			'edit-text'                    => __( 'Editing Text', 'wpmudev_vids' ),
			'excerpt'                      => __( 'Post Excerpts', 'wpmudev_vids' ),
			'featured-image'               => __( 'Set Featured Image', 'wpmudev_vids' ),
			'hyperlinks'                   => __( 'Hyperlinks', 'wpmudev_vids' ),
			'image-editor'                 => __( 'The Image Editor', 'wpmudev_vids' ),
			'lists'                        => __( 'Lists', 'wpmudev_vids' ),
			'media-library'                => __( 'The Media Library', 'wpmudev_vids' ),
			'oEmbed'                       => __( 'Embed Videos', 'wpmudev_vids' ),
			'quickpress'                   => __( 'Quick Draft', 'wpmudev_vids' ),
			'replace-image'                => __( 'Replace an Image', 'wpmudev_vids' ),
			'restore-page'                 => __( 'Restoring Pages', 'wpmudev_vids' ),
			'restore-post'                 => __( 'Restoring Posts', 'wpmudev_vids' ),
			'revisions'                    => __( 'Revisions', 'wpmudev_vids' ),
			'pages-v-posts'                => __( 'Pages vs. Posts', 'wpmudev_vids' ),
			'tags'                         => __( 'Using Tags', 'wpmudev_vids' ),
			'the-toolbar'                  => __( 'The Toolbar', 'wpmudev_vids' ),
			'trash-post'                   => __( 'Using Trash', 'wpmudev_vids' ),
			'widgets'                      => __( 'Managing Widgets', 'wpmudev_vids' ),
			'menus'                        => __( 'Navigation Menus', 'wpmudev_vids' ),
			'change-theme'                 => __( 'Change Theme', 'wpmudev_vids' ),
			'customize'                    => __( 'The Customizer', 'wpmudev_vids' ),
			'create-edit-user'             => __( 'Create and Edit Users', 'wpmudev_vids' ),
			'tools'                        => __( 'Tools', 'wpmudev_vids' ),
			'settings'                     => __( 'Settings', 'wpmudev_vids' ),
			'playlists'                    => __( 'Creating Playlists', 'wpmudev_vids' ),
		);

		if ( ! is_multisite() ) {
			$this->video_list['running-updates'] = __( 'Running Updates', 'wpmudev_vids' );
			$this->video_list['install-themes']  = __( 'Install a Theme', 'wpmudev_vids' );
			$this->video_list['install-plugin']  = __( 'Install and Configure a Plugin', 'wpmudev_vids' );
		}

		//videos by category
		$this->video_cats = array(
			'dashboard'  => array(
				'name' => __( 'The Dashboard', 'wpmudev_vids' ),
				'list' => array( 'dashboard', 'admin-bar', 'quickpress', 'change-password' )
			),
			'posts'      => array(
				'name' => __( 'Posts', 'wpmudev_vids' ),
				'list' => array( 'add-new-post', 'trash-post', 'restore-post', 'revisions' )
			),
			'pages'      => array(
				'name' => __( 'Pages', 'wpmudev_vids' ),
				'list' => array( 'add-new-page', 'trash-post', 'restore-page', 'pages-v-posts' )
			),
			'editor'     => array(
				'name' => __( 'The Visual Editor', 'wpmudev_vids' ),
				'list' => array(
					'the-toolbar',
					'edit-text',
					'add-paragraph',
					'add-heading',
					'hyperlinks',
					'lists',
					'oEmbed',
					'playlists',
					'excerpt'
				)
			),
			'images'     => array(
				'name' => __( 'Working With Images', 'wpmudev_vids' ),
				'list' => array(
					'add-image-from-pc',
					'add-image-from-media-library',
					'add-image-from-url',
					'image-gallery',
					'edit-image',
					'replace-image',
					'delete-image',
					'featured-image'
				)
			),
			'media'      => array(
				'name' => __( 'Media Library', 'wpmudev_vids' ),
				'list' => array( 'media-library', 'add-media', 'image-editor' )
			),
			'appearance' => array(
				'name' => __( 'Appearance', 'wpmudev_vids' ),
				'list' => array( 'change-theme', 'customize', 'widgets', 'menus' )
			),
			'organizing' => array(
				'name' => __( 'Organizing Content', 'wpmudev_vids' ),
				'list' => array( 'categories', 'tags' )
			),
			'comments'   => array(
				'name' => __( 'Managing Comments', 'wpmudev_vids' ),
				'list' => array( 'comments' )
			),
			'other'      => array(
				'name' => __( 'Users, Tools, and Settings', 'wpmudev_vids' ),
				'list' => array(
					'create-edit-user',
					'tools',
					'settings',
					'running-updates',
					'install-themes',
					'install-plugin'
				)
			)
		);

	}

	// an easy way to get to our settings array without undefined indexes.
	public function get_setting( $key, $default = null ) {
		$settings = get_site_option( 'wpmudev_vids_settings' );
		$setting  = isset( $settings[ $key ] ) ? $settings[ $key ] : $default;

		return apply_filters( "wpmudev_vids_setting_$key", $setting, $default );
	}

	function update_setting( $key, $value ) {
		$settings         = get_site_option( 'wpmudev_vids_settings' );
		$settings[ $key ] = $value;

		return update_site_option( 'wpmudev_vids_settings', $settings );
	}

	function plug_pages() {
		global $wpdb, $wp_version;

		//define this in wp-config to hide the setting menu
		if ( ! defined( 'WPMUDEV_VIDS_HIDE_SETTINGS' ) ) {
			define( 'WPMUDEV_VIDS_HIDE_SETTINGS', false );
		}

		if ( ! WPMUDEV_VIDS_HIDE_SETTINGS ) {
			if ( is_multisite() && is_network_admin() ) {
				$page = add_submenu_page( 'settings.php', __( 'WPMU DEV Videos', 'wpmudev_vids' ), __( 'WPMU DEV Videos', 'wpmudev_vids' ), 'manage_network_options', 'wpmudev-videos', array(
					&$this,
					'settings_output'
				) );
			} else if ( ! is_multisite() ) {
				$page = add_submenu_page( 'options-general.php', __( 'WPMU DEV Videos', 'wpmudev_vids' ), __( 'WPMU DEV Videos', 'wpmudev_vids' ), 'manage_options', 'wpmudev-videos', array(
					&$this,
					'settings_output'
				) );
			}
		}

		if ( ! is_network_admin() ) {
			if ( $this->get_setting( 'menu_location', 'dashboard' ) == 'dashboard' ) {
				$page           = add_submenu_page( 'index.php', $this->get_setting( 'menu_title' ), $this->get_setting( 'menu_title' ), 'read', 'video-tuts', array(
					&$this,
					'page_output'
				) );
				$this->page_url = admin_url( "index.php?page=video-tuts" );
			} else if ( $this->get_setting( 'menu_location' ) == 'support_system' ) {
				$page           = add_submenu_page( 'ticket-manager', $this->get_setting( 'menu_title' ), $this->get_setting( 'menu_title' ), 'read', 'video-tuts', array(
					&$this,
					'page_output'
				) );
				$this->page_url = admin_url( "admin.php?page=video-tuts" );
			} else if ( $this->get_setting( 'menu_location' ) == 'top' ) {
				$icon           = version_compare( $wp_version, '3.8', '>=' ) ? 'dashicons-format-video' : plugins_url( 'includes/icon.png', __FILE__ );
				$page           = add_menu_page( $this->get_setting( 'menu_title' ), $this->get_setting( 'menu_title' ), 'read', 'video-tuts', array(
					&$this,
					'page_output'
				), $icon, 57.24 );
				$this->page_url = admin_url( "admin.php?page=video-tuts" );
			}
			if ( isset( $page ) ) {
				add_action( 'admin_print_scripts-' . $page, array( &$this, 'masonry_script' ) );
			}
		}
	}

	function masonry_script() {
		wp_enqueue_script( 'jquery-masonry' );
	}

	function wpmudev_videos_settings_styles() {
		$screen = get_current_screen();

		if ( is_object( $screen ) && ( 'settings_page_wpmudev-videos' == $screen->id || 'settings_page_wpmudev-videos-network' == $screen->id ) ) {
			wp_enqueue_style( 'wpmudev-videos-stylesheet', plugins_url( '/includes/stylesheet.css', __FILE__ ) );
		}
	}

	function handle_shortcode( $atts ) {
		extract( shortcode_atts( array(
			'video'      => false,
			'group'      => false,
			'show_title' => true,
			'width'      => 500,
			'height'     => false
		), $atts ) );

		if ( ! $height ) {
			$height = ceil( ( $width * 9 ) / 16 );
		}

		if ( $group && isset( $this->video_cats[ $group ] ) ) {
			$hidden = $this->get_setting( 'hide' );

			$output = $show_title ? '<h3 class="wpmudev_video_group_title">' . $this->video_cats[ $group ]['name'] . '</h3>' : '';
			foreach ( $this->video_cats[ $group ]['list'] as $video ) {
				if ( ! isset( $this->video_list[ $video ] ) || isset( $hidden[ $video ] ) ) {
					continue; //exclude videos not in the main list (multisite ones) or hidden videos
				}
				$output .= '<p class="wpmudev_video"><iframe src="' . $this->create_embed_url( $video ) . '" frameborder="0" width="' . $width . '" height="' . $height . '" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe></p>';
			}

			return '<div class="wpmudev_video_group">' . $output . '</div>';
		}

		if ( $video && isset( $this->video_list[ $video ] ) ) {
			return '<p class="wpmudev_video"><iframe src="' . $this->create_embed_url( $video ) . '" frameborder="0" width="' . $width . '" height="' . $height . '" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe></p>';
		} else {
			return '';
		}
	}

	function get_apikey() {
		return ( defined( 'WPMUDEV_APIKEY' ) && WPMUDEV_APIKEY ) ? WPMUDEV_APIKEY : get_site_option( 'wpmudev_apikey' );
	}

	function create_embed_url( $video, $autoplay = false ) {
		//create ssl url
		$url = is_ssl() ? 'https://premium.wpmudev.org/video/' . urlencode( $video ) : 'http://premium.wpmudev.org/video/' . urlencode( $video );
		if ( $autoplay ) {
			$url = add_query_arg( 'autoplay', '1', $url );
		}

		if ( ! $this->is_mapped() ) {
			return $url;
		}

		//used to sign video embed urls with a 10 minute expiring signature when domain mapping is on
		$site_id   = $this->get_setting( 'site_id' );
		$expire    = strtotime( "+10 Minutes" );
		$api_key   = $this->get_apikey();
		$signature = hash_hmac( "sha1", $site_id . $expire, $api_key );

		return add_query_arg( array( 'id' => $site_id, 'expire' => $expire, 'signature' => $signature ), $url );
	}

	function is_mapped() {

		//As of WP 4.9 Referrer-Policy:same-origin is sent in admin, so we have to use mapping mode now always
        if ( is_admin() ) {
	        return true;
        }

		//allow users of other domain mapping plugins to turn on support
		if ( defined( 'WPMUDEV_VIDS_DOMAIN_MAPPED' ) ) {
			return true;
		}

		if ( is_multisite() && class_exists( 'domain_map' ) ) {
			$options = get_site_option( 'domain_mapping', array() );
			if ( $options['map_admindomain'] != 'original' ) {
				return true;
			}
		}

		return false;
	}

//------------------------------------------------------------------------//
//---Page Output Functions------------------------------------------------//
//------------------------------------------------------------------------//

	function settings_output() {
		global $wpdb, $current_site;

		//save settings
		if ( isset( $_POST['save_settings'] ) ) {
			//strip slashes
			$_POST['wpmudev_vids']['menu_title'] = stripslashes( $_POST['wpmudev_vids']['menu_title'] );

			if ( ! empty( $_POST['wpmudev_vids']['site_id'] ) ) {
				$_POST['wpmudev_vids']['site_id'] = intval( $_POST['wpmudev_vids']['site_id'] );
			}

			update_site_option( 'wpmudev_vids_settings', $_POST['wpmudev_vids'] );

			echo '<div class="updated fade"><p>' . __( 'Settings saved.', 'wpmudev_vids' ) . '</p></div>';
		}
		?>
        <div class="wrap">
            <h2><?php _e( 'WPMU DEV Video Settings', 'wpmudev_vids' ) ?></h2>

	        <?php if ( empty( $this->get_apikey() ) ) { ?>
                <div class="notice error"><p><?php _e( 'Please install and login to the <a href="https://premium.wpmudev.org/project/wpmu-dev-dashboard/" target="_blank">WPMU DEV Dashboard plugin</a> to enable video tutorials.', 'wpmudev_vids' ); ?></p></div>
	        <?php } ?>

            <form action="" method="post">
                <div id="poststuff" class="metabox-holder">

                    <div class="postbox">
                        <h3 class='hndle' style="cursor:default;">
                            <span><?php _e( 'Display Settings', 'wpmudev_vids' ) ?></span>
                        </h3>

                        <div class="inside">
                            <table class="form-table">
                                <tr>
                                    <th scope="row"><?php _e( 'Register This Domain', 'wpmudev_vids' ) ?></th>
                                    <td>
										<?php
										$result = wp_remote_get( $this->api_url . '?domain_id=' . network_site_url() );
										if ( is_wp_error( $result ) ) {
											echo '<div class="error"><p>' . sprintf( __( 'Whoops, your server is having trouble connecting to the WPMU DEV API! If this problem continues, please contact your host and ask them to "make sure php and any firewall is configured to allow an HTTP GET call via curl or fsockopen to %s.', 'wpmudev_vids' ), $this->api_url ) . '</p></div>';
										} else if ( ! is_numeric( $result['body'] ) ) {
											?>
                                            <span
                                                    class="description"><?php printf( __( 'Please register this domain "%s" below: ', 'wpmudev_vids' ), network_site_url() ); ?></span>
                                            <iframe src="<?php echo $this->api_url . '?new_domain=' . network_site_url(); ?>"
                                                    width="100%"
                                                    height="150"></iframe>
                                            <input type="submit" class="button-primary" name="save_settings"
                                                   value="<?php _e( 'Now Confirm Registration', 'wpmudev_vids' ) ?>"/>
											<?php
											$site_id = '';
										} else {
											$site_id = intval( $result['body'] );
											?>
                                            <strong><?php printf( __( 'Successfully Registered! Video Site ID: %s', 'wpmudev_vids' ), $site_id ); ?></strong>
                                            <input name="wpmudev_vids[site_id]"
                                                   value="<?php echo esc_attr( $this->get_setting( 'site_id', $site_id ) ); ?>"
                                                   type="hidden"/>
										<?php } ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row"><?php _e( 'Add Videos to Contextual Help', 'wpmudev_vids' ) ?></th>
                                    <td>
                                        <label><input value="1" name="wpmudev_vids[contextual_help]"
                                                      type="radio"<?php checked( $this->get_setting( 'contextual_help', 1 ), 1 ) ?> /> <?php _e( 'Yes', 'wpmudev_vids' ) ?>
                                        </label>
                                        <label><input value="0" name="wpmudev_vids[contextual_help]"
                                                      type="radio"<?php checked( $this->get_setting( 'contextual_help', 1 ), 0 ) ?> /> <?php _e( 'No', 'wpmudev_vids' ) ?>
                                        </label>
                                        <br/><span
                                                class="description"><?php _e( 'This will add the appropriate video tutorials to the help dropdowns on WordPress admin screens.', 'wpmudev_vids' ) ?></span>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row"><?php _e( 'Menu Location', 'wpmudev_vids' ) ?></th>
                                    <td>
                                        <select name="wpmudev_vids[menu_location]">
                                            <option
                                                    value="dashboard"<?php selected( $this->get_setting( 'menu_location' ), 'dashboard' ) ?>><?php _e( 'Dashboard', 'wpmudev_vids' ) ?></option>
                                            <option
                                                    value="top"<?php selected( $this->get_setting( 'menu_location' ), 'top' ) ?>><?php _e( 'Top Level', 'wpmudev_vids' ) ?></option>
											<?php if ( function_exists( 'incsub_support' ) ) { ?>
                                                <option
                                                        value="support_system"<?php selected( $this->get_setting( 'menu_location' ), 'support_system' ) ?>><?php _e( 'Support System Plugin', 'wpmudev_vids' ) ?></option>
											<?php } ?>
                                            <option
                                                    value="none"<?php selected( $this->get_setting( 'menu_location' ), 'none' ) ?>><?php _e( 'No Menu', 'wpmudev_vids' ) ?></option>
                                        </select>
                                        <br/><span
                                                class="description"><?php _e( 'What part of the admin menu should the video tutorial page be added?', 'wpmudev_vids' ) ?></span>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row"><?php _e( 'Menu Title', 'wpmudev_vids' ) ?></th>
                                    <td>
                                        <label><input size="25" name="wpmudev_vids[menu_title]"
                                                      value="<?php esc_attr_e( $this->get_setting( 'menu_title', __( 'Video Tutorials', 'wpmudev_vids' ) ) ); ?>"
                                                      type="text"/></label>
                                        <br/><span
                                                class="description"><?php _e( 'Sets the menu title for the video tutorial page.', 'wpmudev_vids' ) ?></span>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row"><?php _e( 'Hide Videos', 'wpmudev_vids' ) ?></th>
                                    <td class="wpmudev-hide-videos">
										<span
                                                class="description"><?php _e( 'Check any videos here that you want to hide from users on the videos page or in group shortcodes.', 'wpmudev_vids' ) ?></span><br/>
										<?php
										$hidden = $this->get_setting( 'hide' );
										foreach ( $this->video_list as $key => $label ) {
											$checked = isset( $hidden[ $key ] ) ? ' checked="checked"' : '';
											?>
                                            <label><input name="wpmudev_vids[hide][<?php echo $key; ?>]" value="1"
                                                          type="checkbox"<?php echo $checked; ?> /> <?php esc_attr_e( $label ); ?>
                                            </label>
										<?php } ?>
                                    </td>
                                </tr>
                            </table>
                            <p class="submit">
                                <input type="submit" class="button-primary" name="save_settings"
                                       value="<?php _e( 'Save Changes', 'wpmudev_vids' ) ?>"/>
                            </p>
                        </div>
                    </div>

                    <div class="postbox">
                        <h3 class='hndle' style="cursor:default;">
                            <span><?php _e( 'Shortcodes', 'wpmudev_vids' ) ?></span>
                        </h3>

                        <div class="inside">
                            <p><?php _e( 'These shortcodes allow you to easily embed video tutorials in posts and pages on your sites. Simply type or paste them into your post or page content where you would like them to appear. Also properly handles SSL protected pages. You may also pass "width" and/or "height" arguments to customize the size of the videos.', 'wpmudev_vids' ) ?></p>
                            <table class="form-table">
								<?php foreach ( $this->video_list as $url => $label ) { ?>
                                    <tr>
                                        <th scope="row"><?php esc_attr_e( $label ); ?></th>
                                        <td>
                                            <strong>[wpmudev-video video="<?php echo $url; ?>"]</strong>
                                        </td>
                                    </tr>
								<?php } ?>
                            </table>
                            <h2><?php _e( 'Group Shortcodes', 'wpmudev_vids' ) ?> - <span
                                        class="description"><?php _e( 'These shortcodes allow you to embed a whole group of videos at a time.', 'wpmudev_vids' ) ?></span>
                            </h2>
                            <table class="form-table">
								<?php foreach ( $this->video_cats as $url => $group ) { ?>
                                    <tr>
                                        <th scope="row"><?php echo esc_attr( $group['name'] ); ?></th>
                                        <td>
                                            <strong>[wpmudev-video group="<?php echo $url; ?>" show_title="1"]</strong>
                                            or
                                            <strong>[wpmudev-video
                                                group="<?php echo $url; ?>" show_title="0"]</strong>
                                            <br>
                                            <small>
												<?php
												$list = array();
												foreach ( $group['list'] as $video ) {
													if ( isset( $this->video_list[ $video ] ) && ! isset( $hidden[ $video ] ) ) { //only display if existing and not hidden
														$list[] = $this->video_list[ $video ];
													}
												}
												echo implode( ', ', $list );
												?>
                                            </small>
                                        </td>
                                    </tr>
								<?php } ?>
                            </table>
                        </div>
                    </div>

                </div>
            </form>
        </div>
		<?php
	}

	function page_output() {
		global $wpdb, $current_site;

		//remove any hidden videos from the list
		$hidden = $this->get_setting( 'hide' );
		if ( is_array( $hidden ) && count( $hidden ) ) {
			foreach ( $this->video_cats as $cat_key => $cat ) {
				foreach ( $cat['list'] as $key => $video ) {
					if ( isset( $hidden[ $video ] ) ) {
						unset( $this->video_cats[ $cat_key ]['list'][ $key ] );
					}
				}
			}
		}

		/**
		 * Video list filter.
		 *
		 * Use this hook to add your custom videos to the $this->video_list array in the same format
		 *  like 'slug' => 'label'. Example `return $video_list['newslug'] = 'Label';`
		 *
		 * @since 1.5
		 *
		 * @param array $this ->video_list Registered videos.
		 */
		$this->video_list = apply_filters( 'wpmudev_vids_list', $this->video_list );

		/**
		 * Video category filter.
		 *
		 * Use this hook to add your custom videos registered via 'wpmudev_vids_list' filter to the desired categories, or a new category.
		 *
		 * @since 1.5
		 *
		 * @param array $this ->video_cats Registered video categories.
		 */
		$this->video_cats = apply_filters( 'wpmudev_vids_categories', $this->video_cats );
		?>
        <style type="text/css">#poststuff .postbox .inside iframe {
                display: block;
                margin: 0 auto;
                box-shadow: 30px 0 50px -30px #222, -30px 0 50px -30px #222;
            }</style>
        <div class="wrap">
            <h2><?php echo $this->get_setting( 'menu_title' ); ?></h2>

			<?php if ( isset( $_GET['vid'] ) && isset( $this->video_list[ $_GET['vid'] ] ) ) { ?>
                <div id="poststuff" class="metabox-holder">
                    <div class="postbox">
                        <h3 class='hndle' style="cursor:default;">
                            <span><?php esc_attr_e( $this->video_list[ $_GET['vid'] ] ); ?></span></h3>

                        <div class="inside">
							<?php
							$video_html = '<iframe src="' . $this->create_embed_url( $_GET['vid'], true ) . '" frameborder="0" width="600"
							        height="338" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';

							/**
							 * Video embed HTML
							 *
							 * Use this hook to return the actual video embed code to display your custom video.
							 *
							 * @since 1.5.2
							 *
							 * @param string $video_html HTML embed code.
							 * @param string $video_slug The id slug of the video that you added via the wpmudev_vids_(list|categories) filters.
							 */
							echo apply_filters( 'wpmudev_vids_embed_html', $video_html, $_GET['vid'] );
							?>
                        </div>
                    </div>
                </div>
			<?php } ?>

            <h3><?php _e( 'Select a Video Tutorial', 'wpmudev_vids' ) ?></h3>

            <div class="grid js-masonry" data-masonry-options='{ "itemSelector": ".grid-item", "columWidth": 190 }'>
				<?php foreach ( $this->video_cats as $cat ) {
					//skip if no vids in category
					if ( count( $cat['list'] ) == 0 ) {
						continue;
					}
					?>
                    <table class='widefat grid-item'
                           style="width: 19%; float: left; margin-right: 1%;margin-bottom: 10px;clear: none;">
                        <thead>
                        <tr>
                            <th scope='col'><?php echo $cat['name']; ?></th>
                        </tr>
                        </thead>
                        <tbody id='the-list'>
						<?php
						$class = '';
						foreach ( $cat['list'] as $video ) {
							if ( ! isset( $this->video_list[ $video ] ) ) {
								continue;
							}
							//=========================================================//
							$highlight = ( isset( $_GET['vid'] ) && $_GET['vid'] == $video ) ? ' style="color:#D54E21;font-weight:bold;"' : '';
							echo "<tr class='$class'>";
							echo "<td valign='top'><a href='" . $this->page_url . "&vid=$video" . "'$highlight>" . esc_attr( $this->video_list[ $video ] ) . "</a></td>";
							echo "</tr>";
							$class = ( 'alternate' == $class ) ? '' : 'alternate';
							//=========================================================//
						}
						?>
                        </tbody>
                    </table>
				<?php } ?>
                <div class="clear"></div>
            </div>

        </div>
		<?php
	}

}

global $wpmudev_vids;
$wpmudev_vids = new WPMUDEV_Videos();

global $wpmudev_notices;
$wpmudev_notices[] = array(
	'id'      => 248,
	'name'    => 'WPMU DEV Videos',
	'screens' => array(
		'settings_page_wpmudev-videos',
		'settings_page_wpmudev-videos-network',
		'toplevel_page_video-tuts',
		'dashboard_page_video-tuts'
	)
);
include_once( dirname( __FILE__ ) . '/includes/dash-notice/wpmudev-dash-notification.php' );