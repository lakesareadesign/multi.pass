<?php

class UM_Social_Login_Google {

	function __construct() {
		
		add_action('init', array(&$this, 'load'));
		
		add_action('init', array(&$this, 'get_auth'));

	}

	/***
	***	@load
	***/
	function load() {
		global $um_social_login, $ultimatemember;
		
		require_once um_social_login_path . 'providers/google/autoload.php';
		
		$this->client_id = trim( um_get_option('google_client_id') );
		$this->client_secret = trim( um_get_option('google_client_secret') );
		$this->redirect_uri = $um_social_login->get_redirect_url();
		$this->redirect_uri = remove_query_arg('code', $this->redirect_uri );
		$this->redirect_uri = remove_query_arg('provider', $this->redirect_uri );
		$this->redirect_uri = trim( add_query_arg('provider','google',$this->redirect_uri) );
	}

	/***
	***	@Get auth
	***/
	function get_auth() {
		global $um_social_login;

		if ( isset( $_REQUEST['code'] ) && isset( $_REQUEST['provider'] ) && $_REQUEST['provider'] == 'google' ) {
					
			if( $this->is_session_started() === FALSE ){
				session_start();
			}

			if( ! is_user_logged_in() ){
				unset( $_SESSION['gplus_token']  );
			}

			$client = new Google_Client();
			$client->setAccessType('offline');
			$client->setClientId($this->client_id);
			$client->setClientSecret($this->client_secret);
			$client->setRedirectUri($this->redirect_uri);
			$client->setScopes(array(
			        "https://www.googleapis.com/auth/plus.login",
			        "https://www.googleapis.com/auth/plus.profile.emails.read",
			));
			    
			if(  $client->isAccessTokenExpired() && ! isset( $_SESSION['gplus_access_token'] ) ){
				
				$client->authenticate($_GET['code']);
				
				$accessToken = $client->getAccessToken();
	            
                $_SESSION['gplus_access_token'] = $accessToken;

               

            } else{
            	
            	$accessToken  = $_SESSION['gplus_access_token'];

            }



			try{
					
					
					try{
						$client->setAccessToken( $accessToken );
						$service = new Google_Service_Oauth2($client);
						$profile = $service->userinfo->get();
					}catch(Google_Service_Exception $e){
						wp_die( 'UM Social Login - Google Service Exception: '.$e->getMessage().'<br/> Redirect URI: '.$this->redirect_uri,'UM Social Login - Google Error', array('back_link' => true ) );
					}

			} catch (Google_Auth_Exception $e) {
					wp_die( 'UM Social Login - Google Authenticate Exception: '.$e->getMessage().'<br/> Redirect URI: '.$this->redirect_uri,'UM Social Login - Google Error', array('back_link' => true ) );
			}

			if ( isset( $profile ) ) {

				$profile = json_decode(json_encode($profile), true);

				// prepare the array that will be sent
				$profile['first_name'] = $profile['givenName'];
				$profile['last_name'] = $profile['familyName'];
				$profile['user_email'] = $profile['email'];

				// username/email exists
				$profile['email_exists'] = $profile['email'];
				$profile['username_exists'] = $profile['email'];
					
				// provider identifier
				$profile['_uid_google'] = $profile['id'];
				
				if ( isset( $profile['picture'] ) ) {
					$profile['_save_synced_profile_photo'] = $profile['picture'] . '?sz=200';
				}
				
				$profile['_save_google_handle'] = $profile['name'];
				$profile['_save_google_link'] = $profile['link'];
				$profile['_save_google_photo_url_dyn'] = $profile['picture'] . '?sz=40';
				
				// have everything we need?
				$um_social_login->resume_registration( $profile, 'google' );
			
			}
			
		}

	}
		
	/***
	***	@get login uri
	***/
	function login_url() {
		global $ultimatemember;
		
		if ( ! isset( $_REQUEST['code'] ) && ! isset( $_REQUEST['provider'] ) ) {
			$client = new Google_Client();
			$client->setAccessType('offline');
			$client->setClientId($this->client_id);
			$client->setClientSecret($this->client_secret);
			$client->setRedirectUri($this->redirect_uri);
			$client->addScope("https://www.googleapis.com/auth/userinfo.profile");
			$client->addScope("https://www.googleapis.com/auth/userinfo.email");
			$this->login_url = $client->createAuthUrl();

		}
		return $this->login_url;
		
	}
		
	/**
	 * Checks if session has been started
	 * @return bool
	*/
	function is_session_started(){
		
		if ( php_sapi_name() !== 'cli' ) {
		        if ( version_compare(phpversion(), '5.4.0', '>=') ) {
		            return session_status() === PHP_SESSION_ACTIVE ? TRUE : FALSE;
		        } else {
		            return session_id() === '' ? FALSE : TRUE;
		        }
		}
		
		return FALSE;
	}
}