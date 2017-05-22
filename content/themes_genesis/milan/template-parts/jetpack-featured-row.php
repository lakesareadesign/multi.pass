<?php
/**
 * The template used for the posts in the row below the primary featured post.
 *
 * @package Adaline
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'featured-secondary' ); ?>>
	<?php the_post_thumbnail( 'square' ); ?>
	<p class="entry-meta">
		<?php echo do_shortcode( "[post_date]" ); ?>
	</p>
	<?php the_title( sprintf( '<h4 class="entry-title" itemprop="headline"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h4>' ); ?>
</article>
