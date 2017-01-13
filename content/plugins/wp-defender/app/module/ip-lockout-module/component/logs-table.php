<?php
/**
 * Author: Hoang Ngo
 */

namespace WP_Defender\IP_Lockout\Component;

use WP_Defender\IP_Lockout\Model\Log_Model;
use WP_Defender\IP_Lockout\Model\Settings_Model;

class Logs_Table extends \WP_List_Table {
	public function __construct( $args = array() ) {
		parent::__construct( array_merge( array(
			'plural'     => '',
			'autoescape' => false,
			'screen'     => 'lockout_logs'
		), $args ) );
	}

	/**
	 * @return array
	 */
	function get_table_classes() {
		return array(
			'list-table',
			//'hover-effect',
			'logs',
			'intro'
		);
	}

	/**
	 * @return array
	 */
	function get_columns() {
		$columns = array(
			'reason' => esc_html__( 'LOCKOUT REASON', wp_defender()->domain ),
			'ip'     => esc_html__( 'IP', wp_defender()->domain ),
			'date'   => esc_html__( 'DATE', wp_defender()->domain ),
			'action' => ''
		);

		return $columns;
	}

	protected function get_sortable_columns() {
		return array(
			'reason' => array( 'log', true ),
			'date'   => array( 'date', true ),
			'ip'     => array( 'ip', true ),
		);
	}

	function prepare_items() {
		$paged    = $this->get_pagenum();
		$per_page = 20;

		$addition_params = array();
		if ( ( $orderby = \WD_Utils::http_get( 'orderby', null ) ) != null ) {
			$order                       = \WD_Utils::http_get( 'order', null );
			$addition_params['orderby']  = 'meta_value';
			$addition_params['meta_key'] = $orderby;
			$addition_params['order']    = $order;
		} else {
			$addition_params['orderby'] = 'ID';
			$addition_params['order']   = 'DESC';
		}

		$addition_params['date_query'] = array(
			'after' => '-30 days'
		);

		$params = array();
		if ( ( $filter = \WD_Utils::http_get( 'filter', null ) ) != null ) {
			$params['type'] = $filter;
		}

		$logs = Log_Model::model()->find_all( $params, $per_page, $paged, $addition_params, $wp_query );
		$this->set_pagination_args( array(
			'total_items' => $wp_query->found_posts,
			'total_pages' => $wp_query->max_num_pages,
			'per_page'    => $per_page
		) );

		$this->_column_headers = array( $this->get_columns(), array(), $this->get_sortable_columns() );
		$this->items           = $logs;
	}

	/**
	 * @param Log_Model $log
	 *
	 * @return string
	 */
	public function column_action( Log_Model $log ) {
		return Login_Protection_Api::get_logs_actions_text( $log );
	}

	/**
	 * @param Log_Model $log
	 *
	 * @return string
	 */
	public function column_reason( Log_Model $log ) {
		$type = '';
		if ( in_array( $log->type, array(
			Log_Model::AUTH_LOCK,
			Log_Model::AUTH_FAIL
		) ) ) {
			$type = 'login';
		} elseif ( in_array( $log->type, array(
			Log_Model::ERROR_404,
			Log_Model::ERROR_404_IGNORE,
			Log_Model::LOCKOUT_404
		) ) ) {
			$type = '404';
		}
		$class = "";
		if ( in_array( $log->type, array( Log_Model::AUTH_LOCK, Log_Model::LOCKOUT_404 ) ) ) {
			$class = "red";
		}
		$format = false;
		if ( $log->type == Log_Model::ERROR_404 ) {
			$format = true;
		}

		return '<span class="mark ' . $class . '">' . $type . '</span>' . '<span>' . $log->get_log_text( $format ) . '</span>';
	}

	/**
	 * @param Log_Model $log
	 *
	 * @return string
	 */
	public function column_date( Log_Model $log ) {
		return $log->get_date();
	}

	/**
	 * @param Log_Model $log
	 *
	 * @return string
	 */
	public function column_ip( Log_Model $log ) {
		$ip = $_SERVER['REMOTE_ADDR'];
		if ( $ip == $log->get_ip() ) {
			return '<span tooltip="' . esc_attr( $ip ) . '" class="badge">' . __( "You", wp_defender()->domain ) . '</span>';
		} else {
			return $log->get_ip();
		}
	}

	public function display() {
		$singular = $this->_args['singular'];

		$this->display_tablenav( 'top' );

		$this->screen->render_screen_reader_content( 'heading_list' );
		?>
		<table class="wp-list-table <?php echo implode( ' ', $this->get_table_classes() ); ?>">
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
		<?php
		$this->display_tablenav( 'bottom' );
	}

	protected function display_tablenav( $which ) {
		?>
		<div class="intro">
			<?php if ( $which === 'top' ): ?>
				<div class="float-l log-summary">
					<?php printf( esc_html__( 'Your website\'s lockout log for the past %s.', wp_defender()->domain ), apply_filters( 'ip_lockout_logs_store_backward', __( '30 days', wp_defender()->domain ) ) ) ?>
				</div>
			<?php endif; ?>
			<div class="def-pager float-r">
				<span><?php echo sprintf( esc_html__( "%s results", wp_defender()->domain ), $this->get_pagination_arg( 'total_items' ) ) ?></span>
				<?php $this->pagination( $which ); ?>
			</div>
			<div class="clearfix"></div>
		</div>
		<?php
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
			$links['first'] = sprintf( '<li><a class="button button-light" href="%s">%s</a></li>',
				add_query_arg( 'paged', 1, $current_url ), '&laquo;' );
			$links['prev']  = sprintf( '<li><a class="button button-light" href="%s">%s</a></li>',
				add_query_arg( 'paged', $current_page - 1, $current_url ), '&lsaquo;' );
		}

		for ( $i = 1; $i <= $total_pages; $i ++ ) {
			if ( ( $i >= 1 && $i <= $radius ) || ( $i > $current_page - 2 && $i < $current_page + 2 ) || ( $i <= $total_pages && $i > $total_pages - $radius ) ) {
				if ( $i == $current_page ) {
					$links[ $i ] = sprintf( '<li><a href="#" class="button audit-nav button-light" disabled="">%s</a></li>', $i );
				} else {
					$links[ $i ] = sprintf( '<li><a class="button audit-nav button-light" href="%s">%s</a></li>',
						add_query_arg( 'paged', $i, $current_url ), $i );
				}
			} elseif ( $i == $current_page - $radius || $i == $current_page + $radius ) {
				$links[ $i ] = '<li><a href="#" class="button audit-nav button-light" disabled="">...</a></li>';
			}
		}

		if ( $current_page < $total_pages && $total_pages > $radius ) {
			$links['next'] = sprintf( '<li><a class="button audit-nav button-light" href="%s">%s</a></li>',
				add_query_arg( 'paged', $current_page + 1, $current_url ), '&rsaquo;' );
			$links['last'] = sprintf( '<li><a class="button audit-nav button-light" href="%s">%s</a></li>',
				add_query_arg( 'paged', $total_pages, $current_url ), '&raquo;' );
		}
		$output            = "\n<ul>" . join( "\n", $links ) . '</ul>';
		$this->_pagination = $output;

		echo $this->_pagination;
	}
}