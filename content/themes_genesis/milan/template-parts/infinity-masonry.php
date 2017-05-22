<?php
/**
 * Template part for Infinite Scroll rendering of masonry posts.
 *
 * This markup should match the initially loaded markup.
 *
 * @package Milan
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="grid-wrap">
		<?php the_post_thumbnail( 'square' ); ?>
		<?php if ( 'post' == get_post_type() ) : ?>
			<div class="entry-meta">
				<?php echo do_shortcode( "[post_date]" ); ?>
			</div><!-- .entry-meta -->
		<?php endif; ?>
		<header class="entry-header">
			<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
		</header><!-- .entry-header -->
	</div>
</article><!-- #post-## -->
