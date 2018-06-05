<?php
/**
 * The Template for displaying instructor profile.
 *
 * @package CoursePress
 */
get_header();
?>
<div id="primary" class="content-area content-instructor-profile">
    <main id="main" class="site-main" role="main">
<?php
$user = false;
global $wp;
if ( array_key_exists( 'instructor_username', $wp->query_vars ) ) {
	$username = sanitize_text_field( $wp->query_vars['instructor_username'] );
	$user = CoursePress_Data_Instructor::instructor_by_login( $username );
	if ( empty( $user ) ) {
		$user = CoursePress_Data_Instructor::instructor_by_hash( $username );
	}
}
if ( empty( $user ) ) {
	printf( '<h1>%s</h1>', esc_html__( 'Instructor not found.', 'coursepress' ) );
	printf( '<p>%s</p>', esc_html__( 'The requested instuctor does not exists.', 'coursepress' ) );
} else {
	$assigned_courses = CoursePress_Data_Instructor::get_assigned_courses_ids( $user->ID, 'publish' );
?>
		<h1 class="h1-instructor-title">
		<?php echo $user->display_name; ?>
		</h1>

		<?php
		// Avatar.
		echo do_shortcode( '[course_instructor_avatar instructor_id="' . $user->ID . '" thumb_size="235" class="instructor_avatar_full"]' );

		// Bio.
		echo wp_kses_post(
			get_user_meta( $user->ID, 'description', true )
		);
		?>

		<h2 class="h2-instructor-bio">
			<?php _e( 'Courses', 'coursepress' ); ?>
		</h2>

		<?php
		// Course List.
		echo do_shortcode( '[course_list instructor="' . $user->ID . '" class="course" left_class="enroll-box-left" right_class="enroll-box-right" course_class="enroll-box" title_link="yes"]' );
}
		?>
	</main><!-- #main -->
</div><!-- #primary -->
<?php
get_footer();