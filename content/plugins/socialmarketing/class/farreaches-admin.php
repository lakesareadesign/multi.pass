<?php
/**
 * Class that is responsible for configuring the plugin within the WordPress environment.
 *
 * The actual configuration code by the user is handled in FarReaches_Settings_Social_Media and FarReaches_Settings_Organization
 *
 * This class is also responsible for incidental UI that does not justify its own UI. ( for example categories )
 *
 * TODO: Editors ?can see the posts. So we need to move the code related to marking up postlists appropriately.
 * TODO: investigate role abilities.
 * TODO : we need test to make sure that when a new admin user is added they get an api key assigned
 * TO_NEWPERSON : we need a button to allow all users to get new api keys.
 */
class FarReaches_Admin extends FarReaches_Ui_Using {
    const MENU_SLUG_PREFIX = 'farReaches_';
    // NOTE: menu slug names must match template file names (.tmpl)
    const TOP_LEVEL_MENU_SLUG = 'top';
    const ACTIVATE_CONFIRM_STEP_1_MENU_SLUG = 'activate_confirm_step_1';
    const ACTIVATE_CONFIRM_STEP_2_MENU_SLUG = 'activate_confirm_step_2';

    const SUBSCRIPTIONS_MENU_SLUG = 'subscriptions';
    const SUBSCRIPTIONS_PAGE_NAME = 'Subscriptions';

    const SOCIAL_MEDIA_ACCOUNT_SETTINGS_MENU_SLUG = 'social_media_settings';
    const SOCIAL_MEDIA_ACCOUNT_SETTINGS_PAGE_NAME = 'Social Media Settings';

    const ORGANIZATION_SETTINGS_MENU_SLUG = 'organization_settings';
    const ORGANIZATION_SETTINGS_PAGE_NAME = 'General Account';

    const BETA_MENU_SLUG = 'beta_features';
    const BETA_PAGE_NAME = 'Beta Features';

    const FEEDBACK_MENU_SLUG = 'feedback';
    const FEEDBACK_PAGE_NAME = 'Feedback';
    const HELP_MENU_SLUG = 'help';
    const NEW_FEATURES_MENU_SLUG = 'new_features';
    const HELP_PAGE_NAME = 'Help';
    const TERMS_OF_SERVICE_MENU_SLUG = 'tos';
    const TERMS_OF_SERVICE_PAGE_NAME = 'Terms Of Service';
    const PRIVACY_MENU_SLUG = 'privacy';
    const PRIVACY_PAGE_NAME = 'Privacy';
    const COMPLETE_CONNECTION_CONFIGURATION_MENU_SLUG = 'complete_connection_configuration';
	const COMPLETE_CONNECTION_CONFIGURATION_PAGE_NAME = 'Complete connection configuration';

    const RETRY_CONNECTION = 'farreaches-retry-connection';

    const ACTIVATE_CONFIRM_PAGE_NAME = 'Complete registration';

    // DEPRECATED use farreaches specific permissions -- see below.
    const CAPABILITY_REQUIRED_TO_SEE_CONFIG = 'manage_options';
    const CAPABILITY_REQUIRED_TO_EDIT_SELF_POSTS = 'edit_posts';

    const FARREACHES_LIST_COLUMN = 'farreaches_external_services';
    const FARREACHES_USER_PERM = 'farreaches_user';

    /**
     * @var FarReaches_Post_Handling
     */
    private $farReaches_Post_Handling;

    /**
     * @var FarReaches_Diagnostics
     */
    private $farReaches_Diagnostics;

    /**
     * @var FarReaches_Settings_Social_Media
     */
    private $farReaches_Settings_Social_Media;
    /**
     * @var FarReaches_Settings_Organization
     */
    private $farReaches_Settings_Organization;

    /**
     * @var FarReaches_Subscription
     */
    private $farReaches_Subscription;

    /**
     * @var FarReaches_Beta
     */
    private $farReaches_Beta;

    /**
     * @var FarReaches_Notifications_Manager
     */
    private $farReaches_Notifications_Manager;

    /**
     * @var array
     */
    private $admin_pages = array();

    /**
     * @var FarReaches_Wireservice
     */
    private $farReaches_Wireservice;

    private $category_walker;

    // see java server code for complete list of status codes
    private $external_entity_status_map = array(
        "pcd" => "Published on:",
        "upd" => "Updated on:",
        "nvr" => "Never Posted",
        "aut" => "Authentication Problem",
        "abs" => "Not published. Marked as abusive by external service.",
        "iop" => "Problem communicating to external service, FarReach.es will automatically retry in few minutes.",
        "rej" => "External service rejected content for a reason other than authentication issues",
        "crt" => "Farreaches server issue. (contact support@farreach.es)",
        "spt" => "The operation we tried to execute is not supported by external service API. No request were made.",
    );

    function __construct(
        FarReaches_Util $farReaches_Util,
        FarReaches_Communication $farReaches_Communication,
        FarReaches_Post_Handling $farReaches_Post_Handling,
        FarReaches_Notifications_Manager $notificationManager,
        FarReaches_Wireservice $farReaches_Wireservice,
        FarReaches_Ui_Handling $farReaches_Ui_Handling
    ) {
        parent::__construct($farReaches_Util, $farReaches_Communication, $farReaches_Ui_Handling);
        $this->farReaches_Wireservice = $farReaches_Wireservice;

        $this->farReaches_Post_Handling = $farReaches_Post_Handling;
        $this->farReaches_Notifications_Manager = $notificationManager;
        $this->farReaches_Settings_Social_Media = new FarReaches_Settings_Social_Media($farReaches_Util, $farReaches_Communication, $farReaches_Ui_Handling, $this, $farReaches_Post_Handling, $notificationManager, $farReaches_Wireservice);
        $this->farReaches_Settings_Organization = new FarReaches_Settings_Organization($farReaches_Util, $farReaches_Communication, $farReaches_Ui_Handling, $this, $farReaches_Post_Handling, $notificationManager, $farReaches_Wireservice);
        $this->farReaches_Subscription = new FarReaches_Subscription($farReaches_Util, $farReaches_Communication, $farReaches_Ui_Handling);
        $this->farReaches_Beta = new FarReaches_Beta($farReaches_Util, $farReaches_Communication, $farReaches_Ui_Handling);
        $this->farReaches_Diagnostics = new FarReaches_Diagnostics($farReaches_Util, $farReaches_Communication, $farReaches_Ui_Handling);
        $this->init_admin_pages();

        // Pat 31 May 2012 from WP_Plugins_List_Table: line 385
        //   $prefix = $screen->is_network ? 'network_admin_' : '';
        //   $actions = apply_filters( $prefix . 'plugin_action_links', array_filter( $actions ), $plugin_file, $plugin_data, $context );
        //   $actions = apply_filters( $prefix . "plugin_action_links_$plugin_file", $actions, $plugin_file, $plugin_data, $context );
        // We have to hook the second filter ( plugin_file = plugin_dir/plugin_file_name ) to add just actions for us.
        $plugin_file = $this->get_plugin_file();
        $this->add_filter("plugin_action_links_$plugin_file", 'wp_plugin_action_links');
        $this->add_filter("network_admin_plugin_action_links_$plugin_file", 'wp_plugin_action_links');
        $this->add_filter('cron_schedules', 'do_cron_schedules');

        FarReaches_EventBus_Facade::subscribeMe($this, array(
            'farreaches://post/status' => 'onevent_post_status',
            'farreaches://post-list/status' => 'onevent_post_list_status',
            'farreaches://plugin_state/keys_received' => 'on_event_keys_received'
        ), true);

        // register refresh ( which also acts as a way to for us to send update messages async to the plugin )
        $this->add_cron_action('farReaches_PeriodicRefresh', 'oncron_periodic_refresh', 'twicedaily');

        // Maybe should be every 30 min - so that we see issues faster.
        // or 2 jobs - 1 for urgent issues -- code over in error management
        $this->add_cron_action('farReaches_EmailLogSending', 'oncron_email_error_log', 'twicedaily');
        $this->add_action('admin_init', 'user_redirect');
        $this->add_action('admin_menu', 'add_admin_menus');
        $this->add_action('admin_footer', 'admin_footer', FarReaches_Util::LATER_PRIORITY);

        $this->add_action('admin_head-post-new.php', 'on_admin_head_post_page');
        $this->add_action('admin_head-post.php', 'on_admin_head_post_page');
        $this->add_filter(FarReaches_Ui_Handling::FARREACHES_BROWSER_RESOURCES_FILTER_HOOK, 'filter_browser_resources');
    }

    //HACK static because pages are not initialized yet when this one is called.
    public static function get_top_menu_link() {
    	return "<a href='".admin_url("admin.php?page=".self::MENU_SLUG_PREFIX.self::TOP_LEVEL_MENU_SLUG)."'>registration</a>";
    }

    //HACK static because pages are not initialized yet when this one is called.
    public static function get_new_features_menu_link() {
        return "<a href='".admin_url("admin.php?page=".self::MENU_SLUG_PREFIX.self::NEW_FEATURES_MENU_SLUG)."'>new features</a>";
    }

    private function get_processed_category_walker(){
    	if ($this->category_walker == null){
    		$this->category_walker = new FarReaches_Category_Walker($this->farReaches_Wireservice, $this->farReaches_Ui_Handling);
    		wp_terms_checklist(0, array('walker' => $this->category_walker));
    	}
    	return $this->category_walker;
    }

    public function on_event_keys_received() {
    	//$this->farReaches_Notifications_Manager->notify_user('new_features', null, self::get_new_features_menu_link());
    }

    /**
     * Adds in the farreaches code needed on the post edit/ post new pages.
     */
    public function on_admin_head_post_page() {
        wp_enqueue_script(FarReaches_Ui_Handling::FARREACHES_POST_EDIT_CATEGORIES_DECORATION_JS);
        $walker = $this->get_processed_category_walker();
    	$default_category_id = get_option('default_category');
    	$default_category = null;
    	$categories = $walker->get_category_data();
    	foreach ($categories as $category) {
    		if ($category['id'] == $default_category_id) {
    			$default_category = $category;
    		}
    	}
        $this->add_js_config('post_edit_categories_data', array('categories' => $categories, 'default_category' => $default_category));
    }
    /**
     * Looks for redirects set by add_user_redirect() for this user and does the redirect.
     */
    function user_redirect() {
        if (!defined('DOING_AJAX') && !defined('DOING_CRON')) {
            $full_uri = $this->get_user_meta(null, "redirect");
            if (!empty($full_uri)) {
                $this->delete_user_meta(null, "redirect");
                wp_redirect($full_uri);
                // no further processing on this page ( we do not want to give a chance for another redirect to override this one)
                exit;
            }
        }
    }

    /**
     * Add a delayed redirect that will occur when reloading a admin page. This delayed redirect is needed for cases where
     * a filter or action handler would like to do a redirect but cannot because wordpress needs to finish its processing.
     *
     * A particular example of this is during plugin activation. In wordpress plugin activation, wordpress runs code after the
     * plugin activation to complete wordpress's plugin activation process.
     *
     * This extra code interferes with the farreaches activation function doing a redirect as part of the activation itself.
     *
     * @param string $uri
     * @param boolean $menu_slug $uri is a menu_slug
     */
    function add_user_redirect($uri, $menu_slug = true) {
        $full_uri = $menu_slug == true ? $this->get_farreaches_admin_page_url($uri) : $uri;
        $this->add_user_meta(null, "redirect", null, $full_uri);
    }

    /**
     * Supplies the links displayed under the Plugin description on the WordPress installed plugin page
     * wordpress actions :
     *
     *      "plugin_action_links_$plugin_file"
     *      "network_admin_plugin_action_links_$plugin_file"
     *
     * @param unknown $actions
     * @param unknown $file
     * @param unknown $plugin_data
     * @return string
     */
    function wp_plugin_action_links($actions, $file, $plugin_data) {
        if (!$this->is_configuration_in_progress()) {
            if ( current_user_can(FarReachesFoundation_Permissions::READ_FARREACHES_ORGANIZATION_SETTINGS_CAP)) {
                $actions[self::ORGANIZATION_SETTINGS_MENU_SLUG] = $this->get_farreaches_html_a_link(self::ORGANIZATION_SETTINGS_MENU_SLUG);
            }
            if ( current_user_can(FarReachesFoundation_Permissions::READ_FARREACHES_SOCIAL_MEDIA_SETTINGS_CAP)) {
                $actions[self::SOCIAL_MEDIA_ACCOUNT_SETTINGS_MENU_SLUG] = $this->get_farreaches_html_a_link(self::SOCIAL_MEDIA_ACCOUNT_SETTINGS_MENU_SLUG);
            }
        } else if ( current_user_can(FarReachesFoundation_Permissions::MANAGE_FARREACHES_PLUGIN_CAP)) {
            $actions[self::ORGANIZATION_SETTINGS_MENU_SLUG] = $this->get_farreaches_html_a_link(self::ORGANIZATION_SETTINGS_MENU_SLUG, null, $this->__("Complete Activation"));
        }
        $actions[self::FEEDBACK_MENU_SLUG] = $this->get_farreaches_html_a_link(self::FEEDBACK_MENU_SLUG);
        return $actions;
    }

    public function oncron_periodic_refresh(){
        // semi-HACK : use the user who agreed to the TOS.
        $userId = $this->farReaches_Util->set_a_cron_user_id();
        // semi-HACK to make sure we are registered. (TODO: make the cron registration more correct)
        if( $userId > 0 ) {
            $this->api_call(FarReaches_Api_Call::API_PERIODIC_REFRESH);
        }
    }
    public function oncron_email_error_log() {
        // semi-HACK : use the user who agreed to the TOS.
        $userId = $this->farReaches_Util->set_a_cron_user_id();
        // semi-HACK to make sure we are registered. (TODO: make the cron registration more correct)
        if( $userId > 0 ) {
            FarReaches_Error_Management::email_log_if_larger(512);
        }
    }
    /**
     * Runs on plugin activation.
     */
    function activate() {
        // TODO BUG for some reason we are getting a double event notification of the activate plugin state
        // 1) here
        // 2) on initialization on redirect to activation screen
        $this->update_option("plugin_version", null, FARREACHES_PLUGIN_VERSION);

        $this->set_plugin_state(FarReaches_Plugin_State::ACTIVATED);
        // a one-shot action to complete the activation via a redirect.
        $this->add_action('activated_plugin', 'handle_activated_plugin');
    }
    /**
     * Used when plugin can just quietly upgrade without talking with users.
     */
    function upgrade() {
        $this->update_option("plugin_version", null, FARREACHES_PLUGIN_VERSION);
    }
    /**
     * put check here so we can do more complex upgrade checking in the future.
     */
    function check_for_upgrade() {
        $saved_version = $this->get_option("plugin_version");
        $current_version = FARREACHES_PLUGIN_VERSION;
        if ($saved_version != $current_version) {
            // look for backward compatability
            // check to see the saved version is compatible with the saved constant representing the compatible versions.
            if ( isset($saved_version) && substr_compare($saved_version, FARREACHES_COMPATIBLE_VERSION, 0, strlen(FARREACHES_COMPATIBLE_VERSION)) === 0) {
                // different versions but minor upgrade
                $this->upgrade();
            } else {
                //major Upgrade happened and it is significant enough to require that the user manually re-register
                // 1.7.3 version did not write the plugin_version information so we have to always do deactivation.
                $this->deactivate();
                if ( !defined('FARREACHES_ACTIVATING') ) {
                    // reset only if we are not already activating.
                    $this->activate();
                }
            }
        }
    }
    /**
     *  (unfortunately still cannot do a redirect )
     * @param unknown $plugin
     * @param unknown $network_wide
     */
    function handle_activated_plugin($plugin, $network_wide) {
        if ($plugin == $this->get_plugin_file()) {
            // TODO: check to see if account already registered
            // AND/OR register with no users.
            // The action string will be 'activate' if only this plugin was activated.
            // 'activate-selected' if multiple plugins are activated.
            // make sure the request is not a bulk action, redirect to the confirm page
            if (FarReaches_Get::string('action') == 'activate') {
                $this->add_user_redirect(FarReaches_Admin::ORGANIZATION_SETTINGS_MENU_SLUG);
            }
        }
    }

    function deactivate() {
        /**
         * @var wpdb $wpdb
         */
        global $wpdb;

        $this->remove_farreaches_keys($wpdb, $wpdb->usermeta, 'meta_key');
        $this->remove_farreaches_keys($wpdb, $wpdb->options, 'option_name');
        $this->remove_farreaches_keys($wpdb, $wpdb->postmeta, 'meta_key');

        // TODO: notify farreaches so we can deactivate the keys.
    }

    private function remove_farreaches_keys(wpdb $wpdb, $tab, $col) {
        $query = $wpdb->prepare("DELETE FROM $tab WHERE $col LIKE '%s'", $this->farReaches_Util->get_meta_key_prefix() . '%');
        $this->debug_log("$query => " . $wpdb->query($query));
    }

    /**
     * admin_menu hook function.
     */
    function add_admin_menus() {
        $user_api_key = $this->farReaches_Diagnostics->get_current_user_api_key_if_exists();
        $api_key_available = FarReaches_String_Util::not_blank($user_api_key);

        $plugin_state = $this->get_plugin_state();
        // from http://codex.wordpress.org/Function_Reference/add_menu_page
        //         The position in the menu order this menu should appear. By default, if this parameter is omitted,
        //         the menu will appear at the bottom of the menu structure. The higher the number, the lower its position in the menu.
        //         WARNING: if two menu items use the same position attribute, one of the items may be overwritten so that only one item displays!
        //         Risk of conflict can be reduced by using decimal instead of integer values, e.g. 63.3 instead of 63 (Note: Use quotes in code, IE '63.3').
        $position = '3.3453453';
        // HACK - because page is really a virtual page
        add_menu_page($this->__(self::SOCIAL_MEDIA_ACCOUNT_SETTINGS_PAGE_NAME), $this->get_plugin_display_name(), FarReachesFoundation_Permissions::READ_FARREACHES_ORGANIZATION_SETTINGS_CAP,
            self::MENU_SLUG_PREFIX . self::TOP_LEVEL_MENU_SLUG, $this->make_callable('show_page_top_level'), '', $position);
        $this->add_submenu_pages(self::MENU_SLUG_PREFIX . self::TOP_LEVEL_MENU_SLUG, $plugin_state, $api_key_available);

        if ($api_key_available) {
            //User has an API Key, load in full menu
            $this->add_filter("manage_edit-post_columns", "set_edit_post_columns");
            $this->add_action('manage_posts_custom_column', 'custom_post_columns');
            $this->add_filter("manage_edit-category_columns", "set_edit_category_columns");
            $this->add_action('manage_category_custom_column', 'custom_category_columns');
            $this->add_action('add_meta_boxes', 'add_publishing_meta_box');
            $this->add_action('post_submitbox_misc_actions', 'render_publishing_controls');

            // TODO: no functionality yet.
            //add extra fields to category edit form hook
//             $this->add_action('edit_category_form_fields', 'extra_category_fields');
            // save extra category extra fields hook
//             $this->add_action('edited_category', 'save_extra_category_fields');
        }
    }

    private function is_configuration_in_progress() {
        $configuration_in_progress =$this->get_plugin_state() != FarReaches_Plugin_State::SYNCED;
        return $configuration_in_progress;
    }

    // TODO : Have each page get registered in the correct class instead of making this class know about them.
    private function init_admin_pages() {
        $hide_settings_pages = false; //$this->is_configuration_in_progress();
        $this->init_submenu_page(self::ORGANIZATION_SETTINGS_MENU_SLUG, $this->__(self::ORGANIZATION_SETTINGS_PAGE_NAME),
                FarReaches_Plugin_State::values(),
                $this->make_callable($this->farReaches_Settings_Organization, 'show_page_organization_settings'), null, false, $hide_settings_pages);
        $this->init_submenu_page(
                self::SOCIAL_MEDIA_ACCOUNT_SETTINGS_MENU_SLUG, $this->__(self::SOCIAL_MEDIA_ACCOUNT_SETTINGS_PAGE_NAME),
                FarReaches_Plugin_State::values_except_activated(),
                $this->make_callable($this->farReaches_Settings_Social_Media,'show_page_social_media_settings'), null, true, true);
        if (FARREACHES_PAYMENTS_ENABLED) {
            // TODO : why limit when the subscription page is displayed.
            $this->init_submenu_page(self::SUBSCRIPTIONS_MENU_SLUG, $this->__(self::SUBSCRIPTIONS_PAGE_NAME), FarReaches_Plugin_State::values_except_activated(),
                    $this->make_callable($this->farReaches_Subscription, 'show_page_subscriptions'), null, true, false);
        }
        $feature_set = FarReaches_Subscription::get_feature_set($this->farReaches_Util);
        //HACK think of better way to detect that the page is to be shown.
        if ($feature_set->is_active('anl')) {
            $this->init_submenu_page(
                    self::BETA_MENU_SLUG,
                    $this->__(self::BETA_PAGE_NAME),
                    FarReaches_Plugin_State::values_except_activated(),
                    $this->make_callable($this->farReaches_Beta, 'show_page_beta'),
                    null, true, false);
        }

        $this->init_submenu_page(self::FEEDBACK_MENU_SLUG, $this->__(self::FEEDBACK_PAGE_NAME), FarReaches_Plugin_State::values(), $this->make_callable($this->farReaches_Diagnostics, 'show_page_diagnostics'), null, false);

        $this->init_submenu_page(self::HELP_MENU_SLUG, $this->__(self::HELP_PAGE_NAME), FarReaches_Plugin_State::values(), 'show_page_help', null, false);
        //$this->init_submenu_page(self::NEW_FEATURES_MENU_SLUG, $this->__("New Features"), FarReaches_Plugin_State::values(), 'show_page_new_features', null, false);
        $this->init_submenu_page(self::TERMS_OF_SERVICE_MENU_SLUG, $this->__(self::TERMS_OF_SERVICE_PAGE_NAME), FarReaches_Plugin_State::values(), 'show_page_terms_of_service', null, false, true);
        $this->init_submenu_page(self::PRIVACY_MENU_SLUG, $this->__(self::PRIVACY_PAGE_NAME), FarReaches_Plugin_State::values(), 'show_page_privacy', null, false, true);
        // page used to complete the connection - since it is a popup
        $this->init_submenu_page(self::COMPLETE_CONNECTION_CONFIGURATION_MENU_SLUG, $this->__(self::COMPLETE_CONNECTION_CONFIGURATION_PAGE_NAME),  FarReaches_Plugin_State::values_except_activated(),
                $this->make_callable($this->farReaches_Settings_Social_Media,'show_page_complete_connection_configuration'), null, false, true);
    }

    /**
     * Dynamically determines which page is the "top" level menu item. We defer determination until the menu item is triggered to allow for the plugin state to
     * change outside of the current browser window
     */
    public function show_page_top_level() {
        if ($this->is_configuration_in_progress()) {
            $real_page = $this->get_admin_page_by_menu_slug(self::ORGANIZATION_SETTINGS_MENU_SLUG);
        } else {
            $real_page = $this->get_admin_page_by_menu_slug(self::SOCIAL_MEDIA_ACCOUNT_SETTINGS_MENU_SLUG);
        }
        call_user_func_array($real_page['function'], array());
    }
    /**
     *
     * @param unknown $menu_slug
     * @param unknown $menu_title
     * @param unknown $state - DEPRECATED - to crude for many purposes - use wp capabilities
     * @param string $handler defaults (or null) to calling function 'show_page_' . $menu_slug
     * @param string $page_title defaults to $menu_title
     * @param string $api_key_needed
     * @param string $hidden_page
     * @param string $capability  - DEPRECATED - use farreaches specific permissions
     */
    private function init_submenu_page($menu_slug, $menu_title, $state, $handler = null, $page_title = null, $api_key_needed = true, $hidden_page = false, $capability = self::CAPABILITY_REQUIRED_TO_SEE_CONFIG) {
        FarReaches_Validate::is_null($this->get_admin_page_by_menu_slug($menu_slug), "$menu_slug already exists");
        if (!isset($page_title)) {
            $page_title = $menu_title;
        }

        if ( !isset($handler)) {
            $handler = 'show_page_' . $menu_slug;
        }

        // Prepends self::MENU_SLUG_PREFIX to the menu slug so it is properly unique in the wordpress environment
        $expanded_menu_slug = self::MENU_SLUG_PREFIX . $menu_slug;
        $this->admin_pages[$menu_slug] = array(
            "menu_title" => $menu_title,
            "page_title" => $page_title,
            "state" => $state,
            "function" => $this->make_callable($handler),
            "api_key_needed" => $api_key_needed,
            "hidden_page" => $hidden_page,
            "expanded_menu_slug" => $expanded_menu_slug,
            "capability" => $capability,
        );
    }

    /**
     * This method will add the submenu for the parent menu (FarReach.es menu). Depends on the plugin state(activate,
     * activate_confirm) and the api key, certain submenu will be added or not
     *
     * @param string $parent_slug
     * @param string $state: activate or activate_confirmed states
     * @param boolean $api_key_available
     */
    private function add_submenu_pages($parent_slug, $state, $api_key_available) {
        foreach ($this->admin_pages as $menu_slug => $admin_page) {
            if (in_array($state, $admin_page['state'])) {
                if ($api_key_available || !$admin_page['api_key_needed']) {
                    if ($admin_page['hidden_page']) {
                        add_submenu_page(null, $admin_page['page_title'], $admin_page['menu_title'],
                            $admin_page["capability"], $admin_page["expanded_menu_slug"], $admin_page['function']);
                    } else {
                        add_submenu_page($parent_slug, $admin_page['page_title'], $admin_page['menu_title'],
                            $admin_page["capability"], $admin_page["expanded_menu_slug"], $admin_page['function']);
                    }
                }
            }
        }
    }

    /**
     * Use to build a link to a plugin admin page
     *
     * @param string $menu_slug
     * @param array $query_params
     * @return string URL
     */
    function get_farreaches_admin_page_url($menu_slug, $query_params = null) {
        $admin_page = $this->get_admin_page_by_menu_slug($menu_slug);
        FarReaches_Validate::not_null($admin_page, "$menu_slug does not exists");
        $form_data = array("page" => $admin_page["expanded_menu_slug"]);
        if (isset($query_params)) {
            $form_data = array_merge($form_data, $query_params);
        }
        $query_str = http_build_query($form_data);
        return admin_url('admin.php?' . $query_str);
    }

    /**
     * Create the <a> html link to link to a plugin admin page.
     *
     * @param string $menu_slug
     * @param array|null $query_params
     * @param string $menu_title ([optional] overrides standard )
     * @param string $page_title ([optional] overrides standard )
     * @return string
     */
    public function get_farreaches_html_a_link($menu_slug, array $query_params = null, $menu_title = null, $page_title = null) {
        $admin_page = $this->get_admin_page_by_menu_slug($menu_slug);
        FarReaches_Validate::not_empty($admin_page, "No admin page with slug $menu_slug");
        $uri = $this->get_farreaches_admin_page_url($menu_slug, $query_params);
        if ( !empty($menu_title) && empty($page_title)) {
            $page_title = $menu_title;
        }
        if ( empty($menu_title)) {
            $menu_title = $admin_page["menu_title"];
        }
        if ( empty($page_title)) {
            $page_title = $admin_page["page_title"];
        }
        return sprintf("<a href='%s' title='%s'>%s</a>", $uri, $page_title, $menu_title);
    }

    /**
     * This method is executed as a WordPress 'FarReaches_Ui_Handling::FARREACHES_BROWSER_RESOURCES_FILTER_HOOK' action handler
     */
    public function filter_browser_resources($js_config) {
        $returned = array_merge($js_config,
                array('settings_page_url' => $this->get_farreaches_admin_page_url(FarReaches_Admin::SOCIAL_MEDIA_ACCOUNT_SETTINGS_MENU_SLUG),
                      'show_page_complete_connection_configuration_url' => $this->get_farreaches_admin_page_url(FarReaches_Admin::COMPLETE_CONNECTION_CONFIGURATION_MENU_SLUG)
                        )
        );
        return $returned;
    }
    /**
     * Only public for testing
     * @param unknown $menu_slug
     * @return multitype:|NULL
     */
    public function get_admin_page_by_menu_slug($menu_slug) {
        if (FarReaches_Params::key_exists($menu_slug, $this->admin_pages)) {
            return $this->admin_pages[$menu_slug];
        } else {
            return null;
        }
    }

    function set_edit_post_columns($columns) {
        global $posts;

        // This is a performance trick allowing us to cache posts bulk status responce.
        $this->_get_posts_statuses($posts, true);

        return array_merge($columns, array(self::FARREACHES_LIST_COLUMN => $this->get_plugin_display_name()));
    }

    /**
     * This function is invoked for each post in the list.
     *
     * @param object $column
     */
    function custom_post_columns($column) {
        switch ($column) {
        case self::FARREACHES_LIST_COLUMN :
            $this->_render_post_status(false, false);
            break;
        }
    }

    /**
     * Category list page customization
     *
     * @param $columns
     * @return array
     */
    function set_edit_category_columns($columns) {
        return array_merge($columns, array(self::FARREACHES_LIST_COLUMN => $this->get_plugin_display_name()));
    }

    /**
     * TODO: a new category results in no <td></td> being rendered so there is a wierd artifact of no separator in the SocialMarketing column
     * Note that the $accepted_args must be explicitly set to get more than 1 arg.
     * $blank : see class-wp-terms-list-table.php ( column_default() ) - always passes ''
     * $column : the key as registered in set_edit_category_columns()
     * $termId : the categoryId.
     */
    function custom_category_columns($blank, $column, $term_id) {
        global $taxonomy;
        global $post_type;
        global $tag;
        $ext_services = array();
        foreach ($this->farReaches_Wireservice->get_external_service_definitions_associated_with_categories($term_id) as $definition) {
            // TODO this isn't consistent, seems to show disabled category connections often (see email)
            $ext_services[] = array(
                'service' => $definition['name'],
                'term_id' => $term_id,
                'service_icon' => $this->farReaches_Ui_Handling->get_extserv_img_uri(strtolower($definition['service_name']), '16')
            );
        }
        $this->generate_jsrender_template(array('key' => 'category_ext_service'), true, array('ext_services' => $ext_services,
                'settings_page' => $this->get_farreaches_admin_page_url(self::SOCIAL_MEDIA_ACCOUNT_SETTINGS_MENU_SLUG)
        ));
    }

        /* Adds a box to the main column on the Post and Page edit screens */
    function add_publishing_meta_box() {
        add_meta_box('farreaches_publishing', FARREACHES_PLUGIN_DISPLAY_NAME, $this->make_callable('add_publishing_meta_box_inner'), 'post', 'side', 'high');
    }

    function add_publishing_meta_box_inner($post) {
        echo "<div class='farreaches-meta-box-section'>";
        $this->render_post_preview_block();
    	$this->render_farreaches_post_status();
    	echo "</div>";
    }

    function render_publishing_controls() {
        global $post;
        echo "<div class='misc-pub-section farreaches-meta-box-section'>";
        // Each div that holds rendered post status should be associated with post using such attribute in order to re-render it then later asynchronously
        $template = array('key' => 'post_publishing_controls');
        $template_values = $this->_get_post_controls_data($post);
        $this->generate_jsrender_template($template, true, $template_values, false);
        //$this->render_post_preview_block();
        echo "</div>";
    }


    private function _get_post_controls_data($post) {
        $post = get_post($post);
        $post_local_transmission_status = $this->farReaches_Post_Handling->get_post_local_transmission_status($post);
        // we want to default to true.
        $post_eligible_for_automatic_handling = $this->farReaches_Post_Handling->get_post_eligible_for_automatic_handling($post);
        if (!isset($post_eligible_for_automatic_handling)) {
            $post_eligible_for_automatic_handling = $post->status ==='new';
        }
        $enable_abort = FarReaches_Post_Handling::POST_LOCAL_STATUS_TRANSMISSION_DELAYED == $post_local_transmission_status;
        // abort acts like uncheck on automatic publish
        $enable_automatic_publishing = !$enable_abort;
        $template_values = array(
                'post_id' => $this->get_id($post),
                'enable_abort' => $enable_abort,
                // TODO : Note issue if there is a programming failure while sending the post.
                // Need a way to get out of POST_LOCAL_STATUS_TRANSMISSION_IN_PROGRESS
                'enable_publish_now' => in_array($post_local_transmission_status, array(
                        FarReaches_Post_Handling::POST_LOCAL_STATUS_TRANSMISSION_DELAYED,
                        FarReaches_Post_Handling::POST_LOCAL_STATUS_TRANSMISSION_ERROR,
                        FarReaches_Post_Handling::POST_LOCAL_STATUS_TRANSMISSION_ABORTED,
                        FarReaches_Post_Handling::POST_LOCAL_STATUS_TRANSMISSION_CANCELLED_AS_ALREADY_PUBLISHED_LOCALLY
                )),
                'enable_automatic_publishing' => $enable_automatic_publishing,
                'post_automatic_publishing' => $post_eligible_for_automatic_handling,
                'post_automatic_publishing_value' => $post_eligible_for_automatic_handling ? "checked" : ""
        );
        return $template_values;
    }


    /**
     * Renders post status for the right side publish box.
     */
    function render_farreaches_post_status() {
        // TODO : this should also be an admin level notification ( i.e. yellow bar across the top )
        $message_endpoints_tree = $this->farReaches_Wireservice->get_message_endpoints_tree();
        if ( ! $this->is_response_in_error($message_endpoints_tree) &&
          !$this->farReaches_Wireservice->has_active_message_endpoints()) {
            echo "<div>Configure social media sites on the " .$this->get_farreaches_html_a_link(self::SOCIAL_MEDIA_ACCOUNT_SETTINGS_MENU_SLUG) . "</div>";
        }
        $this->_render_post_status();
    }

    private function _render_post_status($show_publishing_controls = true, $refresh_missing=true) {
        global $post;
        wp_enqueue_script(FarReaches_Ui_Handling::FARREACHES_POST_STATUS_UPDATE); // to update post status asynchronously
        // Each div that holds rendered post status should be associated with post using such attribute in order to re-render it then later asynchronously
        $template = array('key' => 'post_status', 'custom_attrs' => "data-post-id='$post->ID'");
        $posts_status_map = $this->_get_posts_statuses(array($post), $refresh_missing);
        $template_values = array_merge($posts_status_map[$post->ID], $show_publishing_controls ? $this->_get_post_controls_data($post) : array());
        $this->generate_jsrender_template($template, true, $template_values, false);
    }

    /**
     * Returns posts status data (batch).
     *
     * @param array[WP_Post] $posts
     * @return array Either a map (Post=>Array) with local status data or a map (Post=>Array) of arrays with status data for each external service
     */
    private function _get_posts_statuses($posts, $refresh_missing = true) {
        $userId = $this->get_user_id();
        $posts_to_refresh = array();
        foreach($posts as $post) {
            if ( $this->farReaches_Post_Handling->get_post_is_managed($post) !== false) {
                // for posts that are eligible OR we do not know about yet, then we can ask FarReach.es
                $posts_to_refresh[] = $post;
            }
        }

    	$post_external_service_statuses = $this->farReaches_Post_Handling->get_posts_statuses($posts_to_refresh, $userId, $refresh_missing);
        $result = array();

		foreach ($posts as $post) {
		    $post_id = $this->get_id($post);
			$result[$post_id] = array('statuses' => $this->_get_post_statuses($post, $post_external_service_statuses));
		}

    	return $result;
    }

    /**
     * Returns post status data.
     *
     * @param WP_Post $post
     * @param array $post_external_service_statuses
     * @return array Either a array with local status data or an array of arrays with status data for each external service
     */
    private function _get_post_statuses($post, $post_external_service_statuses) {
        $post_id = $this->get_id($post);
        $statuses = array();

        if (!$this->is_response_in_error($post_external_service_statuses) && FarReaches_Params::key_exists($post_id, $post_external_service_statuses)) {
            $statuses = $this->_get_display_post_external_statuses($post_id, $post_external_service_statuses[$post_id]);
        }

        $post_not_sent = $this->farReaches_Post_Handling->get_post_local_transmission_status($post) != FarReaches_Post_Handling::POST_LOCAL_STATUS_TRANSMISSION_SUCCESSFUL;
        if (empty($statuses) || $post_not_sent) {
            $post_local_status = $this->farReaches_Post_Handling->get_post_local_transmission_status_object($post);
            $statuses[] = &$post_local_status;
        }
        return $statuses;
    }

    private function _get_display_post_external_statuses($post_id, array $external_entity_statuses) {
        $statuses = array();
        // TODO : sort by date
        foreach ($external_entity_statuses as $messagePointLookupKey => $external_entity_status_array) {
            foreach($external_entity_status_array as $external_entity_status) {
                $status_code = $external_entity_status['externalEntityStatus'];
                if ('spt' == $status_code || 'nvr' == $status_code) {
                    // The operation we tried to execute is not supported by external service API. No request were made.
                    // or this post was not sent to the mep.
                    continue;
                }
                $statuses[] = $this->get_display_post_external_status($post_id, $external_entity_status);
            }
        }
        return $statuses;
    }

    public function get_display_post_external_status($post_id, $external_entity_status) {
        $status_code = $external_entity_status['externalEntityStatus'];
        $external_service_name = FarReaches_Params::def($external_entity_status, 'externalServiceDefinition');
        //Making plugin-provided dates formatted like other dates in WP admin console:
        //WP does not apply settings date formats to admin console.
        //We mimic admin console formats for post-list/post-edit pages.
        $date_as_str = FarReaches_Params::string($external_entity_status, 'unblockCompletedTime');
        $dateTime = $this->parse_date_from_format($date_as_str);
        $timestamp = '';
        if (!empty($dateTime)) {
            //TODO add support for other WP-mimic formats, like "3 hours ago" for 'today' posts.
            // $timestamp = $dateTime->format($displaying_post_list? FARREACHES_DATE_FORMAT_POST_LIST: FARREACHES_DATE_FORMAT_POST_INFO);
            $timestamp = $dateTime->format(FARREACHES_DATE_FORMAT_POST_INFO);
        }

        $status = array(
                'post_id' => $post_id,
                'statusText' => FarReaches_Params::string($this->external_entity_status_map, $status_code),
                'status' => $status_code,
                'timestamp' =>  $timestamp
        );
        if ( $external_service_name != null) {
            // HACK : 21-feb-2013 this is to work around a server problem where server lose track of ESI that published the information.
            $service_alias = strtolower($this->farReaches_Wireservice->get_external_service_attribute($external_service_name, 'service_name'));
            $status['service'] = $service_alias;
        }
        if ('aut' === $status_code) {
            $status['link'] = $this->get_farreaches_admin_page_url(self::SOCIAL_MEDIA_ACCOUNT_SETTINGS_MENU_SLUG);
        } elseif ('pcd' === $status_code) {
            $status['service_link'] = $this->farReaches_Wireservice->get_external_service_attribute($external_service_name, 'link');
            $status['link'] = FarReaches_Params::def($external_entity_status,'publicUri');
        } else if ('upd' === $status_code) {
            $status['link'] = FarReaches_Params::def($external_entity_status, 'publicUri');
        } else {
            // TODO add the farreaches customer service url for iop? on the meantime, it'll redirect just like aut
            $status['link'] = $this->get_farreaches_admin_page_url(self::SOCIAL_MEDIA_ACCOUNT_SETTINGS_MENU_SLUG);
        }
        return $status;
    }

    /**
     * This method is an event bus handler that periodically receives events from farreaches_postlist_status_update.js
     * to asynchronously update posts statuses in the list.
     *
     * @todo TO_YURIY instead of checking status every event_bus sync it should be published once update is available
     * TODO : wireserver should be pushing to plugin, not plugin should be polling.
     *
     * Called from edit Post / Post List pages
     * Client side script: farreaches_post_status_update.js
     *
     * TODO: look at java framework ( https://github.com/Atmosphere/atmosphere  )
     */
    function onevent_post_status(FarReaches_Event $farReaches_Event) {
        $post_ids = $farReaches_Event->data;
        $statuses = $this->post_status_inner($post_ids);
        reset($statuses);
        $post_id = key($statuses);
        return array($post_id => array_merge($statuses[$post_id], $this->_get_post_controls_data($post_id)));
    }

    /**
     * Same as 'post_status'
     */
    function onevent_post_list_status(FarReaches_Event $farReaches_Event) {
        $post_ids = $farReaches_Event->data;
    	return $this->post_status_inner($post_ids);
    }

    /**
     *
     * @param array|int $post_ids array of post ids which statuses are to update
     * @return array map of post id => status
     */
    private function post_status_inner($post_ids) {
    	$posts = array();
    	$post_ids_array = FarReaches_Util::ensure_array($post_ids);
    	// TODO HACK : why is it necessary to get the post itself?
    	foreach($post_ids_array as $post_id) {
    		$posts[] = get_post($post_id);
    	}
    	return $this->_get_posts_statuses($posts, true);
    }

    function render_post_preview_block() {
        $message_endpoints_tree = $this->farReaches_Wireservice->get_message_endpoints_tree();
    	$walker = $this->get_processed_category_walker();
    	$connected_services = $walker->get_connected_service_aliases();

        $template_data = array();
            // loop is to handle preview button:
            // which preview be availabe to user on post page.
            // 1)   yuriy: (first simple) to show all preview buttons even if no mep
        foreach ($this->farReaches_Wireservice->get_external_service_definitions() as $definition) {
            $service_alias = strtolower($definition['service_name']);

            //if (in_array($service_alias, $connected_services)){
	            $template_data[] = array(
	                'service_icon_url' => $this->farReaches_Ui_Handling->get_extserv_img_uri($service_alias, '24'),
	                'service_alias' => $service_alias,
	            );
	            // TODO TO_YURIY remove this matching loop ( combine with outer loop )
	            // 2)   if user has mep then actually details like profile picture from actual mep
	            if ( !$this->is_response_in_error($message_endpoints_tree)) {
	                foreach($message_endpoints_tree as $message_end_point) {
	                    if (FarReaches_Params::string($message_end_point, 'externalServiceDefinition') == $definition['name']) {
	                        $this->add_js_config($service_alias, $message_end_point);
	                        break;
	                    }
	                }
	            }
	            $this->generate_jsrender_template(array('key' => "post_preview_$service_alias"), false, null, false);
            //}
        }

        // TODO : PAT : add line on img.preview-icon in farreach.js ( line 286 :  $('img.preview-icon').click(function()  )
        // create jquery custom event. - or rather use eventbus - custom event : need to have a single event bus on the js )
        // js may not have the mep_map (yet ).
        $this->generate_jsrender_template(array('key' => 'post_preview'), true, array('definitions' => $template_data), false);
    }

    function admin_footer() {
        wp_enqueue_script(FarReaches_Ui_Handling::FARREACHES_PREMIUM_JS);
        if ( FARREACHES_PAYMENTS_ENABLED) {
            $this->add_js_config('subscriptions_link', $this->get_farreaches_admin_page_url(self::SUBSCRIPTIONS_MENU_SLUG));
        }
        $this->generate_jsrender_template(array('key' => 'premium'), false);
        $this->farReaches_Ui_Handling->load_browser_resources();
    }

    function show_page_help() {
    	$plugin_url = $this->get_plugin_url();
    	// TODO: mechanism to have caching
    	// or mechanism to allow the help to be directly displayed. without iframe
        $uri = $plugin_url . 'help/index.html';
        $data = array('url' => $uri);
        $this->generate_jsrender_template(array('key' => 'help'), true, $data);
    }

    function show_page_new_features() {
        global $current_user;
        $query_params = array('origin'=> site_url(),
                'email' => $current_user->user_email);
        $query_string = http_build_query($query_params);
        $data = array('url' => 'http://farreaches-premium.appspot.com?' . $query_string);
        $this->generate_jsrender_template(array('key' => 'help'), true, $data);
    }

    // TODO : should really come from the farreach.es website
    function show_page_terms_of_service() {
        $plugin_url = $this->get_plugin_url();
        // TODO: mechanism to have caching
        // or mechanism to allow the help to be directly displayed. without iframe
        $uri = $plugin_url . 'help/TermsOfService.html';
        $data = array('url' => $uri);
        $this->generate_jsrender_template(array('key' => 'help'), true, $data);
    }

    // TODO : should really come from the farreach.es website
    function show_page_privacy() {
        $plugin_url = $this->get_plugin_url();
        // TODO: mechanism to have caching
        // or mechanism to allow the help to be directly displayed. without iframe
        $uri = $plugin_url . 'help/Privacy.html';
        $data = array('url' => $uri);
        $this->generate_jsrender_template(array('key' => 'help'), true, $data);
    }

    /**
     * Remove meta box so we can have a custom wp_terms_checklist walker.
     */
    function remove_default_categories_box() {
        remove_meta_box('categorydiv', 'post', 'side');
    }

    /**
     * This function checks if the plugin is in the middle of getting an api key using the secured two phase process.
     * The user meta data related to temp api key is created during the start of the process. This meta data is removed
     * once the api key is retrieved from the FarReaches server.
     */
    function is_request_api_key_running() {
        return $this->is_present_temp_key_cb() || $this->is_present_perm_key_cb();
    }

    function is_present_temp_key_cb() {
        $meta_key = $this->farReaches_Communication->get_callback_meta_key_base(FarReaches_Api_Call::API_KEY_TEMPORARY);
        $temp_api_cb = $this->get_user_meta(null, $meta_key);
        return !empty($temp_api_cb);
    }

    function is_present_perm_key_cb() {
        $meta_key = $this->farReaches_Communication->get_callback_meta_key_base(FarReaches_Api_Call::API_KEY_PERMANENT);
        $perm_api_cb = $this->get_user_meta(null, $meta_key);
        return !empty($perm_api_cb);
    }

    function do_cron_schedules($schedules) {
        // fast scheduling - useful for getting periodic refreshes (for debugging)
        $schedules['farreaches-fast'] = array(
            'interval' => 60*5,
            'display' => __( 'frequent updating for testing' )
        );
        return $schedules;
    }
}

/**
 * This class runs through all blog categories and collects
 * 1) farreaches category data (icons, links etc).
 * 2) a full list of services connected to categories.
 *
 * TO_NEWPERSON: Get rid of the class. Extending the UI builder class just to gather the data seems to be
 * an overkill.
 *
 */

class FarReaches_Category_Walker extends Walker_Category {
	private $farReaches_Wireservice;
	private $farReaches_Ui_Handling;
	private $output_Cat_Data = array();
	private $output_Connected_Service_Aliases = array();

	/**
	 *
	 * @return a plain category-data array ready for further processing, i.e. serialize to JSON for client.
	 */
	public function get_category_data(){
		return $this->output_Cat_Data;
	}

	/**
	 *
	 * @return returns a set of active external service aliases.
	 */
	public function get_connected_service_aliases(){
		return array_unique($this->output_Connected_Service_Aliases);
	}

	function __construct(FarReaches_Wireservice $farReaches_Wireservice, FarReaches_Ui_Handling $farReaches_Ui_Handling) {
		$this->farReaches_Wireservice = $farReaches_Wireservice;
		$this->farReaches_Ui_Handling = $farReaches_Ui_Handling;
	}

	function start_el( &$output, $category, $depth = 0, $args = array(), $id = 0 ) {
		$category_Obj = array();
		$category_Obj['id'] = $category->term_id;
		$category_Obj['slug'] = $category->slug;
		$category_Obj['parent_id'] = $category->parent;

		$category_registered = $this->farReaches_Wireservice->is_category_registered($category);
		$category_Obj['category_registered'] = $category_registered;

		if ($category_registered) {
			$far_icons = array();
			$endpoints = $this->farReaches_Wireservice->list_message_endpoints_associated_with_categories($category->term_id);
			// We don't have access to is_response_in_error here
			// TODO above statement is BS - it just requires a bit of work to make sure that this class gets access to method.
			if (is_array($endpoints)){
				foreach ($endpoints as $message_endpoint) {
					$service_name = $message_endpoint[FarReaches_Wireservice::EXTERNAL_SERVICE_DEFINITION];
					$definition = $this->farReaches_Wireservice->get_external_service_definition_by_name($service_name);
					if ( !empty($definition)) {
						// allow for plugin not knowing about every definition.
						$service_alias = strtolower($definition['service_name']);
						$service_icon_url = $this->farReaches_Ui_Handling->get_extserv_img_uri($service_alias, '16');
						$far_icons[] = array('public_uri' => $message_endpoint['publicUri'], 'service_icon_url' => $service_icon_url,
						    'public_uri_anchor_text' => $message_endpoint['publicUriAnchorText']);

						array_push($this->output_Connected_Service_Aliases, $service_alias);
					}
				}
			}

			$category_Obj['icon_data'] = $far_icons;
		}
		array_push($this->output_Cat_Data, $category_Obj);
	}

	//Eliminating any output produced by super class
	function end_el( &$output, $page, $depth = 0, $args = array() ) {}
	function start_lvl( &$output, $depth = 0, $args = array() ) {}
	function end_lvl( &$output, $depth = 0, $args = array() ) {}
}
