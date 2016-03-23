<?php
/**
 * provides wrapper/sanity methods around wordpress.
 * Ideally the need for the wrapper methods will go away because wordpress will improve.
 *
 * NOTE: Race condition if 2 different users cause the options or metadata to be updated. As much as possible use
 * user metadata to store things like messages to users.
 * This can happen particularily when deleting metadata and removing empty subtrees.
 */

class FarReaches_Util {
    private $plugin_file;
    private $plugin_url;
    private $plugin_directory;
    private $json_service;
    private $plugin_display_name;

    const MESSAGE_THREAD_KEY_BASE = 'messagethread';
    const ENVELOPE_KEY_BASE = 'envelope';
    const PLUGIN_STATE_OPTION_KEY = 'plugin_state';

    // used to configure FarReaches_Util
    const ARG_KEY_CACHE_ENABLED = 'cache_enabled';
    // the cached values must be cleared once. (then this is reset)
    const ARG_KEY_CACHE_CLEAR = 'cache_clear';
    // NOTE: a leading '_' means that the meta data is not visible / editable in the post custom fields area when editing the post.
    // passed in as an option to allow tests to be more independent from each other.
    const ARG_KEY_META_KEY_PREFIX = 'meta_key_prefix';
    // end config option keys

    /**
     * parameter on $_REQUEST to force all cached data to be invalidated.
     *
     * This serves as a "emergency" when-all-else-fails action to help recover from errors.
     * currently we don't have any known errors that we need this for.
     * This will also help with clearing out during any plugin upgrade.
     *
     * TODO: TO_NEWPERSON do this during activation and upgrade.
     */
    const CACHE_INVALIDATE = 'invalidate';
    /**
     * Default priority used by wordpress: Lower numbers correspond with earlier execution, and functions with the same priority are executed in the order in which they were added to the action.
     */
    const NORMAL_PRIORITY = 10;
    const LATER_PRIORITY = 100;

    /**
     * Used in get_optional_id / get_id when looking at arrays and objects for the id property
     * @var unknown
     */
    const ID_KEY = 'ID';
    /**
     * Cached config file contents
     * ( 'file_name_key' => file contents )
     * @var array
     */
    private $config_file_contents = array();

    /**
     * add_actions - saved so that for tests the actions can be removed
     * (<action_string> => <method to call> )
     * @var array
     */
    private $actions = array();

    /**
     * add_actions - saved so that for tests the actions can be removed
     * (<action_string> => <method to call> )
     * @var array
     */
    private $filters = array();

    /**
     * keys for items that *may* be cached. ( the cache may have expired the items )
     *
     * Primarily used to clear caches during testing.
     * @var array
     */
    private $cache_keys = array();

    /**
     *
     * @var array
     */
    private $options;

    public function __construct($plugin_file, array $args = array()) {
        FarReaches_Validate::not_empty($plugin_file, "need the plugin file");
        $this->options = $this->parse_args($args,
                array(self::ARG_KEY_CACHE_ENABLED => true,
                        // NOTE: a leading '_' means that the meta data is not visible / editable in the post custom fields area when editing the post.
                        // passed in as an option to allow tests to be more independent from each other.
                       self::ARG_KEY_META_KEY_PREFIX => '_farreaches.',
                       self::ARG_KEY_CACHE_CLEAR => FarReaches_Params::key_exists(self::CACHE_INVALIDATE, $_REQUEST),
                        ));
        // needed for plugin action hooks.
        $this->plugin_directory = dirname($plugin_file);
        // note the separator must be '/' for all platforms - using DIRECTORY_SEPARATOR breaks the action registration on windows
        $this->plugin_file = basename($this->plugin_directory) . '/' . basename($plugin_file);

        // we're using FR_SERVICES_JSON_LOOSE_TYPE so that we return an array instead of a stdClass
        $this->json_service = new FarReaches_JSON(FR_SERVICES_JSON_LOOSE_TYPE);
        $this->plugin_display_name = $this->__(FARREACHES_PLUGIN_DISPLAY_NAME);

        // see comment on CACHE_INVALIDATE
        $this->cache_check_for_clear();
    }

    // in future will use a standard domain of farreaches.
    public function __($string) {
        return __($string, 'default');
    }

    public function get_plugin_display_name() {
        return $this->plugin_display_name;
    }

    /*
    * decode string into json and error out if there are decoding problems as described:
    * http://www.php.net/manual/en/function.json-decode.php
    *    the name and value must be enclosed in double quotes single quotes are not valid
    *         $bad_json = "{ 'bar': 'baz' }"
    *    the name must be enclosed in double quotes
    *         $bad_json = '{ bar: "baz" }';
    *    trailing commas are not allowed
    *         $bad_json = '{ bar: "baz", }';
    */
    function json_decode($stringValue) {
        $stringValue = trim($stringValue);
        if (empty($stringValue)) {
            return array();
        }
        try {
            $json = $this->json_service->decode($stringValue);
            // TODO: A simple method to check for errors. should be replaced with get_last_json_error_message() when PHP required is >= 5.3.x
            $error_message = $this->check_for_errors($stringValue);
        } catch (Exception $exception) {
            $error_message = $exception;
            $json = null;
        }
        if (!is_null($error_message)) {
            throw new Exception("JSON decoding error '$error_message', JSON string = '$stringValue'");
        }
        return $json;
    }

    /**
     * Note:
     *  json_encode(): recursion detected in .../farreaches-plugin/class/farreaches-farReaches_Util.php on line 121
     *
     *  means that you tried to print one of the farreaches php classes. This typically happens when one of the arguments is an array pointer to a function.
     *  i.e. array($this, 'method_name')
     * TODO: note that php json_encode does not seem to do escaping correctly for " - need to investigate.
     *
     * @param object|array $object_or_array
     * @return string|mixed
     */
    function json_encode($object_or_array) {
        if (is_null($object_or_array)) {
            return '';
        } else if (is_string($object_or_array)) {
            if ( empty($object_or_array)) {
                return '""';
            } else if ($object_or_array[0] == '"' && $object_or_array[strlen($object_or_array) - 1] == '"') {
                // string is already quoted assume that is has already been json_encode'd
                return $object_or_array;
            }
        }
        // if ( defined(JSON_UNESCAPED_SLASHES) ) {
        // options added in PHP 5.3
        //  $stringValue = json_encode($object_or_array, JSON_UNESCAPED_SLASHES/*, JSON_UNESCAPED_UNICODE*/);
        //  } else {
        // Not needed if phpversion() is >= 5.4.0
        try {
            // you will get recursion warnings if you try to print a reference to one of the farreaches objects.
            // you see this in references to functions in ajax_calls.
            $stringValue = $this->json_service->encode($object_or_array);

            // Haris: a simple method to check for errors. should be replaced with get_last_json_error_message() when PHP required is >= 5.3.x
            $error_message = $this->check_for_errors($stringValue);

            // undo the escaping of '/'
            $stringValue = preg_replace("%\\\\/%", "/", $stringValue);
        } catch (Exception $exception) {
            $error_message = $exception;
        }
        //    }

        // hariso: json_last_error() not supported in 5.2.x. Replacing this method with a simpler check.
        if (!is_null($error_message)) {
            // may be having this happen while trying to report error message (avoid recursion)
            @error_log("JSON encode error " . $error_message);
        }
        return $stringValue;
    }

    /**
     *
     * @return string (returns FarReaches_Plugin_State::ACTIVATED ) if not explicitly set
     */
    public function get_plugin_state() {
        $plugin_state = $this->get_option(self::PLUGIN_STATE_OPTION_KEY);
        if (empty($plugin_state)) {
            //If no state found, assume that we are in initial state. (but do not set because that would mess up the activation sequence)
            $plugin_state = FarReaches_Plugin_State::ACTIVATED;
        }
        return $plugin_state;
    }

    /**
     *
     * @param unknown $plugin_state
     * @param FarReaches_Event|NULL $farReaches_Event
     * @param unknown $user_ids
     * @param unknown $timeout
     * @param unknown $success_handler
     * @param unknown $failure_handler
     */
    public function set_plugin_state($plugin_state,
            FarReaches_Event $farReaches_Event = NULL,
            $user_ids = null,
            $timeout = FarReaches_EventBus::DEFAULT_TIMEOUT,
            $success_handler = FarReaches_EventBus::NO_HANDLER,
            $failure_handler = FarReaches_EventBus::NO_HANDLER) {

        $old_plugin_state = $this->get_option(self::PLUGIN_STATE_OPTION_KEY);
        if ( $old_plugin_state != $plugin_state) {
            // do nothing if the plugin state is unchanged ( avoids duplicate event triggering )
            FarReaches_Validate::not_blank($plugin_state, 'Attempt to set Null or blank value as plugin state.');
            FarReaches_Validate::array_contains(FarReaches_Plugin_State::values(), $plugin_state, 'An attempt to set non plugin state constant as plugin state detected. Value: '.$plugin_state);
            $this->update_option(self::PLUGIN_STATE_OPTION_KEY, null, $plugin_state);
            FarReaches_EventBus_Facade::publish(FarReaches_Plugin_State::plugin_state_event_topic($plugin_state), $farReaches_Event, $user_ids, $timeout, $success_handler, $failure_handler);
        }
    }

    /**
     * NOTE - TODO: Multisite wp installations have add_site_option and get_site_option options.
     * We should use those in the future to store http://codex.wordpress.org/WPMU_Functions/get_site_option
     * @param unknown_type $meta_key_base
     * @param array|string $key_array
     * @return string - if supplied $key_array returns a leaf value, array if the $key_array returns a subtree or an empty array if the $key_array does not find any value.
     */
    function get_option($meta_key_base, $key_array = NULL, $returnNullIfEmpty = true) {
        $meta_key = $this->get_farreaches_meta_key($meta_key_base);
        $string = get_option($meta_key);
        if (!empty($string)) {
            return $this->_get_meta_from_key($string, $key_array);
        } else if ( $returnNullIfEmpty === true) {
            return null;
        } else {
            return array();
        }
    }

    /**
     * save options in to the wordpress wp_options table.
     * $key_array: the option_key (array)
     * $value : value to be saved in json value.
     */
    function update_option($meta_key_base, $key_array, $value) {
        $meta_key = $this->get_farreaches_meta_key($meta_key_base);
        if (empty($key_array)) {
            $updated_options = $value;
        } else {
            $existing_options = $this->get_option($meta_key, null, false);
            $updated_options = $this->set_multikeyed_value($existing_options, $key_array, $value);
        }
        if (!isset($updated_options)) {
            return delete_option($meta_key);
        } else {
            // We use our own json encoding code because php implementation seems to behave differently from one php version to another.
            $save_back = $this->json_encode($updated_options);
            return update_option($meta_key, $save_back);
        }
    }

    function delete_option($meta_key_base, $key_array) {
        return $this->update_option($meta_key_base, $key_array, null);
    }

    // WRAPPER METHODS
    /**
     * method exists primarily to make sure that we always ask for all the arguments that could possibly be passed to the action.
     * Otherwise wordpress by default only supplies the first argument (lame!)
     *
     * WARNING: do NOT attempt to add actions that only available once:
     * For example, we tried to have a one-shot action registered to handle a wireserver callback. This was not successful because there maybe different php instances
     * running. As a result, the wireservice callback may be to a different instance which did not have the one-shot action registered.
     *
	 * HINT: You can get the whole list of actual wordpress hooks if you update YOUR_WP_WORK_DIR/wp-includes/plugin.php:
     * 1) Update do_action()
     * 2) Update apply_filters()
     * Add something like: '@error_log($tag);' to log all the hook tags.
     *
     * 10 is the wordpress default priority
     * TODO: 15 jan 2013 use wrapper object so uncaught exceptions do not escape.
     */
    public function add_action($action_str, $callable, $priority = self::NORMAL_PRIORITY) {
        // there probably will not be over a thousand arguments
        $accepted_args = 1000;
        $wrapper = new FarReaches_Error_Management($callable, 'action', $action_str);
        $actual_callable = $wrapper->as_callable();
        $this->actions[] = array($action_str, $actual_callable, $priority);
        return add_action($action_str, $actual_callable, $priority, $accepted_args);
    }

    /**
     * specialized version of add_action that will ensure the current_user is set when the action is
     * invoked ( the first parameter when SCHEDULING the cron job is supposed to be the current_user_id )
     *
     * see the schedule_single_event() in base.
     *
     * @param unknown $action_str
     * @param unknown $callable
     * @param unknown $priority
     */
    public function add_cron_action($action_str, $callable, $priority = self::NORMAL_PRIORITY) {
        // there probably will not be over a thousand arguments
        $accepted_args = 1000;
        $wrapper = FarReaches_Error_Management::instantiate($callable, $action_str)->set_user();
        $actual_callable = $wrapper->as_callable();
        $this->actions[] = array($action_str, $actual_callable, $priority);
        add_action($action_str, $actual_callable, $priority, $accepted_args);
    }

    /**
     * WARNING: remove_action is very problematic and can only be used when trying to change behavior within
     * the current thread of execution.
     *
     * 10 is the wordpress default priority
     * @param unknown_type $action_str
     * @param unknown_type $that
     * @param unknown_type $method_name
     */
    public function remove_action($action_str, $callable, $priority = self::NORMAL_PRIORITY) {
        return remove_action($action_str, $callable, $priority);
    }

    /**
     * method exists primarily to make sure that we always ask for all the arguments that could possibly be passed to the action.
     * Otherwise wordpress by default only supplies the first argument (lame!)
     * 10 is the wordpress default priority
     *
	 * HINT: You can get the whole list of actual wordpress hooks if you update YOUR_WP_WORK_DIR/wp-includes/plugin.php:
     * 1) Update do_action()
     * 2) Update apply_filters()
     * Add something like: '@error_log($tag);' to log all the hook tags.
     *
     */
    function add_filter($action_str, $callable, $priority = self::NORMAL_PRIORITY) {
        // there probably will not be over a thousand arguments
        $accepted_args = 1000;
        $wrapper = new FarReaches_Error_Management($callable, 'filter', $action_str);
        $actual_callable = $wrapper->as_callable();
        $this->filters[] = array($action_str, $actual_callable, $priority);
        return add_filter($action_str, $actual_callable, $priority, $accepted_args);
    }
    /**
     * WARNING: remove_action is very problematic and can only be used when trying to change behavior within
     * the current thread of execution.
     *
     * 10 is the wordpress default priority
     * @param unknown_type $action_str
     * @param unknown_type $that
     * @param unknown_type $method_name
     */
    function remove_filter($action_str, $callable, $priority = self::NORMAL_PRIORITY) {
        return remove_filter($action_str, $callable, $priority);
    }

    /**
     * Used to help reset the tests.
     */
    public function remove_all_hooks() {
        foreach ($this->actions as $hook) {
            call_user_func_array(array($this, 'remove_action'), $hook);
        }
        unset($this->actions);
        $this->actions = array();
        foreach ($this->filters as $hook) {
            call_user_func_array(array($this, 'remove_filter'), $hook);
        }
        unset($this->filters);
        $this->filters = array();
    }

    /**
     * public for testing purposes (only)
     * @param unknown $meta_array
     * @param unknown $key_array
     * @param unknown $value
     * @return NULL|unknown_type
     */
    public function set_multikeyed_value($meta_array, $key_array, $value) {
        $key_array = $this->_make_array($key_array);
        $new_value = $this->_set_multikeyed_value($meta_array, $key_array, $value);
        // TODO only display if not a NOP operation
        // $this->debug_log("set_multikeyed_value( meta:", $meta_array, ", key: ", $key_array, ", value: ", $value, ")");
        if ($new_value === null || (is_array($new_value) && empty($new_value))) {
            // force an empty array to be returned as null so that empty trees can be collapse away
            return null;
        } else {
            return $new_value;
        }
    }

    /**
     * Note : this function is called recursively
     * @param unknown_type $meta_array
     * @param unknown_type $key_array
     * @param unknown_type $value
     * @throws InvalidArgumentException
     */
    private function _set_multikeyed_value($meta_array, $key_array, $value) {
        $arrayLength = count($key_array);
        if ($arrayLength > 0) {
            $current_key = array_shift($key_array);
            if (empty($meta_array[$current_key])) {
                $old_value = null;
            } else if (!is_array($meta_array) && !is_object($meta_array)) {
                throw new InvalidArgumentException("\$meta_array is not an array or object so it cannot be indexed. Probable cause is setting a option or metadata value with different key hierarchy.");
            } else {
                $old_value = $meta_array[$current_key];
            }

            $new_value = $this->_set_multikeyed_value($old_value, $key_array, $value);
            // cannot use empty() empty(false) === true and empty(0) === true.
            // But we need to be able to store 0 and false
            if ($new_value === null || (is_array($new_value) && empty($new_value))) {
                unset($meta_array[$current_key]);
            } else {
                $meta_array[$current_key] = $new_value;
            }
            return $meta_array;
        } else if ($value === null || (is_array($value) && empty($value))) {
            // cannot use empty() empty(false) === true and empty(0) === true.
            // But we need to be able to store 0 and false
            return null;
        } else {
            return $value;
        }
    }

    /**
    /**
     * NOTE ABOUT messageThread METADATA:
     *
     * messageThread information is always attached to the post (never a revision)
     * This means that as a user updates a post and creates revisions, the messageThread meta will stick with the current version of the post.
     *
     * TODO: handle/verify case when current revision is reverted.
     *
     * @param object $post_or_revision
     * @param array|string $key_array
     * @return string - if supplied $key_array returns a leaf value, array if the $key_array returns a subtree or an empty array if the $key_array does not find any value.
     */
    function get_messageThread_meta($post_or_revision, $key_array = null) {
        $meta_type = 'post';
        $object_id = $this->get_id($post_or_revision);
        if ($the_post = wp_is_post_revision($object_id)) {
            $object_id = $the_post;
        }
        return $this->get_meta($meta_type, $object_id, self::MESSAGE_THREAD_KEY_BASE, $key_array);
    }

    /**
     * Message Thread meta data is expected to occupy only a single row in the wp_postmeta table.
     */
    function add_messageThread_meta($post_or_revision, $key_array, $value) {
        $meta_type = 'post';
        $object_id = $this->get_id($post_or_revision);
        if ($the_post = wp_is_post_revision($object_id)) {
            $object_id = $the_post;
        }
        return $this->update_meta($meta_type, $object_id, self::MESSAGE_THREAD_KEY_BASE, $key_array, $value);
    }

    function delete_messageThread_meta($post_or_revision, $key_array = null) {
        $meta_type = 'post';
        $object_id = $this->get_id($post_or_revision);
        if ($the_post = wp_is_post_revision($object_id)) {
            $object_id = $the_post;
        }
        return $this->delete_meta($meta_type, $object_id, self::MESSAGE_THREAD_KEY_BASE, $key_array);
    }

    /**
     * NOTE ABOUT envelope METADATA:
     *
     * envelope meta sticks with the revision NOT the current revision of the post.
     *
     * This is useful for case when we are trying to track a version of the post that is sent and then immediately reedited.
     *
     * IMPORTANT :
     * TODO need to check with is_revisions_enabled($post_or_revision)
     * HACK TODO this is subject to the revisions being stored by the wordpress configuration.
     * So we do want to consider how to handle this better.
     *
     * @param array|string $key_array
     * @return string - if supplied $key_array returns a leaf value, array if the $key_array returns a subtree or an empty array if the $key_array does not find any value.
     */
    function get_envelope_meta($post_or_revision, $key_array = null) {
        $meta_type = 'post';
        return $this->get_meta($meta_type, $post_or_revision, self::ENVELOPE_KEY_BASE, $key_array);
    }

    function add_envelope_meta($post_or_revision, $key_array, $value) {
        $meta_type = 'post';
        // determine if the envelope_meta is for this version or a previous version.
        // TODO: should we put the meta always on the master post so that way we do not have to 'move' meta nor do we have to worry about the post revisions being discarded
        // in high traffic websites do they keep revisions?
        return $this->update_meta($meta_type, $post_or_revision, self::ENVELOPE_KEY_BASE, $key_array, $value);
    }

    function delete_envelope_meta($post_or_revision, $key_array = null) {
        $meta_type = 'post';
        return $this->delete_meta($meta_type, $post_or_revision, self::ENVELOPE_KEY_BASE, $key_array);
    }

    /**
     * TO_KOSTYA: NOTE: DO NOT REMOVE.
     *
     * PAT: TO_KOSTYA: We need to talk about this code - is it no longer needed because we handle envelope specific information in a better way?
     * PAT: I have temporarily restored it but not enabled it.
     *
     *  This is necessary for proper handling of envelope and messageThread specific metadata.
     *
     * called by do_action('new_inherit') so do not need to check status of passed post
     */
    function check_for_post_revision_after_publish($post) {
        if ($post->post_type == 'revision') {
            $post_id = $post->ID;
            if ($the_parent = wp_is_post_revision($post_id)) {
                $parent_post_status = get_post_status($the_parent);
                if ($parent_post_status == 'publish') {
                    $this->move_lookup_key_to_revision($the_parent, $post);
                }
            } else {
                $this->debug_log("A revision with no parent. ", $post);
            }
        }
    }

    private function move_lookup_key_to_revision($the_parent, $post) {
        $farreaches_lookupKey = $this->get_envelope_meta($the_parent, array(self::LOOKUP_KEY));
        $previous_revision = $this->get_messageThread_meta($the_parent, array('revision'));
        if (!empty($farreaches_lookupKey) /*&& there is a change between the post and current revision && is not autosave*/) {
            $this->add_envelope_meta($post, array(self::LOOKUP_KEY), $farreaches_lookupKey);
            $this->add_envelope_meta($post, array('revision'), $previous_revision);
            $this->add_messageThread_meta($the_parent, array('revision'), $post->ID);
        }
    }

    // ABOVE METHODS MUST NOT BE DELETED EVEN IF TEMPORARILY UNUSED.

    function add_user_meta($user, $meta_key, $key_array, $value) {
        $meta_type = 'user';
        $object_or_id = $this->get_user_id($user);
        return $this->update_meta($meta_type, $object_or_id, $meta_key, $key_array, $value);
    }

    /**
     * @param $user - if null then use the current_user
     */
    function get_user_meta($user, $meta_key, $key_array = null) {
        $meta_type = 'user';
        $object_or_id = $this->get_user_id($user);
        // special case to handle ajax when there is no user.
        if (isset($object_or_id)) {
            return $this->get_meta($meta_type, $object_or_id, $meta_key, $key_array);
        } else {
            return null;
        }
    }

    function delete_user_meta($user, $meta_key, $key_array = null) {
        $meta_type = 'user';
        $object_or_id = $this->get_user_id($user);
        return $this->delete_meta($meta_type, $object_or_id, $meta_key, $key_array);
    }

    /*
    * NOTE: DO NOT json_encode $value (or any part of ) before calling this method as the double json_encoded result cannot be decoded!
    * @param $meta_key - the metakey used directly in the wordpress meta db tables. If null then the first element of  $key_array is used.
    * @param $key_array - used for multivalue keys.
    *
    * Example call:
    *    update_meta('post', 3, 'farreaches.envelope', array('top', 'middle', 'child'), 'a value')
    *       (or)
    *    update_meta('post', 3, null, array('farreaches.envelope','top', 'middle', 'child'), 'a value')
    * results in:
    *    'farreaches.envelope' = "{ 'top': {'middle': { 'child': 'a value'} } }"
    *
    * being stored in the post_meta
    *
    * This is exposed ONLY for rare cases where we need to control the $meta_key_base
    * Currently only example is when looking for posts that need their statuses refreshed.
    * In this case we are creating a key that has a date stored in it (something that would normally be the value)
    *
    * @param string $meta_type
    * @param string $meta_key_base
    */
    public function update_meta($meta_type, $object_or_id, $meta_key_base, $key_array, $value) {
    	$this->debug_log("Updating metadata with key array:", $meta_type, $object_or_id, $key_array, " set to ", $value);
        $object_id = $this->get_id($object_or_id);
        $meta_key = $this->get_farreaches_meta_key($meta_key_base);
        $meta_value = $this->_update_meta($meta_type, $object_id, $meta_key, $key_array, $value);
        // TODO: detect NOPs
        return update_metadata($meta_type, $object_id, $meta_key, $meta_value /*, $prev_value */);
    }

    /**
     *
     * @param string $meta_type
     * @param number $object_id
     * @param string $meta_key
     * @param unknown $key_array
     * @param unknown $value
     * @return string
     */
    private function _update_meta($meta_type, $object_id, $meta_key, $key_array, $value) {
        $original_meta_array = $this->_get_meta($meta_type, $object_id, $meta_key);
        $meta_array = $this->set_multikeyed_value($original_meta_array, $key_array, $value);
        $meta_value = $this->json_encode($meta_array);

        // TODO : ?? - this is why we are doing the custom json encoding - string should come out pure enough to use.
        // if you need options to be sent to the json_encoding to accomplish this then do so.
        // TODO : the " in the site name was meant as a example problem - not the only such case.
        // TODO : create TEST cases to prove that the meta methods work to save and restore.
        // when updating meta data, Wordpress stips slashes. This breaks JSON strings.
        // This line prevents back slashes being removed completely from JSON strings after stripping slashes.
        $meta_value = str_replace("\\", "\\\\", $meta_value);
        return $meta_value;
    }

    private function get_meta($meta_type, $object_id, $meta_key_base, $key_array = null) {
        $meta_key = $this->get_farreaches_meta_key($meta_key_base);
        $meta_array = $this->_get_meta($meta_type, $object_id, $meta_key, $key_array);
        return $meta_array;
    }

    /**
     * returns null if using the $key_array to navigate down an object returns a null
     */
    private function _get_meta($meta_type, $object_or_id, $meta_key, $key_array = null) {
        $single = true;
        $object_id = $this->get_id($object_or_id);
        $meta_str = get_metadata($meta_type, $object_id, $meta_key, $single);
        $meta_array = $this->_get_meta_from_key($meta_str, $key_array);
        return $meta_array;
    }

    private function _get_meta_from_key($meta_str, $key_array) {
        $meta_array = $this->json_decode($meta_str);
        $key_array = $this->_make_array($key_array);
        if (!empty($key_array)) {
            foreach ($key_array as $key) {
                $meta_array = FarReaches_Params::def($meta_array,$key);
                if (!isset($meta_array) || empty($meta_array)) {
                    break;
                }
            }
        }
        return $meta_array;
    }

    private function delete_meta($meta_type, $object_or_id, $meta_key_base, $key_array = null) {
        $single = true;
        $object_id = $this->get_id($object_or_id);
        $meta_key = $this->get_farreaches_meta_key($meta_key_base);

        $meta_value = $this->_update_meta($meta_type, $object_id, $meta_key, $key_array, null);
        // TODO: detect NOPs
        if (!empty($meta_value)) {
            // still stuff left in the key
            return update_metadata($meta_type, $object_id, $meta_key, $meta_value /*, $prev_value */);
        }
        return delete_metadata($meta_type, $object_id, $meta_key);
    }

    /**
     * php converts '.' and spaces to _ ( see comments in http://php.net/manual/en/function.parse-str.php )
     * so can't use $this->get_farreaches_meta_key($meta_key_base) strings as part of a url.
     */
    function get_farreaches_meta_key($meta_key_base) {
        if (strpos($meta_key_base, $this->get_meta_key_prefix()) === 0) {
            // we already have prefix
            return $meta_key_base;
        } else {
            return $this->get_meta_key_prefix() . $meta_key_base;
        }
    }

    function get_meta_key_prefix() {
        return $this->options[self::ARG_KEY_META_KEY_PREFIX];
    }
    /**
     * IMPORTANT: This is the only place in the code where the wordpress current_user is allowed to be referenced.
     * WordPress uses a fake user that has 0 as its id. This method converts that fake user to a null to simplify conditionals.
     * Determines the user id of the passed object or the current_user if $user_or_id is not set.
     * @param \WP_User|int $user_or_id if null returns the current_user id if current_user is logged in ( i.e. current_user->ID != 0 )
     *
     * @return NULL|int null if the id of the passed $user is null and current_user has 0 as an ID.
     */
    public function get_user_id($user_or_id = null) {
        global $current_user;
        if (!isset($user_or_id)) {
            if ($current_user->ID == 0) {
                return null;
            } else {
                $user_or_id = $current_user;
            }
        }
        return $this->get_id($user_or_id);
    }

    /**
     * HACK - find some user id we can use for running cron jobs.
     * TODO : really need anonymous user for read-only operations
     * Can't be a fixed user for periodic cron jobs because a cron job could be registered 4 months ago.
     */
    public function set_a_cron_user_id() {
        if (!$this->is_current_user_set()) {
            $possible_users = array(FarReaches_Settings_Organization::TERMS_OF_SERVICE_USER_ID, FarReaches_Settings_Organization::SOCIAL_MARKETING_CONTACT_USER_ID, FarReaches_Settings_Organization::TECHNICAL_CONTACT_USER_ID);
            foreach($possible_users as $possible_user) {
                $userId = $this->get_option($possible_user);
                if (is_numeric($userId) && $userId > 0) {
                    break;
                }
            }
            // semi-HACK to make sure we are registered.
            // TODO: have null user for read-only api requests
            if( $userId > 0 ) {
                $this->set_current_user($userId);
            }
        } else {
            $userId = $this->get_user_id();
        }
        return $userId;
    }
    /**
     * TODO: Move over to FarReaches_Error_Management so that the current_user always gets set in the wrapping.
     * Sets the WordPress global $current_user if the current user's ID is 0 ( i.e. not set )
     * @param \WP_User|int $new_current_user
     * @return the new current user
     */
    public function set_current_user($new_current_user) {
        global $current_user;
        if ( $current_user->ID === 0 && isset($new_current_user)) {
            $id = $this->get_user_id($new_current_user);
            if ( $id !== 0) {
                // see wp-includes/pluggable.php
                return wp_set_current_user($id);
            }
        }
        return $current_user;
    }

    public function is_current_user_set() {
        global $current_user;
        return $current_user->ID !== 0;
    }
    public function get_id($object_or_id) {
        $object_id = $this->get_optional_id($object_or_id);
        if ( !is_numeric($object_id)) {
            // test first to avoid print_r being called unnecessarily
            FarReaches_Validate::is_numeric($object_id, "get_id() was passed a null non-numeric or object with no ID :". print_r($object_or_id,true));
        }
        return $object_id;
    }

    public function get_optional_id($object_or_id) {
        if (is_numeric($object_or_id)) {
            $object_id = $object_or_id;
        } else if (is_object($object_or_id) && property_exists($object_or_id, self::ID_KEY)) {
            $object_id = $object_or_id->ID;
        } else if (is_array($object_or_id) && array_key_exists(self::ID_KEY, $object_or_id)) {
            $object_id = $object_or_id[self::ID_KEY];
        } else {
            $object_id = null;
        }
        return $object_id;
    }

    /**
     * Ensure that the key_array is an array.
     *
     * <code>
     * _make_array('foo') == array('foo')
     * _make_array(null) == null
     * _make_array(array('foo')) == original array
     * </code>
     *
     * @param string|array $key_array
     * @throws InvalidArgumentException
     * @return array
     */
    private function _make_array($key_array) {
        if (!isset($key_array) || is_array($key_array)) {
            return $key_array;
        } else if (is_string($key_array)) {
            return array($key_array);
        } else {
            throw new InvalidArgumentException("key_array is not a string, null or array ");
        }
    }

    // TODO HACK - use/combine with above _make_array()
    public static function ensure_array($value) {
        return is_array($value) ? $value : array($value);
    }

    /**
     * @param unknown_type $cache_key_base
     * @param unknown_type $cache_value
     * @param unknown_type $expire_in_secs
     */
    function cache($cache_key_base, $cache_value, $expire_in_secs) {
        if ($this->options[self::ARG_KEY_CACHE_ENABLED]) {
            $cache_key = $this->get_cache_key($cache_key_base);
            if (!empty($cache_key)) {
                $this->cache_keys[$cache_key_base] = true;
                // wordpress get_transient() returns false if the key is not in the cache or if the transient has expired
                // this screws up detecting expired values when we are expecting a boolean or when null is a legal value to cache.
                // therefore we just always wrap in an array.
                // note this still leaves us not knowing about how to handle nulls.
                set_transient($cache_key, array($cache_value), $expire_in_secs);
            }
        }
    }

    /**
     *
     *
     * @param unknown_type $cache_key_base
     * @return NULL
     */
    function get_cached($cache_key_base) {
        $this->cache_check_for_clear();
        if ($this->options[self::ARG_KEY_CACHE_ENABLED]) {
            $cache_key = $this->get_cache_key($cache_key_base);
            if (!empty($cache_key)) {
                $wrapped_value = get_transient($cache_key);
                // see note in cache() about how we need to wrap in an array to handle caching booleans and nulls
                if ( is_array($wrapped_value)) {
                    return $wrapped_value[0];
                }
            }
        }
        // TODO : need to return a special - "no cached value" object to detect different between nothing and a cached null.
        return null;
    }

    // TODO: PAT: run cache_key through hash_hmac() so that we guarentee a key less than 45 characters but still unique
    private function get_cache_key($cache_key_base) {
        $cache_key = $this->get_farreaches_meta_key($cache_key_base);
        $cache_key_len = strlen($cache_key);
        //cache key must be 45 char or less per wp spec.
        //http://codex.wordpress.org/Function_Reference/set_transient
        FarReaches_Validate::false($cache_key_len > 45, "Cache key length must be 45 char or less as per WordPress Specification."
            . "Since the plugin prefixes the cache key base with meta key of 11 characters length, "
            . "the length of the cache base key shouldn't be greater than 34 characters. "
            . "The current length of cache base key=" . strlen($cache_key_base) . " for key '$cache_key_base'");
        return $cache_key;
    }

    /**
     * Function to clear objects in the cache. Useful for ajax calls and functions that need to force cache to be cleared in an asynchronous way
     * @param string|array $cache_key_base a key or an array of keys to clear from the cache.
     */
    function clear_cached($cache_key_base) {
        if ($this->options[self::ARG_KEY_CACHE_ENABLED]) {
            if ( is_array($cache_key_base)) {
                foreach($cache_key_base as $real_cache_key_base) {
                    $this->clear_cached($real_cache_key_base);
                }
            } else if (!empty($cache_key_base)) {
                $cache_key = $this->get_cache_key($cache_key_base);
                if (!empty($cache_key)) {
                    unset($this->cache_keys[$cache_key_base]);
                    delete_transient($cache_key);
                }
            }
        }
    }
    // TODO : problem if current code did not do the caching but previous run did cache a value
    public function clear_cached_all() {
        foreach($this->cache_keys as $cache_key_base => $value) {
            $this->clear_cached($cache_key_base);
        }
        $this->options[self::ARG_KEY_CACHE_CLEAR] = false;
    }
    /**
     * calls clear_cached_all if is_cache_to_be_cleared() is true
     */
    public function cache_check_for_clear() {
        if ($this->is_cache_to_be_cleared()) {
            $this->clear_cached_all();
        }
    }

    /**
     *
     * @return boolean true if all cached values should be invalidated
     */
    private function is_cache_to_be_cleared() {
        return $this->options[self::ARG_KEY_CACHE_CLEAR] === true;
    }

    /**
     * 19 jun 2013 Borrowed from wordpress so we can be less reliant on wp within the code
     *
     * Merge user defined arguments into defaults array.
     *
     * This function is used throughout WordPress to allow for both string or array
     * to be merged into another array.
     *
     *
     * @param string|array $args Value to merge with $defaults
     * @param array $defaults Array that serves as the defaults.
     * @return array Merged user defined values with defaults.
     */
    function parse_args( $args, $defaults = '' ) {
        if ( is_object( $args ) )
            $r = get_object_vars( $args );
        elseif ( is_array( $args ) )
            $r =& $args;
        else
            $this->parse_str( $args, $r );

        if ( is_array( $defaults ) )
            return array_merge( $defaults, $r );
        return $r;
    }
    /**
     * 19 jun 2013 Borrowed from wordpress so we can be less reliant on wp within the code
     *
     * Parses a string into variables to be stored in an array.
     *
     * Uses {@link http://www.php.net/parse_str parse_str()} and stripslashes if
     * {@link http://www.php.net/magic_quotes magic_quotes_gpc} is on.
     *
     * @since 2.2.1
     *
     * @param string $string The string to be parsed.
     * @param array $array Variables will be stored in this array.
     */
    private function parse_str( $string, &$array ) {
        parse_str( $string, $array );
        if ( get_magic_quotes_gpc() )
            $array = stripslashes_deep( $array );
        return $array;
    }

    /*
     * Note: we can NOT use http://logging.apache.org/log4php/ framework:
     *   1) php has a global namespace and therefore another plugin or wordpress might load the log4php code.
     *   2) yes we could look for a 'Logger' class already loaded but that 'Logger' class may have nothing to do with log4php
     *   3) yes we could customize our own Logger with a FarReaches_ prefix but at that point its too much effort
     *
     * Utility method that adds a FarReaches prefix to the message and handles logging of arrays and objects
     *
     * message only outputed if FARREACHES_DEBUG
     *
     */
    public function debug_log() {
        if (FARREACHES_DEBUG && FarReaches_Error_Management::is_log_writable()) {
            // NOTE : older versions of PHP require assignment - cannot pass directly
            $args = func_get_args();
            $message = call_user_func_array(array($this, 'create_log_message'), $args);
            @FarReaches_Error_Management::debug_log($message);
        }
    }

    /**
     * Error messages are attempted to be emailed to us.
     * TODO Annoyance : when developing we want plugin error_log messages to be more visible to developers ( i.e. throw exceptions - so that errors are noticed more proactively )
     * but in release version we would like to be notified via another mechanism - to log file or emailed to us.
     * @param unknown_type $args
     */
    public function error_log($args) {
        // NOTE : older versions of PHP require assignment - cannot pass directly
        $args = func_get_args();
        $message = call_user_func_array(array($this, 'create_log_message'), $args);
        @FarReaches_Error_Management::error_log($message);
    }

    /**
     * varargs ( pass the parameters that make up the message )
     * @return string
     */
    private function create_log_message($args) {
        $args_number = func_num_args();
        if (is_array($args) && $args_number == 1) {
            // handle case where caller is a conv in another class
            $actual_args = $args;
            $args_number = count($actual_args);
        } else {
            $actual_args = func_get_args();
        }
        $error_msg_array = array(FARREACHES_PLUGIN_NAME, '(', FARREACHES_PLUGIN_VERSION, '):');
        // TODO / HACK : note this does not handle correctly the case of a single array with non-numeric keys passed to the _log() method.
        for ($i = 0; $i < $args_number; $i++) {
            $obj = $actual_args[$i];
            $id_or_null = $this->get_optional_id($obj);
            if ($id_or_null != null) {
                // for wordpress objects ( Posts, users, etc. we should just print theobject type, id and maybe something small like a post title
                $error_msg_array[] = $id_or_null;
            } else if (is_object($obj) || is_array($obj)) {
                $error_msg_array[] = print_r($obj, true);
            } else {
                $error_msg_array[] = $obj;
            }
        }

        // interesting: note that it is possible to log farreaches errors to a separate log file.
        // not used right now because if doing logging we want to insert error log message in the wp code.
        // so we want to see the messages threaded together.
        $message = $this->get_request_mark()." ".implode(" ", $error_msg_array);
        return $message;
    }
    private function get_request_mark(){
    	if (!$this->log_req_rand_id){
    		$this->log_req_rand_id = uniqid("Rq");
    	}

    	return $this->log_req_rand_id;
    }

    /**
     * This is a pseudo-ThreadId, helps in detecting log messages sequence.
     */
    private $log_req_rand_id;

    /**
     * Utility to help with understanding what is being sent to an action or filter
     */
    //$this->add_filter('all', $this->farReaches_Util, '_filter_action_reporter');
    function _filter_action_reporter() {
        $all_args = func_get_args();
        $this->debug_log("_all_filter:", $all_args);
    }

    function get_plugin_file() {
        return $this->plugin_file;
    }

    /**
     * Needed to make sure that all directories resolve from the correct location.
     */
    public function get_plugin_directory() {
        return $this->plugin_directory;
    }

    /**
     * loads config file via include() that is at "<plugin_root>/config/$config_file_name.php"
     *
     * Useful for lazy loading the file contents.
     *
     * Only loads it once - the next time it is cached.
     *
     * @param unknown_type $config_file_name
     * @return multitype:
     */
    public function get_config_file_contents($config_file_name) {
        if (!FarReaches_Params::key_exists($config_file_name, $this->config_file_contents)) {
            $filename = $this->get_plugin_directory(). '/config/' . $config_file_name . '.php';
            $this->set_config_file_contents($config_file_name, include($filename));
        }
        return $this->config_file_contents[$config_file_name];
    }

    /**
     * Exposed as a function for testing purposes
     * @param unknown_type $config_file_name
     * @param unknown_type $value
     */
    public function set_config_file_contents($config_file_name, $value) {
        $this->config_file_contents[$config_file_name] = $value;
    }
    public function get_plugin_url() {
        if ( empty($this->plugin_url)) {
            $this->plugin_url = plugin_dir_url($this->get_plugin_file());
        }
        return $this->plugin_url;
    }
    function check_for_errors($stringValue) {
        $error_message = null;

        if (!$stringValue) {
            $error_message = 'Could not encode JSON.';
        }

        return $error_message;
    }

    /**
     * Returns date string formatted as configured by blog admin.
     */
    function format_date($timestamp) {
        return date_i18n(get_option('date_format'), $timestamp);
    }

    /**
     * This is a PHP < 5.3 replacement for DateTime::createFromFormat.
     * Note that use of strptime() is deprecated as it is not implemented on windows platform.
     *
     * HACK: Currently parses only dates formatted like this: "10 April 2013 17:31 GMT"
     */
    function parse_date_from_format($date_as_string){
        if (FarReaches_String_Util::not_blank($date_as_string)) {
      	    list($day, $monthWord, $year, $hour24_and_minute, $time_format) = explode(' ', $date_as_string);
      	    // TODO : Test to make sure we got a valid result.
      	    $month = date('m', strtotime($monthWord));
      	    list($hour24, $minute) = explode(':', $hour24_and_minute);

      	    $formatted_date = sprintf('%04d-%02d-%02d %02d:%02d:00 %s', $year, $month, $day, $hour24, $minute, $time_format);

      	    return new DateTime($formatted_date);
        } else {
            return null;
        }
    }
}

