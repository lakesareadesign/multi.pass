<?php

/**
 * Class implements publish/subscribe pattern to allow loose coupling between components.
 *
 * This interface should not be used directly.
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
interface FarReaches_EventBus {

    const DELIVER_OR_DROP = -1;
    const NO_HANDLER = null;
    const TOPIC_PREFIX_WIRESERVICE = 'wireservice://';

    /**
     * @todo add a possibility to specify timeout values per topic prefix, e.g. all events to 'eventbus://*' have same timeout self::DELIVER_OR_DROP
     */
    // PAT:
    // HACK if message can not be delivered then throw it away.
    // We are having race conditions when multiple threads are trying to modify the cached envelopes.
    // This most reliably shows up when creating a new user when the FarReaches server is down.
    // Unfortunately, we need the events to be cached when creating a new MEP. The connections window pops up and then registers for the
    // redirect event - which already has happened - so the redirect never occurs.
    // I think that we should be narrowing which events can be persisted until collected vs. events that are DELIVER_OR_DROP.
    const DEFAULT_TIMEOUT = 60; // 1 minute

    /**
     * Subscribe listener to the topic.
     *
     * @param string $topic named logical channel
     * @param callable $listener callable to be invoked when message arrives to the $topic
     * @return void
     */
    public function subscribe($topic, $listener);

    /**
     * Subscribe listener to all topics that are matched by regular expression.
     *
     * @param string $regex regular expression used to match topics
     * @param callable $listener callable to be invoked when message arrives to the $topic
     * @return void
     */
    public function subscribeRegex($regex, $listener);

    /**
     * Unsubscribe listener from the topic.
     *
     * @param string $topic named logical channel
     * @param callable|null $handler callable to unsubscribe. If null then all listeners of the topic will be unsubscribed.
     * @return void
     */
    public function unsubscribe($topic, $handler = null);

    /**
     * Publish event to the topic. All listeners subscribed to the topic will receive event.
     *
     * @param string $topic named logical channel
     * @param FarReaches_Event $event arbitrary data (message) to pass to listeners
     * @param callable|null $success_handler OPTIONAL callable to be invoked upon successful execution of listener. Result from listener will be passed to this callable.
     * @param callable|null $failure_handler OPTIONAL callable to be invoked upon failed execution of listener. Exception from listener will be passed to this callable.
     * @param int $timeout OPTIONAL how long to try deliver event
     * @return array containing results from all listeners
     */
    public function publish($topic, FarReaches_Event $event, $success_handler = null, $failure_handler = null, $timeout = self::DEFAULT_TIMEOUT);

}
