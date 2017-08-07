<?php
/*
 * 	Admin Help Page - Sidebar
 *
 * 	@author		Kerry Kline
 * 	@copyright	Copyright (c) 2017, Kerry Kline
 * 	@link		http://www.bnecreative.com
 *	@package	BNE Testimonials
 *
*/

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;



?>
<div class="widget" style="margin-top: 60px;">
	<h3 class="widget-title">Information</h3>
	<p>Thank you for using BNE Testimonials!</p>

	<p><strong>Current Version:</strong> <?php echo BNE_TESTIMONIALS_VERSION; ?></p>

	<p><strong>Support:</strong> Available at <a href="https://wordpress.org/support/plugin/bne-testimonials">WordPress.org Forums</a></p>
	
</div><!-- .widget (end) -->


<div class="widget">
	<h3 class="widget-title">Upgrade to Pro Version! <span class="dashicons dashicons-star-filled" style="color:gold;"></span></h3>
	<div class="bne-upsell">
		<a href="https://www.bnecreative.com/products/testimonials-wordpress-pro/" target="_blank" class="upsell-link">
			<img src="<?php echo BNE_TESTIMONIALS_URI; ?>/assets/images/admin/help-pro-banner.jpg" width="100%" />
			<div class="upsell-footer">BNE Testimonials Pro</div>
		</a>
	</div>

	<p>Did you know there is a pro version which includes these additional features:</p>
	<ul>
		<li>Front end submission form</li>
		<li>Masonry grid and thumbnail slider layouts</li>
		<li>5-Star Ratings</li>
		<li>Developer tools and support!</li>
		<li>Additional themes and custom styles</li>
		<li>Rich schema markup for online search</li>
		<li>Lifetime updates and unlimited domain use</li>
		<li>List and Masonry pagination (page 2, page 3, etc)</li>
		<li>API - pull in reviews from Yelp, Google, and Facebook</li>
		<li>Rating Badges - quick snapshot of your ratings</li>
	</ul>
		
	 <a href="https://www.bnecreative.com/products/testimonials-wordpress-pro/" class="button-primary" target="_blank" style="width:100%; text-align:center;">View Details and Demo</a>
</div>