<?php
/**
 * The Instagram API library
 */


global $um_connect_instagram;

/**
 * class UM_Connect_Instagram
 * 
 * @since  1.0.0
 */
class UM_Connect_Instagram {

	/**
	 *  init
	 * 
	 * @since  1.0.0
	 */
	function __construct() {
		
		if ( class_exists('UM_API') ) {
			add_action('template_redirect', array(&$this, 'load'),99);
			
			add_action('template_redirect', array(&$this, 'get_auth'),99);

			add_action('init', array(&$this,'dependencies'));
		}

	}

	function dependencies(){
		if( ! class_exists('Instagram') )
			require_once plugin_dir_path( dirname( __FILE__ ) ) . '../providers/instagram/api/Instagram.php';
	}

	/**
	 * Prepare variables
	 * action hook: template_redirect
	 * 
	 * @since  1.0.0
	 */
	function load() {
		
		global $ultimatemember;
		
		$this->client_id = um_get_option('instagram_photo_client_id');
		$this->client_secret = um_get_option('instagram_photo_client_secret');
		$this->callback_url = site_url('/');
		$this->callback_url = add_query_arg('um-connect-instagram', 'true', $this->callback_url);
		
	
	}

	/**
	 * Get authorization callback response
	 * action hook: template_redirect
	 * 
	 * @since  1.0.0
	 */
	function get_auth() {
		global $ultimatemember, $um_connect_instagram;


		if ( isset($_REQUEST['um-connect-instagram']) && $_REQUEST['um-connect-instagram'] == 'true' && isset($_REQUEST['code']) ) {
			
			session_start();

			$instagram = new Instagram(array(
				'apiKey'      => $this->client_id,
				'apiSecret'   => $this->client_secret,
				'apiCallback' => $this->callback_url
			));
			
			$token = false;
			
			if (isset($_SESSION['insta_access_token'])) {
				
				$token = $_SESSION['insta_access_token'];
				$user = $_SESSION['insta_user'];
				  
			} else {

				$code = $_GET['code'];
				$data = $instagram->getOAuthToken($code);
				$token = $data->access_token;
				$_SESSION['insta_access_token'] = $token;
				$_SESSION['insta_user'] = $data->user;
				
				$user = $_SESSION['insta_user'];
			
			}

			

			if( ! empty( $token ) ){
				$profile_url = add_query_arg('profiletab','main', um_user_profile_url() );
				$profile_url = add_query_arg('um_action','edit', $profile_url );
				$profile_url = add_query_arg('um_ig_code', $code, $profile_url );
				
				wp_redirect( $profile_url );
			}

	
			
		}
		
	}
		
	
	/**
	 * Get Authorization URL
	 * @return string Login url for App authorization
	 * 
	 * @since  1.0.0
	 */
	function connect_url() {
		global $ultimatemember;
		

		$instagram = new Instagram(array(
			'apiKey'      => $this->client_id,
			'apiSecret'   => $this->client_secret,
			'apiCallback' => $this->callback_url
		));
		
		$this->login_url = $instagram->getLoginUrl();
		
		return $this->login_url;
		
	}

	/**
	 * Get current user's access token
	 * @param  string $metakey field meta key
	 * @return string | boolen  returns token strings on success, otherwise return false when empty token
	 * 
	 * @since  1.0.0
	 */
	function get_user_token( $metakey = '', $user_id = 0 ){

		if( um_user('ID') && empty( $user_id ) ){
			$user_id = um_user('ID');
		}
		
		$token = get_user_meta( $user_id, $metakey, true );

		if(  isset( $token ) && ! empty( $token ) || isset( $_REQUEST['um_ig_code'] ) && ! empty(  $_REQUEST['um_ig_code'] ) ||  isset( $_SESSION['insta_access_token'] ) &&  ! empty( $_SESSION['insta_access_token'] ) ) {


			if( isset( $_SESSION['insta_access_token'] ) ){
				$token = $_SESSION['insta_access_token'];
				unset( $_SESSION['insta_access_token'] );
			}
				
			if( $token ){
				
				return $token;
			}
			
		}

		return false;

		
	}
		
}

$um_connect_instagram = new UM_Connect_Instagram();