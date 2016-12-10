<?php
/**
 * Add New Discussion template file
 *
 * @package CoursePress
 */

$course_id = do_shortcode( '[get_parent_course_id]' );
cp_can_access_course( $course_id );

$form_message_class = '';
$form_message = '';

if ( isset( $_POST['new_question_submit'] ) ) {
	check_admin_referer( 'new_question' );
	if ( empty( $_POST['question_title'] ) ) {
		$form_message = __( 'Question title is required.', 'cp' );
		$form_message_class = 'red';
	} elseif ( empty( $_POST['question_description'] ) ) {
		$form_message = __( 'Question description is required.', 'cp' );
		$form_message_class = 'red';
	} else {
		CoursePress_Data_Discussion::update_discussion(
			$_POST['question_title'],
			$_POST['question_description'],
			$course_id
		);
		wp_safe_redirect(
			get_permalink( $course_id ) . CoursePress_Core::get_slug( 'discussion' )
		);
		exit;
	}
}

get_header();

$post = CoursePress_Data_Discussion::get_one();

?>
<div id="primary" class="content-area coursepress-add-discussion">
	<main id="main" class="site-main" role="main">
		<h1><?php echo do_shortcode( '[course_title course_id="' . $course_id . '"]' ); ?></h1>
		<div class="instructors-content">
			<?php echo do_shortcode( '[course_instructors style="list-flat" course_id="' . $course_id . '"]' ); ?>
		</div>

		<?php
		echo do_shortcode( '[course_unit_archive_submenu]' );
		?>

		<div class="clearfix"></div>

		<p class="form-info-<?php echo $form_message_class; ?>"><?php echo $form_message; ?></p>

        <form id="new_question_form" name="new_question_form" method="post" class="new_question_form">
            <input type="hidden" value="<?php echo intval( $post['ID'] ); ?>" name="discussion_id" />
			<div class="add_new_discussion">
				<?php
				$scode = sprintf(
					'[units_dropdown course_id="%d" include_general="true" general_title="%s"]',
					$course_id,
					__( 'Course General', 'cp' )
				);
				echo do_shortcode( $scode );
				?>
				<div class="new_question">
					<div class="rounded"><span>Q</span></div>
					<input type="text" name="question_title" placeholder="<?php
						esc_attr_e( 'Title of your question', 'cp' );
				?>" value="<?php esc_attr_e( $post['post_title'] ); ?>"/>
					<textarea name="question_description" placeholder="<?php
						esc_attr_e( 'Question description...', 'cp' );
							?>"><?php echo  CoursePress_Helper_Utility::filter_content( $post['post_content'] ); ?></textarea>

					<input type="submit" class="button_submit" name="new_question_submit" value="<?php
						esc_attr_e( 'Ask this Question', 'cp' );
?>" />

					<a href="<?php
						echo get_permalink( $course_id ) . CoursePress_Core::get_slug( 'discussion' );
						?>/" class="button_cancel">
						<?php esc_attr_e( 'Cancel', 'cp' ); ?>
					</a>

					<?php wp_nonce_field( 'new_question' ); ?>
				</div>
			</div>
		</form>

	</main><!-- #main -->
</div><!-- #primary -->
<?php

get_sidebar( 'footer' );
get_footer();