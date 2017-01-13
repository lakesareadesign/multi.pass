<?php

/**
 * Author: Hoang Ngo
 */
namespace WP_Defender\IP_Lockout\Model;

class Log_Model extends \WD_Post_Model {
	const AUTH_FAIL = 'auth_fail', AUTH_LOCK = 'auth_lock', ERROR_404 = '404_error', LOCKOUT_404 = '404_lockout', ERROR_404_IGNORE = '404_error_ignore';
	public $table = 'wd_iplockout_log';

	public $id;
	public $log;
	public $ip;
	public $date;
	public $user_agent;
	public $type;
	public $blog_id;

	protected $relations = array(
		array(
			'type' => 'native',
			'prop' => 'id',
			'wp'   => 'ID'
		),
		array(
			'type' => 'wp_meta',
			'prop' => 'log',
			'wp'   => 'log'
		),
		array(
			'type' => 'wp_meta',
			'prop' => 'ip',
			'wp'   => 'ip'
		),
		array(
			'type' => 'wp_meta',
			'prop' => 'date',
			'wp'   => 'date'
		),
		array(
			'type' => 'wp_meta',
			'prop' => 'type',
			'wp'   => 'type'
		),
		array(
			'type' => 'wp_meta',
			'prop' => 'user_agent',
			'wp'   => 'user_agent'
		),
		array(
			'type' => 'wp_meta',
			'prop' => 'blog_id',
			'wp'   => 'blog_id'
		)
	);

	/**
	 * @return string
	 */
	public function get_ip() {
		return esc_html( $this->ip );
	}

	/**
	 * @return string
	 */
	public function get_log_text( $format = false ) {
		if ( ! $format ) {
			return esc_html( $this->log );
		} else {
			$text = sprintf( __( "Request for file <span class='log-text-table' tooltip='%s'>%s</span> which doesn't exist", wp_defender()->domain ), esc_attr( $this->log ), pathinfo( $this->log, PATHINFO_BASENAME ) );

			return $text;
		}
	}

	public function before_update() {
		$this->blog_id = get_current_blog_id();
	}

	public function before_insert() {
		$this->blog_id = get_current_blog_id();
	}

	/**
	 * @return string
	 */
	public function get_date() {
		return esc_html( get_date_from_gmt( date( 'Y-m-d H:i:s', $this->date ), \WD_Utils::get_date_time_format() ) );
	}

	/**
	 * @return mixed|null
	 */
	public function get_type() {
		$types = array(
			'auth_fail'        => __( "Failed login attempts", wp_defender()->domain ),
			'auth_lock'        => __( "Login lockout", wp_defender()->domain ),
			'404_error'        => __( "404 error", wp_defender()->domain ),
			'404_error_ignore' => __( "404 error", wp_defender()->domain ),
			'404_lockout'      => __( "404 lockout", wp_defender()->domain )
		);

		if ( isset( $types[ $this->type ] ) ) {
			return $types[ $this->type ];
		}

		return null;
	}

	/**
	 * @param string $class_name
	 *
	 * @return Log_Model
	 */
	public static function model( $class_name = __CLASS__ ) {
		return parent::model( $class_name );
	}
}