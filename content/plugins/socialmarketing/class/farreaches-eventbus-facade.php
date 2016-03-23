<?php

/**
 * This is a facade for Event Bus functionality.
 *
 * It provides a simplified interface to a larger body of event bus code.
 * It is Singleton that holds EventBus and can be accessed anywhere in the code using static method.
 *
 * You should typically use this class to subscribe/publish.
 *
 * @link https://github.com/farreaches/farreaches-wp-plugin/wiki/Event-bus---why,-when-and-how
 *
 * TO_YURIY (replied): factory method is anti-pattern - follow the pattern we use for all other singletons.
 * TO_PAT: I would argue:
 * 1) Here we have a singleton, not a factory method. Do you think that singleton is anti-pattern?
 * 2) I don't think that having an explicit singleton is the best option for the EventBus. As for me, options are (from the most preferable to the least):
 *      a) Use dependency injection pattern (aka Inversion Of Control). See https://github.com/Elfet/IoC
 *      b) Use service locator pattern.
 *      c) Use explicit singletons for the ubiquitous dependencies like DB, Logging, EventBus and pass other dependencies as constructor arguments.
 *      d) Pass every dependency as argument.
 *
 * Summary: you want d), current class follows c) we need a)
 * Having that said I propose to introduce a DI and refactor classes to use it instead of aligning current class to the least preferable option d)
 *
 * Good article on subject http://www.davegardner.me.uk/blog/2009/11/23/php-dependency-strategies-dependency-injection-and-service-locator/
 */
class FarReaches_EventBus_Facade extends FarReaches_Util_Using {

    /**
     * @var FarReaches_EventBus_Facade instance
     */
    protected static $instance;

    /**
     * @var FarReaches_EventBus_Durable
     */
    private $_event_bus;

    /**
     * @var FarReaches_EventBus_Bridge_Javascript
     */
    private $_event_bus_bridge_javascript;

    private $_initialized;

    private $_subscribe_requests = array();

    private $_publish_requests = array();

    /**
     * Singleton instance method.
     *
     * @static
     * @return FarReaches_EventBus_Facade singleton instance
     */
    // HACK remove static methods.
    public static function getInstance() {
        if (is_null(self::$instance)) {
            self::$instance = new FarReaches_EventBus_Facade;
        }
        return self::$instance;
    }

    /**
     * Initialize FarReaches_EventBus
     * @static
     * @param FarReaches_Util $farReaches_Util
     * @param FarReaches_Communication $farReaches_Communication
     */
    public static function initialize(FarReaches_Util $farReaches_Util, FarReaches_Communication $farReaches_Communication) {
        $facade = self::getInstance();
        $facade->farReaches_Util = $farReaches_Util;
        $storage = new FarReaches_EventBus_Storage_Meta($farReaches_Util);
        $facade->setEventBus(new FarReaches_EventBus_Durable($farReaches_Util, $storage));
        $facade->setEventBusBridgeJavascript(new FarReaches_EventBus_Bridge_Javascript($farReaches_Util, $farReaches_Communication));
        $facade->_set_initialized(true);
        $subscribeMeCallable = array('FarReaches_EventBus_Facade', 'subscribeMe');
        foreach ($facade->_subscribe_requests as $subscribe_request) {
            call_user_func_array($subscribeMeCallable, $subscribe_request);
        }
        $publishCallable = array('FarReaches_EventBus_Facade', 'publish');
        foreach ($facade->_publish_requests as $publish_request) {
            call_user_func_array($publishCallable, $publish_request);
        }
    }

    public static function publish($topic,
            FarReaches_Event $farReaches_Event= null,
            $user_ids = null,
            $timeout = FarReaches_EventBus::DEFAULT_TIMEOUT,
            $success_handler = FarReaches_EventBus::NO_HANDLER,
            $failure_handler = FarReaches_EventBus::NO_HANDLER) {
        $facade = self::getInstance();
        if ($facade->_is_initialized()) {
            if ( !isset($farReaches_Event)) {
                // so all handlers are guarentee to get a set value.
                // TODO : should have 1 event / user ? : not clear how event to multiple users should behave (1 / user? first user to see handles for all? )
                if ( !empty($user_ids)) {
                    $user_id = $user_ids[0];
                } else {
                    $user_id = $facade->get_user_id();
                }

                $farReaches_Event = new FarReaches_Event($user_id);
            }
            return $facade->getEventBus()->publish(
                    FarReaches_Validate::not_empty($topic, "Missing event topic"),
                    $farReaches_Event,
                    $success_handler, $failure_handler,
                    $timeout,
                    $user_ids
            );
        } else {
            $facade->_publish_requests[] = func_get_args();
        }
    }

    /**
     * Publish array of events to the same topic.
     *
     * @static
     * @param string $topic
     * @param array $array_of_events
     */
    public static function publishArray($topic, $array_of_events) {
        foreach ($array_of_events as $event) {
            self::publish($topic, $event);
        }
    }

    /**
     * Subscribes a number of object's methods to a corresponding topics.
     * Optionally, allows publishing to topics from client side.
     *
     * @static
     * @param object $that what object is to subscribe
     * @param array $topic2method key = topic, value = method name
     * @param bool $allow_from_browser (false default) [OPTIONAL] true if the event can be sent or received by the browser's javascript.
     */
    public static function subscribeMe($that, $topic2method, $allow_from_browser = false) {
        $facade = self::getInstance();
        if ($facade->_is_initialized()) {
            foreach ($topic2method as $topic => $method) {
                if ($allow_from_browser) {
                    $facade->_event_bus_bridge_javascript->set_allow_client_publish($topic);
                }
                $callable = array($that, $method);
                FarReaches_Validate::is_callable($callable);
                $facade->_event_bus->subscribe($topic, $callable);
            }
        } else {
            $facade->_subscribe_requests[] = func_get_args();
        }
    }

    /**
     * Could be used to set mock instance
     *
     * @param FarReaches_EventBus_Durable $event_bus
     */
    public function setEventBus(FarReaches_EventBus_Durable $event_bus) {
        $this->_event_bus = $event_bus;
    }

    /**
     * @return FarReaches_EventBus_Durable event bus
     */
    public function getEventBus() {
        return $this->_event_bus;
    }

    /**
     * @param FarReaches_EventBus_Bridge_Javascript $event_bus_bridge_javascript
     */
    public function setEventBusBridgeJavascript($event_bus_bridge_javascript) {
        $this->_event_bus_bridge_javascript = $event_bus_bridge_javascript;
    }

    /**
     * @return FarReaches_EventBus_Bridge_Javascript
     */
    public function getEventBusBridgeJavascript() {
        return $this->_event_bus_bridge_javascript;
    }

    /**
     * Protection against instantiation using constructor
     *
     * @return FarReaches_EventBus_Facade
     */
    protected function __construct() {
        parent::__construct(null);
    }

    /**
     * Protection against instantiation using cloning
     *
     * @return FarReaches_EventBus_Facade
     */
    private function __clone() {
    }

    /**
     *  Protection against instantiation using de-serialization
     *
     * @return FarReaches_EventBus_Facade
     */
    private function __wakeup() {
    }

    private function _is_initialized() {
        return $this->_initialized;
    }
    /**
     * Only for internal and tests usage.
     *
     * @param unknown $initialized
     */
    function _set_initialized($initialized) {
        $this->_initialized = $initialized;
    }
    
    /**
     * Only for internal and tests usage.
     *
     * @param unknown $initialized
     */
    function _set_farReaches_Util($farReaches_Util) {
        $this->farReaches_Util = $farReaches_Util;
    }
}