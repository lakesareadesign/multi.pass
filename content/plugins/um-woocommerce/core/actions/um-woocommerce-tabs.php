<?php

	/***
	***	@product reviews tab
	***/
	add_action('um_profile_content_purchases_default', 'um_profile_content_purchases_default');
	function um_profile_content_purchases_default( $args ) {
		global $ultimatemember;
		
		
		$args = array( 'post_type' => 'product', 'posts_per_page' => -1 );
		$loop = new WP_Query( $args );
		
		if ( $loop->found_posts ) {
		
			require um_woocommerce_path . 'templates/my-purchases.php';
		
		} else {
			
		?>
		
		<div class="um-profile-note"><span><?php echo ( um_profile_id() == get_current_user_id() ) ? __('You did not purchase any product yet.','um-woocommerce') : __('User did not purchase any product yet.','um-woocommerce'); ?></span></div>
		
		<?php
		
		}
		
	}
	
	/***
	***	@product reviews tab
	***/
	add_action('um_profile_content_product-reviews_default', 'um_profile_content_product_reviews_default');
	function um_profile_content_product_reviews_default( $args ) {
		global $ultimatemember;
		
		$args = array ('post_type' => 'product', 'user_id' => um_profile_id() );
		$comments = get_comments( $args );
		if ( $comments ) {
		
			require um_woocommerce_path . 'templates/product-reviews.php';
		
		} else {
			
		?>
		
		<div class="um-profile-note"><span><?php echo ( um_profile_id() == get_current_user_id() ) ? __('You did not review any products yet.','um-woocommerce') : __('User did not review any product yet.','um-woocommerce'); ?></span></div>
		
		<?php
		
		}
		
	}