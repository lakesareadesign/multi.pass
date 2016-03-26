<div class="um-reviews-header">

	<span class="um-reviews-header-span"><?php echo $um_reviews->api->rating_header(); ?></span>
	
	<span class="um-reviews-avg" data-number="5" data-score="<?php echo $um_reviews->api->get_rating(); ?>"></span>
	
</div>

<div class="um-reviews-avg-rating"><?php echo $um_reviews->api->avg_rating(); ?></div>

<div class="um-reviews-details">
	<?php echo $um_reviews->api->get_details(); ?>
	
	<?php if ( $um_reviews->api->get_filter() ) { ?>
	
	<span class="um-reviews-filter"><?php printf(__('(You are viewing only %s star reviews. <a href="%s">View all reviews</a>)','um-reviews'), $um_reviews->api->get_filter(), remove_query_arg('filter') ); ?></span>
	
	<?php } ?>
	
</div>