<?php

/**
 * @author: Hoang Ngo
 */
abstract class WD_Scan_Result_Item_Model extends WD_Model {

	/**
	 * @var
	 */
	protected $id;
	/**
	 * Can be file path, can be plugin/theme slug
	 * @var
	 */
	protected $name;
	/**
	 * addition detail of a result item
	 * @var mixed
	 */
	protected $detail;

	/**
	 * Can ignore this or not
	 * @var bool
	 */
	protected $can_ignore;

	public abstract function get_name();

	public abstract function get_sub();

	public abstract function get_detail();

	public abstract function get_type();

	public function can_delete() {
		return true;
	}

	public function can_ignore() {
		return false;
	}

	public abstract function get_system_type();
}