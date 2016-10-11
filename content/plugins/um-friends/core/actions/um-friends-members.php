<?php

	/***
	***	@Add stats to member directory
	***/
	add_action('um_members_just_after_name', 'um_friends_friend_button_in_directory', 99, 2 );
	function um_friends_friend_button_in_directory( $user_id, $args ) {
		global $um_friends, $ultimatemember;
		
		$can_view = true;

		if ( !is_user_logged_in() || get_current_user_id() != $user_id ) {
			$is_private_case = $ultimatemember->user->is_private_case( $user_id, __('Friends only','um-friends') );
			if ( $is_private_case ) { // only friends can view my profile
				$can_view = false;
			}

		}

		?>
		
		<?php if ( um_get_option('friends_show_stats') && $can_view ) { ?>
		<div class="um-members-friend-stats">
			<div><?php echo $um_friends->api->count_friends( $user_id ); ?><?php _e('friends','um-friends'); ?></div>
		</div>
		<?php } ?>
		
		<?php if ( um_get_option('friends_show_button') ) { 
				
				$btn = $um_friends->api->friend_button( $user_id, get_current_user_id() );
				
				if ( !$btn ) {
					$btn ='<a href="' . um_edit_profile_url() . '" class="um-friend-edit um-button um-alt">' . __('Edit profile','um-friends') . '</a>';
				}
				
				echo '<div class="um-members-friend-btn">' . $btn . '</div>';
				
			}
		
	}