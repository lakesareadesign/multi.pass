<?php
/**
 * The units archive / grades template file
 *
 * @package CoursePress
 */

$course_id = do_shortcode( '[get_parent_course_id]' );
$progress = do_shortcode( '[course_progress course_id="' . $course_id . '"]' );
//redirect to the parent course page if not enrolled
cp_can_access_course( $course_id );

get_header();

add_thickbox();
?>
<div id="primary" class="content-area coursepress-archive-workbook">
	<main id="main" class="site-main" role="main">
		<h1 class="workbook-title">
			<?php
			echo do_shortcode( '[course_title course_id="' . $course_id . '" title_tag=""]' );
			?>
			<?php if ( 100 > (int) $progress ) : ?>
				<span class="workbook-course-progress">
				<?php echo esc_html( $progress ); ?>%
				<?php esc_html_e( 'completed', 'cp' ); ?>
				</span>
			<?php endif; ?>
		</h1>

		<div class="instructors-content">
			<?php
			// Flat hyperlinked list of instructors
			echo do_shortcode( '[course_instructors style="list-flat" link="true" course_id="' . $course_id . '"]' );
			?>
		</div>

		<?php
		echo do_shortcode( '[course_unit_archive_submenu]' );
		if ( 100 == (int) $progress ) {
			echo sprintf(
				'<div class="unit-archive-course-complete">%s %s</div>',
				'<i class="fa fa-check-circle"></i>',
				__( 'Course Complete', 'cp' )
			);
		}
		?>

		<div class="clearfix"></div>

		<?php
		if ( have_posts() ) {
			while ( have_posts() ) {
				the_post();
				?>
				<div class="workbook_units">
					<div class="unit_title">
						<h3><?php the_title(); ?>
							<span>
<?php
				$unit_id = get_the_ID();
				$shortcode = '';
				if ( empty( $unit_id ) ) {
					$shortcode = sprintf( '[course_progress course_id="%d"]', $course_id );
				} else {
					$shortcode = sprintf( '[course_unit_progress course_id="%d" unit_id="%d"]', $course_id, $unit_id );
				}
				echo do_shortcode( $shortcode );
?>%
							<?php esc_html_e( 'completed', 'cp' ); ?>
							</span>
						</h3>
					</div>
					<div class="accordion-inner">
						<?php echo do_shortcode( '[student_workbook_table]' ); ?>
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

	</main><!-- #main -->
</div><!-- #primary -->
<?php

get_sidebar( 'footer' );
get_footer();