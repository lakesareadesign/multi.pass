<?php

	/***
	***	@global profile redirection
	***/
	add_action('template_redirect', 'um_bbpress_profile_redirect');
	function um_bbpress_profile_redirect(){
		$bbp_user_id = get_query_var( 'bbp_user_id' );
		if ( $bbp_user_id > 0 && bbp_is_single_user() ) {
			um_fetch_user($bbp_user_id);
			$redirect = um_user_profile_url();
			exit( wp_redirect( $redirect ) );
		}
	}