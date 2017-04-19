<?php

/**
 * Author: Hoang Ngo
 */

namespace WP_Defender\Module\Audit\Component;

use Hammer\Helper\HTTP_Helper;
use Hammer\Helper\Log_Helper;
use WP_Defender\Behavior\Utils;
use WP_Defender\Module\Scan\Component\Scan_Api;

class Audit_Table extends \WP_List_Table {
	private $error;
	protected $date_format = 'm/d/Y';
	protected $email_search;

	public function __construct( $args = array(), $email ) {
		parent::__construct( array_merge( array(
			'plural'     => '',
			'autoescape' => false,
			'screen'     => 'audit_table_ajax'
		), $args ) );
		$this->email_search = $email;
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
			//'col_type'    => esc_html__( 'Event Context', wp_defender()->domain ),
			//'col_action'  => esc_html__( "Action", wp_defender()->domain ),
			'col_ip'      => esc_html__( 'IP Address', wp_defender()->domain ),
			//'col_user'    => esc_html__( 'User', wp_defender()->domain ),
			'col-action'  => ''
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
		$attributes = array(
			'date_from'   => date( $this->date_format, strtotime( '-7 days', current_time( 'timestamp' ) ) ),
			'date_to'     => date( $this->date_format, current_time( 'timestamp' ) ),
			'user_id'     => '',
			'event_type'  => '',
			'ip'          => '',
			'context'     => '',
			'action_type' => '',
			'blog_id'     => 1
		);
		$params     = array();
		foreach ( $attributes as $att => $value ) {
			$params[ $att ] = HTTP_Helper::retrieve_get( $att, $value );
			if ( $att == 'date_from' || $att == 'date_to' ) {
				$df_object      = \DateTime::createFromFormat( $this->date_format, $params[ $att ] );
				$params[ $att ] = $df_object->format( 'Y-m-d' );
			} elseif ( $att == 'user_id' ) {
				$params['user_id'] = HTTP_Helper::retrieve_get( 'term' );
			}
		}

		$params['date_to']   = trim( $params['date_to'] . ' 23:59:59' );
		$params['date_from'] = trim( $params['date_from'] . ' 00:00:00' );
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

		$result = Audit_API::pullLogs( $params, HTTP_Helper::retrieve_get( 'order_by', 'timestamp' ), HTTP_Helper::retrieve_get( 'order', 'desc' ) );
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

	public function column_col_action() {
		return '<a href="#"><i class="dev-icon dev-icon-caret_down"></i></a>';
	}

	/**
	 * @param $item
	 *
	 * @return mixed
	 */
	public function column_col_summary( $item ) {
		$msg = Audit_API::liveable_audit_log( $item['msg'] );
		if ( Utils::instance()->isActivatedSingle() == false && $item['blog_id'] < 1 ) {
			$msg .= ( '<br/>' . sprintf( esc_html__( "Blog %s", wp_defender()->domain ), get_site_url( $item['blog_id'] ) ) );
		}
		$msg .= ( isset( $item['count'] ) ? ' (' . $item['count'] . ')' : null );

		return $msg;
		//return esc_html( $item['msg'] . ( isset( $item['count'] ) ? ' (' . $item['count'] . ')' : null ) );
	}

	/**
	 * @param $item
	 *
	 * @return string
	 */
	public function column_col_action1( $item ) {
		return sprintf( '<a class="afilter" href="%s">%s</a>', esc_url( add_query_arg( array(
			'page'        => 'wdf-logging',
			'action_type' => $item['action_type']
		), network_admin_url( 'admin.php' ) ) ), ucwords( Audit_API::get_action_text( $item['action_type'] ) ) );
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
            <strong><?php echo esc_html( Audit_API::time_since( $item['timestamp'][1] ) . esc_html__( " ago", wp_defender()->domain ) ) ?></strong>
			<?php
		} else {
			?>
            <strong><?php echo esc_html( Audit_API::time_since( $item['timestamp'] ) . esc_html__( " ago", wp_defender()->domain ) ) ?></strong>
			<?php
		}

		return ob_get_clean();
	}

	public function column_col_type( $item ) {
		$type = Audit_API::get_action_text( $item['event_type'] );

		$html = sprintf( '<a class="afilter" href="%s">%s</a>', $this->build_filter_url( 'event_type[]', $item['event_type'] ), ucwords( $type ) );
		$html .= ' / ' . sprintf( '<a class="afilter" href="%s">%s</a>', $this->build_filter_url( 'context', $item['context'] ), ucwords( Audit_API::get_action_text( $item['context'] ) ) );

		return $html;
	}

	public function column_col_ip( $item ) {
		return sprintf( '<a class="" href="%s">%s</a>', $this->build_filter_url( 'ip', $item['ip'] ), $item['ip'] );
	}

	public function column_col_user( $item ) {
		ob_start();
		?>

		<?php if ( $item['user_id'] == 0 ): ?>
			<?php printf( '<a class="afilter" href="%s">%s</a>',
				$this->build_filter_url( 'term', 0 ),
				esc_html__( "Guest", wp_defender()->domain )
			) ?>
		<?php else: ?>
			<?php printf( '<a class="afilter" href="%s">%s</a>',
				$this->build_filter_url( 'term', $item['user_id'] ),
				Utils::instance()->getDisplayName( $item['user_id'] )
			) ?>
            <span class="sub">
				<?php
				$user = get_user_by( 'id', $item['user_id'] );
				echo ucwords( implode( $user->roles, '<br/>' ) );
				?>
			</span>
		<?php endif; ?>
		<?php
		return ob_get_clean();
	}

	public function display() {
		$singular   = $this->_args['singular'];
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
			<?php
			if ( ! defined( 'DOING_AJAX' ) ):
				$from = esc_attr( Http_Helper::retrieve_get( 'date_from', date( $this->date_format, strtotime( 'today midnight', strtotime( '-7 days', current_time( 'timestamp' ) ) ) ) ) );
				$to = esc_attr( Http_Helper::retrieve_get( 'date_to', date( $this->date_format, current_time( 'timestamp' ) ) ) );
				?>
                <div class="well well-white audit-filter mline">
                    <form method="post">
                        <strong>
							<?php _e( "Filter", wp_defender()->domain ) ?>
                        </strong>
                        <div class="columns">
                            <div class="column is-5">
								<?php echo $this->email_search->renderInput() ?>

                            </div>
                            <div class="column is-5">
                                <input name="date_from" id="wd_range_from" type="text" class="wd-calendar"
                                       value="<?php echo $from . ' - ' . $to ?>">
                            </div>
                        </div>
                        <div class="events">
							<?php foreach ( Audit_API::get_event_type() as $event ): ?>
                                <div class="event">
                                    <input id="chk_<?php echo $event ?>" type="checkbox" name="event_type[]"
										<?php echo in_array( $event, HTTP_Helper::retrieve_get( 'event_type', Audit_API::get_event_type() ) ) ? 'checked="checked"' : null ?>
                                           value="<?php echo $event ?>">
                                    <label
                                            for="chk_<?php echo $event ?>"><?php echo esc_html( ucwords( str_replace( '_', ' ', $event ) ) ) ?></label>
                                </div>
							<?php endforeach; ?>
                        </div>
                    </form>
                    <div class="clear"></div>
                </div>
                <button type="button" class="button button-grey block mline wd-hide new-event-count">

                </button>
			<?php endif; ?>
            <div class="audit-logs-container">
				<?php $this->display_tablenav( 'top' ); ?>
                <table id="wd-audit-table">
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
				<?php $this->display_tablenav( 'bottom' ) ?>
            </div>
		<?php else: ?>
			<?php $this->display_tablenav( 'top' ); ?>
            <div class="audit-logs-container">
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
					if ( HTTP_Helper::retrieve_get( $val, false ) !== false ) {
						$is_filter = true;
						break;
					}
				}
				?>
				<?php if ( $is_filter == false ): ?>
                    <div class="wd-well wd-well-blue audit-nologs">
						<?php esc_html_e( "Defender hasn’t detected any events yet. When he does, they’ll appear here!", wp_defender()->domain ) ?>
                    </div>
				<?php else: ?>
                    <div class="wd-well wd-well-blue audit-nologs">
						<?php esc_html_e( "Defender couldn't find any logs matching your filters.", wp_defender()->domain ) ?>
                    </div>
				<?php endif; ?>
            </div>
		<?php endif; ?>
		<?php
	}

	private function build_filter_url( $type, $value ) {
		/**
		 * when click on a filter link, we will havet o include the current date range, and from
		 * we will need to keep the current get too
		 */
		$allowed     = array(
			'event_type',
			'term',
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

		return '#' . http_build_query( $http_params );
	}

	protected function display_tablenav( $which ) {
		if ( isset( $this->_pagination_args['total_items'] ) ) {
			$total_items = $this->_pagination_args['total_items'];
		} else {
			$total_items = 0;
		}
		?>
		<?php if ( $total_items > 0 ): ?>
            <div class="clear"></div>
            <div data-total="<?php echo $this->get_pagination_arg( 'total_items' ) ?>"
                 class="bulk-nav <?php echo $which == 'top' ? 'mline' : null ?>">
                <div class="nav">
                    <span><?php printf( __( "%d Results", wp_defender()->domain ), $this->_pagination_args['total_items'] ) ?></span>
                    <div class="button-group is-hidden-mobile">
						<?php $this->pagination( $which ) ?>
                    </div>
                </div>
                <div class="clear"></div>
            </div>
		<?php endif; ?>
		<?php
	}

	protected function pagination( $which ) {
		if ( empty( $this->_pagination_args ) ) {
			return;
		}

		$total_items = $this->_pagination_args['total_items'];
		$total_pages = $this->_pagination_args['total_pages'];

		if ( $total_items == 0 ) {
			return;
		}

		if ( $total_pages < 2 ) {
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
			$links['first'] = sprintf( '<a class="button button-light" href="%s">%s</a>',
				add_query_arg( 'paged', 1, $current_url ), '&laquo;' );
			$links['prev']  = sprintf( '<a class="button button-light" href="%s">%s</a>',
				add_query_arg( 'paged', $current_page - 1, $current_url ), '&lsaquo;' );
		}

		for ( $i = 1; $i <= $total_pages; $i ++ ) {
			if ( ( $i >= 1 && $i <= $radius ) || ( $i > $current_page - 2 && $i < $current_page + 2 ) || ( $i <= $total_pages && $i > $total_pages - $radius ) ) {
				if ( $i == $current_page ) {
					$links[ $i ] = sprintf( '<a href="#" class="button  button-light" disabled="">%s</a>', $i );
				} else {
					$links[ $i ] = sprintf( '<a class="button  button-light" href="%s">%s</a>',
						add_query_arg( 'paged', $i, $current_url ), $i );
				}
			} elseif ( $i == $current_page - $radius || $i == $current_page + $radius ) {
				$links[ $i ] = '<a href="#" class="button  button-light" disabled="">...</a>';
			}
		}

		if ( $current_page < $total_pages && $total_pages > $radius ) {
			$links['next'] = sprintf( '<a class="button  button-light" href="%s">%s</a>',
				add_query_arg( 'paged', $current_page + 1, $current_url ), '&rsaquo;' );
			$links['last'] = sprintf( '<a class="button  button-light" href="%s">%s</a>',
				add_query_arg( 'paged', $total_pages, $current_url ), '&raquo;' );
		}
		$output            = join( "\n", $links );
		$this->_pagination = $output;

		echo $this->_pagination;
	}
}