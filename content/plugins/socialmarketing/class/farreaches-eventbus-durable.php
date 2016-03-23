<?php

/**
 * Implementation of publish/subscribe pattern to allow loose coupling between components.
 *
 * This class should not be instantiated/used directly.
 * If you need to work with Event Bus then use FarReaches_EventBus_Facade
 *
 * {@inheritdoc} In addition, this subclass can persist its state to the database and load it later.
 *
 * For example of usage see corresponding unit-test.
 *
 * @link FarReaches_EventBus_Durable_Test
 * @link https://github.com/farreaches/farreaches-wp-plugin/wiki/Event-bus---why,-when-and-how
 * @link http://en.wikipedia.org/wiki/Publish%E2%80%93subscribe_pattern
 */
class FarReaches_EventBus_Durable extends FarReaches_EventBus_Transient {

    /**
     * @var FarReaches_EventBus_Storage
     */
    private $_storage;
    public $_dirty = false;

    public function __construct(FarReaches_Util $farReaches_Util, FarReaches_EventBus_Storage $storage) {
        parent::__construct($farReaches_Util);
        $this->_storage = $storage;
        $this->load($this->get_user_id());
    }

    /**
     * Load events from database.
     */
    private function load($user_id) {
        if (!empty($user_id)) {
            $this->_cached_topic_envelopes = $this->_storage->load($user_id);
            $this->invalidate_cache();
        }
    }

    /**
     * Persist undelivered events to database.
     */
    public function persist() {
        if ($this->_dirty) {
            $user_topic_envelope = array();
            foreach ($this->_cached_topic_envelopes as $topic => $envelopes) {
                foreach ($envelopes as $envelope) {
                    assert(is_array($envelope['user_ids']));
                    $user_ids = $envelope['user_ids'];
                    unset($envelope['user_ids']);
                    foreach ($user_ids as $user_id) {
                        if (!isset($user_topic_envelope[$user_id])) {
                            $user_topic_envelope[$user_id] = array();
                        }
                        if (!isset($user_topic_envelope[$user_id][$topic])) {
                            $user_topic_envelope[$user_id][$topic] = array();
                        }
                        $user_topic_envelope[$user_id][$topic][] = $envelope;
                    }
                }
            }
            if (empty($user_topic_envelope)) {
                $current_user_id = $this->get_user_id();
                if (! is_null($current_user_id)) {
                    // TODO : This is being called a lot - everytime wp is loaded
                    // Maybe we can have some optimization to handle the NOP case better.
                    $this->_storage->erase($current_user_id);
                }
            } else {
                foreach ($user_topic_envelope as $user_id => $topic_envelopes) {
                    $this->_storage->persist($user_id, $topic_envelopes);
                }
            }
            $this->_dirty = false;
        }
    }

    public function invalidate_cache() {
        $invalidated = parent::invalidate_cache();
        if ($invalidated > 0) {
            $this->_dirty = true;
        }
        return $invalidated;
    }

    protected function clear($topic = null) {
        $cleared = parent::clear($topic);
        if ($cleared > 0) {
            $this->_dirty = true;
        }
        return $cleared;
    }

    protected function add_topic_envelope($topic, $envelope) {
        parent::add_topic_envelope($topic, $envelope);
        $this->_dirty = true;
    }
}