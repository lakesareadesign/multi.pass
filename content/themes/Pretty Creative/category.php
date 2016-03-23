<?php
remove_action( 'genesis_before_loop', 'genesis_do_taxonomy_title_description', 15 );
add_action( 'genesis_before_loop', 'prettycreative_do_taxonomy_title_description', 15 );
/**
 * Add custom headline and / or description to category / tag / taxonomy archive pages.
 *
 * If the page is not a category, tag or taxonomy term archive, or we're not on the first page, or there's no term, or
 * no term meta set, then nothing extra is displayed.
 *
 * If there's a title to display, it is marked up as a level 1 heading.
 *
 * If there's a description to display, it runs through `wpautop()` before being added to a div.
 *
 * @since 1.3.0
 *
 * @global WP_Query $wp_query Query object.
 *
 * @return null Return early if not the correct archive page, not page one, or no term meta is set.
 */
function prettycreative_do_taxonomy_title_description() {
	global $wp_query;
	if ( get_query_var( 'paged' ) >= 2 ) {
		return;
	}
	$term = $wp_query->get_queried_object();
	if ( ! $term || ! isset( $term->meta ) ) {
		return;
	}
	$headline = $intro_text = '';
	if ( $term->meta['headline'] ) {
		$headline = sprintf( '<h1 class="archive-title">%s</h1>', strip_tags( $term->meta['headline'] ) );
	}
	if ( $term->meta['intro_text'] ) {
		$intro_text = apply_filters( 'genesis_term_intro_text_output', $term->meta['intro_text'] );
	}
	// if ( $headline || $intro_text )
	// 	printf( '<div class="archive-description taxonomy-description clearfix"><div class="alignleft">%s</div><div class="alignright">Dropdown</div></div>', $headline . $intro_text );
	?>

	<div class="archive-description taxonomy-description clearfix">
		<div class="alignleft"><?php echo $headline; echo $intro_text; ?></div>
		<div class="alignright">
			<form id="category-select" class="category-select" action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get">

				<?php
				$args = array(
					'show_option_none' => __( 'Select Category' ),
					// 'show_count'       => 1, // Show the number of Posts
					'orderby'          => 'name', // ID is the default
					'echo'             => 0, // Send output to browser (1/True) or return output to PHP (0/False)
					'child_of'         => $term->term_id, // Display all categories that are descendants (i.e. children & grandchildren) of the category identified by its ID
					'hierarchical'     => 1, // Show child categories indented
					'hide_if_empty'    => 1, // enable if the dropdown should not appear when there are no sub categories
				);
				?>

				<?php $select  = wp_dropdown_categories( $args ); ?>
				<?php $replace = "<select$1 onchange='return this.form.submit()'>"; ?>
				<?php $select  = preg_replace( '#<select([^>]*)>#', $replace, $select ); ?>

				<?php echo $select; ?>

				<noscript>
					<input type="submit" value="View" />
				</noscript>

			</form>
		</div>
	</div>

	<?php
}

add_filter( 'body_class', 'prettycreative_body_class' );
/**
 * Adds a css class to the body element
 *
 * @param  array $classes the current body classes
 * @return array $classes modified classes
 */
function prettycreative_body_class( $classes ) {
	$classes[] = 'grid-archive';
	return $classes;
}
/**
 * Display as Columns
 *
 */
function be_portfolio_post_class( $classes ) {
	if ( is_main_query() ) { // conditional to ensure that column classes do not apply to Featured widgets
		$columns = 4; // Set the number of columns here
		$column_classes = array( '', '', 'one-half', 'one-third', 'one-fourth', 'one-fifth', 'one-sixth' );
		$classes[] = $column_classes[$columns];
		global $wp_query;
		if( 0 == $wp_query->current_post || 0 == $wp_query->current_post % $columns )
			$classes[] = 'first';
	}
	return $classes;
}
add_filter( 'post_class', 'be_portfolio_post_class' );
// Remove post info
remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
// Remove the post content (requires HTML5 theme support)
remove_action( 'genesis_entry_content', 'genesis_do_post_content' );
// Remove entry meta from entry footer incl. markup
remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_open', 5 );
remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_close', 15 );
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );
// Remove the post image (requires HTML5 theme support)
remove_action( 'genesis_entry_content', 'genesis_do_post_image', 8 );
add_action( 'genesis_entry_header', 'prettycreative_featured_image', 7 );
function prettycreative_featured_image() {
	if ( $image = genesis_get_image( 'format=url&size=portfolio' ) ) {
		printf( '<div class="recipe-image"><a href="%s" rel="bookmark"><img src="%s" alt="%s" /></a></div>', get_permalink(), $image, the_title_attribute( 'echo=0' ) );
	}
}

genesis();