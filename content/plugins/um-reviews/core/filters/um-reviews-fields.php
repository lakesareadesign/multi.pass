<?php

	/***
	***	@extend core fields
	***/
	add_filter("um_predefined_fields_hook", 'um_reviews_add_field', 20 );
	function um_reviews_add_field($fields){

		$fields['user_rating'] = array(
				'title' => __('User Rating','um-reviews'),
				'metakey' => 'user_rating',
				'type' => 'text',
				'label' => __('User Rating','um-reviews'),
				'required' => 0,
				'public' => 1,
				'editable' => 0,
				'icon' => 'um-faicon-star',
				'edit_forbidden' => 1,
				'show_anyway' => true,
				'custom' => true,
		);

		return $fields;
		
	}
	
	/***
	***	@show rating
	***/
	add_filter('um_profile_field_filter_hook__user_rating', 'um_reviews_show_rating', 99, 2);
	function um_reviews_show_rating( $value, $data ) {
		global $um_reviews;
		return '<span class="um-reviews-avg" data-number="5" data-score="'. $um_reviews->api->get_rating() . '"></span>';
	}