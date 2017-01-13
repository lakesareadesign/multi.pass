<?php

require_once( 'minify/class-uri-rewriter.php' );
require_once( 'minify/class-errors-controller.php' );
require_once( 'minify/class-minify-sources-collector.php' );

// New files
include_once( 'minify/class-minify-group.php' );
include_once( 'minify/class-minify-groups-list.php' );

class WP_Hummingbird_Module_Minify extends WP_Hummingbird_Module {

	/**
	 * List of groups to be processed at the end of the request
	 *
	 * @var array
	 */
	private $group_queue = array();

	/**
	 * @var WP_Hummingbird_Sources_Collector
	 */
	public $sources_collector;

	/**
	 * @var WP_Hummingbird_Minification_Errors_Controller
	 */
	public $errors_controller;

	/**
	 * Counter that will name scripts/styles slugs
	 *
	 * @var int
	 */
	private static $counter = 0;

	public $done = array(
		'scripts' => array(),
		'styles' => array()
	);

	public $to_footer = array(
		'styles' => array(),
		'scripts' => array()
	);


	public function __construct( $slug, $name ) {
		parent::__construct( $slug, $name );
		self::$counter = 0;
	}

	/**
	 * Initializes Minify module
	 */
	public function init() {
		global $pagenow;

		$this->errors_controller = new WP_Hummingbird_Minification_Errors_Controller();
		$this->sources_collector = new WP_Hummingbird_Sources_Collector();

		if ( isset( $_GET['avoid-minify'] ) || 'wp-login.php' === $pagenow ) {
			add_filter( 'wp_hummingbird_is_active_module_' . $this->get_slug(), '__return_false' );
		}

		add_filter( 'wp_hummingbird_is_active_module_' . $this->get_slug(), array( $this, 'should_be_active' ), 20 );

		add_action( 'before_delete_post', array( $this, 'on_delete_post' ), 10 );
	}

	/**
	 * Delete files attached to a minify group
	 */
	public function on_delete_post( $post_id ) {
		$group = WP_Hummingbird_Module_Minify_Group::get_instance_by_post_id( $post_id );

		if ( is_a( $group, 'WP_Hummingbird_Module_Minify_Group'  ) && $group->file_id ) {
			if ( $group->get_file_path() ) {
				wp_delete_file( $group->get_file_path() );
			}
			wp_cache_delete( 'wphb_minify_groups' );
		}
	}

	public function should_be_active( $is_active ) {
		if ( ! $this->can_execute_php() ) {
			return false;
		}

		return $is_active;
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
	 * Check if the current PHP version is suitable for minification
	 */
	public function can_execute_php() {
		$minimun = $this->get_php_min_version();

		if ( version_compare( PHP_VERSION, $minimun, '<' ) ) {
			return false;
		}

		return true;
	}

	public function get_php_min_version() {
		return '5.3';
	}

	public function run() {
		global $wp_customize;

		add_action( 'init', array( $this, 'register_cpts' ) );

		if ( is_admin() || is_customize_preview() || is_a( $wp_customize, 'WP_Customize_Manager' ) ) {
			return;
		}

		// Only minify on front
		add_filter( 'print_styles_array', array( $this, 'filter_styles' ), 5 );
		add_filter( 'print_scripts_array', array( $this, 'filter_scripts' ), 5 );
		//add_action( 'wp_head', array( $this, 'print_styles' ), 900 );
		//add_action( 'wp_head', array( $this, 'print_scripts' ), 900 );
		//add_action( 'wp_print_footer_scripts', array( $this, 'print_late_resources' ), 900 );

		add_action( 'shutdown', array( $this, 'process_queue' ) );
	}

	/**
	 * Register a new CPT for Assets groups
	 */
	public static function register_cpts() {
		$labels = array(
			'name' => 'WPHB Minify Groups',
			'singular_name' => 'WPHB Minify Group'
		);

		$args = array(
			'labels'             => $labels,
			'description'        => 'WPHB Minify Groups (internal use)',
			'public'             => false,
			'publicly_queryable' => false,
			'show_ui'            => false,
			'show_in_menu'       => false,
			'query_var'          => false,
			'rewrite'            => false,
			'capability_type'    => 'post',
			'has_archive'        => false,
			'hierarchical'       => false,
			'supports'           => array()
		);
		register_post_type( 'wphb_minify_group', $args );
	}

	public function get_queue_to_process() {
		return $this->group_queue;
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
		if ( ! $this->is_active() ) {
			// Minification not active, return the handles
			return $handles;
		}

		if ( $this->errors_controller->is_server_error() ) {
			// there seem to be an error in our severs, do not minify
			return $handles;
		}

		if ( $type == 'styles' ) {
			global $wp_styles;
			$wp_dependencies = $wp_styles;
		}
		elseif( $type == 'scripts' ) {
			global $wp_scripts;
			$wp_dependencies = $wp_scripts;
		}
		else {
			// What is this?
			return $handles;
		}

		if ( empty( $handles ) ) {
			//  Nothing to do
			return $handles;
		}

		// Collect the handles information to use in admin later
		foreach ( $handles as $key => $handle ) {
			if ( isset ( $wp_dependencies->registered[ $handle ] ) && ! empty( $wp_dependencies->registered[ $handle ]->src ) ) {
				$this->sources_collector->add_to_collection( $wp_dependencies->registered[ $handle ], $type );
			}

			// If we aren't in footer, remove handles that need to go to footer
			if ( ! self::is_in_footer() && isset ( $wp_dependencies->registered[ $handle ]->extra['group'] ) && $wp_dependencies->registered[ $handle ]->extra['group'] ) {
				unset( $handles[ $key ] );
			}
		}

		$return_to_wp = array();

		if ( self::is_in_footer() && ! empty( $this->to_footer[ $type ] ) ) {
			// Header sent us some handles to be moved to footer
			$handles = array_unique( array_merge( $handles, $this->to_footer[ $type ] ) );
		}

		// Group dependencies by attributes like args, extra, etc
		$_groups = $this->group_dependencies_by_attributes( $handles, $wp_dependencies, $type );


		// Create a Groups list object
		$groups_list = new WP_Hummingbird_Module_Minify_Groups_List( $type );
		array_map(array( $groups_list, 'add_group' ), $_groups );

		unset( $_groups );

		$this->attach_inline_attribute( $groups_list, $wp_dependencies );

		if ( 'scripts' === $type ) {
			$this->attach_scripts_localization( $groups_list, $wp_dependencies );
		}

		// Time to split the groups if we're not combining some of them
		foreach ( $groups_list->get_groups() as $group ) {
			/** @var WP_Hummingbird_Module_Minify_Group $group */
			$dont_enqueue_list = $group->get_dont_enqueue_list();
			if ( $dont_enqueue_list ) {
				// There are one or more handles that should not be enqueued
				$group->remove_handles( $dont_enqueue_list );
				if ( 'styles' === $type ) {
					wp_dequeue_style( $dont_enqueue_list );
				}
				else {
					wp_dequeue_script( $dont_enqueue_list );
				}
			}

			$dont_combine_list = $group->get_dont_combine_list();
			if ( $dont_combine_list ) {
				// There are one or more handles that should not be combined
				/** @var WP_Hummingbird_Module_Minify_Group $group */
				$handles = $group->get_handles();
				// Here we'll save sources that don't need to be minified/combine
				// Then we'll extract those handles from the group and we'll create
				// a new group for them keeping the groups order
				$group_combine = array();
				foreach ( $handles as $handle ) {
					$combine_resource = $group->should_do_handle( $handle, 'combine' );
					$group_combine[ $handle ] = $combine_resource ? 1 : 0;
				}

				// Now split groups if needed based on combine value
				// We need to keep always the order, ALWAYS
				// This will save the new splitted group structure
				$splitted_group = array();

				$last_status = null;
				foreach ( $group_combine as $handle => $status ) {

					// Last minify status will be the first one by default
					if ( is_null( $last_status ) ) {
						$last_status = $status;
					}

					// Set the splitted groups to the last element
					end( $splitted_group );
					if ( $last_status === $status ) {
						$current_key = key( $splitted_group );
						if ( ! $current_key ) {
							// Current key can be NULL, set to 0
							$current_key = 0;
						}

						if ( ! isset( $splitted_group[ $current_key ] ) || ! is_array( $splitted_group[ $current_key ] ) ) {
							$splitted_group[ $current_key ] = array();
						}

						$splitted_group[ $current_key ][] = $handle;
					}
					else {
						// Create a new group
						$splitted_group[] = array( $handle );
					}


					$last_status = $status;
				}

				// Split the group!
				$groups_list->split_group( $group->hash, $splitted_group );
			}
		}


		// Set the groups handles, as we need all of them before processing
		foreach ( $groups_list->get_groups() as $group ) {
			$group->group_id = 'wphb-' . ++self::$counter;
			foreach ( $group->get_handles() as $handle ) {
				$this->done[ $type ][] = $handle;
			}
		}

		// Parse dependencies, load files and mark groups as ready,process or only-handles
		// Watch out! Groups must not be changed after this point
		$groups_list->preprocess_groups();

		foreach ( $groups_list->get_groups() as $group ) {
			$group_status = $groups_list->get_group_status( $group->hash );
			$deps = $groups_list->get_group_dependencies( $group->hash );

			if ( 'ready' == $group_status ) {
				// The group has its file and is ready to be enqueued
				$group->enqueue( self::is_in_footer(), $deps );
				$return_to_wp = array_merge( $return_to_wp, array( $group->group_id ) );
			}
			else {
				// The group has not yet a file attached or it cannot be processed
				// for some reason
				foreach ( $group->get_handles() as $handle ) {
					$new_id = $group->enqueue_one_handle( $handle, self::is_in_footer(), $deps );
					$return_to_wp = array_merge( $return_to_wp, array( $new_id ) );
				}

				if ( 'process' == $group_status ) {
					// Add the group to the queue to be processed later
					if ( $group->should_process_group() ) {
						$this->group_queue[] = $group;
					}

				}
			}
		}

		return $return_to_wp;
	}

	/**
	 * Group dependencies by alt, title, rtl, conditional and args attributes
	 *
	 * @param $handles
	 * @param $wp_dependencies
	 *
	 * @return array
	 */
	private function group_dependencies_by_attributes( $handles, $wp_dependencies, $type ) {
		$groups = array();
		$prev_differentiators_hash = false;

		foreach ( $handles as $handle ) {
			$registered_dependency = isset( $wp_dependencies->registered[ $handle ] ) ? $wp_dependencies->registered[ $handle ] : false;
			if ( ! $registered_dependency ) {
				continue;
			}

			if ( ! self::is_in_footer() ) {
				/**
				 * Filter the resource (move to footer)
				 *
				 * @usedby wphb_filter_resource_to_footer()
				 *
				 * @var bool $send_resource_to_footer
				 * @var string $handle Source slug
				 * @var string $type scripts|styles
				 * @var string $source_url Source URL
				 */
				if ( apply_filters( 'wphb_send_resource_to_footer', false, $handle, $type, $wp_dependencies->registered[ $handle ]->src ) ) {
					// Move this to footer, do not take this handle in account for this iteration
					$this->to_footer[ $type ][] = $handle;
					continue;
				}
			}

			// We'll group by these extras $wp_style->extras and $wp_style->args (args is no more than a string, confusing)
			// If previous group has the same values, we'll add this dep it to that group
			// otherwise, a new group will be created
			$group_extra_differentiators = array( 'alt', 'title', 'rtl', 'conditional' );
			$group_differentiators = array( 'args' );

			// We'll create a hash for all differentiators
			$differentiators_hash = array();
			foreach ( $group_extra_differentiators as $differentiator ) {
				if ( isset( $registered_dependency->extra[ $differentiator ] ) ) {
					if ( is_bool( $registered_dependency->extra[ $differentiator ] ) && $registered_dependency->extra[ $differentiator ] ) {
						$differentiators_hash[] = 'true';
					}
					elseif ( is_bool( $registered_dependency->extra[ $differentiator ] ) && ! $registered_dependency->extra[ $differentiator ] ) {
						$differentiators_hash[] = 'false';
					}
					else {
						$differentiators_hash[] = (string)$registered_dependency->extra[ $differentiator ];
					}
				}
				else {
					$differentiators_hash[] = '';
				}
			}

			foreach ( $group_differentiators as $differentiator ) {
				if ( isset( $registered_dependency->$differentiator ) ) {
					if ( is_bool( $registered_dependency->$differentiator ) && $registered_dependency->$differentiator ) {
						$differentiators_hash[] = 'true';
					}
					elseif ( is_bool( $registered_dependency->$differentiator ) && ! $registered_dependency->$differentiator ) {
						$differentiators_hash[] = 'false';
					}
					else {
						$differentiators_hash[] = (string)$registered_dependency->$differentiator;
					}
				}
				else {
					$differentiators_hash[] = '';
				}
			}

			$differentiators_hash = implode( '-', $differentiators_hash );

			// Now compare the hash with the previous one
			// If they are the same, do not create a new group
			if ( $differentiators_hash !== $prev_differentiators_hash ) {
				$new_group = new WP_Hummingbird_Module_Minify_Group();
				$new_group->set_type( $type );
				foreach ( $registered_dependency->extra as $key => $value ) {
					$new_group->add_extra( $key, $value );
				}

				// We'll treat this later
				$new_group->delete_extra( 'after' );

				$new_group->set_args( $registered_dependency->args );

				if ( $registered_dependency->src ) {
					$new_group->add_handle( $handle, $registered_dependency->src );

					// Add dependencies
					$new_group->add_handle_dependency( $handle, $wp_dependencies->registered[ $handle ]->deps );
				}


				$groups[] = $new_group;
			}
			else {
				end( $groups );
				$last_key = key( $groups );
				$groups[ $last_key ]->add_handle( $handle, $registered_dependency->src );
				// Add dependencies
				$groups[ $last_key ]->add_handle_dependency( $handle, $registered_dependency->deps );
				reset( $groups );
			}

			$prev_differentiators_hash = $differentiators_hash;

		}

		// Remove group without handles
		$return = array();
		foreach ( $groups as $key => $group ) {
			if ( $group->get_handles() ) {
				$return[ $key ] = $group;
			}
		}

		return $return;
	}

	/**
	 * Attach inline scripts/styles to groups
	 *
	 * Extract all deps that has inline scripts/styles (added by wp_add_inline_script/style functions)
	 * then it will add those extras to the groups
	 *
	 * @param WP_Hummingbird_Module_Minify_Groups_List $groups_list
	 * @param $wp_dependencies
	 */
	private function attach_inline_attribute( &$groups_list, $wp_dependencies ) {
		$registered = $wp_dependencies->registered;
		$extras = wp_list_pluck( $registered, 'extra' );
		$after = wp_list_pluck( array_filter( $extras, array( $this, '_filter_after_after_attribute' ) ), 'after' );

		array_map( function( $group ) use ( $groups_list, $after ) {
			/** @var WP_Hummingbird_Module_Minify_Group $group */
			array_map( function( $handle ) use ( $after, $group ) {
				if ( isset( $after[ $handle ] ) ) {
					// Add!
					$group->add_after( $after[ $handle ] );
				}
			}, $group->get_handles() );
		}, $groups_list->get_groups() );
	}

	/**
	 * Attach localization scripts to groups
	 *
	 * @param WP_Hummingbird_Module_Minify_Groups_List $groups_list
	 * @param $wp_dependencies
	 */
	private function attach_scripts_localization( &$groups_list, $wp_dependencies ) {
		$registered = $wp_dependencies->registered;
		$extra = wp_list_pluck( $registered, 'extra' );
		$data = wp_list_pluck( array_filter( $extra, function($a) {
			if ( isset ( $a['data'] ) ) {
				return $a['data'];
			}
			return false;
		} ), 'data' );

		array_map( function( $group ) use ( $groups_list, $data ) {
			/** @var WP_Hummingbird_Module_Minify_Group $group */
			array_map( function( $handle ) use ( $data, $group ) {
				if ( isset( $data[ $handle ] ) ) {
					// Add!
					$group->add_data( $data[ $handle ] );
				}
			}, $group->get_handles() );
		}, $groups_list->get_groups() );
	}

	/**
	 * Filter a list of dependencies returning their 'after' attribute inside 'extra' list
	 *
	 * @internal
	 */
	public function _filter_after_after_attribute( $a ) {
		if ( isset ( $a['after'] ) ) {
			return $a['after'];
		}
		return false;
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
	 * Process the queue: Minify and combine files
	 */
	public function process_queue() {
		$queue = $this->get_queue_to_process();
		$this->sources_collector->save_collection();

		if ( empty( $queue ) ) {
			return;
		}

		$this->add_items_to_persistent_queue( $queue );

		// Process the queue
		if ( get_transient( 'wphb-processing' ) ) {
			// Still processing
			return;
		}

		set_transient( 'wphb-processing', true, 60 );
		// Process 4 groups max in a request
		$count = 0;
		foreach ( $queue as $key => $item ) {
			if ( $count >= 4 ) {
				break;
			}
			if ( ! is_a( $item, 'WP_Hummingbird_Module_Minify_Group' ) )
				continue;

			/** @var WP_Hummingbird_Module_Minify_Group $item */
			if ( $item->should_generate_file() ) {
				$result = $item->process_group();
				if ( is_wp_error( $result ) ) {
					$this->errors_controller->add_server_error( $result );
				}
			}
			$this->remove_item_from_persistent_queue( $item->hash );
			$count++;
		}
		delete_transient( 'wphb-processing' );
	}

	/**
	 * Save a list of groups to a persistent option in database
	 *
	 * If a timeout happens during groups processing, we won't loose
	 * the data needed to process the rest of groups
	 *
	 * @param array $items
	 */
	private function add_items_to_persistent_queue( $items ) {
		$current_queue = $this->get_pending_persistent_queue();
		if ( empty( $current_queue ) ) {
			add_option( 'wphb_process_queue', $items, null, false );
		} else {
			update_option( 'wphb_process_queue', array_merge( $items, $current_queue ) );
		}
	}

	/**
	 * Remove a group from the persistent queue
	 *
	 * @param string $hash
	 */
	private function remove_item_from_persistent_queue( $hash ) {
		$queue = $this->get_pending_persistent_queue();
		$items = wp_list_filter( $queue, array( 'hash' => $hash ) );
		if ( ! $items ) {
			return;
		}

		$keys = array_keys( $items );
		foreach ( $keys as $key ) {
			unset( $queue[ $key ] );
		}

		$queue = array_values( $queue );

		if ( empty( $queue ) ) {
			$this->delete_pending_persistent_queue();
			return;
		}

		update_option( 'wphb_process_queue', $queue );
	}

	/**
	 * Get the list of groups that are yet pending to be processed
	 */
	public function get_pending_persistent_queue() {
		return get_option( 'wphb_process_queue', array() );
	}

	/**
	 * Deletes the persistent queue completely
	 */
	public function delete_pending_persistent_queue() {
		delete_option( 'wphb_process_queue' );
	}

	/**
	 * Clear the module cache
	 */
	public static function clear_cache( $reset_settings = true ) {
		global $wpdb;

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

		foreach ( $option_names as $name ) {
			delete_option( $name );
		}

		WP_Hummingbird_Sources_Collector::clear_collection();

		$groups = WP_Hummingbird_Module_Minify_Group::get_minify_groups();

		foreach ( $groups as $group ) {
			$path = get_post_meta( $group->ID, 'path', true );
			if ( $path ) {
				wp_delete_file( $path );
			}
			wp_delete_post( $group->ID );
			wp_cache_delete( 'wphb_minify_groups' );
		}

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

		// Clear the pending process queue
		self::clear_pending_process_queue();

		update_option( 'wphb-minification-check-files', 0 );

		WP_Hummingbird_Minification_Errors_Controller::clear_errors();
	}

	public static function clear_pending_process_queue() {
		delete_option( 'wphb_process_queue' );
		delete_transient( 'wphb-processing' );
	}

	/**
	 * Initializes the scanning process
	 */
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

		$urls_list = array();
		// Duplicate every URL 4 times. This will be enough to generate all the files for most of the sites
		for ( $i = 0; $i < 4; $i++ ) {
			$urls_list = array_merge( $urls_list, $urls );
		}

		sort( $urls_list );
		$urls = $urls_list;

		$args = array(
			'on' => current_time( 'timestamp' ),
			'urls_list' => $urls,
			'urls_done' => array()
		);

		update_option( 'wphb-minification-check-files', $args );
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
			if ( strpos( $name, 'wordpress_' ) > -1 ) {
				$cookies[] = new WP_Http_Cookie( array( 'name' => $name, 'value' => $value ) );
			}

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
			'timeout' => 0.01,
			'blocking' => false,
			'sslverify' => false
		);

		$result['no-cookie'] = wp_remote_get( $url, $args );

		return $result;
	}

}




