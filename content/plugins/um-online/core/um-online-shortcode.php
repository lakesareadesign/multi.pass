<?php

class UM_Online_Shortcode {

	function __construct() {
	
		add_shortcode('ultimatemember_online', array(&$this, 'ultimatemember_online'), 1);

	}
	
	function setup( &$user ) {
		
		$ID = $user;
		$user = array();
		
		$user['ID'] = $ID;
		
		um_fetch_user( $ID );
		
		$user['url'] = um_user_profile_url();
		$user['name'] = um_user('display_name');
		$user['role'] = get_user_meta( $ID, 'role', true );

		return $user;
	}

	/***
	***	@Shortcode
	***/
	function ultimatemember_online( $args = array() ) {
		global $ultimatemember, $um_online;

		$defaults = array(
			'max' => 11,
			'role' => 'all'
		);
		$args = wp_parse_args( $args, $defaults );
		extract( $args );

		ob_start();
		
		$template = null;
		$online = $um_online->get_users();
		
		if ( $online ) {
			$template = um_online_path . 'templates/online.php';
		} else {
			$template = um_online_path . 'templates/nobody.php';
		}
		
		include $template;

		$output = ob_get_contents();
		ob_end_clean();
		return $output;
	}

}