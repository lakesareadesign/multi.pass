<?php
/**
 * The Template for displaying all single posts.
 *
 * @package CoursePress
 */

get_header(); ?>

	<div id="primary" class="content-area content-side-area">
		<main id="main" class="site-main" role="main">

		<?php
		while ( have_posts() ) :
			the_post();

			get_template_part( 'content', 'single' );

			coursepress_post_nav();

			// If comments are open or we have at least one comment, load up the comment template
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		endwhile; // end of the loop.
		?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();