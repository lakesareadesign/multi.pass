<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://ultimatemember.com/
 * @since      1.0.0
 *
 * @package    Um_Instagram
 * @subpackage Um_Instagram/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Um_Instagram
 * @subpackage Um_Instagram/admin
 * @author     Ultimate Member <support@ultimatemember.com>
 */
class Um_Instagram_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {


		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/um-instagram-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/um-instagram-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Checks for plugin udpates and license validation
	 * @action_hook 'admin_init'
	 * @since  1.0.0
	 */
	public function plugin_updater(){

		if ( !function_exists( 'um_get_option' ) ) return;
			$item_key = 'um_instagram_license_key';
			$item_status = 'um_Instagram_license_status';
			$product = 'Instagram';
			$license_key = trim( um_get_option( $item_key ) );
			$edd_updater = new EDD_SL_Plugin_Updater( 'https://ultimatemember.com/', __FILE__, array( 
					'version' 	=> '1.0.1',
					'license' 	=> $license_key,
					'item_name' => $product,
					'author' 	=> 'Ultimate Member'
				)
			);

	}

	/**
	 * Register License fields
	 * @param  array $array 
	 * @return array returns registered fields
	 * @since  1.0.0
	 */
	public function license_key( $array ) {
		if ( !function_exists( 'um_get_option' ) ) return;
			$item_key = 'um_instagram_license_key';
			$item_status = 'um_instagram_license_status';
			$product = 'Instagram';
			$array[] = 	array(
					'id'       		=> $item_key,
					'type'     		=> 'text',
					'title'   		=> $product . ' License Key',
					'compiler' 		=> true,
				);
			return $array;
	}

	/**
	 * Validates license
	 * @param  array $options       
	 * @param  array $css            
	 * @param  array $changed_values
	 * @since  1.0.0
	 */
	public function license_status($options, $css, $changed_values) {
		if ( !function_exists( 'um_get_option' ) ) return;
		$item_key = 'um_instagram_license_key';
		$item_status = 'um_instagram_license_status';
		$product = 'Instagram';
		if ( isset( $options[$item_key] ) && isset($changed_values[$item_key]) && $options[$item_key] != $changed_values[$item_key] ) {
			
			if ( $options[$item_key] == '' ) {
				
				$license = trim( $options[$item_key] );
				$api_params = array( 
					'edd_action'=> 'deactivate_license', 
					'license' 	=> $changed_values[$item_key], 
					'item_name' => urlencode( $product ), // the name of our product in EDD
					'url'       => home_url()
				);

				$response = wp_remote_get( add_query_arg( $api_params, 'https://ultimatemember.com/' ), array( 'timeout' => 30, 'sslverify' => false ) );
				if ( is_wp_error( $response ) )
					return false;

				$license_data = json_decode( wp_remote_retrieve_body( $response ) );

				delete_option( $item_status );
				
			} else {
			
				$license = trim( $options[$item_key] );
				$api_params = array( 
					'edd_action'=> 'activate_license', 
					'license' 	=> $license, 
					'item_name' => urlencode( $product ), // the name of our product in EDD
					'url'       => home_url()
				);

				$response = wp_remote_get( add_query_arg( $api_params, 'https://ultimatemember.com/' ), array( 'timeout' => 30, 'sslverify' => false ) );
				if ( is_wp_error( $response ) )
					return false;

				$license_data = json_decode( wp_remote_retrieve_body( $response ) );

				update_option( $item_status, $license_data->license );
				
			}
			
		}
	}

	/**
	 * Register Field with a UM filter hook called 'um_core_fields_hook'
	 * @param  array $core_fields returns built-in fields
	 * @return array     
	 * @since  1.0.0     
	 */
	public function register_builder_field( $core_fields ){
		
		$core_fields['instagram_photo'] =  array(
				'name' => __('Instagram Photos','um-instagram'),
				'col1' => array('_title','_metakey','_help'),
				'col2' => array('_label','_public','_roles','_visibility'),
				'col3' => array('_required','_editable'),
				'validate' => array(
					'_title' => array(
						'mode' => 'required',
						'error' => __('You must provide a title','ultimatemember')
					),
					'_metakey' => array(
						'mode' => 'unique',
					),
				)
		);

		return $core_fields;
	}

	/**
	 * Register API config fields
	 * Filter hook: `redux/options/um_options/sections`
	 * @param  array $sections
	 * @return array
	 * @since  1.0.0
	 */
	public function api_config($sections){


		$main_opts[] = array(
                'id'       		=> 'enable_instagram_photo',
                'type'     		=> 'switch',
                'title'   		=> __( 'Enable Instagram Photos','um-instagram' ),
				'default' 		=> 0,
				'desc' 	   		=> __('Enable/disable the Instagram Photos field in the Form Builder and Profile page','um-instagram'),
				'on'			=> __('On','um-instagram'),
				'off'			=> __('Off','um-instagram'),
        );
		
		$main_opts[] = array(
						'id'       		=> 'instagram_photo_client_id',
						'type'     		=> 'text',
						'title'    		=> 'Client ID',
						'default' 		=> '',
						'required'		=> array( "enable_instagram_photo", '=', '1' ),
		);

		$main_opts[] = array(
						'id'       		=> 'instagram_photo_client_secret',
						'type'     		=> 'text',
						'title'    		=> 'Client Secret',
						'default' 		=> '',
						'required'		=> array( "enable_instagram_photo", '=', '1' ),
		);

		$sections[] = array(
			'subsection' => true,
			'title'      => __( 'Instagram Photos','um-instagram'),
			'fields'     => $main_opts

		);


		return $sections;
	}

}
