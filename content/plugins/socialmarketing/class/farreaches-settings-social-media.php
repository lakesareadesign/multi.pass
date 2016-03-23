<?php
/**
 * Provides an interface to allow the admin review and confirm to allow the plugin.
 *
 * TODO: MUST also be responsible for periodically checking with the wireserver
 * to help make sure the plugin is in sync with the wireserver. This is good to handle
 * wordpress db backup and restore resulting in the plugin losing track of which posts
 * were sent.
 *
 */
class FarReaches_Settings_Social_Media extends FarReaches_Ui_Using {

    private $farReaches_Admin;

    private $farReaches_Notifications_Manager;

    private $farReaches_Post_Handling;

    private $farReaches_Wireservice;

    const KEY_EXTERNAL_SERVICE_DEFINITION = 'externalServiceDefinition';
    const ON_COMPLETE_SIGNUP_STEP_2 = 'farreaches://FarReaches_Settings/complete_signup_step_2';
    const ON_UPDATE_SOCIAL_MEDIA_SETTINGS = 'farreaches://FarReaches_Settings/update_social_media_settings';
    const ON_MESSAGE_END_POINT_FORGET = 'farreaches://message-endpoint/forget';
    const ON_EXTERNAL_SERVICE_CONNECT = 'farreaches://external-service/connect';
    const ON_MESSAGE_END_POINT_ACTIVATE = 'farreaches://message-endpoint/activate';
    const ON_EXTERNAL_SERVICE_PREPARE_REDIRECT = 'farreaches://external-service/prepare-redirect';
    const ON_EXTERNAL_SERVICE_REDIRECT = 'farreaches://external-service/redirect';

    function __construct(FarReaches_Util $farReaches_Util,
            FarReaches_Communication $farReaches_Communication,
            FarReaches_Ui_Handling $farReaches_Ui_Handling,
            FarReaches_Admin $farReaches_Admin,
            FarReaches_Post_Handling $farReaches_Post_Handling,
            FarReaches_Notifications_Manager $farReaches_Notifications_Manager,
            FarReaches_Wireservice $farReaches_Wireservice
    ) {
        parent::__construct($farReaches_Util, $farReaches_Communication, $farReaches_Ui_Handling);
        $this->farReaches_Wireservice = $farReaches_Wireservice;
        $this->farReaches_Admin = $farReaches_Admin;
        $this->farReaches_Post_Handling = $farReaches_Post_Handling;
        $this->farReaches_Notifications_Manager = $farReaches_Notifications_Manager;

        FarReaches_EventBus_Facade::subscribeMe($this,
        array(
        self::ON_COMPLETE_SIGNUP_STEP_2 => 'on_complete_signup_step_2',
        self::ON_UPDATE_SOCIAL_MEDIA_SETTINGS => 'on_update_social_media_settings',
        self::ON_EXTERNAL_SERVICE_CONNECT => 'on_external_service_connect',
        self::ON_MESSAGE_END_POINT_FORGET => 'on_message_end_point_forget',
        self::ON_MESSAGE_END_POINT_ACTIVATE => 'on_message_end_point_activate',
        self::ON_EXTERNAL_SERVICE_PREPARE_REDIRECT => 'on_external_service_prepare_redirect',
        ), true);
    }

    public function show_page_social_media_settings() {
        wp_enqueue_script(FarReaches_Ui_Handling::FARREACHES_SETTINGS_JS);
        // TODO : use the feature paid mechanism to show minimal if needed.
        // key off of - is there an end point or not?
        $plugin_state = $this->get_plugin_state();
        if ( $plugin_state == FarReaches_Plugin_State::SYNCED) {
            // display the full configuration screen if the user already has things configured.
            $this->_show_page_social_media_settings();
        } else {
            $this->show_page_activate_complete_signup_step_2();
        }
    }
    /**
     * Page to show after activation to get the social media connections
     */
    private function _show_page_social_media_settings() {
        $invalidate_endpoint_cache = FarReaches_Get::boolean("invalidate");
        if ($invalidate_endpoint_cache) {
            $this->farReaches_Wireservice->clear_mep_list_cache();
        }
        if ( current_user_can(FarReachesFoundation_Permissions::READ_FARREACHES_SOCIAL_MEDIA_SETTINGS_CAP)) {
            $message_endpoints = $this->farReaches_Wireservice->list_message_endpoints();
            if ( $this->is_response_in_error($message_endpoints) ) {
                $this->add_js_config('settings_page_error_occurred', true);
            }

            $data = array(
                    'external_service_definitions' => $this->farReaches_Wireservice->get_external_service_definitions(),
                    'page_name' => $this->__(FarReaches_Admin::SOCIAL_MEDIA_ACCOUNT_SETTINGS_PAGE_NAME));
            $endpoints_data = $this->prepare_endpoints_data($message_endpoints);
            if (count($endpoints_data) > 0) {
                $data['message_end_points'] = $endpoints_data;
            } 
            if ( current_user_can(FarReachesFoundation_Permissions::EDIT_FARREACHES_SOCIAL_MEDIA_CATEGORIES_CAP)) {
                $data['publish_topic'] = self::ON_UPDATE_SOCIAL_MEDIA_SETTINGS;
            }
            if ( current_user_can(FarReachesFoundation_Permissions::EDIT_FARREACHES_SOCIAL_MEDIA_SETTINGS_CAP)) {
                $data['message_end_point_forget_topic'] = self::ON_MESSAGE_END_POINT_FORGET;
                $data['message_end_point_activate_topic'] = self::ON_MESSAGE_END_POINT_ACTIVATE;
                $data['external_service_connect_topic'] = self::ON_EXTERNAL_SERVICE_CONNECT;
            }
            $this->generate_jsrender_template(array('key' => FarReaches_Admin::SOCIAL_MEDIA_ACCOUNT_SETTINGS_MENU_SLUG), true, $data);
        }
    }
    
    private function prepare_endpoints_data($message_endpoints = null) {
        global $wpdb;
        $result = array();
        $delayed_posts_ids = $wpdb->get_results("select post_id from wp_postmeta where meta_key='_farreaches.messagethread' and meta_value like '%transmission_delayed%' order by post_id desc");
        $delayed_posts = array();
        foreach ($delayed_posts_ids as $row) {
            $post_id = $row->post_id;
        	$delayed_posts[$post_id] =  $this->farReaches_Post_Handling->get_registered_categories_associated_with_post(get_post($post_id));
        }
        
        if ( !empty($message_endpoints) && !$this->is_response_in_error($message_endpoints)) {
            $external_service_definition_map = $this->get_external_service_definition_map();
            foreach ($message_endpoints as $message_end_point) {
                $endpoint_delayed_posts = array();
                foreach ($delayed_posts as $post_id => $registered_categories) {
                    if (count(array_intersect($registered_categories, $message_end_point['externalSelectedTopics'])) > 0) {
                        $post_status = array('title' => get_the_title($post_id), 'postId' => $post_id, 'link' => get_edit_post_link($post_id));
                        $post_status = array_merge($post_status, $this->farReaches_Post_Handling->get_post_local_transmission_status_object($post_id));
                        $endpoint_delayed_posts[] = $post_status;
                    }                	
                }
                if (!empty($endpoint_delayed_posts)) {
                	$message_end_point['delayedPosts'] = $endpoint_delayed_posts;
                }
                $endpointClass = '';
                if (!empty($message_end_point['inactiveState'])) {
                    $endpointClass = $endpointClass.' farreaches-endpoint-inactive fareraches-endpoint-'.$message_end_point['inactiveState'];	
                }
                $categories = get_categories(array('orderby' => 'name', 'order' => 'ASC', 'hide_empty' => false));
                $categories_array = $this->get_categories_map($message_end_point, $categories);
                $message_end_point['categories'] = $categories_array;
                $message_end_point['cssClass'] = $endpointClass;
                $message_end_point['externalSelectedTopics'] = implode(' ', $message_end_point['externalSelectedTopics']);
                $definition_name = $message_end_point[self::KEY_EXTERNAL_SERVICE_DEFINITION];
                $service_name = $external_service_definition_map[$definition_name]['service_name'];
                $message_end_point['service_name'] = $service_name;
                $endpoint_key = $message_end_point['lookupKey'];
                $query = $wpdb->prepare(
                            "select post_id from wp_postmeta where meta_key='_farreaches.messagethread' and meta_value like '%s' order by post_id desc", 
                            '%'.$endpoint_key.'%');
                $rows = $wpdb->get_results($query);
                if (is_array($rows) && count($rows) > 0) {
                	$message_end_point['posts'] = array();
                	foreach ($rows as $row) {
                	    $post_remote_transmission_status = $this->get_messageThread_meta($row->post_id, array(FarReaches_Post_Handling::FARREACHES_STATUS, FarReaches_Post_Handling::REMOTE_STATUS));
                	    $post_status = array('title' => get_the_title($row->post_id));
                	    $post_status = array_merge($post_status, $this->farReaches_Admin->get_display_post_external_status($row->post_id, $post_remote_transmission_status[$endpoint_key][0]));
                	    $post_status['postId'] = $row->post_id;
                	    $message_end_point['posts'][] = $post_status;
                	}
                }
                $result[] = $message_end_point;
            }
        }
        return $result;
    }

    /**
     * social media accounts when configuring
     */
    private function show_page_activate_complete_signup_step_2() {
        wp_enqueue_script(FarReaches_Ui_Handling::FARREACHES_ACTIVATION_JS);
        if ( !current_user_can(FarReachesFoundation_Permissions::MANAGE_FARREACHES_PLUGIN_CAP)) {
            $this->farReaches_Ui_Handling->output_farreaches_html("You do not have permission to view this page.");
        } else {
            $message_endpoints = $this->farReaches_Wireservice->list_message_endpoints();
            $external_service_definition_map = $this->get_external_service_definitions($message_endpoints);

            $data = array(
                    'external_service_definitions' => $external_service_definition_map,
                    'publish_topic' => self::ON_COMPLETE_SIGNUP_STEP_2,
                    'message_end_point_forget_topic' => self::ON_MESSAGE_END_POINT_FORGET,
                    'message_end_point_activate_topic' => self::ON_MESSAGE_END_POINT_ACTIVATE,
                    'external_service_connect_topic' => self::ON_EXTERNAL_SERVICE_CONNECT
            );
            $landing_url = $this->farReaches_Admin->get_farreaches_admin_page_url(FarReaches_Admin::SOCIAL_MEDIA_ACCOUNT_SETTINGS_MENU_SLUG);
            $post_create_url = admin_url('post-new.php');
            $this->add_js_config('activation_landing_url', $landing_url);
            $this->add_js_config('post_create_url', $post_create_url);
            $this->add_js_config('plugin_state', $this->get_plugin_state());

            $this->generate_jsrender_template(array('key' => FarReaches_Admin::ACTIVATE_CONFIRM_STEP_2_MENU_SLUG), true, $data);
        }
    }
    /**
     * When completing the signup all connections are by default connected to all categories.
     * @param array $data
     */
    public function on_complete_signup_step_2(FarReaches_Event $farReaches_Event) {
        $this->on_update_social_media_settings($farReaches_Event);
        $this->farReaches_Admin->add_user_redirect(admin_url( 'post-new.php'), false);
    }

    /**
     * called when updating the social_media settings page ( and indirectly when completing the sign up )
     * @param FarReaches_Event $farReaches_Event
     */
    public function on_update_social_media_settings(FarReaches_Event $farReaches_Event) {
        // only checking EDIT_FARREACHES_SOCIAL_MEDIA_CATEGORIES_CAP because connecting MEPs is currently handled async.
        if ( !current_user_can(FarReachesFoundation_Permissions::EDIT_FARREACHES_SOCIAL_MEDIA_CATEGORIES_CAP)) {
            $this->farReaches_Ui_Handling->output_farreaches_html("You do not have permission to view this page.");
        } else {
            $data = $farReaches_Event->data;
            $message_end_point_list = $this->farReaches_Wireservice->list_message_endpoints();
            foreach ($message_end_point_list as $message_end_point) {
                $message_end_point_id = $message_end_point[FarReaches_Post_Handling::LOOKUP_KEY];
                $category_data_key = 'categories-'.$message_end_point_id;
            	if (array_key_exists($category_data_key, $data)) {
                    $category_data = is_string($data[$category_data_key]) ? explode(' ', $data[$category_data_key]) : array();
                    $category_data = array_filter($category_data);
                    // TODO: this results in 1 call per MEP - not called enough to be critical - but in future we will want to handle this as a single call.
            		$this->toggle_external_service_category($message_end_point_id, $category_data);
            	}
            }
            $this->farReaches_Notifications_Manager->notify_user('settings_saved_successfully');
            $this->set_plugin_state(FarReaches_Plugin_State::SYNCED);
        }
    }

    private function toggle_external_service_category($message_end_point_id, $connected_category_data) {
        $this->debug_log("toggle_external_service_category ", $message_end_point_id, $connected_category_data);

        $message_end_point_list = $this->farReaches_Wireservice->get_message_endpoints_tree();
        $this->check_response_in_error($message_end_point_list, "FarReach.es had a problem");

        if (!empty($message_end_point_list)) {
            $message_end_point = $this->find_endpoint_by_id($message_end_point_id, $message_end_point_list);
            if ($message_end_point) {
                $categories = $this->get_ext_service_categories_by_mep($message_end_point);
                $this->debug_log("Unmodified list of categories : ", $categories);
                $change_made = (count(array_diff($categories, $connected_category_data)) + count(array_diff($connected_category_data, $categories))) > 0;
                if ($change_made) {
                    foreach ($connected_category_data as $category) {
                        $this->register_category(get_category($category), true);                    	
                    }
                    $this->set_external_service_categories($message_end_point, $connected_category_data);
                } else {
                    $this->debug_log("No changes made on message_point_id = ", $message_end_point_id);
                }
            } else {
                //we didn't get a message end point(ie no server) so whistle blow, don't try to do stuff
                //TODO error message should be shown
            }
        }
    }

    /**
     * $category : wordpress category object
     * $force : if true then even if the category is registered with farreach.es, resend the information.
     *          Used when the category has been changed on the wordpress installation.
     * TODO : how to handle category hierarchy?
     *
     * NOTE: This function *purposely* does not configure message end points.
     *   Reason: this allows an unprivledged user to send content in different categories without giving them the ability
     *   to add destinations.
     *
     * New categories should only be added to farreach.es if it is used by a post that is sent to farreach.es
     * @returns true, if successful
     */
    private function register_category($category, $force = false) {
        $this->debug_log("register_category category=", $category);
        $category_registered = $this->farReaches_Wireservice->is_category_registered($category);
        if (!$category_registered || $force == true) {
            $request = array(
                    'category.name' => $category->name,
                    // slug is urlencode()
                    'category.tag' => urldecode($category->slug),
                    'category.additionalDescription' => $category->description,
                    // need the blog url in here for communicating between multiple sites
                    // also insurance against multisite installations (?)
                    // TODO: revisit this - but externalId should be opaque to farrreach.es server.
                    'externalContentId' => array($category->term_id, 'tag')
            );
            $full_response = $this->api_call(FarReaches_Api_Call::CATEGORY_REGISTER, $request);
            $this->check_response_in_error($full_response, "When trying to register a category");
        }
        return $category_registered;
    }

    // TODO : cache temporarily
    function get_external_service_definition_map() {
        $external_service_definitions = $this->farReaches_Wireservice->get_external_service_definitions();
        $external_service_definition_map = array();
        foreach ($external_service_definitions as &$definition) {
            $external_service_definition_map[$definition['name']] = &$definition;
        }
        return $external_service_definition_map;
    }

    /**
     * TODO: this is the popup -- do we really need this? The use of PRE_ACTIVE argues -- no.
     * TODO: create a static html to avoid any wp running. wp running could result in interference.
     */
    public function show_page_complete_connection_configuration(){
        $this->farReaches_Wireservice->clear_mep_list_cache();
        $messageEndPointLookupKey = FarReaches_Request::get('messageEndPoint', null);
        if ($messageEndPointLookupKey != null) {
            $response = $this->api_call(FarReaches_Api_Call::MESSAGE_ENDPOINT_LIST, array('messageEndPoint' => $messageEndPointLookupKey));
            if (!$this->is_response_in_error($response)) {
                // TODO : should be in event handler.
                $messageEndPoints = $response;
                $this->generate_jsrender_template(array('key' => 'complete_connection_configuration'), true, array(
                        'message_end_points' => $messageEndPoints));
            } else {
                //TODO report error?
            }
        } else {
            $redirect_data = FarReaches_Request::get_all();
            if (!array_key_exists(self::KEY_EXTERNAL_SERVICE_DEFINITION, $redirect_data)
                    || empty($redirect_data[self::KEY_EXTERNAL_SERVICE_DEFINITION])) {
                //If redirect parameter was stripped off by external service, load it from cookie.
                $redirect_data[self::KEY_EXTERNAL_SERVICE_DEFINITION] = $_COOKIE[self::KEY_EXTERNAL_SERVICE_DEFINITION];
            }
            $this->add_js_config('redirectData', $redirect_data);
        }
        // override default
        $this->add_js_config(FarReaches_EventBus_Bridge_Javascript::BROWSER_EVENT_SYNC_INTERVAL, 2000);
        wp_enqueue_script(FarReaches_Ui_Handling::FARREACHES_SETTINGS_JS);
        wp_enqueue_script(FarReaches_Ui_Handling::FARREACHES_COMPLETE_CONNECTION_CONFIGURATION_JS);
    }

    /**
     * EventBus Listener for the topic "farreaches://external-service/connect"
     */
    public function on_external_service_connect(FarReaches_Event $farReaches_Event) {
        if ( current_user_can(FarReachesFoundation_Permissions::EDIT_FARREACHES_SOCIAL_MEDIA_SETTINGS_CAP)) {
            //We only count active endpoint so re-enabling after auth problem is always possible.
            //$message_endpoints = $this->farReaches_Wireservice->list_active_message_endpoints();
            //$this->check_response_in_error($message_endpoints);
            //$end_points_count = count($message_endpoints);
            // TODO: This error can be triggered if the setting screen is displayed while the wireserver is down ( so no message_end_points are found)
            // the user then tries to connect. Getting this message :
            // TODO: make the check based on 1 of each accounts.
            // $feature_set = $this->get_feature_set();
            //FarReaches_Validate::false($feature_set->exceeds_maximum_end_point($end_points_count + 1), 'You have reached your connection limit. Upgrade you subscription to extend it or remove unneeded connections.');
            $response = $this->initiate_secured_api_call(FarReaches_Api_Call::EXTERNAL_SERVICE_CONFIGURE,
            $farReaches_Event->data, null, null, self::ON_EXTERNAL_SERVICE_PREPARE_REDIRECT);
            $this->check_response_in_error($response);
        } else {
            // TODO: some sort of notification
        }
    }

    public function on_external_service_prepare_redirect(FarReaches_Event $farReaches_Event) {
        $temporaryApiKey = $farReaches_Event->temporaryApiKey;
        $call_data = $farReaches_Event->apiData;
        $user = $farReaches_Event->user;
        if ( current_user_can(FarReachesFoundation_Permissions::EDIT_FARREACHES_SOCIAL_MEDIA_SETTINGS_CAP)) {
            $data = array(
                    'fsRedirectUrl' => $this->farReaches_Admin->get_farreaches_admin_page_url(FarReaches_Admin::COMPLETE_CONNECTION_CONFIGURATION_MENU_SLUG).'&'.self::KEY_EXTERNAL_SERVICE_DEFINITION.'='.$call_data[self::KEY_EXTERNAL_SERVICE_DEFINITION],
                    'redirectProperties' => "['messageEndPoint']",
                    'apiKey' => $temporaryApiKey
            );
            $data = array_merge($data, $call_data);
            $redirectUrl = $this->farReaches_Communication->get_full_api_uri(
                    FarReaches_Api_Call::EXTERNAL_SERVICE_CONFIGURE, $data
            );
            $farReaches_Event = new FarReaches_Event($user);
            $farReaches_Event->redirectUrl = $redirectUrl;
            FarReaches_EventBus_Facade::publish(self::ON_EXTERNAL_SERVICE_REDIRECT, $farReaches_Event, $this->get_user_id($user));
        } else {
            // TODO: some sort of notification
        }
    }

    /**
     * Returns FarReaches server URL that sets inactive state of a message endpoint to HISTORICAL, can be reverted by a user.
     *
     * EventBus Listener for the topic "farreaches://external-service/forget"
     */
    public function on_message_end_point_forget(FarReaches_Event $farReaches_Event) {
        $message_endpoint_ids = $farReaches_Event->data;
        $message_endpoint_ids = FarReaches_Util::ensure_array($message_endpoint_ids);
        if ( current_user_can(FarReachesFoundation_Permissions::EDIT_FARREACHES_SOCIAL_MEDIA_SETTINGS_CAP)) {
            if (count($message_endpoint_ids) > 0) {
                $response = $this->api_call(FarReaches_Api_Call::MESSAGE_ENDPOINT_INACTIVATE, array('messageEndPointList' => $message_endpoint_ids));
                $this->check_response_in_error($response, 'Failed to finish setup, try again.');
            }
        } else {
            // TODO: some sort of notification
        }
        return $message_endpoint_ids;
    }

    public function on_message_end_point_activate(FarReaches_Event $farReaches_Event) {
        $message_endpoint_ids = $farReaches_Event->data;
        $message_endpoint_ids = FarReaches_Util::ensure_array($message_endpoint_ids);
        if ( current_user_can(FarReachesFoundation_Permissions::EDIT_FARREACHES_SOCIAL_MEDIA_SETTINGS_CAP)) {
            $point_count = count($message_endpoint_ids);
            if ($point_count > 0) {
                $active_point_count = count($this->farReaches_Wireservice->list_active_message_endpoints());
                // TO_KOSTYA: we want this enforced by the server.
                //                 $feature_set = $this->get_feature_set();
                //                 FarReaches_Validate::false($feature_set->exceeds_maximum_end_point($active_point_count + $point_count), 'Too many connection selected. You have to select less connections to stay within your limit.');
                $response = $this->api_call(FarReaches_Api_Call::MESSAGE_ENDPOINT_ACTIVATE, array('messageEndPointList' => $message_endpoint_ids));
                $this->check_response_in_error($response, 'Failed to finish setup, try again.');
            }
        } else {
            // TODO: some sort of notification
        }
        return $message_endpoint_ids;
    }

    /*Returns category_array with add or remove set*/
    private function get_categories_map($message_end_point, $categories) {
        $categories_array = array();
        $message_end_point_id = $message_end_point[FarReaches_Post_Handling::LOOKUP_KEY];
        $farreaches_categories = $message_end_point['externalSelectedTopics'];
        foreach ($categories as $category) {
            $category_assigned = !empty($farreaches_categories) && in_array($category->term_id, $farreaches_categories);
            $categories_array[] = array(
                    'name' => $category->name,
                    'class' =>  $category_assigned? 'farreaches-assigned': '',
                    'message_end_point_id' => $message_end_point_id,
                    'category' => $category->term_id,
                    'category_assigned' => $category_assigned);
        }
        return $categories_array;
    }

    private function get_ext_service_categories_by_mep($message_end_point) {
        // lets make sure this is an array so we don't get an error (in_array 2nd value not an array)
        if ($message_end_point['externalSelectedTopics']) {
            $categories = $message_end_point['externalSelectedTopics']; // validate this works, doesn't have an array inside an array
        } else {
            $categories = array();
        }

        return $categories;
    }
    private function set_external_service_categories($message_end_point, $category_ids) {
        $this->debug_log($message_end_point, ": Edited list of categories : ", $category_ids);
        $category_ids = $this->farReaches_Post_Handling->add_entity_type_info($category_ids, 'tag');
        $parameters = array(
                'externalCategorySelection' => $category_ids,
                FarReaches_Wireservice::MESSAGE_END_POINT_API_PARAM => $message_end_point[FarReaches_Post_Handling::LOOKUP_KEY]);
        $response = $this->initiate_secured_api_call(FarReaches_Api_Call::MESSAGE_ENDPOINT_CATEGORIES_CONFIGURE, $parameters);

        $this->check_response_in_error($response, "Problem changing categories on the external services");
    }

    private function find_endpoint_by_id($message_end_point_id, array $message_end_point_list) {
        foreach ($message_end_point_list as $message_end_point) {
            if ($message_end_point_id == $message_end_point[FarReaches_Post_Handling::LOOKUP_KEY]) {
                return $message_end_point;
            }
        }
        return null;
    }
    /**
     * Sort the Message end point that are derived from a external service like Facebook, Twitter, Tumblr.
     * Example: Sort the Facebook pages based on their inactiveState
     *
     * @static
     */
    static function compare_by_inactive_state($a, $b) {
        return self::compare_by_key_presence($a, $b, 'inactiveState');
    }

    private static function compare_by_key_presence(array $a, array $b, $key, $greater_if_key_present = true, $string_key = false) {
        if (array_key_exists($key, $a) && !array_key_exists($key, $b)) {
            return $greater_if_key_present ? 1 : -1;
        } else if (!array_key_exists($key, $a) && array_key_exists($key, $b)) {
            return $greater_if_key_present ? -1 : 1;
        } else {
            return empty($string_key) ? 0 : strcmp($a[$string_key], $b[$string_key]);
        }
    }

}
