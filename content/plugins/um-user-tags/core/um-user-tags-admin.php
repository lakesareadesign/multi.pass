<?php

class UM_User_Tags_Admin {

	function __construct() {
	
		$this->slug = 'ultimatemember';
		$this->pagehook = 'toplevel_page_ultimatemember';
		
		add_action('um_extend_admin_menu',  array(&$this, 'um_extend_admin_menu'), 5);
		
	}

	/***
	***	@
	***/
	function um_extend_admin_menu() {

		add_submenu_page( $this->slug, __('User Tags', 'um-user-tags'), __('User Tags', 'um-user-tags'), 'manage_options', 'edit-tags.php?taxonomy=um_user_tag', '', '' );
		
	}

}