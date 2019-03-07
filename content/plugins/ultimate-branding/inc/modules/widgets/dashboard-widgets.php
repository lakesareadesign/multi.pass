<?php
/**
 * Branda Dashboard Widgets class.
 *
 * @package Branda
 * @subpackage Widgets
 */
if ( ! class_exists( 'Branda_Dashboard_Widgets' ) ) {

	require_once dirname( __FILE__ ) . '/dashboard-widgets-widget.php';

	class Branda_Dashboard_Widgets extends Branda_Helper {
		protected $option_name = 'ub_dashboard_widgets';
		protected $items_name  = 'ub_dashboard_widgets_items';
		private $available_widgets = 'ub_rwp_all_active_dashboard_widgets';

		private $positions  = array( 'normal', 'side', 'advanced' );
		private $priorities = array( 'core', 'low', 'high' );
		private $types = array( 'dashboard', 'dashboard-network' );

		public function __construct() {
			parent::__construct();
			$this->set_options();
			$this->module = 'dashboard-widgets';
			/**
			 * hooks
			 */
			add_filter( 'ultimatebranding_settings_dashboard_widgets', array( $this, 'admin_options_page' ) );
			add_filter( 'ultimatebranding_settings_dashboard_widgets_process', array( $this, 'update' ) );
			/**
			 * remove widgets
			 */
			add_action( 'wp_dashboard_setup', array( $this, 'remove_wp_dashboard_widgets' ), PHP_INT_MAX );
			add_action( 'wp_network_dashboard_setup', array( $this, 'remove_wp_dashboard_widgets' ), PHP_INT_MAX );
			/**
			 * save available boxes
			 *
			 * @since 2.1.0
			 */
			add_action( 'wp_dashboard_setup', array( $this, 'save_available_widgets' ), 99999 );
			add_action( 'wp_network_dashboard_setup', array( $this, 'save_available_widgets' ),  99999 );
			/**
			 * Dashboard Welcome
			 */
			$message = $this->get_value( 'welcome', 'text' );
			if ( ! empty( $message ) && is_string( $message ) ) {
				add_action( 'welcome_panel', array( $this, 'render_custom_welcome_message' ) );
				add_filter( 'get_user_metadata', array( $this, 'remove_dashboard_welcome' ) , 10, 4 );
			}
			/**
			 * upgrade options
			 *
			 * @since 3.0.0
			 */
			add_action( 'init', array( $this, 'upgrade_options' ) );
			/**
			 * add options names
			 *
			 * @since 2.1.0
			 */
			add_filter( 'ultimate_branding_options_names', array( $this, 'add_options_names' ) );
			/**
			 * Add dialog
			 *
			 * @since 3.0,0
			 */
			add_filter( 'branda_get_module_content', array( $this, 'add_dialog' ), 10, 2 );
			/**
			 * Handla AJAX actions
			 *
			 * @since 3.0.0
			 */
			add_action( 'wp_ajax_branda_dashboard_widget_save', array( $this, 'ajax_save' ) );
			add_action( 'wp_ajax_branda_dashboard_widget_delete', array( $this, 'ajax_delete' ) );
			/**
			 * text widgets
			 */
			$has_items = $this->has_items();
			if ( $has_items ) {
				add_action( 'wp_dashboard_setup', array( $this, 'add_dashboard_widgets' ), 467 );
				add_action( 'wp_network_dashboard_setup', array( $this, 'add_dashboard_widgets' ), 467 );
				add_action( 'wp_user_dashboard_setup', array( $this, 'add_dashboard_widgets' ), 467 );
				add_action( 'admin_print_styles', array( $this, 'admin_print_styles' ) );
			}
		}

		/**
		 * Upgrade option
		 *
		 * @since 3.0.0
		 */
		public function upgrade_options() {
			$update = false;
			$data = $this->get_value();
			/**
			 * Remove Dashboard Widgets
			 */
			$option = ub_get_option( 'ub_remove_wp_dashboard_widgets' );
			if (
				isset( $option['remove_dashboard'] )
				&& isset( $option['remove_dashboard']['wp_widgets'] )
			) {
				if ( ! isset( $data['visibility'] ) ) {
					$data['visibility'] = array(
						'wp_widgets' => array(),
					);
					$update = true;
				}
				foreach ( $option['remove_dashboard']['wp_widgets'] as $key => $value ) {
					if ( empty( $value ) || ! $value ) {
						continue;
					}
					$data['visibility']['wp_widgets'][ $key ] = $value;
					$update = true;
				}
				ub_delete_option( 'ub_remove_wp_dashboard_widgets' );
			}
			/**
			 * Custom Welcome Message
			 */
			$option = ub_get_option( 'ub_custom_welcome_message' );
			if ( ! empty( $option ) ) {
				if ( isset( $option['dashboard_widget'] ) ) {
					if ( isset( $option['welcome'] ) ) {
						$data['welcome'] = array();
						$update = true;
					}
					foreach ( $option['dashboard_widget'] as $key => $value ) {
						$data['welcome'][ $key ] = $option['dashboard_widget'][ $key ];
						$update = true;
					}
				}
				ub_delete_option( 'ub_custom_welcome_message' );
			}
			/**
			 * Dashboard Text Widget
			 */
			$options = ub_get_option( 'wpmudev_dashboard_text_widgets_options' );
			if ( ! empty( $options ) ) {
				$data = array();
				foreach ( $options as $one ) {
					$id = md5( serialize( $one ) );
					$data[ $id ] = array(
						'id' => $id,
						'title' => isset( $one['title'] )? $one['title']:'',
						'content' => isset( $one['content'] )? $one['content']:'',
						'content_meta' => isset( $one['content_parse'] )? $one['content_parse']:'',
						'site' => isset( $one['show-on'] ) && isset( $one['show-on']['site'] )? $one['show-on']['site']:'on',
						'network' => isset( $one['show-on'] ) && isset( $one['show-on']['network'] )? $one['show-on']['network']:'on',
					);
				}
				if ( ! empty( $data ) ) {
					ub_update_option( $this->items_name, $data );
					ub_delete_option( 'wpmudev_dashboard_text_widgets_options' );
				}
			}
			/**
			 * save
			 */
			if ( $update ) {
				$this->update_value( $data );
			}
		}

		/**
		 * Set options
		 *
		 * @since 2.0.0
		 */
		protected function set_options() {
			$available_widgets = ub_get_option( $this->available_widgets );
			$options = array(
				'visibility' => array(
					'title' => __( 'Widget Visibility', 'ub' ),
					'description' => __( 'Choose the widgets which you want to remove from all the dashboards on your network.', 'ub' ),
					'fields' => array(
						'wp_widgets' => array(
							'type' => 'checkboxes',
							'options' => $available_widgets,
							'description' => __( 'Note: If you do not see a desired widget on this list, please visit Dashboard page and come back on this page.', 'ub' ),
							'description-position' => 'bottom',
						),
					),
				),
				'welcome' => array(
					'title' => __( 'Dashboard Welcome', 'ub' ),
					'description' => __( 'Customize the default welcome message displayed in the dashboard welcome wizard.', 'ub' ),
					'fields' => array(
						'shortocode' => array(
							'type' => 'sui-tab',
							'label' => __( 'Shortcodes', 'ub' ),
							'description' => __( 'Choose whether you want to allow shortcode parsing within the welcome message or not. Be careful it can break compatibility with themes with UI builders.', 'ub' ),
							'options' => array(
								'on' => __( 'Parse Shortocodes', 'ub' ),
								'off' => __( 'Stop Parsing', 'ub' ),
							),
							'default' => 'off',
						),
						'text' => array(
							'type' => 'wp_editor',
							'label' => __( 'Message', 'ub' ),
							'description' => __( 'Choose the welcome message for the widget.', 'ub' ),
							'placeholder' => __( 'Add your custom welcome message here…', 'ub' ),
							'default' => '',
						),
					),
				),
				'text' => array(
					'title' => __( 'Text Widgets', 'ub' ),
					'description' => __( 'Add text widgets to the WordPress dashboard with your custom content.', 'ub' ),
					'fields' => array(
						'list' => array(
							'type' => 'callback',
							'callback' => array( $this, 'get_list' ),
						),
					),
				),
			);
			if ( empty( $available_widgets ) ) {
				$options['visibility']['fields'] = array(
					'info' => array(
						'type' => 'description',
						'value' => __( 'If you do not see any widget here, please visit Dashboard page and come back on this page.', 'ub' ),
						'classes' => array( 'sui-notice', 'sui-notice-info' ),
					),
				);
			}
			$this->options = $options;
		}

		/**
		 * save available boxes
		 *
		 * @since 2.1.0
		 */
		public function save_available_widgets() {
			global $wp_meta_boxes;
			$available_widgets = ub_get_option( $this->available_widgets );
			foreach ( $this->types as $type ) {
				if ( ! isset( $wp_meta_boxes[ $type ] ) ) {
					continue;
				}
				foreach ( $this->positions as $position ) {
					if ( ! isset( $wp_meta_boxes[ $type ][ $position ] ) ) {
						continue;
					}
					foreach ( $this->priorities as $priority ) {
						if ( ! isset( $wp_meta_boxes[ $type ][ $position ][ $priority ] ) ) {
							continue;
						}
						foreach ( $wp_meta_boxes[ $type ][ $position ][ $priority ] as $key => $box ) {
							$title = strip_tags( $box['title'] );
							if ( empty( $title ) ) {
								continue;
							}
							$available_widgets[ $key ] = $title;
						}
					}
				}
			}
			asort( $available_widgets );
			ub_update_option( $this->available_widgets, $available_widgets );
		}

		/**
		 * Add option names
		 *
		 * @since 2.1.0
		 */
		public function add_options_names( $options ) {
			$options[] = 'rwp_active_dashboard_widgets';
			$options[] = $this->available_widgets;
			$options[] = $this->items_name;
			return $options;
		}

		/**
		 * Remove selected widgets
		 */
		public function remove_wp_dashboard_widgets() {
			global $wp_meta_boxes;
			$active = $this->get_value( 'visibility', 'wp_widgets', array() );
			foreach ( $active as $key => $value ) {
				foreach ( $this->types as $type ) {
					foreach ( $this->positions as $context ) {
						remove_meta_box( $key, $type, $context );
					}
				}
			}
		}

		/**
		 * Removes default welcome message from dashboard
		 *
		 * @param $value
		 * @param $object_id
		 * @param $meta_key
		 * @param $single
		 *
		 * @since 1.0
		 *
		 * @return bool
		 */
		public function remove_dashboard_welcome( $value, $object_id, $meta_key, $single ) {
			global $wp_version;
			if ( version_compare( $wp_version, '3.5', '>=' ) ) {
				remove_action( 'welcome_panel', 'wp_welcome_panel' );
				return $value;
			} else {
				if ( 'show_welcome_panel' === $meta_key ) {
					return false;
				}
			}
			return $value;
		}

		/**
		 * Renders custom content
		 *
		 * @since 1.2
		 */
		public function render_custom_welcome_message() {
			$value = $this->get_value( 'welcome', 'shortocode', 'off' );
			$content = $this->get_value( 'welcome', 'text', '' );
			if ( 'on' === $value ) {
				$value = $this->get_value( 'welcome', 'text_meta', null );
				if ( ! empty( $value ) ) {
					$content = $value;
				}
				$content = do_shortcode( $content );
			}
			echo wpautop( $content );
		}

		/**
		 * List of existing elements.
		 *
		 * @since 3.0.0
		 */
		public function get_list() {
			$content = '';
			/**
			 * top button
			 */
			$args = array(
				'data' => array(
					'a11y-dialog-show' => $this->get_name( 'text-add' ),
				),
				'icon' => 'plus',
				'text' => __( 'Add Text Widget', 'ub' ),
				'sui' => 'magenta',
			);
			/**
			 * Box builder header
			 */
			$content .= '<div class="sui-box-builder">';
			$content .= '<div class="sui-box-builder-header">';
			$content .= $this->button( $args );
			$content .= '</div>'; // Box Builder Header
			/**
			 * list
			 */
			$items = ub_get_option( $this->items_name );
			$content .= '<div class="sui-box-builder-body">';
			$content .= '<div class="sui-box-builder-fields">';
			$dialogs = '';
			if ( is_array( $items ) ) {
				$delete_dialog_configuration = array(
					'title' => __( 'Delete Text Widget', 'ub' ),
					'description' => __( 'Are you sure you wish to permanently delete this text widget?', 'ub' ),
				);
				foreach ( $items as $id => $item  ) {
					$content .= $this->get_list_one_row( $id, $item );
					$dialogs .= $this->get_dialog( $id, $item, 'edit' );
					$dialogs .= $this->get_dialog_delete( $id, $delete_dialog_configuration );
				}
			}
			$content .= '</div>'; // Box Builder Fields
			$args = array(
				'data' => array(
					'a11y-dialog-show' => $this->get_name( 'text-add' ),
				),
				'icon' => 'plus',
				'text' => __( 'Add Text Widget', 'ub' ),
				'sui' => 'dashed',
			);
			$content .= $this->button( $args );
			if ( empty( $items ) || ! count( $items ) ) {
				$content .= '<span class="sui-box-builder-message">' . __( 'No text widget has been added yet. Click on “+ Add Text Widget” to add your first text widget using a simple wizard.', 'ub' ) . '</span>';
			}
			$content .= '</div>'; // Box Builder Body
			$content .= '</div>'; // Box Builder
			$content .= $dialogs;
			return $content;
		}

		/**
		 * Add SUI dialog
		 *
		 * @since 3.0.0
			 *
			 * @param string $content Current module content.
			 * @param array $module Current module.
		 */
		public function add_dialog( $content, $module ) {
			if ( $this->module !== $module['module'] ) {
				return $content;
			}
			$content .= $this->get_dialog();
			return $content;
		}

		/**
		 * SUI: get dialog
		 *
		 * @since 3.0.0
		 */
		private function get_dialog( $id = 0, $data = array(), $type = 'add' ) {
			/**
			 * add defaults
			 */
			$defaults = array(
				'title' => '',
				'content' => '',
				'site' => 'on',
				'network' => 'on',
			);
			$data = wp_parse_args( $data, $defaults );
			$config = $this->get_sui_tabs_config( $data );
			$dialog = $this->sui_tabs( $config, $id, true );
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
			$nonce_action = $this->get_nonce_action( $id );
			$args = array(
				'data' => array(
					'nonce' => wp_create_nonce( $nonce_action ),
					'id' => $id,
					'state' => 'add' === $type? 'add':'edit',
				),
				'icon' => 'check',
				'text' => __( 'Apply', 'ub' ),
				'sui' => '',
				'class' => $this->get_name( 'text-add' ),
			);
			$footer .= $this->button( $args );
			/**
			 * Dialog
			 */
			$args = array(
				'id' => $this->get_name( 'add' === $type? 'text-add':sprintf( 'edit-%s', $id ) ),
				'content' => $dialog,
				'title' => 'add' === $type? __( 'Add Text Widget', 'ub' ):__( 'Edit Text Widget', 'ub' ),
				'footer' => array(
					'content' => $footer,
					'classes' => array( 'sui-space-between' ),
				),
			);
			return $this->sui_dialog( $args );
		}

		/**
		 * AJAX: save feed data
		 *
		 * @since 3.0.0
		 */
		public function ajax_save() {
			$uba = ub_get_uba_object();
			$id = filter_input( INPUT_POST, 'id', FILTER_SANITIZE_STRING );
			$nonce_action = $this->get_nonce_action( $id );
			$message = __( 'Dashboard Widget was created.', 'ub' );
			$this->check_input_data( $nonce_action, array( 'id', 'title', 'content' ) );
			$items = ub_get_option( $this->items_name );
			if ( '0' === $id ) {
				$id = md5( serialize( $_POST ) );
			}
			if ( isset( $items[ $id ] ) ) {
				$message = __( 'Dashboard Widget was updated.', 'ub' );
			}
			$items[ $id ] = array(
				'id' => $id,
				'title' => filter_input( INPUT_POST, 'title', FILTER_SANITIZE_STRING ),
				'content' => $_POST['content'],
				'content_meta' => apply_filters( 'the_content', $_POST['content'] ),
				'site' => filter_input( INPUT_POST, 'site', FILTER_SANITIZE_STRING ),
				'network' => filter_input( INPUT_POST, 'network', FILTER_SANITIZE_STRING ),
			);
			ub_update_option( $this->items_name, $items );
			$message = array(
				'class' => 'success',
				'message' => $message,
			);
			$uba->add_message( $message );
			/**
			 * add/update $available_widgets
			 */
			$available_widgets = ub_get_option( $this->available_widgets );
			if ( ! is_array( $available_widgets ) ) {
				$available_widgets = array();
			}
			$branda_id = $this->get_name( $id );
			$available_widgets[ $branda_id ] = $items[ $id ]['title'];
			asort( $available_widgets );
			ub_update_option( $this->available_widgets, $available_widgets );
			wp_send_json_success();
		}

		/**
		 * Helper to get single row of items list
		 *
		 * @since 3.0.0
		 */
		private function get_list_one_row( $id, $tab ) {
			$content = '<div class="sui-builder-field">';
			$content .= '<div class="sui-builder-field-label">';
			$content .= $tab['title'];
			$content .= '</div>';
			/**
			 * Button: delete
			 */
			$args = array(
				'only-icon' => true,
				'icon' => 'trash',
				'data' => array(
					'a11y-dialog-show' => $this->get_nonce_action( $id, 'delete' ),
				),
				'classes' => array(
					'sui-hover-show',
				),
				'sui' => array(
					'red',
				),
			);
			$content .= $this->button( $args );
			/**
			 * Button: edit
			 */
			$args = array(
				'only-icon' => true,
				'icon' => 'widget-settings-config',
				'data' => array(
					'a11y-dialog-show' => $this->get_nonce_action( $id, 'edit' ),
				),
			);
			$content .= $this->button( $args );
			$content .= '</div>'; // Builder Field
			return $content;
		}

		private function has_items() {
			$items = ub_get_option( $this->items_name );
			if ( empty( $items ) || ! is_array( $items ) ) {
				return false;
			}
			return true;
		}

		public function add_dashboard_widgets() {
			global $wp_version;
			$version_compare = version_compare( $wp_version, '3.7.1' );
			$widget_items = array();
			$items = ub_get_option( $this->items_name );
			if ( empty( $items ) || ! is_array( $items ) ) {
				return;
			}
			foreach ( $items as $widget_id => $widget_options ) {
				// IF we still have them, ignore.
				if ( 0 >= $version_compare ) {
					if (
						'df-dashboard_primary' === $widget_id
						|| 'df-dashboard_secondary' === $widget_id
					) {
						continue;
					}
				}
				$widget_options['branda_id'] = $this->get_name( $widget_id );
				if ( is_multisite() && is_network_admin() ) {
					if ( isset( $widget_options['network'] ) && 'on' === $widget_options['network'] ) {
						$widget_items[ $widget_id ] = new Branda_Dashboard_Widgets_Widget();
						$widget_items[ $widget_id ]->init( $widget_id, $widget_options );
					}
				} else {
					if ( isset( $widget_options['site'] ) && 'on' === $widget_options['site'] ) {
						$widget_items[ $widget_id ] = new Branda_Dashboard_Widgets_Widget();
						$widget_items[ $widget_id ]->init( $widget_id, $widget_options );
					}
				}
			}
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
			$items = ub_get_option( $this->items_name );
			if ( isset( $items[ $_POST['id'] ] ) ) {
				$uba = ub_get_uba_object();
				unset( $items[ $_POST['id'] ] );
				ub_update_option( $this->items_name, $items );
				$message = array(
					'class' => 'success',
					'message' => sprintf( 'Widget was deleted.', 'ub' ),
				);
				$uba->add_message( $message );
				/**
				 * remove widget
				 */
				$available_widgets = ub_get_option( $this->available_widgets );
				$id = $this->get_name( $_POST['id'] );
				if (
					is_array( $available_widgets )
					&& isset( $available_widgets[ $id ] )
				) {
					unset( $available_widgets[ $id ] );
					ub_update_option( $this->available_widgets, $available_widgets );
				}
				wp_send_json_success();
			}
			wp_send_json_error( array( 'message' => __( 'Selected widget does not exists!', 'ub' ) ) );
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
							'label' => __( 'Widget Title', 'ub' ),
							'value' => isset( $item['title'] )? $item['title']:'',
						),
						'content' => array(
							'label' => __( 'Widget Content', 'ub' ),
							'type' => 'wp_editor',
							'placeholder' => __( 'Add your help sidebar content here…', 'ub' ),
							'value' => isset( $item['content'] )? $item['content']:'',
						),
					),
				),
				array(
					'tab' => __( 'Visibility', 'ub' ),
					'fields' => array(
						'site' => array(
							'type' => 'sui-tab',
							'label' => __( 'Site Dashboard', 'ub' ),
							'description' => __( 'Choose whether to show this text widget on site dashboard or not.', 'ub' ),
							'options' => array(
								'on' => __( 'Show', 'ub' ),
								'off' => __( 'Hide', 'ub' ),
							),
							'default' => 'on',
							'value' => isset( $item['site'] )? $item['site']:'on',
						),
						'network' => array(
							'type' => 'sui-tab',
							'label' => __( 'Network Dashboard', 'ub' ),
							'description' => __( 'Choose whether to show this text widget on the network dashboard or not.', 'ub' ),
							'options' => array(
								'on' => __( 'Show', 'ub' ),
								'off' => __( 'Hide', 'ub' ),
							),
							'default' => 'on',
							'value' => isset( $item['network'] )? $item['network']:'on',
							'divider' => array(
								'position' => 'before',
							),
						),
					),
				),
			);
			/**
			 * remove multisite show
			 */
			if ( ! $this->is_network ) {
				unset( $config[1]['fields']['network'] );
			}
			return $config;
		}

		public function admin_print_styles() {
			$screen = get_current_screen();
			if ( ! is_a( $screen, 'WP_Screen' ) ) {
				return;
			}
			if ( ! preg_match( '/^dashboard(\-network)?$/', $screen->base ) ) {
				return;
			}
			$template = sprintf( '/admin/modules/%s/css', $this->module );
			$args = array(
				'id' => $this->get_name(),
			);
			$this->render( $template, $args );
		}
	}
}

new Branda_Dashboard_Widgets;
