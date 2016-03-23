<?php
/**
 * Installs the database, if it's not already present.
 */
class Bau_Installer {

	/**
	 * @public
	 * @static
	 */
	static function check () {
		$is_installed = get_site_option('bau', false);
		if ( ! $is_installed )
			Bau_Installer::install();
	}

	/**
	 * @private
	 * @static
	 */
	function install () {
		$me = new Bau_Installer;
		$me->create_default_options();
	}

	/**
	 * @private
	 */
	function create_default_options () {
		update_site_option('bau', array(
			'show_add_new_users' => 'manage_options',
			'show_add_existing_users' => 'manage_options',
			'show_add_blogs' => 'manage_options',
		));
	}
}