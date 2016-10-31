<?php

/**
 * @author: Hoang Ngo
 */
class WD_Resolve_Controller extends WD_Controller {

	public function __construct() {
		$this->add_ajax_action( 'wd_resolve_result', 'resolve_result' );
		$this->add_ajax_action( 'wd_resolve_update_theme', 'update_theme' );
		if ( ! $this->is_ajax() ) {
			$this->template = 'layouts/detail';
			if ( is_multisite() ) {
				$this->add_action( 'network_admin_menu', 'admin_menu', 13 );
			} else {
				$this->add_action( 'admin_menu', 'admin_menu', 13 );
			}
			$this->add_action( 'admin_enqueue_scripts', 'load_scripts' );
			$this->add_action( 'wp_loaded', 'resolve_core_integrity' );
		}
	}

	/**
	 * Auto Resolving for core integrity
	 * @since 1.0.2
	 */
	public function resolve_core_integrity() {
		if ( ! WD_Utils::check_permission() ) {
			return;
		}
		if ( ! wp_verify_nonce( WD_Utils::http_post( 'wd_resolve_nonce' ), 'wd_resolve_core_integrity' ) ) {
			return;
		}

		$model = WD_Scan_Api::get_last_scan();
		$id    = WD_Utils::http_post( 'id' );
		$item  = $model->find_result_item( $id );
		if ( is_object( $item ) ) {
			$ret = $item->automate_resolve();
			if ( ! is_wp_error( $ret ) ) {
				$this->flash( 'success', sprintf( __( "The file <strong>%s</strong> was reverted back to original state.", wp_defender()->domain ), $item->get_name() ) );
				wp_redirect( network_admin_url( 'admin.php?page=wdf-scan' ) );
				exit;
			} else {
				wp_defender()->global['error'] = $ret;
			}
		}
	}

	public function admin_menu() {
		$cap = is_multisite() ? 'manage_network_options' : 'manage_options';
		if ( WD_Utils::http_get( 'page' ) == 'wdf-issue-detail' ) {
			add_submenu_page( 'wp-defender', esc_html__( "Detail Information", wp_defender()->domain ), esc_html__( "Detail Information", wp_defender()->domain ), $cap, 'wdf-issue-detail', array(
				$this,
				'display_main'
			) );
		}
	}

	public function display_main() {
		$id        = WD_Utils::http_get( 'id' );
		$last_scan = WD_Scan_Api::get_last_scan();
		$model     = $last_scan->find_result_item( $id );
		if ( is_object( $model ) ) {
			if ( $model instanceof WD_Scan_Result_Core_Item_Model ) {
				$error = null;
				if ( isset( wp_defender()->global['error'] ) ) {
					$error = wp_defender()->global['error'];
				}
				if ( $model->detail['is_added'] == false ) {
					$this->render( 'detail/core_integrity', array(
						'model' => $model,
						'error' => is_wp_error( $error ) ? $error->get_error_message() : null
					), true );
				} else {
					$this->render( 'detail/show_source', array(
						'model' => $model,
						'error' => is_wp_error( $error ) ? $error->get_error_message() : null
					), true );
				}
			} elseif ( $model instanceof WD_Scan_Result_File_Item_Model ) {
				$this->render( 'detail/file_item', array(
					'model' => $model
				), true );
			}
		} else {
			$this->render( 'detail/not_found', array(), true );
		}
	}

	/**
	 * check if this page is page of the plugin
	 * @return bool
	 */
	private function is_in_page() {
		return WD_Utils::http_get( 'page' ) == 'wdf-issue-detail';
	}

	/**
	 * Check if in right page, then load assets
	 */
	public function load_scripts() {
		if ( $this->is_in_page() ) {
			WDEV_Plugin_Ui::load( wp_defender()->get_plugin_url() . 'shared-ui/', false );
			wp_enqueue_style( 'wp-defender' );
			wp_enqueue_script( 'wp-defender' );
			wp_enqueue_script( 'wd-highlight' );
			wp_enqueue_script( 'wd-confirm' );
		}
	}

	public function update_theme() {
		if ( ! WD_Utils::check_permission() ) {
			return;
		}
		if ( ! wp_verify_nonce( WD_Utils::http_post( 'wd_resolve_nonce' ), 'wd_update_theme' ) ) {
			return;
		}

		$theme = WD_Utils::http_post( 'theme' );

		$ret = WD_Utils::update_theme( $theme );
		if ( is_wp_error( $ret ) ) {
			wp_send_json_error( array(
				'error' => $ret->get_error_message()
			) );
		}
		wp_send_json_success();
	}

	public function resolve_result() {
		if ( ! WD_Utils::check_permission() ) {
			return;
		}

		if ( ! wp_verify_nonce( WD_Utils::http_post( 'wd_resolve_nonce' ), 'wd_resolve' ) ) {
			return;
		}

		$model = WD_Scan_Api::get_last_scan();
		$id    = WD_Utils::http_post( 'id' );
		$item  = $model->find_result_item( $id );

		if ( ! is_object( $item ) ) {
			wp_send_json( array(
				'status' => 0,
				'error'  => esc_html__( "Can't find the issue needing to be fixed.", wp_defender()->domain )
			) );
		}
		$type = WD_Utils::http_post( 'type' );
		switch ( $type ) {
			case 'delete':
				//ability to undo
				$ret = $item->remove();
				if ( is_wp_error( $ret ) ) {
					wp_send_json( array( 'status' => 0, 'error' => $ret->get_error_message() ) );
				}
				WD_Utils::flag_for_submitting();
				wp_send_json( array( 'status' => 1 ) );
				break;
			case 'clean':
				//for now every clean will just return instruction (string)
				$result = $item->clean();
				wp_send_json( array(
					'status' => 1,
					'result' => $result
				) );
				break;
			case 'ignore':
				$ignore_list         = $model->ignore_files;
				$ignore_list[]       = $id;
				$model->ignore_files = $ignore_list;

				$model->save();
				$element = $this->get_ignored_item_html( $item );
				WD_Utils::flag_for_submitting();
				wp_send_json( array(
					'status'  => 1,
					'element' => $element
				) );
				break;
			case 'resolve_ci':
				$res = $item->automate_resolve();
				if ( is_wp_error( $res ) ) {
					wp_send_json( array(
						'status' => 0,
						'error'  => $res->get_error_message()
					) );
				}
				$this->flash( 'success', sprintf( __( "The file <strong>%s</strong> was reverted back to original state.", wp_defender()->domain ), $item->get_name() ) );
				wp_send_json( array(
					'status' => 1
				) );
				break;
			case 'undo':
				$ignore_list = $model->ignore_files;
				$key         = array_search( $id, $ignore_list );
				if ( $key !== false ) {
					unset( $ignore_list[ $key ] );
					$model->ignore_files = $ignore_list;
					$model->save();
					WD_Utils::flag_for_submitting();
					wp_send_json( array(
						'status'  => 1,
						'element' => $this->get_item_html( $item )
					) );
				}
				break;
		}
		wp_send_json( array(
			'status' => 0
		) );
	}

	private function get_ignored_item_html( $item ) {
		ob_start();
		?>
		<tr>
			<td width="30%" class="file-path">
				<strong><?php echo esc_html( $item->get_name() ) ?></strong>
				<span><?php echo esc_html( $item->get_sub() ) ?></span>
			</td>
			<td width="15%" class="issue-type"><?php echo esc_html( $item->get_type() ); ?></td>
			<td width="45%"><?php echo wp_kses( $item->get_detail(), WD_Utils::allowed_html() ) ?></td>
			<td width="10%" class="wd-report-actions">
				<form method="post" class="wd-resolve-frm">
					<input type="hidden" name="action" value="wd_resolve_result">
					<?php wp_nonce_field( 'wd_resolve', 'wd_resolve_nonce' ) ?>
					<input type="hidden" value="<?php esc_attr( get_class( $item ) ) ?>" name="class">
					<input type="hidden" name="id" value="<?php echo esc_attr( $item->id ) ?>"/>

					<div class="wd-button-group">
						<button data-type="undo"
						        tooltip="<?php esc_attr_e( "Undo", wp_defender()->domain ) ?>"
						        type="submit" class="button button-light button-small">
							<i class="wdv-icon wdv-icon-undo"></i>
						</button>
						<?php if ( $item->can_delete() ): ?>
							<?php
							$tooltip     = $item->delete_tooltip;
							$confirm_key = $item->delete_confirm_text; ?>
							<button data-type="delete"
							        data-confirm="<?php echo esc_attr( $confirm_key ) ?>"
							        data-confirm-button="<?php echo 'delete_confirm_btn' ?>"
							        tooltip="<?php echo esc_attr( $tooltip ) ?>"
							        type="submit" class="button button-light button-small">
								<i class="wdv-icon wdv-icon-trash"></i>
							</button>
						<?php else: ?>
							<button data-type="delete"
							        tooltip="<?php esc_attr_e( "Delete", wp_defender()->domain ) ?>"
							        type="button" disabled
							        class="button button-light button-small">
								<i class="wdv-icon wdv-icon-trash"></i>
							</button>
						<?php endif; ?>
					</div>
				</form>
			</td>
		</tr>
		<?php
		return ob_get_clean();
	}

	private function get_item_html( $item ) {
		ob_start();
		?>
		<tr data-type="<?php echo esc_attr( $item->get_system_type() ) ?>">
			<td width="30%" class="file-path">
				<strong><?php echo esc_html( $item->get_name() ) ?></strong>
				<span><?php echo esc_html( $item->get_sub() ) ?></span>
			</td>
			<td width="15%" class="issue-type"><?php echo esc_html( $item->get_type() ); ?></td>
			<td width="45%"
			    class="issue-detail"><?php echo wp_kses( $item->get_detail(), WD_Utils::allowed_html() ) ?></td>
			<td width="10%" class="wd-report-actions">
				<form method="post" class="wd-resolve-frm">
					<input type="hidden" name="action" value="wd_resolve_result">
					<?php wp_nonce_field( 'wd_resolve', 'wd_resolve_nonce' ) ?>
					<input type="hidden" value="<?php esc_attr( get_class( $item ) ) ?>"
					       name="class">
					<input type="hidden" name="id" value="<?php echo esc_attr( $item->id ) ?>"/>

					<div class="wd-button-group">
						<button data-type="clean"
						        tooltip="<?php esc_attr_e( "Resolve Issue", wp_defender()->domain ) ?>"
						        type="submit" class="button button-light button-small">
							<i class="wdv-icon wdv-icon-wrench"></i>
						</button>
						<?php if ( $item->can_ignore() ): ?>
							<button data-type="ignore"
							        tooltip="<?php esc_attr_e( "False alarm? Ignore it", wp_defender()->domain ) ?>"
							        data-confirm="<?php echo 'ignore_confirm_msg' ?>"
							        data-confirm-button="<?php echo 'ignore_confirm_btn' ?>"
							        type="submit" class="button button-light button-small">
								<i class="wdv-icon wdv-icon-fw wdv-icon-ban-circle"></i>
							</button>
						<?php endif; ?>
						<?php if ( $item->can_delete() ): ?>
							<?php
							$tooltip     = $item->delete_tooltip;
							$confirm_key = $item->delete_confirm_text; ?>
							<button data-type="delete"
							        data-confirm="<?php echo esc_attr( $confirm_key ) ?>"
							        data-confirm-button="<?php echo 'delete_confirm_btn' ?>"
							        tooltip="<?php echo esc_attr( $tooltip ) ?>"
							        type="submit" class="button button-light button-small">
								<i class="wdv-icon wdv-icon-trash"></i>
							</button>
						<?php else: ?>
							<button data-type="delete"
							        tooltip="<?php esc_attr_e( "Delete", wp_defender()->domain ) ?>"
							        type="button" disabled
							        class="button button-light button-small">
								<i class="wdv-icon wdv-icon-trash"></i>
							</button>
						<?php endif; ?>
					</div>
				</form>
			</td>
		</tr>
		<?php
		return ob_get_clean();
	}
}