<?php

	/***
	***	@add tab to account page
	***/
	add_filter('um_account_page_default_tabs_hook', 'um_notification_account_tab', 100 );
	function um_notification_account_tab( $tabs ) {

		$tabs[445]['webnotifications']['icon'] = 'um-faicon-bell';
		$tabs[445]['webnotifications']['title'] = __('Web notifications','um-notifications');

		return $tabs;
	}
	
	/***
	***	@display tab
	***/
	add_action('um_account_tab__webnotifications', 'um_account_tab__webnotifications');
	function um_account_tab__webnotifications( $info ) {
		global $ultimatemember;
		extract( $info );
		
		$output = $ultimatemember->account->get_tab_output('webnotifications');
		
		if ( $output ) { ?>
		
		<div class="um-account-heading uimob340-hide uimob500-hide"><i class="<?php echo $icon; ?>"></i><?php echo $title; ?></div>
		
		<?php echo $output; ?>
		
		<?php do_action('um_after_account_webnotifications'); ?>

		<div class="um-col-alt um-col-alt-b">
			<div class="um-left"><input type="submit" name="um_account_tab-webnotifications" id="um_account_tab-webnotifications" value="<?php _e('Update Settings','um-notifications'); ?>" class="um-button" /></div>
			<?php do_action('um_after_account_webnotifications_button'); ?>
			<div class="um-clear"></div>
		</div>
		
		<?php
		
		}
	}

	/***
	***	@add content to account tab
	***/
	add_filter('um_account_content_hook_webnotifications', 'um_account_content_hook_webnotifications');
	function um_account_content_hook_webnotifications( $output ){
		global $um_notifications;
		
		ob_start();
		
		$user_id = get_current_user_id();
		
		$logs = $um_notifications->api->get_log_types();
		
		?>
		
		<div class="um-field" data-key="">
			<div class="um-field-label"><strong><?php _e('Receiving Notifications','um-notifications'); ?></strong></div>
			<div class="um-field-area">
			
				<?php foreach( $logs as $key => $array ) { 

					if ( !um_get_option('log_' . $key) ) continue;
					
					$enabled = $um_notifications->api->user_enabled( $key, $user_id );
				
				if ( $enabled ) { // get notified automatically? ?>
					
					<label class="um-field-checkbox active">
						<input type="checkbox" name="um-notifyme[<?php echo $key; ?>]" value="1" checked />
						<span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline"></i></span>
						<span class="um-field-checkbox-option"><?php echo $array['account_desc']; ?></span>
					</label>
					
					<?php } else { ?>
					
					<label class="um-field-checkbox">
						<input type="checkbox" name="um-notifyme[<?php echo $key; ?>]" value="1"  />
						<span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline-blank"></i></span>
						<span class="um-field-checkbox-option"><?php echo $array['account_desc']; ?></span>
					</label>
					
					<?php } ?>
					
				<?php } wp_reset_postdata(); ?>
				
				<div class="um-clear"></div>
				
			</div>
		</div>

		<?php
		
		$output .= ob_get_contents();
		ob_end_clean();

		return $output;
	}