<?php

class WDS_SeoReport {

	private static $_instance;

	private $_items = array();
	private $_by_type = array();
	private $_ignores = array();

	private function __construct () {}
	private function __clone () {}

	public static function get () {
		if (empty(self::$_instance)) self::$_instance = new self;
		return self::$_instance;
	}

	/**
	 * Builds report instance
	 *
	 * @param array $raw Raw issues list, as returned by service
	 *
	 * @return object WDS_SeoReport instance
	 */
	public static function build ($raw) {
		if (!is_array($raw)) $raw = array();
		$me = self::get();

		foreach ($raw as $type => $items) {
			if (!is_array($items) || empty($items)) continue;
			if (!in_array($type, array_keys($me->_by_type))) $me->_by_type[$type] = array();
			foreach ($items as $item) {
				$key = $me->get_item_key($item, $type);
				if (empty($key)) continue; // Invalid key

				$item['type'] = $type;

				$me->_items[$key] = $item;
				$me->_by_type[$type][] = $key;
			}
		}

		// TODO: populate ignores here
		// ...

		return $me;
	}

	/**
	 * Creates an unique key for a corresponding item
	 *
	 * @param array $item Item to create the key for
	 * @param string $type Optional item type
	 *
	 * @return string Unique key
	 */
	public function get_item_key ($item, $type=false) {
		if (!is_array($item)) return false;
		if (empty($item['path'])) return false;

		if (empty($type)) $type = 'generic';

		return md5("{$type}-{$item['path']}");
	}

	/**
	 * Returns known issue types
	 *
	 * @return array List of known issue types identifiers
	 */
	public function get_issue_types () {
		return array_keys($this->_by_type);
	}

	/**
	 * Gets unique IDs of all issues
	 *
	 * @return array List of all known issues
	 */
	public function get_all_issues () {
		return array_keys($this->_items);
	}

	/**
	 * Gets a list of ignored items
	 *
	 * @return array List of ignored items unique IDs
	 */
	public function get_ignored_issues () {
		return $this->_ignores;
	}

	/**
	 * Gets ignored issues count, all or by type
	 *
	 * @param string $type Optional issue type to count ignores for
	 *                     - if omitted, all ignores are counted
	 *
	 * @return int Ignored issues count
	 */
	public function get_ignored_issues_count ($type=false) {
		$issues = empty($type)
			? $this->get_all_issues()
			: $this->get_issues_by_type($type)
		;
		$count = 0;

		foreach ($issues as $key) {
			if ($this->is_ignored_issue($key)) $count++;
		}

		return (int)$count;
	}

	/**
	 * Gets issues for a specific issue type
	 *
	 * @param string $type Type identifier
	 *
	 * @return array List of issues for this type
	 */
	public function get_issues_by_type ($type) {
		return !empty($this->_by_type[$type]) && is_array($this->_by_type[$type])
			? $this->_by_type[$type]
			: array()
		;
	}

	/**
	 * Gets issues count, for all issues or by type
	 *
	 * @param string $type Optional issue type
	 *                     - if omitted, all issues are counted
	 *
	 * @return int Issues count
	 */
	public function get_issues_count ($type=false) {
		$issues = empty($type)
			? $this->get_all_issues()
			: $this->get_issues_by_type($type)
		;
		return (int)count($issues);
	}

	/**
	 * Gets a specific issue by its key
	 *
	 * @param string $key Issue's unique key
	 *
	 * @return array Issue info hash
	 */
	public function get_issue ($key) {
		return !empty($this->_items[$key]) && is_array($this->_items[$key])
			? $this->_items[$key]
			: array()
		;
	}

	/**
	 * Checks if an issue is to be ignored
	 *
	 * @return bool
	 */
	public function is_ignored_issue ($key) {
		return (bool)in_array($key, $this->get_ignored_issues());
	}


}