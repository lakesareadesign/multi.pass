<?php

	/***
	***	@Add possible user tags
	***/
	add_action('um_after_header_meta', 'um_user_tags_display', 30, 2 );
	function um_user_tags_display( $user_id, $args ) {
		global $um_user_tags, $ultimatemember;

		if ( $ultimatemember->fields->editing == 1 )
			return false;
		
		if ( ! um_user('show_user_tags') )
			return false;
		
		if ( ! um_user('user_tags_metakey') )
			return false;
		
		$metakey = um_user('user_tags_metakey');
		
		$value = $um_user_tags->get_tags( $user_id, $metakey );
		
		echo $value;
	}
	
	/***
	***	@Save user tags to profile and update tag count
	***/
	add_action('um_user_pre_updating_profile', 'um_user_tags_sync_user', 39 );
	function um_user_tags_sync_user( $changes ) {
		global $wpdb;

		$filters = get_option('um_user_tags_filters');
		if ( !$filters )
			return;

		foreach( $filters as $term_id => $metakey ) {
			$usermeta = get_user_meta( um_user('ID'), $metakey, true );
			if ( isset( $changes[$metakey] ) ) {
				if ( $usermeta == $changes[$metakey] )
					continue;

				$all_terms = array_merge( $changes[$metakey], (array) $usermeta );
				
				foreach( $all_terms as $value ) {
					$term = get_term_by( 'slug', $value, 'um_user_tag' );
					if ( in_array( $value, $changes[$metakey] ) && !in_array( $value, $usermeta ) ) {
						$wpdb->update( $wpdb->term_taxonomy, array( 'count' => $term->count + 1 ), array( 'term_taxonomy_id' => $term->term_id ) );
					} else if ( !in_array( $value, $changes[$metakey] ) && in_array( $value, $usermeta ) ) {
						$count = $term->count - 1;
						if ( $count < 0 )
							$count = 0;
						$wpdb->update( $wpdb->term_taxonomy, array( 'count' => $count ), array( 'term_taxonomy_id' => $term->term_id ) );
					}
				}

			} else {
				if ( $usermeta ) {
					foreach( $usermeta as $value ) {
						$term = get_term_by( 'slug', $value, 'um_user_tag' );
						$count = $term->count - 1;
						if ( $count < 0 )
							$count = 0;
						$wpdb->update( $wpdb->term_taxonomy, array( 'count' => $count ), array( 'term_taxonomy_id' => $term->term_id ) );
					}
				}
				delete_user_meta( um_user('ID'), $metakey );
			}
		}
	}