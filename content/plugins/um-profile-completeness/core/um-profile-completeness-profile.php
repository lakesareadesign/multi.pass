<?php

	/***
	***	@Show a notice on profile
	***/
	add_action('um_profile_before_header', 'um_profile_completeness_show_notice' );
	function um_profile_completeness_show_notice( $args ) {
		
		if ( isset( $_GET['notice'] ) && $_GET['notice'] == 'incomplete_access' ) {
			
			echo '<p class="um-notice warning" style="margin: 0 0 12px 0!important">' . __('You need to complete your profile before you can view that page.','um-profile-completeness') . '</p>';
		
		}
		
		if ( isset( $_GET['notice'] ) && $_GET['notice'] == 'incomplete_view' ) {
			
			echo '<p class="um-notice warning" style="margin: 0 0 12px 0!important">' . __('You need to complete your profile before you can view that page.','um-profile-completeness') . '</p>';
		
		}
		
		if ( isset( $_GET['notice'] ) && $_GET['notice'] == 'incomplete_comment' ) {
			
			echo '<p class="um-notice warning" style="margin: 0 0 12px 0!important">' . __('You need to complete your profile before you can leave comments.','um-profile-completeness') . '</p>';
		
		}

		if ( isset( $_GET['notice'] ) && $_GET['notice'] == 'incomplete_forum' ) {
			
			echo '<p class="um-notice warning" style="margin: 0 0 12px 0!important">' . __('You need to complete your profile before you can participate in forums.','um-profile-completeness') . '</p>';
		
		}
		
	}