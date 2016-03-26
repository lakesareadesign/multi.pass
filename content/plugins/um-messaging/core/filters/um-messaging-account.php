<?php

	/***
	***	@Show a notification option in email tab
	***/
	add_filter('um_account_content_hook_notifications', 'um_messaging_account_tab', 46 );
	function um_messaging_account_tab( $output ){
		global $um_messaging;

		ob_start();
		
		$_enable_new_pm = $um_messaging->api->enabled_email( get_current_user_id() );
		
		?>
		
			<div class="um-field-area">
				
				<?php if ( $_enable_new_pm ) { ?>
					
				<label class="um-field-checkbox active">
					<input type="checkbox" name="_enable_new_pm" value="1" checked />
					<span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline"></i></span>
					<span class="um-field-checkbox-option"><?php echo __('Someone sends me a private message','um-messaging'); ?></span>
				</label>
					
				<?php } else { ?>
					
				<label class="um-field-checkbox">
					<input type="checkbox" name="_enable_new_pm" value="1" />
					<span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline-blank"></i></span>
					<span class="um-field-checkbox-option"><?php echo __('Someone sends me a private message','um-messaging'); ?></span>
				</label>
					
				<?php } ?>
					
				<div class="um-clear"></div>
				
			</div>
		
		<?php
		
		$output .= ob_get_contents();
		ob_end_clean();

		return $output;
	}