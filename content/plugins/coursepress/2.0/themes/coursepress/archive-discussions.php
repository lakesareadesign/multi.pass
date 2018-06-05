<?php
/**
 * The discussion archive template file
 *
 * @package CoursePress
 */

global $wp;

$course_id = get_the_ID();

// Redirect to the parent course page if not enrolled.
cp_can_access_course( $course_id );

get_header();

?>
<div id="primary" class="content-area coursepress-archive-discussions">
	<main id="main" class="site-main" role="main">
		<h1>
			<?php echo do_shortcode( '[course_title course_id="' . $course_id . '"]' ); ?>
		</h1>
		<div class="instructors-content">
			<?php
			// Flat hyperlinked list of instructors.
			echo do_shortcode( '[course_instructors style="list-flat" link="true" course_id="' . $course_id . '"]' );
			?>
		</div>

		<?php
		echo do_shortcode( '[course_unit_archive_submenu]' );
		?>

		<div class="discussion-controls">
			<a class="button_submit" href="<?php echo get_permalink( $course_id ); ?><?php echo CoursePress_Core::get_slug( 'discussion' ) . '/' . CoursePress_Core::get_slug( 'discussion_new' ); ?>/">
				<?php _e( 'Ask a Question', 'coursepress' ); ?>
			</a>
		</div>

		<div class="clearfix"></div>

		<ul class="discussion-archive-list">
			<?php
			$page = ( isset( $wp->query_vars['paged'] ) ) ? $wp->query_vars['paged'] : 1;
			$query_args = array(
				'order' => 'DESC',
				'post_type' => 'discussions',
				'post_status' => 'publish',
				'meta_key' => 'course_id',
				'meta_value' => $course_id,
				'paged' => $page,
			);

			query_posts( $query_args );

			if ( have_posts() ) {
				while ( have_posts() ) :
					the_post();

					$discussion = CoursePress_Data_Discussion::get_one( get_the_ID() );
					?>
					<li class="discussion-<?php the_ID(); ?>">
						<div class="discussion-archive-single-meta">
							<div class="<?php
							if ( get_comments_number() ) {
								echo 'discussion-answer-circle';
							} else {
								echo 'discussion-comments-circle';
							}
							?>">
								<span class="comments-count">
									<?php echo get_comments_number(); ?>
								</span>
							</div>
						</div>
						<div class="discussion-archive-single">
							<h1 class="discussion-title">
								<a href="<?php the_permalink(); ?>">
									<?php the_title(); ?>
								</a>
							</h1>
							<div class="discussion-meta">
<?php
				$unit_id = get_post_meta( get_the_ID(), 'unit_id', true );
				if ( $unit_id ) {
					$discussion_unit = sprintf(
						'<a href="%s">%s</a>',
						esc_url( CoursePress_Data_Unit::get_url( $unit_id ) ),
						get_the_title( $unit_id )
					);
				} else {
					$discussion_unit = get_the_title( $course_id );
				}
?>
								<span>
									<?php echo get_the_date(); ?>
								</span> | <span>
									<?php the_author(); ?>
								</span> | <span>
									<?php echo $discussion_unit; ?>
								</span> | <span>
									<?php echo get_comments_number(); ?>
									<?php _e( 'Comments', 'coursepress' ); ?>
								</span>
							</div>
							<div class="clearfix"></div>
						</div>

					</li>
					<?php
				endwhile;
			} else {
				?>
				<h1 class="zero-course-units">
					<?php _e( 'This course has no discussions yet. Start one, ask a question!' ); ?>
				</h1>
				<?php
			}
			?>
		</ul>
		<br clear="all" />
		<?php cp_numeric_posts_nav( 'navigation-pagination' ); ?>
	</main><!-- #main -->
</div><!-- #primary -->
<?php

get_sidebar( 'footer' );
get_footer();