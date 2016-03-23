<?php

/**
 * Class WP_Hummingbird_Minification_Chart
 *
 * Manage all relaated to chart data
 */
class WP_Hummingbird_Minification_Chart {

	/**
	 * Save all the chart data
	 *
	 * @var array
	 */
	private $chart_data = array();

	private $url = '';

	/**
	 * @var integer Count the number of sources in the chart
	 */
	private $sources_number = 0;

	/**
	 * Add a new group to the chart data
	 *
	 * @param string $hash Group hash ID
	 * @param string $position footer|header
	 * @param string $type scripts|styles
	 * @param string $src Source URL
	 */
	public function add_source( $hash, $position, $type, $src ) {
		$url = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

		$this->chart_data[] = array(
			'group' => $hash,
			'url' => $url,
			'src' => $src,
			'position' => $position,
			'type' => $type,
		);
	}

	/**
	 * Return the sources that we have gathered throug self::add_source()
	 * They are not those that are saved in DB.
	 *
	 * @return array
	 */
	public function get_sources() {
		return $this->chart_data;
	}

	/**
	 * Save the collected data in DB
	 *
	 * @param array $chart_data
	 */
	public function save_chart_data( $chart_data ) {
		if ( empty( $chart_data ) )
			return;

		$model = wphb_get_model();
		foreach ( $chart_data as $data ) {
			$model->insert_chart_src( $data['group'], $data['url'], $data['src'], $data['position'], $data['type'] );
		}

		//set_transient( 'wphb-collect-chart', true, 60 * 60 * 12 ); // We collect data every 12 hours
	}

	public function delete_group( $hash ) {
		if ( ! is_front_page() )
			return;

		$model = wphb_get_model();
		$model->delete_chart_group( $hash );
	}

	public function get_chart_data( $url ) {
		$model = wphb_get_model();
		$url = wphb_sanitize_chart_url( $url );
		return $model->get_chart_data( $url );
	}

	// ** RENDERING FUNCTIONS **/
	public function set_chart_url( $url ) {
		$this->url = $url;
	}

	public function group_data() {
		$data = array();
		$raw_data = $this->get_chart_data( wphb_sanitize_chart_url( $this->url ) );

		$data['header'] = $this->group_data_by_position( $raw_data, 'header' );
		$data['footer'] = $this->group_data_by_position( $raw_data, 'footer' );

		$data['header'] = $this->group_data_by_origin( $data['header'] );
		$data['footer'] = $this->group_data_by_origin( $data['footer'] );

		$data['groups'] = $this->get_data_groups_info( $raw_data );

		return $data;
	}

	/**
	 * Return the chart data already prepared to be rendered
	 */
	public function chart() {
		$cache_key = wphb_sanitize_chart_url( $this->url ) . '_chart_data';
		$chart = wp_cache_get( $cache_key, 'wphb' );

		if ( false === $chart ) {
			$data = $this->group_data();
			$sources_number = $this->get_sources_number();
			$chart = array(
				'data' => $data,
				'sources_number' => $sources_number
			);

			wp_cache_set( $cache_key, $chart, 'wphb' );
		}

		return $chart;
	}

	public function get_data_groups_info( $raw_data ) {
		$data = array();
		$groups_hashes = array();

		// Two loops, yeah

		// One to collect the group hashes
		foreach ( $raw_data as $item ) {
			$groups_hashes[] = $item['group_hash'];
		}

		$groups_hashes = array_unique( $groups_hashes );

		// Another to create relationships between srcs and group hashes
		foreach ( $raw_data as $item ) {
			if ( ! $item['src'] )
				continue;

			$key = array_search( $item['group_hash'], $groups_hashes );
			$group_key = $item['type'] == 'styles' ? 'css' : 'js';
			$group_key .= '-' . $key;

			$data[ $item['src'] ][] = $group_key;
		}

		return $data;
	}

	public function group_data_by_position( $raw_data, $position ) {
		$data = array();

		foreach ( $raw_data as $item ) {
			if ( ! $item['src'] )
				continue;

			if ( $item['position'] != $position )
				continue;

			if ( ! isset( $data[ $item['group_hash'] ] ) )
				$data[ $item['group_hash'] ] = array();

			$data[ $item['group_hash'] ][] = $item['src'];

		}

		return $data;
	}

	public function group_data_by_origin( $data ) {
		$data_by_origin = array(
			'themes' => array(),
			'plugins' => array(),
			'core' => array()
		);

		$theme = wp_get_theme();
		$active_plugins = get_option('active_plugins', array() );
		if ( is_multisite() ) {
			foreach ( get_site_option('active_sitewide_plugins', array() ) as $plugin => $item ) {
				$active_plugins[] = $plugin;
			}
		}

		foreach ( $data as $group_hash => $sources ) {

			foreach ( $sources as $src ) {

				$this->sources_number++;

				$found_match = false;

				if ( preg_match( '/wp-content\/themes\/(.*)\//', $src, $matches ) ) {
					if ( ! isset( $data_by_origin['themes'][ $theme->name ] ) )
						$data_by_origin['themes'][ $theme->name ] = array();

					$data_by_origin['themes'][ $theme->name ][ $src ] = $src;

					$found_match = true;
				}
				elseif ( preg_match( '/wp-content\/plugins\/([\w-_]*)\//', $src, $matches ) ) {

					// The source comes from a plugin
					foreach ( $active_plugins as $active_plugin ) {
						$found_match = stristr( $active_plugin, $matches[1] );

						if ( $found_match ) {

							// It seems that we found the plguin but let's double check
							$plugin_data = get_plugin_data( WP_PLUGIN_DIR . '/' . $active_plugin );
							if ( ! $plugin_data['Name'] ) {
								// Nope
								$found_match = false;
							}
							else {
								// Yes, add it to our list
								if ( ! isset( $data_by_origin['plugins'][ $plugin_data['Name'] ] ) )
									$data_by_origin['plugins'][ $plugin_data['Name'] ] = array();

								$data_by_origin['plugins'][ $plugin_data['Name'] ][ $src ] = $src;
							}
							break;
						}

					}
				}

				if ( ! $found_match ) {
					$data_by_origin['core'][ $src ] = $src;
				}

			}

		}

		return $data_by_origin;
	}

	public static function prepare_for_javascript( $data ) {
		$js_data = array();
		foreach ( $data as $position => $lists ) {

			if ( $position == 'groups' )
				continue;

			$position_text = $position == 'footer' ? __( 'Footer', 'wphb' ) : __( 'Header', 'wphb' );

			$themes_and_plugins = array_merge( $lists['themes'], $lists['plugins'] );
			foreach ( $themes_and_plugins as $name => $sources ) {
				foreach ( $sources as $src ) {
					$js_data[] = array( self::_truncate_src( $src ), $data['groups'][$src][0], 1 );
					$js_data[] = array( $data['groups'][$src][0], $position_text, 1 );
				}
			}


			foreach ( $lists['core'] as $src ) {
				$js_data[] = array( self::_truncate_src( $src ), $data['groups'][$src][0], 1 );
				$js_data[] = array( $data['groups'][$src][0], $position_text, 1 );
			}

		}

		return json_encode( $js_data );
	}

	private static function _truncate_src( $src ) {
		$src = basename( $src );

		if ( strlen( $src ) <= 45 )
			return $src;

		$src = substr( $src, 0, 45 );
		$src .= '...';

		return $src;
	}

	public function get_sources_number() {
		return $this->sources_number;
	}

}