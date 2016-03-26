<?php

	/***
	***	@add tab for reviews
	***/
	add_filter('um_profile_tabs', 'um_reviews_add_tab', 800 );
	function um_reviews_add_tab( $tabs ) {
		global $um_reviews;
		
		$tabs['reviews'] = array(
			'name' => __('Reviews','um-reviews'),
			'icon' => 'um-faicon-star'
		);
		
		return $tabs;
	}
	
	/***
	***	@add tabs based on user
	***/
	add_filter('um_user_profile_tabs', 'um_reviews_user_add_tab', 1000 );
	function um_reviews_user_add_tab( $tabs ) {
		
		if ( !um_user('can_have_reviews_tab') )
			unset( $tabs['reviews'] );
		
		if ( !is_user_logged_in() && !um_get_option('guests_see_reviews') )
			unset( $tabs['reviews'] );
			
		return $tabs;
	}