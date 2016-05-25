<?php
/**
 * Template part for Infinite Scroll rendering of non-masonry posts.
 *
 * This markup should match the initially loaded markup.
 *
 * @package Milan
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemtype="http://schema.org/CreativeWork">
	<?php the_post_thumbnail( 'square' ); ?>
	<div class="article-content">
		<header class="entry-header">
			<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

			<?php if ( 'post' == get_post_type() ) : ?>
			<p class="entry-meta">
				<?php echo do_shortcode( "[post_date]" ); ?>
				<?php echo do_shortcode( "[post_author_posts_link]" ); ?>
			</p><!-- .entry-meta -->
			<?php endif; ?>
		</header><!-- .entry-header -->

		<div class="entry-content" itemprop="text">
			<?php the_excerpt(); ?>
		</div><!-- .entry-content -->
	</div>
</article><!-- #post-## -->
