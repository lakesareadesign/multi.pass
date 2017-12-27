<?php

class WDS_Model_IO {

	const OPTIONS = 'options';
	const IGNORES = 'ignores';
	const EXTRA_URLS = 'extra_urls';
	const POSTMETA = 'postmeta';
	const TAXMETA = 'taxmeta';
	const REDIRECTS = 'redirects';
	const REDIRECT_TYPES = 'redirect_types';

	private $_options = array();
	private $_ignores = array();
	private $_extra_urls = array();
	private $_postmeta = array();
	private $_taxmeta = array();
	private $_redirects = array();
	private $_redirect_types = array();

	/**
	 * Gets loaded options
	 *
	 * @param string $what Which part to get
	 *
	 * @return array
	 */
	public function get ($what) {
		$ret = array();
		if (!in_array($what, $this->get_sections())) return $ret;
		$prop = "_{$what}";

		$ret = $this->$prop;
		return (array)$ret;
	}

	/**
	 * Sets the property value
	 *
	 * @param string $what IO section to set
	 * @param array $value Value to set
	 *
	 * @return bool Status
	 */
	public function set ($what, $value) {
		if (!in_array($what, $this->get_sections())) return false;
		$prop = "_{$what}";
		return !!$this->$prop = $value;
	}

	/**
	 * Returns a list of known sections
	 *
	 * @return array List of IO sections
	 */
	public function get_sections () {
		return array(
			self::OPTIONS,
			self::IGNORES,
			self::EXTRA_URLS,
			self::POSTMETA,
			self::TAXMETA,
			self::REDIRECTS,
			self::REDIRECT_TYPES,
		);
	}

	/**
	 * Gets all loaded parameters
	 *
	 * @return array Everything
	 */
	public function get_all () {
		$ret = array();
		foreach ($this->get_sections() as $sect) {
			$ret[$sect] = $this->get($sect);
		}
		return $ret;
	}

	/**
	 * Encodes all loaded parameters into a JSON string
	 *
	 * @return string JSON
	 */
	public function get_json () {
		return wp_json_encode($this->get_all());
	}

}