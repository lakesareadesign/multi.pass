<?php

/**
 * This is Wireservice Proxy. It should contain all read-only calls wireservice calls. (no write operations)
 * Any other part of the plugin that is dependent on wireservice should be refactored to be dependent on this class and not interact with wireservice directly.
 * This will allow for us to work to smarter smarter caching in the future.
 */
// DEPRECATED : move code to -settings-social-media.php and -post-handling.php as appropriate.
class FarReaches_Wireservice extends FarReaches_Base {

    const EXTERNAL_SERVICE_DEFINITION = 'externalServiceDefinition';
    const EXTERNAL_SELECTED_TOPICS = 'externalSelectedTopics';

    const CONFIG_FILE_NAME = "external-services-definitions";

    const MESSAGE_END_POINT_API_PARAM = 'messageEndPoint';
    /**
     * @var array
     */
    private $external_service_definitions;

    function __construct(
        FarReaches_Util $farReaches_Util,
        FarReaches_Communication $farReaches_Communication
    ) {
        parent::__construct($farReaches_Util, $farReaches_Communication);
        $this->external_service_definitions = $this->get_config_file_contents(self::CONFIG_FILE_NAME);
        $this->register_api_response_handler(FarReaches_Api_Call::MESSAGE_ENDPOINT_LIST, 'on_message_end_point_list_done');
    }

    /**
     * Get all configured message endpoints as tree.
     *
     * This function stores the message_endpoint_list in a cache. It first checks if the cache needs
     * to be invalidated. If it does than the API call is made to the Farreaches server and the cache is
     * refreshed. Else we check if the the cache has expired. The cache expiration time is
     * 1 day. So if any requests comes within 1 day the list is retrieved from the cache
     * rather than from the Farreaches server.
     *
     * In future we should also look at the possibility of using Alternative PHP Caching (APC). It is
     * the popular caching method and is planned to be part of PHP6 (need to find link to confirm that).
     *
     * @return array tree of message endpoints
     */
    public function get_message_endpoints_tree() {
        // TODO: rely on the cron jobs to keep refreshed and use get_option to get the current information.
        $message_end_point_list = $this->api_call(FarReaches_Api_Call::MESSAGE_ENDPOINT_LIST);
        if ($this->is_response_in_error($message_end_point_list)){
        	return $message_end_point_list;
        }else{
            /*
             * Do not mess with cache contents, just parse response every time.
             * Fixes issue with blank endpoint names on first render after cache reset.
             */
            return !is_array($message_end_point_list) ? array() : $this->parse_message_end_point_list($message_end_point_list);
        }
    }

    /**
     * Triggered upon receipt of new message_end_point information ( information may be part of another call)
     * @param FarReaches_Event $farReaches_Event
     */
    public function on_message_end_point_list_done(FarReaches_Event $farReaches_Event) {
        $message_end_point_list = $farReaches_Event->response;
        // TODO: store in options not in transient
        // note: this is periodically refreshed every 12 hours, via admin call to periodicRefresh
        $this->cache_results(FarReaches_Api_Call::MESSAGE_ENDPOINT_LIST, $message_end_point_list, 1200);
    }

    private function parse_message_end_point_list($message_end_point_list) {
        foreach($message_end_point_list as &$message_end_point) {
            $message_end_point['publicUriAnchorText'] = FarReaches_Params::def_first($message_end_point,
                    array('extServiceUserFullName','extServiceUsername','publicUri'), null);
            if (FarReaches_Params::key_exists('externalServiceAccount', $message_end_point)) {
                $publicUriAnchorTitle = FarReaches_Params::def_first($message_end_point['externalServiceAccount'],
                        array('extServiceUserFullName', 'extServiceUsername', 'publicUri'), null);
                if ( !empty($publicUriAnchorTitle)) {
                    $message_end_point['publicUriAnchorTitle'] = "Connected via " . $publicUriAnchorTitle;
                }
            }
        }
        return $message_end_point_list;
    }
    /**
     * Get all configured message endpoints as a flat list.
     *
     * @return array flat list of message endpoints
     */
    public function list_message_endpoints() {
        return $this->collect_message_endpoints_with_predicates();
    }

    /**
     * Get only active (non-disabled) message endpoints as a flat list.
     *
     * @return array flat list of active message endpoints
     */
    public function list_active_message_endpoints() {
        return $this->collect_message_endpoints_with_predicates('is_active');
    }

    /**
     * Check whether active message endpoints exist or not.
     *
     * @return bool true if minimum one active message endpoint exists
     */
    public function has_active_message_endpoints() {
    	$active_message_endpoints = $this->list_active_message_endpoints();
    	if (!$this->is_response_in_error($active_message_endpoints)){
    		return count($this->list_active_message_endpoints()) > 0;
    	}else{
    		return $active_message_endpoints;
    	}
    }

    /**
     * Get external service definitions.
     *
     * @return array of external service definitions
     */
    public function get_external_service_definitions() {
        return $this->external_service_definitions;
    }

    /**
     * Get attribute value of an external service definition.
     *
     * @param string $external_service_definition_name
     * @param string $attribute_name
     * @return mixed attribute value
     */
    public function get_external_service_attribute($external_service_definition_name, $attribute_name) {
        $external_service_definition = $this->get_external_service_definition_by_name($external_service_definition_name);
        $attribute = FarReaches_Params::def($external_service_definition, $attribute_name);
        if ( $attribute != null) {
            return $attribute;
        } else {
            $this->debug_log("External service definition with name '$external_service_definition_name' has no attribute '$attribute_name'");
            return null;
        }
    }

    /**
     * Invoked after each FarReaches_Api_Call::MESSAGE_ENDPOINT_CATEGORIES_CONFIGURE
     * @deprecated should be at the FarReaches_Api_Call level
     */
    public function clear_mep_list_cache() {
        $this->farReaches_Communication->clear_cached_results(FarReaches_Api_Call::MESSAGE_ENDPOINT_LIST);
    }

    /**
     * Get external service definitions of message endpoints associated with specified categories.
     *
     * @param array|int $category_ids either one id or array of ids. In case of array matched external service definitions names are merged.
     * @param bool $only_active OPTIONAL If true then only active definition namespaces will be returned. False if not specified.
     * @return array of external service definitions names
     */
    public function get_external_service_definitions_associated_with_categories($category_ids, $only_active = false) {
        $definitions = array();
        if (empty($category_ids)) {
            return $definitions;
        }
        foreach ($this->list_message_endpoints_associated_with_categories($category_ids, $only_active) as $message_endpoint) {
            $definitions[] = $this->get_external_service_definition_by_name(FarReaches_Params::string($message_endpoint,self::EXTERNAL_SERVICE_DEFINITION));
        }
        return $definitions;
    }

    /**
     * Get message endpoints associated with specified categories.
     *
     * @param array|int $category_ids either one key or array of keys. In case of array matched external service definitions names are merged.
     * @param bool $only_active OPTIONAL If true then only active definition namespaces will be returned. False if not specified.
     * @return array of message endpoints
     */
    public function list_message_endpoints_associated_with_categories($category_ids, $only_active = false) {
        $message_endpoints = array();
        if (!empty($category_ids)) {
            $category_id_array = FarReaches_Util::ensure_array($category_ids);
            $message_endpoints_with_categories = $this->list_message_endpoints_with_associated_categories($only_active);
            if (!$this->is_response_in_error($message_endpoints_with_categories)){
            	foreach ($message_endpoints_with_categories as $message_endpoint) {
            		if (count(array_intersect($category_id_array, $message_endpoint[self::EXTERNAL_SELECTED_TOPICS])) > 0) {
            			$message_endpoints[] = $message_endpoint;
            		}
            	}
            }
        }
        return $message_endpoints;
    }

    public function has_active_message_endpoints_associated_with_categories($category_ids) {
    	$res = $this->list_message_endpoints_associated_with_categories($category_ids, true);
    	if ($this->is_response_in_error($res)){
    		return $res;
    	}
        return count($res) > 0;
    }

    private function list_message_endpoints_with_associated_categories($only_active) {
        $predicates = array('has_associated_categories');
        if ($only_active) {
            $predicates[] = 'is_active';
        }
        return $this->collect_message_endpoints_with_predicates($predicates);
    }

    private function collect_message_endpoints_with_predicates($predicate_methods = array()) {
        $message_endpoints_tree = $this->get_message_endpoints_tree();
        if (!$this->is_response_in_error($message_endpoints_tree)) {
            if ( empty($predicate_methods) ) {
                $message_endpoints = $message_endpoints_tree;
            } else {
                $message_endpoints = array();
                $predicates = array();
                foreach (FarReaches_Util::ensure_array($predicate_methods) as $method) {
                    // TODO: fix should allow for methods from outside WireService
                    $predicates[] = array($this, $method);
                }
                foreach ($message_endpoints_tree as $message_endpoint) {
                    $should_be_collected = true;
                    foreach ($predicates as $predicate) {
                        if (!call_user_func($predicate, $message_endpoint)) {
                            $should_be_collected = false;
                            break;
                        }
                    }
                    if ($should_be_collected) {
                        $message_endpoints[] = $message_endpoint;
                    }
                }
            }
            return $message_endpoints;
        }else{
        	return $message_endpoints_tree;
        }
    }

    /**
     * may return null because plugin may not know about every external_service_definition on the wireserver.
     * Currently the plugin should know about all definitions.
     *
     * However, past bugs have resulted in the wireserver forgetting about which
     * external service definition is attached to the message end point or a message.
     *
     * The plugin should not fail just because some information is not available from the wireserver.
     *
     * @param unknown_type $name
     * @return unknown
     */
    public function get_external_service_definition_by_name($name) {
        if ( !empty($name)) {
            foreach ($this->external_service_definitions as $definition) {
                if ($definition['name'] == $name) {
                    return $definition;
                }
            }
        }
        $this->debug_log("No external service definition with name '$name'");
        return null;
    }

    private function is_active(array $message_endpoint) {
        return !array_key_exists('inactiveState', $message_endpoint);
    }

    private function has_associated_categories(array $message_endpoint) {
        return !empty($message_endpoint[self::EXTERNAL_SELECTED_TOPICS]) && is_array($message_endpoint[self::EXTERNAL_SELECTED_TOPICS]);
    }

    /**
     *
     * @param unknown $category
     * @param string $message_end_points
     * @return boolean, true if the category is assigned to a connection.
     */
    function is_category_registered($category, $message_end_points = null) {
        $registered_categories = $this->list_registered_categories($message_end_points);
        return in_array($category->term_id, $registered_categories);
    }

    /**
     * @param string $messsage_end_points
     * @return array of all category ids which are assigned to a connection.
     */
    function list_registered_categories(array $message_end_points = null) {
        if (empty($message_end_points)) {
            $message_end_points = $this->list_message_endpoints();
        }
        $registered_categories = array();
        if (!$this->is_response_in_error($message_end_points)){
        	foreach ($message_end_points as $message_end_point) {
        		if (array_key_exists(FarReaches_Wireservice::EXTERNAL_SELECTED_TOPICS, $message_end_point)) {
        			$registered_categories = array_merge($registered_categories, $message_end_point[FarReaches_Wireservice::EXTERNAL_SELECTED_TOPICS]);
        		}
        	}
        	$registered_categories = array_unique($registered_categories);
        }
        return $registered_categories;
    }

    /**
     *
     * Combines ids into tulips of (id, 'type') form.
     * Needed for server to properly distinguish between differrent entity types: posts, categories, etc.
     *
     * @param array $ids
     * @param unknown $entity_type
     * @return multitype:multitype:unknown
     */
    private function add_entity_type_info(array $ids, $entity_type) {
    	$result = array();
    	foreach ($ids as $id) {
    		$result[] = array($id, $entity_type);
    	}
    	return $result;
    }

}
