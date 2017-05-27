<?php

if ( $settings->sale_flash ) {
	echo FLPageDataWooCommerce::get_sale_flash();
}

echo FLPageDataWooCommerce::get_product_images();
