<?php
/**
 * Branda Dashboard Feeds class.
 *
 * @package Branda
 * @subpackage Widgets
 */
if ( ! class_exists( 'Branda_Dashboard_Feeds' ) ) {

	class Branda_Dashboard_Feeds extends Branda_Helper {
		private $version_compare;
		private $list_table;
		private $items_name = 'branda_dashboard_feeds';

		public function __construct() {
			parent::__construct();
			$this->module = 'dashboard-feeds';
			global $wp_version;
			$this->version_compare = version_compare( $wp_version, '3.7.1' );
			/**
			 * hooks
			 */
			add_action( 'wp_dashboard_setup', array( $this, 'add_dashboard_widgets' ), 99 );
			add_action( 'wp_network_dashboard_setup', array( $this, 'add_dashboard_widgets' ), 99 );
			add_action( 'wp_user_dashboard_setup', array( $this, 'add_dashboard_widgets' ), 99 );
			add_filter( 'ultimatebranding_settings_dashboard_feeds', array( $this, 'admin_options_page' ) );
			/**
			 * Disable button "Save Changes".
			 *
			 * @since 3.0.0
			 */
			add_filter( 'ultimatebranding_settings_panel_show_submit', array( $this, 'disable_save_changes' ), 10, 2 );
			/**
			 * Add settings button.
			 *
			 * @since 3.0.0
			 */
			add_filter( 'branda_settings_after_box_title', array( $this, 'add_button_after_title' ), 10, 2 );
			/**
			 * Handla AJAX actions
			 *
			 * @since 3.0.0
			 */
			add_action( 'wp_ajax_branda_dashboard_feed_save', array( $this, 'ajax_save' ) );
			add_action( 'wp_ajax_branda_dashboard_feed_delete', array( $this, 'ajax_delete' ) );
			add_action( 'wp_ajax_branda_dashboard_feed_delete_bulk', array( $this, 'ajax_delete_bulk' ) );
			/**
			 * upgrade options
			 *
			 * @since 3.0.0
			 */
			add_action( 'init', array( $this, 'upgrade_options' ) );
			/**
			 * Add dialog
			 *
			 * @since 3.0,0
			 */
			add_filter( 'branda_get_module_content', array( $this, 'add_modal' ), 10, 2 );
			/**
			 * Single item delete
			 */
			add_filter( 'branda_dialog_delete_attr', array( $this, 'dialog_delete_attr_filter' ), 10, 3 );
		}

		/**
		 * Add button after title.
		 *
		 * @since 3.0.0
		 */
		public function add_button_after_title( $content, $module ) {
			if ( $this->module !== $module['module'] ) {
				return $content;
			}
			$content .= '<div class="sui-actions-left">';
			$content .= $this->button_add();
			$content .= '</div>';
			return $content;
		}

		/**
		 * Upgrade option
		 *
		 * @since 3.0.0
		 */
		public function upgrade_options() {
			if ( is_multisite() ) {
				global $current_blog;
				if ( $current_blog->site_id == $current_blog->blog_id ) {
					$df_widgets = get_blog_option( $current_blog->site_id, 'wpmudev_df_widget_options' );
					if ( ! is_array( $df_widgets ) ) {
						$df_widgets = get_option( 'wpmudev_df_widget_options' );
					}
				} else {
					$df_widgets = get_blog_option( $current_blog->site_id, 'wpmudev_df_widget_options' );
				}
			} else {
				$df_widgets = get_option( 'wpmudev_df_widget_options' );
			}
			if ( empty( $df_widgets ) || ! is_array( $df_widgets ) ) {
				return;
			}
			$items = $this->get_df_feed_widgets_items();
			foreach ( $df_widgets as $one ) {
				if ( isset( $one['show-on'] ) ) {
					$one['network'] = isset( $one['show-on']['network'] )? $one['show-on']['network']:'hide';
					$one['site'] = isset( $one['show-on']['site'] )? $one['show-on']['site']:'hide';
					unset( $one['show-on'] );
				}
				foreach ( $one as $key => $value ) {
					switch ( $key ) {
						case 'show_author':
						case 'show_date':
						case 'site':
						case 'network':
							$one[ $key ] = 'hide';
							if ( 'on' === $value || 1 === intval( $value ) ) {
								$one[ $key ] = 'show';
							}
						break;
						case 'show_summary':
							$one[ $key ] = 'excerpt';
							if ( 'on' === $value || 1 === intval( $value ) ) {
								$one[ $key ] = 'full';
							}
						break;
					}
				}
				$id = $this->get_max_feed_id() + 1;
				$one['id'] = sprintf( 'df-%d', $id );
				$items[ $id ] = $one;
			}
			ub_update_option( $this->items_name, $items );
			if ( $this->is_network && function_exists( 'delete_blog_option' ) ) {
				delete_blog_option( $current_blog->site_id, 'wpmudev_df_widget_options' );
			}
			delete_option( 'wpmudev_df_widget_options' );
		}

		/**
		 * Disable button "Save Changes".
		 *
		 * @since 3.0.0
		 */
		public function disable_save_changes( $status, $module ) {
			if ( $this->module !== $module['module'] ) {
				return $status;
			}
			return false;
		}

		public function admin_options_page( $content ) {
			require_once 'dashboard-feeds-table.php';
			global $ub_version;
			$this->list_table = new Branda_Dashboard_Feeds_table();
			$content = '<div id="branda-dashboard-feeds-panel" class="branda-dashboard-feeds-wrap">';
			$df_widgets = $this->get_df_feed_widgets_items();
			$content .= $this->show_dashboard_feed_list_table( $df_widgets );
			$content .= '</div>';
			add_action( 'branda_ubadmin_footer', array( $this, 'add_modals' ) );
			return $content;
		}

		public function add_dashboard_widgets() {
			require_once 'dashboard-feeds-widget.php';
			$widget_items = array();
			$df_widgets = $this->get_df_feed_widgets_items();
			foreach ( $df_widgets as $widget_id => $widget_options ) {
				/**
				 * check is proper url
				 */
				if ( ! isset( $widget_options['url'] ) ) {
					continue;
				}
				$is_url = filter_var( $widget_options['url'] , FILTER_VALIDATE_URL );
				if ( ! $is_url ) {
					continue;
				}
				if ( is_multisite() && is_network_admin() ) {
					if (
						isset( $widget_options['network'] )
						&& 'show' === $widget_options['network']
					) {
						$widget_items[ $widget_id ] = new Branda_Dashboard_Feeds_widget();
						$widget_items[ $widget_id ]->init( $widget_id, $widget_options );
					}
				} else if (
					isset( $widget_options['site'] )
					&& 'show' === $widget_options['site']
				) {
					$widget_items[ $widget_id ] = new Branda_Dashboard_Feeds_widget();
					$widget_items[ $widget_id ]->init( $widget_id, $widget_options );
				}
			}
		}

		/**
		 * Get widgets
		 *
		 * @since 3.0.0
		 *
		 * @return array $df_widgets Arary of defined widgets.
		 */
		public function get_df_feed_widgets_items() {
			$df_widgets = ub_get_option( $this->items_name, array() );
			return $df_widgets;
		}

		public function show_dashboard_feed_list_table( $df_items = array() ) {
			ob_start();
			$this->list_table->set_config( $this );
			$this->list_table->prepare_items( $df_items );
			$this->list_table->display();
			$content = ob_get_contents();
			ob_end_clean();
			return $content;
		}

		/**
		 * SUI: button add
		 *
		 * @since 3.0.0
		 *
		 * @return string Button HTML.
		 */
		public function button_add() {
			$args = array(
				'data' => array(
					'a11y-dialog-show' => $this->get_name( 'new' ),
				),
				'icon' => 'plus',
				'text' => __( 'Add Feed', 'ub' ),
				'sui' => 'blue',
			);
			return $this->button( $args );
		}

		/**
		 * Get SUI configuration for modal window.
		 *
		 * @since 3.0.0
		 *
		 * @return array $config Configuration of modal window.
		 */
		public function get_sui_tabs_config( $item = array() ) {
			$config = array(
				array(
					'tab' => __( 'General', 'ub' ),
					'fields' => array(
						'title' => array(
							'label' => __( 'Feed title (optional)', 'ub' ),
							'label_after' => __( '(options)', 'ub' ),
							'placeholder' => __( 'E.g. Daily Jobs Feed.', 'ub' ),
							'value' => isset( $item['title'] )? $item['title']:'',
						),
						'link' => array(
							'type' => 'url',
							'label' => __( 'Site URL', 'ub' ),
							'placeholder' => __( 'E.g. http://www.example.com', 'ub' ),
							'value' => isset( $item['link'] )? $item['link']:'',
						),
						'url' => array(
							'type' => 'url',
							'label' => __( 'Feed URL', 'ub' ),
							'placeholder' => __( 'E.g. http://www.example.com/feed', 'ub' ),
							'value' => isset( $item['url'] )? $item['url']:'',
							'required' => 'required',
						),
					),
				),
				array(
					'tab' => __( 'Display', 'ub' ),
					'fields' => array(
						'items' => array(
							'type' => 'number',
							'label' => __( 'Count', 'ub' ),
							'description' => __( 'The number of feed items you’d like to display.', 'ub' ),
							'value' => isset( $item['items'] )? $item['items']:10,
							'default' => 10,
						),
						'show_summary' => array(
							'label' => __( 'Content', 'ub' ),
							'description' => __( 'Choose whether to show full content or only the excerpt.', 'ub' ),
							'type' => 'sui-tab',
							'options' => array(
								'excerpt' => __( 'Excerpt', 'ub' ),
								'full' => __( 'Full Content', 'ub' ),
							),
							'value' => isset( $item['show_summary'] )? $item['show_summary']:'excerpt',
							'default' => 'excerpt',
						),
						'show_author' => array(
							'label' => __( 'Author', 'ub' ),
							'description' => __( 'Show the Author of the feed item if available or not.', 'ub' ),
							'type' => 'sui-tab',
							'options' => array(
								'hide' => __( 'Hide', 'ub' ),
								'show' => __( 'Show', 'ub' ),
							),
							'value' => isset( $item['show_author'] )? $item['show_author']:'hide',
							'default' => 'hide',
						),
						'show_date' => array(
							'label' => __( 'Date', 'ub' ),
							'description' => __( 'Show the creation date of feed item or not.', 'ub' ),
							'type' => 'sui-tab',
							'options' => array(
								'hide' => __( 'Hide', 'ub' ),
								'show' => __( 'Show', 'ub' ),
							),
							'value' => isset( $item['show_date'] )? $item['show_date']:'hide',
							'default' => 'hide',
						),
					),
				),
				array(
					'tab' => __( 'Visibility', 'ub' ),
					'fields' => array(
						'site' => array(
							'label' => __( 'Site Dashboard', 'ub' ),
							'description' => __( 'Choose whether to show this feed on site dashboard or not.', 'ub' ),
							'type' => 'sui-tab',
							'options' => array(
								'hide' => __( 'Hide', 'ub' ),
								'show' => __( 'Show', 'ub' ),
							),
							'value' => isset( $item['site'] )? $item['site']:'show',
							'default' => 'show',
						),
						'network' => array(
							'label' => __( 'Network Dashboard', 'ub' ),
							'description' => __( 'Choose whether to show this feed on the network dashboard or not.', 'ub' ),
							'type' => 'sui-tab',
							'options' => array(
								'hide' => __( 'Hide', 'ub' ),
								'show' => __( 'Show', 'ub' ),
							),
							'value' => isset( $item['network'] )? $item['network']:'show',
							'default' => 'show',
						),
					),
				),
			);
			/**
			 * remove multisite show
			 */
			if ( ! $this->is_network ) {
				unset( $config[2]['fields']['network'] );
			}
			return $config;
		}

		/**
		 * Add modal windows.
		 *
		 * @since 3.0.0
		 */
		public function add_modals() {
			$config = $this->get_sui_tabs_config();
			$content = $this->sui_tabs( $config, 0, true );
			/**
			 * Footer
			 */
			$footer = '';
			$args = array(
				'icon' => 'undo',
				'text' => __( 'Reset', 'ub' ),
				'sui' => 'ghost',
				'classes' => array(
					$this->get_name( 'reset' ),
					'branda-dialog-reset',
				),
			);
			$footer .= $this->button( $args );
			$args = array(
				'data' => array(
					'nonce' => wp_create_nonce( $this->get_nonce_action( 'df-0' ) ),
					'id' => 0,
				),
				'icon' => 'check',
				'text' => __( 'Add', 'ub' ),
				'class' => $this->get_name( 'add' ),
			);
			$footer .= $this->button( $args );
			/**
			 * Dialog
			 */
			$args = array(
				'id' => $this->get_name( 'new' ),
				'title' => __( 'Add Dashboard Feed', 'ub' ),
				'content' => $content,
				'footer' => array(
					'content' => $footer,
					'classes' => array( 'sui-space-between' ),
				),
				'classes' => array(
					$this->get_name( 'dialog' ),
				),
			);
			echo $this->sui_dialog( $args );
		}

		/**
		 * Get modal for to edit feed
		 *
		 * @since 3.0.0
		 */
		public function get_feed_form( $item ) {
			$id = isset( $item['id'] )? $item['id']:md5( serialize( $item ) );
			$config = $this->get_sui_tabs_config( $item );
			$content = $this->sui_tabs( $config, $id, true );
			/**
			 * Footer
			 */
			$footer = '';
			$args = array(
				'icon' => 'undo',
				'text' => __( 'Reset', 'ub' ),
				'sui' => 'ghost',
				'classes' => array(
					$this->get_name( 'reset' ),
					'branda-dialog-reset',
				),
			);
			$footer .= $this->button( $args );
			$args = array(
				'data' => array(
					'nonce' => wp_create_nonce( $this->get_nonce_action( $item['id'] ) ),
					'id' => $id,
				),
				'icon' => 'check',
				'text' => __( 'Apply', 'ub' ),
				'sui' => '',
				'class' => $this->get_name( 'save' ),
			);
			$footer .= $this->button( $args );
			/**
			 * Dialog
			 */
			$args = array(
				'id' => $this->get_nonce_action( $item['id'], 'edit' ),
				'title' => __( 'Dashboard Feed', 'ub' ),
				'content' => $content,
				'footer' => array(
					'content' => $footer,
					'classes' => array( 'sui-space-between' ),
				),
				'classes' => array(
					$this->get_name( 'dialog' ),
				),
			);
			return $this->sui_dialog( $args );
		}

		/**
		 * AJAX: delete feed data
		 *
		 * @since 3.0.0
		 */
		public function ajax_delete() {
			$nonce_action = 0;
			if ( isset( $_POST['id'] ) ) {
				$nonce_action = $this->get_nonce_action( $_POST['id'], 'delete' );
			}
			$this->check_input_data( $nonce_action, array( 'id' ) );
			$items = ub_get_option( $this->items_name, array() );
			if ( isset( $items[ $_POST['id'] ] ) ) {
				$uba = ub_get_uba_object();
				unset( $items[ $_POST['id'] ] );
				ub_update_option( $this->items_name, $items );
				$message = array(
					'class' => 'success',
					'message' => sprintf( 'Feed was deleted.', 'ub' ),
				);
				$uba->add_message( $message );
				wp_send_json_success();
			}
			wp_send_json_error( array( 'message' => __( 'Selected feed does not exists!', 'ub' ) ) );
		}

		/**
		 * AJAX: delete feed data (bulk)
		 *
		 * @since 3.0.0
		 */
		public function ajax_delete_bulk() {
			$this->check_input_data( $this->get_nonce_action( 'bulk', 'delete' ), array( 'ids' ) );
			$update = false;
			if ( is_array( $_POST['ids'] ) ) {
				$items = ub_get_option( $this->items_name, array() );
				foreach ( $_POST['ids'] as $id ) {
					if ( isset( $items[ $id ] ) ) {
						unset( $items[ $id ] );
						$update = true;
						continue;
					}
					foreach ( $items as $id2 => $data ) {
						if ( $id === $data['id'] ) {
							unset( $items[ $id2 ] );
							$update = true;
							continue;
						}
					}
				}
			}
			if ( $update ) {
				if ( empty( $items ) ) {
					ub_delete_option( $this->items_name );
				} else {
					ub_update_option( $this->items_name, $items );
				}
				$uba = ub_get_uba_object();
				$message = array(
					'class' => 'success',
					'message' => __( 'Selected feeds was deleted!', 'ub' ),
				);
				$uba->add_message( $message );
				wp_send_json_success();
			}
			$this->json_error();
		}

		/**
		 * AJAX: save feed data
		 *
		 * @since 3.0.0
		 */
		public function ajax_save() {
			$uba = ub_get_uba_object();
			$message = $nonce_action = $id = 0;
			if ( isset( $_POST['id'] ) ) {
				$id = intval( preg_replace( '/[^\d]+/', '', $_POST['id'] ) );
				$nonce_action = $this->get_nonce_action( 'df-'.$id );
				$message = sprintf( 'Feed was updated.', 'ub' );
			}
			if ( 0 === $id ) {
				$message = sprintf( 'Feed was added.', 'ub' );
			}
			$this->check_input_data( $nonce_action, array( 'id', 'url' ) );
			$data = array();
			$config = $this->get_sui_tabs_config();
			foreach ( $config as $tab ) {
				foreach ( $tab['fields'] as $key => $one ) {
					$value = isset( $one['default'] )? $one['default']:'';
					switch ( $key ) {
						case 'link':
						case 'url':
							if ( isset( $_POST[ $key ] ) ) {
								$value = filter_input( INPUT_POST, $key, FILTER_VALIDATE_URL );
							}
						break;
						case 'show_summary':
							$v = filter_input( INPUT_POST, $key, FILTER_SANITIZE_STRING );
							if ( preg_match( '/^(excerpt|full)$/', $v ) ) {
								$value = $v;
							}
						break;
						case 'show_author':
						case 'show_date':
						case 'site':
						case 'network':
							$v = filter_input( INPUT_POST, $key, FILTER_SANITIZE_STRING );
							if ( preg_match( '/^(hide|show)$/', $v ) ) {
								$value = $v;
							}
						break;
						case 'items':
							$value = filter_input( INPUT_POST, $key, FILTER_SANITIZE_NUMBER_INT );
						default:
							$value = filter_input( INPUT_POST, $key, FILTER_SANITIZE_STRING );
						break;
					}
					$data[ $key ] = $value;
				}
			}
			if ( 0 === $id ) {
				$id = 1 + $this->get_max_feed_id();
			}
			$data['id'] = sprintf( 'df-%d', $id );
			$items = ub_get_option( $this->items_name, array() );
			$items[ $data['id'] ] = $data;
			ub_update_option( $this->items_name, $items );
			$message = array(
				'class' => 'success',
				'message' => $message,
			);
			$uba->add_message( $message );
			wp_send_json_success();
		}

		/**
		 * Get max id
		 *
		 * @since 3.0.0
		 *
		 * return integer
		 */
		private function get_max_feed_id() {
			$value = 0;
			$items = ub_get_option( $this->items_name, array() );
			if ( empty( $items ) ) {
				return $value;
			}
			$keys = array_keys( $items );
			foreach ( $keys as $key ) {
				$v = intval( preg_replace( '/[^\d]+/', '', $key ) );
				if ( $v > $value ) {
					$value = $v;
				}
			}
			return $value;
		}

		/**
		 * Add SUI dialog
		 *
		 * @since 3.0.0
			 *
			 * @param string $content Current module content.
			 * @param array $module Current module.
		 */
		public function add_modal( $content, $module ) {
			if ( $this->module !== $module['module'] ) {
				return $content;
			}
			$content .= $this->get_dialog_delete( 'bulk' );
			return $content;
		}

		/**
		 * Replace default by module related
		 */
		public function dialog_delete_attr_filter( $args, $module, $id ) {
			if ( $this->module === $module ) {
				$args['title'] = __( 'Delete Dashboard Feed', 'ub' );
				$args['description'] = __( 'Are you sure you wish to permanently delete this dashboard feed?', 'ub' );
				if ( 'bulk' === $id ) {
					$args['title'] = __( 'Delete Dashboard Feeds', 'ub' );
					$args['description'] = __( 'Are you sure you wish to permanently delete selected dashboard feeds?', 'ub' );
				}
			}
			return $args;
		}
	}
}
new Branda_Dashboard_Feeds();