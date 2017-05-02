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
			<?php if ( have_posts() ) {
				$grades = 0;
				$units = 0;

				while ( have_posts() ) :
					the_post();
					$module_count = do_shortcode( '[course_unit_details field="input_modules_count"]' );
					$grades += (int) do_shortcode( '[course_unit_details field="student_unit_grade" unit_id="' . get_the_ID() . '"]' );
					?>
					<li>
						<div class="unit-archive-single">
							<span class="grade-percentage">
								<?php echo do_shortcode( '[course_unit_details field="student_unit_grade" unit_id="' . get_the_ID() . '" format="true"]' ); ?>
							</span>
							<a class="unit-archive-single-title" href="<?php the_permalink(); ?>" rel="bookmark">
								<?php the_title(); ?>
							</a>

							<?php if ( $module_count ) { ?>
								<span class="unit-archive-single-module-status">
								<?php
								printf(
									__( '%1$d of %2$d mandatory elements completed | %3$d of %4$d elements graded', 'cp' ),
									do_shortcode( '[course_unit_details field="student_module_responses"]' ),
									do_shortcode( '[course_unit_details field="mandatory_input_modules_count"]' ),
									do_shortcode( '[course_unit_details field="student_unit_modules_graded" unit_id="' . get_the_ID() . '"]' ),
									do_shortcode( '[course_unit_details field="mandatory_input_modules_count"]' )
								)
								?>
								</span>
							<?php } else { ?>
								<span class="unit-archive-single-module-status read-only-module">
									<?php _e( 'Read-only','cp' ); ?>
								</span>
							<?php } ?>
						</div>
					</li>
					<?php
					$units++;
				endwhile;
				?>
				<div class="total_grade"><?php
				echo apply_filters(
					'coursepress_grade_caption',
					__( 'TOTAL:', 'cp' )
				) . ' ';
				echo apply_filters(
					'coursepress_grade_total',
					( $grades > 0 ? ( round( $grades / $units, 0 ) ) : 0 ) . '%'
				);
				?>
				</div>
			<?php } else { ?>
				<h1 class="zero-course-units">
					<?php _e( 'This course has no units yet. Please check back later.' ); ?>
				</h1>
			<?php } ?>
		</ul>
	</main><!-- #main -->
</div><!-- #primary -->
<?php

get_sidebar( 'footer' );
get_footer();