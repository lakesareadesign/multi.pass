<?php

/**
 * The class responsible for async synchronization of events between server-side and client-side Event Bus implementations.
 *
 * This class should not be used directly.
 * If you need to work with Event Bus then use FarReaches_EventBus_Facade
 *
 * TODO: Shouldn't FarReaches_EventBus_Base or FarReaches_EventBus_Durable be the parent?
 *
 * It allows server-side publishers and client-side subscribers as well as client-side publishers and server-side subscribers.
 * Currently synchronization is based on AJAX polling with default interval 5 seconds. If you need to adjust it
 * then use cookie named event_bus_sync_interval containing integer value in milliseconds.
 *
 * @link https://github.com/farreaches/farreaches-wp-plugin/wiki/Event-bus---why,-when-and-how
 */
class FarReaches_EventBus_Bridge_Javascript extends FarReaches_Base{

    private $_event_bus;

    const PAYLOAD = 'payload';
    const KEY_TIMEOUT = 'timeout';
    const OUTGOING_ENVELOPES = 'event_bus_pending_events';
    const DELIVERY_NOTES = 'event_bus_delivered_events';
    const JS_EVENT_STATUS_SUCCESS = 'success';
    const JS_EVENT_STATUS_FAILURE = 'failure';

    public $_client_allowed_topics = array();
    public $_suspended_topics = array();

    public $handle_success_callable;
    public $handle_failure_callable;

    private $sync_events_call;
    /**
     * @var FarReaches_Ui_Handling
     */
    private $farReaches_Ui_Handling;

    const BROWSER_EVENT_SYNC_INTERVAL = 'farreaches_event_bus_sync_interval';

    public function __construct(FarReaches_Util $farReaches_Util, FarReaches_Communication $farReaches_Communication) {
        parent::__construct($farReaches_Util, $farReaches_Communication);

        $this->sync_events_call = $farReaches_Communication->add_ajax_hook(new FarReaches_Ajax_Call($this, 'sync_events_ajax', array('all')));

        $this->_event_bus = FarReaches_EventBus_Facade::getInstance()->getEventBus();
        $this->add_action('shutdown', 'on_shutdown');
        $this->handle_success_callable = $this->make_callable('handle_success');
        $this->handle_failure_callable = $this->make_callable('handle_failure');
        $this->add_filter(FarReaches_Ui_Handling::FARREACHES_BROWSER_RESOURCES_FILTER_HOOK, 'filter_browser_resources');
    }

    /**
     * This action is invoked periodically by AJAX call
     *
     * @return array data to be serialized and sent to a client browser
     */
    public function sync_events_ajax() {
        $delivery_notes = $this->_process_incoming_envelopes();
        $this->_event_bus->invalidate_cache();
        $outgoing_envelopes = $this->_process_outgoing_envelopes();

        $response = array();

        if (!empty($delivery_notes))
            $response[self::DELIVERY_NOTES] = $delivery_notes;

        if (!empty($outgoing_envelopes))
            $response[self::OUTGOING_ENVELOPES] = $outgoing_envelopes;

        return $response;
    }

    /**
     * Specify to which topics browser side is allowed to publish events.
     *
     * @param string | array $topic_or_array either topic name as string or topic names as array
     */
    public function set_allow_client_publish($topic_or_array) {
        if (is_array($topic_or_array)) {
            foreach ($topic_or_array as $topic) {
                $this->set_allow_client_publish($topic);
            }
        } else {
            FarReaches_Validate::not_blank($topic_or_array);
            $this->_client_allowed_topics[] = $topic_or_array;
        }
    }

    private function _process_outgoing_envelopes() {
        $outgoing_envelopes = array();
        foreach ($this->_event_bus->fetch_cached_topic_envelopes() as $topic => $envelopes) {
            if (!in_array($topic, $this->_suspended_topics)) {
                if (!isset($outgoing_envelopes[$topic])) {
                    $outgoing_envelopes[$topic] = array();
                }
                foreach ($envelopes as $envelope) {
                    // TODO : convert FarReaches_Event to array using get_object_properties()
                    $outgoing_envelopes[$topic][] = $envelope;
                }
            }
        }
        return $outgoing_envelopes;
    }

    /**
     *  TODO: the request should list requested events : this would allow only the popup window it get the redirect request.
     */
    private function _process_incoming_envelopes() {
        $delivery_notes = array();
        if (isset($_POST[self::PAYLOAD])) {
            // WordPress always adds slashes so we strip them all:
            // see http://wordpress.stackexchange.com/questions/21693/wordpress-and-magic-quotes
            $payload = $this->json_decode(stripslashes($_POST[self::PAYLOAD]));
            $current_user_id = $this->get_user_id();
            foreach ($payload as $topic => $envelopes) {
                if ($this->is_allowed_from_client($topic)) {
                    foreach ($envelopes as $envelope) {
                        $farReaches_Event_as_array = FarReaches_Params::def($envelope, FarReaches_EventBus_Transient::KEY_EVENT);
                        $farReaches_Event = new FarReaches_Event($current_user_id);
                        $farReaches_Event->applyHash($farReaches_Event_as_array);
                        $timeout = FarReaches_Params::int($envelope, self::KEY_TIMEOUT, FarReaches_EventBus::DELIVER_OR_DROP);
                        $result = $this->_event_bus->publish($topic, $farReaches_Event, $this->handle_success_callable, $this->handle_failure_callable, $timeout);
                        $delivery_note = $this->delivery_note($envelope, $result);
                        if (!empty($delivery_note)) {
                            $delivery_notes[] = $delivery_note;
                        }
                    }
                } else {
                    //Unauthorized message from client. Silently ignore it, but log for developers.
                    $this->debug_log('Client attempted to publish message to the topic (', $topic, ') it has no permission to publish in!');
                }
            }
        }
        return $delivery_notes;
    }

    function handle_success($result) {
        if (!is_array($result)) {
            $result = array($result);
        }
        $result['call_status'] = self::JS_EVENT_STATUS_SUCCESS;
        return $result;
    }

    function handle_failure($exception) {
        $message = $exception->getMessage();
        if (empty($message)) {
            $message = 'An error happened while processing your call.';
        }
        return array('call_status' => self::JS_EVENT_STATUS_FAILURE,
                     'exception_message' => $message);
    }

    private static function delivery_note($envelope, $result) {
        $return = array();
        if (isset($result)) {
            $return['result'] = $result;
        }
        if (isset($envelope['success_handler_reg_id'])) {
            $return['success_handler_reg_id'] = $envelope['success_handler_reg_id'];
        }
        if (isset($envelope['failure_handler_reg_id'])) {
            $return['failure_handler_reg_id'] = $envelope['failure_handler_reg_id'];
        }
        return $return;
    }

    public function suspend_topic($topic) {
        $this->_suspended_topics[] = $topic;
    }

    /**
     * This method is executed as a WordPress 'FarReaches_Ui_Handling::FARREACHES_BROWSER_RESOURCES_FILTER_HOOK' action handler
     */
    public function filter_browser_resources($js_config) {
        $alterations = array(self::OUTGOING_ENVELOPES => $this->_process_outgoing_envelopes(),
                '_wp_event_bus_sync_url' => $this->sync_events_call->get_ajax_uri(),
        );
        // determine if someone else set the interval
        if (!array_key_exists(self::BROWSER_EVENT_SYNC_INTERVAL, $js_config)) {
            $alterations[self::BROWSER_EVENT_SYNC_INTERVAL] =
                isset($_REQUEST[self::BROWSER_EVENT_SYNC_INTERVAL]) ? intval($_REQUEST[self::BROWSER_EVENT_SYNC_INTERVAL]) : 15000;
        }
        $returned = array_merge($js_config, $alterations);
        return $returned;
    }

    /**
     * This method is executed as a WordPress 'shutdown' action handler
     */
    public function on_shutdown() {
        // We don't want to persist event bus if plugin has been deactivated
        if (!defined('FARREACHES_DOING_DEACTIVATION')) {
            $this->_event_bus->persist();
        }
    }

    private function is_allowed_from_client($topic) {
        return in_array($topic, $this->_client_allowed_topics);
    }
}
