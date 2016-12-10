<?php
/**
 * WooCommerce product search widget override
 */
?>
<form role="search" method="get" class="search-form woocommerce-product-search" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<div>
		<label class="screen-reader-text"><?php echo _x( 'Search for:', 'label' ); ?></label>
		<input type="search" class="search-field" placeholder="<?php echo esc_attr_x( 'Search Products&hellip;', 'placeholder', 'woocommerce' ); ?>" value="<?php echo get_search_query(); ?>" name="s" title="<?php echo esc_attr_x( 'Search for:', 'label', 'woocommerce' ); ?>">
		<div class="upfront-search-submit_group">
			<input type="submit" class="search-submit" value="<?php echo esc_attr_x( 'Search', 'submit button', 'woocommerce' ); ?>" />
			<input type="hidden" name="post_type" value="product" />
		</div>
	</div>
</form>