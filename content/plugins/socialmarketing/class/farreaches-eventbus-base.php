<?php

/**
 * Class implements publish/subscribe pattern to allow loose coupling between components.
 *
 * This class should not be used directly.
 * If you need to work with Event Bus then use FarReaches_EventBus_Facade
 *
 * EventBus is a topic-based system, where messages are published to "topics" or named logical channels.
 * Subscribers in a topic-based system will receive all messages published to the topics to which they subscribe,
 * and all subscribers to a topic will receive the same messages.
 *
 * This implementation is synchronous.
 *
 * @link https://github.com/farreaches/farreaches-wp-plugin/wiki/Event-bus---why,-when-and-how
 * @link http://en.wikipedia.org/wiki/Publish%E2%80%93subscribe_pattern
 */
abstract class FarReaches_EventBus_Base extends FarReaches_Util_Using implements FarReaches_EventBus {

    private $_topic_handlers = array();

    /**
     * @var array[Reflector]
     */
    private $_regex_handlers = array();
    // HACK must not be public
    public $_handlers = array();

    public function __construct(FarReaches_Util $farReaches_Util) {
        parent::__construct($farReaches_Util);
    }
    /**
     * Subscribe listener to the topic.
     *
     * @param string $topic named logical channel
     * @param callable $listener callable to be invoked when message arrives to the $topic
     * @return void
     */
    public function subscribe($topic, $listener) {
        $topic_handlers =& $this->create_topic_handlers($topic);
        $topic_handlers[] = $this->createEventBusHandlerInstance($listener);
    }

    /**
     * Subscribe listener to all topics that are matched by regular expression.
     *
     * @param string $regex regular expression used to match topics
     * @param callable $listener callable to be invoked when message arrives to the $topic
     * @return void
     */
    public function subscribeRegex($regex, $listener) {
        FarReaches_Validate::is_callable($listener, '$listener is not callable');
        $regex_handlers =& $this->create_regex_handlers($regex);
        $regex_handlers[] = $this->createEventBusHandlerInstance($listener);
    }

    /**
     * Unsubscribe listener from the topic.
     *
     * @param string $topic named logical channel
     * @param callable|null $handler callable to unsubscribe. If null then all listeners of the topic will be unsubscribed.
     * @return void
     */
    public function unsubscribe($topic, $handler = null) {
        if (array_key_exists($topic, $this->_topic_handlers)) {
            if (is_null($handler)) {
                unset($this->_topic_handlers[$topic]);
            } else {
                $topic_handlers = $this->_topic_handlers[$topic];
                assert(is_array($topic_handlers));
                if (($key = array_search($handler, $topic_handlers)) !== false) {
                    unset($topic_handlers[$key]);
                }
            }
        }
    }

    /**
     * Publish event to the topic. All listeners subscribed to the topic will receive event.
     *
     * @param string $topic named logical channel
     * @param FarReaches_Event $farReaches_Event arbitrary data (message) to pass to listeners
     * @param callable|null $success_handler OPTIONAL callable to be invoked upon successful execution of listener. Result from listener will be passed to this callable.
     * @param callable|null $failure_handler OPTIONAL callable to be invoked upon failed execution of listener. Exception from listener will be passed to this callable.
     * @param int $timeout OPTIONAL how long to try deliver event
     * @return array containing results from all listeners
     * @throws Exception if failure handler is not defined then exception will be thrown
     */
    public function publish($topic, FarReaches_Event $farReaches_Event, $success_handler = null, $failure_handler = null, $timeout = self::DEFAULT_TIMEOUT) {
        FarReaches_Validate::null_or_callable($success_handler, '$success_handler is not callable');
        FarReaches_Validate::null_or_callable($failure_handler, '$failure_handler is not callable');

        $handler_results = array();
        $topic_handlers = FarReaches_Params::def($this->_topic_handlers, $topic);
        if ( !empty($topic_handlers )) {
            $this->debug_log("publishing to " . $topic);
            foreach ($topic_handlers as /** @var FarReaches_EventBus_Handler $handler */
                     $handler) {
                $result = null;
                try {
                    $result = $handler->invoke($farReaches_Event);
                    if (!is_null($success_handler)) {
                        $result = call_user_func($success_handler, $result);
                    }
                } catch (Exception $e) {
                    if (!is_null($failure_handler)) {
                        $result = call_user_func($failure_handler, $e);
                    } else {
                        throw $e;
                    }
                }
                $handler_results[] = $result;
            }
        }
        foreach ($this->_regex_handlers as $regex => $handlers) {
            foreach ($handlers as /** @var FarReaches_EventBus_Handler $handler */
                     $handler) {
                $matches = array();
                if (preg_match($regex, $topic, $matches) === 1) {
                    $result = null;
                    try {
                        $matching = new FarReaches_Event($farReaches_Event->user);
                        $matching->matches = $matches;
                        $matching->matched_event = $farReaches_Event;
                        $result = $handler->invoke($matching);
                        if (!is_null($success_handler)) {
                            call_user_func($success_handler, $result);
                        }
                    } catch (Exception $e) {
                        if (!is_null($failure_handler)) {
                            call_user_func($failure_handler, $e);
                        } else {
                            throw $e;
                        }
                    }
                    $handler_results[] = $result;
                }
            }
        }

        return $handler_results;
    }

    protected function register_handler($handler) {
        $this->_handlers[] = $handler;
        return count($this->_handlers) - 1;
    }

    protected function unregister_handler($handler_id) {
        $extracted = array_splice($this->_handlers, $handler_id, 1);
        return $extracted[0];
    }

    /**
     * @param string $topic
     * @return array(Reflector)
     */
    private function &create_topic_handlers($topic) {
        if (array_key_exists($topic, $this->_topic_handlers)) {
            $topic_handlers =& $this->_topic_handlers[$topic];
            return $topic_handlers;
        } else {
            $topic_handlers = array();
            $this->_topic_handlers[$topic] =& $topic_handlers;
            return $topic_handlers;
        }
    }

    private function &create_regex_handlers($regex) {
        if (array_key_exists($regex, $this->_regex_handlers)) {
            $regex_handlers =& $this->_regex_handlers[$regex];
            return $regex_handlers;
        } else {
            $regex_handlers = array();
            $this->_regex_handlers[$regex] =& $regex_handlers;
            return $regex_handlers;
        }
    }
    private function createEventBusHandlerInstance($callable) {
        FarReaches_Validate::is_callable($callable, 'Event bus handler is not callable');
        // TO_YURIY (replied): can we use ReflectionMethod when registering actions with wordpress?
        // i did not know about ReflectionMethod, I would prefer to use ReflectionMethod every place where before we
        // are using array(&this, 'method_name') - ReflectionMethod is much more obvious.
        // TO_PAT: I agree that ReflectionMethod is more explicit and readable callback form then array. It is not supported yet but could be added without problems.

        if (is_string($callable)) {
            $reflection = new ReflectionFunction($callable);
            return new FarReaches_EventBus_Handler_Function($reflection);
        } elseif (is_array($callable)) {
            return new FarReaches_EventBus_Handler_Method($callable[0], new ReflectionMethod($callable[0], $callable[1]));
        } elseif (is_a($callable, 'Closure')) {
            // fyi - we cannot use Closures because current php 5.2.4 is the minimum and closures were introduced in 5.3
            $reflector = new ReflectionObject($callable);
            return new FarReaches_EventBus_Handler_Method($callable, $reflector->getMethod('__invoke'));
        } else {
            $callable_info = print_r($callable, true);
            FarReaches_Validate::should_never_reach_here(sprintf("Callable that is not an array nor string nor Callable. Don't know how to call it. class=%s\n%s", get_class($callable), $callable_info));
            return null;
        }
    }
}

abstract class FarReaches_EventBus_Handler {

    /**
     * @var ReflectionFunctionAbstract
     */
    protected $reflection;
    /**
     * @var unknown_type
     */
    protected $required_params;
    public function __construct($reflection) {
        $this->reflection = $reflection;
        // not needed any more because now we are only passing single event object to the event handler.
        $this->required_params = $this->reflection->getNumberOfParameters();
    }

    /**
     *
     */
    public abstract function invoke(FarReaches_Event $farReaches_Event);
}

class FarReaches_EventBus_Handler_Function extends FarReaches_EventBus_Handler {
    public function __construct($reflection) {
        parent::__construct($reflection);
    }

    public function invoke(FarReaches_Event $farReaches_Event) {
        return $this->reflection->invoke($farReaches_Event);
    }
}
class FarReaches_EventBus_Handler_Method extends FarReaches_EventBus_Handler {
    // TODO is $object really needed when the $reflection is constructed with an instance?
    private $object;
    public function __construct($object, $reflection) {
        parent::__construct($reflection);
        $this->object = $object;
    }
    public function invoke(FarReaches_Event $farReaches_Event) {
        return $this->reflection->invoke($this->object, $farReaches_Event);
    }
}
