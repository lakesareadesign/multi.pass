<ul class="um-activity-trending">

	<?php foreach ( (array) $hashtags as $hashtag ) { ?>
	
	<li><a href="<?php echo add_query_arg( 'hashtag', $hashtag->slug, um_get_core_page('activity') ); ?>">#<?php echo $hashtag->name; ?></a></li>
	
	<?php } ?>

</ul>