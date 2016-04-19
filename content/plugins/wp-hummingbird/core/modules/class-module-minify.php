<?php


require_once( 'minify/class-sources-group.php' );
require_once( 'minify/class-chart.php' );
require_once( 'minify/class-uri-rewriter.php' );
require_once( 'minify/class-errors-controller.php' );

class WP_Hummingbird_Module_Minify extends WP_Hummingbird_Module {


	/**
	 * Sources that are going to be moved to footer
	 *
	 * @var array
	 */
	private $to_footer = array(
		'styles' => array(),
		'scripts' => array()
	);

	private $done_handles = array(
		'styles' => array(),
		'scripts' => array()
	);

	/**
	 * Save all the minified groups that
	 * are already enqueued so they are not
	 * repeated
	 *
	 * @var array
	 */
	private $done_minified = array(
		'styles' => array(),
		'scripts' => array()
	);

	/**
	 * Sources that are going to be moved to header
	 *
	 * @var array
	 */
	private $to_header = array(
		'styles' => array(),
		'scripts' => array()
	);

	/**
	 * The list of sources that we are going to manage
	 *
	 * @var array
	 */
	private $to_do_list = array(
		'styles' => array(),
		'scripts' => array()
	);

	/**
	 * Save all resource that we have finished with
	 *
	 * @var array
	 */
	private $done_list = array(
		'styles' => array(),
		'scripts' => array()
	);

	/**
	 * Handles that will be processed by WP
	 *
	 * @var array
	 */
	private $return_to_wp = array(
		'styles' => array(),
		'scripts' => array()
	);

	/**
	 * Number that helps to numerate scripts handled by WP Hummingbird
	 *
	 * @var int
	 */
	private static $minified_counter = 0;

	/**
	 * Collector object. It will gather information
	 * about all sources that finds
	 *
	 * @var WP_Hummingbird_Sources_Collector
	 */
	private $collector;

	/**
	 * The object that collects all data related to chart
	 *
	 * @var WP_Hummingbird_Minification_Chart
	 */
	private $chart = null;

	/**
	 * Saves the resources that are pending to be processed
	 *
	 * @var array
	 */
	public $process_queue = array(
		'styles' => array(),
		'scripts' => array()
	);

	/**
	 * @var WP_Hummingbird_Minification_Errors_Controller
	 */
	public $errors_controller;

	/**
	 * Initializes Minify module
	 */
	public function init() {
		global $pagenow;

		$this->errors_controller = new WP_Hummingbird_Minification_Errors_Controller();

		if ( isset( $_GET['avoid-minify'] ) || 'wp-login.php' === $pagenow ) {
			add_filter( 'wp_hummingbird_is_active_module_' . $this->get_slug(), '__return_false' );
		}

	}

	public function run() {
		global $wp_customize;

		// Init the chart data collector
		$this->chart = new WP_Hummingbird_Minification_Chart();

		if ( is_admin() || is_customize_preview() || is_a( $wp_customize, 'WP_Customize_Manager' ) ) {
			return;
		}

		wphb_include_sources_collector();

		// Init the collector
		$this->collector = new WP_Hummingbird_Sources_Collector();


		// Only minify on front
		add_filter( 'print_styles_array', array( $this, 'filter_styles' ), 5 );
		add_filter( 'print_scripts_array', array( $this, 'filter_scripts' ), 5 );
		add_action( 'wp_head', array( $this, 'print_styles' ), 900 );
		add_action( 'wp_head', array( $this, 'print_scripts' ), 900 );
		add_action( 'wp_print_footer_scripts', array( $this, 'print_late_resources' ), 900 );

		add_action( 'shutdown', array( $this, 'save_data' ) );
	}

	/**
	 * Filter styles
	 *
	 * @param array $handles list of styles slugs
	 *
	 * @return array
	 */
	function filter_styles( $handles ) {
		return $this->filter_enqueues_list( $handles, 'styles' );
	}

	/**
	 * Filter styles
	 *
	 * @param array $handles list of scripts slugs
	 *
	 * @return array
	 */
	function filter_scripts( $handles ) {
		return $this->filter_enqueues_list( $handles, 'scripts' );
	}

	/**
	 * Print footer sources
	 */
	function print_late_resources() {
		$this->print_styles();
		$this->print_scripts();
	}

	/**
	 * Print styles only those handled by WP Hummingbird
	 */
	function print_styles() {
		$this->print_enqueues( 'styles' );
	}

	/**
	 * Print scripts only those handled by WP Hummingbird
	 */
	function print_scripts() {
		$this->print_enqueues( 'scripts' );
	}

	/**
	 * Print sources
	 *
	 * Print sources based on our to-do list that we have gathered before
	 *
	 * @param string $type styles|scripts
	 */
	public function print_enqueues( $type ) {
		global $wp_styles, $wp_scripts;

		$to_do = $this->to_do_list[ $type ];

		if ( $type == 'styles' ) {
			$wp_sources = $wp_styles;
		}
		else {
			$wp_sources = $wp_scripts;
		}

		foreach ( $to_do as $key => $handle ) {
			$wp_sources->do_item( $handle );
			$this->done_list[ $type ][ $key ] = $this->to_do_list[ $type ][ $key ];
			unset( $this->to_do_list[ $type ][ $key ] );
		}
	}

	/**
	 * Filter the sources
	 *
	 * We'll collect those styles/scripts that are going to be
	 * processed by WP Hummingbird and return those that will
	 * be processed by WordPress
	 *
	 * @param array $handles list of scripts/styles slugs
	 * @param string $type scripts|styles
	 *
	 * @return array List of handles that will be processed by WordPress
	 */
	function filter_enqueues_list( $handles, $type ) {
		$init_time = $this->microtime_float();
		$original_handles = $handles;

		// Sometimes handles are passed twice, let's remove those that we have processed already
		if ( $intersect = array_intersect( $handles, $this->done_handles[ $type ] ) ) {
			foreach ( $intersect as $item ) {
				unset( $handles[ array_search( $item, $handles ) ] );
			}
		}

		if ( $type == 'styles' ) {
			global $wp_styles;
			$wp_sources = $wp_styles;
		}
		elseif( $type == 'scripts' ) {
			global $wp_scripts;
			$wp_sources = $wp_scripts;
		}
		else {
			// What is this?
			return $handles;
		}

		if ( ! $this->is_active() )
			return $handles;

		if ( self::is_in_footer() && ! empty( $this->to_footer[ $type ] ) ) {
			// We have some gift from the header
			$handles = array_unique( array_merge( $this->to_footer[ $type ], $handles ) );
		}
		elseif ( ! self::is_in_footer() && ! empty( $this->to_header[ $type ] ) ) {
			// We have some gift from the footer
			$handles = array_unique( array_merge( $this->to_header[ $type ], $handles ) );
		}

		$in_footer = self::is_in_footer() ? 'footer' : 'header';

		if ( empty( $handles ) )
			return $handles;

		// Group the sources by externals and extras
		$groups = $this->group_sources_by_externals( $handles, $wp_sources->registered, $type );
		$groups = $this->_group_groups_by_extras( $groups, $wp_sources, $type );

		$all_groups = array();
		foreach ( $groups as $group ) {

			$extras = isset( $group['extra'] ) ? $group['extra'] : array();
			$obj_group = new WP_Hummingbird_Sources_Group( $type, $group['sources'], $extras );
			$obj_group->set_must_minify( $group['minify'] );
			$obj_group->set_must_combine( $group['combine'] );
			$obj_group->set_externals( $group['externals'] );
			$obj_group->set_position( $group['position'] );

			foreach ( $group['sources'] as $_source ) {
				$obj_group->add_source( $_source );
			}

			$all_groups[] = $obj_group;

		}

		unset( $groups );

		// We'll add here groups that need to be processed
		$process_queue = array();

		foreach ( $all_groups as $group ) {
			/** @var WP_Hummingbird_Sources_Group $group */
			$sources = $group->get_sources();

			if ( empty( $sources ) )
				continue;

			$process = true;
			$process_but_save = false;

			if ( ! $group->must_minify() && ! $group->must_combine() ) {
				$this->return_to_wp[ $type ] = array_merge( $this->return_to_wp[ $type ], $group->get_handles() );
				$process = false;
				$process_but_save = true;
			}


			// Get the versions hash for this group
			// so we can compare and decide if refresh cache or not
			$group_sources_vers_hash = $group->get_versions_hash();

			// Search the option where we save the data (not the content)
			$cache_info = $group->get_cache_info();


			$group_src = '';
			if ( $cache_info ) {
				$expire = $cache_info['expires'];
				$cached_vers_hash = $cache_info['ver_hash'];

				$is_expired = ( time() > $expire ) || ( $cached_vers_hash != $group_sources_vers_hash );
				if ( ! $is_expired && ! empty( $cache_info['src'] ) ) {
					// Do not minify, we have already the cached source
					$process = false;
					$group_src = $cache_info['src'];
				}
				else {
					// Cache expired, let's delete the file
					$group->delete_cache_file();
					$group->delete_cache_info();
					$this->chart->delete_group( $group->get_cache_key() );
				}
			}


			if ( $process ) {
				// Minify the files
				$process_queue[ $group->get_cache_key() ] = $group;

				// Add data to chart
				if ( is_front_page() ) {
					foreach ( $group->get_handles() as $group_handle ) {
						$registered = $wp_sources->registered[ $group_handle ];
						$this->chart->add_source( $group->get_cache_key(), $group->get_position(), $type, $registered->src );
					}
				}
			}

			if ( ! $process_but_save && ( ! $group_src || is_wp_error( $group_src ) ) ) {
				// Something happened! Return these handles to WP
				// @TODO: Log the error
				$this->return_to_wp[ $type ] = array_merge( $this->return_to_wp[ $type ], $group->get_handles() );
				$this->done_handles[ $type ] = array_merge( $this->done_handles[ $type ], $group->get_handles() );
			}
			elseif ( $process_but_save ) {
				$group_handles = $group->get_handles();

				// Save collection for future reference
				foreach ( $group_handles as $group_handle ) {
					$registered = $wp_sources->registered[ $group_handle ];
					$registered->original_size = $group->get_original_size( $group_handle );
					$registered->compressed_size = $group->get_compressed_size( $group_handle );
					$registered->group_key = $group->get_cache_key();
					$this->collector->add_to_collection( $registered, $type );
				}
			}
			else {
				// Is the group already enqueued?
				$group->set_group_src( $group_src );
				$group_hash = $group->get_srcs_hash();

				if ( ! in_array( $group_hash, $this->done_minified[ $type ] ) ) {
					$group_handles = $group->get_handles();

					self::$minified_counter++;
					$new_handle = 'wphb-' . self::$minified_counter;
					$group->enqueue( $new_handle, self::is_in_footer() );

					// Save this group as enqueued
					$this->done_minified[ $type ][] = $group->get_srcs_hash();

					$this->to_do_list[ $type ][] = $new_handle;

					// Save collection for future reference
					foreach ( $group_handles as $group_handle ) {
						$registered = $wp_sources->registered[ $group_handle ];
						$registered->original_size = $group->get_original_size( $group_handle );
						$registered->compressed_size = $group->get_compressed_size( $group_handle );
						$registered->group_key = $group->get_cache_key();
						$this->collector->add_to_collection( $registered, $type );

						$this->done_handles[ $type ][] = $group_handle;
					}
				}
			}

		}

		if ( ! empty( $process_queue ) ) {
			$this->process_queue[ $type ] = array_merge( $this->process_queue[ $type ], $process_queue );
		}

		$finish_time = $this->microtime_float();
		$duration = ( $finish_time - $init_time );

		// Try to sort the returned array the same way that we get it at the beginning
		$new_return_to_wp = array();
		foreach ( $original_handles as $key => $handle ) {
			if ( array_search( $handle, $this->return_to_wp[ $type ] ) !== false ) {
				$new_return_to_wp[ $key ] = $handle;
			}
		}

		$this->return_to_wp[ $type ] = $new_return_to_wp;

		$this->return_to_wp[ $type ] = array();

		return $new_return_to_wp;

	}

	/**
	 * @return float
	 */
	function microtime_float() {
		list($usec, $sec) = explode(" ", microtime());
		return ((float)$usec + (float)$sec);
	}

	/**
	 * @param $handles
	 * @param $registered
	 * @param string $type scripts|styles
	 *
	 * @return array
	 */
	function group_sources_by_externals( $handles, $registered, $type = 'styles' ) {
		$resources_group = array();

		// This var will tell us during teh loop if we marked
		// last resource to minify later
		$last_minify_status = -1;
		$last_combine_status = -1;

		$i = 0;
		$files_in_group = 0;
		$options = wphb_get_settings();

		/**
		 * Filter the max number of files in a group
		 *
		 * @var int $options['max_files_in_group']
		 */
		$max_files_in_group = apply_filters( 'wphb_max_files_in_group', $options['max_files_in_group'] );

		// This loop iterates over the handles
		// It creates a group for every X resources that we are going to minify
		// If it finds a resource that we don't want to minify,
		// It creates a new group and starts again
		foreach ( $handles as $handle ) {

			if ( ! isset( $registered[ $handle ] ) ) {
				$this->return_to_wp[ $type ][] = $handle;
				continue;
			}

			$source_url = $registered[ $handle ]->src;

			// By default we're going to try to minify it
			$minify_resource = true;

			/**
			 * Filter the resource (blocked or not)
			 *
			 * @usedby wphb_filter_resource_block()
			 *
			 * @var bool false
			 * @var string $handle Source slug
			 * @var string $source_url Source URL
			 * @var string $type scripts|styles
			 */
			$block_resource = apply_filters( 'wphb_block_resource', false, $handle, $type, $source_url );
			if ( $block_resource ) {
				continue;
			}

			if ( ! self::is_in_footer() ) {
				$send_resource_to_footer = false;
				if ( isset( $registered[ $handle ]->extra['group'] ) && 1 == $registered[ $handle ]->extra['group'] )
					$send_resource_to_footer = true;

				/**
				 * Filter the resource (move to footer)
				 *
				 * @usedby wphb_filter_resource_to_footer()
				 *
				 * @var bool $send_resource_to_footer
				 * @var string $handle Source slug
				 * @var string $source_url Source URL
				 * @var string $type scripts|styles
				 */
				$send_resource_to_footer = apply_filters( 'wphb_send_resource_to_footer', $send_resource_to_footer, $handle, $type, $source_url );
				if ( $send_resource_to_footer ) {
					$this->to_footer[ $type ][] = $handle;
					continue;
				}

			}
			else {
				/**
				 * Filter the resource (move to header)
				 *
				 * @var bool false
				 * @var string $handle Source slug
				 * @var string $source_url Source URL
				 * @var string $type scripts|styles
				 */
				$send_resource_to_header = apply_filters( 'wphb_send_resource_to_header', false, $minify_resource, $handle, $type, $source_url );
				if ( $send_resource_to_header ) {
					// It should have been processed on header
					continue;
				}
			}

			$is_external_source = ! $this->is_local_source( $source_url );

			/**
			 * Filter the resource (minify or not)
			 *
			 * @usedby wphb_filter_resource_minify()
			 *
			 * @var bool $minify_resource
			 * @var string $handle Source slug
			 * @var string $source_url Source URL
			 * @var string $type scripts|styles
			 */
			$minify_resource = apply_filters( 'wphb_minify_resource', $minify_resource, $handle, $type, $source_url );
			$minify_resource = (bool) $minify_resource;

			$files_in_group++;


			/**
			 * Filter the resource (combine or not)
			 *
			 * @usedby wphb_filter_resource_combine()
			 *
			 * @var bool false
			 * @var string $handle Source slug
			 * @var string $source_url Source URL
			 * @var string $type scripts|styles
			 */
			$combine_resource = apply_filters( 'wphb_combine_resource', true, $handle, $type, $source_url );
			if ( ! $combine_resource ) {
				// If we want to keep the position or not combine it, let's create a new group only for it
				$i++;
				$last_minify_status = null;
				$last_combine_status = null;
				$files_in_group = 0;
			}
			elseif ( ( $last_minify_status != $minify_resource ) || ( $last_combine_status != $combine_resource ) || $files_in_group >= $max_files_in_group ) {
				// If last status is different from the current one, create a new group
				// OR we have too many files for this group
				$i++;
				// Reset the number of files in the same group
				$files_in_group = 0;
			}

			$resources_group[ $i ]['minify'] = $minify_resource;
			$resources_group[ $i ]['combine'] = $combine_resource;

			// List of externals in this group
			if ( ! isset( $resources_group[ $i ]['externals'] ) ) {
				$resources_group[ $i ]['externals'] = array();
			}

			if ( $is_external_source ) {
				$resources_group[ $i ]['externals'] = array_merge( $resources_group[ $i ]['externals'], array( $handle ) );
			}

			// List of sources in this group
			if ( empty( $resources_group[ $i ]['sources'] ) )
				$resources_group[ $i ]['sources'] = array();

			$resources_group[ $i ]['sources'][] = $handle;
			if ( self::is_in_footer() ) {
				$resources_group[ $i ]['position'] = 'footer';
			}
			else {
				$resources_group[ $i ]['position'] = 'header';
			}

			$last_minify_status = $minify_resource;
			$last_combine_status = $combine_resource;

		}

		return $resources_group;
	}

	/**
	 * Regroup groups by extras
	 *
	 * @internal
	 *
	 * @param array $groups
	 * @param $wp_sources
	 *
	 * @return array
	 */
	private function _group_groups_by_extras( $groups, $wp_sources, $type ) {
		$resources_groups = array();

		foreach ( $groups as $group ) {
			// Group by extras
			$group_sources = $this->_group_handles_by_extra( $group['sources'], $wp_sources, $type );
			foreach ( $group_sources as $key => $handles ) {
				$resources_groups[] = array(
					'minify' => $group['minify'],
					'combine' => $group['combine'],
					'externals' => $group['externals'],
					'extra' => maybe_unserialize( $key ),
					'sources' => $handles,
					'position' => $group['position']
				);
			}
		}

		return $resources_groups;
	}

	/**
	 * Group handles by extras
	 *
	 * @internal
	 *
	 * @param array $handles
	 * @param $wp_sources WP_Styles or WP_Scripts WP Object list
	 *
	 * @return array
	 */
	private function _group_handles_by_extra( $handles, $wp_sources, $type ) {
		$bundles = array();

		foreach ( $handles as $handle ) {
			if ( ! isset( $wp_sources->registered[ $handle ] ) ) {
				$this->return_to_wp[ $type ][] = $handle;
				continue;
			}

			$source = $wp_sources->registered[ $handle ];
			$extras = $source->extra;

			if ( is_a( $wp_sources, 'WP_Styles') )
				$extras['media'] = is_string( $source->args ) ? $source->args : 'all';

			unset( $extras['suffix'] );
			unset( $extras['rtl'] );
			unset( $extras['data'] );

			// Default scripts are not assigned 'group', so we use the original 'deps->args' value
			if ( is_a( $wp_sources, 'WP_Scripts' ) && empty( $extra['group'] ) && is_int( $wp_sources->args ) )
				$extras['group'] = $wp_sources->args;

			ksort( $extras );

			$key = maybe_serialize( $extras );
			$bundles[ $key ][] = $handle;
		}

		return $bundles;
	}


	/**
	 * Return if we are processing the footer
	 *
	 * @return bool
	 */
	public static function is_in_footer() {
		return doing_action( 'wp_footer' );
	}

	/**
	 * Return if the source is from the current site
	 * or an external one
	 *
	 * @param string $src Source URL
	 *
	 * @return bool
	 */
	public static function is_local_source( $src ) {
		// Check if the URL is an external one
		$home_url = home_url();

		// Add scheme to src if it does not exist
		if ( 0 === strpos( $src, '//' ) )
			$src = 'http:' . $src;

		$parsed_site_url = parse_url( $home_url );
		$parsed_src = parse_url( $src );

		if ( ! $parsed_src ) {
			// Probably not local but who knows
			return false;
		}

		// '/wp-includes/js' are locals
		if ( empty( $parsed_src['host'] ) && strpos( $parsed_src['path'], '/' ) === 0 )
			return true;

		// Hosts match
		if ( ! empty( $parsed_src['host'] ) && $parsed_src['host'] === $parsed_site_url['host'] )
			return true;

		// Not local
		return false;

	}

	/**
	 * Save all the collected information
	 */
	public function save_data() {

		if ( ! empty( $this->process_queue['styles'] ) ) {
			// Save the queue to process it soon
			wphb_minification_add_items_to_process_queue( $this->process_queue['styles'] );
		}
		if ( ! empty( $this->process_queue['scripts'] ) ) {
			wphb_minification_add_items_to_process_queue( $this->process_queue['scripts'] );
		}

		// Process the chart data
		if ( count( $this->chart->get_sources() ) > 0 ) {
			$this->chart->save_chart_data( $this->chart->get_sources() );
		}



		// Process the queue
		if ( get_transient( 'wphb-processing' ) ) {
			// Still processing
			return;
		}

		set_transient( 'wphb-processing', true, 5 );

		$queue = wphb_minification_get_pending_process_queue();

		if ( ! empty( $queue ) ) {

			foreach ( $queue as $key => $item ) {
				if ( ! is_a( $item, 'WP_Hummingbird_Sources_Group' ) )
					continue;

				/** @var WP_Hummingbird_Sources_Group $item */
				$item->process_group();

				wphb_minification_delete_item_from_process_queue( $key );
			}

		}

		delete_transient( 'wphb-processing' );

	}



	public static function log( $message ) {
		if ( defined( 'WPHB_DEBUG_LOG' ) ) {
			$date = current_time( 'mysql' );
			if ( ! is_string( $message ) ) {
				$message = print_r( $message, true );
			}

			$message = '[' . $date . '] ' . $message;
			$cache_dir = wphb_get_cache_dir();
			$file = $cache_dir . 'minification.log';
			file_put_contents( $file, $message . "\n", FILE_APPEND );
		}
	}


	/**
	 * This function send a request to a URL in the site
	 * that will trigger the files collection
	 *
	 * Executed with AJAX
	 *
	 * @param string $url
	 *
	 * @return array
	 */
	public static function scan( $url ) {
		$cookies = array();
		foreach ( $_COOKIE as $name => $value ) {
			$cookies[] = new WP_Http_Cookie( array( 'name' => $name, 'value' => $value ) );
		}

		$result = array();

		$args = array(
			'timeout' => 0.01,
			'cookies' => $cookies,
			'blocking' => false,
			'sslverify' => false
		);
		$result['cookie'] = wp_remote_get( $url, $args );

		// One call logged out
		$args = array(
			'timeout' => 5,
			'blocking' => false,
			'sslverify' => false
		);

		$result['no-cookie'] = wp_remote_get( $url, $args );

		return $result;
	}

	/**
	 * Clear the module cache
	 */
	public static function clear_cache( $reset_settings = true ) {
		global $wpdb;

		// Clear all the collected sources
		wphb_include_sources_collector();
		WP_Hummingbird_Sources_Collector::clear_collection();

		// Clear all the cached groups data
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

		if ( $reset_settings ) {
			// Reset the minification settings
			$options = wphb_get_settings();
			$default_options = wphb_get_default_settings();
			$options['block'] = $default_options['block'];
			$options['dont_minify'] = $default_options['dont_minify'];
			$options['dont_combine'] = $default_options['dont_combine'];
			$options['position'] = $default_options['position'];
			wphb_update_settings( $options );
		}

		// Clear all the cached files
		wphb_include_file_cache_class();
		WP_Hummingbird_Cache_File::clear_files();

		// Clear the pending process queue
		self::clear_pending_process_queue();

		// Clear the chart data
		$model = wphb_get_model();

		$urls = $model->get_chart_urls();
		foreach ( $urls as $url ) {
			wp_cache_delete( wphb_sanitize_chart_url( $url . '_chart_data' ), 'wphb' );
		}

		$model->delete_chart();

		update_option( 'wphb-minification-check-files', 0 );

		WP_Hummingbird_Minification_Errors_Controller::clear_errors();
	}


	public static function clear_pending_process_queue() {
		delete_option( 'wphb_process_queue' );
		delete_transient( 'wphb-processing' );
	}

	public static function clear_cache_group( $group_key ) {
		if ( ! $group_key )
			return;

		// Delete the source group
		delete_option( $group_key );

		// Now clear the group from the chart too
		$model = wphb_get_model();
		$group_data = $model->get_chart_group_data( $group_key );

		if ( $group_data ) {
			// Get all URLs for that group so we can clean the chart cache
			$urls = wp_list_pluck( $group_data, 'url' );
			$urls = array_unique( $urls );
			foreach ( $urls as $url ) {
				wp_cache_delete( $url . '_chart_data', 'wphb' );
			}

			$model->delete_chart_group( $group_key );
		}
	}

	public static function init_scan() {
		wphb_clear_minification_cache( false );

		// Activate minification if is not
		wphb_toggle_minification( true );

		// Calculate URLs to Check
		$args = array(
			'orderby'        => 'rand',
			'posts_per_page' => '1',
			'ignore_sticky_posts' => true,
			'post_status' => 'publish'
		);

		$urls = array();

		$urls[] = home_url();

		$post_types = get_post_types();
		$post_types = array_diff( $post_types, array( 'attachment', 'nav_menu_item', 'revision' ) );

		foreach ( $post_types as $post_type ) {
			$args['post_type'] = $post_type;
			$posts = get_posts( $args );
			if ( $posts ) {
				$urls[] = get_permalink( $posts[0] );
			}

			$post_type_archive_link = get_post_type_archive_link( $post_type );
			if ( $post_type_archive_link )
				$urls[] = $post_type_archive_link;
		}

		if ( get_option( 'show_on_front' ) && $post = get_post( get_option( 'page_for_posts' ) ) ) {
			$urls[] = get_permalink( $post->ID );
		}

		$urls = array_unique( $urls );

		$args = array(
			'on' => current_time( 'timestamp' ),
			'urls_list' => $urls,
			'urls_done' => array()
		);

		update_option( 'wphb-minification-check-files', $args );
	}

	/**
	 * Get the current list of files to be processed
	 *
	 * @return mixed|void
	 */
	public static function get_pending_process_queue() {
		return get_option( 'wphb_process_queue', array() );
	}

	/**
	 * Check if Hummingbird is currently checking files
	 *
	 * @return bool
	 */
	public static function is_checking_files() {
		$checking_files = get_option( 'wphb-minification-check-files', 0 );
		if ( $checking_files )
			return true;

		return false;
	}

	/**
	 * Add items to be processed to the queue
	 *
	 * @param array $items List of items to be added
	 */
	public static function add_items_to_process_queue( $items ) {
		$current_queue = wphb_minification_get_pending_process_queue();
		if ( empty( $current_queue ) ) {
			add_option( 'wphb_process_queue', $items, null, false );
		} else {
			update_option( 'wphb_process_queue', array_merge( $items, $current_queue ) );
		}
	}


	/**
	 * Delete a single item from the process queue
	 *
	 * @param $key
	 */
	public static function delete_item_from_process_queue( $key ) {
		$queue = wphb_minification_get_pending_process_queue();
		if ( ! isset( $queue[ $key ] ) ) {
			return;
		}

		unset( $queue[ $key ] );

		if ( empty( $queue ) ) {
			wphb_delete_pending_process_queue();

			return;
		}

		update_option( 'wphb_process_queue', $queue );

	}


	public static function update_errors( $errors ) {
		update_option( 'wphb-minification-errors', $errors );
	}


}