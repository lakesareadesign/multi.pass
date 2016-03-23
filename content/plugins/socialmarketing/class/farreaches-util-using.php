<?php
/**
 * Base class for all classes (except obviously FarReaches_Util)
 */
abstract class FarReaches_Util_Using {
    // this is the string used as the key to store farreach.es server lookupKeys.
    // it is also used in farreaches server replies when full details about an object (message_end_point for example) is returned.
    const LOOKUP_KEY = 'lookupKey';
    //Cache time is set to 30 seconds so we only use it for several subsequent calls.
    const CACHE_EXPIRY_TIME = 30;

    /**
     *
     * @var FarReaches_Util
     */
    protected $farReaches_Util;

    /**
     *
     * @param FarReaches_Util|null $farReaches_Util
     */
    protected function __construct($farReaches_Util) {
        $this->farReaches_Util = $farReaches_Util;
    }

    /**
     * Generic - probably should be in FarReaches_Param
     * @param array $array
     * @param unknown $item
     * @return boolean true is added (only if not already present)
     */
    protected function add_unique(array &$array, $item) {
        $item_added = true;

        if (in_array($item, $array)) {
            $item_added = false;
        } else {
            array_push($array, $item);
        }

        return $item_added;
    }

    /**
     *
     * @param array $array
     * @param unknown $item
     * @return boolean true if $item was present but removed.
     */
    protected function remove_unique(array &$array, $item) {
        $item_removed = true;

        if (isset($array)) {
            $modified_array = array_diff($array, array($item));

            if (count($modified_array) != count($array)) {
                $array = $modified_array;
            } else {
                $item_removed = false;
            }
        } else {
            $item_removed = false;
        }

        return $item_removed;
    }

    protected function get_plugin_file() {
        return $this->farReaches_Util->get_plugin_file();
    }

    protected function get_plugin_url() {
        return $this->farReaches_Util->get_plugin_url();
    }

    protected function get_plugin_directory() {
        return $this->farReaches_Util->get_plugin_directory();
    }

    protected function get_config_file_contents($config_file_name) {
        return $this->farReaches_Util->get_config_file_contents($config_file_name);
    }
    // in future will use a standard domain of farreaches.
    protected function __($string) {
        return $this->farReaches_Util->__($string);
    }

    protected function json_decode($string) {
        return $this->farReaches_Util->json_decode($string);
    }

    protected function json_encode($object) {
        return $this->farReaches_Util->json_encode($object);
    }

    protected function get_plugin_display_name() {
        return $this->farReaches_Util->get_plugin_display_name();
    }
    protected function get_plugin_state() {
        return $this->farReaches_Util->get_plugin_state();
    }

    /**
     * Triggers the appropriate event.
     * @param unknown $plugin_state
     * @param null|FarReaches_Event $farReaches_Event
     * @param string $user_ids
     * @param unknown $timeout
     * @param unknown $success_handler
     * @param unknown $failure_handler
     */
    protected function set_plugin_state($plugin_state,
            FarReaches_Event $farReaches_Event = NULL,
            $user_ids = null,
            $timeout = FarReaches_EventBus::DEFAULT_TIMEOUT,
            $success_handler = FarReaches_EventBus::NO_HANDLER,
            $failure_handler = FarReaches_EventBus::NO_HANDLER) {
        $this->farReaches_Util->set_plugin_state($plugin_state, $farReaches_Event,
            $user_ids,
            $timeout,
            $success_handler,
            $failure_handler);
    }

    protected function get_option($meta_key_base, $key_array = NULL, $returnNullIfEmpty = true) {
        return $this->farReaches_Util->get_option($meta_key_base, $key_array, $returnNullIfEmpty);
    }

    protected function update_option($meta_key_base, $key_array, $value) {
        return $this->farReaches_Util->update_option($meta_key_base, $key_array, $value);
    }

    protected function delete_option($meta_key_base, $key_array) {
        return $this->farReaches_Util->delete_option($meta_key_base, $key_array);
    }

    /**
     * @param string $action_str
     * @param string $method_name
     *
     * @return boolean true if added successfully
     */
    protected function add_action($action_str, $method_name = null, $priority = FarReaches_Util::NORMAL_PRIORITY) {
        if (empty($method_name)) {
            $method_name = 'do_' . $action_str;
        }
        $callable = $this->make_callable($method_name);
        return $this->farReaches_Util->add_action($action_str, $callable, $priority);
    }
    /**
     * specialized version of add_action that will ensure the current_user is set when the action is
     * invoked ( the first parameter when SCHEDULING the cron job is supposed to be the current_user_id )
     *
     * see the schedule_single_event() in base.
     * see farReaches_Util->set_a_cron_user_id() hack function to make sure we have an user id for api calls.
     *
     * @param unknown $hook
     * @param unknown $callable
     * @param unknown $priority
     */
    protected function add_cron_action($hook, $method_name = null, $reoccurance =null, $time_from_now_in_seconds = 0, $priority = FarReaches_Util::NORMAL_PRIORITY) {
        if (empty($method_name)) {
            $method_name = 'do_' . $hook;
        }
        $callable = $this->make_callable($method_name);
        $this->farReaches_Util->add_cron_action($hook, $callable, $priority);
        if ( isset($reoccurance)) {
            // Not using create_job_definition because that forces the userid
            $job_definition = array($hook);
            if ( !$this->get_next_scheduled($job_definition) ) {
                $this->schedule_event($time_from_now_in_seconds, $reoccurance, $job_definition);
            }
        }
    }
    /**
     * WARNING: remove_action is very problematic and can only be used when trying to change behavior within
     * the current thread of execution.
     */
    protected function remove_action($action_str, $method_name = null, $priority = FarReaches_Util::NORMAL_PRIORITY) {
        if (empty($method_name)) {
            $method_name = 'do_' . $action_str;
        }
        $callable = $this->make_callable($method_name);
        return $this->farReaches_Util->remove_action($action_str, $callable, $priority);
    }

    protected function schedule_single_event($time_from_now_in_seconds, array $job_definition) {
        if ( $time_from_now_in_seconds < 0 ) {
            $time_from_now_in_seconds = 0;
        }
        $timestamp = time() + $time_from_now_in_seconds;
        $full_args = array_merge(array($timestamp), $job_definition);
        return call_user_func_array('wp_schedule_single_event', $full_args);
    }
    /**
     *
     * @param unknown $time_from_now_in_seconds
     * @param unknown $reoccurance ( use  wp_get_schedules() )
     * @param array $job_definition ( first 2 array elements must be hook and userid )
     * @return mixed
     */
    protected function schedule_event($time_from_now_in_seconds, $reoccurance, array $job_definition) {
        if ( $time_from_now_in_seconds < 0 ) {
            $time_from_now_in_seconds = 0;
        }
        $timestamp = time() + $time_from_now_in_seconds;
        if ( FARREACHES_DEBUG) {
            // fast reoccurance of jabs when debugging
            $reoccurance = 'farreaches-fast';
        }
        $full_args = array_merge(array($timestamp, $reoccurance), $job_definition);
        return call_user_func_array('wp_schedule_event', $full_args);
    }

    /**
     * Returns the next timestamp for a cron event.
     * @param array $job_definition
     * @return
     */
    protected function get_next_scheduled(array $job_definition) {
        return call_user_func_array('wp_next_scheduled', $job_definition);
    }
    protected function unschedule_event(array $job_definition, $next_schedule_timestamp = null) {
        if ( empty($next_schedule_timestamp)) {
            $next_schedule_timestamp = $this->get_next_scheduled($job_definition);
        }
        if ( !empty($next_schedule_timestamp)) {
            $full_args = array_merge(array($next_schedule_timestamp), $job_definition);
            call_user_func_array('wp_unschedule_event', $full_args);
        }
    }

    /**
     * Creates a job definition array :
     * ( $hook,
     *    array( $user_id, $args ) // $args is combined with $user_id
     * )
     *
     * returned object is used to call unschedule_event()  and get_next_scheduled()
     * @param unknown_type $user_or_id
     * @param unknown_type $hook - the hook that has actions registered with add_action($hook, ...)
     * @param array $args
     */
    protected function create_job_definition($user_or_id, $hook, array $args = null) {
        $user_id = $this->get_user_id($user_or_id);
        $user_id_array = array($user_id);
        if (empty($args)) {
            $full_args = $user_id_array;
        } else {
            $full_args = array_merge($user_id_array, $args);
        }
        return array($hook, $full_args);
    }

    protected function cache($cache_key_base, $value, $expire_in_secs = self::CACHE_EXPIRY_TIME) {
        $this->farReaches_Util->cache($cache_key_base, $value, $expire_in_secs);
    }

    protected function get_cached($meta_key_base) {
        return $this->farReaches_Util->get_cached($meta_key_base);
    }

    protected function clear_cached($meta_key_base) {
        $this->farReaches_Util->clear_cached($meta_key_base);
    }
    protected function cache_check_for_clear() {
        $this->farReaches_Util->cache_check_for_clear();
    }

    protected function add_filter($action_str, $method_name = null, $priority = FarReaches_Util::NORMAL_PRIORITY) {
        if (empty($method_name)) {
            $method_name = 'filter_' . $action_str;
        }
        $callable = $this->make_callable($method_name);
        return $this->farReaches_Util->add_filter($action_str, $callable, $priority);
    }

    protected function get_user_meta($user, $meta_key, $key_array = null) {
        return $this->farReaches_Util->get_user_meta($user, $meta_key, $key_array);
    }

    protected function add_user_meta($user, $meta_key, $key_array, $value) {
        return $this->farReaches_Util->add_user_meta($user, $meta_key, $key_array, $value);
    }

    protected function delete_user_meta($user, $meta_key, $key_array = null) {
        return $this->farReaches_Util->delete_user_meta($user, $meta_key, $key_array);
    }

    protected function get_envelope_meta($post_or_revision, $key_array = null) {
        return $this->farReaches_Util->get_envelope_meta($post_or_revision, $key_array);
    }

    protected function add_envelope_meta($post_or_revision, $key_array, $value) {
        return $this->farReaches_Util->add_envelope_meta($post_or_revision, $key_array, $value);
    }

    protected function delete_envelope_meta($post_or_revision, $key_array) {
        return $this->farReaches_Util->delete_envelope_meta($post_or_revision, $key_array);
    }

    protected function get_messageThread_meta($post_or_revision, $key_array = null) {
        return $this->farReaches_Util->get_messageThread_meta($post_or_revision, $key_array);
    }

    protected function add_messageThread_meta($post, $key_array, $value) {
        return $this->farReaches_Util->add_messageThread_meta($post, $key_array, $value);
    }

    protected function get_farreaches_meta_key($meta_key_base) {
        return $this->farReaches_Util->get_farreaches_meta_key($meta_key_base);
    }

    /**
     * @param object|int $user_or_id if null then current user is returned.
     * @return int user id
     */
    protected function get_user_id($user_or_id = null) {
        return $this->farReaches_Util->get_user_id($user_or_id);
    }
    /**
     * Sets the WordPress global $current_user if the current user's ID is 0 ( i.e. not set )
     * @param unknown $new_current_user
     */
    protected function set_current_user($new_current_user) {
        return $this->farReaches_Util->set_current_user($new_current_user);
    }

    protected function get_ids($objects_or_ids) {
        if ( is_array($objects_or_ids)) {
            foreach ($objects_or_ids as $object_or_id) {
                $ids[] = $this->get_id($object_or_id);
            }
        } else {
            $ids[] = $this->get_id($objects_or_ids);
        }
        return $ids;
    }
    protected function get_id($object_or_id) {
        return $this->farReaches_Util->get_id($object_or_id);
    }
    protected function get_optional_id($object_or_id) {
        return $this->farReaches_Util->get_optional_id($object_or_id);
    }

    protected function error_log() {
        $args = func_get_args();
        return call_user_func_array(array($this->farReaches_Util, __FUNCTION__), $args);
    }

    protected function debug_log() {
        $args = func_get_args();
        return call_user_func_array(array($this->farReaches_Util, __FUNCTION__), $args);
    }

    /**
     * This function should be used to create callable function arrays.
     *
     * Creates the 2 element array needed to do a function call:
     *     ($this, $method_name)
     * Intent is to make function call arrays semantically clear.
     *
     * as a note see php function is_callable()
     *
     * @param string $method_name
     * @return callable
     */
    protected function make_callable($method_name) {
        if (is_array($method_name)) {
            $callable = $method_name;
        } else if ( func_num_args() == 1) {
            $callable = array($this, $method_name);
        } else {
            $callable = array(func_get_arg(0), func_get_arg(1));
        }
        // This check has nice effect to make sure the the method in question really exists
        FarReaches_Validate::is_callable($callable, ": is not callable - probably missing method");
        return $callable;
    }

    protected function format_date($timestamp) {
        return $this->farReaches_Util->format_date($timestamp);
    }

    /**
     *
     * @param unknown_type $date_as_string Must be in the 'd F Y H:i P' format: "10 April 2013 17:31 GMT"
     */
    protected function parse_date_from_format($date_as_string) {
    	return $this->farReaches_Util->parse_date_from_format($date_as_string);
    }

    /**
     *
     * @param string|FarReaches_Api_Call $api_call_key
     * @param string|callable|null $success_handler_method
     * @param string|callable|null $failure_handler_method
     */
    protected function register_api_response_handler($api_call_key, $success_handler_method, $failure_handler_method = null) {
        /**
         * @var FarReaches_Api_Call
         */
        $api_call_definition = $this->get_api_call_definition($api_call_key);

        if (isset($success_handler_method)) {
            $handlers[$api_call_definition->get_success_notification_topic()] = $success_handler_method;
        }
        if (isset($failure_handler_method)) {
            $handlers[$api_call_definition->get_failure_notification_topic()] = $failure_handler_method;
        }
        FarReaches_EventBus_Facade::subscribeMe($this, $handlers);
    }
}
