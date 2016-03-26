<?php

require um_social_login_path . 'providers/twitter/api/autoload.php';
use Abraham\TwitterOAuth\TwitterOAuth;

class UM_Social_Login_Twitter {

	function __construct() {
		
		add_action('init', array(&$this, 'load'));
		
		add_action('init', array(&$this, 'get_auth'));

	}

	/***
	***	@load
	***/
	function load() {
		global $um_social_login, $ultimatemember;
		
		$this->consumer_key = trim( um_get_option('twitter_consumer_key') );
		$this->consumer_secret = trim( um_get_option('twitter_consumer_secret') );
		$this->oauth_callback = $um_social_login->get_redirect_url();
		$this->oauth_callback = add_query_arg( 'provider', 'twitter', $this->oauth_callback );
		$this->oauth_callback = remove_query_arg( 'oauth_token', $this->oauth_callback );
		$this->oauth_callback = remove_query_arg( 'oauth_verifier', $this->oauth_callback );
	}

	/***
	***	@Get auth
	***/
	function get_auth() {
		global $um_social_login;
		
		if ( isset($_REQUEST['provider']) && $_REQUEST['provider'] == 'twitter' && isset($_REQUEST['oauth_token']) && isset($_REQUEST['oauth_verifier']) ) {
				

				if( ! isset( $_SESSION['tw_access_token'] ) ){
					try{ 
						$request_token['oauth_token'] = $_SESSION['tw_oauth_token'];
						$request_token['oauth_token_secret'] = $_SESSION['tw_oauth_token_secret'];
						
						$connection = new TwitterOAuth( $this->consumer_key, $this->consumer_secret,$request_token['oauth_token'] , $request_token['oauth_token_secret']);
						$access_token = $connection->oauth("oauth/access_token", array("oauth_verifier" => $_REQUEST['oauth_verifier'], "oauth_callback" => $this->oauth_callback ));
						$_SESSION['tw_access_token'] = $access_token;

					}catch(Exception $e ){
						wp_die( 'UM Social Login - Twitter Access Token: '.$e->getMessage().' - '.$this->oauth_callback,'UM Social Login - Twitter Error', array('back_link' => true ) );
					}
				}

				if( isset( $_SESSION['tw_access_token'] ) ){
					try{ 
						
						$access_token = $_SESSION['tw_access_token'];
						$connection = new TwitterOAuth( $this->consumer_key, $this->consumer_secret, $access_token['oauth_token'], $access_token['oauth_token_secret']);
						$profile = $connection->get("account/verify_credentials");
						$profile = json_decode(json_encode($profile), true);

					}catch(Exception $e ){
						wp_die( 'UM Social Login - Twitter Verify Credentials: '.$e->getMessage().' - '.$this->oauth_callback,'UM Social Login - Twitter Error', array('back_link' => true ) );
					}
				}

				
				if( isset($profile['errors']) && count($profile['errors']) > 0 ){
					wp_die( 'UM Social Login - Twitter SDK Error: '.$profile['errors'][0]['message'].' - '.$this->oauth_callback,'UM Social Login - Twitter Error', array('back_link' => true ) );
				}

				$name = $profile['name'];
				$name = explode(' ', $name);
				
				// prepare the array that will be sent
				$profile['username'] = $profile['screen_name'];
				$profile['user_login'] = $profile['screen_name'];
				$profile['first_name'] = $name[0];
				$profile['last_name'] = $name[1];

				// username/email exists
				$profile['email_exists'] = '';
				$profile['username_exists'] = '';
				
				// provider identifier
				$profile['_uid_twitter'] = $profile['id'];
				
				if ( isset( $profile['profile_image_url'] ) && strstr( $profile['profile_image_url'], '_normal' ) ) {
					$profile['_save_synced_profile_photo'] = str_replace('_normal','',$profile['profile_image_url']);
				}
				
				$profile['_save_twitter_handle'] = '@' . $profile['screen_name'];
				$profile['_save_twitter_link'] = 'https://twitter.com/' . $profile['screen_name'];
				$profile['_save_twitter_photo_url_dyn'] = $profile['profile_image_url'];

				// have everything we need?
				$um_social_login->resume_registration( $profile, 'twitter' );
			
			
		}
		
	}
		
	/***
	***	@get login uri
	***/
	function login_url() {
		global $ultimatemember;
		
		if( ! isset($_REQUEST['oauth_token']) && ! isset($_REQUEST['oauth_verifier'])  ){

			if( ! is_user_logged_in() ){
				unset( $_SESSION['tw_access_token'] );
			}

			try{
				$connection = new TwitterOAuth( $this->consumer_key, $this->consumer_secret );
				$request_token = $connection->oauth('oauth/request_token', array('oauth_callback' => trim($this->oauth_callback) ));
				
				
					$_SESSION['tw_oauth_token'] = $request_token['oauth_token'];
					$_SESSION['tw_oauth_token_secret'] = $request_token['oauth_token_secret'];
				
				if( $connection->getLastHttpCode() ==200 ){
					$this->login_url = $connection->url('oauth/authenticate', array('oauth_token' => $request_token['oauth_token']));
				}else{
					$this->login_url = '?error=400';
				}

			} catch (Exception $e) {
					$this->login_url = '?error_message='.$e->getMessage();

			}
		}
		return $this->login_url;
		
	}
		
}