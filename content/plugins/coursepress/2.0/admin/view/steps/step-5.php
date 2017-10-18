<?php
/**
 * Course Edit Step - 5
 **/
?>
<div class="step-title step-5">
	<?php _e( 'Step 5 &ndash; Classes, Discussion & Workbook', 'cp' ); ?>
	<div class="status <?php echo $setup_class; ?>"></div>
</div>

<div class="cp-box-content step-content step-5">
	<input type="hidden" name="meta_setup_step_5" value="saved" />

	<div class="wide class-size">
		<label><?php _e( 'Class Size', 'cp' ); ?></label>
		<p class="description"><?php _e( 'Use this setting to set a limit for all classes. Uncheck for unlimited class size(s).', 'cp' ); ?></p>
		<label class="narrow col">
			<input type="checkbox" name="meta_class_limited" <?php checked( true, $class_limited ); ?> />
			<span><?php _e( 'Limit class size', 'cp' ); ?></span>
		</label>

		<label class="num-students narrow col <?php echo ( $class_limited ? '' : 'disabled' ); ?>">
			<?php _e( 'Number of students', 'cp' ); ?>
			<input type="text" class="spinners" name="meta_class_size" value="<?php echo $class_size; ?>" <?php echo ( $class_limited ? '' : 'disabled="disabled"' ); ?> />
		</label>
	</div>

	<?php
	$checkboxes = array(
		array(
			'meta_key' => 'allow_discussion',
			'title' => __( 'Course Discussion', 'cp' ),
			'description' => __( 'If checked, students can post questions and receive answers at a course level. A \'Discusssion\' menu item is added for the student to see ALL discussions occuring from all class members and instructors.', 'cp' ),
			'label' => __( 'Allow course discussion', 'cp' ),
			'default' => false,
		),
		array(
			'meta_key' => 'allow_workbook',
			'title' => __( 'Student Workbook', 'cp' ),
			'description' => __( 'If checked, students can see their progress and grades.', 'cp' ),
			'label' => __( 'Show student workbook', 'cp' ),
			'default' => false,
		),
		array(
			'meta_key' => 'allow_grades',
			'title' => __( 'Student grades', 'cp' ),
			'description' => __( 'If checked, students can see their grades.', 'cp' ),
			'label' => __( 'Show student grades', 'cp' ),
			'default' => false,
		),
	);

	foreach ( $checkboxes as $one ) {
		echo CoursePress_Helper_UI::course_edit_checkbox( $one, $course_id );
	}

	/**
	 * Trigger after printing fields at step 5.
	 *
	 * The dynamic portion of this hook is to allow additional course meta fields.
	 **/
	echo apply_filters( 'coursepress_course_setup_step_5', '', $course_id );

	/**
	 * Print button **/
	echo CoursePress_View_Admin_Course_Edit::get_buttons( $course_id, 5 );
	?>
</div>