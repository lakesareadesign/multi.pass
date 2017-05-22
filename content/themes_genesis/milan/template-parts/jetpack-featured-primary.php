<?php
/**
 * The template used for the primary featured post.
 *
 * @package Adaline
 */

?>

<div class="featured-primary">
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<?php the_post_thumbnail( 'rectangle' ); ?>
		<div class="featured-content">
			<?php the_title( sprintf( '<h4 class="entry-title" itemprop="headline"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
			<div class="entry-meta">
				<?php echo do_shortcode( "[post_date]" ); ?>
				<?php echo do_shortcode( "[post_author_posts_link]" ); ?>
			</div>
			<div class="entry-excerpt" itemprop="text">
				<?php echo wp_trim_words( get_the_excerpt(), 26, '' ); ?>
			</div>
		</div>
	</article>
</div><!-- .featured-primary -->