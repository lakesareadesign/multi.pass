<?php
/*
 * Class that encapsulates and holds all logic related to front end notifications
 *
 * see also config/farreaches_config_notifications.php
 */
class FarReaches_Notifications_Manager extends FarReaches_Base {

    const META_KEY = "notifications";
    const FORMAT_ARGS_META_KEY = "notifications_format_args";
    const CURRENT_USER = null;
    const TOPIC_NOTIFICATION_SHOW = 'farreaches://notification/show';
    const TOPIC_NOTIFICATION_DISMISS = 'farreaches://notification/dismiss';

    const CONFIG_FILE_NAME = 'notifications';
    private $_notifications_config;

    function __construct(
        FarReaches_Util $farReaches_Util,
        FarReaches_Communication $farReaches_Communication
    ) {
        parent::__construct($farReaches_Util, $farReaches_Communication);
        $this->_notifications_config = $this->get_config_file_contents(self::CONFIG_FILE_NAME);
        if (defined('WP_ADMIN') && WP_ADMIN) {
            $this->add_action('admin_init', 'admin_init');
            FarReaches_EventBus_Facade::subscribeMe($this, array(
                FarReaches_Communication::NOTIFICATION_SERVER_NOT_AVAILABLE => 'onevent_farreaches_server_is_not_available',
                FarReaches_EventBus::TOPIC_PREFIX_WIRESERVICE . 'status/obsolete_api_version' => 'onevent_plugin_has_obsolete_api_version',
                FarReaches_Plugin_State::plugin_state_event_topic(FarReaches_Plugin_State::ACTIVATED) => 'onevent_plugin_activated',
                FarReaches_Plugin_State::plugin_state_event_topic(FarReaches_Plugin_State::KEYS_RECEIVED) => 'onevent_plugin_keys_received'
            ));
            if (defined('DOING_AJAX') && DOING_AJAX) {
                FarReaches_EventBus_Facade::subscribeMe($this, array(self::TOPIC_NOTIFICATION_DISMISS => 'onevent_dismiss_notification'), true);
            }
        }
    }

    // Invoked by wordpress on startup http://codex.wordpress.org/Plugin_API/Action_Reference/admin_init
    public function admin_init() {
        $notifications = $this->_load_notifications();
        if (!empty($notifications)) {
            FarReaches_EventBus_Facade::publishArray(self::TOPIC_NOTIFICATION_SHOW, $notifications);
        }
    }

    private function _load_notifications() {
        $notices = array();
        $superseded_keys = array();
        $transient_keys = array();
        $user_id = $this->get_user_id();

        $user_meta_notifications = $this->get_user_meta($user_id, self::META_KEY);
        if (empty($user_meta_notifications)) {
            return $notices;
        }

        foreach (array_keys($user_meta_notifications) as $key) {
            if (!isset($this->_notifications_config[$key])) {
                continue; // should not be the case but better to handle as we don't trust usermeta :-)
            }

            $notification = $this->_notifications_config[$key];

            // Collect notification keys that we are going to supersede
            if (isset($notification['supersede'])) {
                $superseded_keys = array_unique(array_merge($superseded_keys, $notification['supersede']));
            }

            if (defined('DOING_AJAX') && array_key_exists('deferred', $notification) && (boolean)$notification['deferred']) {
                // If notification is deferred we are not going to send it via AJAX
                continue;
            }
            $farReaches_Event = new FarReaches_Event($user_id);
            $farReaches_Event->key = $key;
            $farReaches_Event->text = $notification['text'];
            $format_args = $this->get_user_meta($user_id, self::FORMAT_ARGS_META_KEY, array($key));
            if (FarReaches_String_Util::not_blank($format_args)) {
                $farReaches_Event->text = sprintf($notification['text'], $format_args);
            }
            
            $notices[] = $farReaches_Event;

            // If notification is transient then it should be returned once and removed
            if (isset($notification['transient']) && (boolean)$notification['transient']) {
                $transient_keys[] = $key;
            }
        }

        // Remove transient notifications
        if (!empty($transient_keys)) {
            $this->delete_user_meta($user_id, self::META_KEY, $transient_keys);
        }

        // Remove superseded notifications
        foreach ($notices as $i => $notice) {
            if (in_array($notice->key, $superseded_keys)) {
                $this->dismiss_notification($notice->key);
                unset($notices[$i]);
            }
        }

        return $notices;
    }

    // used to be run when the plugin did its initial thing. but msg doesn't make sense
    // need message on delayed activation. to get user to complete activation.
    public function onevent_plugin_activated(FarReaches_Event $farReaches_Event) {
        $user = $farReaches_Event->user;
        $top_menu_link = FarReaches_Admin::get_top_menu_link();
        $this->notify_user('plugin_activated', $user, $top_menu_link);
    }
    // used to be run when the plugin did its initial thing. but msg doesn't make sense
    // need message on delayed activation. to get user to complete activation.
    public function onevent_plugin_keys_received(FarReaches_Event $farReaches_Event) {
        $user = $farReaches_Event->user;
        $this->notify_user('plugin_activating_keys_received', $user);
    }
    /**
     * Add a notification that will be displayed at the top of a wordpress admin page.
     *
     * @param string $notification_key  what notification to show
     * @param object|int $user_or_id to whom notification is visible if null then use the current user (put be able to be determined : see FarReaches_Util->set_current_user() )
     * @param $format_args arguments for the $notification['text'] string.
     */
    public function notify_user($notification_key, $user_or_id = null, $format_args = null) {
        FarReaches_Validate::array_has_key($this->_notifications_config, $notification_key, "Invalid notification key: $notification_key");
        $user_id = $this->get_user_id($user_or_id);
        FarReaches_Validate::not_empty($user_id, "notify_user() method passed an empty user parameter and there is no current user set ( see util->set_current_user() )");
        $notification = $this->_notifications_config[$notification_key];
        if (!empty($format_args)) {
            $notification['text'] = sprintf($notification['text'], $format_args);
        }
        $is_deferred = array_key_exists('deferred', $notification) && $notification['deferred'];
        $is_transient = array_key_exists('transient', $notification) && $notification['transient'];
        if ($is_deferred || !$is_transient) {
            $this->add_user_meta($user_id, self::META_KEY, array($notification_key), true);
            if (isset($format_args)) {
                $this->add_user_meta($user_id, self::FORMAT_ARGS_META_KEY, array($notification_key), $format_args);
            }
        }
        if (!$is_deferred) {
            if (isset($notification['supersede'])) {
                $supercede = $notification['supersede'];
                foreach ($supercede as $key_to_supercede) {
                    $dismissed_notifications[$key_to_supercede] = true;
                }
            }
            if (array_key_exists('failure', $notification) && $notification['failure'] === false) {
                // an explicit success message
                foreach($this->_notifications_config as $other_notification_key => $other_notification) {
                    if ($other_notification_key != $notification_key && array_key_exists('failure', $other_notification) && $other_notification['failure'] === true) {
                        $dismissed_notifications[$other_notification_key] = true;
                    }
                }
            }
            if ( !empty($dismissed_notifications)) {
                foreach (array_keys($dismissed_notifications) as $key_to_supercede) {
                    $farReaches_Event = new FarReaches_Event($user_id);
                    $farReaches_Event->data = $key_to_supercede;
                    FarReaches_EventBus_Facade::publish(
                        self::TOPIC_NOTIFICATION_DISMISS,
                        $farReaches_Event,
                        array($user_id)
                    );
                }
            }
            $farReaches_Event = new FarReaches_Event($user_id);
            $farReaches_Event->key = $notification_key;
            $farReaches_Event->text = $notification['text'];
            if (array_key_exists('transient', $notification)) {
                $farReaches_Event->transient = $notification['transient'];
            } else {
                $farReaches_Event->transient = false;
            }
            FarReaches_EventBus_Facade::publish(
                self::TOPIC_NOTIFICATION_SHOW,
                $farReaches_Event,
                array($user_id)
            );
        }
    }

    /**
     * Handle user dismissal of a notification.
     * @param FarReaches_Event $farReaches_Event
     */
    public function onevent_dismiss_notification(FarReaches_Event $farReaches_Event) {
        $this->dismiss_notification($farReaches_Event->data, $farReaches_Event->user);
    }

    private function dismiss_notification($notification_keys, $user_or_id = null) {
        $notification_keys = FarReaches_Util::ensure_array($notification_keys);
        foreach ($notification_keys as $notification_key) {
            if ( FarReaches_Params::key_exists($notification_key, $this->_notifications_config)) {
                $this->delete_user_meta($user_or_id, self::META_KEY, array($notification_key));
            } else {
                $this->error_log(__CLASS__,".", __FUNCTION__,": Invalid notification key:", $notification_key);
            }
        }
    }

    function onevent_farreaches_server_is_not_available(FarReaches_Event $farReaches_Event) {
        $user = $farReaches_Event->user;
        $api_status = $farReaches_Event->api_status;
        if (FarReaches_String_Util::not_blank($api_status)) {
            $this->notify_user('farreaches_server_down_to_maintenance', $user, $api_status);
        }
    }

    function onevent_plugin_has_obsolete_api_version(FarReaches_Event $farReaches_Event) {
    	$this->notify_user('plugin_has_obsolete_api_version');
    }
}
