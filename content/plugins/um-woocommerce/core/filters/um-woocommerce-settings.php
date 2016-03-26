<?php

	/***
	***	@extend settings
	***/
	add_filter("redux/options/um_options/sections", 'um_woocommerce_config', 9.520 );
	function um_woocommerce_config($sections){
		global $ultimatemember, $um_woocommerce;

		$sections[] = array(

			'subsection' => true,
			'title'      => __( 'WooCommerce','um-woocommerce'),
			'fields'     => array(

				array(
						'id'       		=> 'woo_oncomplete_role',
						'type'     		=> 'select',
						'select2'		=> array( 'allowClear' => 0, 'minimumResultsForSearch' => -1 ),
						'title'    		=> __( 'Assign this role to users when payment is completed','um-woocommerce' ),
						'desc' 	   		=> __( 'Automatically set the user this role when a payment is completed.','um-woocommerce' ),
						'default'  		=> '',
						'options' 		=> array('' => __('None','um-woocommerce') ) + $ultimatemember->query->get_roles( ),
						'placeholder' 	=> __('Community role...','um-woocommerce'),
				),

				array(
						'id'       		=> 'woo_oncomplete_except_roles',
						'type'     		=> 'select',
						'select2'		=> array( 'allowClear' => 0, 'minimumResultsForSearch' => -1 ),
						'title'    		=> __( 'Do not update these roles when payment is completed','um-woocommerce' ),
						'desc' 	   		=> __( 'Only applicable if you assigned a role when payment is completed.','um-woocommerce' ),
						'default'  		=> '',
						'options' 		=> $ultimatemember->query->get_roles( ),
						'placeholder' 	=> __('Community role(s)..','um-woocommerce'),
						'multi'         => true
				),

				array(
						'id'       		=> 'woo_hide_purchases_tab',
						'type'     		=> 'switch',
						'default'		=> 0,
						'title'   		=> __( 'Hide purchases tab from guests','um-woocommerce' ),
						'desc' 	   		=> __('Enable this option If you do not want to show the purchases tab for guests.','um-woocommerce'),
						'on'			=> __('Yes','um-woocommerce'),
						'off'			=> __('No','um-woocommerce'),
				),

				array(
						'id'       		=> 'woo_hide_reviews_tab',
						'type'     		=> 'switch',
						'default'		=> 0,
						'title'   		=> __( 'Hide product reviews tab from guests','um-woocommerce' ),
						'desc' 	   		=> __('Enable this option If you do not want to show the reviews tab for guests.','um-woocommerce'),
						'on'			=> __('Yes','um-woocommerce'),
						'off'			=> __('No','um-woocommerce'),
				),

			)

		);

		return $sections;

	}
