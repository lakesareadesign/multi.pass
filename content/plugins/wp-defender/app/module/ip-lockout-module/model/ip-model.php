<?php

/**
 * Author: Hoang Ngo
 */
namespace WP_Defender\IP_Lockout\Model;
class IP_Model extends \WD_Post_Model {
	const STATUS_BLOCKED = 'blocked', STATUS_NORMAL = 'normal';

	public $table = 'wd_ip_lockout';

	public $id;
	public $ip;
	public $status;
	public $lockout_message;
	public $release_time;
	public $lock_time;
	public $lock_time_404;
	public $attempt;
	public $attempt_404;

	protected $relations = array(
		array(
			'type' => 'native',
			'prop' => 'id',
			'wp'   => 'ID'
		),
		array(
			'type' => 'wp_meta',
			'prop' => 'ip',
			'wp'   => 'ip'
		),
		array(
			'type' => 'wp_meta',
			'prop' => 'status',
			'wp'   => 'status'
		),
		array(
			'type' => 'wp_meta',
			'prop' => 'lockout_message',
			'wp'   => 'lockout_message'
		),
		array(
			'type' => 'wp_meta',
			'prop' => 'release_time',
			'wp'   => 'release_time'
		),
		array(
			'type' => 'wp_meta',
			'prop' => 'lock_time',
			'wp'   => 'lock_time'
		),
		array(
			'type' => 'wp_meta',
			'prop' => 'lock_time_404',
			'wp'   => 'lock_time_404'
		),
		array(
			'type' => 'wp_meta',
			'prop' => 'attempt',
			'wp'   => 'attempt'
		)
	);

	/**
	 * @return bool
	 */
	public function is_locked() {
		if ( $this->status == self::STATUS_BLOCKED ) {
			if ( $this->release_time < time() ) {
				//unlock it
				$this->attempt = 0;
				$this->status  = self::STATUS_NORMAL;
				$this->save();

				return false;
			} else {
				return true;
			}
		}

		return false;
	}

	/**
	 * @param string $class_name
	 *
	 * @return IP_Model
	 */
	public static function model( $class_name = __CLASS__ ) {
		return parent::model( $class_name );
	}
}