<?php
/**
 * 'transient' : If notification is transient then it should be returned once and removed
 */
return array(
    'farreaches_server_not_reachable' => array(
        'text' => 'FarReach.es may be down for maintenance, please wait a moment and try again.',
        'transient' => true,
        'failure' => true
    ),
    'farreaches_server_down_to_maintenance' => array(
        'text' => 'FarReach.es is down for maintenance. %s',
        'transient' => false,
        'failure' => true
    ),
    'farreaches_server_internal_error' => array(
        'text' => 'FarReach.es experiencing problems. If this continues, please contact support: support@farReach.es',
        'transient' => false,
        'failure' => true
    ),
    'plugin_has_obsolete_api_version' => array(
        'text' => FARREACHES_PLUGIN_DISPLAY_NAME .' plugin needs to be updated. It cannot communicate to FarReach.es server until it is updated.',
        'failure' => true
    ),
    'plugin_activated' => array(
        'text' => FARREACHES_PLUGIN_DISPLAY_NAME .' needs to complete the %s.',
        'failure' => false
    ),
    'plugin_activating' => array(
        'text' => FARREACHES_PLUGIN_DISPLAY_NAME . ' connecting with FarReach.es to register plugin.',
        'transient' => true,
        'failure' => false
    ),
    'plugin_activating_keys_received' => array(
        'text' => FARREACHES_PLUGIN_DISPLAY_NAME . ' has registered. Syncing plugin state with FarReach.es.',
        'supersede' => array('plugin_activated', 'plugin_activating', 'plugin_activated'),
        'transient' => true,
        'failure' => false
    ),
    'plugin_activation_delayed' => array(
        'text' => FARREACHES_PLUGIN_DISPLAY_NAME .' failed to contact FarReach.es to finish up the registration. The plugin will complete the registration once the FarReach.es server is available.',
        'supersede' => array('plugin_activating'),
        'failure' => true
    ),
    'post_publishing' => array(
        'text' => FARREACHES_PLUGIN_DISPLAY_NAME . ' plugin is now publishing the post via the FarReach.es server.'
    ),
    'post_publishing_delayed' => array(
        'text' => FARREACHES_PLUGIN_DISPLAY_NAME . ' has now delayed publishing the post.'
    ),
    'post_publishing_complete' => array(
        'text' => FARREACHES_PLUGIN_DISPLAY_NAME . ' has published the post via FarReach.es server.'
    ),
    'post_publishing_resending' => array(
        'text' => FARREACHES_PLUGIN_DISPLAY_NAME . ' is trying again to publish the post.'
    ),
    'post_publishing_failed' => array(
        'text' => FARREACHES_PLUGIN_DISPLAY_NAME . ' failed to publish the post.',
        'failure' => true
    ),
    'post_revoked_action_required' => array(
        //TODO need to include links to external services pages/posts for users to find them quickly.
        'text' => 'The post revoke request was sent to FarReach.es, but your action is required to manually remove the post. Visit the external services the post was published to and remove it manually.'
    ),
    'category_change_failed' => array(
        'text' => FARREACHES_PLUGIN_DISPLAY_NAME . ' failed to change the category.'
    ),
    'post_category_is_not_mapped' => array(
        'text' => 'Post was <strong>not</strong> published to any social websites because no post category is mapped to a social website on the <a href="admin.php?page=farReaches_top">settings page</a>.',
        'transient' => true,
        'deferred' => true,
    ),
    'settings_saved_successfully' => array(
		'text' => FARREACHES_PLUGIN_DISPLAY_NAME . ' Settings have been saved successfully.',
		'transient' => true
    ),
    'new_features' => array(
            // Need to substitute in "face book page" twitter
            'text' => FARREACHES_PLUGIN_DISPLAY_NAME . ' Check out %s.',
            'transient' => false
    )
);