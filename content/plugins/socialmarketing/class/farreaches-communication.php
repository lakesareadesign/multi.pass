<?php
/*
 * Responsible for actually api calls with the farreaches server.
 * ALL wp_remote_post()/wp_remote_get() to the farreaches server *must* go through this file.
 *
 * ====================================================================================================================
 * SECURED API CALLS
 *
 * ------------------------------ Paste this code to http://www.websequencediagrams.com ------------------------------
title FarReach.es 2-phase communication
participant "WireService" as s
participant "WordPress plugin" as p
participant "WordPress" as w

p->+w: Persist $apiCallData
p->+s: HTTP request ($apiCall, $permanentApiKey, $nonce, $callbackUri) asking for a TemporaryApiKey
s-->p: HTTP response
s->s: Validate callback domain
s->-p: HTTP request ($temporaryApiKey, $nonce)
p->w: Retrieve $apiCallData
w-->p: $apiCallData
p->-w: Delete $apiCallData
p->+s: HTTP request($apiCall, $temporaryApiKey, $apiCallData)
s-->p: HTTP response
 * ------------------------------ end of paste http://www.websequencediagrams.com -------------------------------------
 *
 * Secured api calls are used where the farreach.es server needs to be certain that it is talking with the plugin at the registered location.
 * This addresses these security issues:
 * 1) a hacker registers an account for a domain that the hacker doesn't control.
 * 2) a hacker steals the api_keys in the wordpress database.
 *
 * To protect against both scenarios:
 * 1) plugin initiates a call to the server - providing the api call that the plugin wishes to perform.
 *    a) plugin supplies a callbackUri ( TODO: remove this )
 * 2) server responds to the callbackUri which must be in the same domain as registered account with a callback id
 * 3) plugin uses callback to initiate another call to the server to complete the operation.
 *
 * This temporary to permanent key exchange insures that the uri the account is set for is the same as the url participating in the key
 * exchange.
 * For example:
 * if evil.com calls:
 * http://api.farreach.es/api/TemporaryApiKey?callbackUri=http://goodguy.com/foo
 *
 * the blog at goodguy.com will not have the any function registered to respond to the reply to farreach.es.
 * So no temporary key will be passed to goodguy.com. This means that evil.com cannot register goodguy.com nor can evil.com
 * pretend like evil.com is the farreach.es server completing the temp-> permanent key exchange.
 *
 * When this call is made from the server, there is no wordpress login information available.
 * ====================================================================================================================
 *
 * Also responsible for farreach.es initiated calls ( xmlrpc).
 * note that xmlrpc.php (line:105) allows filtering "wp_xmlrpc_server_class" to create an alternative xmlrpc handler.
 * We want to have an xmlrpc handler that only responds to xmlrpc requests from farreach.es server.
 *
 * each xmlrpc call gets a call like:
 *       do_action( 'xmlrpc_call', 'wp.getUsersBlogs' );
 *
 * If we ever use xmlrpc is where we will add methods to the xmlrpc list.
 * see wp-includes/class-wp-xmlrpc-server.php
    function add_xmlrpc_methods($xmlrpc_callback_methods) {
        // add to the methods
        return $xmlrpc_callback_methods;
    }
 *
 */
class FarReaches_Communication extends FarReaches_Util_Using {
    /**
     * @var FarReaches_Ajax
     */
    private $farReaches_Ajax;
    private $api_host;
    private $api_port;
    private $api_path;
    private $api_status_host;
    private $api_uri;
    // expect json response. This should always be kept up to date ( i.e. no reason to accept old version of api )
    // also use more industry standard accept header to specify json reply
    private $headers;

    const TEMPORARY_API_KEY_VALUE = 'temporaryApiKey';
    // if api_call[TEMPORARY_API_KEY_VALUE] = API_KEY_NOT_NEEDED - then the api key is not used even if available.
    // see code in api_call
    const API_KEY_NOT_NEEDED = 'not-needed';
    const WORDPRESS_USER_ID = 'externalUserId';
    const CALLBACK_META_KEY_SUFFIX = 'Callback';
    const API_STATUS_UNKNOWN = 'unknown';

    const NOTIFICATION_SERVER_NOT_AVAILABLE = 'wireservice://status/not_available';

    const MODULE = "(api)";

    /**
     * meta_key base used to store the user's api_key in the wp database.
     */
    const FARREACHES_API_KEY_BASE = 'api_key';

    const BAD_API_KEY_TOPIC = 'wireservice://bad_api_key';
    const BAD_API_KEY_REQUESTS_KEY = "bad_api_key_requests";

    const API_KEY_RECEIVED = "wireservice://api_key_received";

    const ASYNC_CALL = 'async';
    const API_CALL_KEY = 'apiCall';

    const CONFIG_FILE_NAME = "farreaches-api-calls";
    private $user_agent;
    /**
     * get_option(home) - the human visible location of the site
     * get_option(siteurl) - the site as reported by admin_url() i.e. the callback code. (if different)
     */
    private $blog_urls;

    private $blog_charset;

    private $security_nonce_timeout_in_seconds;

    /**
     * @var FarReaches_Ajax_Call making an farreaches api call that expects a response via a callback.
     */
    private $farreaches_callback_ajax_call;

    // $current_user->ID == 0 happens when debugging and mixing localhost with fake domain name.
    // as a result the auth cookie used to determine user is not available.
    // relogin to wordpress using fake domain name in browser url
    // check the http://___/wordpress/wp-admin/options-general.php
    // page to make sure the fake domain is listed as the wordpress address and site address
    // is wp $current_user->ID != 0?
    private $user_not_logged_in;

    private $requests_cache;

    private $farReaches_Api_Calls;

    /**
     * property_name/FarReaches_Api_Call map for properties that can be updated out-of-band
     * TODO in future allow properties that do not have specific api calls.
     * @var array
     */
    private $property_api_calls;
    /**
     *
     * @var FarReaches_Http_Handler
     */
    private $farReaches_Http_Handler;
    /**
     * Read in the configuration using get_option()
     */
    function __construct(FarReaches_Util $farReaches_Util, FarReaches_Http_Handler $farReaches_Http_Handler, array $args = array()) {
        parent::__construct($farReaches_Util);
        //For added security only wait for the callback for 10 minutes.
        // PAT: This allows time for the wireserver to be a little slow in the response. (we might have performance issue)
        // a 10 minute window is still tight for a hacker
        $this->security_nonce_timeout_in_seconds = 10 * 60;
        $this->farReaches_Ajax = new FarReaches_Ajax($farReaches_Util);
        $this->farReaches_Http_Handler = $farReaches_Http_Handler;
        global $wp_version;

        // the human visible site.
        $home_url_str = get_option("home");
        $home_url = parse_url($home_url_str);
        // This double checks the similar check in FarReaches_Bootstrap in farreaches-wp.php
        // this protects against a possible change in host to localhost.
        if ( strcasecmp($home_url['host'], 'localhost') ===0 ) {
            FarReaches_Validate::false(true, "Cannot use localhost as blog url: $home_url_str");
        }
        $this->blog_urls['publicUri'] = $home_url;
        $x_site_header = $home_url['host']. '/' ;
        if ( array_key_exists('path', $home_url)) {
            $x_site_header.=  $home_url['path'];
        }

        // blog code site admin_url() uses this location for callbacks. We need to verify both human and api call.
        // ( must be available via redirect at $home_url_str location - see http://codex.wordpress.org/Giving_WordPress_Its_Own_Directory )
        $site_url_str = get_option("siteurl");
        if ( strcasecmp($site_url_str, $home_url_str) !== 0 ) {
            $site_url = parse_url($site_url_str);
            $this->blog_urls['codeUri'] =$site_url;
            $x_site_header .= '|' . $site_url['host']. '/';
            if ( array_key_exists('path', $site_url)) {
                $x_site_header.=  $site_url['path'];
            }
        }
        $defaults = $this->get_default_api_configuration();

        $args = wp_parse_args($args, $defaults);
        $this->api_host = $args['api_host'];
        $this->api_port = $args['api_port'];
        $this->api_status_host = $args['api_status_host'];

        // TODO : we should not try to make call. Otherwise we don't want to mess up customer site.

        if (!is_user_logged_in()) {
            // some times the $current_user is a null object (don't bother to say anything )
            // case happens when debugging and mixing localhost with fake domain name.
            // as a result the auth cookie used to determine user is not available.
            // relogin to wordpress using fake domain name in browser url
            $this->user_not_logged_in = true;
        } else if (!$this->is_registered()) {
            $this->debug_log("User does not have farreaches access key yet. User=", $this->get_user_id());
        }
        $this->api_uri = "http://{$this->api_host}:{$this->api_port}" . '/';

        //Using hard coded agent string instead of plugin name because server needs to always know what to look for in User-Agent header.
        //And plugin name might be eventually changed. Do not alter the constant without updating server code.
        // example : WordPress/3.7.1 | FarReaches WP Plugin/1.8.1 | PHP/5.3.4
        $this->user_agent = sprintf("WordPress/%s | FarReaches WP Plugin/%s | PHP/%s", $wp_version, FARREACHES_PLUGIN_VERSION, phpversion());
        $this->blog_charset = get_option('blog_charset');

        $this->headers = array(
          // Why Not Comments that need to be left:
          //Kostya (14-Mar-2013): commented out content-type header since it resulted in Â symbols to
          //appear on server instead of spaces. as explained here http://stackoverflow.com/questions/1461907/html-encoding-issues-character-showing-up-instead-of-nbsp )
          // this is a bad translation of nbsp into a utf-8 encoding.
          // the charset results in translation into strange characters in tomcat when it is handling the request on the wireserver
         // this was verified by using curl to make call. we have not tested with non-english characters.
//                 'Content-Type' => 'application/x-www-form-urlencoded; ' .
//                 'charset=' . $this->blog_charset . ':application/json',
            //Bruno (17 sept) for some reason this field is causing trouble when doing redirects
            //in any case it is not necessary for http 1.0
            //'Host'              => $this->api_host,
            'User-Agent' => $this->user_agent,
            'Accept' => 'fr_api_' . FARREACHES_API_VERSION . '/json',
            'X-FarReaches-Site' => $x_site_header
        );

        $this->property_api_calls = array();
        $farReaches_Api_Calls = $this->get_config_file_contents(self::CONFIG_FILE_NAME);
        foreach($farReaches_Api_Calls as $api_call_key => $farReaches_Api_Call) {
            $farReaches_Api_Call->set_api_uri($this->api_uri);
            $farReaches_Api_Call->set_api_call_key($api_call_key);
            // find properties that can be updated out of band
            if ( $farReaches_Api_Call instanceof FarReaches_Api_Call_Read) {
                $property_name = $farReaches_Api_Call->get_property_name();
                if ( isset($property_name) ) {
                    $this->property_api_calls[$property_name] = $farReaches_Api_Call;
                }
            }
        }
        $this->farReaches_Api_Calls =$farReaches_Api_Calls;
        $this->register_api_response_handler(FarReaches_Api_Call::API_KEY_TEMPORARY,  'onevent_initiate_secured_api_call_response');
        $this->register_api_response_handler(FarReaches_Api_Call::API_KEY_INITIALIZE, 'onevent_initiate_secured_api_call_response');
        $this->register_api_response_handler(FarReaches_Api_Call::API_KEY_PERMANENT, 'onevent_receive_and_store_users_permanent_key');
        FarReaches_EventBus_Facade::subscribeMe($this, array(
            self::API_KEY_RECEIVED => 'onevent_api_key_received'
        ));

        $this->farreaches_callback_ajax_call = $this->add_ajax_hook(new FarReaches_Ajax_Call($this, 'farreaches_server_reply', array('all')));
    }

    /**
     * return true if this blog has an account code with the farreaches server.
     * Account is not guaranteed to be valid. The server may decide to cancel an account
     * at any moment.
     */
    function is_registered() {
        $farreaches_api_key = $this->get_user_farreaches_api_key();
        return !empty($farreaches_api_key);
    }

    /**
     * will throw exception if there is no matching api_call_definition
     * @param FarReaches_Api_Call|string $api_call_key
     */
    public function get_api_call_definition($api_call_key) {
        if ( !isset($api_call_key) ) {
            FarReaches_Validate::false(true, "no api_call_key supplied");
        } else if ( is_string($api_call_key)) {
            FarReaches_Validate::array_has_key($this->farReaches_Api_Calls, $api_call_key);
            return $this->farReaches_Api_Calls[$api_call_key];
        } else if ( $api_call_key instanceof FarReaches_Api_Call) {
            return $api_call_key;
        } else {
            FarReaches_Validate::false(true, $api_call_key . ": is not a api_call or a api_call_key");
        }
    }

    /**
     * Use case: Cache Request
     *========================
     * If the plugin makes a request to FarReaches server and the server is down for some reason,
     * the request gets dropped. There is no means to ensure that the request gets sent to the server
     * again. Caching requests will ensure that the request will never get lost. However, not all request will
     * be cached. Those like info which require information from the server at that time, will be allowed
     * to go through.
     * The function cache_api_call will decide if the api call should be allowed to go through. If it should be cached
     * then api call along with the incoming request will be added to an array requests_cache.
     * A separate cron job will periodically check if the requests_cache has values in it and then process it in fifo order.
     * The cron job will remove the requests which had been handled successfully by the FarReaches server. However, those request
     * which were not processed by the server will remain in the requests_cache.
     * The cron job:
     * The cron job will run hourly. The cron job will process the requests in fifo order. If any request fails because of
     * server not available, then the cron job will not process further requests and sleep until it gets started again.
     * Alternate use cases
     * a) User tries to send the same request repeatedly
     *
     * TODO: all api_calls should be async (in that the response is not immediate )
     * TODO : only immediate failure sure be returned everything else should be handled via a registered event handler.
     *
     * @param string|FarReaches_Api_Call $api_call_key
     * @param array $request
     * @param string $user
     * @param string $initial_call_parameters
     * @return FarReaches_Communication_Error|Ambigous <NULL, WP_Error, unknown>
     */
    public function api_call($api_call_key, $request = array(), $user = null, $initial_call_parameters = null) {
        $this_user = $this->get_user_id($user);
        $api_call_definition = $this->get_api_call_definition($api_call_key);
        $complete_request = $api_call_definition->get_complete_request($request);
        // A double async call ( first to get temporary key, second to initiate the request ) is useful when the result of the second request will not be known for a while
        // for example, posting a message.
        if(FarReaches_Params::key_exists(self::ASYNC_CALL, $complete_request)) {
            $async_call = $complete_request[self::ASYNC_CALL] === true;
            unset($complete_request[self::ASYNC_CALL]);
        } else {
            $async_call = false;
        }
        $response = null;
        for($success = false; !$success; ) {
            try {
                if ( $async_call) {
                    $response = $this->_async_api_call($api_call_definition, $request, $this_user, $initial_call_parameters);
                } else {
                    $response = $this->_api_call($api_call_definition, $complete_request, $this_user);
                }
                $success = true;
            } catch (FarReaches_Authorization_Exception $e) {
                // thrown when a reauthorization was needed.
                // TODO better response than sleep - but we want to avoid a busy wait.
                sleep(1);
                return new FarReaches_Communication_Error(401, "retry - get new authorization");
            }
        }
        return $response;
    }
    /**
     * called only from api_call() function
     *
     * On success will send publish an event to
     * @param FarReaches_Api_Call $api_call_definition
     * @param unknown_type $request
     * @param unknown_type $user
     */
    private function _api_call(FarReaches_Api_Call $api_call_definition, $request, $user) {
        if ( $api_call_definition->cachable === true) {
            // see if there is a cached value.
            // caching is done in the event handlers that are triggered when the original request is received.
            $response = $this->get_cached($api_call_definition->get_api_call_name());
            if ( isset($response)) {
                // remember empty is a valid api return value
                return $response;
            } else {
                // used if the attempt to refresh fails.
                // see $this->cache_results()
                $default_if_failed = $this->get_option($api_call_definition->get_api_call_name());
            }
        }
        $full_api_uri = $api_call_definition->get_full_api_uri();
        // TODO check with api_call_definiton
        if ($api_call_definition->is_api_not_used()) {
            // some calls (i.e. getwordpressinfo) do not need an api key or must not use the api key even available:
            // example: api_key is invalidated or plugin is not activated but is still asking about updates.
            // other calls like the initial registration have no api key yet or are trying to get a new key because the old one is not available or is bad.
            $api_key = null;
        } else {
            if (FarReaches_Params::key_exists(self::TEMPORARY_API_KEY_VALUE, $request)) {
                $api_key = $request[self::TEMPORARY_API_KEY_VALUE];
            } else {
                $api_key = $this->get_user_farreaches_api_key($user);
            }
            if (empty($api_key)) {
                $plugin_state = $this->get_plugin_state();
                if ( !isset($user)) {
                    // HACK: this needs to be an ordinary error for cases where the js is sending a request
                    // (post status for example) but the login has timed out so there is no user.
                    // but we don't want to invalidate previously cached items (as another user may be logged in)
                    $this->debug_log("No api key and no user supplied for api call:",$api_call_definition->get_api_call_key(),". Could be an error but more likely just a case of a user whose session has expired but still has a window open making ajax refresh calls.");
                    return new FarReaches_Communication_Error(0, "no user defined");
                } else if ($plugin_state == FarReaches_Plugin_State::KEYS_RECEIVED || $plugin_state == FarReaches_Plugin_State::SYNCED) {
                    // will throw exception
                    $this->reinitialize_api_key($api_call_definition, $request, $user);
                    FarReaches_Validate::should_never_reach_here("No api key and not trying to get one (for some reason) #1: ". $api_call_definition->get_api_call_key());
                } else {
                    return new FarReaches_Communication_Error(0, "plugin rems of service not accepted yet");
                }
            }
        }
        $http_args = $this->get_api_call_http_args($request, $api_key);
        // But just make sure that we can figure out where we are in the processing of a request.
        $this->debug_log(self::MODULE, " Made call:" , $full_api_uri);
        // TODO wp_remote_get as well.
        // TODO encapsulate response into our own Farreaches response object.
        $full_response = $this->farReaches_Http_Handler->http_post($full_api_uri, $http_args);
        $error_response = $this->build_error($full_response);
        $farReaches_Event = new FarReaches_Event($user);
        $farReaches_Event->api_call_key = $api_call_definition->get_api_call_key();
        $farReaches_Event->full_response = $full_response;
        $farReaches_Event->request = $request;
        $farReaches_Event->full_api_uri = $full_api_uri;
        $farReaches_Event->http_args = $http_args;
        $farReaches_Event->error_response = $error_response;
        $success = $error_response == null;
        if ($success) {
            $farReaches_Event->parsed_response = $this->get_parsed_response($full_response);
            $this->debug_log(self::MODULE, " Succeeded :" , $full_api_uri);
        } else {
            if (!$error_response->is_server_available()) {
                $this->debug_log(self::MODULE, " >>>>Server is not available:" , $full_api_uri, ": ", $error_response->get_error());
                $api_status = $this->get_api_status();
                $failed_api_call_key = $api_call_definition->get_api_call_key();
                // HACK TODO such specific knowledge is hacky
                // these calls are step 1 of a 2-step call
                if (FarReaches_Api_Call::API_KEY_TEMPORARY == $failed_api_call_key || FarReaches_Api_Call::API_KEY_INITIALIZE == $failed_api_call_key) {
                    $failed_api_call_key = $request[FarReaches_Communication::API_CALL_KEY];
                }
                // TODO : set $user this way if $user is null - why require there to be a user?
                if (!empty($user)) {
                    $farReaches_Event->api_call_key = $failed_api_call_key;
                    $farReaches_Event->api_status = $api_status;

                	// TODO: This should be moved to wireserver layer (when everything goes through wireserver).
                	// We do cache error responses, which means some server unavalible messages will not be shown in case of cache hit.
                    FarReaches_EventBus_Facade::publish(FarReaches_Communication::NOTIFICATION_SERVER_NOT_AVAILABLE,$farReaches_Event);
                }
            } else if ($error_response->is_non_server_error()) {
                $this->error_log(self::MODULE, " WP_Error:" . $full_api_uri, ": ", $error_response->get_error());
            } else if ($error_response->is_bad_request()) {
                $this->error_log(self::MODULE, " Failed : Bad request. Request validation error: ", $full_api_uri, " : ",
                    $http_args, "\n\tRequest=", $request, "\tResponse=", $error_response);
            } else if ($error_response->is_authorization_problem() ) {
            	$this->debug_log(self::MODULE, " Auth error:", $full_api_uri, " : ", $http_args, "\n\tResponse=", $error_response);
            	if (!$this->reinitialize_api_key($api_call_definition, $request, $user)) {
            	    $this->error_log(self::MODULE, "FAILED TO COMPLETE AUTHENTICATION PROCESS:", $full_api_uri,
            	            " : ", $http_args, "\n\tResponse=", $error_response);
            	} else {
            	    FarReaches_Validate::should_never_reach_here("No api key and not trying to get one (for some reason) #2 :" . $api_call_definition->get_api_call_key());
            	}
            } else if ($error_response->is_not_acceptable_problem() ) {
            	$this->error_log(self::MODULE, " Server did not accept request:", $full_api_uri, " : ", $http_args, "\n\tResponse=", $error_response);
            	// wireserver replies with a 406 response code it force users to upgrade plugin
            	// 406 ONLY means obsolete_api_version
				FarReaches_EventBus_Facade::publish(FarReaches_EventBus::TOPIC_PREFIX_WIRESERVICE . 'status/obsolete_api_version', $farReaches_Event);
            } else {
                $this->error_log(self::MODULE, " >>>>FAILED API CALL:", $full_api_uri, " : ", $http_args, "\n\tResponse=", $error_response);
            }
        }
        if ( $success && $api_call_definition instanceof FarReaches_Api_Call_Write ) {
            foreach ($api_call_definition->get_invalidates() as $api_call_key) {
                $this->clear_cached_results($api_call_key);
            }
        }
        // HACK - hacky way to determine if the results will be async returned by server
        if (!FarReaches_Params::key_exists("callbackUri", $request) || !$success) {
            //Only publish result if we're not waiting for server callback or it failed.
            // trigger updates to properties that may (or may not) be the current property being updated.

            // Used to avoid double triggers.
            $main_event_triggered = false;
            $property_event_triggered = false;
            if ( $success == true && is_array($farReaches_Event->parsed_response)) {
                foreach($farReaches_Event->parsed_response as $property_name => $associated_response ) {
                    if ( array_key_exists($property_name,$this->property_api_calls) ) {
                        $associated_api_call_definition = $this->property_api_calls[$property_name];
                        if ( $api_call_definition == $associated_api_call_definition ) {
                            $main_event_triggered = true;
                        }
                        $property_event_triggered |= true;
                        // the api_call that made the actual api call was already triggered.
                        $farReaches_Event_Secondary = clone $farReaches_Event;
                        $farReaches_Event_Secondary->response = $associated_response;
                        $result_topic = $associated_api_call_definition->get_notification_topic($success);
                        FarReaches_EventBus_Facade::publish(
                            $result_topic,
                            $farReaches_Event_Secondary,
                            $this->get_user_id($user),
                            FarReaches_EventBus::DELIVER_OR_DROP
                        );
                    }
                }
            }
            if ( !$main_event_triggered) {
                $result_topic = $api_call_definition->get_notification_topic($success);
                if ( $success ) {
                    // if the api_call being made was not triggered, then this means we need to send the entire response
                    $farReaches_Event->response = $this->get_parsed_response($full_response);
                } else {
                    $farReaches_Event->response = $farReaches_Event->error_response;
                }
                FarReaches_EventBus_Facade::publish(
                    $result_topic,
                    $farReaches_Event,
                    $this->get_user_id($user),
                    FarReaches_EventBus::DELIVER_OR_DROP
                );
            }
        }
        if ( !$success) {
            if(isset($default_if_failed)) {
                // return the backup cached information of the previous
                return $default_if_failed;
            } else {
                return $farReaches_Event->error_response;
            }
        } else {
            return @$farReaches_Event->response;
        }
    }

    /**
     * caches a property returned and makes a second long-term copy so that a default can be supplied if there is any sort of server issue.
     * See code in _api_call()
     * @param FarReaches_Api_Call|string $api_call_key
     * @param unknown $value
     * @param unknown $expire_in_secs
     */
    public function cache_results($api_call_key, $value, $expire_in_secs) {
        $api_call_definition = $this->get_api_call_definition($api_call_key);
        $cache_key_base = $api_call_definition->get_api_call_name();
        $this->cache($cache_key_base, $value, $expire_in_secs);
        if ( !$this->is_response_in_error($value)) {
            // only do a long-term cache if the value is not in error.
            // extended backup ( to cover for server being down. )
            $this->update_option($cache_key_base, null, $value);
        }
    }

    public function clear_cached_results($api_call_key) {
    	$this->clear_cached($this->get_api_call_definition($api_call_key)->get_api_call_name());
    }

    /**
     * Returns status message about current api state or null if no message is available.
     *
     * @return NULL | string
     */
    private function get_api_status() {
        $status = $this->get_cached('api_status');
        if ($status === null) {
            $status = $this->farReaches_Http_Handler->http_get('http://' . $this->api_status_host . '/status.json');
            if (is_wp_error($status) || $status['response']['code'] >= 400) {
                //Server seem to be completely down. No api status available.
                $status = self::API_STATUS_UNKNOWN;
            } else {
                $status = $status['body'];
            }
            // cache api status for 2 minutes (because this is likely slow changing)
            $this->cache('api_status', $status, 2*60);
        }
        if ($status == self::API_STATUS_UNKNOWN) {
            $status = null;
        }
        return $status;
    }

    /**
     *
     * @param FarReaches_Api_Call $api_call_definition
     * @param unknown_type $request
     * @param unknown_type $this_user
     * @throws FarReaches_Authorization_Exception
     * @return false if the call that failed authorization was the initialize or the permanent key.
     * it is o.k. to fail on the TemporaryKeyApi because that is used when we are trying to upgrade an existing key.
     * That existing key maybe bad.
     */
    private function reinitialize_api_key(FarReaches_Api_Call $api_call_definition, $request, $this_user) {
        // if the status code is 401 - then the user api_key is invalid.
        $this->remove_user_farreaches_api_key($this_user);
        // HACK that we are checking $api_call so explicitly
        // make sure that the call that got the 401 isn't an authentication call.
        // this check avoids an infinite loop of failed api key requests.
        if ($api_call_definition->is_fail_on_key_fail() !== true) {
            // TODO : Need to prevent multiple in-progress attempts at getting a new key - we need a locking mechanism.
            $farReaches_Event = new FarReaches_Event($this_user);
            $farReaches_Event->api_call_key = $api_call_definition->get_api_call_key();
            $farReaches_Event->request = $request;
            //Save failed call data to re-try after we get a new API key.
            $this->add_user_meta($this_user, self::BAD_API_KEY_REQUESTS_KEY, null, array($api_call_definition->get_api_call_key() => $request));

            // mark user as needing new api key
            $this->update_users_needing_api_key($this_user, true);
            // and schedule job to get new api key (see farreaches-settings-organization.php )
            $job_definition = $this->create_job_definition($this_user, FarReaches_Settings_Organization::FARREACHES_REFRESH_API_HOOK);
            $this->schedule_single_event(2, $job_definition);

            // because the reauthorization is happening async we want to make sure that a developer doesn't try
            // to pretend that the api_key is going to be supplied in some sort of sequential manner.
            // TODO maybe the request could queue up so that multiple requests that queue up waiting for reauthorization can handled.
            throw new FarReaches_Authorization_Exception($api_call_definition->get_api_call_key() . ":Authorization error occurred when doing ". $api_call_definition);
        } else {
            return false;
        }
    }

    function onevent_api_key_received(FarReaches_Event $farReaches_Event) {
        //Re-try previously failed (due to bad API key) requests, if any.
    	$failed_requests = $this->get_user_meta($farReaches_Event->user, self::BAD_API_KEY_REQUESTS_KEY);
    	if (!empty($failed_requests)) {
    	    //Clean first.
    	    $this->delete_user_meta($farReaches_Event->user, self::BAD_API_KEY_REQUESTS_KEY);
    	    foreach ($failed_requests as $api_call_key => $request) {
    	        try {
                    $this->_api_call($this->get_api_call_definition($api_call_key), $request, $farReaches_Event->user);
    	        } catch (Exception $e) {
    	            $this->error_log('Failed on re-try call: ', $api_call_key, 'request: ', $request, $e);
    	        }
    	    }
    	}
    }

    // HACK because would like way to build the full uri ourselves for use in the browser.
    // not used within FarReaches_Communication TBD - to be deleted
    function get_full_api_uri($api_call, $query_params = null, $api_key = null) {
        $api_call_definition = $this->get_api_call_definition($api_call);
        $full_api_uri = $api_call_definition->get_full_api_uri($query_params);
        return $full_api_uri;
    }

    /**
     * TODO this should be called via the api_call method ( we don't want to leave it to the developer )
     * The api_call_definition needs to determine if the call is secured or not )
     *
     * Step 1 for a secured_api_call ( see the class level notes )
     *
     * @param string|FarReaches_Api_Call $phase_two_api_call
     * @param array $saved_for_callback
     * @param array $initial_call_parameters
     * @param object $user
     * @return array|\WP_Error from the initial connection to the server.
     */
    function initiate_secured_api_call($phase_two_api_call, array $saved_for_callback = array(), array $initial_call_parameters = null, $user = null, $topic = null) {
        //TODO a callback handler should be registered right here and unregistered after the callback was executed.
        // verifies to that the phase_two_api_call exists.
        $phase_two_api_call_definition = $this->get_api_call_definition($phase_two_api_call);
        $api_key = $this->get_user_farreaches_api_key($user);
        if (!is_string($api_key) && $phase_two_api_call_definition->is_permanent_api_key_not_needed()) {
            //If no api key is available, then try to obtain temporary key from public api
            //(this one is considered an initial setup request).
            $phase_one_call = FarReaches_Api_Call::API_KEY_INITIALIZE;
        } else {
            $phase_one_call = FarReaches_Api_Call::API_KEY_TEMPORARY;
        }
        $saved_data = array(
            'serverApiCall' => array(
                FarReaches_Communication::API_CALL_KEY => $phase_two_api_call_definition->get_api_call_key(),
                'apiData' => $saved_for_callback,
                'topic' => $topic
            ));
        if (empty($initial_call_parameters)) {
            $initial_call_parameters = array(FarReaches_Communication::API_CALL_KEY => $phase_two_api_call_definition->get_api_call_basename());
        } else {
            $initial_call_parameters[FarReaches_Communication::API_CALL_KEY] = $phase_two_api_call_definition->get_api_call_basename();
        }
        // we want to make sure that we force an async response ( even if the definition of the call was not specifying async call)
        $response = $this->async_api_call($phase_one_call, $saved_data, $user, $initial_call_parameters);
        if ($this->is_response_in_error($response)) {
            $farReaches_Event = new FarReaches_Event($user);
            $farReaches_Event->response = $response;
            $farReaches_Event->error_response = $response;
            $farReaches_Event->phase_two_api_call = $phase_two_api_call_definition->get_api_call_key();
            $farReaches_Event->saved_for_callback = $saved_for_callback;
            FarReaches_EventBus_Facade::publish(
                $phase_two_api_call_definition->get_failure_notification_topic(),
                $farReaches_Event,
                $this->get_user_id($user),
                FarReaches_EventBus::DELIVER_OR_DROP
            );
        }
        return $response;
    }

    /**
     * Step 2 and Step 3 for the secured api calls
     * Handle the response from the farreach.es server in response to a request initiated in initiate_secured_api_call()
     * verify the nonce.
     * verify the expected api call to be made.
     * Make the secured call.
     */
    function onevent_initiate_secured_api_call_response(FarReaches_Event $farReaches_Event) {
        $user = $farReaches_Event->user;
        $callback_data = $farReaches_Event->callback_data;
        $temporaryApiKey = FarReaches_Request::string(self::TEMPORARY_API_KEY_VALUE);

        // phase 2 call
        $phase_two_api_call = $callback_data['serverApiCall'];
        $apiCall = $phase_two_api_call[FarReaches_Communication::API_CALL_KEY];
        $topic = FarReaches_Params::string($phase_two_api_call, 'topic', null);
        if (FarReaches_String_Util::not_blank($topic)) {
            $farReaches_Event_1 = new FarReaches_Event($user);
            $farReaches_Event_1->temporaryApiKey = $temporaryApiKey;
            $farReaches_Event_1->apiData = $phase_two_api_call['apiData'];
            FarReaches_EventBus_Facade::publish($topic, $farReaches_Event_1, $user->ID);
        } else {
            $savedPhase2ApiData = $phase_two_api_call['apiData'];
            $this->debug_log(self::MODULE, " Handling a phase 1 secured response ('", $temporaryApiKey, "') and starting phase 2 ", $callback_data);
            // PAT:  this dance is to handle case where after the temporary api key is retrieved there is an additional
            // level of indirect as part of the call itself. This second request/response is currently only used
            // when getting the PermanentApiKeys but may be useful where the secured api call triggers some action
            // that will return the response in a delayed manner. (pubishing a post (CreateAlert) for example)
            $initial_call_parameters = array(self::TEMPORARY_API_KEY_VALUE => $temporaryApiKey);
            if (!empty($savedPhase2ApiData)) {
                $apiData = array_merge($initial_call_parameters, $savedPhase2ApiData);
            } else {
                $apiData = $initial_call_parameters;
            }
            $response = $this->api_call($apiCall, $apiData, $user, $apiData);
            return $response;
        }
    }

    /**
     * This is an *server* async api call. The server will respond later with the results.
     * (as opposed to the client code making
     * a synchronous server call that the client code does not wait for )
     *
     * To handle the async callback, 2 parameters are added to the passed data:
     * a nonce and a callbackUri
     *
     * TODO Such a client side async handling is part of the cache code.
     *
     * @param string|FarReaches_Api_Call $api_call_key
     * @param array $initial_call_parameters
     * @param array $saved_for_callback
     * @param object $user
     * @internal param object $that
     * @return array|\FarReaches_Communication_Error
     */
    function async_api_call($api_call_key, $saved_for_callback, $user = null, $initial_call_parameters = array()) {
        $user_id = $this->get_user_id($user);
        $api_call_definition = $this->get_api_call_definition($api_call_key);
        return $this->_async_api_call($api_call_definition, $saved_for_callback, $user_id, $initial_call_parameters);
    }
    private function _async_api_call(FarReaches_Api_Call $api_call_definition, $saved_for_callback, $user_id, $initial_call_parameters = array()) {
        $nonce = $this->farReaches_Http_Handler->nonce();

        $callbackUri = $this->get_callback_uri($nonce);
        // save the nonce, the saved data
        $saved_for_nonce = array(self::WORDPRESS_USER_ID => $user_id, FarReaches_Communication::API_CALL_KEY => $api_call_definition->get_api_call_key());
        if (!empty($saved_for_callback)) {
            $saved_for_nonce = array_merge($saved_for_nonce, $saved_for_callback);
        }

        $this->cache($nonce, $saved_for_nonce, $this->security_nonce_timeout_in_seconds);

        $phase_request = array('callbackUri' => $callbackUri);
        if (!empty($initial_call_parameters)) {
            $phase_request = array_merge($phase_request, $initial_call_parameters);
        }
        $response = $this->_api_call($api_call_definition, $phase_request, $user_id);
        if ($this->is_response_in_error($response)) {
            //Clean callback data if error was detected, it won't be triggered anyhow.
            //$this->clear_cached($nonce);
        }
        return $response;
    }

    private function get_callback_uri($nonce) {
        $api_call_params = array(FarReaches_Ajax::FARREACHES_CB_NONCE => $nonce);
        $callbackUri = $this->farreaches_callback_ajax_call->get_ajax_uri($api_call_params);
        // this check is to catch developers running locally in an incorrect way.
        $domain = parse_url($callbackUri, PHP_URL_HOST);
        FarReaches_Validate::string_contains($domain, '.', "$domain: Illegal blog url. Blog must have a publicly visible domain name (for example: example.com). "
            . "Cannot use a local host as the blog's domain (For example 'localhost' is not allowed)");
        return $callbackUri;
    }

    /**
     * called from Farreaches_Ajax::_invoke_user_ajax_func
     *
     * Note: if you want to debug this function, you're going to need a bigger timeout from the server.
     *          To do that, log in to the amplafi db and check the CALLBACKS table. In that table you'll find
     *          the timeouts for the callbacks, and you can simply add some time to it:
     *             UPDATE CALLBACKS SET EXPIRATION_TIME = DATE_ADD(EXPIRATION_TIME, INTERVAL 5 DAY) WHERE LOOKUP_KEY = 'ampcb_$randomnumbers';
     *          this parameter is part of the response, the apiCallKey and varies on each call. set a breakpoint,
     *          grab it, execute the appropriate query and keep debugging
     * @param mixed $ajax_call
     * @return string
     */
    function farreaches_server_reply($ajax_call) {
        // error check request
        $user_nonce = FarReaches_Request::string(FarReaches_Ajax::FARREACHES_CB_NONCE);
        if ( empty($user_nonce) ) {
            $this->report_server_error("Bad request. user_nonce not set");
            return;
        }
        $callback_data = $this->get_cached($user_nonce);
        if ( empty($callback_data) || !is_array($callback_data) ) {
            $this->report_server_error("Nonce $user_nonce has no callback data associated with it. This may happen if nonce is bad or the nonce has expired.");
            return;
        }
        $api_call_key = FarReaches_Params::string($callback_data, FarReaches_Communication::API_CALL_KEY);
        if ( empty($api_call_key)) {
            $this->report_server_error("Nonce $user_nonce has bad callback data. apiCallKey is not set.");
            return;
        }
        $api_call_definition = $this->get_api_call_definition($api_call_key);

        $userId = FarReaches_Params::string($callback_data, self::WORDPRESS_USER_ID);
        // make sure this user is valid
        if ( empty($userId) || $userId === 0 || !is_numeric($userId)) {
            $this->report_server_error("Nonce $user_nonce has bad callback data. Bad callback data. userId is not set.");
            return;
        }
        // don't really need the user data but we want to verify the user is still valid.
        $user = get_userdata($userId);
        if ( !isset($user)) {
            $this->report_server_error("Nonce $user_nonce has bad callback data :$userId: no user with this id.");
            return;
        }

        //set the "current_user" for this callback and processing that happens on this callback.
        $this->set_current_user($userId);

        $this->debug_log(__CLASS__, ".", __FUNCTION__ , "userId=", $userId, " callback_data=", $callback_data);
        //TODO grab all request parameters and put them in to a response object. So it should be possible
        //to publish this event with the same array structue as in api_call().
        $farReaches_Event = new FarReaches_Event($user);
        $farReaches_Event->api_call_key = $api_call_definition->get_api_call_key();
        $farReaches_Event->callback_data = $callback_data;
        $farReaches_Event->response = $_REQUEST;
        $farReaches_Event->parsed_response = $_REQUEST;
        FarReaches_EventBus_Facade::publish(
            $api_call_definition->get_success_notification_topic(),
            $farReaches_Event,
            $userId,
            FarReaches_EventBus::DELIVER_OR_DROP
        );
        $this->clear_cached($user_nonce);
    }

    /**
     * response to wireserver if plugin did not understand the information.
     * @param unknown $message
     */
    private function report_server_error($message) {
        @header("X-FarReaches-Error: $message", false, 400);
        echo "$message\n";
        echo var_export($_REQUEST, true);
    }
    /**
     */
    private function get_value_from_response($response, $parameter_key = null) {
        if (!$this->is_response_in_error($response) && !empty($response)) {
            $responseBody = $this->get_parsed_response($response);
            if (!isset($parameter_key)) {
                return $responseBody;
            } else if (FarReaches_Params::key_exists($parameter_key, $responseBody)) {
                return $responseBody[$parameter_key];
            }
        }
        return null;
    }

    function get_parsed_response($response) {
        if (!$this->is_response_in_error($response) && !empty($response)) {
            $responseBody = $this->json_decode($response['body']);
            return $responseBody;
        } else {
            return null;
        }
    }
    /**
     *
     * @param unknown_type $response
     * @return boolean true if $response is an instance of FarReaches_Communication_Error
     */
    public function is_response_in_error($response) {
        return is_object($response) && is_a($response, 'FarReaches_Communication_Error');
    }

    public function check_response_in_error($response, $message=null) {
        if ( $this->is_response_in_error($response)) {
            $actual_message = (is_null($message)?"":$message) . $response->get_error_message();
            FarReaches_Validate::false(true, $actual_message);
            // does not return
        }
    }

    private function build_error($response) {
        if ( empty($response) ) {
            return new FarReaches_Communication_Error(0, "empty response");
        } else if ( is_wp_error($response) ) {
            return new FarReaches_Communication_Error(0, $response, $this->is_server_reachable());
        } else if ( $response['response']['code'] >= 400 ) {
            $error_message = $this->get_value_from_response($response, 'error');
            if ( empty($error_message)) {
                $error_message = $response['response']['message'];
            }
            return new FarReaches_Communication_Error($response['response']['code'], $error_message, true, $this->get_parsed_response($response));
        } else {
            return null;
        }
    }

    function is_server_available($response) {
        // errors that are not WP_Errors are plugin errors or some other error but the wireserver is still present
        if ($this->is_response_in_error($response)) {
            return $response->is_server_available();
        }
        return true;
    }

    function get_user_farreaches_api_key($user = null) {
        $key = $this->get_user_meta($user, FarReaches_Communication::FARREACHES_API_KEY_BASE);
        if (!is_string($key)) {
            $key = null;
        }
        return $key;
    }
    /**
     * called when a user is removed from the wordpress list of users or their permission is reduced/or changed.
     * if permission is changed then the api_key will be reauthorized.
     */
    public function remove_user_farreaches_api_key($user = null) {
        $this->delete_user_meta($user, FarReaches_Communication::FARREACHES_API_KEY_BASE);
    }
    function set_user_farreaches_api_key($user, $farreaches_api_key) {
        $this->add_user_meta($user, FarReaches_Communication::FARREACHES_API_KEY_BASE, null, $farreaches_api_key);
        $this->update_users_needing_api_key($user, false);
        $farReaches_Event = new FarReaches_Event($user);
        FarReaches_EventBus_Facade::publish(self::API_KEY_RECEIVED, $farReaches_Event, $user);
    }
    /**
     *
     * Receive the user's permanent key in exchange for temporary key from the farreach.es server.
     * Function only registered when the exchange_temporary_key_for_permanent_key call is made.
     * When this call is made from the server, there is no wordpress login information available.
     *
     * @listens wireservice://PermanentApiKey/done
     *
     * @param WP_User $user
     * @param array $callback_data should not be removed as it is passed by event bus (argument count has to match)
     * @return void
     */
    function onevent_receive_and_store_users_permanent_key(FarReaches_Event $farReaches_Event) {
        $user = $farReaches_Event->user;
        $permanent_api_keys = $farReaches_Event->response;
        if ( !empty($permanent_api_keys)) {
            foreach ($permanent_api_keys as $this_user => $farreaches_api_key) {
                $this->set_user_farreaches_api_key($this_user, $farreaches_api_key);
            }

            $plugin_state = $this->get_plugin_state();
            if ( $plugin_state !== FarReaches_Plugin_State::SYNCED) {
                $this->set_plugin_state(FarReaches_Plugin_State::KEYS_RECEIVED);
            }
        }
    }

    /**
     * add or remove a user from list of users needing their api key updated.
     */
    function update_users_needing_api_key($user_id, $add) {
        $current_bad_list = $this->get_option(FarReaches_Communication::BAD_API_KEY_TOPIC);
        if ( $add ) {
            $current_bad_list[$user_id] = true;
        } else {
            unset($current_bad_list[$user_id]);
        }
        $this->update_option(FarReaches_Communication::BAD_API_KEY_TOPIC, null, $current_bad_list);
    }
    /**
     * Only called if there is reason to believe the server may be down ( for example, api error ) or from diagnostics page.
     * This function checks if a server is reachable by requesting header information.
     *
     */
    function is_server_reachable() {
        //Kostya (Oct 8, 2012): fsockopen seem to have no problems, unlike the get_headers method.
        $server_reachable = $this->get_cached("server_reachable");
        if ( $server_reachable === null) {
            $fp = @fsockopen($this->api_host, $this->api_port);
            if ($fp) {
                fclose($fp);
                $server_reachable = true;
            } else {
                $server_reachable = false;
            }
            // only short cache because this method is only called if the server looks to be down.
            $this->cache("server_reachable", $server_reachable, 10);
        }
        return $server_reachable;
    }

    /**
     * create the meta_key base that will be used as the key to store the callback uri.
     * This callback uri is invoked by the server to deliver its response.
     */
    function get_callback_meta_key_base($meta_key_base) {
        FarReaches_Validate::not_empty($meta_key_base, "meta_key_base is empty");
        return $meta_key_base . self::CALLBACK_META_KEY_SUFFIX;
    }

    private function get_api_call_http_args($request, $api_key) {
        $headers = $this->headers;
        if (is_string($api_key) && $api_key !== self::API_KEY_NOT_NEEDED) {
            $headers['Authorization'] = $api_key;
        }
        $json_encoded_body = $this->json_encode_array_values($request);
        $http_args = array(
            'body' => $json_encoded_body,
            'headers' => $headers,
            //Set explicitly to 1.0 to avoid keep alive connections.
            //On 1.1 hangs waiting for server to pass data even after request was processed already.
            'httpversion' => '1.0',
        );
        if (FARREACHES_DEBUG) {
            // otherwise no timeout. (effectively)
            $http_args['timeout'] = 9000;
        } else {
            // if not debugging then allow a 90 second time out ( need to shrink )
            $http_args['timeout'] = 90;
        }
        return $http_args;
    }

    /**
     * TODO / HACK : this function must be in utils and merged with the json_echode there
     * Applies $this->encode to all values in the input array.
     * @param $array
     * @return array
     */
    function json_encode_array_values($array) {
        $encoded_array_values = array();

        if (!empty($array)) {
            foreach ($array as $key => $value) {
                if (is_array($value) || is_object($value) || is_bool($value)) {
                    // encode boolean values as strings (otherwise encoded as numbers)
                    $encoded_array_values[$key] = $this->json_encode($value);
                } else {
                    // no reason to json_encode strings ( it would result in things like uris having " ) or numbers
                    $encoded_array_values[$key] = $value;
                }
            }
        }

        return $encoded_array_values;
    }

    /**
     * Creates and returns default parameters for API configuration: host, path, port and whether to initialize plugin or not.
     * @return array which maps configuration type to configuration value.
     */
    private function get_default_api_configuration() {
        $defaults = array(
            'api_host' => FARREACHES_API_HOST,
            'api_port' => FARREACHES_API_PORT,
            'api_status_host' => FARREACHES_API_STATUS_HOST,
            'initialize_plugin' => false
        );
        return $defaults;
    }

    /**
     *
     * @return array ('publicUri' => get_option(home), 'codeUri' => get_option(siteurl)
     */
    function get_blog_urls() {
        return $this->blog_urls;
    }

    /**
     * The get_option("home") the url that is the address entered in the browser
     * @param string $part
     * @return unknown
     */
    function get_human_uri($part = 'host') {
        $publicUri = $this->blog_urls['publicUri'];
        return $publicUri[$part];
    }
    /**
     * get_option('siteUrl') where the code is. This happens if the code is in a common location for multiple websites.
     * @param string $part
     * @return unknown
     */
    function get_code_uri($part = 'host') {
        $publicUri = $this->blog_urls['publicUri'];
        return $publicUri[$part];
    }

    function get_ajax_uri($ajax_call, $preconfig_data = array()) {
        return $this->farReaches_Ajax->get_ajax_uri($ajax_call, $preconfig_data);
    }

    function add_ajax_hook(FarReaches_Ajax_Call $ajax_call) {
        return $this->farReaches_Ajax->add_ajax_hook($ajax_call);
    }

    // TODO: not currently used - but we should be caching responses.
    private function post_requests() {
        while (!empty($this->requests_cache)) {
            $api_request = array_pop($this->requests_cache);
            $api_call = $api_request[0];
            $request = $api_request[1];

            $response = $this->api_call($api_call, $request);
            $this->log_response($response);
            if (!$this->is_server_available($response)) {
                array_push($this->requests_cache, $api_request);
                break;
            }
        }
    }

    private function log_response($response) {
        if (!$this->is_response_in_error($response)) {
            $this->debug_log(self::MODULE, " Succeeded :" . $full_api_uri . " : ", $http_args, "\n\tResponse=", $response);
        } else if (!$response->is_server_available()) {
            $this->error_log(self::MODULE, " >>>>Server is not available:" . $full_api_uri, ": WP_Error ", $response);
        } else if ($response->is_non_server_error()) {
            $this->error_log(self::MODULE, " WP_Error:" . $full_api_uri, ": WP_Error ", $response);
        } else if ($response->is_bad_request()) {
            $this->error_log(self::MODULE, " Failed : Reason: 400 Bad request. Request validation error, flow definition not found : " . $full_api_uri . " : ",
                $http_args, "\n\tRequest=", $request, "\tResponse=", $response);
        } else {
            // if the status code is 401 - then the user api_key is invalid.
            // run the user through the registration process. This will mean refactoring the admin registration code.
            // QUESTIONs
            // 1. Should this class be "dumb", in the sense that it should not contain any business, rather only a means to communicate to the server?
            // 2. What about this solution: the caller of this method (api_call), should decide whether to reregister or not.
            // So, in this case, FarReaches_Admin, when it calls communcation->api_call, and receives 401, it calls register_all_interesting_users to reregister
            // PAT: don't want to get into this just yet.
            $this->error_log(self::MODULE, " >>>>FAILED API CALL:" . $full_api_uri . " : ", $http_args, "\n\tResponse=", $response);
        }
    }
}

class FarReaches_Communication_Error {
    /**
     * 0 if there is no http_status associated with the error.
     * @var unknown_type
     */
    private $http_status;
    /**
     * string or WP_Error
     * @var unknown_type
     */
    private $error;

    private $server_available;

    private $parsed_response;

    public function __construct($http_status, $error, $server_available = true, $parsed_response = null) {
        $this->http_status = $http_status;
        $this->error = $error;
        $this->server_available = $server_available;
        $this->parsed_response = $parsed_response;
    }

    public function is_server_available() {
        return $this->server_available;
    }

    public function get_error() {
        return $this->error;
    }

    public function get_parsed_response() {
    	return $this->parsed_response;
    }

    /**
     * Note: the name of this function matches WP_Error get_error_message() so it is easier to get error message out
     * @return unknown_type
     */
    public function get_error_message() {
        if ( $this->is_non_server_error()) {
            // assuming WP_Error
            return $this->get_error()->get_error_message();
        } else {
            return $this->get_error();
        }
    }

    /**
     * 400 = bad parameters to a flow
     * 410 = unknown flow
     */
    public function is_bad_request() {
        return $this->http_status == 400 || $this->http_status == 410;
    }

	public function is_authorization_problem() {
        return $this->http_status == 401;
    }
    public function is_not_acceptable_problem() {
    	return $this->http_status == 406;
    }
    public function is_non_server_error() {
        return is_wp_error($this->error);
    }
}

class FarReaches_Authorization_Exception extends Exception {
    public function __construct($message) {
        parent::__construct($message);
    }
}
