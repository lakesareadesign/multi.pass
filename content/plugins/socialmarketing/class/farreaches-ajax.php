<?php

/**
 * Handles communication from the plugin javascript to the wordpress plugin.
 *
 * A ajax callback is registered using:
 * $ajax_call = $this->add_ajax_hook(FarReaches_Ajax_Call object)
 * $ajax_uri_for_use_in_html = $this->get_ajax_uri($ajax_call, array(key => value, ... ))
 *
 * See Notes:
 * http://www.garyc40.com/2010/03/5-tips-for-using-ajax-in-wordpress/#js-global
 * http://codex.wordpress.org/AJAX_in_Plugins
 */
class FarReaches_Ajax extends FarReaches_Util_Using {
    private $ajax_calls;
    private $base_uri;
    const FARREACHES_CB_NONCE = 'farreachesNonce';
    // IMPORTANT: notice that wp uses the 'nopriv_' string as part of the name of the key.
    // wp_ajax_nopriv_<key> for web visitors and wp_ajax_<key> for logged in visitors
    // See: add_ajax_hook
    const WP_NO_PRIV = 'nopriv_';

    const PERMS = 'perms';

    function __construct(FarReaches_Util $farReaches_Util) {
        parent::__construct($farReaches_Util);
        $this->ajax_calls = array();
        $this->base_uri = admin_url('admin-ajax.php');
        $this->add_filter(FarReaches_Ui_Handling::FARREACHES_BROWSER_RESOURCES_FILTER_HOOK, 'filter_browser_resources');
    }

    /**
     * Register the ajax call with the plugin ajax dispatcher
     *
     * @param FarReaches_Ajax_Call $ajax_call
     * @return FarReaches_Ajax_Call ajax call with modified uri
     */
    function add_ajax_hook(FarReaches_Ajax_Call $ajax_call) {
        $ajax_call->set_uri($this->base_uri);
        $this->ajax_calls[$ajax_call->get_call_key()] = $ajax_call;
        $action_str = $ajax_call->get_call_key();
        // IMPORTANT: Notice the magic here. See _unpriv_call()
        if (($ajax_call->is_unprivileged_call())) {
            //  $action_str, the call key, is expected to start with 'nopriv_' so that 'wp_ajax_nopriv_' is the prefix as required by wp
            $this->add_action('wp_ajax_' . self::WP_NO_PRIV . $action_str, 'handle_nopriv_ajax');
        }
        // or user can be logged in
        $this->add_action('wp_ajax_' . $action_str, 'handle_priv_ajax');

        return $ajax_call;
    }

    /**
     * Initial entry point for ajax calls that are privileged ( require a logged in user )
     *
     */
    function handle_priv_ajax() {
        try {
            $ajax_call = $this->_get_requested_ajax_call();
//             $this->debug_log("handle_priv_ajax: ", $ajax_call->get_call_key());
            // HACK - skipping nonce check for now
            // $nonce = FarReaches_Request::get(self::FARREACHES_CB_NONCE);
            // FarReaches_Validate::true(wp_verify_nonce($this->_get_nonce_name($ajax_call)),"BAD NONCE $nonce when calling $ajax_call") ;
            // FarReaches_Validate::true($ajax_call->user_has_perm(), $ajax_call->get_call_key() . " current user can not call this ajax call");

            // Note on nonce validation:
            // As wireserver notifies the plugin with an AJAX call,
            // Nonce wp_verify_nonce() verification should be disabled for wireserver responce flow.
            // It uses non-wordpress key value: see FarReaches_Communication::async_api_call() comments on nonce.
            $log_message = $this->_invoke_user_ajax_func($ajax_call);
        } catch(Exception $exception) {
        	@header('HTTP/1.1 500 Internal Server Error');
    	    //Output so error is not invisible for users.
        	$log_message = FarReaches_Error_Management::error_recovery($exception, __FUNCTION__);
        }
        // IMPORTANT: don't forget to "exit"
        echo $log_message;
        exit(0);
    }

    /**
     * Initial entry point for ajax calls that are UNprivileged ( do NOT require a logged in user )
     *
     */
    function handle_nopriv_ajax() {
        try {
            $ajax_call = $this->_get_requested_ajax_call();
//             $this->debug_log("handle_nopriv_ajax: ", $ajax_call->get_call_key());
            $log_message = $this->_invoke_user_ajax_func($ajax_call);
        } catch(Exception $exception) {
        	@header('HTTP/1.1 500 Internal Server Error');
    	    //Output so error is not invisible for users.
        	$log_message = FarReaches_Error_Management::error_recovery($exception, __FUNCTION__);
        }
        // IMPORTANT: don't forget to "exit"
        echo $log_message;
        exit(0);
    }

    /**
     * get the requested ajax key from the 'action' key.
     * Note that 'action' is used by wordpress to route the message to correct ajax handler. (so key name is fixed)
     */
    private function _get_requested_ajax_call() {
        // Question: there was some discussion about security hole using $_REQUEST rather than $_GET / $_POST but lots of the wp
        // code does use $_REQUEST. need to confirm with Automatic.(wordpress implementors)
        $action = FarReaches_Request::string('action');
        FarReaches_Validate::array_has_key($this->ajax_calls, $action, "No such call '$action'");
        return $this->ajax_calls[$action];
    }

    private function _invoke_user_ajax_func(FarReaches_Ajax_Call $ajax_call) {
        // REFACTOR (Bruno 11 sep) maybe there is a cleaner way to do this (notice the self:: and _get_nonce calls)
        // response output
        $response = $ajax_call->invoke_user_ajax_func();
        // need a new nonce for repeated AJAX calls.
        // PROBLEM (Bruno 25 sep):  this headers might be redundant, try removing the @ of wp_remote_post in communications::api_call and
        // 							some times this will become problematic when you have warnings being printed. In my case, it was echoing the
        //							errors into the ajax (there is an unavoidable warning that i need to get and it comes from api call, so i *have*
        //							to suppress errors or the ajax call will receive garbage on the other side). The function that gave problem is
        //							retry_connection, engaged when you press the 're-connect' button in the welcome screen.
        //							This header error however, only
        //							appears when the @ is taken away of the previously mentioned wp_remote_post. I have no plausible explanation for
        //							that behavior. The error that appears is related to resending headers or writing them after the body starts.
        //							Again, the following lines should be the only ones echoing anything, so i don't really understand the problem
        //							behind the error.
        header("Content-Type: application/json");
        $response[self::FARREACHES_CB_NONCE] = $this->_get_nonce($ajax_call);
        echo json_encode($response);
    }


    /**
     * This method is executed as a WordPress 'FarReaches_Ui_Handling::FARREACHES_BROWSER_RESOURCES_FILTER_HOOK' action handler
     */
    public function filter_browser_resources($js_config) {
        $returned = array_merge($js_config,
                array('ajax' => $this->get_ajax_config())
        );
        return $returned;
    }

    /**
     * TODO: need to generate the javascript automatically
     *     var data = {
    action: 'my_action',
    whatever: 1234
    };

    // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
    // but for unloggedin users..
    jQuery.post(ajaxurl, data, function(response) {
    alert('Got this from the server: ' + response);
    });
     */
    // http://codex.wordpress.org/AJAX_in_Plugins
    private function get_ajax_config() {
        $localization = array();

        // TODO: maybe only generate nonces for calls that the current page can make?
        // or only a single nonce?
        foreach ($this->ajax_calls as $ajax_call) {
            // generate a nonce with a unique ID per $ajax_call
            // so that you can check it later when an AJAX request is sent
            $localization[$ajax_call->get_call_key()] = array(
                'url' => $ajax_call->get_ajax_uri()
            );
            if (!$ajax_call->is_stateless_call()) {
                $localization[$ajax_call['key']]['nonce'] = $this->_get_nonce($ajax_call);
            }
        }
        return $localization;
    }

    function _get_nonce_name($ajax_call) {
        //this function is in the epicenter of the call refactor storm
        // Bruno (sep 11) notice this function is called with things different than ajax calls (or show why i'm wrong, this was the major source
        //		of headaches las time)
        if (is_string($ajax_call)) {
            $nonce_prefix = $ajax_call;
        } elseif ($ajax_call instanceof FarReaches_Ajax_Call) {
            $nonce_prefix = $ajax_call->get_call_key();
        } elseif (is_array($ajax_call)) {
            // HACK: this is the main confusion i had with api calls.
            // This function is a dirty hack entirely, there are several types of objects that use it
            // After isolating the ajax calls we should strive to use conversors that create acceptable
            // homogeneous input for this function instead of making this hide all the nasty because it
            // makes really hard to understand what exactly is calling to get the nonce names...
            // suggestion: the _get_nonce function should instead of being supplied an arbitrary object,
            // it should be supplied what now is the nonce name. That will make this code much easier to
            // understand
            $nonce_prefix = $ajax_call['key'];
        } else {
            throw new Exception("_get_nonce_name: ajax_call variable isn't of type FarReaches_Ajax_Call and isn't a string or array");
        }
        return $nonce_prefix . '-nonce';
    }

    /**
     * Use the name of the ajax call as a part of the name used to generate a wp_create_nonce.
     *
     * WARNING:
     * WP Nonce object has design downsides, please be aware:
     * 1) WP Nonces are not random in common meaning of this word.
     * For example, wp_create_nonce('action1') for one blog user will return same values now and ten minutes after.
     * 2) WP Nonces are not stored anywhere, they are just hashes.
     * 3) WP Nonces don't get invalidated. They are invalidated by time only (24 hours with default WP settings).
     */
    function _get_nonce($ajax_call) {
        $nonce_name = $this->_get_nonce_name($ajax_call);
        return wp_create_nonce($nonce_name);
    }
}
