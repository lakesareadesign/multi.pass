<?php

/**
 * @author: Hoang Ngo
 */
class WD_Scan_Result_File_Item_Model extends WD_Scan_Result_Item_Model {
	public $score;
	public $delete_tooltip;
	public $delete_confirm_text;

	public function __wakeup() {
		$this->score = $this->detail['score'];
		$location    = $this->determine_location();

		if ( $location == 'theme' ) {
			$this->delete_tooltip      = esc_html__( "Delete this theme", wp_defender()->domain );
			$this->delete_confirm_text = 'delete_theme_confirm_msg';
		} elseif ( $location == 'plugin' ) {
			$this->delete_tooltip      = esc_html__( "Delete this plugin", wp_defender()->domain );
			$this->delete_confirm_text = 'delete_plugin_confirm_msg';
		} elseif ( empty( $location ) ) {
			$this->delete_tooltip      = esc_html__( "Delete this file", wp_defender()->domain );
			$this->delete_confirm_text = 'delete_confirm_msg';
		}
	}

	public function can_automate_resolve() {
		return false;
	}

	public function get_name() {
		return pathinfo( $this->name, PATHINFO_BASENAME );
	}

	public function get_sub() {
		return str_replace( ABSPATH, '/', $this->name );
	}

	public function get_detail() {
		return '<img class="text-warning" src="' . wp_defender()->get_plugin_url() . 'assets/img/robot.png' . '"/> <strong>' . esc_html__( "Suspicious function found", wp_defender()->domain ) . '</strong>' . $this->get_suspicious_gauge();
	}

	public function get_type() {
		return WD_Scan_Result_Model::get_system_type_label( WD_Scan_Result_Model::TYPE_FILE );
	}

	private function get_suspicious_gauge() {
		if ( $this->score <= 26 ) {
			return '<span class="wd-suspicious-light">' . esc_html__( "Low", wp_defender()->domain ) . '</span>';
		} elseif ( $this->score <= 35 ) {
			return '<span class="wd-suspicious-medium">' . esc_html__( "Medium", wp_defender()->domain ) . '</span>';
		} elseif ( $this->score > 35 ) {
			return '<span class="wd-suspicious-strong">' . esc_html__( "High", wp_defender()->domain ) . '</span>';
		}
	}

	public function get_system_type() {
		return WD_Scan_Result_Model::TYPE_FILE;
	}

	public function can_ignore() {
		return true;
	}

	/**
	 *
	 */
	public function remove() {
		$location = $this->determine_location();
		if ( $location == 'plugin' ) {
			//remove whole plugin
			$plugin = $this->find_plugin_data();
			if ( ! function_exists( 'delete_plugins' ) ) {
				require_once ABSPATH . 'wp-admin/includes/plugin.php';
			}
			if ( ! is_null( $plugin ) ) {
				//always be here
				$ret    = delete_plugins( array( $plugin['slug'] ) );
				$folder = pathinfo( WP_CONTENT_DIR . '/plugins/' . $plugin['slug'], PATHINFO_DIRNAME );
				if ( $ret === true ) {
					$model = WD_Scan_Api::get_last_scan();
					//we need to find all result relate to this
					$issues = $model->result;
					foreach ( $issues as $issue ) {
						if ( $issue instanceof WD_Scan_Result_File_Item_Model && strpos( $issue->name, $folder ) === 0 ) {
							//this files inside this plugin, so we need to remove the index
							$model->delete_item_from_result( $issue->id );
						}
					}
				}

				return $ret;
			}
		} elseif ( $location == 'theme' ) {
			if ( ! function_exists( 'delete_theme' ) ) {
				require_once ABSPATH . 'wp-admin/includes/theme.php';
			}
			//remove theme
			$theme = $this->find_theme_data();
			if ( ! is_null( $theme ) ) {
				$stylesheet = $theme->get_stylesheet();
				$folder     = $theme->get_stylesheet_directory();
				$ret        = delete_theme( $stylesheet );
				if ( $ret === true ) {
					$model  = WD_Scan_Api::get_last_scan();
					$issues = $model->result;
					foreach ( $issues as $issue ) {
						if ( $issue instanceof WD_Scan_Result_File_Item_Model && strpos( $issue->name, $folder ) === 0 ) {
							//this files inside this plugin, so we need to remove the index
							$model->delete_item_from_result( $issue->id );
						}
					}
				}

				return $ret;
			}
		} elseif ( empty( $location ) ) {
			//files belong to no where, deleteable
			if ( @unlink( $this->name ) ) {
				$model = WD_Scan_Api::get_last_scan();
				$model->delete_item_from_result( $this->id );
			} else {
				return new WP_Error( 'cant_remove', sprintf( esc_html__( "We can't remove the file %s, this might be caused by lack of permissions, please remove the file manually.", wp_defender()->domain ), $this->name ) );
			}
		}
	}

	public function get_raw_data() {
		return array(
			'file' => $this->name,
			'type' => 'malicious_code',
			'date' => @filemtime( $this->name ),
			'size' => @filesize( $this->name )
		);
	}

	/**
	 * @return null|array
	 */
	private function find_plugin_data() {
		$path        = $this->name;
		$plugins_dir = WP_CONTENT_DIR . '/plugins/';
		$parts       = explode( DIRECTORY_SEPARATOR, str_replace( $plugins_dir, '', $path ) );
		$folder      = array_shift( $parts );
		$plugins     = get_plugins();
		foreach ( $plugins as $key => $plugin ) {
			if ( strpos( $key, $folder . '/' ) === 0 ) {
				$plugin['slug'] = $key;

				return $plugin;
			}
		}

		return null;
	}

	/**
	 * @return null|WP_Theme
	 */
	private function find_theme_data() {
		$path       = $this->name;
		$themes_dir = WP_CONTENT_DIR . '/themes/';
		$parts      = explode( DIRECTORY_SEPARATOR, str_replace( $themes_dir, '', $path ) );
		$folder     = array_shift( $parts );
		$theme      = wp_get_theme( $folder );
		if ( $theme->exists() ) {
			return $theme;
		}

		return null;
	}

	public function clean() {
		/**
		 * if this file inside a plugin, or theme, we will trying to find the theme and recommend user to replace
		 * all files with the new download
		 * if this is not inside a plugin or theme, recommend to quarantine it
		 */
		$output = $this->_get_resolve_html_template();

		$output = str_replace(
			array(
				'{{location}}',
				'{{size}}',
				'{{date}}'
			),
			array(
				$this->name,
				$this->convert_size( @filesize( $this->name ) ),
				date_i18n( get_option( 'date_format' ) . ' ' . get_option( 'time_format' ), @filemtime( $this->name ) )
			),
			$output );


		$location = $this->determine_location();
		$html     = "";
		switch ( $location ) {
			case 'plugin':
				$plugin = $this->find_plugin_data();
				if ( ! is_null( $plugin ) ) {
					$html   = sprintf( __( "Suspicious code has been found in the file <strong>%s</strong>, which is in the plugin <a target='_blank' href=\"%s\">%s</a>. We recommend re-downloading <a target='_blank' href=\"%s\">%s</a> and replacing your existing files with a newer version, just to be on the safe side. ", wp_defender()->domain ),
						$this->get_sub(), $plugin['PluginURI'], $plugin['Name'], $plugin['PluginURI'], $plugin['Name'] );
					$output = str_replace( '{{delete_button_text}}', esc_html__( "Delete this plugin", wp_defender()->domain ), $output );
				}
				break;
			case 'theme':
				$theme = $this->find_theme_data();
				if ( ! is_null( $theme ) ) {
					$html   = sprintf( __( "Suspicious code has been found in the file  <strong>%s</strong>, which inside the theme  <a target='_blank' href=\"%s\">%s</a>. We recommend re-downloading  <a target='_blank' href=\"%s\">%s</a> and replacing your existing files with a newer version, just to be on the safe side. ", wp_defender()->domain ),
						$this->get_sub(), $theme->get( 'ThemeURI' ), $theme->Name, $theme->get( 'ThemeURI' ), $theme->Name );
					$output = str_replace( '{{delete_button_text}}', esc_html__( "Delete this theme", wp_defender()->domain ), $output );
				}
				break;
			case 'mu_plugin':
				$data = array_values( get_plugin_data( $this->name ) );
				$data = array_filter( $data );
				if ( empty( $data ) ) {
					$html = esc_html__( "This file does’nt seem to belong to any of your themes or plugins. We recommend isolating or removing it. ", wp_defender()->domain );
				} else {
					//this has some data, if we can't determine plugin name & url, show info
					$name = $data['Name'];

					if ( ! empty( $name ) ) {
						$html = sprintf( __( "Suspicious code has been found in the file <strong>%s</strong>, which is in the plugin <strong>%s</strong>.  We recommend re-downloading <strong>%s</strong> and replacing your existing files with a newer version, just to be on the safe side. ", wp_defender()->domain ),
							$this->get_sub(), $name, $name );
					} else {
						$html = esc_html__( "This file does’nt seem to belong to any of your themes or plugins. We recommend isolating or removing it. ", wp_defender()->domain );
					}

				}
				break;
		}
		//if still here, means doesnt theme, but injection
		if ( empty( $html ) ) {
			$html = esc_html__( "This file does’nt seem to belong to any of your themes or plugins. We recommend isolating or removing it. ", wp_defender()->domain );
		}
		//just in case the delete text doesnt replace
		$output       = str_replace( '{{delete_button_text}}', esc_html__( "Delete this file", wp_defender()->domain ), $output );
		$html         = '<p>' . $html . '</p>';
		$warning_line = '';
		if ( $this->score <= 26 ) {
			$warning_line .= __( "The level of suspicion here is <strong>low</strong>, so this could be a false alarm.", wp_defender()->domain );
		} else {
			$warning_line .= sprintf( __( "The level of suspicion here is <strong>%s</strong>, so act quickly!", wp_defender()->domain ), strtolower( $this->get_suspicious_gauge() ) );
		}
		$warning_line = '<p>' . $warning_line . '</p>';
		$html .= $warning_line;
		$output = str_replace( '{{resolve_note}}', $html, $output );

		return $output;
	}

	/**
	 * @return string
	 */
	private function determine_location() {
		$path           = $this->name;
		$plugins_dir    = WP_CONTENT_DIR . '/plugins/';
		$mu_plugins_dir = WPMU_PLUGIN_DIR;
		$themes_dir     = WP_CONTENT_DIR . '/themes/';
		$include_dir    = ABSPATH . 'wp-include/';
		$admin_dir      = ABSPATH . 'wp-admin';

		$location = '';

		if ( strpos( $path, $themes_dir ) === 0 ) {
			//file inside theme
			$location = 'theme';
		} elseif ( strpos( $path, $plugins_dir ) === 0 ) {
			//file inslude plugin
			$location = 'plugin';
		} elseif ( strpos( $path, $mu_plugins_dir ) === 0 ) {
			$location = 'mu_plugin';
		} elseif ( strpos( $path, $include_dir ) === 0 ) {
			$location = 'wp_include';
		} elseif ( strpos( $path, $admin_dir ) === 0 ) {
			$location = 'wp_admin';
		}

		return $location;
	}

	public function check() {
		$model = WD_Scan_Api::get_last_scan();
		if ( ! file_exists( $this->name ) ) {
			$model->delete_item_from_result( $this->id );

			return true;
		}

		return false;
	}

	private function _get_resolve_html_template() {
		ob_start();
		?>
		<div class="wp-defender">
			<div class="wd-scan-resolve-dialog">
				<div class="group">
					<div class="col span_3_of_12">
						<strong><?php esc_html_e( "Location: ", wp_defender()->domain ) ?></strong>
					</div>
					<div class="col span_9_of_12">
						{{location}}
					</div>
				</div>
				<div class="group">
					<div class="col span_3_of_12">
						<strong><?php esc_html_e( "Size: ", wp_defender()->domain ) ?></strong>
					</div>
					<div class="col span_9_of_12">
						{{size}}
					</div>
				</div>
				<div class="group">
					<div class="col span_3_of_12">
						<strong><?php echo esc_html__( "Date added/modified: " ) ?></strong>
					</div>
					<div class="col span_9_of_12">
						{{date}}
					</div>
				</div>
				<hr/>
				<div>
					{{resolve_note}}
				</div>
				<div class="wd-ignore-cancel">
					<form method="post" class="wd-resolve-frm">
						<input type="hidden" name="action" value="wd_resolve_result">
						<?php wp_nonce_field( 'wd_resolve', 'wd_resolve_nonce' ) ?>
						<input type="hidden" value="<?php echo esc_attr( get_class( $this ) ) ?>" name="class">
						<input type="hidden" name="id" value="<?php echo esc_attr( $this->id ) ?>"/>
						<?php if ( $this->can_ignore() ): ?>
							<button type="submit" data-confirm-button="<?php echo 'ignore_confirm_btn' ?>"
							        data-confirm="<?php echo 'ignore_confirm_msg' ?>" data-type="ignore"
							        class="button button-grey button-small">
								<?php esc_html_e( "Ignore File", wp_defender()->domain ) ?>
							</button>&nbsp;
						<?php endif; ?>
						<?php if ( $this->can_delete() ): ?>
							<button data-type="delete" data-confirm-button="<?php echo 'delete_confirm_btn' ?>"
							        data-confirm="<?php echo esc_attr( $this->delete_confirm_text ) ?>" type="submit"
							        class="button button-red button-small">
								{{delete_button_text}}
							</button>
						<?php endif; ?>
					</form>
				</div>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}