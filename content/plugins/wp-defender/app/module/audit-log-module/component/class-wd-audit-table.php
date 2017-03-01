<?php
/**
 * Author: Hoang Ngo
 */
if ( ! class_exists( 'WP_List_Table' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class WD_Audit_Table extends WP_List_Table {
	private $error;

	public function __construct( $args = array() ) {
		parent::__construct( array_merge( array(
			'plural'     => '',
			'autoescape' => false,
			'screen'     => 'audit_table_ajax'
		), $args ) );
	}

	/**
	 * @return array
	 */
	function get_table_classes() {
		return array( $this->_args['plural'] );
	}

	/**
	 * @return array
	 */
	function get_columns() {
		$columns = array(
			'col_summary' => esc_html__( 'Summary', wp_defender()->domain ),
			'col_date'    => esc_html__( 'Date', wp_defender()->domain ),
			'col_type'    => esc_html__( 'Event Context', wp_defender()->domain ),
			'col_action'  => esc_html__( "Action", wp_defender()->domain ),
			'col_ip'      => esc_html__( 'IP Address', wp_defender()->domain ),
			'col_user'    => esc_html__( 'User', wp_defender()->domain ),
		);

		return $columns;
	}

	protected function get_sortable_columns() {
		return array(
			//'col_summary' => array( 'text', true ),
			'col_date' => array( 'timestamp', true ),
			//'col_ip'      => array( 'ip', true ),
			//'col_user'    => array( 'user', true ),
			//'col_type'    => array( 'event_type', true )
		);
	}

	/**
	 * prepare logs data
	 */
	function prepare_items() {
		$date_format = 'm/d/Y';
		$attributes  = array(
			'date_from'   => date( $date_format, strtotime( '-7 days', current_time( 'timestamp' ) ) ),
			'date_to'     => date( $date_format, current_time( 'timestamp' ) ),
			'user_id'     => '',
			'event_type'  => '',
			'ip'          => '',
			'context'     => '',
			'action_type' => '',
			'blog_id'     => 1
		);
		$params      = array();
		foreach ( $attributes as $att => $value ) {
			$params[ $att ] = WD_Utils::http_get( $att, $value );
			if ( $att == 'date_to' || $att == 'date_from' ) {
				$df_object      = DateTime::createFromFormat( $date_format, $params[ $att ] );
				$params[ $att ] = $df_object->format( 'Y-m-d' );
			}
		}
		$params['date_from'] = trim( $params['date_from'] . ' 00:00:00' );
		$params['date_to']   = trim( $params['date_to'] ) . ' 23:59:59';

		if ( ! empty( $params['user_id'] ) ) {
			if ( ! filter_var( $params['user_id'], FILTER_VALIDATE_INT ) ) {
				$user_id = username_exists( $params['user_id'] );
				if ( $user_id == false ) {
					$params['user_id'] = null;
				} else {
					$params['user_id'] = $user_id;
				}
			}
		}

		$params['paged'] = $this->get_pagenum();

		$params = array_filter( $params );

		$result = WD_Audit_API::get_logs( $params, WD_Utils::http_get( 'order_by', 'timestamp' ), WD_Utils::http_get( 'order', 'desc' ) );
		if ( is_wp_error( $result ) ) {
			$this->items = array();
			$this->error = $result;
		} else {
			$total_pages = $result['total_pages'];
			$this->set_pagination_args( array(
				'total_items' => $result['total_items'],
				'total_pages' => $total_pages,
				'per_page'    => $result['per_page']
			) );

			$this->_column_headers = array( $this->get_columns(), array(), $this->get_sortable_columns() );
			$this->items           = $result['data'];
		}
	}

	/**
	 * @param $item
	 *
	 * @return mixed
	 */
	public function column_col_summary( $item ) {
		$msg = WD_Audit_API::liveable_audit_log( $item['msg'] );
		if ( is_plugin_active_for_network( wp_defender()->slug ) && $item['blog_id'] < 1 ) {
			$msg .= ( '<br/>' . sprintf( esc_html__( "Blog %s", wp_defender()->domain ), get_site_url( $item['blog_id'] ) ) );
		}
		$msg .= ( isset( $item['count'] ) ? ' (' . $item['count'] . ')' : null );

		return $msg;
		//return esc_html( $item['msg'] . ( isset( $item['count'] ) ? ' (' . $item['count'] . ')' : null ) );
	}

	public function column_col_action( $item ) {
		return sprintf( '<a class="audit-nav" href="%s">%s</a>', esc_url( add_query_arg( array(
			'page'        => 'wdf-logging',
			'action_type' => $item['action_type']
		), network_admin_url( 'admin.php' ) ) ), ucwords( WD_Audit_API::get_action_text( $item['action_type'] ) ) );
	}

	/**
	 * @param $item
	 *
	 * @return string
	 */
	public function column_col_date( $item ) {
		ob_start();
		if ( is_array( $item['timestamp'] ) ) {
			sort( $item['timestamp'] );
			?>
            <strong><?php echo esc_html( WD_Utils::time_since( $item['timestamp'][1] ) . esc_html__( " ago", wp_defender()->domain ) ) ?></strong>
            <small><?php echo esc_html( date_i18n( get_option( 'date_format' ) . ' ' . get_option( 'time_format' ), strtotime( get_date_from_gmt( date( 'Y-m-d H:i:s', $item['timestamp'][0] ) ) ) ) ) ?>
                &nbsp;<?php esc_attr_e( "to", wp_defender()->domain ) ?>&nbsp;
				<?php echo esc_html( date_i18n( get_option( 'date_format' ) . ' ' . get_option( 'time_format' ), strtotime( get_date_from_gmt( date( 'Y-m-d H:i:s', $item['timestamp'][1] ) ) ) ) ) ?></small>
			<?php
		} else {
			?>
            <strong><?php echo esc_html( WD_Utils::time_since( $item['timestamp'] ) . esc_html__( " ago", wp_defender()->domain ) ) ?></strong>
            <small><?php echo esc_html( date_i18n( get_option( 'date_format' ) . ' ' . get_option( 'time_format' ), strtotime( get_date_from_gmt( date( 'Y-m-d H:i:s', $item['timestamp'] ) ) ) ) ) ?></small>
			<?php
		}

		return ob_get_clean();
	}

	public function column_col_type( $item ) {
		$type = WD_Audit_API::get_action_text( $item['event_type'] );

		$html = sprintf( '<a class="audit-nav" href="%s">%s</a>', $this->build_filter_url( 'event_type[]', $item['event_type'] ), ucwords( $type ) );
		$html .= ' / ' . sprintf( '<a class="audit-nav" href="%s">%s</a>', $this->build_filter_url( 'context', $item['context'] ), ucwords( WD_Audit_API::get_action_text( $item['context'] ) ) );

		return $html;
	}

	public function column_col_ip( $item ) {
		return sprintf( '<a class="audit-nav" href="%s">%s</a>', $this->build_filter_url( 'ip', $item['ip'] ), $item['ip'] );
	}

	public function column_col_user( $item ) {
		ob_start();
		?>
        <div>
			<?php
			echo get_avatar( $item['user_id'], 30 );
			?>
        </div>
        <div>
		<?php if ( $item['user_id'] == 0 ): ?>
            <small>
				<?php printf( '<a class="audit-nav" href="%s">%s</a>',
					$this->build_filter_url( 'user_id', 0 ),
					esc_html__( "Guest", wp_defender()->domain )
				) ?>
            </small>
		<?php else: ?>
            <small><?php printf( '<a class="audit-nav" href="%s">%s</a>',
					$this->build_filter_url( 'user_id', $item['user_id'] ),
					WD_Utils::get_display_name( $item['user_id'] )
				) ?></small>
            <span>
				<?php
				$user = get_user_by( 'id', $item['user_id'] );
				echo ucwords( implode( $user->roles, '<br/>' ) );
				?>
			</span>
            </div>
		<?php endif; ?>
		<?php
		return ob_get_clean();
	}

	public function display() {

		$singular = $this->_args['singular'];

		//$this->screen->render_screen_reader_content( 'heading_list' );
		?>
		<?php
		if ( is_wp_error( $this->error ) ):?>
            <div class="wd-error">
				<?php echo $this->error->get_error_message() ?>
            </div>
		<?php elseif
		( count( $this->items ) > 0
		): ?>
			<?php $this->display_tablenav( 'bottom' ); ?>
            <table id="wd-audit-table" class="wp-list-table <?php echo implode( ' ', $this->get_table_classes() ); ?>">
                <thead>
                <tr>
					<?php $this->print_column_headers(); ?>
                </tr>
                </thead>

                <tbody id="the-list"<?php
				if ( $singular ) {
					echo " data-wp-lists='list:$singular'";
				} ?>>
				<?php $this->display_rows_or_placeholder(); ?>
                </tbody>
            </table>
		<?php else: ?>
			<?php
			$is_filter = false;
			//we need to check if the URL has any parameters
			$params = array(
				'date_from',
				'date_to',
				'user_id',
				'event_type',
				'ip',
				'context',
				'action_type'
			);
			foreach ( $params as $val ) {
				if ( WD_Utils::http_get( $val, false ) !== false ) {
					$is_filter = true;
					break;
				}
			}
			?>
			<?php if ( $is_filter == false ): ?>
                <div class="wd-well blue wd-well-small">
					<?php esc_html_e( "Defender hasn’t detected any events yet. When he does, they’ll appear here!", wp_defender()->domain ) ?>
                </div>
			<?php else: ?>
                <div class="wd-well blue wd-well-small">
					<?php esc_html_e( "Defender couldn't find any logs matching your filters.", wp_defender()->domain ) ?>
                </div>
			<?php endif; ?>
		<?php endif; ?>
		<?php
	}

	private function build_filter_url( $type, $value ) {
		/**
		 * when click on a filter link, we will havet o include the current date range, and from
		 * we will need to keep the current get too
		 */
		$allowed     = array(
			'page',
			'event_type',
			'user',
			'date_from',
			'date_to'
		);
		$http_params = array();
		foreach ( $_GET as $key => $val ) {
			if ( in_array( $key, $allowed ) && ! empty( $val ) ) {
				$http_params[ $key ] = $val;
			}
		}

		$http_params[ $type ] = $value;

		return esc_url( add_query_arg( $http_params, network_admin_url( 'admin.php' ) ) );
	}

	public function single_row( $item ) {
		static $row_class = '';

		echo '<tr' . $row_class . '>';
		$this->single_row_columns( $item );
		echo '</tr>';
	}

	protected function display_tablenav( $which ) {
		if ( 'top' === $which ) {
			if ( isset( $this->_pagination_args['total_items'] ) ) {
				$total_items = $this->_pagination_args['total_items'];
			} else {
				$total_items = 0;
			}
			$from = esc_attr( WD_Utils::http_get( 'date_from', date( 'm/d/Y', strtotime( 'today midnight', strtotime( '-7 days', current_time( 'timestamp' ) ) ) ) ) );
			$to   = esc_attr( WD_Utils::http_get( 'date_to', date( 'm/d/Y', current_time( 'timestamp' ) ) ) );

			?>
            <div class="wd-well wd-audit-filter">
                <div class="group">
                    <form method="get" action="<?php echo network_admin_url( 'admin.php?page=wdf-logging' ) ?>">
                        <input type="hidden" name="page" value="wdf-logging">
                        <div class="col span_12_of_12">
                            <div class="wd-audit-user-filter">
                                <!--<select>
									<option>All IP</option>
								</select>-->
                                <label><?php esc_html_e( "Users", wp_defender()->domain ) ?></label>
                                <input name="user_id" id="wd_user_id" class="user-search"
                                       data-empty-msg="<?php esc_attr_e( "We did not find an admin user with this name...", wp_defender()->domain ) ?>"
                                       placeholder="<?php esc_attr_e( "Type a user’s name", wp_defender()->domain ) ?>"
                                       type="search"/>

                            </div>
                            <div class="wd-audit-date-filter">
                                <label><?php esc_html_e( "Date", wp_defender()->domain ) ?></label>
                                <div>
                                    <i class="wdv-icon wdv-icon-fw wdv-icon-calendar"></i>
                                    <input name="date_from" id="wd_range_from" type="text" class="wd-calendar"
                                           value="<?php echo $from ?> - <?php echo $to ?>">
                                </div>
                            </div>
                        </div>
                        <div class="wd-clearfix"></div>
                        <div class="wd-audit-event-context col span_12_of_12">
                            <label><?php esc_html_e( "Event Contexts", wp_defender()->domain ) ?></label>
                            <div class="wd-event-filter">
								<?php foreach ( WD_Audit_API::get_event_type() as $event ): ?>
                                    <div class="event">
                                        <input id="chk_<?php echo $event ?>" type="checkbox" name="event_type[]"
											<?php echo in_array( $event, WD_Utils::http_get( 'event_type', WD_Audit_API::get_event_type() ) ) ? 'checked="checked"' : null ?>
                                               value="<?php echo $event ?>">
                                        <label
                                                for="chk_<?php echo $event ?>"><?php echo esc_html( ucwords( str_replace( '_', ' ', $event ) ) ) ?></label>
                                    </div>
								<?php endforeach; ?>
                            </div>
                        </div>
                        <div class="wd-clearfix"></div>
                        <!--<div class="col span_12_of_12">
							<button type="submit"
							        class="button button-grey"><?php /*esc_html_e( "Apply Filter", wp_defender()->domain ) */ ?></button>
						</div>-->
                    </form>
                </div>
            </div>
			<?php if ( $total_items > 0 ): ?>

                <div class="tablenav <?php echo esc_attr( $which ); ?>">
					<?php
					$this->pagination( $which );
					?>

                    <div class="wd-clearfix"></div>
                </div>
                <br/>
                <br/>
			<?php endif; ?>
			<?php
		} elseif ( 'bottom' == $which ) {
			if ( count( $this->items ) == 0 ) {
				return;
			}
			?>
            <div class="tablenav <?php echo esc_attr( $which ); ?>">
				<?php
				$this->pagination( $which );
				?>

                <br class="clear"/>
            </div>
			<?php
		}
	}

	protected function pagination( $which ) {
		if ( empty( $this->_pagination_args ) ) {
			return;
		}

		$total_items = $this->_pagination_args['total_items'];
		$total_pages = $this->_pagination_args['total_pages'];
		$per_page    = $this->_pagination_args['per_page'];

		if ( $total_items == 0 ) {
			return;
		}

		$links        = array();
		$current_page = $this->get_pagenum();
		/**
		 * if pages less than 7, display all
		 * if larger than 7 we will get 3 previous page of current, current, and .., and, and previous, next, first, last links
		 */
		$current_url = set_url_scheme( 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] );
		$current_url = remove_query_arg( array( 'hotkeys_highlight_last', 'hotkeys_highlight_first' ), $current_url );

		$radius = 3;

		if ( $current_page > 1 && $total_pages > $radius ) {
			$links['first'] = sprintf( '<a class="button audit-nav button-light" href="%s">%s</a>',
				add_query_arg( 'paged', 1, $current_url ), '&laquo;' );
			$links['prev']  = sprintf( '<a class="button audit-nav button-light" href="%s">%s</a>',
				add_query_arg( 'paged', $current_page - 1, $current_url ), '&lsaquo;' );
		}

		for ( $i = 1; $i <= $total_pages; $i ++ ) {
			if ( ( $i >= 1 && $i <= $radius ) || ( $i > $current_page - 2 && $i < $current_page + 2 ) || ( $i <= $total_pages && $i > $total_pages - $radius ) ) {
				if ( $i == $current_page ) {
					$links[ $i ] = sprintf( '<a href="#" class="button audit-nav button-light" disabled="">%s</a>', $i );
				} else {
					$links[ $i ] = sprintf( '<a class="button audit-nav button-light" href="%s">%s</a>',
						add_query_arg( 'paged', $i, $current_url ), $i );
				}
			} elseif ( $i == $current_page - $radius || $i == $current_page + $radius ) {
				$links[ $i ] = '<a href="#" class="button audit-nav button-light" disabled="">...</a>';
			}
		}

		if ( $current_page < $total_pages && $total_pages > $radius ) {
			$links['next'] = sprintf( '<a class="button audit-nav button-light" href="%s">%s</a>',
				add_query_arg( 'paged', $current_page + 1, $current_url ), '&rsaquo;' );
			$links['last'] = sprintf( '<a class="button audit-nav button-light" href="%s">%s</a>',
				add_query_arg( 'paged', $total_pages, $current_url ), '&raquo;' );
		}
		$output                 = '<span data-count="' . esc_attr( $total_items ) . '" class="num-results">' . sprintf( _n( '%s log found', '%s logs found', $total_items, wp_defender()->domain ),
				number_format_i18n( $total_items ) ) . '</span>';
		$pagination_links_class = 'wd-button-group';
		if ( $total_pages ) {
			$page_class = $total_pages < 2 ? ' one-page' : '';
		} else {
			$page_class = ' no-pages';
		}
		$output .= "\n<div class='$pagination_links_class'>" . join( "\n", $links ) . '</div>';
		$this->_pagination = '<div class="wd-audit-paginate">' . $output . '</div>';

		echo $this->_pagination;
	}
}