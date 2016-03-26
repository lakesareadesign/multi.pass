<?php

	/***
	***	@show mailchimp lists in account
	***/
	add_filter('um_account_content_hook_notifications', 'um_followers_account_tab', 50 );
	function um_followers_account_tab( $output ){
		global $um_followers;

		ob_start();
		
		$_enable_new_follow = $um_followers->api->enabled_email( get_current_user_id() );
		
		?>
		
			<div class="um-field-area">
				
				<?php if ( $_enable_new_follow ) { ?>
					
				<label class="um-field-checkbox active">
					<input type="checkbox" name="_enable_new_follow" value="1" checked />
					<span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline"></i></span>
					<span class="um-field-checkbox-option"><?php echo __('I\'m followed by someone new','um-followers'); ?></span>
				</label>
					
				<?php } else { ?>
					
				<label class="um-field-checkbox">
					<input type="checkbox" name="_enable_new_follow" value="1" />
					<span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline-blank"></i></span>
					<span class="um-field-checkbox-option"><?php echo __('I\'m followed by someone new','um-followers'); ?></span>
				</label>
					
				<?php } ?>
					
				<div class="um-clear"></div>
				
			</div>
		
		<?php
		
		$output .= ob_get_contents();
		ob_end_clean();

		return $output;
	}