<?php

	/***
	***	@Add stats to member directory
	***/
	add_action('um_members_just_after_name', 'um_followers_follow_button_in_directory', 99, 2 );
	function um_followers_follow_button_in_directory( $user_id, $args ) {
		global $um_followers;
		
		?>
		
		<?php if ( um_get_option('followers_show_stats') ) { ?>
		<div class="um-members-follow-stats">
			<div><?php echo $um_followers->api->count_followers( $user_id ); ?><?php _e('followers','um-followers'); ?></div>
			<div><?php echo $um_followers->api->count_following( $user_id ); ?><?php _e('following','um-followers'); ?></div>
		</div>
		<?php } ?>
		
		<?php if ( um_get_option('followers_show_button') ) { 
				
				$btn = $um_followers->api->follow_button( $user_id, get_current_user_id() );
				
				if ( !$btn ) {
					$btn ='<a href="' . um_edit_profile_url() . '" class="um-follow-edit um-button um-alt">' . __('Edit profile','um-followers') . '</a>';
				}
				
				echo '<div class="um-members-follow-btn">' . $btn . '</div>';
				
			}
		
	}