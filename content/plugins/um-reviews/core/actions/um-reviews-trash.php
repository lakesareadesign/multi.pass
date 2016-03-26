<?php

	add_action( 'trash_um_review', 'trash_um_review' );
	function trash_um_review( $postid ){
		global $um_reviews;
		if(!did_action('trash_post')){
			$um_reviews->api->undo_review( $postid );
		}
	}
	
	add_action( 'untrash_post', 'untrash_um_review' );
	function untrash_um_review( $postid ){
		global $um_reviews;
		if ( get_post_type( $postid ) != 'um_review' ) return;
		$um_reviews->api->publish_review( $postid );
	} 