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
		<ul class="units-archive-list">
		<?php
		if ( have_posts() ) {
			while ( have_posts() ) {
				the_post();
				?>
				<div class="workbook_units">
					<div class="unit_title">
						<h3><?php esc_html_e( 'Course Grades', 'cp' ); ?></h3>
					</div>
					<div class="accordion-inner">
						<?php echo do_shortcode( '[student_grades_table]' ); ?>
					</div>
				<div class="total_grade"><?php
					$shortcode = sprintf( '[course_progress course_id="%d"]', $course_id );
				echo apply_filters(
					'coursepress_grade_caption',
					__( 'TOTAL:', 'cp' )
				) . ' ';
				echo do_shortcode( $shortcode );
				echo '%';
				?>
				</div>
				</div>
				<?php
			}
			wp_reset_query();
		} else {
			?>
			<div class="zero-courses"><?php esc_html_e( '0 Units in the course', 'cp' ); ?></div>
			<?php
		}
		?>
		</ul>
	</main><!-- #main -->
</div><!-- #primary -->
<?php
get_sidebar( 'footer' );
get_footer();