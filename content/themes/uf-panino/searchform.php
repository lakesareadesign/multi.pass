
<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<div>
		<label class="screen-reader-text">Search for:</label>
		<input type="search" class="search-field" placeholder="Search…" value="<?php echo get_search_query(); ?>" name="s" title="Search for:">
		<div class="upfront-search-submit_group">
			<input type="submit" class="search-submit" value="Search">
		</div>
	</div>
</form>