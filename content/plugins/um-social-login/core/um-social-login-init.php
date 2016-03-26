<?php

class UM_Social_Login_API {

	function __construct() {

		$this->plugin_inactive = false;
		
		$this->show_overlay = false;
		
		add_action('init', array(&$this, 'plugin_check'), 1);
		
		add_action('init', array(&$this, 'init'), 1);
		
		add_action('init', array(&$this, 'disconnect'), 1);
		
		add_action('wp_footer', array(&$this, 'show_registration'), 9999 );

	}
	
	/***
	***	@Check plugin requirements
	***/
	function plugin_check() {

		if ( !class_exists('UM_API') ) {
			
			$this->add_notice( sprintf(__('The <strong>%s</strong> extension requires the Ultimate Member plugin to be activated to work properly. You can download it <a href="https://wordpress.org/plugins/ultimate-member">here</a>','um-social-login'), um_social_login_extension) );
			$this->plugin_inactive = true;
		
		} else if ( !version_compare( ultimatemember_version, um_social_login_extension, '>=' ) ) {
			
			$this->add_notice( sprintf(__('The <strong>%s</strong> extension requires a <a href="https://wordpress.org/plugins/ultimate-member">newer version</a> of Ultimate Member to work properly.','um-social-login'), um_social_login_extension) );
			$this->plugin_inactive = true;
		
		} else if ( phpversion() < 5.4 ) {
			
			$this->add_notice( sprintf(__('The social extension requires <strong>PHP 5.4 or better</strong> installed on your server.','um-social-login'), um_social_login_extension) );
			$this->plugin_inactive = true;
		
		}
		
	}
	
	/***
	***	@Add notice
	***/
	function add_notice( $msg ) {
		
		if ( !is_admin() ) return;
		
		echo '<div class="error"><p>' . $msg . '</p></div>';
		
	}
	
	/***
	***	@disconnect from a provider
	***/
	function disconnect_url( $provider ) {
		$url = get_bloginfo('url');
		$url = add_query_arg('disconnect',$provider, $url);
		$url = add_query_arg('uid', um_user('ID'), $url );
		
		return $url;
	}
	
	/***
	***	@Get user photo
	***/
	function get_user_photo( $user_id, $provider ) {
		$providers = $this->networks;
		$url = false;
		if ( isset( $providers[$provider]['sync']['photo_url'] ) ) {
			$url = $providers[$provider]['sync']['photo_url'];
			$url = str_replace('{id}', get_user_meta( $user_id, '_uid_'.$provider, true ), $url );
			if ( is_ssl() ) {
				$url = str_replace('http://','https://', $url );
			}
		}
		return $url;
	}
	
	/***
	***	@Get dynamic user photo
	***/
	function get_dynamic_user_photo( $user_id, $provider ) {
		$providers = $this->networks;
		$url = false;
		if ( isset( $providers[$provider]['sync']['photo_url_dyn'] ) ) {
			$url = um_user( $providers[$provider]['sync']['photo_url_dyn'] );
			if ( is_ssl() ) {
				$url = str_replace('http://','https://', $url );
			}
		}
		return $url;
	}
	
	/***
	***	@Disconnects a user from network
	***/
	function disconnect() {
		global $ultimatemember;
		if ( !isset($_REQUEST['disconnect']) ) return;
		if ( get_current_user_id() != $_REQUEST['uid'] ) die('Ehh! hacking?');
		
		$provider = $_REQUEST['disconnect'];	
		
		$networks = $this->networks;
		foreach( $networks[$provider]['sync'] as $k => $v ) {
			delete_user_meta( $_REQUEST['uid'], $k );
		}
		
		delete_user_meta( $_REQUEST['uid'], '_uid_'. $provider );
		
		do_action("um_social_login_after_disconnect", $provider, $_REQUEST['uid'] );
		do_action("um_social_login_after_{$provider}_disconnect", $_REQUEST['uid'] );
		
		exit( wp_redirect( $ultimatemember->account->tab_link('social') ) );
	}
	
	/***
	***	@Init
	***/
	function init() {

		if ( $this->plugin_inactive ) return;
		
		if (function_exists('session_status')) {
			if (session_status() == PHP_SESSION_NONE) {
				session_start();
			}
		} else {
			if(session_id() == '') {
				session_start();
			}
		}
		
		// Core
		require_once um_social_login_path . 'core/um-social-login-install.php';
		require_once um_social_login_path . 'core/um-social-login-enqueue.php';
		require_once um_social_login_path . 'core/um-social-login-admin.php';
		require_once um_social_login_path . 'core/um-social-login-taxonomies.php';
		require_once um_social_login_path . 'core/um-social-login-metabox.php';
		require_once um_social_login_path . 'core/um-social-login-shortcode.php';
		
		$this->install = new UM_Social_Login_Install();
		$this->styles = new UM_Social_Login_Enqueue();
		$this->admin = new UM_Social_Login_Admin();
		$this->taxonomies = new UM_Social_Login_Taxonomies();
		$this->metabox = new UM_Social_Login_Metabox();
		$this->shortcode = new UM_Social_Login_Shortcode();
		
		// Providers
		require_once um_social_login_path . 'providers/facebook/um-social-login-facebook.php';
		require_once um_social_login_path . 'providers/twitter/um-social-login-twitter.php';
		require_once um_social_login_path . 'providers/google/um-social-login-google.php';
		require_once um_social_login_path . 'providers/linkedin/um-social-login-linkedin.php';
		require_once um_social_login_path . 'providers/instagram/um-social-login-instagram.php';
		require_once um_social_login_path . 'providers/vk/um-social-login-vk.php';
		
		$this->facebook = new UM_Social_Login_Facebook();
		$this->twitter = new UM_Social_Login_Twitter();
		$this->google = new UM_Social_Login_Google();
		$this->linkedin = new UM_Social_Login_LinkedIn();
		$this->instagram = new UM_Social_Login_Instagram();
		$this->vk = new UM_Social_Login_VK();
		
		// Actions
		require_once um_social_login_path . 'core/actions/um-social-login-form.php';
		require_once um_social_login_path . 'core/actions/um-social-login-admin.php';
		
		// Filters
		require_once um_social_login_path . 'core/filters/um-social-login-settings.php';
		require_once um_social_login_path . 'core/filters/um-social-login-account.php';

		$this->networks['facebook'] = array(
			'name' => __('Facebook','um-social-login'),
			'button' => __('Sign in with Facebook','um-social-login'),
			'color' => '#fff',
			'bg' => '#3b5998',
			'bg_hover' => '#324D84',
			'icon' => 'um-faicon-facebook',
			'opts' => array(
				'facebook_app_id' => __('App ID','um-social-login'),
				'facebook_app_secret' => __('App Secret','um-social-login'),
			),
			'sync' => array(
				'handle' => 'facebook_handle',
				'link' => 'facebook_link',
				'photo_url' => 'http://graph.facebook.com/{id}/picture?type=square',
			),
		);
		
		$this->networks['twitter'] = array(
			'name' => __('Twitter','um-social-login'),
			'button' => __('Sign in with Twitter','um-social-login'),
			'color' => '#fff',
			'bg' => '#55acee',
			'bg_hover' => '#4997D2',
			'icon' => 'um-faicon-twitter',
			'opts' => array(
				'twitter_consumer_key' => __('Consumer Key','um-social-login'),
				'twitter_consumer_secret' => __('Consumer Secret','um-social-login'),
			),
			'sync' => array(
				'handle' => 'twitter_handle',
				'link' => 'twitter_link',
				'photo_url_dyn' => 'twitter_photo_url_dyn',
			),
		);
		
		$this->networks['google'] = array(
			'name' => __('Google+','um-social-login'),
			'button' => __('Sign in with Google+','um-social-login'),
			'color' => '#fff',
			'bg' => '#dd4b39',
			'bg_hover' => '#BE4030',
			'icon' => 'um-faicon-google-plus',
			'opts' => array(
				'google_client_id' => __('Client ID','um-social-login'),
				'google_client_secret' => __('Client secret','um-social-login'),
			),
			'sync' => array(
				'handle' => 'google_handle',
				'link' => 'google_link',
				'photo_url_dyn' => 'google_photo_url_dyn',
			),
		);
		
		$this->networks['linkedin'] = array(
			'name' => __('LinkedIn','um-social-login'),
			'button' => __('Sign in with LinkedIn','um-social-login'),
			'color' => '#fff',
			'bg' => '#0976b4',
			'bg_hover' => '#07659B',
			'icon' => 'um-faicon-linkedin',
			'opts' => array(
				'linkedin_api_key' => __('API Key','um-social-login'),
				'linkedin_api_secret' => __('API Secret','um-social-login'),
			),
			'sync' => array(
				'handle' => 'linkedin_handle',
				'link' => 'linkedin_link',
				'photo_url_dyn' => 'linkedin_photo_url_dyn',
			),
		);
		
		$this->networks['instagram'] = array(
			'name' => __('Instagram','um-social-login'),
			'button' => __('Sign in with Instagram','um-social-login'),
			'color' => '#fff',
			'bg' => '#3f729b',
			'bg_hover' => '#4480aa',
			'icon' => 'um-faicon-instagram',
			'opts' => array(
				'instagram_client_id' => __('Client ID','um-social-login'),
				'instagram_client_secret' => __('Client Secret','um-social-login'),
			),
			'sync' => array(
				'handle' => 'instagram_handle',
				'link' => 'instagram_link',
				'photo_url_dyn' => 'instagram_photo_url_dyn',
			),
		);
		
		$this->networks['vk'] = array(
			'name' => __('VK','um-social-login'),
			'button' => __('Sign in with VK','um-social-login'),
			'color' => '#fff',
			'bg' => '#45668e',
			'bg_hover' => '#395f8e',
			'icon' => 'um-faicon-vk',
			'opts' => array(
				'vk_api_key' => __('API Key','um-social-login'),
				'vk_api_secret' => __('API Secret','um-social-login'),
			),
			'sync' => array(
				'handle' => 'vk_handle',
				'link' => 'vk_link',
				'photo_url_dyn' => 'vk_photo_url_dyn',
			),
		);
		
		$this->networks = apply_filters('um_social_login_networks', $this->networks);

	}
	
	/***
	***	@available networks
	***/
	function available_networks() {
		$networks = $this->networks;
		foreach( $networks as $id => $arr ) {
			if (!um_get_option('enable_'.$id))
				unset($networks[$id]);
		}
		$this->networks = $networks;
		return $this->networks;
	}
	
	/***
	***	@number of connected users
	***/
	function count_users( $id ) {
		$args = array( 'fields' => 'ID', 'number' => 0 );
		$args['meta_query'][] = array(array( 'key' => '_uid_' . $id, 'value' => '','compare' => '!='));
		$users = new WP_User_Query( $args );
		return count($users->results);
	}
	
	/***
	***	@Get the complete registration path
	***/
	function get_registration_uri() {
		return trailingslashit( get_bloginfo('url') );
	}
	
	/***
	***	@get login url
	***/
	function login_url( $id ) {
		$login_url = '';
		$login_url = apply_filters("um_social_login_get_authorize_link_{$id}", $login_url );
		if ( !$login_url ) {
			$login_url = $this->{$id}->login_url();
		}
		return $login_url;
	}
	
	/***
	***	@resume registration
	***/
	function resume_registration( $profile, $provider ) {
		global $ultimatemember;

		$this->profile = $profile;
		$_SESSION['um_social_profile'] = $profile;

		if ( is_user_logged_in() ) {
			$this->login( $profile, $provider, 1 );
		}

		$this->login( $profile, $provider );
	}

	/***
	***	@this has to be done after resume registration call
	***/
	function login( $profile, $provider, $logged_in = 0 ) {
		global $ultimatemember;

		// logged-in user
		if ( $logged_in ) { // Account Social connection
			
			$connected = $this->is_previously_connected( $profile, $provider );
			if ( $connected ) {
				
				um_fetch_user( $connected );
				
				$r = $ultimatemember->account->tab_link('social');
				
				if ( $connected != get_current_user_id() ) {
					$r = add_query_arg( 'err', $provider . '_exist', $r );
				}
				
				exit( wp_redirect( $r ) );
			
			} else {
				
				um_fetch_user( get_current_user_id() );
				$this->connect( $profile, $provider );
				exit( wp_redirect( $ultimatemember->account->tab_link('social') ) );
			
			}
		
		// guest
		} else {
			
			$connected = $this->is_previously_connected( $profile, $provider );
			
			if ( $connected ) {
				
				um_fetch_user( $connected );

				$after = um_user('after_login');
				switch( $after ) {
					
					case 'redirect_admin':
						$redirect_to = admin_url();
						break;
						
					case 'redirect_profile':
						$redirect_to = um_user_profile_url();
						break;
					
					case 'redirect_url':
						$redirect_to = um_user('login_redirect_url');
						break;
						
					case 'refresh':
						$redirect_to = $_SERVER['HTTP_REFERER'];
						break;
				}
				do_action( 'um_user_login', $args = array( 'rememberme' => true, 'redirect_to' => $redirect_to ) );
				
			} else if ( $this->user_exists( $profile, $provider ) ) {

				$user_id = $this->user_exists( $profile, $provider );
				
				um_fetch_user( $user_id );
				$this->connect( $profile, $provider );
				
				$after = um_user('after_login');
				switch( $after ) {
					
					case 'redirect_admin':
						$redirect_to = admin_url();
						break;
						
					case 'redirect_profile':
						$redirect_to = um_user_profile_url();
						break;
					
					case 'redirect_url':
						$redirect_to = um_user('login_redirect_url');
						break;
						
					case 'refresh':
						$redirect_to = $_SERVER['HTTP_REFERER'];
						break;
				}
				do_action( 'um_user_login', $args = array( 'rememberme' => true, 'redirect_to' => $redirect_to ) );
				
			} else {
			
				remove_action('um_after_register_fields', 'um_add_submit_button_to_register', 1000);
				
				add_action('um_after_register_fields', array(&$this, 'show_submit_button'), 1000);
				
				add_action('um_after_form_fields', array(&$this, 'show_hidden_inputs'), 1000);

				$this->show_overlay = true;
				
			}
			
		}
	}
	
	/***
	***	@Connect a user
	***/
	function connect( $profile, $provider ) {

		$user_id = get_current_user_id();

		foreach( $profile as $key => $value ) {
			if ( strstr( $key, '_uid_') ) {
				update_user_meta( $user_id , $key, $value );
			}
			if ( strstr( $key, '_save_') ) {
				$key = str_replace('_save_','',$key);
				if ( $key != 'synced_profile_photo' ) {
					update_user_meta( $user_id , $key, $value );
				}
			}
		}
		
		do_action("um_social_login_after_connect", $provider, um_user('ID') );
		do_action("um_social_login_after_{$provider}_connect", um_user('ID') );
		
	}
	
	/***
	***	@Check that user exists but not connected yet
	***/
	function user_exists( $profile, $provider ) {
		if ( email_exists( $profile['email_exists'] ) )
			return email_exists( $profile['email_exists'] );
		if ( username_exists( $profile['username_exists'] ) )
			return username_exists( $profile['username_exists'] );
		return 0;
	}
	
	/***
	***	@Check that user has connected with that provider
	***/
	function is_previously_connected( $profile, $provider ) {
		global $wpdb; 
		$provider_o = '_uid_' . $provider;
		
		if( ! empty( $profile[$provider_o] ) ){
			$user = $wpdb->get_row( $wpdb->prepare(
				'SELECT * FROM '.$wpdb->usermeta.' WHERE meta_key = %s AND meta_value = %s aND meta_value != "" ',
				$provider_o,
				$profile[$provider_o]

			) );
		}

		if ( isset( $user->user_id )  ) {
			return $user->user_id;
		}
		return false;
	}

	/***
	***	@Is connected
	***/
	function is_connected($user_id, $provider) {
		$connection = get_user_meta( $user_id, '_uid_'.$provider, true );
		if ( $connection )
			return true;
		return false;
	}
		
	/***
	***	@add hidden inputs to form
	***/
	function show_hidden_inputs($args) {
		if ( !isset( $this->profile ) ) return;
		foreach( $this->profile as $key => $value ) {
			if ( strstr( $key, '_uid_') ) {
				echo '<input type="hidden" name="'. $key . '" id="' . $key . '" value="' . $value . '" />';
			}
			if ( strstr( $key, '_save_') ) {
				echo '<input type="hidden" name="'. $key . '" id="' . $key . '" value="' . $value . '" />';
			}
		}
	}
	
	/***
	***	@get submit button on form
	***/
	function show_submit_button() {
		?>
		
		<div class="um-col-alt">

			<input type="hidden" name="_social_login_form" id="_social_login_form" value="true" />
			
			<div class="um-center"><input type="submit" value="<?php _e('Complete Registration','um-social-login'); ?>" class="um-button" /></div>

			<div class="um-clear"></div>
			
		</div>
		
		<?php
	}
	
	/***
	***	@load template
	***/
	function load_template( $tpl, $once = false ) {
		$file       = um_social_login_path . 'templates/' . $tpl . '.php';
		$theme_file = get_stylesheet_directory() . '/ultimate-member/templates/social-login/' . $tpl . '.php';

		if( file_exists( $theme_file ) ) {
			$file = $theme_file;
		}

		if( file_exists( $file ) ) {
			if( $once ) {
				require_once $file;
			}
			else {
				require $file;
			}
		}
	}
	
	/***
	***	@show form
	***/
	function show_registration() {
		if ( $this->show_overlay ) {
			$this->load_template('form');
		}
	}
	
	/***
	***	@Get form id
	***/
	function form_id() {
		return get_option('um_social_login_form_installed');
	}
	

	/**
	 * Get redirect url as callback url
	 * @return string
	 */
	function get_redirect_url(){
		global $ultimatemember, $post;

		$redirect_url = $ultimatemember->permalinks->get_current_url();
		$pages = $ultimatemember->permalinks->core;
		$slug = '';

		if( isset( $pages['account'] ) && ! empty( $pages['account'] ) ){
			$post = get_post( $pages['account'] ); 
			$slug = $post->post_name;
		}
		if( ! empty( $slug ) && strpos( $redirect_url, '/'.$slug.'/' ) > -1 ){
			$redirect_url = trailingslashit(um_get_core_page('account').'social');
		}

		if( empty( $redirect_url ) ){
			$redirect_url = $this->get_registration_uri();
		}

		$siteurl = get_bloginfo('siteurl');

		if( strpos( $redirect_url, "www.") <= -1 && strpos($siteurl, "www.") > -1  ){
			if( is_ssl() ){
				$redirect_url = str_replace("https://", "https://www.", $redirect_url);
			}else{
				$redirect_url = str_replace("http://", "http://www.", $redirect_url);
			}
		}

		$redirect_url = remove_query_arg('provider',$redirect_url);
		$redirect_url = remove_query_arg('code',$redirect_url);
		
		return $redirect_url;

	}
}

$um_social_login = new UM_Social_Login_API();