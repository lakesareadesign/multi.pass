<?php

	/***
	***	@Change how multiselect keys are treated
	***/
	add_filter('um_multiselect_option_value', 'um_user_tags_multiselect_options', 10, 2 );
	function um_user_tags_multiselect_options( $value, $field_type ) {
		if ( $field_type == 'user_tags' )
			return 1;
		return 0;
	}
	
	/***
	***	@Save our user tags filters
	***/
	add_filter('um_admin_pre_save_field_to_form', 'um_user_tags_assign_new_tags_field');
	function um_user_tags_assign_new_tags_field( $args ) {

		if ( $args['type'] == 'user_tags' ) {
			
			$store = get_option('um_user_tags_filters');
			
			if ( !$store ) {
				
				$store[ $args['tag_source'] ] = $args['metakey'];
				update_option('um_user_tags_filters', $store );
			
			} else {
				
				$store[ $args['tag_source'] ] = $args['metakey'];
				update_option('um_user_tags_filters', $store );
			
			}
		}
		
		return $args;
	}

	/***
	***	@Modify query for filtering
	***/
	add_filter('um_query_args_filter', 'um_user_tags_filter' );
	function um_user_tags_filter( $query_args ) {
		global $ultimatemember, $um_user_tags;
		
		$tags = get_option('um_user_tags_filters');

		if ( !$tags )
			return $query_args;
		
		$tags = array_values( $tags );
		$tags = array_unique( $tags );
		
		$i = 0;
		
		foreach( $tags as $metakey ) {
			if ( isset( $_REQUEST[$metakey] ) &&  sanitize_key( $_REQUEST[$metakey] ) ) {
				$query_args['meta_query'][] = array(
					'key' => $metakey,
					'value' => sanitize_key( $_REQUEST[$metakey] ),
					'compare' => 'like',
				);
				$i++;
				$um_user_tags->filters[ $metakey ] = sanitize_key( $_REQUEST[$metakey] );
			}
		}
		
		if ( $i > 0 ) {
			$ultimatemember->is_filtering = 1;
		}
		
		return $query_args;
	}
	
	/***
	***	@outputs user tags
	***/
	add_filter('um_profile_field_filter_hook__user_tags', 'um_profile_field_filter_hook__user_tags', 99, 2);
	function um_profile_field_filter_hook__user_tags( $value, $data ) {
		global $um_user_tags;
		
		$metakey = $data['metakey'];

		$value = $um_user_tags->get_tags( um_user('ID'), $metakey );
		
		return $value;
	}
	
	/***
	***	@Dynamically change field type
	***/
	add_filter('um_hook_for_field_user_tags','um_hook_for_field_user_tags');
	function um_hook_for_field_user_tags( $type ) {
		return 'multiselect';
	}
	
	/***
	***	@Get custom user tags
	***/
	add_filter('um_multiselect_options_user_tags', 'um_multiselect_options_user_tags', 100, 2 );
	function um_multiselect_options_user_tags( $options, $data ) {
		
		$tag_source = $data['tag_source'];
		
		$tags = get_terms( 'um_user_tag', array(
			'hide_empty' => 0,
			'child_of' => $tag_source
		) );
		
		if ( !$tags )
			return array('');
		
		$options = '';
		
		foreach( $tags as $term ) {
			$id = $term->slug;
			$options[ $id ] = $term->name;
		}

		return $options;
	}
	
	/***
	***	@extend core fields
	***/
	add_filter("um_core_fields_hook", 'um_user_tags_add_field', 10 );
	function um_user_tags_add_field($fields){
		
		$fields['user_tags'] = array(
				'name' => __('User Tags','um-user-tags'),
				'col1' => array('_title','_metakey','_visibility'),
				'col2' => array('_label','_max_selections', '_tag_source'),
				'col3' => array('_required','_editable','_icon'),
				'validate' => array(
					'_title' => array(
						'mode' => 'required',
						'error' => __('You must provide a title','um-user-tags')
					),
					'_metakey' => array(
						'mode' => 'unique',
					),
				)
			);
		
		return $fields;
		
	}
	
	/***
	***	@do not require a metakey
	***/
	add_filter('um_fields_without_metakey', 'um_user_tags_requires_no_metakey');
	function um_user_tags_requires_no_metakey( $array ) {
		$array[] = 'user_tags';
		return $array;
	}