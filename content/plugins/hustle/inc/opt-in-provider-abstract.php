<?php


abstract class Opt_In_Provider_Abstract{

	const LISTS = "lists";

	/**
	 * Sets argument to the provider class
	 *
	 * @param $field
	 * @param $value
	 */
	public function set_arg( $field, $value ){
		$this->{$field} = $value;
	}


	/**
	 * Updates provider option with the new value
	 *
	 * @uses update_site_option
	 * @param $option_key
	 * @param $option_value
	 * @return bool
	 */
	public function update_option($option_key, $option_value){
		return update_site_option( $this->id . "_" . $option_key, $option_value);
	}


	/**
	 * Retrieves provider option from db
	 *
	 * @uses get_site_option
	 * @param $option_key
	 * @param $default
	 * @return mixed
	 */
	public function get_option($option_key, $default){
		return get_site_option( $this->id . "_" . $option_key, $default );
	}
}