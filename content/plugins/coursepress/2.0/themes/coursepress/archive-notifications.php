<?php
/**
 * The notifications archive template file
 *
 * @package CoursePress
 */
global $wp;

$course_id = get_the_id();

// Redirect to the parent course page if not enrolled.
cp_can_access_course( $course_id );

get_header();
?>
<div id="primary" class="content-area coursepress-archive-notifications">
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

		<div class="clearfix"></div>

		<ul class="notification-archive-list">
			<?php
			$page = ( isset( $wp->query_vars['paged'] ) ) ? $wp->query_vars['paged'] : 1;

			$query_args = array(
				'category' => '',
				'order' => 'DESC',
				'post_type' => 'notifications',
				'post_mime_type' => '',
				'post_parent' => '',
				'post_status' => 'publish',
				'orderby' => 'meta_value_num',
				'paged' => $page,
				'meta_query' => array(
					'relation' => 'OR',
					array(
						'key' => 'course_id',
						'value' => $course_id,
					),
					array(
						'key' => 'course_id',
						'value' => 'all',
					),
				),
			);

			query_posts( $query_args );

			if ( have_posts() ) {
				while ( have_posts() ) {
					the_post();
					?>
					<li>
						<div class="notification-archive-single-meta">
							<div class="notification-date"><span class="date-part-one"><?php echo get_the_date( 'M' ); ?></span><span class="date-part-two"><?php echo get_the_date( 'j' ); ?></span></div>
							<span class="notification-meta-divider"></span>
							<div class="notification-time"><?php the_time(); ?></div>
						</div>
						<div class="notification-archive-single">
							<h1 class="notification-title"><?php the_title(); ?></h1>
							<div class="notification_author"><?php the_author(); ?></div>
							<div class="notification-content"><?php the_content(); ?></div>
						</div>
						<div class="clearfix"></div>
					</li>
					<?php
				}
			} else {
				?>
				<h1 class="zero-course-units">
					<?php _e( 'This course has no notifications yet. Please check back later.' ); ?>
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