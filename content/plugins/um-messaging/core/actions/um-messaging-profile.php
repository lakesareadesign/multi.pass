<?php
	
	/***
	***	@customize the nav bar
	***/
	add_action('um_profile_navbar', 'um_messaging_add_profile_bar', 4 );
	function um_messaging_add_profile_bar( $args ) {
		if ( !defined('um_followers_version') ) {
			$user_id = um_profile_id();
			
			if ( !is_user_logged_in() || get_current_user_id() != um_profile_id() ) { ?>
			
			<div class="um-followers-bar">

				<div class="um-followers-btn">
					<?php do_action('um_after_follow_button_profile', $user_id ); ?>
				</div><div class="um-clear"></div>
				
			</div>
		
			<?php
			}
		}
	}
	
	/***
	***	@Show message button in profile
	***/
	add_action('um_after_follow_button_profile', 'um_messaging_add_button_to_profile');
	function um_messaging_add_button_to_profile( $user_id ) {
		global $ultimatemember, $um_messaging;
		echo do_shortcode('[ultimatemember_message_button user_id='.$user_id.']');
	}