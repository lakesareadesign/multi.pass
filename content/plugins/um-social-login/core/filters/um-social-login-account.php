<?php

	/***
	***	@custom error
	***/
	add_filter('um_custom_error_message_handler', 'um_social_login_custom_error', 10, 2 );
	function um_social_login_custom_error( $msg, $err_t ) {
		global $um_social_login;
		$providers = $um_social_login->available_networks();
		
		foreach( $providers as $key => $info ) {
			if ( strstr( $err_t, $key ) && $err_t == $key . '_exist' ) {
				$msg = sprintf(__(' This %s account is already linked to another user.','um-social-login'), $info['name']);
			}
		}
		return $msg;
	}
	
	/***
	***	@sync user profile photo
	***/
	add_filter('um_user_avatar_url_filter', 'um_social_login_synced_profile_photo', 100, 2 );
	function um_social_login_synced_profile_photo( $url, $user_id ) {
		if ( get_user_meta( $user_id, 'synced_profile_photo', true ) ) {
			$url = get_user_meta( $user_id, 'synced_profile_photo', true );
			// ssl enabled?
			if ( is_ssl() && !strstr( $url, 'vk.me' ) ) {
				$url = str_replace('http://','https://', $url );
			}
		}
		return $url;
	}
	
	/***
	***	@add tab to account page
	***/
	add_filter('um_account_page_default_tabs_hook', 'um_social_login_account_tab', 100 );
	function um_social_login_account_tab( $tabs ) {

		$tabs[450]['social']['icon'] = 'um-faicon-sign-in';
		$tabs[450]['social']['title'] = __('Social Connect','um-social-login');

		return $tabs;
	}
	
	/***
	***	@display tab "Social"
	***/
	add_action('um_account_tab__social', 'um_account_tab__social');
	function um_account_tab__social( $info ) {
		global $ultimatemember;
		extract( $info );
		
		$output = $ultimatemember->account->get_tab_output('social');
		
		if ( $output ) { ?>
		
		<div class="um-account-heading uimob340-hide uimob500-hide"><i class="<?php echo $icon; ?>"></i><?php echo $title; ?></div>
		
		<?php echo $output; ?>

		<?php
		
		}
	}

	/***
	***	@add content to account tab
	***/
	add_filter('um_account_content_hook_social', 'um_account_content_hook_social');
	function um_account_content_hook_social( $output ){
		global $um_social_login;
		
		ob_start();
		
		$user_id = get_current_user_id();
		
		// important to only show available networks
		$providers = $um_social_login->available_networks();
		
		?>
		
		<div class="um-field" data-key="">
	
			<?php foreach( $providers as $provider => $array ) { ?>
			
			<div class="um-provider">
				
				<div class="um-provider-title">
					<?php printf(__('Connect to %s','um-social-login'), $array['name']); ?>
					<?php do_action('um_social_login_after_provider_title', $provider, $array); ?>
				</div>
				
				<div class="um-provider-conn">
				
					<?php if ( $um_social_login->is_connected( $user_id, $provider ) ) { ?>
					
						<?php if ( $um_social_login->get_user_photo( $user_id, $provider ) ) { ?>
						
						<div class="um-provider-user-photo"><a href="<?php echo get_user_meta( $user_id, $providers[$provider]['sync']['link'], true ); ?>" target="_blank" title="<?php echo get_user_meta( $user_id, $providers[$provider]['sync']['handle'], true ); ?>"><img src="<?php echo $um_social_login->get_user_photo( $user_id, $provider ); ?>" class="um-provider-photo small" /></a></div>
						
						<?php } else if ( $um_social_login->get_dynamic_user_photo( $user_id, $provider ) ) { ?>
						
						<div class="um-provider-user-photo"><a href="<?php echo get_user_meta( $user_id, $providers[$provider]['sync']['link'], true ); ?>" target="_blank" title="<?php echo get_user_meta( $user_id, $providers[$provider]['sync']['handle'], true ); ?>"><img src="<?php echo $um_social_login->get_dynamic_user_photo( $user_id, $provider ); ?>" class="um-provider-photo small" /></a></div>
						
						<?php } ?>
						
						<div class="um-provider-user-handle"><a href="<?php echo get_user_meta( $user_id, $providers[$provider]['sync']['link'], true ); ?>" target="_blank"><?php echo get_user_meta( $user_id, $providers[$provider]['sync']['handle'], true ); ?></a></div>
						
						<div class="um-provider-disconnect">(<a href="<?php echo $um_social_login->disconnect_url( $provider ); ?>">Disconnect</a>)</div>
					
					<?php } else { ?>
					
						<a title="<?php printf(__('Connect to %s','um-social-login'), $array['name']); ?>" href="<?php echo $um_social_login->login_url( $provider ); ?>" class="um-social-btn um-social-btn-<?php echo $provider; ?>"><i class="<?php echo $array['icon']; ?>"></i><?php printf(__('Connect to %s','um-social-login'), $array['name']); ?></a>
					
					<?php } ?>
					
				</div>
				
				<div class="um-clear"></div>
			
			</div>
			
			<?php } ?>
			
		</div>		
		
		<?php
		
		$output .= ob_get_contents();
		ob_end_clean();

		return $output;
	}