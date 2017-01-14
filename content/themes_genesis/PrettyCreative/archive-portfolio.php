<?php
// Force full width content
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );
add_filter( 'body_class', 'prettycreative_body_class' );
/**
 * Adds a css class to the body element
 *
 * @param  array $classes the current body classes
 * @return array $classes modified classes
 */
function prettycreative_body_class( $classes ) {
	$classes[] = 'archive-portfolio';
	return $classes;
}

//* Add the portfolio blurb section
add_action( 'genesis_before_content', 'prettycreative_portfolioblurb_before_content' );
function prettycreative_portfolioblurb_before_content() {

	genesis_widget_area( 'portfolioblurb', array(
	'before' => '<div class="portfolioblurb">',
	'after' => '</div>',
	) );

}

/**
 * Display as Columns
 *
 */
function be_portfolio_post_class( $classes ) {
	if ( is_main_query() ) { // conditional to ensure that column classes do not apply to Featured widgets
		$columns = 3; // Set the number of columns here
		$column_classes = array( '', '', 'one-half', 'one-third', 'one-fourth', 'one-fifth', 'one-sixth' );
		$classes[] = $column_classes[$columns];
		global $wp_query;
		if( 0 == $wp_query->current_post || 0 == $wp_query->current_post % $columns )
			$classes[] = 'first';
	}
	return $classes;
}
add_filter( 'post_class', 'be_portfolio_post_class' );
// Remove the entry title (requires HTML5 theme support)
remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
// Remove post info
remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
// Remove entry header markup
remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_open', 5 );
remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_close', 15 );
// Remove entry meta from entry footer incl. markup
remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_open', 5 );
remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_close', 15 );
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );
// Remove the post image (requires HTML5 theme support)
remove_action( 'genesis_entry_content', 'genesis_do_post_image', 8 );
// Display Featured image in the entry content
add_action( 'genesis_entry_content', 'prettycreative_show_featured_image' );
function prettycreative_show_featured_image() {
	if ( $image = genesis_get_image( 'format=url&size=portfolio' ) ) {
	printf( '<div class="portfolio-image"><a href="%s" rel="bookmark"><img src="%s" alt="%s" /></a></div>', get_permalink(), $image, the_title_attribute( 'echo=0' ) );
	}	
}
// Remove the post content
remove_action( 'genesis_entry_content', 'genesis_do_post_content' );
genesis();