<?php

/**
 * @author: Hoang Ngo
 */
class WD_Audit_API extends WD_Component {
	const ACTION_ADDED = 'added', ACTION_UPDATED = 'updated', ACTION_DELETED = 'deleted', ACTION_TRASHED = 'trashed',
		ACTION_RESTORED = 'restored';


	private static $cache;

	private static $order_by;
	private static $order;

	public static $end_point = 'audit.wpmudev.org';

	/**
	 * @param $data
	 */
	public static function submit_to_api( $data ) {
		//currently write to text
		//@self::log( var_export( $data, true ), self::ERROR_LEVEL_INFO, 'audit' );
		//return self::submit_to_local( $data );

		$component = new WD_Component();
		$ret       = $component->wpmudev_call( 'https://' . self::$end_point . '/logs/add_multiple', $data, array(
			'method'  => 'POST',
			'timeout' => 1,
			//'sslverify' => false,
			'headers' => array(
				'apikey' => WD_Utils::get_dev_api()
			)
		), true );
	}

	/**
	 * create a new socket
	 */
	public static function open_socket() {
		if ( ! isset( wp_defender()->global['sockets'] ) ) {
			$start = new DateTime();
			//$fp = fsockopen( 'ssl://' . WD_Audit_API::$end_point, 443, $err, $errstr );
			$fp = @stream_socket_client( 'ssl://' . WD_Audit_API::$end_point . ':443', $errno, $errstr,
				3, // timeout should be ignored when ASYNC
				STREAM_CLIENT_ASYNC_CONNECT );

			if ( is_resource( $fp ) ) {
				//socket_set_nonblock( $fp );
				wp_defender()->global['sockets'][] = $fp;
			}
			$end = new DateTime();
			@WD_Component::log( 'time for create socket ' . $end->diff( $start )->format( '%s' ) );

		}
	}

	public static function get_mime_type( $post_ID ) {
		$file_path = get_post_meta( $post_ID, '_wp_attached_file', true );

		return pathinfo( $file_path, PATHINFO_EXTENSION );
	}

	/**
	 * @param $data
	 *
	 * @return bool
	 */
	public static function submit_to_api_socket( $data ) {
		/**
		 * set stream select to 0, to get the socket immediatly, usually this should be ready here.
		 * If yes, then process as normal, if not, we will try to pass the socket directly without to check it ready for test
		 * then check the resonponse if it 200 or not
		 * if all fail, then fall to curl
		 */
		$sockets = isset( wp_defender()->global['sockets'] ) ? wp_defender()->global['sockets'] : array();
		//we will need to wait a little bit
		if ( count( $sockets ) == 0 ) {
			//fall back
			return false;
		}

		$sks = $sockets;
		$r   = null;
		$e   = null;

		if ( ( $socket_ready = stream_select( $r, $sks, $e, 1 ) ) === false ) {
			//this case error happen
			@WD_Component::log( 'socket error' );

			return false;
		} elseif ( $socket_ready == 0 ) {
			@WD_Component::log( 'no socket ready' );

			return self::_submit_by_socket_check_later( $data, $sockets );
		}

		//if here, mean we got something okay
		$fp = array_shift( $sockets );

		$uri  = '/logs/add_multiple';
		$vars = http_build_query( $data );

		# compose HTTP request header
		$header = "Host: " . WD_Audit_API::$end_point . "\r\n";
		$header .= "User-Agent: WPMUDEV Audit Logging\r\n";
		$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
		$header .= "Content-Length: " . strlen( $vars ) . "\r\n";
		$header .= 'apikey:' . WD_Utils::get_dev_api() . "\r\n";
		$header .= "Connection: close\r\n\r\n";

		fputs( $fp, "POST " . $uri . "  HTTP/1.1\r\n" );
		fputs( $fp, $header . $vars );

		fclose( $fp );

		return true;
	}

	private static function _submit_by_socket_check_later( $data, $sockets ) {
		$fp = array_shift( $sockets );

		$uri  = '/logs/add_multiple';
		$vars = http_build_query( $data );

		# compose HTTP request header
		$header = "Host: " . WD_Audit_API::$end_point . "\r\n";
		$header .= "User-Agent: WPMUDEV Audit Logging\r\n";
		$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
		$header .= "Content-Length: " . strlen( $vars ) . "\r\n";
		$header .= 'apikey:' . WD_Utils::get_dev_api() . "\r\n";
		$header .= "Connection: close\r\n\r\n";

		fputs( $fp, "POST " . $uri . "  HTTP/1.1\r\n" );
		fputs( $fp, $header . $vars );
		$return = fread( $fp, 1000 );
		fclose( $fp );

		//now check the http header
		list( $headers, $body ) = preg_split( "#\n\s*\n#Uis", $return );
		$body = json_decode( $body, true );
		if ( is_array( $body ) && $body['status'] == 1 ) {
			return true;
		}

		return false;
	}

	public static function dictionary() {
		return array(
			self::ACTION_TRASHED  => __( "trashed", wp_defender()->domain ),
			self::ACTION_UPDATED  => __( "updated", wp_defender()->domain ),
			self::ACTION_DELETED  => __( "deleted", wp_defender()->domain ),
			self::ACTION_ADDED    => __( "created", wp_defender()->domain ),
			self::ACTION_RESTORED => __( "restored", wp_defender()->domain ),
		);
	}

	/**
	 * Queue event data prepare for submitting
	 * if this is ajax, we will queued inside database, if not just, use global
	 *
	 * @param $data
	 * since 1.1
	 */
	public static function queue_events_data( $data ) {
		wp_defender()->global['events_queue'][] = $data;
	}

	public static function get_logs( $filter = array(), $order_by = 'timestamp', $order = 'desc' ) {
		$component        = new WD_Component();
		$data             = $filter;
		$data['site_url'] = network_site_url();
		$data['order_by'] = $order_by;
		$data['order']    = $order;
		$response         = $component->wpmudev_call( 'https://' . self::$end_point . '/logs', $data, array(
			'method'  => 'GET',
			'timeout' => 20,
			//'sslverify' => false,
			'headers' => array(
				'apikey' => WD_Utils::get_dev_api()
			)
		), true );

		if ( is_wp_error( $response ) ) {
			return $response;
		}

		if ( wp_remote_retrieve_response_code( $response ) == 200 ) {
			$body    = wp_remote_retrieve_body( $response );
			$results = json_decode( $body, true );
			if ( isset( $results['message'] ) ) {
				return new WP_Error( 'api_error', $results['message'] );
			}

			return $results;
		}

		return new WP_Error( 'retrieve_data_error', sprintf( __( "Whoops, Defender had trouble loading up your event log. You can try a <a href='%s'class=''>​quick refresh</a>​ of this page or check back again later.", wp_defender()->domain ),
			network_admin_url( 'admin.php?page=wdf-logging' ) ) );
	}

	public static function sort_logs( $a, $b ) {
		switch ( self::$order_by ) {
			case 'timestamp':
				if ( self::$order == 'desc' ) {
					return $b['timestamp'] > $a['timestamp'];
				} elseif ( self::$order == 'desc' ) {
					return $a['timestamp'] > $b['timestamp'];
				}

				return 0;
		}
	}

	public static function get_data() {
		return array();
	}

	public static function get_users() {
		$users = get_users();

		return $users;
	}

	public static function get_event_type() {
		return isset( wp_defender()->global['event_types'] ) ? wp_defender()->global['event_types'] : array();
	}

	/**
	 * @param $slug
	 *
	 * @return mixed
	 */
	public static function get_action_text( $slug ) {
		$dic = isset( wp_defender()->global['dictionary'] ) ? wp_defender()->global['dictionary'] : array();

		return isset( $dic[ $slug ] ) ? $dic[ $slug ] : $slug;
	}

	/**
	 * A text can contain various linkable like post name, site_url etc, we need to make that link clickable
	 *
	 * @param $text
	 */
	public static function liveable_audit_log( $text ) {
		//first need to get the site id
		$site_id = 1;
		//rip out any html if any
		$text = esc_html( $text );

		$text = str_replace( '; ', '<br/>', $text );

		/**
		 * we continue to check anything with ID, usually it will be
		 * comment ID
		 * file URL
		 */

		return $text;
		//we got the site ID.
	}

	public static function remove_http( $url ) {
		$parts = parse_url( $url );

		return $parts['host'] . ( isset( $parts['part'] ) ? $parts['part'] : null );
	}
}