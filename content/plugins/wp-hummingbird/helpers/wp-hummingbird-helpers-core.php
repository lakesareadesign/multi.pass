<?php

/**
 * Try to cast a source URL to a path
 *
 * @param $src
 *
 * @return string
 */
function wphb_src_to_path( $src ) {

	$path = ltrim( parse_url( $src, PHP_URL_PATH ), '/' );
	$path = path_join( $_SERVER['DOCUMENT_ROOT'], $path );


	return apply_filters( 'wphb_src_to_path', $path, $src );
}

function wphb_include_sources_collector() {
	/** @noinspection PhpIncludeInspection */
	include_once( wphb_plugin_dir() . 'core/modules/minify/class-sources-collector.php' );
}

function wphb_include_file_cache_class() {
	/** @noinspection PhpIncludeInspection */
	include_once( wphb_plugin_dir() . 'core/modules/minify/class-file.php' );
}


/**
 * Get the instance of the model class
 *
 * @return WP_Hummingbird_Model instance
 */
function wphb_get_model() {
	/** @noinspection PhpIncludeInspection */
	include_once( wphb_plugin_dir() . 'core/class-model.php' );

	return WP_Hummingbird_Model::get_instance();
}

/**
 * Get all the chart data for a give URL
 *
 * @param string $url
 *
 * @return array|bool|mixed
 */
function wphb_get_chart( $url ) {
	$chart = new WP_Hummingbird_Minification_Chart();
	$chart->set_chart_url( $url );

	return $chart->chart();
}

/**
 * Prepare the chart data for Javascript
 *
 * @param array Chart data
 *
 * @return string JSON chart data
 */
function wphb_prepare_chart_data_for_javascript( $data, $groups ) {
	return WP_Hummingbird_Minification_Chart::prepare_for_javascript( $data, $groups );
}

/**
 * Filter all the chart data
 *
 * The condition will sset what are we filtering by. Possible values
 * are styles and scripts or false to filter core data
 *
 * @param array $data Chart data
 * @param bool|string $condition styles|scripts or false for core
 *
 * @return array Filtered data
 */
function wphb_filter_chart_data( $data, $condition = false ) {
	// If condition is set to false, let's get the Core area
	if ( ! $condition ) {
		$data['header']['themes'] = array();
		$data['header']['plugins'] = array();

		$data['footer']['themes'] = array();
		$data['footer']['plugins'] = array();
	}
	else {
		$data['header']['themes'] = array_intersect_key( $data['header']['themes'], array( $condition => 'true' ) );
		$data['header']['plugins'] = array_intersect_key( $data['header']['plugins'], array( $condition => 'true' ) );
		$data['header']['core'] = array();

		$data['footer']['themes'] = array_intersect_key( $data['footer']['themes'], array( $condition => 'true' ) );
		$data['footer']['plugins'] = array_intersect_key( $data['footer']['plugins'], array( $condition => 'true' ) );
		$data['footer']['core'] = array();
	}

	return $data;
}

/**
 * Prepare a URL for chart class
 *
 * @param string $url
 *
 * @return string Prepared URL
 */
function wphb_sanitize_chart_url( $url ) {
	$url = trailingslashit( preg_replace( '/https?\:\/\//', '', $url ) );

	return $url;
}


/**
 * Return the server type (Apache, NGINX...)
 *
 * @return string Server type
 */
function wphb_get_server_type() {
	global $is_apache, $is_IIS, $is_iis7, $is_nginx;

	$type = get_site_option( 'wphb-server-type' );
	$user_type = get_user_meta( get_current_user_id(), 'wphb-server-type', true );
	if ( $user_type ) {
		$type = $user_type;
	}

	if ( ! $type ) {
		$type = '';

		if ( $is_apache ) {
			// It's a common configuration to use nginx in front of Apache.
			// Let's make sure that this server is Apache
			$response = wp_remote_get( home_url() );

			if ( is_wp_error( $response ) ) {
				// Bad luck
				$type = 'apache';
			}
			else {
				$server = strtolower( wp_remote_retrieve_header( $response, 'server' ) );
				// Could be LiteSpeed too
				$type = strpos( $server, 'nginx' ) !== false ? 'nginx' : 'apache';
				update_site_option( 'wphb-server-type', $type );
			}

		} elseif ( $is_nginx ) {
			$type = 'nginx';
			update_site_option( 'wphb-server-type', $type );
		} elseif ( $is_IIS ) {
			$type = 'IIS';
			update_site_option( 'wphb-server-type', $type );
		} elseif ( $is_iis7 ) {
			$type = 'IIS 7';
			update_site_option( 'wphb-server-type', $type );
		}


	}

	return apply_filters( 'wphb_get_server_type', $type );
}



/**
 * Get a list of server types
 *
 * @return array
 */
function wphb_get_servers() {
	return array(
		'apache' => 'Apache',
		'LiteSpeed' => 'LiteSpeed',
		'nginx' => 'NGINX',
		'iis' => 'IIS',
		'iis-7' => 'IIS 7'
	);
}

/**
 *
 * @param array $args
 */
function wphb_get_servers_dropdown( $args = array() ) {

	$defaults = array(
		'class' => '',
		'id' => '',
		'name' => 'wphb-server-type',
		'selected' => false
	);

	$args = wp_parse_args( $args, $defaults );

	$servers = wphb_get_servers();

	if ( ! $args['id'] )
		$args['id'] = $args['name'];

	if ( ! $args['selected'] )
		$args['selected'] = wphb_get_server_type();

	?>
		<select name="<?php echo esc_attr( $args['name'] ); ?>" id="<?php echo esc_attr( $args['id'] ); ?>" class="<?php echo esc_attr( $args['class'] ); ?>">
			<?php foreach ( $servers as $server => $server_name ): ?>
				<option value="<?php echo esc_attr( $server ); ?>" <?php selected( $server, $args['selected'] ); ?>><?php echo esc_html( $server_name ); ?></option>
			<?php endforeach; ?>
		</select>
	<?php


}


function wphb_is_htaccess_writable() {
	if ( ! function_exists( 'get_home_path' ) ) {
		require_once( ABSPATH . 'wp-admin/includes/file.php' );
	}

	$home_path = get_home_path();
	$writable = ( ! file_exists( $home_path . '.htaccess' ) && is_writable( $home_path ) ) || is_writable( $home_path . '.htaccess' );
	return $writable;
}

function wphb_is_htaccess_written( $module ) {
	if ( ! function_exists( 'get_home_path' ) ) {
		require_once( ABSPATH . 'wp-admin/includes/file.php' );
	}

	if ( ! function_exists( 'extract_from_markers' ) ) {
		require_once( ABSPATH . 'wp-admin/includes/misc.php' );
	}

	$home_path = get_home_path();
	$existing_rules  = array_filter( extract_from_markers( $home_path . '.htaccess', 'WP-HUMMINGBIRD-' . strtoupper( $module ) ) );
	return ! empty( $existing_rules );
}

function wphb_save_htaccess( $module ) {
	if ( wphb_is_htaccess_written( $module ) )
		return false;

	$home_path = get_home_path();
	$htaccess_file = $home_path.'.htaccess';

	if ( wphb_is_htaccess_writable() ) {
		$code = wphb_get_code_snippet( $module, 'apache' );
		$code = explode( "\n", $code );
		return insert_with_markers( $htaccess_file, 'WP-HUMMINGBIRD-' . strtoupper( $module ), $code );
	}

	return false;
}

function wphb_unsave_htaccess( $module ) {
	if ( ! wphb_is_htaccess_written( $module ) )
		return false;

	$home_path = get_home_path();
	$htaccess_file = $home_path.'.htaccess';

	if ( wphb_is_htaccess_writable() ) {
		return insert_with_markers( $htaccess_file, 'WP-HUMMINGBIRD-' . strtoupper( $module ), '' );
	}


	return false;
}


function wphb_log( $message, $module ) {
	if ( defined( 'WPHB_DEBUG_LOG' ) ) {
		$date = current_time( 'mysql' );
		if ( ! is_string( $message ) ) {
			$message = print_r( $message, true );
		}

		if ( is_array( $message ) || is_object( $message ) ) {
			$message = print_r( $message, true );
		}

		$message = '[' . $date . '] ' . $message;
		$cache_dir = wphb_get_cache_dir();
		$file = $cache_dir . $module . '.log';
		file_put_contents( $file, $message . "\n", FILE_APPEND );
	}
}

function wphb_uninstall() {
	global $wpdb;

	delete_option( 'wphb_styles_collection' );
	delete_option( 'wphb_scripts_collection' );

	$option_names = $wpdb->get_col(
			$wpdb->prepare(
					"SELECT option_name FROM $wpdb->options
					WHERE option_name LIKE %s
					OR option_name LIKE %s
					OR option_name LIKE %s
					OR option_name LIKE %s",
					'%wphb-min-scripts%',
					'%wphb-scripts%',
					'%wphb-min-styles%',
					'%wphb-styles%'
			)
	);

	foreach ( $option_names as $name )
		delete_option( $name );

	delete_option( 'wphb_process_queue' );

	delete_option( 'wphb_settings' );
	delete_site_option( 'wphb_settings' );

	delete_site_option( 'wphb_version' );

	delete_site_option( 'wphb-is-cloudflare' );

	// @TODO Delete cache folder (full)

	$table = $wpdb->base_prefix . 'minification_chart';
	$wpdb->query( "DROP TABLE $table" );
}

function wphb_membership_modal( $text ) {
	include_once( wphb_plugin_dir() . 'admin/views/membership-modal.php' );
}

function wphb_is_member() {
	if ( function_exists( 'is_wpmudev_member' ) ) {
		return is_wpmudev_member();
	}

	return false;
}

function wphb_update_membership_link() {
	return "https://premium.wpmudev.org/membership/#profile-menu-tabs";
}

function wphb_support_link() {
	return "https://premium.wpmudev.org/forums/forum/support#question";
}

/**
 * Enqueues admin scripts
 */
function wphb_enqueue_admin_scripts() {
	$ver = '20160217';

	$file = wphb_plugin_url() . 'admin/assets/js/admin.min.js';

	wp_enqueue_script( 'wphb-admin', $file, array( 'jquery', 'underscore' ), $ver );

	$i10n = array(
		'writeHtaccessNonce' => wp_create_nonce( 'wphb-write-htacces' ),
		'setExpirationNonce' => wp_create_nonce( 'wphb-set-expiration' ),
		'setServerNonce' => wp_create_nonce( 'wphb-set-server' ),
		'recheckURL' => add_query_arg( 'run', 'true', wphb_get_admin_menu_url( 'caching' ) ),
		'htaccessErrorURL' => add_query_arg( 'htaccess-error', 'true', wphb_get_admin_menu_url( 'caching' ) ),
		'cacheEnabled' => wphb_is_htaccess_written('caching')
	);
	wp_localize_script( 'wphb-admin', 'wphbCachingStrings', $i10n );

	$i10n = array(
		'writeHtaccessNonce' => wp_create_nonce( 'wphb-write-htacces' ),
		'setServerNonce' => wp_create_nonce( 'wphb-set-server' ),
	);
	wp_localize_script( 'wphb-admin', 'wphbGZipStrings', $i10n );

	$i10n = array(
		'checkFilesNonce' => wp_create_nonce( 'wphb-minification-check-files' ),
		'chartNonce' => wp_create_nonce( 'wphb-chart' ),
		'finishedCheckURLsLink' => wphb_get_admin_menu_url( 'minification' ),
		'toggleMinificationNonce' => wp_create_nonce( 'wphb-toggle-minification' ),
		'discardAlert' => __( 'Are you sure? All your changes will be lost', 'wphb' )
	);
	wp_localize_script( 'wphb-admin', 'wphbMinificationStrings', $i10n );


	$i10n = array(
		'removeWelcomeBoxNonce' => wp_create_nonce( 'wphb-remove-welcome-box' ),
		'activateMinificationNonce' => wp_create_nonce( 'wphb-activate-minification' )
	);
	wp_localize_script( 'wphb-admin', 'wphbDashboardStrings', $i10n );

	$i10n = array(
		'performanceTestNonce' => wp_create_nonce( 'wphb-welcome-performance-test' ),
		'finishedTestURLsLink' => wphb_get_admin_menu_url( 'performance' ),
	);
	wp_localize_script( 'wphb-admin', 'wphbPerformanceStrings', $i10n );

	$toggle_uptime_nonce = wp_create_nonce( 'wphb-toggle-uptime' );
	$i10n = array(
		'enableUptimeURL' => add_query_arg(
			array(
				'_wpnonce' => $toggle_uptime_nonce,
				'action' => 'enable'
			),
			wphb_get_admin_menu_url( 'uptime' )
		),
		'disableUptimeURL' => add_query_arg(
			array(
				'_wpnonce' => $toggle_uptime_nonce,
				'action' => 'disable'
			),
			wphb_get_admin_menu_url( 'uptime' )
		),

	);
	wp_localize_script( 'wphb-admin', 'wphbUptimeStrings', $i10n );

	/** @var WP_Hummingbird_Module_Cloudflare $cf */
	$cf = wphb_get_module( 'cloudflare' );
	$i10n = array(
		'cloudflare' => array(
			'is' => array(
				'connected' => $cf->is_connected() && $cf->is_zone_selected()
			),
			'nonces' => array(
				'expiry' => wp_create_nonce( 'wphb-cloudflare-expiry' )
			)
		)
	);
	wp_localize_script( 'wphb-admin', 'wphb', $i10n );
}





/**
 * Wrapper function for WP_Hummingbird_Module_Performance::get_last_report()
 * @return bool|mixed|void
 */
function wphb_performance_get_last_report() {
	return WP_Hummingbird_Module_Performance::get_last_report();
}

/**
 * Wrapper function for WP_Hummingbird_Module_Performance::refresh_report()
 * @return bool|mixed|void
 */
function wphb_performance_refresh_report() {
	WP_Hummingbird_Module_Performance::refresh_report();
}

/**
 * Wrapper function for WP_Hummingbird_Module_Performance::is_doing_report()
 * @return bool|mixed|void
 */
function wphb_performance_is_doing_report() {
	return WP_Hummingbird_Module_Performance::is_doing_report();
}

/**
 * Wrapper function for WP_Hummingbird_Module_Performance::stopped_report()
 * @return mixed|void
 */
function wphb_performance_stopped_report() {
	return WP_Hummingbird_Module_Performance::stopped_report();
}

/**
 * Wrapper function for WP_Hummingbird_Module_Performance::set_doing_report()
 * @param bool $status
 */
function wphb_performance_set_doing_report( $status = true ) {
	WP_Hummingbird_Module_Performance::set_doing_report( $status );
}

/**
 * Wrapper function for WP_Hummingbird_Module_Performance::init_scan()
 */
function wphb_performance_init_scan() {
	WP_Hummingbird_Module_Performance::init_scan();
}

/**
 * @return WP_Hummingbird_API
 */
function wphb_get_api() {
	return wp_hummingbird()->core->api;
}

function wphb_get_caching_frequencies() {
	return array(
		'1h/A3600' => __( '1 hour', 'wphb' ),
		'3h/A10800' => __( '3 hours', 'wphb' ),
		'4h/A14400' => __( '4 hours', 'wphb' ),
		'5h/A18000' => __( '5 hours', 'wphb' ),
		'6h/A21600' => __( '6 hours', 'wphb' ),
		'12h/A43200' => __( '12 hours', 'wphb' ),
		'16h/A57600' => __( '16 hours', 'wphb' ),
		'20h/A72000' => __( '20 hours', 'wphb' ),
		'1d/A86400' => __( '1 day', 'wphb' ),
		'2d/A172800' => __( '2 days', 'wphb' ),
		'3d/A259200' => __( '3 days', 'wphb' ),
		'4d/A345600' => __( '4 days', 'wphb' ),
		'5d/A432000' => __( '5 days', 'wphb' ),
		'8d/A691200' => __( '8 days', 'wphb' ),
		'16d/A1382400' => __( '16 days', 'wphb' ),
		'24d/A2073600' => __( '24 days', 'wphb' ),
		'1M/A2592000' => __( '1 month', 'wphb' ),
		'2M/A5184000' => __( '2 months', 'wphb' ),
		'3M/A7776000' => __( '3 months', 'wphb' ),
		'6M/A15552000' => __( '6 months', 'wphb' ),
		'1y/A31536000' => __( '1 year', 'wphb' ),
	);
}

function wphb_get_caching_cloudflare_frequencies() {
	return array(
		7200 =>	__( '2 hours', 'wphb' ),
		10800 => __( '3 hours', 'wphb' ),
		14400 => __( '4 hours', 'wphb' ),
		18000 => __( '5 hours', 'wphb' ),
		28800 => __( '8 hours', 'wphb' ),
		43200 => __( '12 hours', 'wphb' ),
		57600 => __( '16 hours', 'wphb' ),
		72000 => __( '20 hours', 'wphb' ),
		86400 => __( '1 day', 'wphb' ),
		172800 => __( '2 days', 'wphb' ),
		259200 => __( '3 days', 'wphb' ),
		345600 => __( '4 days', 'wphb' ),
		432000 => __( '5 days', 'wphb' ),
		691200 => __( '8 days', 'wphb' ),
		1382400 => __( '16 days', 'wphb' ),
		2073600 => __( '24 days', 'wphb' ),
		2592000 => __( '1 month', 'wphb' ),
		5184000 => __( '2 months', 'wphb' ),
		15552000 => __( '6 months', 'wphb' ),
		31536000 => __( '1 year', 'wphb' )
	);
}

function wphb_get_caching_cloudflare_frequencies_dropdown( $args = array() ) {
	$defaults = array(
		'selected' => false,
		'name' => 'expiry-select',
		'id' => false,
		'class' => '',
		'data-type' => ''
	);

	$args = wp_parse_args( $args, $defaults );

	if ( ! $args['id'] )
		$args['id'] = $args['name'];


	?>
	<select id="<?php echo esc_attr( $args['id'] ); ?>" name="<?php echo esc_attr( $args['name'] ); ?>" class="<?php echo esc_attr( $args['class'] ); ?>" data-type="<?php echo esc_attr( $args['data-type'] ); ?>">
		<?php foreach ( wphb_get_caching_cloudflare_frequencies() as $key => $value ): ?>
			<option value="<?php echo esc_attr( $key ); ?>" <?php selected( $args['selected'], $key ); ?>><?php echo $value; ?></option>
		<?php endforeach; ?>
	</select>
	<?php
}

function wphb_get_caching_frequencies_dropdown( $args = array() ) {
	$defaults = array(
		'selected' => false,
		'name' => 'expiry-select',
		'id' => false,
		'class' => '',
		'data-type' => ''
	);

	$args = wp_parse_args( $args, $defaults );

	if ( ! $args['id'] )
		$args['id'] = $args['name'];


	?>
		<select id="<?php echo esc_attr( $args['id'] ); ?>" name="<?php echo esc_attr( $args['name'] ); ?>" class="<?php echo esc_attr( $args['class'] ); ?>" data-type="<?php echo esc_attr( $args['data-type'] ); ?>">
			<?php foreach ( wphb_get_caching_frequencies() as $key => $value ): ?>
				<option value="<?php echo esc_attr( $key ); ?>" <?php selected( $args['selected'], $key ); ?>><?php echo $value; ?></option>
			<?php endforeach; ?>
		</select>
	<?php
}

/**
 * Credits to: http://stackoverflow.com/a/11389893/1502521
 *
 * @param $seconds
 *
 * @return string|void
 */
function wphb_human_read_time_diff( $seconds ) {
	if ( ! $seconds ) {
		return false;
	}

	$year_in_seconds   = 60 * 60 * 24 * 365.25;
	$month_in_seconds  = 60 * 60 * 24 * ( 365.25 / 12 );
	$day_in_seconds    = 60 * 60 * 24;
	$hour_in_seconds   = 60 * 60;
	$minute_in_seconds = 60;

	$minutes = 0;
	$hours = 0;
	$days = 0;
	$months = 0;
	$years = 0;

	while($seconds >= $year_in_seconds) {
		$years ++;
		$seconds = $seconds - $year_in_seconds;
	}

	while($seconds >= $month_in_seconds) {
		$months ++;
		$seconds = $seconds - $month_in_seconds;
	}

	while($seconds >= $day_in_seconds) {
		$days ++;
		$seconds = $seconds - $day_in_seconds;
	}

	while($seconds >= $hour_in_seconds) {
		$hours++;
		$seconds = $seconds - $hour_in_seconds;
	}

	while($seconds >= $minute_in_seconds) {
		$minutes++;
		$seconds = $seconds - $minute_in_seconds;
	}

	$diff = new stdClass();
	$diff->y = $years;
	$diff->m = $months;
	$diff->d = $days;
	$diff->h = $hours;
	$diff->i = $minutes;
	$diff->s = $seconds;

	if ( $diff->y || ( $diff->m == 11 && $diff->d >= 30 ) ) {
		$years = $diff->y;
		if ( $diff->m == 11 && $diff->d >= 30 ) {
			$years++;
		}
		$diff_time = sprintf( _n( '%d year', '%d years', $years, 'wphb' ), $years );
	}
	elseif ( $diff->m ) {
		$diff_time = sprintf( _n( '%d month', '%d months', $diff->m, 'wphb' ), $diff->m );
	}
	elseif ( $diff->d ) {
		$diff_time = sprintf( _n( '%d day', '%d days', $diff->d, 'wphb' ), $diff->d );
	}
	elseif ( $diff->h ) {
		$diff_time = sprintf( _n( '%d hour', '%d hours', $diff->h, 'wphb' ), $diff->h );
	}
	elseif ( $diff->i ) {
		$diff_time = sprintf( _n( '%d minute', '%d minutes', $diff->i, 'wphb' ), $diff->i );
	}
	else {
		$diff_time = sprintf( _n( '%d second', '%d seconds', $diff->s, 'wphb' ), $diff->s );
	}

	return $diff_time;
}

function wphb_get_recommended_caching_values() {
	return array(
		'css' => array(
			'label' => __( '8 days', 'wphb' ),
			'value' => 8 * 24 * 3600,
		),
		'javascript' => array(
			'label' => __( '8 days', 'wphb' ),
			'value' => 8 * 24 * 3600,
		),
		'media' => array(
			'label' => __( '8 days', 'wphb' ),
			'value' => 8 * 24 * 3600,
		),
		'images' => array(
			'label' => __( '8 days', 'wphb' ),
			'value' => 8 * 24 * 3600,
		)
	);
}

function wphb_get_admin_menu_url( $page = '' ) {
	/** @var WP_Hummingbird $hummingbird */
	$hummingbird = wp_hummingbird();
	if ( is_object( $hummingbird->admin ) ) {
		$page_slug = empty( $page ) ? 'wphb' : 'wphb-' . $page;
		if ( $page = $hummingbird->admin->get_admin_page( $page_slug ) ) {
			return $page->get_page_url();
		}
	}

	return '';
}


/**
 * Return the needed capability for admin pages
 *
 * @return string
 */
function wphb_get_admin_capability() {
	$cap = 'manage_options';
	if ( is_multisite() && is_network_admin() ) {
		$cap = 'manage_network';
	}

	return apply_filters( 'wphb_admin_capability', $cap );
}

/**
 * Get code snippet for a module and server type
 *
 * @param string $module Module name
 * @param string $server_type Server type (nginx, apache...)
 *
 * @return string Code snippet
 */
function wphb_get_code_snippet( $module, $server_type = '' ) {

	/** @var WP_Hummingbird_Module_Server $module */
	$module = wphb_get_module( $module );
	if ( ! $module )
		return '';

	if ( ! $server_type )
		$server_type = wphb_get_server_type();

	return apply_filters( 'wphb_code_snippet', $module->get_server_code_snippet( $server_type ), $server_type, $module );
}

