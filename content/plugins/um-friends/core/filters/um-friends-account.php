<?php

	/***
	***	@show mailchimp lists in account
	***/
	add_filter('um_account_content_hook_notifications', 'um_friends_account_tab', 50 );
	function um_friends_account_tab( $output ){
		global $um_friends;

		ob_start();
		
		$_enable_new_friend = $um_friends->api->enabled_email( get_current_user_id() );
		
		$fields['_enable_new_friend'] = array(
			'meta_key' => '_enable_new_friend'
		);
		$fields = apply_filters('um_account_secure_fields', $fields, 'notifications' );
		?>
		
			<div class="um-field-area">
				
				<?php if ( $_enable_new_friend ) { ?>
					
				<label class="um-field-checkbox active">
					<input type="checkbox" name="_enable_new_friend" value="1" checked />
					<span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline"></i></span>
					<span class="um-field-checkbox-option"><?php echo __('I have got a new friend','um-friends'); ?></span>
				</label>
					
				<?php } else { ?>
					
				<label class="um-field-checkbox">
					<input type="checkbox" name="_enable_new_friend" value="1" />
					<span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline-blank"></i></span>
					<span class="um-field-checkbox-option"><?php echo __('I have got a new friend','um-friends'); ?></span>
				</label>
					
				<?php } ?>
					
				<div class="um-clear"></div>
				
			</div>
		
		<?php
		
		$output .= ob_get_contents();
		ob_end_clean();

		return $output;
	}