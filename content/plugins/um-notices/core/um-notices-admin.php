<?php

class UM_Notices_Admin {

	function __construct() {

		$this->slug = 'ultimatemember';
		$this->pagehook = 'toplevel_page_ultimatemember';

		add_action('um_extend_admin_menu',  array(&$this, 'um_extend_admin_menu'), 800);
		add_filter('enter_title_here', array(&$this, 'enter_title_here') );

	}

	/***
	***	@custom title
	***/
	function enter_title_here( $title ){
		$screen = get_current_screen();
		if ( 'um_notice' == $screen->post_type )
			$title = __('Enter notice title here','um-notices');
		return $title;
	}
	
	/***
	***	@extends the admin menu
	***/
	function um_extend_admin_menu() {
	
		add_submenu_page( $this->slug, __('Notices','um-notices'), __('Notices','um-notices'), 'manage_options', 'edit.php?post_type=um_notice', '', '' );
		
	}

}