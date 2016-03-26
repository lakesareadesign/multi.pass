<?php
	
	/***
	***	@filter for user menu links
	***/
	add_filter('um_profile_edit_menu_items', 'um_reviews_user_menu', 100, 2);
	function um_reviews_user_menu( $items, $user_id ) {
		global $um_reviews;
		if ( um_current_user_can('edit', $user_id ) ) {
			
			$block_reviews_link = add_query_arg( 'um_action', 'um_block_add_review' );
			$block_reviews_link = add_query_arg( 'uid', $user_id, $block_reviews_link );
			
			$unblock_reviews_link = add_query_arg( 'um_action', 'um_unblock_add_review' );
			$unblock_reviews_link = add_query_arg( 'uid', $user_id, $unblock_reviews_link );
			
			if ( !$um_reviews->api->is_blocked( $user_id ) ) {
				$items['reviews_block'] = '<a href="' . $block_reviews_link . '" class="real_url">'.__('Block reviews','um-reviews').'</a>';
			} else {
				$items['reviews_block'] = '<a href="' . $unblock_reviews_link . '" class="real_url">'.__('Unblock reviews','um-reviews').'</a>';
			}
			
		}
		
		return $items;
		
	}
	
	/***
	***	@filter for user permissions
	***/
	add_filter('um_user_permissions_filter', 'um_reviews_user_permissions_filter', 10, 4);
	function um_reviews_user_permissions_filter( $meta, $user_id ){
		
		if ( !isset( $meta['can_have_reviews_tab'] ) ) {
			$meta['can_have_reviews_tab'] = 1;
		}
		
		if ( !isset( $meta['can_review'] ) ) {
			$meta['can_review'] = 1;
		}
		
		if ( !isset( $meta['can_publish_review'] ) ) {
			$meta['can_publish_review'] = 1;
		}
		
		if ( !isset( $meta['can_remove_review'] ) ) {
			if ( $meta['can_edit_everyone'] == 1 ) {
				$meta['can_remove_review'] = 1;
			} else {
				$meta['can_remove_review'] = 0;
			}
		}
		
		if ( !isset( $meta['can_remove_own_review'] ) ) {
			$meta['can_remove_own_review'] = 1;
		}
		
		return $meta;

	}