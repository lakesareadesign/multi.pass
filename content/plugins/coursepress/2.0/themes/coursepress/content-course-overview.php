<?php
/**
 * @package CoursePress
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<h1 class="entry-title"><?php the_title(); ?></h1>
		<div class="instructors-content">
			<?php echo do_shortcode( '[course_instructors list="true" link="true"]' ); ?>
		</div>
	</header><!-- .entry-header -->

	<section id="course-summary">
		<?php
		$course_media = do_shortcode( '[course_media]' );
		if ( $course_media ) :
			?>
			<div class="course-video">
				<?php
				// Show course media
				echo $course_media;
				?>
			</div>
		<?php endif; ?>

		<div class="entry-content-excerpt <?php echo ($course_media ? '' : 'entry-content-excerpt-right' ); ?>">
			<div class="course-box">
				<?php
				// Change to yes for 'Open-ended'.
				echo do_shortcode( '[course_dates show_alt_display="yes"]' );

				// Change to yes for 'Open-ended'.
				echo do_shortcode( '[course_enrollment_dates show_alt_display="no"]' );
				echo do_shortcode( '[course_class_size]' );
				echo do_shortcode( '[course_enrollment_type label="' . __( 'Who can Enroll: ', 'cp' ) . '"]' );
				echo do_shortcode( '[course_language]' );
				echo do_shortcode( '[course_cost]' );
				?>
			</div><!--course-box-->
			<div class="quick-course-info">
				<?php echo do_shortcode( '[course_join_button]' ); ?>
			</div>
		</div>
	</section>

	<section id="additional-summary">
		<div class="social-shares">
			<span>
				<?php _e( 'SHARE', 'cp' ); ?>
			</span>
			<a href="http://www.facebook.com/sharer/sharer.php?s=100&p[url]=<?php the_permalink(); ?>&p[images][0]=&p[title]=<?php the_title(); ?>&p[summary]=<?php echo urlencode( strip_tags( get_the_excerpt() ) ); ?>" class="facebook-share" target="_blank"></a>
			<a href="http://twitter.com/home?status=<?php the_title(); ?> <?php the_permalink(); ?>" class="twitter-share" target="_blank"></a>
			<a href="https://plus.google.com/share?url=<?php the_permalink(); ?>" class="google-share" target="_blank"></a>
			<a href="mailto:?subject=<?php the_title(); ?>&body=<?php echo strip_tags( get_the_excerpt() ); ?>" target="_top" class="email-share"></a>
		</div><!--social shares-->
	</section>

	<br clear="all" />

	<?php $instructors = CoursePress_Data_Shortcode_Instructor::course_instructors( array( 'style' => 'block' ) ); ?>
	<div class="entry-content <?php echo( count( $instructors ) > 0 ? 'left-content' : '' ); ?>">
		<h1 class="h1-about-course"><?php _e( 'About the Course', 'cp' ); ?></h1>
		<div class="content"><?php echo do_shortcode('[course_description course_id="' . get_the_ID() . '"]'); ?></div>
<?php
		if ( CoursePress_Data_Course::get_setting( get_the_ID(), 'structure_visible', true ) ) : ?>
			<h1 class = "h1-about-course"><?php
				_e( 'Course Structure', 'cp' );
			?></h1>
			<?php echo do_shortcode( '[course_structure label="" show_title="no" show_divider="yes"]' );
		endif;

		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'cp' ),
				'after' => '</div>',
			)
		);
		?>
	</div><!-- .entry-content -->

	<?php if ( !empty( $instructors ) ) : ?>
		<div class="course-instructors right-content">
			<h1 class="h1-instructors"><?php _e( 'Instructors', 'cp' ); ?></h1>
			<?php echo $instructors; ?>
		</div><!--course-instructors right-content-->
	<?php endif; ?>

	<br clear="all" />

	<footer class="entry-meta">
		<?php
		// Translators: Used between list items, there is a space after the comma.
		$category_list = get_the_category_list( __( ', ', 'cp' ) );

		// Translators: Used between list items, there is a space after the comma.
		$tag_list = get_the_tag_list( '', __( ', ', 'cp' ) );

		if ( ! coursepress_categorized_blog() ) {
			// This blog only has 1 category so we just need to worry about tags in the meta text.
			if ( $tag_list ) {
				$meta_text = __( 'This entry was tagged %2$s. Bookmark the <a href="%3$s" rel="bookmark">permalink</a>.', 'cp' );
			} else {
				$meta_text = '';
			}
		} else {
			// But this blog has loads of categories so we should probably display them here.
			if ( $tag_list ) {
				$meta_text = __( 'This entry was posted in %1$s and tagged %2$s. Bookmark the <a href="%3$s" rel="bookmark">permalink</a>.', 'cp' );
			} else {
				$meta_text = __( 'This entry was posted in %1$s. Bookmark the <a href="%3$s" rel="bookmark">permalink</a>.', 'cp' );
			}
		} // end check for categories on this blog.

		printf(
			$meta_text,
			$category_list,
			$tag_list,
			get_permalink()
		);
		?>

		<?php
		edit_post_link(
			__( 'Edit', 'cp' ),
			'<span class="edit-link">',
			'</span>'
		);
		?>
	</footer><!-- .entry-meta -->
</article><!-- #post-## -->