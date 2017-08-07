<?php
/**
 * The units archive / grades template file
 *
 * @package CoursePress
 */
global $coursepress;
$course_id = do_shortcode( '[get_parent_course_id]' );
// Redirect to the parent course page if not enrolled.
cp_can_access_course( $course_id );
$progress = do_shortcode( '[course_progress course_id="' . $course_id . '"]' );
get_header();
?>
<div id="primary" class="content-area coursepress-archive-grades">
	<main id="main" class="site-main" role="main">
		<h1>
			<?php echo do_shortcode( '[course_title course_id="' . $course_id . '"]' ); ?>
		</h1>
		<div class="instructors-content">
			<?php
			// Flat hyperlinked list of instructors
			echo do_shortcode( '[course_instructors style="list-flat" link="true" course_id="' . $course_id . '"]' );
			?>
		</div>
		<?php
		echo do_shortcode( '[course_unit_archive_submenu]' );
		?>
		<div class="clearfix"></div>
			<?php if ( have_posts() ) { ?>
                <div class="unit-grade-table">
                    <?php echo do_shortcode( '[student_grades_table]' ); ?>
                </div>
                <div class="total-course-grade">
                    <?php
                    $total_grade = do_shortcode( sprintf( '[course_progress course_id="%s"]', $course_id ) );
                    printf( '<span class="total-grade">%s: %d%%</span>', __( 'Total'), $total_grade );
                    ?>
                </div>

			<?php } else { ?>
				<h1 class="zero-course-units">
					<?php _e( 'This course has no units yet. Please check back later.' ); ?>
				</h1>
			<?php } ?>
	</main><!-- #main -->
</div><!-- #primary -->
<?php
get_sidebar( 'footer' );
get_footer();