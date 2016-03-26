<?php

	/***
	***	@Add "follows you" if the user is following current user
	***/
	add_action('um_after_profile_name_inline', 'um_followers_add_state', 200 );
	function um_followers_add_state( $args ) {
		global $um_followers;

		if ( !is_user_logged_in() || !um_profile_id() )
			return;

		if ( get_current_user_id() == um_profile_id() )
			return;

		if ( $um_followers->api->followed( get_current_user_id(), um_profile_id() ) ) {
			echo '<span class="um-follows-you">'. __('follows you','um-followers') . '</span>';
		}

	}

	/***
	***	@Followers List
	***/
	add_action('um_profile_content_followers_default', 'um_profile_content_followers_default');
	function um_profile_content_followers_default( $args ) {
		echo do_shortcode('[ultimatemember_followers user_id='.um_profile_id().']');
	}

	/***
	***	@Following List
	***/
	add_action('um_profile_content_following_default', 'um_profile_content_following_default');
	function um_profile_content_following_default( $args ) {
		echo do_shortcode('[ultimatemember_following user_id='.um_profile_id().']');
	}

	/***
	***	@customize the nav bar
	***/
	add_action('um_profile_navbar', 'um_followers_add_profile_bar', 4 );
	function um_followers_add_profile_bar( $args ) {
		echo do_shortcode('[ultimatemember_followers_bar user_id='.um_profile_id().']');
	}