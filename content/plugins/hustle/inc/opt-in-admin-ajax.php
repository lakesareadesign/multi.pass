<?php
if( !class_exists("Opt_In_Admin_Ajax") ):
/**
 * Class Opt_In_Admin_Ajax
 * Takes care of all the ajax calls to admin pages
 *
 */
class Opt_In_Admin_Ajax {

    private $_hustle;
    private $_admin;

    function __construct( Opt_In $hustle, Opt_In_Admin $admin ){

        $this->_hustle = $hustle;
        $this->_admin = $admin;

        add_action("wp_ajax_render_provider_account_options", array( $this, "render_provider_account_options" ));
        add_action("wp_ajax_refresh_provider_account_details", array( $this, "refresh_provider_account_details" ));
        add_action("wp_ajax_inc_opt_save_new", array( $this, "save_optin" ));
        add_action("wp_ajax_inc_opt_prepare_custom_css", array( $this, "prepare_custom_css" ));
        add_action("wp_ajax_inc_opt_toggle_state", array( $this, "toggle_optin_state" ));
        add_action("wp_ajax_inc_opt_toggle_optin_type_state", array( $this, "toggle_optin_type_state" ));
        add_action("wp_ajax_inc_opt_toggle_type_test_mode", array( $this, "toggle_type_test_mode" ));
        add_action("wp_ajax_inc_opt_delete_optin", array( $this, "delete_optin" ));
        add_action("wp_ajax_inc_optin_get_email_lists", array( $this, "get_subscriptions_list" ));
        add_action("wp_ajax_inc_optin_export_subscriptions", array( $this, "export_subscriptions" ));
        add_action("wp_ajax_persist_new_welcome_close", array( $this, "persist_new_welcome_close" ));
    }

    /**
     * Renders provider account options based on the selected provider ( provider id )
     *
     * @since 1.0
     */
    function render_provider_account_options(){

        Opt_In_Utils::validate_ajax_call( "change_provider_name" );

        $provider_id =  filter_input( INPUT_GET, "provider_id" );

        $optin_id =  filter_input( INPUT_GET, "optin" );

        if( empty( $provider_id ) )  wp_send_json_error( __("Invalid provider", Opt_In::TEXT_DOMAIN) );

        /**
         * @var $provider Opt_In_Provider_Interface
         */
        $provider = Opt_In::get_provider_by_id( $provider_id );
        $is_allowed = $this->_is_provider_allowed_to_run( $provider );
        if( is_wp_error( $is_allowed )  ){
            wp_send_json_error( $is_allowed->get_error_messages() );
        }

        $provider = Opt_In::provider_instance( $provider );

        $options = $provider->is_authorized() ? $provider->get_account_options( $optin_id ) : $provider->get_options();

        $html = "";
        foreach( $options as $key =>  $option ){
            $html .= $this->_hustle->render("general/option", array_merge( $option, array( "key" => $key ) ), true);
        }

        wp_send_json_success( $html );
    }

    /**
     * Refreshes provider account details after the account creds are added and submitted
     *
     * @since 1.0
     */
    function refresh_provider_account_details(){

        Opt_In_Utils::validate_ajax_call( "refresh_provider_details" );

        $provider_id =  filter_input( INPUT_POST, "optin_new_provider_name" );

        $optin_id =  filter_input( INPUT_POST, "optin" );

        if( empty( $provider_id ) )  wp_send_json_error( __("Invalid provider", Opt_In::TEXT_DOMAIN) );

        $api_key =  filter_input( INPUT_POST, "optin_api_key" );
        /**
         * @var $provider Opt_In_Provider_Interface
         */
        $provider = Opt_In::get_provider_by_id( $provider_id );

        /**
         * @var $provider Opt_In_Provider_Abstract
         */
        $provider = Opt_In::provider_instance( $provider );

        $provider->set_arg( "api_key", $api_key );

        if( filter_input( INPUT_POST, "optin_secret_key" ) )
            $provider->set_arg( "secret", filter_input( INPUT_POST, "optin_secret_key" ) );
        if( filter_input( INPUT_POST, "optin_username" ) )
            $provider->set_arg( "username", filter_input( INPUT_POST, "optin_username" ) );

        if( filter_input( INPUT_POST, "optin_account_name" ) )
            $provider->set_arg( "account_name", filter_input( INPUT_POST, "optin_account_name" ) );

        if( filter_input( INPUT_POST, "optin_url" ) )
            $provider->set_arg( "url", filter_input( INPUT_POST, "optin_url" ) );

        $options = $provider->get_options( $optin_id );

        if( !empty( $options ) )
            $provider->update_option( Opt_In::get_const( $provider, 'LISTS' ), serialize( $options ) );


        if( !is_wp_error( $options ) ){
            $html = "";

            foreach( $options as $key =>  $option ){
                $html .= $this->_hustle->render("general/option", array_merge( $option, array( "key" => $key ) ), true);
            }

            wp_send_json_success( $html );
        }else{
            /**
             * @var WP_Error $options
             */
            wp_send_json_error( implode( "<br/>", $options->get_error_messages() ) );
        }

    }

    /**
     * Prepares the custom css string for the live previewer
     *
     * @since 1.0
     */
    function prepare_custom_css(){

        Opt_In_Utils::validate_ajax_call( "inc_opt_prepare_custom_css" );

        $_POST = stripslashes_deep( $_POST );
        if( !isset($_POST['css'] ) ) {
            wp_send_json_error();
        }

        $cssString = $_POST['css'];

        $styles = Opt_In::prepare_css($cssString, ".wph-preview--holder");

        $optin_id = isset( $_POST['optin_id'] ) ? (int) $_POST['optin_id'] : false;

        if( !empty($optin_id) ){
            $optin = Opt_In_Model::instance()->get( $optin_id );
            $design = $optin->design->to_object();
            $design->css = $cssString;
            $optin->update_meta( $this->_hustle->get_const_var(  "KEY_DESIGN", $optin ),  $design );
        }

        wp_send_json_success( $styles );
    }

    /**
     * Saves new optin to db
     *
     * @since 1.0
     */
    function save_optin(){

        Opt_In_Utils::validate_ajax_call( "hustle_save_optin" );

        $_POST = stripslashes_deep( $_POST );
        if( "-1" === $_POST['id']  )
            $res = $this->_admin->save_new( $_POST );
        else
            $res = $this->_admin->update_optin( $_POST );

        wp_send_json( array(
            "success" =>  $res === false ? false: true,
            "data" => $res
        ) );
    }


    /**
     * Toggles optin active state
     *
     * @since 1.0
     */
    function toggle_optin_state(){

        Opt_In_Utils::validate_ajax_call( "inc_opt_toggle_state" );

        $id = filter_input( INPUT_POST, 'id', FILTER_VALIDATE_INT );

        if( !$id )
            wp_send_json_error(__("Invalid Request", Opt_In::TEXT_DOMAIN));

        $result = Opt_In_Model::instance()->get($id)->toggle_state();

        if( $result )
            wp_send_json_success( __("Successful") );
        else
            wp_send_json_error( __("Failed") );
    }

    /**
     * Toggles optin type active state
     *
     * @since 1.0
     */
    function toggle_optin_type_state(){

        Opt_In_Utils::validate_ajax_call( "inc_opt_toggle_optin_type_state" );

        $id = filter_input( INPUT_POST, 'id', FILTER_VALIDATE_INT );
        $type = trim( filter_input( INPUT_POST, 'type', FILTER_SANITIZE_STRING ) );

        if( !$id || !$type )
            wp_send_json_error(__("Invalid Request", Opt_In::TEXT_DOMAIN));



        if( !is_object( Opt_In_Model::instance()->get($id)->settings->{$type} ) )
            wp_send_json_error(__("Invalid environment: " . $type, Opt_In::TEXT_DOMAIN));

        $result = Opt_In_Model::instance()->get($id)->toggle_state( $type );

        if( $result && !is_wp_error( $result ) )
            wp_send_json_success( __("Successful") );
        else
            wp_send_json_error( $result->get_error_message() );
    }

    /**
     * Toggles optin type test mode
     *
     * @since 1.0
     */
    function toggle_type_test_mode(){

        Opt_In_Utils::validate_ajax_call( "inc_opt_toggle_type_test_mode" );

        $id = filter_input( INPUT_POST, 'id', FILTER_VALIDATE_INT );
        $type = trim( filter_input( INPUT_POST, 'type', FILTER_SANITIZE_STRING ) );

        if( !$id || !$type )
            wp_send_json_error(__("Invalid Request", Opt_In::TEXT_DOMAIN));


        if( !is_object( Opt_In_Model::instance()->get($id)->settings->{$type} ) )
            wp_send_json_error(__("Invalid environment: " . $type, Opt_In::TEXT_DOMAIN));

        $result = Opt_In_Model::instance()->get($id)->toggle_type_test_mode( $type );

        if( $result && !is_wp_error( $result ) )
            wp_send_json_success( __("Successful") );
        else
            wp_send_json_error( $result->get_error_message() );
    }

    /**
     * Delete optin
     */
    function delete_optin(){

        Opt_In_Utils::validate_ajax_call( "inc_opt_delete_optin" );

        $id = filter_input( INPUT_POST, 'id', FILTER_VALIDATE_INT );

        if( !$id )
            wp_send_json_error(__("Invalid Request", Opt_In::TEXT_DOMAIN));

        $result = Opt_In_Model::instance()->get($id)->delete();

        if( $result )
            wp_send_json_success( __("Successful") );
        else
            wp_send_json_error( __("Failed") );
    }

    /**
     * Checks conditions required to run given provider
     *
     * @param $provider
     * @return bool|WP_Error
     */
    private function _is_provider_allowed_to_run($provider ){
        $err = new WP_Error();
        if( 'Opt_In_ConstantContact' === $provider && version_compare( PHP_VERSION, '5.3', '<' ) ){
            $err->add("Constant Contact Not Allowed", __("This provider requires PHP5.3+ and can't be used with current server. Please upgrade to use this provider.", Opt_In::TEXT_DOMAIN) );
            return $err;
        }

        return true;
    }

    /**
     * Retrieves the subscription list from db
     *
     *
     * @since 1.1.0
     */
    function get_subscriptions_list(){
        Opt_In_Utils::validate_ajax_call("wpoi_get_emails_list");

        $id = filter_input( INPUT_GET, 'id', FILTER_VALIDATE_INT );

        if( !$id )
            wp_send_json_error(__("Invalid Request", Opt_In::TEXT_DOMAIN));

        $subscriptions = Opt_In_Model::instance()->get($id)->get_local_subscriptions();

        if( $subscriptions )
            wp_send_json_success( array(
                "subscriptions" => $subscriptions
            ) );
        else
            wp_send_json_error( __("Failed to fetch subscriptions", Opt_In::TEXT_DOMAIN) );
    }

	/**
     * Save persistent choice of closing new welcome notice on dashboard
     *
     * @since 2.0.2
     */
	function persist_new_welcome_close() {
		Opt_In_Utils::validate_ajax_call( "hustle_new_welcome_notice" );
		update_option("hustle_new_welcome_notice_dismissed", true);
		wp_send_json_success();
	}


    function export_subscriptions(){
        Opt_In_Utils::validate_ajax_call( 'inc_optin_export_subscriptions' );

        $id = filter_input( INPUT_GET, 'id', FILTER_VALIDATE_INT );

        if( !$id )
            die(__("Invalid Request", Opt_In::TEXT_DOMAIN));

        $optin = Opt_In_Model::instance()->get($id);
        $subscriptions = $optin->get_local_subscriptions();
        $csv = sprintf("%s, %s, %s, %s",
                __("First Name", Opt_In::TEXT_DOMAIN),
                __("Last Name", Opt_In::TEXT_DOMAIN),
                __("Email", Opt_In::TEXT_DOMAIN),
                __("Type", Opt_In::TEXT_DOMAIN)
            ) . "\n";


        foreach( $subscriptions as $row ){
            $csv .= sprintf("%s, %s, %s, %s", $row->f_name, $row->l_name, $row->email, $row->optin_type) . "\n";
        }

        $file_name = strtolower( sanitize_file_name( $optin->optin_name ) ) . ".csv";

        header("Content-type: application/x-msdownload",true,200);
        header("Content-Disposition: attachment; filename=$file_name");
        header("Pragma: no-cache");
        header("Expires: 0");
        echo $csv;
        die();

    }

}
endif;