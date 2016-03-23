<?php

/**
 *
 * We still want farreaches-communication.php to exist separately until we know that all communication is api communication.
 *
 */
class FarReaches_Api_Call {

// API Key related API calls:

    /**
     * Retrieve permanent API key.
     * (deprecated)
     */
    const API_KEY_PERMANENT = 'PermanentApiKey';
    /**
     * like API_KEY_PERMANENT but returns information
     */
    const API_REGISTER_PLUGIN = 'RegisterPlugin';
    const API_UPDATE_ACCOUNT = 'UpdateAccount';
    /**
     * Used when a user is modified via the wordpress user management functions.
     * We send just the changed users.
     * @var unknown
     */
    const API_UPDATE_USERS = 'AlterUsers';
    /**
     * Api call on plugin activation. (checks to see if account already known)
     */
    const API_KEY_PREREGISTER = 'Preregister';
    /**
     * a call that updates data that only periodically changes.
     */
    const API_PERIODIC_REFRESH = 'PeriodicRefresh';
    /**
     * Retrieve temporary API key that is used to get a permanent Api Key
     */
    const API_KEY_TEMPORARY = 'TemporaryApiKey';
    /**
     * Used to get a write api key for write operations
     * @var unknown
     */
    const API_KEY_INITIALIZE = 'InitializeApiKey';

    /**
     * Retrieve diagnostic API key. (purpose?)
     */
    const API_KEY_DIAGNOSTIC = 'DiagnosticApiKey';


    const ENABLE_FEATURE = "EnableFeature";
    
    
    const DISABLE_FEATURE = "DisableFeature";
    
// Message endpoint related API calls:

    /**
     * Retrieve a list of message endpoints.
     */
    const MESSAGE_ENDPOINT_LIST = 'MessageEndPointList';

    /**
     * Enable a message endpoint.
     */
    const MESSAGE_ENDPOINT_ACTIVATE = 'ActivateMessageEndPoint';

    /**
     * Disable a message endpoint.
     */
    const MESSAGE_ENDPOINT_INACTIVATE = 'InactivateMessageEndPoint';

    /**
     * Configure message endpoint categories.
     */
    const MESSAGE_ENDPOINT_CATEGORIES_CONFIGURE = 'ConfigureMessagePointCategories';


// Post-related API calls:

    /**
     * Send post to the wireservice for publishing.
     */
    const POST_PUBLISH = 'CreateAlert';

    /**
     * Revoke post on the wireservice.
     */
    const POST_REVOKE = 'CreateRevoke';

    /**
     * Retrieve statuses of posts sent to publishing.
     */
    const POST_STATUSES = 'EnvelopeStatusList';


// Unsorted API calls:

    /**
     * Register category on wireservice.
     */
    const CATEGORY_REGISTER = 'Category';

    /**
     * Get the latest wordpress plugin info - this is a lightweight call with little db work on wireserver side.
     */
    const PLUGIN_INFO = 'GetWordpressPluginInfo';
    const PLUGIN_DOWNLOAD = 'GetWordpressPlugin';

    /**
     * Redirects to external service authorization page.
     */
    const EXTERNAL_SERVICE_CONFIGURE = 'ConfigureExtServices';

    /**
     * Initiates a charge to customer's credit card.
     *
     */
    const CHARGE_CUSTOMER = 'ChargeCustomer';

    /**
     * Retrieve all active features for current provider.
     *
     */
    const ACTIVE_FEATURES = 'ActiveFeatures';

    /**
     * Retrieve all active subscription options.
     *
     */
    const ACTIVE_FEATURE_SET_DEFINITIONS = 'ActiveFeatureSetDefinitions';

    /**
     * Looks up constants values on server.
     *
     */
    const CONFIGURATION_CONSTANTS = 'ConfigurationConstants';

    /**
     * Get list of all posts known to the server.
     */
    const KNOWN_MESSAGE_EXTERNAL_IDS = 'KnownMessageExternalIds';

    /**
     * Invariant to track if a permanent API key is needed.
     *
     */
    const INVARIANT_PERMANENT_API_KEY = 'permanent_api_key';

    /**
     * The name of the api_call - will be used as a key in the cache
     * @var string
     */
    private $api_call_name;
    private $api_call_basename;

    /**
     *
     * @var boolean
     */
    private $secured_api_call;
    /**
     *
     * @var array
     */
    private $request_defaults;
    /**
     *
     * @var array
     */
    private $request_invariants;

    private $fail_on_key_fail = false;

    private $full_api_uri;

    private $api_call_key;

    private $success_notification_topic;
    private $failure_notification_topic;

    /**
     *
     * @param unknown_type $api_call_name - which MUST include the api path ( 'public/TemporaryKey' )
     * @param array|null $request_defaults
     * @param array|null $request_invariants
     */
    public function __construct($api_call_name,
            array $request_defaults= array(), array $request_invariants = array()) {
        FarReaches_Validate::not_blank($api_call_name, "api call name is not set");
        $this->api_call_name = $api_call_name;
        // without the leading 'api/' or 'public/'
        $this->api_call_basename = basename($api_call_name);
        $this->request_defaults = $request_defaults==null?array():$request_defaults;
        $this->request_invariants = $request_invariants==null?array():$request_invariants;
        $this->cachable = false;
    }

    /**
     *
     * @return FarReaches_Api_Call
     */
    public function async() {
        $this->request_invariants[FarReaches_Communication::ASYNC_CALL] =true;
        return $this;
    }

    /**
     * marks as a api call that needs no api key
     * @return FarReaches_Api_Call
     */
    public function no_key() {
        $this->request_invariants[FarReaches_Communication::TEMPORARY_API_KEY_VALUE] = FarReaches_Communication::API_KEY_NOT_NEEDED;
        return $this;
    }

    /**
     * marks as a api call that needs no permanent api key
     * @return FarReaches_Api_Call
     */
    public function no_permanent_key() {
        $this->request_invariants[self::INVARIANT_PERMANENT_API_KEY] = FarReaches_Communication::API_KEY_NOT_NEEDED;
        return $this;
    }
    /**
     * This api call is responsible for getting api keys so a failure to get the key should not trigger an attempt to get keys.
     * @return FarReaches_Api_Call
     */
    public function fail_on_key_fail() {
        $this->fail_on_key_fail = true;
        return $this;
    }

    /**
     *
     * @return boolean the setting of true if fail_on_key_fail() was called and api key failures should not be reattempted with this call.
     */
    public function is_fail_on_key_fail() {
        return $this->fail_on_key_fail;
    }
    /**
     *
     * @param bool $secured_api_call
     * @return FarReaches_Api_Call
     */
    protected function set_secured_api_call($secured_api_call) {
        $this->secured_api_call = $secured_api_call;
        return $this;
    }

    /**
     * The actual api call made - this api call may be defined in different ways, with different parameters
     * This is with path 'public/PreRegister'
     *
     * @return string
     */
    public function get_api_call_name() {
        return $this->api_call_name;
    }

    public function get_api_call_basename() {
        return $this->api_call_basename;
    }

    /**
     * @param array $query_params combine the arguments into a single http string.
     * @return string
     */
    public function get_full_api_uri(array $query_params = null) {
        if (!empty($query_params)) {
            $query_str = '?' . http_build_query($query_params);
        } else {
            $query_str = '';
        }
        $complete_api_uri = $this->full_api_uri . $query_str;
        return $complete_api_uri;
    }
    // TODO : must only be called once so.
    public function set_api_uri($api_uri) {
        $this->full_api_uri = $api_uri . $this->get_api_call_name();
    }

    /**
     * The map key used in the plugin array of FarReaches_Api_Call
     */
    public function get_api_call_key() {
        return $this->api_call_key;
    }

    public function set_api_call_key($api_call_key) {
        $this->api_call_key = $api_call_key;
        $this->success_notification_topic = FarReaches_EventBus::TOPIC_PREFIX_WIRESERVICE . $api_call_key . '/' . 'done';
        $this->failure_notification_topic = FarReaches_EventBus::TOPIC_PREFIX_WIRESERVICE . $api_call_key . '/' . 'failed';
    }

    public function get_failure_notification_topic() {
        return $this->failure_notification_topic;
    }
    public function get_success_notification_topic() {
        return $this->success_notification_topic;
    }

    public function get_notification_topic($success) {
        return $success===true?$this->success_notification_topic:$this->failure_notification_topic;
    }
    public function is_api_not_used() {
        return FarReaches_Params::def($this->request_invariants, FarReaches_Communication::TEMPORARY_API_KEY_VALUE) === FarReaches_Communication::API_KEY_NOT_NEEDED;
    }
    public function is_permanent_api_key_not_needed() {
        return FarReaches_Params::def($this->request_invariants, self::INVARIANT_PERMANENT_API_KEY) === FarReaches_Communication::API_KEY_NOT_NEEDED;
    }

    /**
     * get the complete request with request_invariants overriding any previous values
     * for example making a call async for example ( is this needed or is this problematic )
     * @param array $request
     * @return array $request modified as needed for this api_call.
     */
    public function get_complete_request($request) {
        if ($request == null) {
            $request = array();
        }
        $result = $this->request_defaults;
        foreach ($request as $key => $value) {
            $result[$key] = $value;
        }
        foreach ($this->request_invariants as $key => $value) {
            $result[$key] = $value;
        }
        return $result;
    }

    public function __toString() {
        return sprintf("%s:{'success' : %s, 'failure': %s }",
            $this->get_api_call_name(), $this->get_success_notification_topic(), $this->get_failure_notification_topic() );
    }
}
