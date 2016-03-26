<?php

	/***
	***	@custom error
	***/
	add_filter('um_custom_error_message_handler', 'um_mycred_custom_error', 10, 2 );
	function um_mycred_custom_error( $msg, $err ) {
		
		if ( $err == 'mycred_invalid_amount' )
			$msg = __('Invalid amount.','um-mycred');
		
		if ( $err == 'mycred_cant_receive' )
			$msg = __('That user can not receive points.','um-mycred');
		
		if ( $err == 'mycred_invalid_user' )
			$msg = __('The user does not exist.','um-mycred');
		
		if ( $err == 'mycred_not_enough_balance' )
			$msg = __('You do not have enough balance.','um-mycred');
		
		if ( $err == 'mycred_myself' )
			$msg = __('You can not transfer points to yourself.','um-mycred');
		
		if ( $err == 'mycred_unauthorized' )
			$msg = __('You are not allowed to transfer points.','um-mycred');
		
		return $msg;
	}
	
	/***
	***	@add tab to account page
	***/
	add_filter('um_account_page_default_tabs_hook', 'um_mycred_account_tab', 100 );
	function um_mycred_account_tab( $tabs ) {

		$tabs[1000]['points']['icon'] = 'um-faicon-trophy';
		$tabs[1000]['points']['title'] = __('My Points','um-mycred');

		return $tabs;
	}
	
	/***
	***	@display tab "Social"
	***/
	add_action('um_account_tab__points', 'um_account_tab__points');
	function um_account_tab__points( $info ) {
		global $ultimatemember;
		extract( $info );
		
		$output = $ultimatemember->account->get_tab_output('points');
		
		if ( $output ) { ?>
		
		<div class="um-account-heading uimob340-hide uimob500-hide"><i class="<?php echo $icon; ?>"></i><?php echo $title; ?></div>
		
		<?php echo $output; ?>

		<?php
		
		}
	}

	/***
	***	@add content to account tab
	***/
	add_filter('um_account_content_hook_points', 'um_account_content_hook_points');
	function um_account_content_hook_points( $output ){
		global $um_mycred;
		
		ob_start();
		
		$user_id = get_current_user_id();

		?>
		
		<div class="um-field um-mycred-account-col" data-key="">
			<div class="um-field-label"><strong><?php echo __('My Balance','um-mycred'); ?></strong></div>
			<div class="um-field-area">
				<span><?php echo $um_mycred->get_points( $user_id ); ?></span>
			</div>
		</div>
		
		<?php if ( um_user('can_transfer_mycred') ) { ?>
		<div class="um-field um-mycred-account-col" data-key="">
			<div class="um-field-label"><strong><?php echo __('Transfer Balance','um-mycred'); ?></strong></div>
			<div class="um-field-area">
				
				<p><?php printf(__('You can transfer up to %s points to another user.','um-mycred'), $um_mycred->get_points_clean( $user_id ) ); ?></p>
				
				<input type="text" name="mycred_transfer_uid" placeholder="<?php _e('Username, e-mail, or ID','um-mycred'); ?>" class="um-mycred-input" />
				
				<p><?php _e('Enter amount below','um-mycred'); ?></p>
				
				<input type="text" name="mycred_transfer_amount" placeholder="0.00" class="um-mycred-amount" /> <input type="submit" name="um_mycred_transfer" id="um_mycred_transfer" value="<?php _e('Confirm Transfer','um-mycred'); ?>" class="um-mycred-send-points um-button" />
				
				<p><?php _e('This is not reversible once you click confirm transfer.','um-mycred'); ?></p>
				
			</div>
		</div>
		<?php } ?>
		
		<?php if ( um_get_option('mycred_refer') ) { ?>
		
		<div class="um-field um-mycred-account-col" data-key="">
			<div class="um-field-label"><strong><?php _e('My Referral Link','um-mycred'); ?></strong></div>
			<div class="um-field-area">
				<a href="<?php echo do_shortcode('[mycred_affiliate_link url='. get_bloginfo('url') . ']'); ?>" target="_blank"><?php echo do_shortcode('[mycred_affiliate_link url='. get_bloginfo('url') . ']'); ?></a>
			</div>
		</div>
		
		<?php } ?>
		
		<?php
		
		$output .= ob_get_contents();
		ob_end_clean();

		return $output;
	}