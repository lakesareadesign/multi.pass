<?php

	/***
	***	@add account privacy options
	***/
	add_action('um_after_account_privacy', 'um_messaging_privacy_setting', 10);
	function um_messaging_privacy_setting() {

		$_pm_who_can = get_user_meta( get_current_user_id(), '_pm_who_can', true );
		if ( ! $_pm_who_can ) {
			$_pm_who_can = 'everyone';
		}
		
		$blocked = get_user_meta( get_current_user_id(), '_pm_blocked', true );
		
		?>
		
		<div class="um-field" data-key="">
			
			<div class="um-field-label">
				<label for=""><?php _e('Who can send me private messages?','um-messaging'); ?></label>
				<div class="um-clear"></div>
			</div>
			
			<div class="um-field-area">
			
				<select name="_pm_who_can" id="_pm_who_can" data-validate="" data-key="_pm_who_can" class="um-form-field valid um-s2 " style="width: 100%" data-placeholder="">
					<option value=""></option>
					<option value="everyone" <?php selected('everyone', $_pm_who_can ); ?>><?php _e('Everyone','um-messaging'); ?></option>
					<option value="nobody" 	<?php selected('nobody', $_pm_who_can ); ?>><?php _e('Nobody','um-messaging'); ?></option>
					<?php if ( defined('um_followers_extension') ) { ?>
					<option value="followed"  <?php selected('followed', $_pm_who_can ); ?>><?php _e('Only people I follow','um-messaging'); ?></option>
					<option value="follower"  <?php selected('follower', $_pm_who_can ); ?>><?php _e('Followers','um-messaging'); ?></option>
					<?php } ?>
				</select>
				
				<div class="um-clear"></div>
				
			</div>
			
		</div>
		
		<?php if ( $blocked ) { ?>
		<div class="um-field" data-key="">
		
			<div class="um-field-label">
				<label for=""><?php _e('Blocked Users','um-messaging'); ?></label>
				<div class="um-clear"></div>
			</div>
			
			<div class="um-field-area">
			
				<?php foreach( $blocked as $blocked_user ) {
						if ( !$blocked_user ) continue;
						um_fetch_user( $blocked_user ); ?>
						
				<div class="um-message-blocked">
					<?php echo get_avatar( $blocked_user, 40 ); ?>
					<div><?php echo um_user('display_name'); ?></div>
					<a href="#" class="um-message-unblock" data-user_id="<?php echo $blocked_user; ?>"><?php _e('Unblock','um-messaging'); ?></a>
				</div>
				
				<?php } um_reset_user(); ?>
				
				<div class="um-clear"></div>
				
			</div>
		
		</div>
		<?php } ?>

		<?php
		
	}