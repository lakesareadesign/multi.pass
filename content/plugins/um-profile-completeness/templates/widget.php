<div class="um-completeness-widget">

	<div style="font-weight: bold;line-height: 22px;">
		<span>Profile: <span class="um-completeness-progress" style="color: #3BA1DA;"><span class="um-completeness-jx"><?php echo $result['progress']; ?></span>%</span></span>
	</div>

	<div class="um-completeness-bar-holder">
		<?php echo $result['bar']; ?>
	</div>

	<?php if ( isset( $result['steps'] ) && is_array( $result['steps'] ) ) { ?>
	<div class="um-completeness-steps">

		<?php $i=0; foreach( $result['steps'] as $key => $pct ) {
			
			if ( $key == 'synced_profile_photo' ) continue;
			if ( in_array( $key, $result['completed'] ) ) continue;
			
			$i++; 
		
			if ( $key == 'profile_photo' || $key == 'cover_photo' ) {
				$edit_link = '<a href="'. um_edit_profile_url() .'" class="um-completeness-edit">' . $ultimatemember->fields->get_field_title($key) . '</a>';
			} else {
				$edit_link = '<a href="#" data-key="'.$key.'" class="um-completeness-edit">' . $ultimatemember->fields->get_field_title($key) . '</a>';
			}
			
		?>
		
		<div data-key="<?php echo $key; ?>" class="um-completeness-step <?php if ( in_array( $key, array('profile_photo','cover_photo') ) ) echo 'is-core'; ?> <?php if ( in_array( $key, $result['completed'] ) ) echo 'completed'; ?>">
			<span class="um-completeness-bullet"><?php echo $i; ?>.</span>
			<span class="um-completeness-desc"><?php printf(__('<strong>%s</strong>','um-profile-completeness'), $edit_link ); ?></span>
			<span class="um-completeness-pct"><?php echo $pct; ?>%</span>
		</div>
		
		<?php } ?>

	</div>
	<?php } ?>

	<div style="padding-top: 15px;text-align: center;"><a href="<?php echo um_edit_profile_url(); ?>"><?php _e('Complete your profile','um-profile-completeness'); ?></a></div>

</div>