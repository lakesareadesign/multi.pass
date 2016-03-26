<?php

	/***
	***	@extend core pages
	***/
	add_filter("um_core_pages", 'um_activity_core_page' );
	function um_activity_core_page( $pages ) {
		$pages['activity'] = __('Activity page','um-activity');
		return $pages;
	}
	
	/***
	***	@extend settings
	***/
	add_filter("redux/options/um_options/sections", 'um_activity_config', 15 );
	function um_activity_config( $sections ){
		global $um_activity;
		
		$fields = array(

				array(
						'id'       => 'activity_posts_num',
						'type'     => 'text',
						'title'    => __( 'Number of wall posts on desktop','um-activity' ),
						'default'  => 10,
				),
				
				array(
						'id'       => 'activity_posts_num_mob',
						'type'     => 'text',
						'title'    => __( 'Number of wall posts on mobile','um-activity' ),
						'default'  => 5,
				),
				
				array(
						'id'       => 'activity_init_comments_count',
						'type'     => 'text',
						'title'    => __( 'Number of initial comments/replies to display per post','um-activity' ),
						'default'  => 2,
				),
				
				array(
						'id'       => 'activity_load_comments_count',
						'type'     => 'text',
						'title'    => __( 'Number of comments/replies to get when user load more','um-activity' ),
						'default'  => 10,
				),
				
				array(
						'id'       	=> 'activity_order_comment',
						'type'     	=> 'select',
						'select2'	=> array( 'allowClear' => 0, 'minimumResultsForSearch' => -1 ),
						'title'    	=> __( 'Comments order','um-activity' ),
						'default'  	=> 'asc',
						'options' 	=> array(
										'desc' 		=> __('Newest first','um-activity'),
										'asc' 				=> __('Oldest first','um-activity'),
						),
						'placeholder'=> __('Select...','um-activity')
				),
				
				array(
						'id'       => 'activity_post_truncate',
						'type'     => 'text',
						'title'    => __( 'How many words appear before wall post is truncated?','um-activity' ),
						'default'  => 25,
				),
				
				array(
						'id'       	=> 'activity_enable_privacy',
						'type'     	=> 'switch',
						'title'   	=> __( 'Allow users to set their activity wall privacy through account page?','um-activity'),
						'default' 	=> 1,
						'on'		=> __('Yes','um-activity'),
						'off'		=> __('No','um-activity'),
				),
				
				array(
						'id'       => 'activity_trending_days',
						'type'     => 'text',
						'title'	   => __('Trending Hashtags Days','um-activity'),
						'desc'     => __( 'Enter number of days here. For example: 0 will calculate trending hashtags over today only, and 7 will calculate trending hashtags over a 7 day period.','um-activity' ),
						'default'  => 7,
				),
				
				array(
						'id'       	=> 'activity_require_login',
						'type'     	=> 'switch',
						'title'   	=> __( 'Require user to login to view activity walls?','um-activity'),
						'default' 	=> 0,
						'on'		=> __('Yes','um-activity'),
						'off'		=> __('No','um-activity'),
				),
				
				array(
						'id'       => 'activity_need_to_login',
						'type'     => 'textarea',
						'title'    => __( 'Text to display If user needs to login to interact in a post','um-reviews' ),
						'default'  => sprintf(__('Please <a href="%s" class="um-link">sign up</a> or <a href="%s" class="um-link">sign in</a> to like or comment on this post.','um-activity'),  add_query_arg( 'redirect_to', '{current_page}', um_get_core_page('register') ), add_query_arg( 'redirect_to', '{current_page}', um_get_core_page('login') ) ),
						'rows'	   => 2,
				),
				
				array(
						'id'       		=> 'activity_highlight_color',
						'type'     		=> 'color',
						'default'		=> um_get_metadefault('active_color'),
						'title'    		=> __( 'Active Color','um-activity' ),
						'validate' 		=> 'color',
						'transparent'	=> false,
				),
				
			);
			
		if ( class_exists('UM_Followers_API') ) {
			$fields[] = array(
						'id'       	=> 'activity_followers_mention',
						'type'     	=> 'switch',
						'title'   	=> __( 'Enable integration with followers to convert user names to user profile links automatically (mention users)?','um-activity'),
						'default' 	=> 1,
						'on'		=> __('Yes','um-activity'),
						'off'		=> __('No','um-activity'),
			);
			$fields[] = array(
						'id'       	=> 'activity_followed_users',
						'type'     	=> 'switch',
						'title'   	=> __( 'Show only followed users activity in the social wall','um-activity'),
						'default' 	=> 0,
						'on'		=> __('Yes','um-activity'),
						'off'		=> __('No','um-activity'),
			);
		}

		foreach( apply_filters('um_activity_global_actions', $um_activity->api->global_actions ) as $k => $v ) {
			if ( $k == 'status' ) continue;
			$fields[] = array(
						'id'       => 'activity-' . $k,
						'type'     	=> 'switch',
						'title'   	=> sprintf(__( 'Enable "%s" in activity','um-activity'), $v ),
						'default' 	=> 1,
						'on'		=> __('Yes','um-activity'),
						'off'		=> __('No','um-activity'),
			);
		}
		
		$sections[] = array(

			'subsection' => true,
			'title'      => __( 'Social Activity','um-reviews'),
			'fields'     => $fields

		);

		return $sections;
	}
	
	/***
	***	@enable image upload
	***/
	add_filter('um_custom_image_handle_wall_img_upload', 'um_custom_image_handle_wall_img_upload');
	function um_custom_image_handle_wall_img_upload( $data ) {
		$data = array(
			'role' => 'wall-upload'
		);
		return $data;
	}
	
	/***
	***	@exclude from comments tab
	***/
	add_filter('um_excluded_comment_types', 'um_activity_excluded_comment_types' );
	function um_activity_excluded_comment_types( $array ) {
		$array[] = 'um-social-activity';
		return $array;
	}