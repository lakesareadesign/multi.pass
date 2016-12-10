<?php
/**
 * The Template for displaying all single posts.
 *
 * @package CoursePress
 */
get_header();
?>

<div id="primary" class="content-area coursepress-single-course">
	<main id="main" class="site-main" role="main">

	<?php
	while ( have_posts() ) :
		the_post();

		get_template_part( 'content-course-overview', 'single' );

		coursepress_post_nav();
	endwhile; // end of the loop.
	wp_reset_postdata();
	?>

	</main><!-- #main -->
</div><!-- #primary -->

<?php
get_sidebar( 'footer' );
get_footer();