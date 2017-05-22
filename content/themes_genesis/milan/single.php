<?php
/**
 * This file adds customizations to the single post template on the Milan Pro Theme.
 *
 * @author Themetry
 * @package Milan
 * @subpackage Customizations
 */

//* Adds author info, date, and category list to the entry header
add_action( 'genesis_entry_header', 'milan_single_post_open', 16 );
function milan_single_post_open() {
	echo '<div class="entry-wrap">';
	echo '<div class="entry-meta">';
	echo '<div class="post-author">';
	echo get_avatar( get_the_author_meta( 'ID' ), '70' );
	$byline = sprintf(
		esc_html_x( 'by %s', 'post author', 'milan' ),
		'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
	);
	echo '<span class="byline"> ' . $byline . '</span>';
	echo '</div>';

	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	$posted_on = sprintf(
		esc_html_x( '%s', 'post date', 'milan' ),
		'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
	);

	echo '<span class="posted-on">' . $posted_on . '</span>';

	if ( 'post' == get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list();
		if ( $categories_list ) {
			printf( '<span class="cat-links"><span class="cats-title">%2$s</span>' . esc_html( '%1$s' ) . '</span>', $categories_list, esc_html__( 'Filed under:', 'milan' ) );
		}
	}

	echo '</div>';
}

//* Close .entry-wrap div
add_action( 'genesis_entry_footer', 'milan_single_post_close', 16 );
function milan_single_post_close() {
	if ( is_single() ) {
		echo '</div><!-- .entry-wrap -->';
	}
}

//* Adds tags and previous/next post navigation to the entry footer
add_action( 'genesis_entry_footer', 'milan_entry_footer', 17 );
function milan_entry_footer() {
	echo '<footer class="entry-footer">';
	if ( 'post' == get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '</span><ul><li>', '</li><li>', '</li></ul>' );
		if ( $tags_list ) {
			printf( '<span class="tags-links"><span class="tags-title">' . esc_html__( 'Tagged: %1$s', 'milan' ) . '</span>', $tags_list );
		}
	}
	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous ) {
		return;
	}
	?>
	<nav class="navigation post-navigation" role="navigation">
		<h2 class="screen-reader-text"><?php esc_html_e( 'Post navigation', 'milan' ); ?></h2>
		<div class="nav-links">
			<?php
			/**
			 * Conditionals used to output internationalized "Previous/Next Post" language
			 */
			if ( $previous ) {
			?>
				<div class="nav-previous">
					<span class="nav-label"><?php esc_html_e( 'Previous Post', 'milan' ); ?></span>
					<?php previous_post_link( '%link', '%title' ); ?>
				</div>
			<?php
			} if ( $next ) { ?>
				<div class="nav-next">
					<span class="nav-label"><?php esc_html_e( 'Next Post', 'milan' ); ?></span>
					<?php next_post_link( '%link', '%title' ); ?>
				</div>
			<?php } ?>
		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
<?php
}

//* Run the Genesis function
genesis();
