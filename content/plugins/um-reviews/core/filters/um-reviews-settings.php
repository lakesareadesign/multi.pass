<?php

	/***
	***	@extend settings
	***/
	add_filter("redux/options/um_options/sections", 'um_reviews_config', 11 );
	function um_reviews_config( $sections ){
		global $um_reviews;
		
		$sections[] = array(

			'subsection' => true,
			'title'      => __( 'User Reviews','um-reviews'),
			'fields'     => array(

				array(
						'id'       		=> 'guests_see_reviews',
						'type'     		=> 'switch',
						'title'   		=> __( 'Show Reviews tab for guests','um-reviews' ),
						'default'		=> 1,
				),
				
				array(
						'id'       		=> 'members_show_rating',
						'type'     		=> 'switch',
						'title'   		=> __( 'Show user rating in members directory','um-reviews' ),
						'default'		=> 1,
				),
				
				array(
						'id'       		=> 'can_flag_review',
						'type'     		=> 'select',
						'select2'		=> array( 'allowClear' => 0, 'minimumResultsForSearch' => -1 ),
						'title'    		=> __( 'Who can flag reviews','um-reviews' ),
						'default'  		=> 'everyone',
						'options' 		=> array(
											'everyone' 			=> __('Everyone','um-reviews'),
											'reviewed' 			=> __('Reviewed user only','um-reviews'),
											'loggedin' 			=> __('All Logged-in Users','um-reviews'),
						),
						'placeholder' 	=> __('Select...','um-reviews')
				),
				
				array(
						'id'       => 'review_notice_on',
						'type'     => 'switch',
						'title'    => __( 'New Review Notification','um-reviews' ),
						'default'  => 1,
						'desc' 	   => __('Send a notification to user when he receives a new review','um-reviews'),
				),
				
				array(
						'id'       => 'review_notice_sub',
						'type'     => 'text',
						'title'    => __( 'New Review Notification','um-reviews' ),
						'subtitle' => __( 'Subject Line','um-reviews' ),
						'default'  => 'You\'ve got a new {rating} review!',
						'required' => array( 'review_notice_on', '=', 1 ),
						'desc' 	   => __('This is the subject line of the e-mail','um-reviews'),
				),

				array(
						'id'       => 'review_notice',
						'type'     => 'textarea',
						'title'    => __( 'New Review Notification','um-reviews' ),
						'subtitle' => __( 'Message Body','um-reviews' ),
						'required' => array( 'review_notice_on', '=', 1 ),
						'default'  => 'Hi {display_name},' . "\r\n\r\n" .
												  'You\'ve received a new {rating} review from {reviewer}!' . "\r\n\r\n" .
												  'Here is the review content:'  . "\r\n\r\n" .
												  '{review_content}'  . "\r\n\r\n" .
												  '{reviews_link}' . "\r\n\r\n" .
												  'This is an automated notification from {site_name}. You do not need to reply.',
				),
				
			)

		);

		return $sections;
	}