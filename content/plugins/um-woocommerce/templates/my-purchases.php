<?php

global $post, $product, $ultimatemember;
$i = 0;

while ( $loop->have_posts() ) : $loop->the_post();

if ( !wc_customer_bought_product( um_user('user_email'), um_profile_id(), get_the_ID() ) ) continue;

$i++;

$product = wc_get_product( get_the_ID() );

$total_sales = (int)get_post_meta( get_the_ID(), 'total_sales', true );
$total_sales = number_format( $total_sales );

$stock_state = (int)get_post_meta( get_the_ID(), '_stock_status', true );
if ( $stock_state == 'instock' ) {
	$stock_state = __('Instock','um-woocommerce');
}

$url = $ultimatemember->account->tab_link( 'orders' );
$order_number = 321321;

?>

<div class="um-woo-grid um-split-2">

	<div class="um-woo-grid-item">

		<div class="um-woo-grid-img">
			
			<?php
				
				$product_link   = get_permalink( get_the_ID() );
				
				if ( has_post_thumbnail( get_the_ID() ) ) {

					$image       	= get_the_post_thumbnail( get_the_ID(), 'medium' );

					echo sprintf( __('<a href="%s" class="um-woo-grid-imgc">%s</a>','um-woocommerce'), $product_link, $image );

				} else {

					echo sprintf( __('<img src="%s" alt="%s" class="um-woo-grid-imgc" />','um-woocommerce'), wc_placeholder_img_src(), __( 'Placeholder', 'um-woocommerce' ) );

				}
			?>
			
		</div>
		
		<span class="um-woo-grid-title"><a href="<?php echo $product_link; ?>"><span><?php the_title(); ?></span></a></span>
		<span class="um-woo-grid-price"><?php echo $product->get_price_html(); ?></span>
		<span class="um-woo-grid-meta">
			<span class="um-woo-salescount" title="<?php _e('Total Sales','um-woocommerce'); ?>"><i class="um-faicon-shopping-cart"></i><?php echo $total_sales; ?></span>
			<span class="um-woo-stock_state"><?php echo $stock_state; ?></span>
		</span>

	</div>

</div>

<?php if ($i % 2 == 0 ) { echo '<div class="um-clear"></div>'; } ?>

<?php endwhile; wp_reset_postdata(); ?>

<?php if ( !$i ) { ?>

<div class="um-profile-note"><span><?php echo ( um_profile_id() == get_current_user_id() ) ? __('You did not purchase any product yet.','um-woocommerce') : __('User did not purchase any product yet.','um-woocommerce'); ?></span></div>

<?php } ?>