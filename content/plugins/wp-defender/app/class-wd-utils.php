<?php

/**
 * Collections of useful function
 * @author: Hoang Ngo
 */
class WD_Utils {
	/**
	 * @param $key
	 * @param string $default
	 *
	 * @return mixed|void
	 */
	public static function get_setting( $key, $default = '' ) {
		$settings = get_site_option( 'wp_defender', array() );

		$keys    = explode( '->', $key );
		$keys    = array_map( 'trim', $keys );
		$setting = self::arr_get_value( $key, $settings, $default );

		if ( ( is_array( $setting ) && empty( $setting ) ) || ( ! is_array( $setting ) && strlen( $setting ) == 0 ) ) {
			//load default
			$defaults = self::get_default_settings();
			if ( isset( $defaults[ $key ] ) ) {
				$setting = $defaults[ $key ];
			}
		}

		return apply_filters( 'wd_setting_' . implode( '', $keys ), wp_unslash( $setting ), $default );
	}

	/**
	 * @param $key
	 * @param $array
	 * @param bool|false $default
	 *
	 * @return bool|null
	 */
	public static function arr_get_value( $key, $array, $default = false ) {
		$value = self::arr_search( $array, $key );

		return ( is_null( $value ) ) ? $default : $value;
	}

	/**
	 * @param $array
	 * @param $path
	 *
	 * @return null
	 */
	public static function arr_search( $array, $path ) {
		$keys = explode( '->', $path );
		$keys = array_map( 'trim', $keys );

		for ( $i = $array; ( $key = array_shift( $keys ) ) !== null; $i = $i[ $key ] ) {
			if ( ! isset( $i[ $key ] ) ) {
				return null;
			}
		}

		return $i;
	}

	/**
	 * @param $key
	 * @param $value
	 *
	 * @return bool
	 */
	public static function update_setting( $key, $value ) {
		$settings = get_site_option( 'wp_defender', array() );
		self::push_to_array( $settings, $key, $value );

		return update_site_option( 'wp_defender', $settings );
	}

	/**
	 * Return tree of files from the path.
	 * $exclude & $include is an array, and accept parameter. Please note that, include will take over exlcude if same
	 * 'ext'=>array('jpg','gif') file extension you don't want appear in the result
	 * 'path'=>array('/tmp/file1.txt','/tmp/file2') absolute path to files
	 * 'dir'=>array('/tmp/','/dir/') absolute path to the directory you dont want to include files
	 * 'filename'=>array('abc*') file name you don't want to include, can be regex,
	 *
	 * @param $path
	 * @param bool|true $include_file
	 * @param bool|true $include_dir
	 * @param array $exclude
	 * @param array $include
	 * @param bool|true $is_recursive
	 * @param bool|false $max_size
	 *
	 * @return array
	 */
	public static function get_dir_tree( $path, $include_file = true, $include_dir = true, $exclude = array(), $include = array(), $is_recursive = true, $max_size = false ) {
		if ( ! class_exists( 'WD_Dir_Tree', false ) ) {
			include WP_CONTENT_DIR . '/plugins/wp-defender/app/component/class-wd-dir-tree.php';
		}
		$tv = new WD_Dir_Tree( $path, $include_file, $include_dir, $include, $exclude, $is_recursive );
		if ( $max_size != false ) {
			$tv->max_filesize = $max_size;
		}
		$result = $tv->get_dir_tree();
		unset( $v );

		return $result;
	}

	/**
	 * Store default settings
	 * @return array
	 */
	public static function get_default_settings() {
		if ( ! class_exists( 'WD_Scan_Api' ) ) {
			include_once wp_defender()->get_plugin_path() . 'app/module/scan-module/component/class-wd-scan-api.php';
		}
		$setting = apply_filters( 'wd_default_settings', array(
			'use_' . WD_Scan_Api::SCAN_CORE_INTEGRITY . '_scan'  => true,
			'use_' . WD_Scan_Api::SCAN_VULN_DB . '_scan'         => WD_Utils::get_dev_api() == false ? false : true,
			'use_' . WD_Scan_Api::SCAN_SUSPICIOUS_FILE . '_scan' => WD_Utils::get_dev_api() == false ? false : true,
			'completed_scan_email_subject'                       => __( 'Scan of {SITE_URL} complete. {ISSUES_COUNT} issues found.', wp_defender()->domain ),
			'completed_scan_email_content_error'                 => __( 'Hi {USER_NAME},

WP Defender here, reporting back from the front.

I\'ve finished scanning your site for vulnerabilities and I found {ISSUES_COUNT} issues that you should take a closer look at!
{ISSUES_LIST}

<a href="{SCAN_PAGE_LINK}">Follow me back to the lair and let\'s get you patched
    up.</a>

Stay Safe,
WP Defender
Official WPMU DEV Superhero', wp_defender()->domain ),
			'completed_scan_email_content_success'               => __( 'Hi {USER_NAME},

WP Defender here, reporting back from the front.

I\'ve finished scanning your site for vulnerabilities and I found nothing - well done for running such a tight ship!

Keep up the good work! With regular security scans and a well-hardened installation you\'ll be just fine.

Stay Safe,
WP Defender
Official WPMU DEV Superhero', wp_defender()->domain ),
			//'log_directory'                        => str_replace( ABSPATH, '', wp_defender()->get_plugin_path() . 'vault/' ),
			//'exclude_scanning_dir'         => array(),
			'include_file_extension'                             => array( 'php' ),
			//'exclude_file_extension'                             => self::exclude_extensions(),
			'max_file_size'                                      => 10,
			/*'files_chunk'                          => array(
				'label'       => __( "Maximum amount of files the plugin can handle at a time", wp_defender()->domain ),
				'value'       => '500',
				'description' => __( "If your site has heavily traffic, lowering this amount (50-200) will improve performance and resource usage. If not, leave by default or larger.", wp_defender()->domain )
			)*/
		) );

		$plugin_settings = get_site_option( 'wp_defender' );
		if ( ! is_array( $plugin_settings ) || ! isset( $plugin_settings['recipients'] ) ) {
			//this mean the plugin just new
			$user_id = get_current_user_id();
			if ( ( is_multisite() && user_can( $user_id, 'manage_network_options' ) )
			     || ( ! is_multisite() && user_can( $user_id, 'manage_options' ) )
			) {
				$setting['recipients'] = array( $user_id );
			}
		}

		return $setting;
	}

	/**
	 *
	 */
	public static function settle_settings() {
		$default         = self::get_default_settings();
		$plugin_settings = get_site_option( 'wp_defender' );
		if ( $plugin_settings == false ) {
			update_site_option( 'wp_defender', $default );
		}
		if ( ! isset( $plugin_settings['recipients'] ) || empty( $plugin_settings['recipients'] ) ) {
			$admins = get_users( array(
				'role' => 'administrator'
			) );
			if ( count( $admins ) ) {
				$admin                         = array_shift( $admins );
				$plugin_settings['recipients'] = array( $admin->ID );
			}
		}
	}

	/**
	 * @param $theme
	 *
	 * @return bool
	 * @since 1.0.2
	 */
	public static function update_theme( $theme ) {
		if ( ! class_exists( 'Theme_Upgrader' ) ) {
			require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
		}
		$skin     = new WD_Theme_Upgrade_Skin( compact( 'title', 'nonce', 'url', 'theme' ) );
		$upgrader = new Theme_Upgrader( $skin );
		$upgrader->upgrade( $theme );
		if ( is_wp_error( $skin->result ) ) {
			return $skin->result;
		}

		return true;
	}

	/**
	 * @param $key
	 *
	 * @return null
	 */
	public static function get_setting_label( $key ) {
		$settings = self::get_default_settings();
		if ( isset( $settings[ $key ] ) ) {
			return $settings[ $key ]['label'];
		}

		return null;
	}

	/**
	 * @param $key
	 *
	 * @return null
	 */
	public static function get_setting_description( $key ) {
		$settings = self::get_default_settings();
		if ( isset( $settings[ $key ] ) ) {
			return $settings[ $key ]['description'];
		}

		return null;
	}

	/**
	 * Settings for AutoScan
	 * @return array
	 */
	public static function get_automatic_scan_settings() {
		$args = array(
			'time'      => WD_Utils::get_setting( 'scan->schedule->time', '04:00' ),
			'day'       => WD_Utils::get_setting( 'scan->schedule->day', 'Sunday' ),
			//'email'     => WD_Utils::get_setting( 'scan->schedule->email', get_option( 'admin_email' ) ),
			'frequency' => WD_Utils::get_setting( 'scan->schedule->frequency', '7' ),
		);

		return $args;
	}

	/**
	 * @param $array
	 * @param $key_string
	 * @param $value
	 */
	public static function push_to_array( &$array, $key_string, $value ) {
		$keys   = explode( '->', $key_string );
		$branch = &$array;

		while ( count( $keys ) ) {
			$key = array_shift( $keys );

			if ( ! is_array( $branch ) ) {
				$branch = array();
			}

			$branch = &$branch[ $key ];
		}

		$branch = $value;
	}

	/**
	 * @param $key
	 * @param bool|false $default
	 *
	 * @return bool|null
	 */
	public static function http_get( $key, $default = false ) {
		return self::arr_get_value( $key, $_GET, $default );
	}

	/**
	 * @param $key
	 * @param bool|false $default
	 *
	 * @return bool|null
	 */
	public static function http_post( $key, $default = false ) {
		return self::arr_get_value( $key, $_POST, $default );
	}

	/**
	 * @return bool
	 */
	public static function is_nginx() {
		//fire a request to static content to determine
		global $is_nginx;

		return $is_nginx;
	}

	/**
	 * @param $url
	 *
	 * @return string
	 * @since 1.0.2
	 */
	public static function determine_server( $url ) {
		$server_type = get_site_transient( 'wd_util_server' );
		if ( ! is_array( $server_type ) ) {
			$server_type = array();
		}

		if ( isset( $server_type[ $url ] ) && ! empty( $server_type[ $url ] ) ) {
			return strtolower( $server_type[ $url ] );
		}

		//url should be end with php
		global $is_apache, $is_nginx, $is_IIS, $is_iis7;

		$server = null;

		if ( $is_nginx ) {
			$server = 'nginx';
		} elseif ( $is_apache ) {
			//case the url is detecting php file
			if ( pathinfo( $url, PATHINFO_EXTENSION ) == 'php' ) {
				$server = 'apache';
			} else {
				//so the server software is apache, let see what the header return
				$request = wp_remote_head( $url, array( 'user-agent' => $_SERVER['HTTP_USER_AGENT'] ) );
				$server  = wp_remote_retrieve_header( $request, 'server' );
				$server  = explode( '/', $server );
				if ( strtolower( $server[0] ) == 'nginx' ) {
					//proxy case
					$server = 'nginx';
				} else {
					$server = 'apache';
				}
			}
		} elseif ( $is_iis7 || $is_IIS ) {
			$server = 'iis';
		}

		if ( is_null( $server ) ) {
			//if fall in here, means there is st unknowed.
			$request = wp_remote_head( $url, array( 'user-agent' => $_SERVER['HTTP_USER_AGENT'] ) );
			$server  = wp_remote_retrieve_header( $request, 'server' );
			$server  = explode( '/', $server );
			$server  = $server[0];
		}

		$server_type[ $url ] = $server;
		//cache for an hour
		set_site_transient( 'wd_util_server', $server_type, 3600 );

		return $server;
	}

	public static function remove_folder( $folder ) {
		$files = self::get_dir_tree( $folder, true, false );
		foreach ( $files as $file ) {
			unlink( $file );
		}

		$folders = self::get_dir_tree( $folder, false, true );
		foreach ( $folders as $f ) {
			rmdir( $f );
		}
	}

	/**
	 * This will return WordPress file, it will look into wp repo for the file
	 *
	 * @param $file
	 *
	 * @return bool|string
	 */
	public static function get_wordpress_file( $file ) {
		global $wp_version;
		$url      = "https://core.svn.wordpress.org/tags/$wp_version/" . $file;
		$response = wp_remote_get( $url );

		// Check for error
		if ( is_wp_error( $response ) ) {
			return $response;
		}

		if (
			'OK' !== wp_remote_retrieve_response_message( $response )
			OR 200 !== wp_remote_retrieve_response_code( $response )
		) {
			return new WP_Error( wp_remote_retrieve_response_code( $response ), wp_remote_retrieve_response_message( $response ) );
		} else {
			$data = wp_remote_retrieve_body( $response );

			return $data;
		}

	}

	/**
	 * A helper function, return all functions call inside a file
	 *
	 * @param $content
	 *
	 * @return array
	 */
	public static function get_functions_of_file( $content ) {
		$tokens    = token_get_all( $content );
		$functions = array();
		foreach ( $tokens as $token ) {
			if ( isset( $token[0] ) && is_long( $token[0] )
			     && in_array( token_name( $token[0] ), array(
					'T_STRING',
					'T_EVAL',
				) )
			) {
				$functions[] = array(
					'type'     => token_name( $token[0] ),
					'function' => $token[1],
					'line'     => $token[2]
				);
			}

		}

		return $functions;
	}

	/**
	 * Get update info of a plugin
	 *
	 * @param $slug
	 */
	public static function is_plugin_update_available( $slug ) {
		wp_update_plugins();
		$plugins = get_site_transient( 'update_plugins' );
		foreach ( (array) $plugins->no_update as $plugin ) {
			if ( $plugin->plugin == $slug ) {
				return $plugin;
			}
		}

		return null;
	}

	/**
	 * just a helper function for debug
	 *
	 * @param $file
	 * @param bool|false $format_short_open
	 *
	 * @return mixed|null|string
	 */
	public static function get_php_content( $file, $format_short_open = false ) {
		$content = '';
		if ( file_exists( $file ) ) {
			$content = file_get_contents( $file );
		}

		if ( $format_short_open ) {
			$content = preg_replace( '/<\?(?!(php|=|xml))(\s|\t|\n)/', '<?php' . PHP_EOL, $content );
		}

		return $content;
	}

	/**
	 * @return string|void
	 */
	public static function get_display_name( $user_id = null ) {
		if ( ! is_user_logged_in() && is_null( $user_id ) ) {
			return __( "Guest", wp_defender()->domain );
		}

		if ( is_null( $user_id ) ) {
			$user_id = get_current_user_id();
		}

		$userdata = get_userdata( $user_id );
		$fullname = trim( $userdata->first_name . ' ' . $userdata->last_name );
		if ( empty( $fullname ) ) {
			$fullname = $userdata->display_name;
		}

		return $fullname;
	}

	/**
	 * Check if WPMUDEV Dashboard installed, return version, else return false
	 * @return bool|string
	 */
	public static function is_wpmudev_dashboard_installed() {
		global $wpmudev_un;
		if ( $wpmudev_un instanceof WPMUDEV_Dashboard ) {
			return $wpmudev_un->version;
		}

		//check if this is new
		if ( class_exists( 'WPMUDEV_Dashboard' ) ) {
			return WPMUDEV_Dashboard::$version;
		}

		return false;
	}

	/**
	 * @return bool|string
	 */
	public static function get_dev_api() {
		if ( ( $version = self::is_wpmudev_dashboard_installed() ) !== false ) {
			if ( version_compare( $version, '4.0.0' ) >= 0 ) {
				//this is version 4+
				//instanize once
				WPMUDEV_Dashboard::instance();
				$membership_type = WPMUDEV_Dashboard::$api->get_membership_type( $dummy );
				if ( $membership_type == 'full' ) {
					$api_key = WPMUDEV_Dashboard::$api->get_key();

					return $api_key;
				}
			} else {
				global $wpmudev_un;
				$api_key = $wpmudev_un->get_apikey();

				return $api_key;
			}
		}

		return false;
	}

	/**
	 * Get full name of an account
	 * @return string|void
	 */
	public static function get_full_name( $email = null ) {
		$fullname = '';
		if ( ! is_null( $email ) ) {
			$user = get_user_by( 'email', $email );
			if ( is_object( $user ) ) {
				$fullname = trim( $user->first_name . ' ' . $user->last_name );
				if ( empty( $fullname ) ) {
					$fullname = $user->display_name;
				}
			} else {
				$fullname = $email;
			}
		}

		if ( empty( $fullname ) ) {
			if ( ! is_user_logged_in() ) {
				return __( "Guest", wp_defender()->domain );
			}
			$userdata = get_userdata( get_current_user_id() );

			$fullname = trim( $userdata->first_name . ' ' . $userdata->last_name );
			if ( empty( $fullname ) ) {
				$fullname = $userdata->display_name;
			}
		}

		return $fullname;
	}

	/**
	 * @param bool|false $force
	 */
	public static function do_submitting( $force = false ) {
		if ( self::get_setting( 'flag->need_submit_to_api' ) == false && $force == false ) {
			return;
		}
		if ( self::is_wpmudev_dashboard_installed() == false ) {
			//we need to submit st, but the scenario doesn't work, so we need to postponse
			self::update_setting( 'flag->submit_asap', 1 );

			return;
		}
		$end_point = "https://premium.wpmudev.org/api/defender/v1/scan-results";
		$data      = WD_Utils::prepare_api_result();
		$component = new WD_Component();
		$component->log( var_export( $data, true ), WD_Component::ERROR_LEVEL_DEBUG, 'api_submit' );
		$component->wpmudev_call( $end_point, $data, array(
			'method' => 'POST'
		) );
		self::update_setting( 'flag->need_submit_to_api', false );
		self::update_setting( 'flag->submit_asap', false );
	}

	/**
	 * @return string
	 */
	public static function retrieve_wp_config_path() {
		if ( file_exists( ABSPATH . 'wp-config.php' ) ) {
			return ( ABSPATH . 'wp-config.php' );
		} elseif ( @file_exists( dirname( ABSPATH ) . '/wp-config.php' ) && ! @file_exists( dirname( ABSPATH ) . '/wp-settings.php' ) ) {
			return ( dirname( ABSPATH ) . '/wp-config.php' );
		}
	}

	/**
	 * flag the plugin to submit api on next request
	 */
	public static function flag_for_submitting() {
		self::update_setting( 'flag->need_submit_to_api', 1 );
	}

	/**
	 * @return array
	 */
	public static function prepare_api_result() {
		$model = WD_Scan_Api::get_last_scan();
		if ( ! is_object( $model ) ) {
			$scan_result = array();
			$timestamp   = null;
		} else {
			$scan_result = $model->get_results_raw();

		}

		$hardener = WD_Hardener_Module::find_controller( 'hardener' );
		$modules  = $hardener->get_loaded_modules();
		if ( ! is_array( $modules ) ) {
			$modules = array();
		}
		$issues = array();
		foreach ( $modules as $rule ) {
			if ( $rule->is_ignored() == false && $rule->check() === false ) {
				$issues[] = array(
					'label' => $rule->title,
					'url'   => $rule->get_link()
				);
			}
		}

		$scan_schedule = WD_Utils::get_automatic_scan_settings();
		$model         = WD_Scan_Api::get_last_scan();
		$count         = 0;
		if ( is_object( $model ) ) {
			if ( isset( $model->execute_time['end_utc'] ) ) {
				$timestamp = $model->execute_time['end_utc'];
			} else {
				$timestamp = strtotime( $model->execute_time['end'] );
			}
			$res = array(
				'core_integrity'   => 0,
				'vulnerability_db' => 0,
				'file_suspicious'  => 0
			);

			foreach ( $model->get_results() as $item ) {
				if ( $item instanceof WD_Scan_Result_Core_Item_Model ) {
					$res['core_integrity'] += 1;
				} elseif ( $item instanceof WD_Scan_Result_VulnDB_Item_Model ) {
					$res['vulnerability_db'] += 1;
				} elseif ( $item instanceof WD_Scan_Result_File_Item_Model ) {
					$res['file_suspicious'] += 1;
				}
			}

			$count = $res['core_integrity'] + $res['vulnerability_db'] + $res['file_suspicious'];
		} else {
			$timestamp = '';
			$res       = array(
				'core_integrity'   => 0,
				'vulnerability_db' => 0,
				'file_suspicious'  => 0
			);
		}
		$labels = array(
			'core_integrity'   => __( "WordPress Core Integrity", wp_defender()->domain ),
			'vulnerability_db' => __( "Plugins & Themes vulnerability", wp_defender()->domain ),
			'file_suspicious'  => __( "Suspicious Code", wp_defender()->domain )
		);
		$data   = array(
			'domain'       => network_home_url(),
			'timestamp'    => $timestamp,
			'warnings'     => $count,
			'cautions'     => count( $issues ),
			'data_version' => '20160220',
			'scan_data'    => json_encode( array(
				'scan_result'        => $res,
				'hardener_result'    => $issues,
				'scan_schedule'      => array(
					'is_activated' => WD_Utils::get_setting( 'scan->auto_scan' ),
					'time'         => $scan_schedule['time'],
					'day'          => $scan_schedule['day'],
					'frequency'    => $scan_schedule['frequency']
				),
				'labels'             => $labels,
				'scan_page_url'      => network_admin_url( 'admin.php?page=wdf-scan' ),
				'hardener_page_url'  => network_admin_url( 'admin.php?page=wdf-hardener' ),
				'new_scan_url'       => network_admin_url( 'admin.php?page=wdf-scan&wdf-action=new_scan' ),
				'schedule_scans_url' => network_admin_url( 'admin.php?page=wdf-schedule-scan' ),
				'settings_page_url'  => network_admin_url( 'admin.php?page=wdf-settings' )
			) ),
		);

		return $data;
	}

	/**
	 * @return bool
	 */
	public static function check_permission() {
		$cap = is_multisite() ? 'manage_network_options' : 'manage_options';

		return current_user_can( $cap );
	}

	/**
	 * @param $get_avatar
	 *
	 * @return mixed
	 */
	public static function get_avatar_url( $get_avatar ) {
		preg_match( "/src='(.*?)'/i", $get_avatar, $matches );

		return $matches[1];
	}

	public static function admin_url( $path ) {
		return is_multisite() ? network_admin_url( $path ) : admin_url( $path );
	}

	/**
	 * @return array
	 */
	public static function allowed_html() {
		return array(
			'i'      => array(
				'class' => 'wd-text-warning wdv-icon wdv-icon-fw wdv-icon-exclamation-sign'
			),
			'strong' => array(),
			'span'   => array(
				'class' => array(
					'wd-suspicious-strong',
					'wd-suspicious-light',
					'wd-suspicious-medium'
				)
			),
			'img'    => array(
				'class' => 'text-warning',
				'src'   => wp_defender()->get_plugin_url() . 'assets/img/robot.png'
			)
		);
	}

	/**
	 * A fork of wp_text_diff
	 *
	 * @param $left_string
	 * @param $right_string
	 * @param null $args
	 *
	 * @return string
	 */
	public static function text_diff( $left_string, $right_string, $args = null ) {
		if ( ! class_exists( 'Text_Diff', false ) || ! class_exists( 'Text_Diff_Renderer_inline', false ) ) {
			require( ABSPATH . WPINC . '/wp-diff.php' );
		}

		$left_lines  = explode( "\n", $left_string );
		$right_lines = explode( "\n", $right_string );
		$text_diff   = new Text_Diff( $left_lines, $right_lines );
		$renderer    = new Text_Diff_Renderer_inline();

		return $renderer->render( $text_diff );
	}

	/**
	 * @param $key
	 * @param $value
	 * @param int $expiry
	 * @param string $store_type
	 *
	 * @since 1.0.4
	 */
	public static function cache( $key, $value, $expiry = null, $store_type = 'serialize' ) {
		if ( $expiry == null ) {
			//we willc ache in 3 months
			$expiry = HOUR_IN_SECONDS * 24 * 60;
		}
		//todo we have to check lenght of the value, incase it too large
		if ( $store_type == 'json' && is_array( $value ) ) {
			$value = json_encode( $value );
		}
		$result = set_site_transient( $key, $value, $expiry );
	}

	/**
	 * @param $key
	 * @param string $store_type
	 *
	 * @return array|mixed
	 */
	public static function get_cache( $key, $default = null, $store_type = 'serialize' ) {
		$value = get_site_transient( $key );
		if ( ! is_array( $value ) && $store_type == 'json' ) {
			$tmp = json_decode( $value, true );
			if ( is_array( $tmp ) ) {
				//assign back
				$value = $tmp;
			}
		}

		if ( empty( $value ) ) {
			return $default;
		}

		return $value;
	}

	/**
	 * @param $key
	 */
	public static function remove_cache( $key ) {
		delete_site_transient( $key );
		if ( is_multisite() ) {
			//in case when upgrade from single to multisite, still get some leftover
			delete_transient( $key );
		}
	}

	public static function exclude_extensions() {
		$exts = array(
			'jpg',
			'jpeg',
			'jpe',
			'gif',
			'png',
			'bmp',
			'tiff',
			'tif',
			'ico',
			'asf',
			'asx',
			'wmv',
			'wmx',
			'wm',
			'avi',
			'divx',
			'flv',
			'mov',
			'qt',
			'mpeg',
			'mpg',
			'mpe',
			'mp4',
			'm4v',
			'ogv',
			'webm',
			'mkv',
			'3gp',
			'3gpp',
			'3g2',
			'3gp2',
			'srt',
			'csv',
			'tsv',
			'ics',
			'rtx',
			'css',
			'vtt',
			'dfxp',
			'mp3',
			'm4a',
			'm4b',
			'ra',
			'ram',
			'wav',
			'ogg',
			'oga',
			'mid',
			'midi',
			'wma',
			'wax',
			'mka',
			'rtf',
			'js',
			'pdf',
			'class',
			'tar',
			'zip',
			'gz',
			'gzip',
			'rar',
			'7z',
			'psd',
			'xcf',
			'doc',
			'pot',
			'pps',
			'ppt',
			'wri',
			'xla',
			'xls',
			'xlt',
			'xlw',
			'mdb',
			'mpp',
			'docx',
			'docm',
			'dotx',
			'dotm',
			'xlsx',
			'xlsm',
			'xlsb',
			'xltx',
			'xltm',
			'xlam',
			'pptx',
			'pptm',
			'ppsx',
			'ppsm',
			'potx',
			'potm',
			'ppam',
			'sldx',
			'sldm',
			'onetoc',
			'onetoc2',
			'onetmp',
			'onepkg',
			'oxps',
			'xps',
			'odt',
			'odp',
			'ods',
			'odg',
			'odc',
			'odb',
			'odf',
			'wp',
			'wpd',
			'key',
			'numbers',
			'pages',
			'z',
			'swf',
			'cache',
			'xml'
		);

		return apply_filters( 'wd_exclude_extension', $exts );
	}
}