<?php

/**
 * @author: Hoang Ngo
 */
class WD_Scan_Result_VulnDB_Item_Model extends WD_Scan_Result_Item_Model {
	public $type;
	public $object;
	public $confirmed = true;
	public $delete_tooltip;
	public $delete_confirm_text;

	public function __wakeup() {
		if ( $this->type == 'theme' ) {
			$this->delete_tooltip      = __( "Delete this theme", wp_defender()->domain );
			$this->delete_confirm_text = 'delete_theme_confirm_msg';
		} elseif ( $this->type == 'plugin' ) {
			$this->delete_tooltip      = __( "Delete this plugin", wp_defender()->domain );
			$this->delete_confirm_text = 'delete_plugin_confirm_msg';
		}
	}

	public function can_automate_resolve() {
		return false;
	}

	public function get_name() {
		switch ( $this->type ) {
			case 'wordpress':
				return __( "WordPress Vulnerability", wp_defender()->domain );
				break;
			case 'plugin':
				$plugins = get_plugins();
				foreach ( $plugins as $slug => $plugin ) {
					if ( strpos( $slug, $this->name ) === 0 ) {
						$this->object         = $plugin;
						$this->object['slug'] = $slug;

						return $plugin['Name'];
					}
				}
				break;
			case 'theme':
				//gues the theme
				$theme = wp_get_theme( $this->name );
				if ( is_object( $theme ) ) {
					$this->object = $theme;

					return $theme->Name;
				}
				break;
		}
	}

	/**
	 * @return string
	 */
	public function get_sub( $is_raw = false ) {
		if ( is_null( $this->object ) ) {
			//init
			$this->get_name();
		}

		if ( $this->type == 'wordpress' ) {
			global $wp_version;
			$version = $wp_version;
		} else {
			if ( is_array( $this->object ) ) {
				$version = $this->object['Version'];
			} else {
				$version = $this->object->Version;
			}
		}

		if ( $is_raw == true ) {
			return $version;
		}

		return sprintf( __( "Version: %s", wp_defender()->domain ), $version );
	}

	/**
	 * @return string
	 */
	public function get_detail() {
		$tmp = array_values( $this->detail );
		if ( ! is_array( array_shift( $tmp ) ) ) {
			$this->detail = array( $this->detail );
		}
		$html = '';
		foreach ( $this->detail as $key => $row ) {
			$html .= '<i class="wd-text-warning wdv-icon wdv-icon-fw wdv-icon-exclamation-sign"></i> <strong>' . $row['title'] . '</strong>';
			$html .= '<span> - ' . __( "Vulnerability type", wp_defender()->domain ) . ':' . $row['vuln_type'] . '</span>';
			if ( ! empty( $row['fixed_in'] ) ) {
				$html .= '<span> - ' . sprintf( __( "This bug has been fixed in version %s", wp_defender()->domain ), $row['fixed_in'] ) . '</span>';
			}
			$html .= "<span class='blank-line'></span>";
		}


		return $html;
	}

	/**
	 * @return null
	 */
	public function get_type() {
		if ( $this->type == 'plugin' ) {
			return WD_Scan_Result_Model::get_system_type_label( WD_Scan_Result_Model::TYPE_PLUGIN );
		} elseif ( $this->type == 'theme' ) {
			return WD_Scan_Result_Model::get_system_type_label( WD_Scan_Result_Model::TYPE_THEME );
		} else {
			return WD_Scan_Result_Model::get_system_type_label( WD_Scan_Result_Model::TYPE_CORE );
		}
	}

	/**
	 * @return string
	 */
	public function get_system_type() {
		if ( $this->type == 'plugin' ) {
			return WD_Scan_Result_Model::TYPE_PLUGIN;
		} elseif ( $this->type == 'theme' ) {
			return WD_Scan_Result_Model::TYPE_THEME;
		} else {
			return WD_Scan_Result_Model::TYPE_CORE;
		}
	}

	public function can_delete() {
		if ( $this->get_system_type() == WD_Scan_Result_Model::TYPE_CORE ) {
			return false;
		}

		return true;
	}

	/**
	 * @return bool|null|void|WP_Error
	 */
	public function remove() {
		if ( ! $this->can_delete() ) {
			return;
		}
		if ( $this->type == 'plugin' ) {
			if ( ! function_exists( 'delete_plugins' ) ) {
				require_once ABSPATH . 'wp-admin/includes/plugin.php';
			}
			if ( is_null( $this->object ) ) {
				$this->get_name();
			}

			$ret = delete_plugins( array( $this->object['slug'] ) );
			if ( $ret === true ) {
				$model = WD_Scan_Api::get_last_scan();

				$model->delete_item_from_result( $this->id );
			}

			return $ret;
		} else {
			if ( ! function_exists( 'delete_theme' ) ) {
				require_once ABSPATH . 'wp-admin/includes/theme.php';
			}
			if ( is_null( $this->object ) ) {
				$this->get_name();
			}
			$stylesheet = $this->object->get_stylesheet();
			$ret        = delete_theme( $stylesheet );
			if ( $ret === true ) {
				$model = WD_Scan_Api::get_last_scan();

				$model->delete_item_from_result( $this->id );
			}

			return $ret;
		}
	}

	/**
	 * @return array
	 */
	public function get_raw_data() {
		return array(
			'name'    => $this->get_name(),
			'type'    => 'vuln_db',
			'version' => $this->get_sub( true ),
			'wp_type' => $this->type
		);
	}

	public function clean() {
		$output = $this->_get_resolve_html_template();
		$vulndb = "";
		$tmp    = array_values( $this->detail );
		if ( ! is_array( array_shift( $tmp ) ) ) {
			$this->detail = array( $this->detail );
		}
		$fixed_in = $this->get_fixed_in();
		foreach ( $this->detail as $row ) {
			$vulndb .= '<p>' . $row['title'] . '</p>';
		}

		$output = str_replace(
			array( '{{name}}', '{{version}}', '{{vulnerability}}' ),
			array( $this->get_name(), $this->get_sub(), $vulndb ),
			$output
		);

		$resolve_note = '<p>' . __( "There’s a newer version available that fixes this issue. We recommend updating to the latest release.", wp_defender()->domain ) . '</p>';
		if ( $this->type == 'wordpress' ) {
			$wp_update_form = '<a href="' . admin_url( 'update-core.php' ) . '" class="button button-small">' . __( "Update Now", wp_defender()->domain ) . '</a>';
			$output         = str_replace( '{{resolve_form}}', $wp_update_form, $output );
		} elseif ( is_array( $this->object ) ) {
			wp_update_plugins();
			$plugins            = get_site_transient( 'update_plugins' );
			$plugin_update_form = '';

			foreach ( $plugins->response as $key => $plugin ) {
				if ( $plugin->plugin == $this->object['slug'] ) {
					$plugin_update_form .= '<form class="wd-resolve-plugins-update">';
					$plugin_update_form .= wp_nonce_field( 'updates', '_ajax_nonce', true, false );
					$plugin_update_form .= '<input type="hidden" name="action" value="update-plugin">';
					$plugin_update_form .= '<input type="hidden" name="plugin" value="' . $key . '">';
					$plugin_update_form .= '<input type="hidden" name="slug" value="' . $plugin->slug . '">';
					$plugin_update_form .= '<button type="submit" class="button button-small wd-button">';
					$plugin_update_form .= __( "Update", wp_defender()->domain );
					$plugin_update_form .= '</button></form>';
					break;
				}
			}

			if ( empty( $plugin_update_form ) ) {
				$resolve_note .= '<p>' . __( "It seems your plugin is a premium plugin, please visit the plugin page for more information.", wp_defender()->domain ) . '</p>';
				$plugin_update_form .= '<a target="_blank" href="' . $this->object['PluginURI'] . '" class="button wd-button button-small">' . __( "Visit plugin page", wp_defender()->domain ) . '</a>';
			}
			$output = str_replace( '{{delete_button_text}}', __( "Delete plugin", wp_defender()->domain ), $output );

			//$resolve_note .= $plugin_update_form;
			$output = str_replace( '{{resolve_form}}', $plugin_update_form, $output );
		} elseif ( is_object( $this->object ) ) {
			wp_update_themes();
			$themes            = get_site_transient( 'update_themes' );
			$theme_update_form = '';
			foreach ( $themes->response as $key => $theme ) {
				if ( $theme['theme'] == $this->name ) {
					$theme_update_form .= '<form class="wd-resolve-plugins-update">';
					$theme_update_form .= wp_nonce_field( 'wd_update_theme', 'wd_resolve_nonce', true, false );
					$theme_update_form .= '<input type="hidden" name="action" value="wd_resolve_update_theme">';
					$theme_update_form .= '<input type="hidden" name="theme" value="' . $key . '">';
					$theme_update_form .= '<button type="submit" class="button button-small wd-button">';
					$theme_update_form .= __( "Update", wp_defender()->domain );
					$theme_update_form .= '</button></form>';
					break;
				}
			}

			if ( empty( $theme_update_form ) ) {
				//this mean premium
				//todo check if this is wpmudev
				$resolve_note .= '<p>' . __( "It seems your theme is a premium theme, please visit the theme page for more information.", wp_defender()->domain ) . '</p>';
				$theme = wp_get_theme( $this->name );
				$uri   = $theme->get( 'ThemeURI' );
				$theme_update_form .= '<a target="_blank" href="' . $uri . '" class="button wd-button button-small">' . __( "Visit theme page", wp_defender()->domain ) . '</a>';
			}
			$output = str_replace( '{{delete_button_text}}', __( "Delete theme", wp_defender()->domain ), $output );

			//$resolve_note .= $theme_update_form;
			$output = str_replace( '{{resolve_form}}', $theme_update_form, $output );
		}
		$output = str_replace( '{{resolve_note}}', $resolve_note, $output );

		return $output;
	}

	private function get_fixed_in() {
		$fixed_in = 0;
		foreach ( $this->detail as $row ) {
			if ( version_compare( $row['fixed_in'], $fixed_in, '>' ) ) {
				$fixed_in = $row['fixed_in'];
			}
		}

		return $fixed_in;
	}

	/**
	 * @return mixed
	 */
	public function check() {
		$this->get_name();
		//many case the plugin get deleted, so we have to check if this still here
		if ( $this->type != 'wordpress' ) {
			if ( is_null( $this->object ) ) {
				//this mean plugin/theme delete
				return true;
			}
		}
		$fixed_in = $this->get_fixed_in();
		if ( $fixed_in == 0 ) {
			return false;
		}
		// due to this native, we can't have a better place for hook when it update.
		//so we will flag for submit the api here, and remove this out of the result queue,
		//this will prevent duplicate submit to API
		if ( version_compare( $this->get_sub( true ), $fixed_in, '>=' ) ) {
			$model = WD_Scan_Api::get_last_scan();
			$model->delete_item_from_result( $this->id );
			WD_Utils::flag_for_submitting();

			return true;
		}

		/**
		 * we got a case, when in repo, we got the latest, but vulndb said it old, this case we just need to remove
		 *
		 */
		if ( $this->type == 'plugin' ) {
			$plugin = WD_Utils::is_plugin_update_available( $this->object['slug'] );
			if ( is_object( $plugin ) ) {
				//no update available, which mean is latest, nothing to do here, so hide this error
				return true;
			}
		}

		return false;
	}

	/**
	 * @return string
	 */
	private function _get_resolve_html_template() {
		ob_start();
		?>
		<div class="wp-defender">
			<div class="wd-scan-resolve-dialog">
				<div class="wd-error wd-hide">

				</div>
				<?php if ( $this->type != 'wordpress' ): ?>
					<div class="group">
						<div class="col span_3_of_12">
							<strong>
								<?php if ( $this->type == 'plugin' ): ?>
									<?php _e( "Plugin name: ", wp_defender()->domain ) ?>
								<?php elseif ( $this->type == 'theme' ): ?>
									<?php _e( "Theme name: ", wp_defender()->domain ) ?>
								<?php endif; ?>
							</strong>
						</div>
						<div class="col span_9_of_12">
							{{name}}
						</div>
					</div>
				<?php endif; ?>
				<div class="group">
					<div class="col span_3_of_12">
						<strong><?php _e( "Version: ", wp_defender()->domain ) ?></strong>
					</div>
					<div class="col span_9_of_12">
						{{version}}
					</div>
				</div>
				<div class="group">
					<div class="col span_3_of_12">
						<strong><?php _e( "Vulnerability: ", wp_defender()->domain ) ?></strong>
					</div>
					<div class="col span_9_of_12">
						{{vulnerability}}
					</div>
				</div>
				<hr/>
				<div>
					{{resolve_note}}
				</div>
				<div class="wd-vuldb-resolve">
					{{resolve_form}}
				</div>
				<div class="wd-ignore-cancel float-l wd-inline wd-no-margin">
					<form method="post" class="wd-resolve-frm">
						<input type="hidden" name="action" value="wd_resolve_result">
						<?php wp_nonce_field( 'wd_resolve', 'wd_resolve_nonce' ) ?>
						<input type="hidden" value="<?php echo esc_attr( get_class( $this ) ) ?>" name="class">
						<input type="hidden" name="id" value="<?php echo esc_attr( $this->id ) ?>"/>
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