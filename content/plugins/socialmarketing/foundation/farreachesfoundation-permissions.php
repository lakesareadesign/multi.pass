<?php
/**
 * Like all files in foundation - this file must not depend on anyone else.
 * @author patmoore
 *
 */
class FarReachesFoundation_Permissions {
    // meta-capabilities -- referenced in farreaches.wp
    // IMPORTANT : all farreaches permissions must begin with 'farreaches_' (see farreaches_map_meta_cap() )
    // can the user edit the information about the organization
    const EDIT_FARREACHES_ORGANIZATION_SETTINGS_CAP = 'farreaches_organization_settings_edit';
    // can the user read the information about the organization settings
    const READ_FARREACHES_ORGANIZATION_SETTINGS_CAP = 'farreaches_organization_settings_read';
    // can the user edit the social media accounts - including dropping the accounts ( the user who created the connection may be treated differently )
    const EDIT_FARREACHES_SOCIAL_MEDIA_SETTINGS_CAP = 'farreaches_social_media_accounts_edit';
    // can the user see the social media accounts details
    const READ_FARREACHES_SOCIAL_MEDIA_SETTINGS_CAP = 'farreaches_social_media_accounts_read';
    // can the user change the categories -> the social media accounts mapping ( maybe for editors only )
    const EDIT_FARREACHES_SOCIAL_MEDIA_CATEGORIES_CAP = 'farreaches_social_media_categories_edit';
    // can the user read the categories -> the social media accounts mapping (needed for authors)
    const READ_FARREACHES_SOCIAL_MEDIA_CATEGORIES_CAP = 'farreaches_social_media_categories_read';
    // can the user change the subscription information
    const EDIT_FARREACHES_SUBSCRIPTION_CAP = 'farreaches_subscription_edit';
    // can the user read the subscription information (needed for authors)
    const READ_FARREACHES_SUBSCRIPTION_CAP = 'farreaches_subscription_read';
    // can the user read the diagnostic information (sensitive information)
    const READ_FARREACHES_DIAGNOSTICS_CAP = 'farreaches_diagnostics_read';
    // the user can publish using farreaches. ( 'publish_posts' permission )
    const PUBLISH_FARREACHES_CAP = 'farreaches_publish_farreaches';
    // user can manage technical details ( looking for 'activate_plugins' permissions )
    // which is needed to resolve technical issues.
    // we just look at activate_plugins permission not install_plugins or update_plugins
    // because in multisite the local admin cannot update or install.
    const MANAGE_FARREACHES_PLUGIN_CAP = 'farreaches_manage_plugin';
    // can manage content (everyones)
    const MANAGE_PUBLISHED_CONTENT_CAP = 'farreaches_manage_published_content';

    /**
     * EXTREMELY IMPORTANT: This function hooks into the entire wordpress permission structure.
     * The entire wordpress site can fail if the $caps or modified $caps is not returned
     *
     * IMPORTANT: Because current_user_can() calls are made very early, these methods need to be registered early as well.
     * IMPORTANT: This is called all the time so make this fast - i.e. no attempt to do any calls to farreaches server.
     *
     * http://codex.wordpress.org/Roles_and_Capabilities
     * TODO: how to handle background task permissions?
     * Usage note: use current_user_can() OR WP_User instance->has_cap($cap, ...extra_args...) (for background tasks)
     *
     * @param array $caps may be an array with only $cap
     * @param unknown $cap
     * @param unknown $user_id
     * @param unknown $args
     * @return array the modified $caps = Add 'do_not_allow' if a feature needs to be turned off even for administrators or super administrators
     */
    public static final function map_meta_cap(array $caps, $cap, $user_id, $args) {
        if ( $cap[0] !== 'f' || strncmp($cap, 'farreaches_', strlen('farreaches_')) !== 0 ) {
            // quick checks for fast return
            return $caps;
        }
        if ( !defined('FARREACHES_DOING_DEACTIVATION') && !FarReaches_Error_Management::is_wordpress_version_allowed()) {
            // old versions of wordpress : we block functionality to minimize weird errors
            // this includes being able to activate the plugin
            // we allow normal checking if deactivating the plugin so that there is the possibility of a clean deactivate
            $caps = array('do_not_allow');
        } else if ( $cap === self::MANAGE_FARREACHES_PLUGIN_CAP) {
            // we just look at activate_plugins permission not install_plugins or update_plugins
            // because in multisite the local admin cannot update or install.
            $caps = array('activate_plugins');
        } else if ( $cap === self::EDIT_FARREACHES_ORGANIZATION_SETTINGS_CAP) {
            // manage_options (administrator) needed to edit the organization's information.
            $caps = array('manage_options');
        } else if ( $cap === self::READ_FARREACHES_ORGANIZATION_SETTINGS_CAP) {
            // manage_categories ( 'editor' ) needed to see the organization's information
            $caps = array('manage_categories');
        } else if ($cap === self::EDIT_FARREACHES_SOCIAL_MEDIA_SETTINGS_CAP) {
            // manage_options ( 'administrator' ) needed to add new social media accounts settings
            $caps = array('manage_options');
        } else if ($cap === self::READ_FARREACHES_SOCIAL_MEDIA_SETTINGS_CAP) {
            // manage_categories ( 'editor' ) needed to see the organization's social media accounts
            $caps = array('manage_categories');
        } else if ($cap === self::EDIT_FARREACHES_SOCIAL_MEDIA_CATEGORIES_CAP) {
            // manage_categories ( 'editor' ) needed to change category to organization's social media accounts mapping
            $caps = array('manage_categories');
        } else if ($cap === self::READ_FARREACHES_SOCIAL_MEDIA_CATEGORIES_CAP) {
            // edit_posts ( 'author' ) needed to see category to organization's social media accounts mapping ( needed to see the mapping when creating posts )
            $caps = array('edit_posts');
        } else if ( $cap === self::EDIT_FARREACHES_SUBSCRIPTION_CAP) {
            // manage_options (administrator) needed to edit the subscription information.
            if (FARREACHES_PAYMENTS_ENABLED) {
                $caps = array('manage_options');
            } else {
                $caps = array('do_not_allow');
            }
        } else if ( $cap === self::READ_FARREACHES_SUBSCRIPTION_CAP) {
            // manage_options ( 'administrator' ) needed to see the organization's subscription information
            if (FARREACHES_PAYMENTS_ENABLED) {
                $caps = array('manage_options');
            } else {
                $caps = array('do_not_allow');
            }
        } else if ( $cap === self::READ_FARREACHES_DIAGNOSTICS_CAP) {
            // manage_options ( 'administrator' ) needed to see the organization's diagnostics information ( sensitive stuff )
            // TODO .... but we need users to be able to report problems and help with diagnostics.
            $caps = array('manage_options');
        } else if ( $cap === self::PUBLISH_FARREACHES_CAP ) {
            $caps = array('publish_posts');
        } else if ( $cap === self::MANAGE_PUBLISHED_CONTENT_CAP) {
            // make sure global ability to edit posts.
            $caps = array ('edit_others_posts', 'edit_published_posts', 'delete_others_posts');
        } else {
            FarReaches_Validate::true(false, "Unknown FarReaches Permission :" . $cap);
        }
        return $caps;
    }
    /**
     * maybe useful for maybe either or options (i.e. where the caps is allowed if the 1 or 2 different capabilities is allowed. ?
     * @param array $allcaps the user's capabilities (foreach [capability] => true)
     * @param unknown $caps - the result of all the map_meta_cap filtering - the requested capabilities
     * @param unknown $args - same args passed to wp_map_meta_cap
     * @return $allcaps modified appropriately.
     */
    // function farreaches_user_has_cap(array $allcaps, array $caps, $args) {
    //     return $allcaps;
    // }
}

// IMPORTANT: Because current_user_can() calls are made very early, these methods need to be registered early as well.
// TODO experiment with capabilities.
add_filter("map_meta_cap", array('FarReachesFoundation_Permissions', 'map_meta_cap'), 10, 1000);
//add_filter("user_has_cap", array('FarReachesFoundation_Permissions','user_has_cap'),10, 1000);
?>
