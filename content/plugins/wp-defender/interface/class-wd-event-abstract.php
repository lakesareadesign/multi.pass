<?php

/**
 * @author: Hoang Ngo
 */
abstract class WD_Event_Abstract extends WD_Component {
	const LOG_LEVEL_DEBUG = 0,
		LOG_LEVEL_NOTICE = 1,
		LOG_LEVEL_INFO = 2,
		LOG_LEVEL_WARNING = 3,
		LOG_LEVEL_ERROR = 4,
		LOG_LEVEL_FATAL = 5;


	/**
	 * todo send email to receiptions when an event written
	 */
	public function notify_event() {

	}

	/**
	 * @param $message
	 * @param $level
	 * @param $module
	 * @param null $user
	 */
	public function write_event( $message, $level, $module, $user = null ) {

	}
}