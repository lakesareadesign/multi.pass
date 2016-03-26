<?php

class UM_Social_Login_VK {

	function __construct() {
		
		add_action('init', array(&$this, 'load'));
		
		add_action('init', array(&$this, 'get_auth'));

	}

	/***
	***	@load
	***/
	function load() {
		global $um_social_login, $ultimatemember;
		
		require( um_social_login_path . 'providers/vk/api/VK.php');
		require( um_social_login_path . 'providers/vk/api/VKException.php');
		
		$this->api_key = trim( um_get_option('vk_api_key') );
		$this->api_secret = trim( um_get_option('vk_api_secret') );
		$this->api_settings = 'offline';
		$this->callback_url = $um_social_login->get_redirect_url();
		$this->callback_url = add_query_arg( 'provider', 'vk', $this->callback_url );
		$this->callback_url = remove_query_arg( 'code',  $this->callback_url );
		
	}

	/***
	***	@Get auth
	***/
	function get_auth() {
		global $um_social_login;

		if ( isset($_REQUEST['provider']) && $_REQUEST['provider'] == 'vk' && isset($_REQUEST['code']) ) {
	
			$vk = new VK\VK( $this->api_key, $this->api_secret );
			
			if ( isset( $_SESSION['vk_token'] ) ) {
				$access_token = $_SESSION['vk_token'];
			} else {
				$access_token = $vk->getAccessToken($_REQUEST['code'], $this->callback_url);
				$_SESSION['vk_token'] = $access_token;
			}

			$uid = $access_token['user_id'];
			$token = $access_token['access_token'];

			$profile = $vk->api('users.get', array(
					'user_ids'       	=> $uid,
					'fields'        	=> 'uid, first_name, last_name, nickname, screen_name, photo, photo_big',
					'https'				=> ( is_ssl() ) ? 1 : 0
			));
			
			$profile = $profile['response'][0];
			
			// prepare the array that will be sent
			$profile['username'] = $profile['screen_name'];
			$profile['user_login'] = $profile['screen_name'];
			$profile['first_name'] = $profile['first_name'];
			$profile['last_name'] = $profile['last_name'];

			// username/email exists
			$profile['email_exists'] = '';
			$profile['username_exists'] = '';
				
			// provider identifier
			$profile['_uid_vk'] = $profile['uid'];
				
			if ( isset( $profile['photo_big'] ) ) {
				$profile['_save_synced_profile_photo'] = $profile['photo_big'];
			}
				
			$profile['_save_vk_handle'] = $profile['first_name'] . ' ' . $profile['last_name'];
			$profile['_save_vk_link'] = 'https://vk.com/' . $profile['screen_name'];
			$profile['_save_vk_photo_url_dyn'] = $profile['photo'];
			
			// have everything we need?
			$um_social_login->resume_registration( $profile, 'vk' );
			
		}
		
	}
		
	/***
	***	@get login uri
	***/
	function login_url() {
		global $ultimatemember;
		
		$vk = new VK\VK( $this->api_key, $this->api_secret );
		
		$this->login_url = $vk->getAuthorizeURL( $this->api_settings, $this->callback_url );
		
		return $this->login_url;
		
	}
		
}