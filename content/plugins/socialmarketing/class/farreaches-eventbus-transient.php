<?php

/**
 * Implementation of publish/subscribe pattern to allow loose coupling between components.
 *
 * This class should not be used directly.
 * If you need to work with Event Bus then use FarReaches_EventBus_Facade
 *
 * {@inheritdoc} In addition, this subclass adds temporary caching of all undelivered events so that
 * any lately subscribed listener will immediately receive all events published to the specified topic within specified time period.
 *
 * @link FarReaches_EventBus_Transient_Test
 * @link https://github.com/farreaches/farreaches-wp-plugin/wiki/Event-bus---why,-when-and-how
 * @link http://en.wikipedia.org/wiki/Publish%E2%80%93subscribe_pattern
 */
class FarReaches_EventBus_Transient extends FarReaches_EventBus_Base {

    protected $_cached_topic_envelopes = array();

    const KEY_INVALID_AFTER = 'invalid_after';

    const KEY_EVENT = 'event';

    public function __construct(FarReaches_Util $farReaches_Util) {
        parent::__construct($farReaches_Util);
    }
    public function subscribe($topic, $listener) {
        parent::subscribe($topic, $listener);
        $this->invalidate_cache();
        $topic_envelopes =& $this->_get_topic_envelopes($topic);
        if (!empty($topic_envelopes)) {
            // deliver queued up messages
            foreach ($topic_envelopes as $event_data) {
                $event_array = FarReaches_Util::ensure_array($event_data[self::KEY_EVENT]);
                call_user_func_array($listener, $event_array);
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
     * @param int|null $timeout OPTIONAL for how long (in seconds) to maintain undelivered events
     * @param array|'all'|null $user_ids OPTIONAL if provided then event will be delivered to specified users, if omitted then event will be delivered to the current user.
     * @throws InvalidArgumentException
     * @return array containing results from all listeners
     */
    public function publish($topic, FarReaches_Event $farReaches_Event, $success_handler = null, $failure_handler = null, $timeout = self::DEFAULT_TIMEOUT, $user_ids = null) {
        $handler_results = parent::publish($topic, $farReaches_Event, $success_handler, $failure_handler);
        $envelope = $this->to_envelope($farReaches_Event, $success_handler, $failure_handler, $timeout, $this->prepare_user_ids($user_ids));
        $this->add_topic_envelope($topic, $envelope);
        $this->invalidate_cache();
        return $handler_results;
    }

    // 2013-08-08 : PAT wordpress integration removed so this should mean that these hacks could be removed as well.
    //HACK Kostya (Jan-29, 2013): To prevent stack overflow when finishing plugin activation.
    //Got it when server called back on TemporaryApiKey flow request.
    //Call to get_users() spawns new wordpress:// event, users are not set, so get_users() gets called again,
    //spawns new event.. etc.
    private $stop_query_events = false;

    private function prepare_user_ids($user_ids) {
        if ($this->stop_query_events) {
            return array(0);
        }
        if (empty($user_ids)) {
            $current_user_id = $this->get_user_id();
            if (empty($current_user_id)) {
                return $this->prepare_user_ids('all');
            }
            return array($current_user_id);
        } elseif (is_numeric($user_ids)) {
            return array($user_ids);
        } elseif ($user_ids instanceof WP_User) {
            return array($user_ids->ID);
        } elseif ('all' == $user_ids) {
            $user_ids = array();
            $this->stop_query_events = true;
            foreach (get_users() as $user) {
                $user_ids[] = $user->ID;
            }
            $this->stop_query_events = false;
            return $user_ids;
        } else {
            return $user_ids;
        }
    }

    /**
     * Wraps event
     *
     * @param FarReaches_Event|null $farReaches_Event arbitrary data (message) to pass to listeners
     * @param callable|null $success_handler OPTIONAL callable to be invoked upon successful execution of listener. Result from listener will be passed to this callable.
     * @param callable|null $failure_handler OPTIONAL callable to be invoked upon failed execution of listener. Exception from listener will be passed to this callable.
     * @param int|null $timeout for how long to maintain undelivered events
     * @param array $user_ids to whom deliver envelope
     * @return array
     */
    public function to_envelope(FarReaches_Event $farReaches_Event, $success_handler, $failure_handler, $timeout = 0, $user_ids = array()) {
        FarReaches_Validate::not_null($timeout, 'Event timeout is not defined');
        FarReaches_Validate::is_array_of_numeric($user_ids, '$user_ids is not an array of numeric values');
        $envelope = array(self::KEY_EVENT => $farReaches_Event);
        if (is_callable($success_handler)) {
        	$envelope['success_handler_reg_id'] = $this->register_handler($success_handler);
        }
        if (is_callable($failure_handler)) {
        	$envelope['failure_handler_reg_id'] = $this->register_handler($failure_handler);
        }
        $envelope['user_ids'] = $user_ids;
        $envelope[self::KEY_INVALID_AFTER] = FarReaches_Clock::time() + $timeout;
        return $envelope;
    }

    /**
     * Invalidate cached events
     *
     * @return int number of invalidated events
     */
    public function invalidate_cache() {
        $invalidated = 0;
        $now = FarReaches_Clock::time();
        foreach ($this->_cached_topic_envelopes as &$topic_envelopes) {
            foreach ($topic_envelopes as $i => $topic_envelope) {
                if ($topic_envelope[self::KEY_INVALID_AFTER] < $now) {
                    unset($topic_envelopes[$i]);
                    $invalidated++;
                }
            }
        }
        // HACK: Strange behaviour happens without &
        foreach ($this->_cached_topic_envelopes as $topic => &$topic_envelopes) {
            if (empty($topic_envelopes)) {
                unset($this->_cached_topic_envelopes[$topic]);
            }
        }
        return $invalidated;
    }

    /**
     * Clear undelivered events cache.
     *
     * @param string|null $topic OPTIONAL if topic is specified that only undelivered events from this topic will be cleared.
     * @return int number of discarded envelopes
     */
    protected function clear($topic = null) {
        $cleared = 0;
        if (is_null($topic)) {
            foreach ($this->_cached_topic_envelopes as $topic_envelopes) {
                $cleared += count($topic_envelopes);
            }
            $this->_cached_topic_envelopes = array();
        } elseif (isset($this->_cached_topic_envelopes[$topic])) {
            $cleared += count($this->_cached_topic_envelopes[$topic]);
            unset($this->_cached_topic_envelopes[$topic]);
        }
        return $cleared;
    }

    protected function add_topic_envelope($topic, $envelope) {
        $topic_envelopes =& $this->_get_topic_envelopes($topic);
        $topic_envelopes[] = $envelope;
    }

    private function &_get_topic_envelopes($topic) {
        if (array_key_exists($topic, $this->_cached_topic_envelopes)) {
            return $this->_cached_topic_envelopes[$topic];
        } else {
            $this->_cached_topic_envelopes[$topic] = array();
            return $this->_cached_topic_envelopes[$topic];
        }
    }

    public function fetch_cached_topic_envelopes() {
        $result = $this->_cached_topic_envelopes;
        $this->clear();
        return $result;
    }

}
