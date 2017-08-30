<?php
/**
 * Portfolio Archive.
 *
 * This template overrides the default archive template to clean
 * up the output.
 *
 * @package      Studio Pro
 * @link         https://seothemes.com/studio-pro
 * @author       Seo Themes
 * @copyright    Copyright © 2017 Seo Themes
 * @license      GPL-2.0+
 */

/**
 * Add portfolio body class.
 *
 * @param array $classes Default body classes.
 * @return array $classes Default body classes.
 */
function studio_portfolio_body_class( $classes ) {
	$classes[] = 'portfolio';
	$classes[] = 'masonry';
	return $classes;
}
add_filter( 'body_class', 'studio_portfolio_body_class', 999 );

// Force full width content layout.
add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );

// Remove custom structural wraps.
remove_action( 'genesis_before_content_sidebar_wrap', 'studio_wrap_open', 6 );
remove_action( 'genesis_after_content_sidebar_wrap', 'studio_wrap_close', 13 );

// Remove the breadcrumbs.
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );

// Remove standard loop (optional).
remove_action( 'genesis_loop', 'genesis_do_loop' );

// Add our custom loop.
add_action( 'genesis_loop', 'studio_filterable_portfolio' );

// Enqueue scripts.
wp_enqueue_script( 'isotope', get_stylesheet_directory_uri() . '/assets/scripts/min/isotope.pkgd.min.js', array( 'jquery' ), CHILD_THEME_VERSION, false );
wp_enqueue_script( 'isotope-init', get_stylesheet_directory_uri() . '/assets/scripts/min/isotope-init.min.js', array( 'isotope' ), CHILD_THEME_VERSION, false );

/**
 * Output filterable portfolio items.
 *
 * @since 1.0
 */
function studio_filterable_portfolio() {

	global $post;
	$terms = get_terms( 'portfolio-type' );
	?>

	<div class="archive-description">
		<?php if ( $terms ) { ?>
		<div id="portfolio-cats" class="filter clearfix">
			<div class="wrap">
				<a href="#" class="active" data-filter="*"><?php esc_html_e( 'All', 'studio-pro' ); ?></a>
				<?php foreach ( $terms as $term ) : ?>
				 	<a href='#' data-filter='.<?php echo esc_attr( $term->slug ); ?>'><?php echo esc_html( $term->name ); ?></a>
				<?php endforeach; ?>
			</div>
		</div>
		<?php } ?>

		<?php if ( have_posts() ) { ?>
		<div class="portfolio-content">
		<?php

		while ( have_posts() ) : the_post();

			$terms = get_the_terms( get_the_ID(), 'portfolio-type' );

			// Display portfolio items.
			if ( has_post_thumbnail( $post->ID ) ) {
				?>
				<article class="portfolio-item <?php if ( $terms ) { foreach ( $terms as $term ) { echo ' ' . $term->slug;	} } ?>">
					<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
					<?php
						echo genesis_get_image( array(
							'size'     => 'portfolio',
							'itemprop' => 'image',
						) );
						printf( '<p class="entry-title" itemprop="name"><span>%s</span></p>', get_the_title() );
					?>
					</a>
				</article>
				<?php

			}
		endwhile; ?>
		</div>
		<?php } ?>
	</div>

<?php

}

// Run genesis.
genesis();
