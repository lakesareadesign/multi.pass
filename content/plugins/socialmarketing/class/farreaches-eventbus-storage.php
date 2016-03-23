<?php

/**
 * Interface that is responsible for event bus persistence.
 *
 * This interface should not be used directly.
 * If you need to work with Event Bus then use FarReaches_EventBus_Facade
 *
 * @link https://github.com/farreaches/farreaches-wp-plugin/wiki/Event-bus---why,-when-and-how
 */
interface FarReaches_EventBus_Storage {

    /**
     * Persist envelopes for user.
     *
     * @abstract
     * @param int $user_id
     * @param array $topic_envelopes
     * @return void
     */
    function persist($user_id, $topic_envelopes);

    /**
     * Load envelopes for user.
     *
     * @abstract
     * @param int $user_id
     * @return array
     */
    function load($user_id);

    /**
     * Erase storage contents for the user.
     *
     * @abstract
     * @param int $user_id
     * @return void
     */
    public function erase($user_id);

}