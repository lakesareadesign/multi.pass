<?php

	/***
	***	@adding default order on directory
	***/
	add_filter('um_modify_sortby_parameter', 'um_reviews_sortby_top_rated', 100, 2);
	function um_reviews_sortby_top_rated( $query_args, $sortby ) {
		if ( $sortby != 'top_rated' ) return $query_args;

		unset($query_args['orderby']);
		unset($query_args['order']);
		
		$query_args['meta_key'] = '_reviews_avg';
		$query_args['orderby'] = 'meta_value';
		$query_args['order'] = 'DESC';

		return $query_args;
	}
	
	/***
	***	@filter by user rating on frontend
	***/
	add_filter('um_prepare_user_query_args', 'um_reviews_filter_by_rating', 200, 2);
	function um_reviews_filter_by_rating( $query_args, $args ) {
		
		if ( isset( $query_args['meta_query'] ) && is_array( $query_args['meta_query']  ) ) {
			
			foreach( $query_args['meta_query'] as $k => $v ) {
				
				if ( isset( $v['key'] ) && $v['key'] == 'filter_rating' ) {
					
					unset( $query_args['meta_query'][$k] );
					
					$val = $_GET['filter_rating'];
					$search = array( $val, $val + 0.95 );

					$query_args['meta_query'][] = array(
						'key' => '_reviews_avg',
						'value' => $search,
						'compare' => 'BETWEEN',
						'type' => 'DECIMAL'
					);
					
				}
				
			}
			
		}
		
		return $query_args;
	}
		
	/***
	***	@custom search filter
	***/
	add_filter('um_custom_search_field_filter_rating', 'um_custom_search_field_filter_rating');
	function um_custom_search_field_filter_rating( $attrs ) {
		$attrs['label'] = __('User Rating','um-reviews');
		$attrs['options'] = array(
			5 => __('5 Stars','um-reviews'),
			4 => __('4 Stars','um-reviews'),
			3 => __('3 Stars','um-reviews'),
			2 => __('2 Stars','um-reviews'),
			1 => __('1 Star','um-reviews'),
			0 => __('Any rating','um-reviews')
		);
		$attrs['custom'] = true;
		return $attrs;
	}
	
	/***
	***	@extend search fields
	***/
	add_filter('um_admin_custom_search_filters', 'um_admin_custom_search_filter_rating');
	function um_admin_custom_search_filter_rating( $fields ) {
		
		$fields['filter_rating'] = array(
			'title' => __('Filter by user rating','um-reviews')
		);
		
		return $fields;
	}