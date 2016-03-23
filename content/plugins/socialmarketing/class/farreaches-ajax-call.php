<?php

/*
 * Class to encapsulate ajax calls from the plugin. An ajax call consists of
 * a callback function plus permissions. It is stored in class-farreaches-ajax
 * in the $ajax_calls array, indexed with the
 */
class FarReaches_Ajax_Call {
    private $permissions;
    private $callback_function;
    private $call_key;
    private $uri;

    /*
      * $base_callback_object is the necessary object on which the callback will execute
      * $key is the name of the function name and the key over which it will be indexed in the ajax dispatcher
      * $if you want a different function send it in the optional $func parameter
      * the constructor *doesn't* set the uri, you must do that afterwards through set_uri
      */
    function __construct(FarReaches_Util_Using $base_callback_object, $key, $permissions_required, $func = null) {
        $this->call_key = $key;
        if (isset($func)) {
            $this->callback_function = array($base_callback_object, $func);
        } else {
            $this->callback_function = array($base_callback_object, $key);
        }
        $this->permissions = $permissions_required;
    }

    /*
      * Returns the call key, used for identifying the uri, used as the action parameter in HTTP GETs.
      * Needed because it is used to index the call in the generic ajax handler.
      */
    function get_call_key() {
        return $this->call_key;
    }

    function set_uri($base_uri) {
        $this->uri = $base_uri . "?action={$this->call_key}";
    }

    function get_uri() {
        return $this->uri;
    }

    /**
     * Returns true when the ajax call is unprivileged, otherwise false.
     */
    function is_unprivileged_call() {
        return in_array('all', $this->permissions, true);
    }

    /**
     * Returns true when the ajax call is privileged, otherwise false.
     */
    function is_privileged_call() {
        return ! $this->is_unprivileged_call();
    }

    function invoke_user_ajax_func() {
        return call_user_func($this->callback_function, $this);
    }

    function user_has_perm() {
        return $this->is_unprivileged_call() || current_user_can($this->permissions);
    }

    /**
     * action : (optional - why?) the action registered with wordpress
     * preconfig_data : optional, if present then included in the generated uri.
     *
     * @returns string
     */
    function get_ajax_uri($preconfig_data = array()) {
        $uri = $this->uri;
        if (!empty($preconfig_data)) {
            return $uri . '&' . http_build_query($preconfig_data);
        } else {
            return $uri;
        }
    }

    function is_stateless_call() {
        return $this->is_unprivileged_call();
    }
}
