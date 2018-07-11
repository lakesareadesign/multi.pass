<?php

interface  Opt_In_Provider_Interface {

	/**
	 * Subscribes to the provider's list
	 *
	 * @param $data array array("email" =>"", "f_name" => "", "l_name" => "" )
	 * @return mixed
	 */
	public function subscribe( Hustle_Module_Model $optin, array $data );
	public function get_account_options( $optin_id );
	public function get_options();
	public function is_authorized();

	/**
	 * @return Opt_In_Provider_Interface|Opt_In_Provider_Abstract class
	 */
	public static function instance();
}