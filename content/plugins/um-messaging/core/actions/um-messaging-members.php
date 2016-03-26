<?php

	/***
	***	@add a message button to directory
	***/
	add_action('um_members_just_after_name', 'um_messaging_button_in_directory', 110, 2 );
	function um_messaging_button_in_directory( $user_id, $args ) {
		if ( isset( $args['show_pm_button'] ) && !$args['show_pm_button'] ) return;
		if ( $user_id == get_current_user_id() ) {
			$messages_link = add_query_arg( 'profiletab', 'messages', um_user_profile_url() );
			echo '<a href="' . $messages_link . '" class="um-message-abtn um-button"><span>'. __('My messages','um-messaging'). '</span></a>';
		} else {	
			echo do_shortcode('[ultimatemember_message_button user_id='.$user_id.']');
		}
	}