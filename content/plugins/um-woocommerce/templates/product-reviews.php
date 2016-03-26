<?php $i = 0; foreach( $comments as $comment ) { $i++;
	
	$rating = intval( get_comment_meta( $comment->comment_ID, 'rating', true ) );
	
	?>

<div class="um-woo-grid um-split-2">

	<div class="um-woo-grid-item">

		<div class="um-woo-grid-img">
			
			<?php
				
				$post = get_post( $comment->comment_post_ID );
				setup_postdata( $post );
				
				$product = wc_get_product( $comment->comment_post_ID );
				$product_link   = get_permalink( $comment->comment_post_ID );
				
				if ( has_post_thumbnail( $comment->comment_post_ID ) ) {

					$image       	= get_the_post_thumbnail( $comment->comment_post_ID, 'medium' );

					echo sprintf( __('<a href="%s" class="um-woo-grid-imgc">%s</a>','um-woocommerce'), $product_link, $image );

				} else {

					echo sprintf( __('<img src="%s" alt="%s" class="um-woo-grid-imgc" />','um-woocommerce'), wc_placeholder_img_src(), __( 'Placeholder', 'um-woocommerce' ) );

				}
			?>
			
		</div>
		
		<span class="um-woo-grid-title"><a href="<?php echo $product_link; ?>"><span><?php echo get_the_title( $comment->comment_post_ID ); ?></span></a></span>
		<span class="um-woo-grid-price"><?php echo $product->get_price_html(); ?></span>
		<span class="um-woo-grid-avg" data-number="5" data-score="<?php echo $rating; ?>"></span>
		<span class="um-woo-grid-content"><?php echo '&ldquo;' . $comment->comment_content . '&rdquo;'; ?></span>

	</div>

</div>

<?php if ($i % 2 == 0 ) { echo '<div class="um-clear"></div>'; } ?>

<?php } wp_reset_postdata(); ?>

<?php if ( !$i ) { ?>

<div class="um-profile-note"><span><?php echo ( um_profile_id() == get_current_user_id() ) ? __('You did not review any products yet.','um-woocommerce') : __('User did not review any product yet.','um-woocommerce'); ?></span></div>

<?php } ?>