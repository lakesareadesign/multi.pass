<?php

/**
 * Author: Hoang Ngo
 */

namespace WP_Defender\Module\IP_Lockout\Model;

use Hammer\Base\DB_Model;

class IP_Model extends DB_Model {
	const STATUS_BLOCKED = 'blocked', STATUS_NORMAL = 'normal';

	protected static $tableName = 'defender_lockout';

	public $id;
	public $ip;
	public $status;
	public $lockout_message;
	public $release_time;
	public $lock_time;
	public $lock_time_404;
	public $attempt;
	public $attempt_404;

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
}