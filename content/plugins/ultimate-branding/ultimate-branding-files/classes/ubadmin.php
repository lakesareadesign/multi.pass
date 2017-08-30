<?php
if ( ! class_exists( 'UltimateBrandingAdmin' ) ) {

	class UltimateBrandingAdmin {

		var $build;
		var $modules = array();

		private $configuration = array();

		var $plugin_msg = array();
		// Holder for the help class
		var $help;

		protected  $js_files = array();
		protected  $css_files = array();

		/**
		 * Default messages.
		 *
		 * @since 1.8.5
		 */
		var $messages = array();

		private $debug = false;

		public function __construct() {
			global $ub_version;
			$this->build = $ub_version;

			$this->set_configuration();
			$this->debug = apply_filters( 'ultimatebranding_debug', defined( 'WP_DEBUG' ) && WP_DEBUG );

			foreach ( $this->configuration as $key => $data ) {
				if ( ! is_multisite() && isset( $data['network-only'] ) && $data['network-only'] ) {
					continue;
				}
				$this->modules[ $key ] = $data['module'];
			}

			add_action( 'plugins_loaded', array( $this, 'load_modules' ) );
			add_action( 'plugins_loaded', array( $this, 'setup_translation' ) );
			add_action( 'init', array( $this, 'initialise_ub' ) );
			/**
			 * default messages
			 */
			$this->messages = array();
			$this->messages['success'] = __( 'Changes saved.', 'ub' );
			$this->messages['fail'] = __( 'There was an error, please try again.', 'ub' );
			$this->messages['reset-section-success'] = __( 'Section was reset to defaults.', 'ub' );
		}

		function UltimateBrandingAdmin() {
			$this->__construct();
		}

		function transfer_old_settings() {
			$modules = ub_get_option( 'ultimatebranding_activated_modules', array() );
			if ( is_multisite() && function_exists( 'is_plugin_active_for_network' ) && is_plugin_active_for_network( 'ultimate-branding/ultimate-branding.php' ) ) {
				// Check for the original settings and if there are none, but there are some in the old location then move them across
				if ( empty( $modules ) ) {
					// none in our settings
					$othermodules = get_option( 'ultimatebranding_activated_modules', array() );
					if ( ! empty( $othermodules ) ) {
						// We shall do a transfer across - first modules
						ub_update_option( 'ultimatebranding_activated_modules', $othermodules );
						// Next each set of settings for the activated modules
						foreach ( $othermodules as $key => $title ) {
							switch ( $key ) {
								case 'favicons.php': ub_update_option( 'ub_favicon_dir', get_option( 'ub_favicon_dir' ) );
									ub_update_option( 'ub_favicon_url', get_option( 'ub_favicon_url' ) );
							break;

								case 'login-image.php': ub_update_option( 'ub_login_image_dir', get_option( 'ub_login_image_dir' ) );
									ub_update_option( 'ub_login_image_url', get_option( 'ub_login_image_url' ) );
							break;

								case 'custom-admin-bar.php':
									ub_update_option( 'wdcab', get_option( 'wdcab' ) );
								break;

								case 'admin-help-content.php': ub_update_option( 'admin_help_content', get_option( 'admin_help_content' ) );
								break;

								case 'global-footer-content.php': ub_update_option( 'global_footer_content', get_option( 'global_footer_content' ) );
								break;

								case 'global-header-content.php': ub_update_option( 'global_header_content', get_option( 'global_header_content' ) );
								break;

								case 'admin-menu.php': ub_update_option( 'admin_menu', get_option( 'admin_menu' ) );
								break;

								case 'admin-footer-text.php': ub_update_option( 'admin_footer_text', get_option( 'admin_footer_text' ) );
								break;

								case 'remove-wp-dashboard-widgets.php': ub_update_option( 'rwp_active_dashboard_widgets', get_option( 'rwp_active_dashboard_widgets' ) );
								break;

								case 'site-generator-replacement.php': ub_update_option( 'site_generator_replacement', get_option( 'site_generator_replacement' ) );
									ub_update_option( 'site_generator_replacement_link', get_option( 'site_generator_replacement_link' ) );
								break;

								case 'site-wide-text-change.php': ub_update_option( 'translation_ops', get_option( 'translation_ops' ) );
									ub_update_option( 'translation_table', get_option( 'translation_table' ) );
								break;

								case 'custom-login-css.php': ub_update_option( 'global_login_css', get_option( 'global_login_css' ) );
								break;

								case 'custom-admin-css.php': ub_update_option( 'global_admin_css', get_option( 'global_admin_css' ) );
								break;

								case 'admin-message.php': ub_update_option( 'admin_message', get_site_option( 'admin_message' ) );
								break;
							}
						}
					}
				}
			}

		}

		function initialise_ub() {
			global $blog_id;
			// For this version only really - to bring settings across from the old storage locations
			$this->transfer_old_settings();

			if ( ! is_multisite() ) {
				if ( UB_HIDE_ADMIN_MENU != true ) {
					add_action( 'admin_menu', array( $this, 'network_admin_page' ) );
				}
			} else {
				if ( is_plugin_active_for_network( 'ultimate-branding/ultimate-branding.php' ) ) {
					add_action( 'network_admin_menu', array( $this, 'network_admin_page' ) );
					$show_in_subsites = $this->check_show_in_subsites();
					if ( $show_in_subsites ) {
						add_action( 'admin_menu', array( $this, 'admin_page' ) );
					}
				} else {
					// Added to allow single site activation across a network
					if ( UB_HIDE_ADMIN_MENU != true && ! defined( 'UB_HIDE_ADMIN_MENU_' . $blog_id ) ) {
						add_action( 'admin_menu', array( $this, 'network_admin_page' ) );
					}
				}
			}

			// Header actions
			add_action( 'load-toplevel_page_branding', array( $this, 'add_admin_header_branding' ) );
		}

		function setup_translation() {
			// Load up the localization file if we're using WordPress in a different language
			// Place it in this plugin's "languages" folder and name it "mp-[value in wp-config].mo"

			load_plugin_textdomain( 'ub', false, '/ultimate-branding/ultimate-branding-files/languages/' );
		}

		function add_admin_header_core() {

			// Add in help pages
			$screen = get_current_screen();

			$this->help = new UB_Help( $screen );
			$this->help->attach();
			// Add in the core CSS file
			wp_enqueue_style( 'defaultadmincss', ub_files_url( 'css/defaultadmin.css' ), array(), $this->build );
			wp_enqueue_script( array(
				'jquery-ui-sortable',
			) );
			wp_enqueue_script( 'ub_ace', ub_files_url( 'js/vendor/ace.js' ), array(), $this->build, true );
			wp_enqueue_script( 'ub_ace', ub_files_url( 'js/vendor/mode-css.js' ), array(), $this->build, true );
			wp_enqueue_script( 'ub_admin', ub_files_url( 'js/admin.js' ), array(), $this->build, true );
			wp_enqueue_script( 'jquery-effects-highlight' );
			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_script( 'wp-color-picker' );
			wp_localize_script('ub_admin', 'ub_admin', array(
				'current_menu_sub_item' => (isset( $_GET['tab'] ) ? $_GET['tab'] : ''),
			));
		}

		function add_admin_header_branding() {
			$this->add_admin_header_core();

			do_action( 'ultimatebranding_admin_header_global' );

			$tab = (isset( $_GET['tab'] )) ? $_GET['tab'] : '';

			if ( empty( $tab ) ) {
				$tab = 'dashboard';
			}

			do_action( 'ultimatebranding_admin_header_' . $tab );

			$this->update_branding_page();
		}

		/**
		 * 	Check plugins those will be used if they are active or not
		 */
		function load_modules() {

			// Load our remaining modules here
			foreach ( $this->modules as $module => $plugin ) {
				if ( ub_is_active_module( $module ) ) {
					ub_load_single_module( $module );
				}
			}
		}

		function check_active_plugins() {
			// We may be calling this function before admin files loaded, therefore let's be sure required file is loaded
			include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

			$plugins = get_plugins(); // All installed plugins

			foreach ( $plugins as $plugin_file => $plugin_data ) {
				if ( is_plugin_active( $plugin_file ) && in_array( $plugin_file, $this->modules ) ) {
					// Add the title to the message
					$this->plugin_msg[ $plugin_file ] = $plugin_data['Title'];
				}
			}
		}

		/**
		 * 	Warn admin if this is not multisite
		 */
		function not_multisite_msg() {
			echo '<div class="error"><p>' .
				__( '<b>[Ultimate Branding]</b> Plugin only works in Multisite.', 'ub' ) .
				'</p></div>';
		}

		/**
		 * 	Warn admin to deactivate the duplicate plugins
		 */
		function deactivate_plugin_msg() {
			echo '<div class="error"><p>' .
				sprintf( __( '<b>[Ultimate Branding]</b> Please deactivate the following plugin(s) to make Ultimate Branding work: %s', 'ub' ), implode( ', ', $this->plugin_msg ) ) .
				'</p></div>';
		}

		/**
		 * Add pages
		 */
		function admin_page() {
			// Add in our menu page
			add_menu_page(
				__( 'Branding', 'ub' ),
				__( 'Branding', 'ub' ),
				'manage_options', 'branding',
				array( $this, 'handle_main_page_subsite' ),
				'dashicons-art'
			);
		}

		/**
		 * Add pages
		 */
		function network_admin_page() {

			if ( function_exists( 'is_plugin_active_for_network' ) && is_plugin_active_for_network( 'ultimate-branding/ultimate-branding.php' ) ) {
				$capability = 'manage_network_options';
			} else {
				$capability = 'manage_options';
			}

			// Add in our menu page
			add_menu_page(
				__( 'Branding', 'ub' ),
				__( 'Branding', 'ub' ),
				$capability, 'branding',
				array( $this, 'handle_main_page' ),
				'dashicons-art'
			);
			if ( ! is_network_admin() ) {
				add_submenu_page(
					'branding',
					__( 'Dashboard', 'ub' ),
					__( 'Dashboard', 'ub' ),
					$capability, 'branding',
					array( $this, 'handle_main_page' )
				);
			}

			// Get the activated modules
			$modules = get_ub_activated_modules();

			$base_url = $this->get_base_url();
			// Add in the extensions
			foreach ( $modules as $key => $title ) {
				if ( isset( $this->configuration[ $key ] ) ) {
					$module = $this->configuration[ $key ];
					if ( isset( $module['tab'] ) ) {
						$function = preg_replace( '/-/', '_', sprintf( 'handle_%s_panel', $module['tab'] ) );
						$menu_slug = sprintf( 'branding&amp;tab='.$module['tab'] );
						if ( method_exists( $this, $function ) ) {
							if ( ub_has_menu( $menu_slug ) ) {
								continue;
							}
							$page_title = isset( $module['page_title'] )? $module['page_title'] : $module['tab'];
							$menu_title = isset( $module['menu_title'] )? $module['menu_title'] : $page_title;
							add_submenu_page( 'branding', $page_title, $menu_title, $capability, $menu_slug, array( $this, $function ) );
							continue;
						} else if ( $this->debug ) {
							error_log( sprintf( 'UltimateBranding: missing module: %s, callback: %s', $key, $function ) );
						}
					} else if ( $this->debug ) {
						error_log( sprintf( 'UltimateBranding: missing module tab: %s', $key ) );
					}
				} else if ( $this->debug ) {
					error_log( sprintf( 'UltimateBranding: missing module configuration: %s', $key ) );
				}
			}
			do_action( 'ultimate_branding_add_menu_pages' );

			/**
			 * sort
			 */
			global $submenu;
			if ( isset( $submenu['branding'] ) ) {
				$items = $submenu['branding'];
				usort( $items, array( $this, 'sort_admin_menu' ) );
				$submenu['branding'] = $items;
			}
		}

		function activate_module( $module ) {

			$modules = get_ub_activated_modules();
			if ( ! isset( $modules[ $module ] ) ) {
				$modules[ $module ] = 'yes';
				update_ub_activated_modules( $modules );
			} else {
				return false;
			}
		}

		function deactivate_module( $module ) {

			$modules = get_ub_activated_modules();

			if ( isset( $modules[ $module ] ) ) {
				unset( $modules[ $module ] );
				update_ub_activated_modules( $modules );
			} else {
				return false;
			}
		}

		function update_branding_page() {

			global $action, $page;

			wp_reset_vars( array( 'action', 'page' ) );

			if ( isset( $_REQUEST['action'] ) && ! empty( $_REQUEST['action'] ) ) {

				$tab = (isset( $_GET['tab'] )) ? $_GET['tab'] : '';

				if ( empty( $tab ) ) {
					$tab = 'dashboard';
				}
				if ( 'dashboard' == $tab ) {
					if ( isset( $_GET['action'] ) && isset( $_GET['module'] ) ) {
						switch ( $_GET['action'] ) {
							case 'enable': check_admin_referer( 'enable-module-' . $_GET['module'] );
								if ( $this->activate_module( $_GET['module'] ) ) {
									wp_safe_redirect( UB_Help::remove_query_arg_raw( array( 'module', '_wpnonce', 'action' ), wp_get_referer() ) );
								} else {
									wp_safe_redirect( UB_Help::remove_query_arg_raw( array( 'module', '_wpnonce', 'action' ), wp_get_referer() ) );
								}
						break;
							case 'disable': check_admin_referer( 'disable-module-' . $_GET['module'] );
								if ( $this->deactivate_module( $_GET['module'] ) ) {
									wp_safe_redirect( UB_Help::remove_query_arg_raw( array( 'module', '_wpnonce', 'action' ), wp_get_referer() ) );
								} else {
									wp_safe_redirect( UB_Help::remove_query_arg_raw( array( 'module', '_wpnonce', 'action' ), wp_get_referer() ) );
								}
						break;
						}
					} elseif ( isset( $_GET['action'] ) && $_GET['action'] == 'enableallmodules' ) {
						check_admin_referer( 'enable-all-modules' );
						foreach ( $this->modules as $module => $value ) {

							$this->activate_module( $module );
						}
						wp_safe_redirect( UB_Help::remove_query_arg_raw( array( 'module', '_wpnonce', 'action' ), wp_get_referer() ) );
					} elseif ( isset( $_GET['action'] ) && $_GET['action'] == 'disableallmodules' ) {
						check_admin_referer( 'disable-all-modules' );
						foreach ( $this->modules as $module => $value ) {

							$this->deactivate_module( $module );
						}
						wp_safe_redirect( UB_Help::remove_query_arg_raw( array( 'module', '_wpnonce', 'action' ), wp_get_referer() ) );
					}
					return;
				}

				$t = preg_replace( '/-/', '_', $tab );
				/**
				 * check
				 */
				check_admin_referer( 'ultimatebranding_settings_'.$t );

				$msg = 'fail';
				$result = apply_filters( 'ultimatebranding_settings_'.$t.'_process', true );
				if ( $result ) {
					$msg = 'success';
				}
				wp_safe_redirect( UB_Help::add_query_arg_raw( 'msg', $msg, wp_get_referer() ) );
				do_action( 'ultimatebranding_settings_update_' . $tab );
			}
		}

		/**
		 * Handle main page on subsite
		 */
		function handle_main_page_subsite() {
			echo  '<div class="wrap nosubsub">';
			echo '<h1>';
			_e( 'Ultimate Branding', 'ub' );
			echo '</h1>';
			echo '</div>';
		}

		function handle_main_page() {
			global $action, $page;
			wp_reset_vars( array( 'action', 'page' ) );
			$tab = (isset( $_GET['tab'] )) ? $_GET['tab'] : '';
			if ( empty( $tab ) ) {
				$tab = 'dashboard';
			}
			echo '<div class="wrap nosubsub">';
			echo '<h3 class="nav-tab-wrapper">';
			$base_url = $this->get_base_url();
			/**
			 * dashboard link
			 */
			$classes = array(
				'nav-tab',
				'nav-tab-dashboard',
			);
			if ( 'dashboard' == $tab ) {
				$classes[] = 'nav-tab-active';
			}
			printf(
				'<a href="%s" class="%s">%s</a>',
				esc_url( $base_url ),
				esc_attr( implode( ' ', $classes ) ),
				esc_html__( 'Dashboard', 'ub' )
			);
			/**
			 * tabs
			 */
			$added = array();
			foreach ( $this->configuration as $key => $data ) {
				if ( ! isset( $data['tab'] ) ) {
					continue;
				}
				if ( isset( $added[ $data['tab'] ] ) ) {
					continue;
				}
				/**
				 * check is active
				 */
				$is_active = ub_is_active_module( $key );
				if ( ! $is_active ) {
					continue;
				}
				/**
				 * avoid double add
				 */
				$added[ $data['tab'] ] = 1;
				$url = add_query_arg( 'tab', $data['tab'], $base_url );
				$classes = array(
					'nav-tab',
					'nav-tab-'.$data['tab'],
				);
				if ( $tab == $data['tab'] ) {
					$classes[] = 'nav-tab-active';
				}
				/**
				 * exceptions
				 */
				if ( 'admin-panel-tips' == $key && ! is_multisite() ) {
					$url = add_query_arg( 'post_type', 'admin_panel_tip', admin_url( 'edit.php' ) );
				}
				printf(
					'<a href="%s" class="%s">%s</a>',
					esc_url( $url ),
					esc_attr( implode( ' ', $classes ) ),
					esc_html( isset( $data['menu_title'] )? $data['menu_title']:$data['page_title'] )
				);
			}
			echo '</h3>';
			/**
			 * tab content
			 */
			if ( 'dashboard' == $tab ) {
				$this->show_dashboard_page();
			} else {
				$module_is_active = false;
				$modules = $this->get_modules_by_tab( $tab );
				foreach ( $modules as $module ) {
					if ( isset( $module['tab'] ) ) {
						$is_active = ub_is_active_module( $module['key'] );
						if ( $is_active && ! $module_is_active ) {
							$this->panel( $module['tab'] );
							$module_is_active = true;
						}
					}
				}
				if ( ! $module_is_active ) {
					if ( 0 < count( $modules ) ) {
						foreach ( $modules as $module ) {
							if ( isset( $module['tab'] ) ) {
								echo $this->module_is_not_active_message( $module );
							}
						}
					} else {
						printf( '<h1>%s</h1>', esc_html__( 'Unknown module', 'ub' ) );
						echo '<div class="updated error">';
						printf( '<p>%s</p>', esc_html__( 'Cheatin&#8217; uh?', 'ub' ) );
						echo '</div>';
					}
				}
			}
			echo '</div> <!-- wrap -->';
		}

		function show_dashboard_page() {
			global $action, $page;
			printf( '<h1>%s</h1>', esc_html__( 'Branding', 'ub' ) );
			if ( isset( $_GET['msg'] ) && isset( $this->messages[ $_GET['msg'] ] ) ) {
				echo '<div id="message" class="updated fade"><p>' . $messages[ $_GET['msg'] ] . '</p></div>';
				$_SERVER['REQUEST_URI'] = UB_Help::remove_query_arg( array( 'msg' ), $_SERVER['REQUEST_URI'] );
			}
?>

    <div id="dashboard-widgets-wrap">

        <div class="metabox-holder" id="dashboard-widgets">
            <div style="width: 49%;" class="postbox-container">
                <div class="meta-box-sortables ui-sortable" id="normal-sortables">

<?php
			// See what plugins are active
			$this->check_active_plugins();

if ( ! empty( $this->plugin_msg ) ) {
?>
<div class="postbox " id="">
<h3 class="hndle"><span><?php _e( 'Notifications', 'ub' ); ?></span></h3>
<div class="inside">
<?php
	_e( 'Please deactivate the following plugin(s) to make Ultimate Branding to work:', 'ub' );
	echo '<ul><li><strong>' . implode( '</li><li>', $this->plugin_msg );
	echo '</strong></li></ul>';
?>
<br class="clear">
</div>
</div>
<?php
}
?>

                    <div class="postbox " id="">
                        <h3 class="hndle"><span><?php _e( 'Branding', 'ub' ); ?></span></h3>
                        <div class="inside">
<?php
			include_once( ub_files_dir( 'help/dashboard.help.php' ) );
?>
                            <br class="clear">
                        </div>
                    </div>

<?php
			do_action( 'ultimatebranding_dashboard_page_left' );
?>
                </div>
            </div>

            <div style="width: 49%;" class="postbox-container">
                <div class="meta-box-sortables ui-sortable" id="side-sortables">

<?php
			do_action( 'ultimatebranding_dashboard_page_right_top' );
?>

                    <div class="postbox " id="dashboard_quick_press">
                        <h3 class="hndle"><span><?php _e( 'Module Status', 'ub' ); ?></span></h3>
                        <div class="inside">
                            <?php $this->show_module_status(); ?>
                            <br class="clear">
                        </div>
                    </div>

<?php
			do_action( 'ultimatebranding_dashboard_page_right' );
?>

                </div>
            </div>

            <div style="display: none; width: 49%;" class="postbox-container">
                <div class="meta-box-sortables ui-sortable" id="column3-sortables" style="">
                </div>
            </div>

            <div style="display: none; width: 49%;" class="postbox-container">
                <div class="meta-box-sortables ui-sortable" id="column4-sortables" style="">
                </div>
            </div>
        </div>

        <div class="clear"></div>
    </div>

<?php
		}

		function show_module_status() {

			global $action, $page;
?>
    <table class='widefat'>
        <thead>
        <th><?php _e( 'Available Modules', 'ub' ); ?></th>
        <th><a href='<?php echo wp_nonce_url( '?page=' . $page . '&amp;action=enableallmodules', 'enable-all-modules' ); ?>'><?php _e( 'Enable', 'ub' ); ?></a> / <a href='<?php echo wp_nonce_url( '?page=' . $page . '&amp;action=disableallmodules', 'disable-all-modules' ); ?>'><?php _e( 'Disable All', 'ub' ); ?></a></th>
    </thead>
    <tfoot>
    <th><?php _e( 'Available Modules', 'ub' ); ?></th>
    <th><a href='<?php echo wp_nonce_url( '?page=' . $page . '&amp;action=enableallmodules', 'enable-all-modules' ); ?>'><?php _e( 'Enable', 'ub' ); ?></a> / <a href='<?php echo wp_nonce_url( '?page=' . $page . '&amp;action=disableallmodules', 'disable-all-modules' ); ?>'><?php _e( 'Disable All', 'ub' ); ?></a></th>
    </tfoot>
    <tbody>
<?php
if ( ! empty( $this->modules ) ) {

	$default_headers = array(
		'Name' => 'Plugin Name',
		'Author' => 'Author',
		'Description' => 'Description',
		'AuthorURI' => 'Author URI',
	);

	$mods = array();
	foreach ( $this->modules as $module => $plugin ) {
		/**
					 * Check file exists
					 *
					 * @since 1.8.6
					 */
		$file = ub_files_dir( 'modules/' . $module );
		if ( ! is_file( $file ) || ! is_readable( $file ) ) {
			continue;
		}
		$module_data = get_file_data( $file, $default_headers, 'plugin' );
		$module_data['module'] = $module;
		$module_data['plugin'] = $plugin;
		$mods[ $module_data['Name'] ] = $module_data;
	}
	ksort( $mods );

	foreach ( $mods as $module_name => $module_data ) {
		$module = $module_data['module'];
		$plugin = $module_data['plugin'];
		// deactivate any conflisting plugins
		if ( in_array( $module, array_keys( $this->plugin_msg ) ) ) {
			$this->deactivate_module( $module );
		}
		$is_active = ub_is_active_module( $module );

		$url = $this->get_nonce_url( $module );
		printf( '<tr class="%s">', esc_attr( $is_active? 'activemodule':'inactivemodule' ) );
		echo '<td>';
		echo $module_data['Name'];
		echo '</td>';
		echo '<td>';
		printf(
			'<a href="%s" class="%s">%s</a>',
			esc_url( $url ),
			esc_attr( $is_active? 'disblelink':'enablelink' ),
			$is_active? esc_html__( 'Disable', 'ub' ):esc_attr__( 'Enable', 'ub' )
		);
		echo '</td>';
		echo '</tr>';

	}
} else {
?>
<tr>
<td colspan='2'><?php _e( 'No modules avaiable.', 'ub' ); ?></td>
</tr>
<?php
}
?>
    </tbody>
    </table>

<?php
		}


		/**
		 * Renders $file and returns | prints content.
		 *
		 *
		 * @since 1.6.3
		 *
		 * @param $file file name without extension name
		 * @param array $params parameters to pass to the file
		 * @param bool $return on true rendered file will be returned | rendered file will be echoed out
		 * @return string
		 */
		public function render( $module_name, $file, $params = array(), $return = false ) {
			global $UB_dir;
			/**
			 * assign $file to a variable which is unlikely to be used by users of the method
			 */
			$UB_Rendered_To_Be_File_Name = $file;
			extract( $params, EXTR_OVERWRITE );
			if ( $return ) {
				ob_start();
			}

			include( $UB_dir . 'ultimate-branding-files/modules/' . $module_name . '-files/views/' . $UB_Rendered_To_Be_File_Name . '.php' );

			if ( $return ) {
				return ob_get_clean();
			}

			if ( ! empty( $params ) ) {
				foreach ( $params as $param ) {
					unset( $param );
				}
			}
		}

		protected function register_js( $module_name, $file ) {
			$this->js_files[ $module_name ][] = $file;
			add_action( 'load-toplevel_page_branding', array( $this, 'register_modules_js' ) );
		}

		protected function get_enqueue_handle( $module_name, $file_name ) {
			return $module_name . '-' . str_replace( '.', '-', $file_name );
		}
		public function register_modules_js() {
			foreach ( $this->js_files as $module_name => $files ) {
				foreach ( $files as $file_name ) {
					$file_path = ub_files_url( 'modules/' . $module_name . '-files/js/'. $file_name . '.js' );
					wp_enqueue_script( $this->get_enqueue_handle( $module_name, $file_name ), $file_path, array(), $this->build, true );
				}
			}
		}

		protected function register_css( $module_name, $file ) {
			$this->css_files[ $module_name ][] = $file;
			add_action( 'load-toplevel_page_branding', array( $this, 'register_modules_css' ) );
		}

		public function register_modules_css() {
			foreach ( $this->css_files as $module_name => $files ) {
				foreach ( $files as $file_name ) {
					$file_path = ub_files_url( 'modules/' . $module_name . '-files/css/'. $file_name . '.css' );
					wp_enqueue_style( $this->get_enqueue_handle( $module_name, $file_name ), $file_path, array(), $this->build );
				}
			}
		}

		public function handle_admin_message_panel() {
			$title = __( 'Admin Message', 'ub' );
			$this->panel( $title, 'admin_message', true );
			return;

			global $action, $page;
			$messages = array();
			$messages[1] = __( 'Settings saved.', 'ub' );
			$messages[2] = __( 'Settings cleared.', 'ub' );
			$messages[3] = __( 'Settings could not be saved.', 'ub' );

			$messages = apply_filters( 'ultimatebranding_settings_admin_message_messages', $messages );
?>
    <h2><?php _e( 'Admin Message', 'ub' ); ?></h2>

<?php
if ( isset( $_GET['msg'] ) && (int) $_GET['msg'] !== 3 ) {
?>
<div id="message" class="updated fade"><p><?php echo $messages[ (int) $_GET['msg'] ] ?></p></div>
<?php
} elseif ( isset( $_GET['msg'] ) && (int) $_GET['msg'] === 3 ) { ?>
                    <div class="error fade"><p><?php echo $messages[ (int) $_GET['msg'] ] ?></p></div>
<?php
}
?>
    <div id="poststuff" class="metabox-holder m-settings">
        <form action='' method="post">

            <input type='hidden' name='page' value='<?php echo $page; ?>' />
            <input type='hidden' name='action' value='process' />
<?php
			wp_nonce_field( 'ultimatebranding_settings_admin_message' );
			do_action( 'ultimatebranding_settings_admin_message' );
?>

<?php
if ( has_filter( 'ultimatebranding_settings_admin_message_process' ) ) {
?>
<p class="submit">
<input class="button button-primary" type="submit" name="Submit" value="<?php _e( 'Save Changes', 'admin_message' ) ?>" />
<input class="button button-secondary" type="submit" name="Reset" value="<?php _e( 'Reset', 'admin_message' ) ?>" />
</p>
<?php
}
?>

        </form>
    </div>
<?php
		}


		/**
		 * Custom MS emails
		 *
		 * @since 1.8.6
		 */
		function handle_custom_ms_register_emails_panel() {
			$title = __( 'Custom MS Registered emails', 'ub' );
			$this->panel( $title, 'custom_ms_register_emails' );
		}

		/**
		 * Export & Import screen
		 *
		 * @since 1.8.6
		 */
		function handle_export_import_panel() {
			$title = __( 'Export & Import Ultimate Branding configuration', 'ub' );
			$this->panel( $title, 'export_import', false );
		}


		/**
		 * Link Manager screen
		 *
		 * @since 1.8.6
		 */
		function handle_link_manager_panel() {
			$title = __( 'Link Manager', 'ub' );
			$this->panel( $title, 'link_manager' );
		}

		/**
		 * Common!
		 *
		 * @since 1.8.6
		 */
		private function panel( $tab ) {
			global $page;
			$panel = preg_replace( '/-/', '_', 'ultimatebranding_settings_'.$tab );
			$modules = $this->get_modules_by_tab( $tab );
			$show = true;
			$inactive_modules = '';
			foreach ( $modules as $key => $module ) {
				$is_active = ub_is_active_module( $module['key'] );
				if ( $is_active ) {
					if ( $show ) {
						$action = preg_replace( '/-/', '_', 'ultimatebranding_settings_'.$module['tab'] );
						$messages = apply_filters( $action.'_messages', $this->messages );
						/**
						 * admin page title
						 */
						echo '<h1>';
						echo $module['page_title'];
						do_action( 'ultimatebranding_settings_after_title' );
						do_action( $panel.'_after_title' );
						echo '</h1>';
						/**
						 * message
						 */
						if ( isset( $_GET['msg'] ) ) {
							$msg = $_GET['msg'];
							$msg = isset( $messages[ $msg ] ) ? $msg : 'fail';
							echo '<div id="message" class="updated fade"><p>' . $messages[ $_GET['msg'] ] . '</p></div>';
							$_SERVER['REQUEST_URI'] = UB_Help::remove_query_arg( array( 'msg' ), $_SERVER['REQUEST_URI'] );
						}
						echo  '<div id="poststuff" class="metabox-holder m-settings">';
						printf( '<form action="" method="post" enctype="multipart/form-data" class="tab-%s">', esc_attr( $tab ) );
						printf( '<input type="hidden" name="tab" value="%s" id="ub-tab"/>', esc_attr( $tab ) );
						printf( '<input type="hidden" name="page" value="%s" />', esc_attr( $page ) );
						echo '<input type="hidden" name="action" value="process" />';
						wp_nonce_field( 'boxes', 'postboxes_nonce', false );

						/**
						 * nonce
						 */
						wp_nonce_field( $action );
						do_action( $action );
						/**
						 * submit button
						 */
						$filter = $action.'_process';
						if (
							has_filter( $filter )
							&& apply_filters( 'ultimatebranding_settings_panel_show_submit', true )
						) {
							$this->button_save();
						}
						echo '</form></div>';
						$show = false;
					}
				} else {
					$inactive_modules .= $this->module_is_not_active_message( $module );
				}
			}
			echo $inactive_modules;
		}

		/**
		 * Print button save.
		 *
		 * @since 1.8.4
		 */
		public function button_save() {
			printf(
				'<p class="submit"><input type="submit" name="Submit" class="button-primary" value="%s" /></p>',
				esc_attr__( 'Save Changes', 'ub' )
			);
		}

		/**
		 * Print header
		 *
		 * @since 1.8.4
		 *
		 * @param string $title Title of the current admin page.
		 */
		public function header( $title ) {
		}

		/**
		 * Sort helper for menu.
		 *
		 * @since 1.8.6
		 */
		private function sort_admin_menu( $a, $b ) {
			if ( 'branding' == $a[2] ) {
				return -1;
			}
			return strcasecmp( $a[0], $b[0] );
		}

		/**
		 * Sort helper for tab menu.
		 *
		 * @since 1.8.8
		 */
		private function sort_configuration( $a, $b ) {
			if ( isset( $a['menu_title'] ) && isset( $b['menu_title'] ) ) {
				return strcasecmp( $a['menu_title'], $b['menu_title'] );
			}
			return 0;
		}

		/**
		 * Should I show menu in admin subsites?
		 *
		 * @since 1.8.6
		 */
		private function check_show_in_subsites() {
			if ( is_multisite() && is_network_admin() ) {
				return true;
			}
			$modules = get_ub_activated_modules();
			if ( empty( $modules ) ) {
				return false;
			}
			foreach ( $modules as $module => $state ) {
				if ( 'yes' != $state ) {
					continue;
				}
				if (
					isset( $this->configuration[ $module ] )
					&& isset( $this->configuration[ $module ]['show-on-single'] )
					&& $this->configuration[ $module ]['show-on-single']
				) {
					return true;
				}
			}
			return false;
		}

		/**
		 * Set configuration
		 *
		 * @since 1.8.7
		 */
		private function set_configuration() {
			$this->configuration = array(
				'admin-footer-text.php' => array(
					'module' => 'admin-footer-text/admin-footer-text.php',
					'tab' => 'footer',
					'page_title' => __( 'Footer Content', 'ub' ),
					'title' => __( 'Admin Footer Content', 'ub' ),
				),
				'admin-help-content.php' => array(
					'module' => 'admin-help-content/admin-help-content.php',
					'tab' => 'help',
					'page_title' => __( 'Help Content', 'ub' ),
				),
				'custom-admin-bar.php' => array(
					'module' => 'custom-admin-bar/custom-admin-bar.php',
					'tab' => 'adminbar',
					'page_title' => __( 'Admin Bar', 'ub' ),
				),
				'admin-bar-logo.php' => array(
					'module' => 'admin-bar-logo.php',
					'tab' => 'adminbar',
					'page_title' => __( 'Admin Bar', 'ub' ),
					'title' => __( 'Admin Bar Logo', 'ub' ),
				),
				'custom-dashboard-welcome.php' => array(
					'module' => 'custom-dashboard-welcome.php',
					'tab' => 'widgets',
					'page_title' => __( 'Widgets', 'ub' ),
					'title' => __( 'Dashboard Welcome', 'ub' ),
				),
				'custom-email-from.php' => array(
					'module' => 'custom-email-from/custom-email-from.php',
					'tab' => 'from-email',
					'page_title' => __( 'E-mail From', 'ub' ),
				),
				'global-footer-content.php' => array(
					'module' => 'global-footer-content/global-footer-content.php',
					'tab' => 'footer',
					'page_title' => __( 'Footer Content', 'ub' ),
					'title' => __( 'Global Footer Content', 'ub' ),
				),
				'global-header-content.php' => array(
					'module' => 'global-header-content/global-header-content.php',
					'tab' => 'header',
					'page_title' => __( 'Header Content', 'ub' ),
				),
				'rebranded-meta-widget.php' => array(
					'module' => 'rebranded-meta-widget/rebranded-meta-widget.php',
					'tab' => 'widgets',
					'page_title' => __( 'Widgets', 'ub' ),
					'title' => __( 'Rebranded Meta Widget', 'ub' ),
				),
				'remove-dashboard-link-for-users-without-site.php' => array(
					'module' => 'remove-dashboard-link-for-users-without-site/remove-dashboard-link-for-users-without-site.php',
				),
				'remove-permalinks-menu-item.php' => array(
					'module' => 'remove-permalinks-menu-item/remove-permalinks-menu-item.php',
					'tab' => 'permalinks',
					'page_title' => __( 'Permalinks Menu', 'ub' ),
				),
				'remove-wp-dashboard-widgets.php' => array(
					'module' => 'remove-wp-dashboard-widgets/remove-wp-dashboard-widgets.php',
					'tab' => 'widgets',
					'page_title' => __( 'Widgets', 'ub' ),
					'title' => __( 'Remove WP Dashboard Widgets', 'ub' ),
				),
				'signup-password.php' => array(
					'module' => '/signup-password/signup-password.php',
					'tab' => 'signuppassword',
					'page_title' => __( 'Signup Password', 'ub' ),
				),
				'site-generator-replacement.php' => array(
					'module' => 'site-generator-replacement/site-generator-replacement.php',
					'tab' => 'sitegenerator',
					'page_title' => __( 'Site Generator', 'ub' ),
				),
				'site-wide-text-change.php' => array(
					'module' => 'site-wide-text-change/site-wide-text-change.php',
					'tab' => 'textchange',
					'page_title' => __( 'Network Wide Text Change', 'ub' ),
					'menu_title' => __( 'Text Change', 'ub' ),
				),
				'custom-admin-css.php' => array(
					'module' => 'custom-admin-css.php',
					'tab' => 'css',
					'menu_title' => __( 'CSS', 'ub' ),
					'page_title' => __( 'Cascading Style Sheets', 'ub' ),
				),
				'custom-login-css.php' => array(
					'module' => 'custom-login-css.php',
					'tab' => 'css',
					'page_title' => __( 'Cascading Style Sheets', 'ub' ),
					'menu_title' => __( 'CSS', 'ub' ),
				),
				'ultimate-color-schemes.php' => array(
					'module' => 'ultimate-color-schemes.php',
					'tab' => 'ultimate-color-schemes',
					'page_title' => __( 'Color Schemes', 'ub' ),
				),
				'admin-message.php' => array(
					'module' => 'admin-message.php',
					'tab' => 'admin-message',
					'page_title' => __( 'Admin Message', 'ub' ),
				),
				/**
				 * Images
				 */
				'favicons.php' => array(
					'module' => 'favicons.php',
					'tab' => 'images',
					'page_title' => __( 'Images', 'ub' ),
					'title' => __( 'Multisite Favicons', 'ub' ),
				),
				'login-image.php' => array(
					'module' => 'login-image/login-image.php',
					'tab' => 'images',
					'page_title' => __( 'Images', 'ub' ),
					'title' => __( 'Login Image', 'ub' ),
				),
				/**
				 * Email Template
				 *
				 * @since 1.8.4
				 */
				'htmlemail.php' => array(
					'module' => 'htmlemail',
					'tab' => 'htmlemail',
					'page_title' => __( 'Email Template', 'ub' ),
				),
				/**
				 * Custom Login Screen
				 *
				 * @since 1.8.5
				 */
				'custom-login-screen.php' => array(
					'module' => 'custom-login-screen.php',
					'tab' => 'login-screen',
					'page_title' => __( 'Login screen', 'ub' ),
				),
				/**
				 * Custom MS email content
				 *
				 * @since 1.8.6
				 */
				'custom-ms-register-emails.php' => array(
					'module' => 'custom-ms-register-emails.php',
					'network-only' => true,
					'tab' => 'custom-ms-register-emails',
					'page_title' => __( 'MultiSite Registration emails', 'ub' ),
					'menu_title' => __( 'Registration emails', 'ub' ),
				),
				/**
				 * Export - Import
				 *
				 * @since 1.8.6
				 */
				'export-import.php' => array(
					'module' => 'export-import.php',
					'tab' => 'export-import',
					'page_title' => __( 'Export & Import Ultimate Branding configuration', 'ub' ),
					'menu_title' => __( 'Export/Import', 'ub' ),
				),
				'admin-panel-tips/admin-panel-tips.php' => array(
					'module' => 'admin-panel-tip',
					'show-on-single' => true,
					'tab' => 'admin-panel-tips',
					'page_title' => __( 'Admin Panel Tips', 'ub' ),
					'menu_title' => __( 'Tips', 'ub' ),
				),
				/**
				 * Comments Control
				 *
				 * @since 1.8.6
				 */
				'comments-control.php' => array(
					'module' => 'comments-control.php',
					'network-only' => true,
					'tab' => 'comments-control',
					'page_title' => __( 'Comments Control', 'ub' ),
				),
				/**
				 * Dashboard Feeds
				 *
				 * @since 1.8.6
				 */
				'dashboard-feeds/dashboard-feeds.php' => array(
					'module' => 'dashboard-feeds',
					'network-only' => true,
					'tab' => 'dashboard-feeds',
					'page_title' => __( 'Dashboard Feeds', 'ub' ),
				),
				/**
				 * Link Manager
				 *
				 * @since 1.8.6
				 */
				'link-manager.php' => array(
					'module' => 'link-manager',
					'tab' => 'link-manager',
					'page_title' => __( 'Link Manager', 'ub' ),
				),
			);
			/**
			 * add key to data
			 */
			foreach ( $this->configuration as $key => $data ) {
				$this->configuration[ $key ]['key'] = $key;
				if ( isset( $data['page_title'] ) && ! isset( $data['menu_title'] ) ) {
					$this->configuration[ $key ]['menu_title'] = $data['page_title'];
				}
			}
			uasort( $this->configuration, array( $this, 'sort_configuration' ) );
		}

		/**
		 * Get module by tab.
		 *
		 * @since 1.8.8
		 *
		 * @param string $tab Tab.
		 */
		private function get_modules_by_tab( $tab = null ) {
			if ( null == $tab ) {
				$tab = get_query_var( 'tab' );
			}
			$modules = array();
			$tab = preg_replace( '/_/', '-', $tab );
			foreach ( $this->configuration as $key => $module ) {
				if ( ! isset( $module['tab'] ) ) {
					continue;
				}
				if ( $tab == $module['tab'] ) {
					$modules[ $key ] = $module;
				}
			}
			return $modules;
		}

		/**
		 * get nonced url
		 *
		 * @since 1.8.8
		 */
		private function get_nonce_url( $module ) {
			global $page;
			$is_active = ub_is_active_module( $module );
			$url = add_query_arg(
				array(
					'page' => $page,
					'action' => $is_active? 'disable':'enable',
					'module' => $module,
				),
				is_network_admin()? network_admin_url( 'admin.php' ) : admin_url( 'admin.php' )
			);
			$nonce_action = sprintf( '%s-module-%s', $is_active? 'disable':'enable', $module );
			$url = wp_nonce_url( $url, $nonce_action );
			return $url;
		}

		/**
		 * get inactive module message
		 *
		 * @since 1.8.8
		 */
		private function module_is_not_active_message( $module ) {
			$content = '';
			$title = isset( $module['title'] )? $module['title']:$module['page_title'];
			$content .= sprintf( '<h1>%s</h1>', esc_html( $title ) );
			$content .= '<div class="ub-module-info">';
			$content .= sprintf( '<h2>%s</h2>', esc_html__( 'This module is not active!', 'ub' ) );
			$content .= '<p>';
			$content .= sprintf(
				__( 'Turn on %s module.', 'ub' ),
				sprintf(
					'<a href="%s">%s</a>',
					$this->get_nonce_url( $module['key'] ),
					esc_html( $title )
				)
			);
			$content .= '</p>';
			$content .= '</div>';
			return $content;
		}

		/**
		 * Get base url
		 *
		 * @since 1.8.8
		 */
		private function get_base_url() {
			global $page;
			if ( empty( $page ) ) {
				if ( isset( $_REQUEST['page'] ) ) {
					$page = esc_html( $_REQUEST['page'] );
				}
			}
			$base_url = add_query_arg(
				array(
					'page' => $page,
				),
				is_network_admin()? network_admin_url( 'admin.php' ):admin_url( 'admin.php' )
			);
			return $base_url;
		}

		/**
		 * fake functions to build admin submenu
		 */
		public function handle_adminbar_panel() {}
		public function handle_admin_menu_panel() {}
		public function handle_admin_panel_tips_panel() {}
		public function handle_comments_control_panel() {}
		public function handle_css_panel() {}
		public function handle_dashboard_feeds_panel() {}
		public function handle_footer_panel() {}
		public function handle_from_email_panel() {}
		public function handle_header_panel() {}
		public function handle_help_panel() {}
		public function handle_htmlemail_panel() {}
		public function handle_images_panel() {}
		public function handle_login_screen_panel() {}
		public function handle_permalinks_panel() {}
		public function handle_signuppassword_panel() {}
		public function handle_sitegenerator_panel() {}
		public function handle_textchange_panel() {}
		public function handle_ultimate_color_schemes_panel() {}
		public function handle_widgets_panel() {}
	}
}