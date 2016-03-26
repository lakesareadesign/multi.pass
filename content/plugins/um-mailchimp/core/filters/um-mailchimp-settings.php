<?php

	/***
	***	@extend settings
	***/
	add_filter("redux/options/um_options/sections", 'um_mailchimp_config', 10 );
	function um_mailchimp_config($sections){
		global $um_mailchimp;
		
		$sections[] = array(

			'subsection' => true,
			'title'      => __( 'MailChimp','um-mailchimp'),
			'fields'     => array(

				array(
						'id'       		=> 'mailchimp_api',
						'type'     		=> 'text',
						'title'   		=> __( 'MailChimp API Key','um-mailchimp' ),
						'desc' 	   		=> __('The MailChimp API Key is required and enables you access and integration with your lists.','um-mailchimp'),
				),

				array(
						'id'       		=> 'mailchimp_real_status',
						'type'     		=> 'switch',
						'title'   		=> __( 'Enable Real-time Subscription Status','um-mailchimp' ),
						'default'		=> 0,
						'desc' 	   		=> __('Careful as this option will contact the MailChimp API when you request a status of user subscription to a specific list.','um-mailchimp'),
				),
				
			)

		);

		$um_mailchimp->tab_id = count($sections) - 1;
		
		return $sections;
		
	}
	
	/* Tweak parameters passed in admin email */
	add_filter('um_email_registration_data', 'um_mailchimp_email_registration_data');
	function um_mailchimp_email_registration_data( $data ) {
		if ( isset( $data['um-mailchimp'] ) ) {
			foreach( $data['um-mailchimp'] as $list_id => $v ) {
				$posts = get_posts( array( 'post_type' => 'um_mailchimp', 'meta_key' => '_um_list', 'meta_value' => $list_id ) );
				$data[ __('Mailchimp Subscription','um-mailchimp') ] = $posts[0]->post_title . ' - ' . $list_id;
			}
			unset( $data['um-mailchimp'] );
		}
		return $data;
	}