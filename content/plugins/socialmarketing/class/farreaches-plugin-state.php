<?php

/**
 * TODO: transistions are rather hacky because they happen as non-obvious sideeffects of other actions
 * and background initializations (for example doing sync with server to see if site already registered - before asking for user permission - will mess up the state )
 *
 * IMPORTANT: the plugin state constants can be referenced in javascript.
 */
class FarReaches_Plugin_State {

    /**
     * Set after the plugin is activated via plugins wordpress page.
     */
    const ACTIVATED = 'plugin_state/activated';
    /**
     * Set after we got user's confirmation that it's o.k. to send data to FarReach.es
     */
    const CONFIRMED = 'plugin_state/confirmed';
    /**
     * DEPRECATED:TODO: should not be a state - keys should be gotten as a side-effect of trying to make the call to the server and discovering that they are missing.
     * The plugin is in this state after API keys were received for the first time after confirmation.
     *
     * Note: this is different that the FarReaches_Admin::API_KEYS_RECEIVED - which is sent everytime new api keys are received.
     */
    const KEYS_RECEIVED = 'plugin_state/keys_received';
    /**
     * DEPRECATED:TODO: should not be a plugin state -- we should just get data if we can.
     * we know or can obtain any data from the wireservice.
     *
     * Note: referenced in farreaches_activation.js
     */
    const SYNCED = 'plugin_state/synced';

    private static $__values__;
    private static $__values_except_activated__;
    static function values() {
        if (!isset(FarReaches_Plugin_State::$__values__)) {
            $reflection = new ReflectionClass(__CLASS__);
            FarReaches_Plugin_State::$__values__ = array_values($reflection->getConstants());
        }
        return FarReaches_Plugin_State::$__values__;
    }

    static function values_except_activated() {
        if (!isset(FarReaches_Plugin_State::$__values_except_activated__)) {
            $values = FarReaches_Plugin_State::values();
            FarReaches_Plugin_State::$__values_except_activated__ = array_diff($values, array(FarReaches_Plugin_State::ACTIVATED));
        }
        return FarReaches_Plugin_State::$__values_except_activated__;
    }

    static function plugin_state_event_topic($plugin_state) {
        return 'farreaches://' . $plugin_state;
    }

}
