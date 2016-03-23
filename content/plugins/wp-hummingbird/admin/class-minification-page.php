<?php


class WP_Hummingbird_Minification_Page extends WP_Hummingbird_Admin_Page {


	public function on_load() {

		wphb_minification_maybe_stop_checking_files();

		if ( isset( $_POST['submit'] ) ) {
			check_admin_referer( 'wphb-enqueued-files' );

			$options = wphb_get_settings();
			$options = $this->_sanitize_type( 'styles', $options );
			$options = $this->_sanitize_type( 'scripts', $options );

			wphb_update_settings( $options );

			wp_redirect( add_query_arg( 'updated', 'true' ) );
			exit;
		}

		if ( isset( $_POST['clear-cache'] ) ) {
			wphb_clear_minification_cache( false  );
			$url = remove_query_arg( 'updated' );
			wp_redirect( add_query_arg( 'wphb-cache-cleared', 'true', $url ) );
			exit;
		}

	}

	private function _sanitize_type( $type, $options ) {

		$current_options = wphb_get_settings();

		// We'll save what groups have changed so we reset the cache for those groups
		$changed_groups = array();

		if ( ! empty( $_POST[ $type ] ) ) {
			foreach ( $_POST[ $type ] as $handle => $item ) {
				$key = array_search( $handle, $options['block'][ $type ] );
				if ( ! isset( $item['include'] ) ) {
					$options['block'][ $type ][] = $handle;
				}
				elseif ( $key !== false ) {
					unset( $options['block'][ $type ][ $key ] );
				}
				$options['block'][ $type ] = array_unique( $options['block'][ $type ] );
				$diff = array_merge(
					array_diff( $current_options['block'][ $type ], $options['block'][ $type ] ),
					array_diff( $options['block'][ $type ], $current_options['block'][ $type ] )
				);
				if ( $diff ) {
					foreach ( $diff as $diff_handle ) {
						$changed_group = WP_Hummingbird_Sources_Collector::get_group_from_handle( $diff_handle, $type );
						if ( $changed_group )
							$changed_groups[] = $changed_group;
					}
				}

				$key = array_search( $handle, $options['dont_minify'][ $type ] );
				if ( ! isset( $item['minify'] ) ) {
					$options['dont_minify'][ $type ][] = $handle;
				}
				elseif ( $key !== false ) {
					unset( $options['dont_minify'][ $type ][ $key ] );
				}
				$options['dont_minify'][ $type ] = array_unique( $options['dont_minify'][ $type ] );
				$diff = array_merge(
					array_diff( $current_options['dont_minify'][ $type ], $options['dont_minify'][ $type ] ),
					array_diff( $options['dont_minify'][ $type ], $current_options['dont_minify'][ $type ] )
				);
				if ( $diff ) {
					foreach ( $diff as $diff_handle ) {
						$changed_group = WP_Hummingbird_Sources_Collector::get_group_from_handle( $diff_handle, $type );
						if ( $changed_group )
							$changed_groups[] = $changed_group;
					}
				}

				$key = array_search( $handle, $options['dont_combine'][ $type ] );
				if ( ! isset( $item['combine'] ) ) {
					$options['dont_combine'][ $type ][] = $handle;
				}
				elseif ( $key !== false ) {
					unset( $options['dont_combine'][ $type ][ $key ] );
				}
				$options['dont_combine'][ $type ] = array_unique( $options['dont_combine'][ $type ] );
				$diff = array_merge(
					array_diff( $current_options['dont_combine'][ $type ], $options['dont_combine'][ $type ] ),
					array_diff( $options['dont_combine'][ $type ], $current_options['dont_combine'][ $type ] )
				);
				if ( $diff ) {
					foreach ( $diff as $diff_handle ) {
						$changed_group = WP_Hummingbird_Sources_Collector::get_group_from_handle( $diff_handle, $type );
						if ( $changed_group )
							$changed_groups[] = $changed_group;
					}
				}

				$key_exists = array_key_exists( $handle, $options['position'][ $type ] );
				if ( in_array( $item['position'], array( 'header', 'footer' ) ) ) {
					$options['position'][ $type ][ $handle ] = $item['position'];
				}
				elseif ( $key_exists ) {
					unset( $options['position'][ $type ][ $handle ] );
				}
				if ( $diff = array_diff_key( $current_options['position'][ $type ], $options['position'][ $type ] ) ) {
					foreach ( $diff as $diff_handle ) {
						$changed_group = WP_Hummingbird_Sources_Collector::get_group_from_handle( $diff_handle, $type );
						if ( $changed_group )
							$changed_groups[] = $changed_group;
					}
				}
				$diff = array_merge(
					array_diff_key( $current_options['position'][ $type ], $options['position'][ $type ] ),
					array_diff_key( $options['position'][ $type ], $current_options['position'][ $type ] )
				);
				if ( $diff ) {
					foreach ( $diff as $diff_handle => $position) {
						$changed_group = WP_Hummingbird_Sources_Collector::get_group_from_handle( $diff_handle, $type );
						if ( $changed_group )
							$changed_groups[] = $changed_group;
					}
				}
			}
		}


		$changed_groups = array_unique( $changed_groups );

		// Delete those groups
		foreach ( $changed_groups as $group_key )
			wphb_delete_minification_cache_group( $group_key );

		return $options;
	}

	/**
	 * Overriden from parent class
	 */
	protected function render_inner_content() {
		$collection = wphb_minification_get_resources_collection();
		$args = array(
			'instructions' => empty( $collection['styles'] ) && empty( $collection['scripts'] )
		);

		$this->view( $this->slug . '-page', $args );
	}

	public function register_meta_boxes() {
		$collection = wphb_minification_get_resources_collection();
		$module = wphb_get_module( 'minify' );
		if ( ( empty( $collection['styles'] ) && empty( $collection['scripts'] ) ) || wphb_minification_is_checking_files() || ! $module->is_active() ) {
			$this->add_meta_box( 'enqueued-files-empty', __( 'Enqueued Files', 'wphb' ), array( $this, 'enqueued_files_empty_metabox' ), null, null, 'box-enqueued-files-empty', array( 'box_class' => 'dev-box content-box content-box-one-col-center') );
		}
		else {
			$this->add_meta_box( 'enqueued-files', __( 'Enqueued Files', 'wphb' ), array( $this, 'enqueued_files_metabox' ), null, null, 'main', array( 'box_content_class' => 'box-content no-side-padding', 'box_footer_class' => 'box-footer buttons buttons-on-right') );
			$this->add_meta_box( 'output', __( 'Output', 'wphb' ), array( $this, 'output_metabox') );
		}
	}

	public function enqueued_files_empty_metabox() {
		// Get current user name
		//$user = wp_get_current_user();
		//$user = $user->user_nicename;
		$user = get_current_user_info();
		$checking_files = wphb_minification_is_checking_files();
		$this->view( 'minification-enqueued-files-empty-meta-box', array( 'user' => $user, 'checking_files' => $checking_files ) );
	}

	public function enqueue_scripts( $hook ) {
		parent::enqueue_scripts( $hook );
		wp_enqueue_script( 'wphb-google-chart', "https://www.google.com/jsapi?autoload={'modules':[{'name':'visualization','version':'1.1','packages':['sankey']}]}" );
	}


	public function enqueued_files_metabox() {
		$collection = wphb_minification_get_resources_collection();
		$styles_rows = $this->_collection_rows( $collection['styles'], 'styles' );
		$scripts_rows = $this->_collection_rows( $collection['scripts'], 'scripts' );

		$args = compact( 'collection', 'styles_rows', 'scripts_rows' );
		$this->view( 'minification-enqueued-files-meta-box', $args );
	}


	private function _collection_rows( $collection, $type ) {
		$options = wphb_get_settings();

		/**
		 * @var WP_Hummingbird_Module_Minify $minification_module
		 */
		$minification_module = wphb_get_module( 'minify' );

		$content = '';

		foreach ( $collection as $item ) {
			/**
			 * Filter minification enqueued files items displaying
			 *
			 * @param bool $display If set to true, display the item. Default false
			 * @param array $item Item data
			 * @param string $type Type of the current item (scripts|styles)
			 */
			if ( ! apply_filters( 'wphb_minification_display_enqueued_file', true, $item, $type ) ) {
				continue;
			}

			if ( ! empty( $options['position'][ $type ][ $item['handle'] ] ) && in_array( $options['position'][ $type ][ $item['handle'] ], array( 'header', 'footer' ) ) ) {
				$position = $options['position'][ $type ][ $item['handle'] ];
			}
			else {
				$position = '';
			}

			$original_size = false;
			$compressed_size = false;

			$base_name = $type . '[' . $item['handle'] . ']';

			if ( isset ( $item['original_size'] ) )
				$original_size = number_format( $item['original_size'] / 1000 , 1 );

			if ( isset( $item['compressed_size'] ) )
				$compressed_size = number_format( $item['compressed_size'] / 1000 , 1 );

			$site_url = str_replace( array( 'http://', 'https://' ), '', get_option('siteurl') );
			$rel_src = str_replace( array( 'http://', 'https://', $site_url ), '', $item['src'] );
			$rel_src = ltrim( $rel_src, '/' );
			$full_src = $item['src'];

			$info = pathinfo( $full_src );
			$ext = isset( $info['extension'] ) ? strtoupper( $info['extension'] ) : __( 'OTHER', 'wphb' );
			if ( ! in_array( $ext, array( __( 'OTHER', 'wphb' ), 'CSS', 'JS' ) ) ) {
				$ext = __( 'OTHER', 'wphb' );
			}
			$row_error = $minification_module->errors_controller->get_handle_error( $item['handle'], $type );
			$disable_switchers = array();
			if ( $row_error ) {
				$disable_switchers = $row_error['disable'];
			}


			/**
			 * Allows to enable/disable switchers in minification page
			 *
			 * @param array $disable_switchers List of switchers disabled for an item ( include, minify, combine)
			 * @param array $item Info about the current item
			 * @param string $type Type of the current item (scripts|styles)
			 */
			$disable_switchers = apply_filters( 'wphb_minification_disable_switchers', $disable_switchers, $item, $type );

			$args = compact( 'item', 'options', 'type', 'position', 'base_name', 'original_size', 'compressed_size', 'rel_src', 'full_src', 'ext', 'row_error', 'disable_switchers' );
			$content .= $this->view( 'minification-enqueued-files-rows', $args, false );
		}

		return $content;
	}

	public function output_metabox() {

		$chart = wphb_get_chart( get_home_url() );
		$data = $chart['data'];

		$themes = array_unique( array_merge( array_keys( $data['header']['themes'] ), array_keys( $data['footer']['themes'] ) ) );
		$plugins = array_unique( array_merge( array_keys( $data['header']['plugins'] ), array_keys( $data['footer']['plugins'] ) ) );
		$options = array_merge( $themes, $plugins );

		$height = 50 * $chart['sources_number'];

		$data = wphb_prepare_chart_data_for_javascript( $chart['data'] );

		$this->view( 'minification-output-meta-box', array( 'data' => $data, 'height' => $height, 'options' => $options ) );
	}

}