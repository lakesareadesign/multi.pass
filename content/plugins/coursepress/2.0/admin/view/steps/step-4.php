<?php
/**
 * Course Edit Step - 4
 **/
?>
<div class="step-title step-4">
	<?php _e( 'Step 4 &ndash; Course Dates', 'cp' ); ?>
	<div class="status <?php echo $setup_class; ?>"></div>
</div>

<div class="cp-box-content step-content step-4">
	<input type="hidden" name="meta_setup_step_4" value="saved" />

	<div class="wide course-dates">
		<label><?php _e( 'Course Availability', 'cp' ); ?></label>
		<p class="description"><?php _e( 'These are the dates that the course will be available to students', 'cp' ); ?></p>
		<label class="checkbox medium">
			<input type="checkbox" name="meta_course_open_ended" <?php checked( true, $open_ended_course ); ?> />
			<span><?php _e( 'This course has no end date', 'cp' ); ?></span>
		</label>
		<div class="date-range">
			<div class="start-date">
				<label for="meta_course_start_date" class="start-date-label required"><?php _e( 'Start Date', 'cp' ); ?></label>

				<div class="date">
					<input type="text" class="dateinput timeinput" name="meta_course_start_date" value="<?php echo $course_start_date; ?>" /><i class="calendar"></i>
				</div>
			</div>
			<div class="end-date <?php echo ( $open_ended_course ? 'disabled' : '' ); ?>">
				<label for="meta_course_end_date" class="end-date-label required"><?php _e( 'End Date', 'cp' ); ?></label>
				<div class="date">
					<input type="text" class="dateinput" name="meta_course_end_date" value="<?php echo $course_end_date; ?>" <?php echo ( $open_ended_course ? 'disabled="disabled"' : '' ); ?> />
				</div>
			</div>
		</div>
	</div>

	<div class="wide enrollment-dates">
		<label><?php _e( 'Course Enrollment Dates', 'cp' ); ?></label>
		<p class="description"><?php _e( 'These are the dates that students will be able to enroll in a course.', 'cp' ); ?></p>
		<label class="checkbox medium">
			<input type="checkbox" name="meta_enrollment_open_ended" <?php checked( true, $enrollment_open_ended ); ?> />
			<span><?php _e( 'Students can enroll at any time', 'cp' ); ?></span>
		</label>
		<div class="date-range enrollment">
			<div class="start-date <?php echo ( $enrollment_open_ended ? 'disabled' : '' ); ?>">
				<label for="meta_enrollment_start_date" class="start-date-label required"><?php _e( 'Start Date', 'cp' ); ?></label>

				<div class="date">
					<input type="text" class="dateinput" name="meta_enrollment_start_date" value="<?php echo esc_attr( $enrollment_start_date ); ?>" /><i class="calendar"></i>
				</div>
			</div>
			<div class="end-date <?php echo ( $enrollment_open_ended ? 'disabled' : '' ); ?>">
				<label for="meta_enrollment_end_date" class="end-date-label required"><?php _e( 'End Date', 'cp' ); ?></label>
				<div class="date">
					<input type="text" class="dateinput" name="meta_enrollment_end_date" value="<?php echo esc_attr( $enrollment_end_date ); ?>" <?php echo ( $enrollment_open_ended ? 'disabled="disabled"' : '' ); ?> />
				</div>
			</div>
		</div>
	</div>

	<?php
	/**
	 * Trigger after printing step 4 fields.
	 **/
	echo apply_filters( 'coursepress_course_setup_step_4', '', $course_id );

	// Print buttons
	echo static::get_buttons( $course_id, 4 );
	?>
	<br />
</div>