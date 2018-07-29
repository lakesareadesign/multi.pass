<?php

class Smartcrawl_Controller_Hub {


	private static $_instance;

	private $_is_running = false;

	private function __construct() {
	}

	/**
	 * Boot controller listeners
	 *
	 * Do it only once, if they're already up do nothing
	 *
	 * @return bool Status
	 */
	public static function serve() {
		$me = self::get();
		if ( $me->is_running() ) {
			return false;
		}

		$me->_add_hooks();

		return true;
	}

	/**
	 * Obtain instance without booting up
	 *
	 * @return Smartcrawl_Controller_Hub instance
	 */
	public static function get() {
		if ( empty( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	/**
	 * Check if we already have the actions bound
	 *
	 * @return bool Status
	 */
	public function is_running() {
		return $this->_is_running;
	}

	/**
	 * Bind listening actions
	 */
	private function _add_hooks() {
		// Passthrough.
		$this->_is_running = true;
	}

	/**
	 * Registers Hub action listeners
	 *
	 * @param array $actions All the Hub actions registered this far
	 *
	 * @return array Augmented actions
	 */
	public function register_hub_actions( $actions ) {
		// Passthrough.
		return $actions;
	}

	/**
	 * Fresh ignores from the Hub action handler
	 *
	 * Updates local ignores list when the Hub storage is updated.
	 *
	 * @param object $params Hub-provided parameters
	 * @param string $action Action called
	 *
	 * @return bool Status
	 */
	public function sync_ignores_list( $params = array(), $action = '' ) {
		return false; // Not in the free version.
	}

	/**
	 * Fresh ignores from the Hub action handler
	 *
	 * Updates local ignores list when the Hub storage is updated.
	 *
	 * @param object $params Hub-provided parameters
	 * @param string $action Action called
	 */
	public function json_sync_ignores_list( $params = array(), $action = '' ) {
	}

	/**
	 * Purge ignores from the Hub action handler
	 *
	 * Purges local ignores list when the Hub storage is purged.
	 *
	 * @param object $params Hub-provided parameters
	 * @param string $action Action called
	 *
	 * @return bool Status
	 */
	public function purge_ignores_list( $params = array(), $action = '' ) {
		return false; // Not in the free version.
	}

	/**
	 * Purge ignores from the Hub action handler
	 *
	 * Purges local ignores list when the Hub storage is purged.
	 *
	 * @param object $params Hub-provided parameters
	 * @param string $action Action called
	 */
	public function json_purge_ignores_list( $params = array(), $action = '' ) {
	}

	/**
	 * Fresh extras from the Hub action handler
	 *
	 * Updates local extra URLs list when the Hub storage is updated.
	 *
	 * @param object $params Hub-provided parameters
	 * @param string $action Action called
	 *
	 * @return bool Status
	 */
	public function sync_extras_list( $params = array(), $action = '' ) {
		return false; // Not in the free version.
	}

	/**
	 * Fresh extras from the Hub action handler
	 *
	 * Updates local extra URLs list when the Hub storage is updated.
	 *
	 * @param object $params Hub-provided parameters
	 * @param string $action Action called
	 */
	public function json_sync_extras_list( $params = array(), $action = '' ) {
	}

	/**
	 * Purge extras from the Hub action handler
	 *
	 * Purges local extra URLs list when the Hub storage is updated.
	 *
	 * @param object $params Hub-provided parameters
	 * @param string $action Action called
	 *
	 * @return bool Status
	 */
	public function purge_extras_list( $params = array(), $action = '' ) {
		return false; // Not in the free version.
	}

	/**
	 * Purge extras from the Hub action handler
	 *
	 * Purges local extra URLs list when the Hub storage is updated.
	 *
	 * @param object $params Hub-provided parameters
	 * @param string $action Action called
	 */
	public function json_purge_extras_list( $params = array(), $action = '' ) {
	}


}