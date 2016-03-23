<?php

/**
 * Implementation of the FarReaches_EventBus_Storage that uses user meta info for persistence.
 *
 * This class should not be used directly.
 * If you need to work with Event Bus then use FarReaches_EventBus_Facade
 *
 * @link https://github.com/farreaches/farreaches-wp-plugin/wiki/Event-bus---why,-when-and-how
 */
class FarReaches_EventBus_Storage_Meta extends FarReaches_Util_Using implements FarReaches_EventBus_Storage {

    /**
     * Meta key used for persistence.
     */
    const META_KEY = 'event_bus_pending';

    /**
     * Persist envelopes for user.
     *
     * @param int $user_id
     * @param array $topic_envelopes
     * @return void
     */
    function persist($user_id, $topic_envelopes) {
        FarReaches_Validate::is_positive_numeric($user_id);
        if (empty($topic_envelopes)) {
            self::erase($user_id);
        } else {
            // note that FarReaches_Event objects are converted to arrays
            $this->add_user_meta($user_id, self::META_KEY, null, $topic_envelopes);
        }
    }

    /**
     * Load envelopes for user.
     *
     * @param int $user_id
     * @return array
     */
    function load($user_id) {
        FarReaches_Validate::is_positive_numeric($user_id);
        $topic_envelopes = $this->get_user_meta($user_id, self::META_KEY);
        if (is_array($topic_envelopes)) {
            foreach ($topic_envelopes as &$envelopes) {
                foreach ($envelopes as &$envelope) {
                    $farReaches_Event = new FarReaches_Event($user_id);
                    $farReaches_Event->applyHash($envelope['event']);
                    $envelope['event'] = $farReaches_Event;
                    $envelope['user_ids'] = array($user_id);
                }
            }
            return $topic_envelopes;
        } else return array();
    }

    /**
     * Erase storage contents for the user.
     *
     * @param int $user_id
     * @return void
     */
    public function erase($user_id) {
        FarReaches_Validate::is_positive_numeric($user_id);
        $this->delete_user_meta($user_id, self::META_KEY);
    }

}
