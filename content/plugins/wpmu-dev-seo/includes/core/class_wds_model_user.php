<?php

class WDS_Model_User extends WDS_Model {

	/**
	 * Holds the user ID reference used in the constructor
	 *
	 * @var int
	 */
	private $_user_id;

	/**
	 * Holds the user object cache
	 *
	 * @var WP_User object
	 */
	private $_user;

	/**
	 * Current user convenience factory method
	 *
	 * @return WDS_Model_User Current user instance
	 */
	public static function current () {
		return self::get(get_current_user_id());
	}

	/**
	 * Particular user convenience factory method
	 *
	 * @param int $user_id User ID
	 *
	 * @return WDS_Model_User Particular user instance
	 */
	public static function get ($user_id=false) {
		return new self($user_id);
	}

	public function __construct ($user_id=false) {
		if (!empty($user_id) && is_numeric($user_id)) {
			$this->_user_id = (int)$user_id;
			$this->_user = new WP_User($user_id);
		} else {
			$this->_user_id = false;
			$this->_user = new WP_User;
		}
	}

	/**
	 * Returns the user ID
	 *
	 * @return int
	 */
	public function get_id () {
		return (int)$this->_user_id;
	}

	/**
	 * Returns user first name
	 *
	 * @return string First name, or display name
	 */
	public function get_first_name () {
		$name = $this->_user->user_firstname;
		$name = !empty($name)
			? $name
			: $this->get_display_name()
		;
		return apply_filters(
			$this->get_filter('first_name'),
			$name,
			$this->_user_id
		);
	}

	/**
	 * Returns user display name
	 *
	 * @return string Display name, or fallback
	 */
	public function get_display_name () {
		$name = $this->_user->display_name;
		$name = !empty($name)
			? $name
			: $this->get_fallback_name()
		;
		return apply_filters(
			$this->get_filter('display_name'),
			$name,
			$this->_user_id
		);
	}

	/**
	 * Returns the fallback name, for when other methods fail
	 *
	 * @return string
	 */
	public function get_fallback_name () {
		$name = $this->_user->user_nicename;
		$name = !empty($name)
			? $name
			: __('Anonymous', 'wds')
		;
		return apply_filters(
			$this->get_filter('fallback_name'),
			$name,
			$this->_user_id
		);
	}

	public function get_type () { return 'user'; }
}