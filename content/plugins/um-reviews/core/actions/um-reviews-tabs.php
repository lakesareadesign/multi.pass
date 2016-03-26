<?php

	/***
	***	@default reviews tab
	***/
	add_action('um_profile_content_reviews_default', 'um_profile_content_reviews_default');
	function um_profile_content_reviews_default( $args ) {
		
		global $ultimatemember, $um_reviews;
		
		if ( file_exists( get_stylesheet_directory() . '/ultimate-member/templates/review-overview.php' ) ) {
			include_once get_stylesheet_directory() . '/ultimate-member/templates/review-overview.php';
		} else {
			include_once um_reviews_path . 'templates/review-overview.php';
		}
		
		if ( file_exists( get_stylesheet_directory() . '/ultimate-member/templates/review-add.php' ) ) {
			include_once get_stylesheet_directory() . '/ultimate-member/templates/review-add.php';
		} else {
			include_once um_reviews_path . 'templates/review-add.php';
		}
		
		if ( file_exists( get_stylesheet_directory() . '/ultimate-member/templates/review-edit.php' ) ) {
			include_once get_stylesheet_directory() . '/ultimate-member/templates/review-edit.php';
		} else {
			include_once um_reviews_path . 'templates/review-edit.php';
		}
		
		$um_reviews->api->set_filter();
		
		$reviews = $um_reviews->api->get_reviews( um_profile_id() );
		if ( $reviews && $reviews != -1 ) {
			
			if ( file_exists( get_stylesheet_directory() . '/ultimate-member/templates/review-list.php' ) ) {
				include_once get_stylesheet_directory() . '/ultimate-member/templates/review-list.php';
			} else {
				include_once um_reviews_path . 'templates/review-list.php';
			}
		
		} else {
			
			if ( $reviews == -1 ) {
				if ( file_exists( get_stylesheet_directory() . '/ultimate-member/templates/review-my.php' ) ) {
					include_once get_stylesheet_directory() . '/ultimate-member/templates/review-my.php';
				} else {
					include_once um_reviews_path . 'templates/review-my.php';
				}
			} else {
				if ( file_exists( get_stylesheet_directory() . '/ultimate-member/templates/review-none.php' ) ) {
					include_once get_stylesheet_directory() . '/ultimate-member/templates/review-none.php';
				} else {
					include_once um_reviews_path . 'templates/review-none.php';
				}
			}
			
		}
		
	}