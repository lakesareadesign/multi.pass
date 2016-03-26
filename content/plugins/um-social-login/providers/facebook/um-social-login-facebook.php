<?php
require_once um_social_login_path . 'providers/facebook/api/autoload.php';

class UM_Social_Login_Facebook {

	function __construct() {

		add_action('init', array(&$this, 'load'));

		add_action('init', array(&$this, 'get_auth'));

	}

	/***
	***	@load
	***/
	function load() {
		global $um_social_login, $ultimatemember;

		$app_id = ( um_get_option('facebook_app_id') ) ? um_get_option('facebook_app_id') : 'APP_ID';
		$app_secret = ( um_get_option('facebook_app_secret') ) ? um_get_option('facebook_app_secret') : 'APP_SECRET';

		$this->app_id             	= trim( $app_id );
		$this->app_secret         	= trim( $app_secret );
		$this->required_scope     	= 'public_profile, email';
		$this->redirect_url 		= $um_social_login->get_redirect_url();
		$this->redirect_url 		= add_query_arg('provider', 'facebook', $this->redirect_url);
		$this->redirect_url 		= remove_query_arg('code',  $this->redirect_url);
		$this->redirect_url 		= remove_query_arg('state',  $this->redirect_url);
		$this->login_url		  	= '';

	}

	/***
	***	@Get auth
	***/
	function get_auth() {
		global $um_social_login, $ultimatemember;

		if (  isset( $_REQUEST['provider'] ) && $_REQUEST['provider'] == 'facebook' ) {
			

			if( $this->is_session_started() === FALSE ){
				session_start();
			}

			// Initialize the Facebook PHP SDK v5.
			$fb = new Facebook\Facebook([
			  'app_id'                => $this->app_id,
			  'app_secret'            => $this->app_secret,
			  'default_graph_version' => 'v2.2',
			  'persistent_data_handler'=>'session',
			]);

			if( ! isset( $_POST ) && empty(  $_POST  ) ||  empty(  $_SESSION['facebook_access_token'] ) ){
				$helper = $fb->getRedirectLoginHelper();

				try {
				  $accessToken = $helper->getAccessToken();
				} catch(Facebook\Exceptions\FacebookResponseException $e) {
					wp_die( 'UM Social Login - Facebook: Graph returned an error: '.$e->getMessage(),'UM Social Login - Facebook Error', array('back_link' => true ) );
				} catch(Facebook\Exceptions\FacebookSDKException $e) {
					wp_die( 'UM Social Login - Facebook: SDK returned an error: '.$e->getMessage(),'UM Social Login - Facebook Error', array('back_link' => true ) );
				}

			}

			if ( ! isset( $accessToken ) ){
				$accessToken = $_SESSION['facebook_access_token'];
			}

			if (isset($accessToken)) {
				$_SESSION['facebook_access_token'] = (string) $accessToken;
				$fb->setDefaultAccessToken( $accessToken );
				$res = $fb->get('/me?fields=id,name,email,link');
				$profile = $res->getGraphObject()->asArray();

				
				if ( isset( $profile['name'] ) && $profile['name'] ) {
					$name = $profile['name'];
					$name = explode(' ', $name);
					$profile['first_name'] = $name[0];
					$profile['last_name'] = $name[1];
				}

				$profile_email = isset( $profile['email'] )? $profile['email'] : '';

				// prepare the array that will be sent
				$profile['user_email'] = $profile_email;

				// username/email exists
				$profile['email_exists'] = $profile_email;
				$profile['username_exists'] = $profile['id'];
				
				if( empty( $profile_email ) &&  empty( $_POST ) ){
					$ultimatemember->form->add_error( 'user_email' , __('The email field was not returned. This may be because the email was missing, invalid or hasn\'t been confirmed.') );
						
				}
				
				// provider identifier
				$profile['_uid_facebook'] = $profile['id'];

				$profile['_save_synced_profile_photo'] = 'http://graph.facebook.com/'.$profile['id'].'/picture?width=200&height=200';
				$profile['_save_facebook_handle'] = $profile['name'];
				$profile['_save_facebook_link'] = $profile['link'];

				// have everything we need?
				$um_social_login->resume_registration( $profile, 'facebook' );

			}

		}

		unset( $_SESSION['um_session_fb_signed'] );

	}

	/***
	***	@get login uri
	***/
	function login_url() {
		global $ultimatemember;

		if( ! isset( $_REQUEST['provider'] ) && $_REQUEST['provider'] !== 'facebook' && ! isset( $_SESSION['um_session_fb_signed'] ) ){
			
			
			if( $this->is_session_started() === FALSE ){
				session_start();
			}

			$fb = new Facebook\Facebook([
				  'app_id'                => $this->app_id,
				  'app_secret'            => $this->app_secret,
				  'default_graph_version' => 'v2.2',
				  'persistent_data_handler'=>'session',
			]);
			$helper = $fb->getRedirectLoginHelper();
			$permissions = array( 'public_profile','email' ); // optional
			$callback = $this->redirect_url;
			$this->login_url = $helper->getLoginUrl($callback, $permissions);

			$_SESSION['um_session_fb_signed'] = true;

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
