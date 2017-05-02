<?php
/**
 * The units archive template file
 *
 * @package CoursePress
 */

$course_id = get_the_ID();
if ( empty( $course_id ) ) {
    global $post;
    $course_id = preg_replace( '/[^\d]/', '', $post->post_name );
}
if ( ! empty( $course_id ) ) {
    $post = get_post( $course_id );
    setup_postdata( $post );
}

// Redirect to the parent course page if not enrolled.
cp_can_access_course( $course_id );

get_header();

$progress = (int) do_shortcode( '[course_progress course_id="' . $course_id . '"]' );
?>
<div id="primary" class="content-area coursepress-archive-unit">
	<main id="main" class="site-main" role="main">
		<h1>
			<?php echo get_the_title( $course_id ) ?>
		</h1>
		<?php echo CoursePress_Template_Unit::unit_archive();?>

	</main><!-- #main -->
</div><!-- #primary -->
<?php
if ( ! empty( $course_id ) ) {
    wp_reset_postdata();
}
get_sidebar( 'footer' );
get_footer();