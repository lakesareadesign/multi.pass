<?php
if ( ! class_exists( 'Branda_List_Table' ) ) {
	if ( ! class_exists( 'WP_List_Table' ) ) {
		require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
	}
	class Branda_List_Table extends WP_List_Table {
		protected $url;
		protected $config;
		protected $module_class;

		public function __construct( $args = array() ) {
			parent::__construct( $args );
		}

		public function set_config( $module_object ) {
			$this->module_class = $module_object;
			if ( method_exists( $this->module_class, 'get_sui_tabs_config' ) ) {
				$this->config = $this->module_class->get_sui_tabs_config();
			}
		}

		public function get_hidden_columns() {
			$screen = get_current_screen();
			$hidden = get_hidden_columns( $screen );
			return $hidden;
		}

		public function column_cb( $item ) {
			$id = $this->module_class->get_name( 'item' ).'-'.$item['id'];
			printf(
				'<label for="%s" class="sui-checkbox"><input type="checkbox" id="%s" name="%s" value="%s" /><span aria-hidden="true"></span></label>',
				esc_attr( $id ),
				esc_attr( $id ),
				$this->_args['singular'],
				esc_attr( $item['id'] )
			);
		}

		public function column_default( $item, $column_name ) {
			echo $item[ $column_name ];
		}

		/**
		 * Display the table
		 *
		 * @since 3.1.0
		 */
		public function display() {
			if ( ! $this->has_items() ) {
				$this->no_items();
				return;
			}
			$singular = $this->_args['singular'];
			$this->display_tablenav( 'top' );
			$this->screen->render_screen_reader_content( 'heading_list' );
			printf(
				'<table class="sui-table sui-table-flushed" id="%s">',
				$this->module_class->get_name( 'items-table' )
			);
			$this->print_column_headers();
			$this->display_rows();
			echo '</table>';
		}

		/**
		 * Generates content for a single row of the table
		 *
		 * @since 3.1.0
		 *
		 * @param object $item The current item
		 */
		public function single_row( $item ) {
			echo '<tr>';
			$this->single_row_columns( $item );
			echo '</tr>';
		}

		/**
		 * Generates the columns for a single row of the table
		 *
		 * @since 3.1.0
		 *
		 * @param object $item The current item
		 */
		protected function single_row_columns( $item ) {
			global $uba;
			list( $columns, $hidden, $sortable, $primary ) = $this->get_column_info();
			foreach ( $columns as $column_name => $column_display_name ) {
				$classes = "$column_name column-$column_name";
				if ( $primary === $column_name ) {
					$classes .= ' column-primary';
				}
				if ( in_array( $column_name, $hidden ) ) {
					$classes .= ' hidden';
				}
				// Comments column uses HTML in the display name with screen reader text.
				// Instead of using esc_attr(), we strip tags to get closer to a user-friendly string.
				$data = 'data-colname="' . wp_strip_all_tags( $column_display_name ) . '"';
				$attributes = "class='$classes' $data";
				if ( 'cb' === $column_name ) {
					echo '<th scope="row" class="check-column">';
					echo $this->column_cb( $item );
					echo '</th>';
				} elseif ( method_exists( $this, '_column_' . $column_name ) ) {
					echo call_user_func(
						array( $this, '_column_' . $column_name ),
						$item,
						$classes,
						$data,
						$primary
					);
				} elseif ( method_exists( $this, 'column_' . $column_name ) ) {
					echo "<td $attributes>";
					echo call_user_func( array( $this, 'column_' . $column_name ), $item );
					echo $this->handle_row_actions( $item, $column_name, $primary );
					echo '</td>';
				} else {
					echo "<td $attributes>";
					echo $this->column_default( $item, $column_name );
					echo $this->handle_row_actions( $item, $column_name, $primary );
					echo '</td>';
				}
			}
		}

		protected function handle_row_actions( $item, $column_name, $primary ) {
			return '';
		}

		protected function display_tablenav( $which ) {
			if ( 'top' === $which ) {
				wp_nonce_field( 'bulk-' . $this->_args['plural'] );
			}
			printf( '<div class="sui-margin-left sui-margin-top sui-margin-bottom %s">', esc_attr( $which ) );
			if ( $this->has_items() ) {
				$this->bulk_actions( $which );
			}
			echo '</div>';
		}

		/**
		 * Bulk actions
		 *
		 * @since 3.0.0
		 */
		protected function branda_bulk_actions( $which = '', $dialog_id ) {
			if ( ! $this->has_items() ) {
				return;
			}
			if ( 'bottom' === $which ) {
				return;
			}
			echo '<label for="bulk-action-selector-' . esc_attr( $which ) . '" class="screen-reader-text">' . __( 'Select bulk action', 'ub' ) . '</label>';
			echo '<select name="action" class="sui-select-sm sui-select-inline" id="bulk-action-selector-' . esc_attr( $which ) . "\">\n";
			echo '<option value="-1">' . __( 'Bulk Actions', 'ub' ) . "</option>\n";
			$actions = array(
				'delete' => __( 'Delete', 'ub' ),
			);
			foreach ( $actions as $name => $title ) {
				$class = 'edit' === $name ? ' class="hide-if-no-js"' : '';
				echo "\t" . '<option value="' . $name . '"' . $class . '>' . $title . "</option>\n";
			}
			echo "</select>\n";
			global $uba;
			$args = array(
				'text' => __( 'Apply', 'ub' ),
				'sui' => 'ghost',
				'classes' => array(
					'branda-bulk-delete',
				),
				'data' => array(
					'dialog' => $dialog_id,
				),
			);
			echo $uba->button( $args );
		}

		public function column_actions( $item ) {
			$args = array(
				'only-icon' => true,
				'icon' => 'pencil',
				'data' => array(
					'a11y-dialog-show' => $this->module_class->get_name( $item['id'] ),
				),
			);
			$content = $this->module_class->button( $args );
			$args = array(
				'only-icon' => true,
				'icon' => 'trash',
				'sui' => array(
					'red',
				),
				'data' => array(
					'a11y-dialog-show' => $this->module_class->get_nonce_action( $item['id'], 'delete' ),
				),
			);
			$content .= $this->module_class->button( $args );
			$content .= $this->module_class->get_dialog_delete( $item['id'] );
			$content .= $this->module_class->add_dialog( $item );
			return $content;
		}

		/**
		 * Get Branda Heaser column CB
		 *
		 * @since 3.0.0
		 */
		protected function get_header_column_cb_all() {
			$id = $this->module_class->get_name( 'cb-select-all' );
			$content = sprintf(
				'<label class="screen-reader-text" for="%s">%s</label>',
				esc_attr( $id ),
				esc_html__( 'Select All', 'ub' )
			);
			$content .= sprintf(
				'<label for="%s" class="sui-checkbox"><input id="%s" type="checkbox" class="branda-cb-select-all" /><span aria-hidden="true"></span></label>',
				esc_attr( $id ),
				esc_attr( $id )
			);
			return $content;
		}
	}

}