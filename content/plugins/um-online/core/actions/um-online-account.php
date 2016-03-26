<?php

	/***
	***	@Add account privacy setting to control online status
	***/
	add_action('um_after_account_privacy', 'um_online_privacy_setting');
	function um_online_privacy_setting() {
		
		?>
		
		<div class="um-field" data-key="">
			
			<div class="um-field-label">
				<label for="hide_online_status"><?php _e('Hide my online status?','um-online'); ?></label>
				<span class="um-tip um-tip-w" title="<?php _e('Do you want other people to see that you are online?','um-online'); ?>"><i class="um-icon-help-circled"></i></span>
				<div class="um-clear"></div>
			</div>
			
			<div class="um-field-area">
			
				<?php if ( get_user_meta( get_current_user_id(), '_hide_online_status', true ) == 1 ) { ?>
				
				<label class="um-field-radio um-field-half"><input type="radio" name="_hide_online_status" value="0" /><span class="um-field-radio-state"><i class="um-icon-android-radio-button-off"></i></span><span class="um-field-radio-option"><?php _e('No','um-online'); ?></span></label>
				<label class="um-field-radio active um-field-half right"><input type="radio" name="_hide_online_status" value="1" checked /><span class="um-field-radio-state"><i class="um-icon-android-radio-button-on"></i></span><span class="um-field-radio-option"><?php _e('Yes','um-online'); ?></span></label>
				
				<?php } else { ?>
				
				<label class="um-field-radio active um-field-half"><input type="radio" name="_hide_online_status" value="0" checked /><span class="um-field-radio-state"><i class="um-icon-android-radio-button-on"></i></span><span class="um-field-radio-option"><?php _e('No','um-online'); ?></span></label>
				<label class="um-field-radio um-field-half right"><input type="radio" name="_hide_online_status" value="1" /><span class="um-field-radio-state"><i class="um-icon-android-radio-button-off"></i></span><span class="um-field-radio-option"><?php _e('Yes','um-online'); ?></span></label>
				
				<?php } ?>
				
				<div class="um-clear"></div>
				<div class="um-clear"></div>
				
			</div>
			
		</div>

		<?php
		
	}