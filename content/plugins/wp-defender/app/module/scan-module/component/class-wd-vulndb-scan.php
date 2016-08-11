<?php

/**
 * @author: Hoang Ngo
 */
class WD_Vulndb_Scan extends WD_Scan_Abstract {
	const IS_DONE = 'wd_vulndb_done';
	protected $end_point = "https://premium.wpmudev.org/api/defender/v1/vulnerabilities";
	public $name = '';

	public function init() {
		$this->name               = __( "Vulnerability scan", wp_defender()->domain );
		$this->percentable        = false;
		$this->dashboard_required = true;
	}

	/**
	 * @return bool
	 */
	public function process() {
		if ( ! $this->maybe_run_this_scan( $this->model ) ) {
			return false;
		}

		set_time_limit( 0 );
		//init the message first
		$this->model->message = __( "Checking for any published vulnerabilities your plugins & themes...", wp_defender()->domain );
		$this->model->save();

		$result = $this->scan();
		if ( is_wp_error( $result ) ) {
			$this->model->status  = WD_Scan_Result_Model::STATUS_ERROR;
			$this->model->message = $result->get_error_message();
			$this->model->save();

			return false;
		} else {
			$data = array();
			if ( count( $result['wordpress'] ) ) {
				$item       = new WD_Scan_Result_VulnDB_Item_Model();
				$item->id   = uniqid();
				$item->name = __( "WordPress Vulnerability", wp_defender()->domain );
				$item->type = 'wordpress';
				$detail     = array();
				foreach ( $result['wordpress'] as $bug ) {
					$detail[] = array(
						'vuln_type' => $bug['vuln_type'],
						'title'     => $bug['title'],
						'ref'       => $bug['references'],
						'fixed_in'  => $bug['fixed_in']
					);
				}
				$item->detail                           = $detail;
				$this->model->item_indexes[ $item->id ] = $item->name;
				$this->model->add_item( $item );
			}

			if ( count( $result['plugins'] ) ) {
				foreach ( $result['plugins'] as $slug => $plugin ) {
					if ( isset( $plugin['confirmed'] ) ) {
						$item       = new WD_Scan_Result_VulnDB_Item_Model();
						$item->id   = uniqid();
						$item->name = $slug;
						$item->type = 'plugin';
						foreach ( $plugin['confirmed'] as $bug ) {
							$item->detail[] = array(
								'vuln_type' => $bug['vuln_type'],
								'title'     => $bug['title'],
								'ref'       => $bug['references'],
								'fixed_in'  => $bug['fixed_in'],
							);
						}
						$this->model->item_indexes[ $item->id ] = $item->name;
						$this->model->add_item( $item );
					} elseif ( isset( $plugin['possible'] ) ) {
						$item            = new WD_Scan_Result_VulnDB_Item_Model();
						$item->id        = uniqid();
						$item->name      = $slug;
						$item->type      = 'plugin';
						$item->confirmed = false;
						foreach ( $plugin['possible'] as $bug ) {
							$item->detail[] = array(
								'vuln_type' => $bug['vuln_type'],
								'title'     => $bug['title'],
								'ref'       => $bug['references'],
								'fixed_in'  => $bug['fixed_in'],
							);
						}
						$this->model->item_indexes[ $item->id ] = $item->name;
						$this->model->add_item( $item );
					}

					if ( is_object( $this->last_scan ) && isset( $item ) ) {
						$is_ignored = $this->last_scan->is_file_ignored( $slug, 'WD_Scan_Result_VulnDB_Item_Model' );
						//if it is ingnored, we add it to the list
						if ( $is_ignored && $item instanceof WD_Scan_Result_VulnDB_Item_Model ) {
							$this->model->ignore_files[] = $item->id;
						}
					}
				}
			}

			if ( count( $result['themes'] ) ) {
				foreach ( $result['themes'] as $slug => $theme ) {
					if ( isset( $theme['confirmed'] ) ) {
						$item       = new WD_Scan_Result_VulnDB_Item_Model();
						$item->id   = uniqid();
						$item->name = $slug;
						$item->type = 'theme';
						foreach ( $theme['confirmed'] as $bug ) {
							$item->detail[] = array(
								'vuln_type' => $bug['vuln_type'],
								'title'     => $bug['title'],
								'ref'       => $bug['references'],
								'fixed_in'  => $bug['fixed_in']
							);
						}
						$this->model->item_indexes[ $item->id ] = $item->name;
						$this->model->add_item( $item );
					} elseif ( isset( $theme['possible'] ) ) {
						$item            = new WD_Scan_Result_VulnDB_Item_Model();
						$item->id        = uniqid();
						$item->name      = $slug;
						$item->type      = 'theme';
						$item->confirmed = false;
						foreach ( $theme['possible'] as $bug ) {
							$item->detail[] = array(
								'vuln_type' => $bug['vuln_type'],
								'title'     => $bug['title'],
								'ref'       => $bug['references'],
								'fixed_in'  => $bug['fixed_in'],
							);
						}
						$this->model->item_indexes[ $item->id ] = $item->name;
						$this->model->add_item( $item );
					}

					if ( is_object( $this->last_scan ) && isset( $item ) ) {
						$is_ignored = $this->last_scan->is_file_ignored( $slug, 'WD_Scan_Result_VulnDB_Item_Model' );
						//if it is ingnored, we add it to the list
						if ( $is_ignored && $item instanceof WD_Scan_Result_VulnDB_Item_Model ) {
							$this->model->ignore_files[] = $item->id;
						}
					}
				}
			}
			//$this->model->result = array_merge( $this->model->result, $data );
			//$this->model->item_indexes = array_merge( $this->model->item_indexes, $data );
			$this->model->save();
			WD_Utils::cache( self::IS_DONE, 1 );

			return true;
		}
	}

	/**
	 * Prepare the data before submitting
	 *
	 * @param null $wp_version
	 * @param array $plugins
	 * @param array $themes
	 *
	 * @return array|mixed|object|WP_Error
	 */
	public function scan( $wp_version = null, $plugins = array(), $themes = array() ) {
		if ( ! function_exists( 'get_plugins' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		}
		if ( is_null( $wp_version ) ) {
			global $wp_version;
		}

		if ( empty( $plugins ) ) {
			//get all the plugins, even activate or not, as in network
			foreach ( get_plugins() as $slug => $plugin ) {
				$base_slug             = explode( DIRECTORY_SEPARATOR, $slug );
				$base_slug             = array_shift( $base_slug );
				$plugins[ $base_slug ] = $plugin['Version'];
			}
		}

		if ( empty( $themes ) ) {
			foreach ( wp_get_themes() as $theme ) {
				$themes[ $theme->get_template() ] = $theme->Version;
			}
		}

		$response = $this->wpmudev_call( $this->end_point, array(
			'themes'    => json_encode( $themes ),
			'plugins'   => json_encode( $plugins ),
			'wordpress' => $wp_version
		), array(
			'method'  => 'POST',
			'timeout' => 15
		), true );

		if ( is_wp_error( $response ) ) {
			return $response;
		}
		if (
			'OK' !== wp_remote_retrieve_response_message( $response )
			OR 200 !== wp_remote_retrieve_response_code( $response )
		) {
			//if goes here, means st happen
			$body = wp_remote_retrieve_body( $response );
			$body = json_decode( $body, true );
			if ( is_array( $body ) ) {
				return new WP_Error( $body['code'], $body['message'] );
			}
		} else {
			$data = wp_remote_retrieve_body( $response );
			$this->log( var_export( $data, true ) );

			return json_decode( $data, true );
		}
	}

	public function check() {
		if ( WD_Utils::get_cache( self::IS_DONE ) == 1 ) {
			return true;
		}

		return false;
	}

	public function clean_up() {
		WD_Utils::remove_cache( self::IS_DONE );
	}

	public function is_enabled() {
		if ( WD_Utils::get_setting( 'use_' . WD_Scan_Api::SCAN_VULN_DB . '_scan' ) != 1 ) {

			return false;
		}

		if ( $this->dashboard_required && WD_Utils::get_dev_api() == false ) {
			return false;
		}

		return true;
	}
}