<?php
/**
 * Handles:
 * <ol>
 * <li>registers the plugin
 * <li>all organization configuration information.
 * <li>user account changes ( for example, adding/removing wp user )
 * <ol>
 *
 * Provides an interface to allow the admin review and confirm to allow the plugin.
 *
 * TODO: MUST also be responsible for periodically checking with the wireserver
 * to help make sure the plugin is in sync with the wireserver. This is good to handle
 * wordpress db backup and restore resulting in the plugin losing track of which posts
 * were sent.
 *
 */
class FarReaches_Settings_Organization extends FarReaches_Ui_Using {

    private $farReaches_Admin;

    private $farReaches_Notifications_Manager;

    private $farReaches_Post_Handling;

    private $farReaches_Wireservice;

    private $organization_types;
    private $organization_sizes;
    /**
     * key is country code
     * @var unknown
     */
    private $country_codes;
    /**
     * key is displayText ( for sorting )
     * @var unknown
     */
    private $countries;

    // stored in user_meta
    private $personal_data_suffixes;

    // the roles that can create and publish content. In order of authority.
    // TODO: handle multisite admins at some point
    // assume that other roles are not interesting (i.e Contributor and Subscriber )
    // roleType is com.amplafi.core.RoleType
    // TODO - for multi-site blogs what is the role string for a wp super-admin?
    private $wp_role_to_farreaches_roles = array(
            array('wp_role' => 'administrator', 'roleType' => 'adm', 'rank' => 0),
            array('wp_role' => 'editor', 'roleType' => 'edt', 'rank' => 1),
            array('wp_role' => 'author', 'roleType' => 'str', 'rank' => 2));


    // step 1 parameters
    const TECHNICAL_CONTACT_USER_ID = 'primaryTechnicalContactUserId';
    const SOCIAL_MARKETING_CONTACT_USER_ID = 'primarySocialMarketingContactUserId';
    const MAIN_PHONE = 'mainPhone';
    const SITE_COUNTRY = 'siteCountry';
    const ORGANIZATION_TYPE = 'organizationType';
    const DEFAULT_ORGANIZATION_TYPE = 'business';
    const ORGANIZATION_SIZE = 'organizationPeopleCount';
    const TERMS_OF_SERVICE_USER_ID = 'termsOfServiceUserId';

    const FARREACHES_SITE_TITLE = 'site_title';

    const PERSONAL = 'personal';
    // these are under the PERSONAL sub-section in the user-meta
    const FIRST_NAME = 'firstName';
    const LAST_NAME = 'lastName';
    const JOB_TITLE = 'jobTitle';
    const DIRECT_PHONE = 'directPhone';
    const EMAIL = 'email';
    const DISPLAY_NAME =  'displayName';
    // end personal

    const ORGANIZATION_FORM_NAME = "organization_form";
    const ON_COMPLETE_SIGNUP_STEP_1 = 'farreaches://FarReaches_Settings_Organization/complete_signup_step_1';
    const ON_UPDATE_ORGANIZATION_SETTINGS = 'farreaches://FarReaches_Settings_Organization/update_organization_settings';

    const FARREACHES_REGISTER_USERS_HOOK = 'farreaches_register_users_hook';
    const FARREACHES_REGISTER_PLUGIN_HOOK = 'farreaches_register_plugin_hook';
    const FARREACHES_REFRESH_API_HOOK = 'farreaches_refresh_api_hook';

    function __construct(FarReaches_Util $farReaches_Util,
                         FarReaches_Communication $farReaches_Communication,
                         FarReaches_Ui_Handling $farReaches_Ui_Handling,
                         FarReaches_Admin $farReaches_Admin,
                         FarReaches_Post_Handling $farReaches_Post_Handling,
                         FarReaches_Notifications_Manager $farReaches_Notifications_Manager,
    					 FarReaches_Wireservice $farReaches_Wireservice
    ) {
        parent::__construct($farReaches_Util, $farReaches_Communication, $farReaches_Ui_Handling);

        $this->personal_data_suffixes = array(self::EMAIL, self::FIRST_NAME, 'lastName', self::JOB_TITLE, 'phone', self::EMAIL);

        $this->farReaches_Wireservice = $farReaches_Wireservice;
        $this->farReaches_Admin = $farReaches_Admin;
        $this->farReaches_Post_Handling = $farReaches_Post_Handling;
        $this->farReaches_Notifications_Manager = $farReaches_Notifications_Manager;
        $this->organization_types = $this->get_config_file_contents('organization-types');
        $this->organization_sizes = $this->get_config_file_contents('organization-people-size');
        $this->country_codes = $this->get_config_file_contents('country-codes');
        if ( current_user_can(FarReachesFoundation_Permissions::EDIT_FARREACHES_SOCIAL_MEDIA_CATEGORIES_CAP)) {
            FarReaches_EventBus_Facade::subscribeMe($this,
                array(
                    self::ON_COMPLETE_SIGNUP_STEP_1 => 'on_complete_signup_step_1',
                    self::ON_UPDATE_ORGANIZATION_SETTINGS => 'on_update_organization_settings',
                    // manual request of new api key
                    "farreaches://request_new_api_key" => 'onevent_request_new_api_key'
                ), true);
        }
        FarReaches_EventBus_Facade::subscribeMe($this,
            array(
                FarReaches_Plugin_State::plugin_state_event_topic(FarReaches_Plugin_State::ACTIVATED) => 'on_plugin_state_activated'
            )
        );

        // Users without api key who can see the user page must still be able to see the FarReach.es configuration (so they can trigger getting api keys)
        $this->add_filter("manage_users_columns", "set_edit_user_columns");
        $this->add_action('manage_users_custom_column', 'custom_user_columns');

        // NOTE: no reoccurance (no auto scheduling)
        $this->add_cron_action(self::FARREACHES_REGISTER_PLUGIN_HOOK, 'oncron_register_plugin');
        // TODO: should be in communications
        $this->add_cron_action(self::FARREACHES_REFRESH_API_HOOK, 'oncron_refresh_api_key');
        $this->register_api_response_handler(FarReaches_Api_Call::API_REGISTER_PLUGIN, 'onevent_RegisterPlugin_done', 'onevent_RegisterPlugin_failed');
        // Notify about user change
        $plugin_state = $this->get_plugin_state();
        if ($plugin_state == FarReaches_Plugin_State::SYNCED || $plugin_state == FarReaches_Plugin_State::KEYS_RECEIVED) {
            $this->add_cron_action(self::FARREACHES_REGISTER_USERS_HOOK, 'oncron_register_users','daily');
            $this->add_action('profile_update', 'notify_farreaches_user_change_if_needed');
            $this->add_action('user_register', 'handle_new_user');
        }
    }

    private function get_users_data($user_ids_to_refresh = null) {
        // $complete_list - if true then the server must remove any user that is not present in the sent list.
        $complete_list = !isset($user_ids_to_refresh);
        if (!$complete_list) {
            $db_constraints['include'] = is_array($user_ids_to_refresh) ? $user_ids_to_refresh : array($this->get_user_id($user_ids_to_refresh));
        } else {
            //See http://wpsmith.net/2012/wp/an-introduction-to-wp_user_query-class/
            //for in depth docs on the WP_User_Query usage.
            $db_constraints['who'] = 'authors';
        }
        $users = get_users($db_constraints);
        usort($users, array(__CLASS__,'sort_users_by_role'));
        foreach ($users as $user) {
            $wp_user = new WP_User($user->ID);
            // what we know about a user because it was entered into the plugin
            $personal_data = $this->get_user_meta($user, self::PERSONAL);
            // personal_data takes priority over stuff from wordpress
            $result[] = $personal_data + array(
                    FarReaches_Util::ID_KEY => $user->ID,
                    'userName' => $user->user_login,
                    self::FIRST_NAME => $user->first_name,
                    self::LAST_NAME => $user->last_name,
                    self::DISPLAY_NAME => $user->display_name,
                    self::EMAIL => $user->user_email,
                    'roles' => implode(',', $wp_user->roles),
                    self::JOB_TITLE => '',
                    self::DIRECT_PHONE => ''
            );
        }
        return $result;
    }

    private function get_wp_roles() {
        if (!isset($this->wp_roles)) {
            $this->wp_roles = array();
            foreach ($this->wp_role_to_farreaches_roles as $wp_role_to_farreaches_role) {
                $this->wp_roles[] = $wp_role_to_farreaches_role['wp_role'];
            }
        }
        return $this->wp_roles;
    }

    /**
     * pick the highest role a user has
     * wordpress does allow for a (db-table-prefix)user_roles table to exist and for the user to have multiple roles.
     * @returns null if $user is not set
     */
    private function get_highest_wp_role($user_or_id) {
        if (isset($user_or_id)) {
            if ($user_or_id instanceof WP_User) {
                //Not an id, consider input to be a WP_User already.
            	$wp_user = $user_or_id;
            } else {
                //Only retrieve user from database if we're passed an id, otherwise we're discarding input data
                //which is not always necessary (e.g. when analything old user data object).
                $wp_user = new WP_User($this->get_user_id($user_or_id));
            }
            $user_roles = $wp_user->roles;
            foreach ($this->wp_role_to_farreaches_roles as $wp_role_to_farreaches_role) {
                if (in_array($wp_role_to_farreaches_role['wp_role'], $user_roles)) {
                    return $wp_role_to_farreaches_role;
                }
            }
        }
        return null;
    }

    // -------------- keeping wireserver up to date about users ---------------
    /**
     * This is a wordpress hook so argument order is constrained by WordPress
     * A user has been changed or registering users.
     *
     * we need to look for user profile changes. (name change) but name changes are more problematic when user is registered
     * for multiple sites.
     *
     * If the server is not available, we don't worry about it because the cron job will do the general refresh
     * @todo make sure we are not getting users marked as spammers or deactivated users.
     * @param int|array|null $user_ids_to_refresh - can be an array of user ids. if null then we are syncing the entire list of users.
     * @param array|null $old_user_data - Useless because the old role is not preserved.
     * @return array|\WP_Error
     */
    public function notify_farreaches_user_change_if_needed($user_ids_to_refresh, $old_user_data = null) {
        //  because there is a job that periodically updates the server with user information, don't worry about a failure.
        return $this->register_wordpress_users_with_farreaches(null, $user_ids_to_refresh, false);
    }

    /**
     * Handles wordpress action 'user_register' (new user creation)
     */
    public function handle_new_user($new_users_id) {
        // a little protection from outside world to avoid a null causing complete user registration.
        if ( !empty($new_users_id)) {
            $this->register_wordpress_users_with_farreaches(null, $new_users_id, true);
        }
    }
    /**
     * This is scheduled in the -communications.php code
     * TODO : should really be in the -communications.php code
     * but we can't assume that the server knows about this user, so we have to do the update user flow
     * we should just refresh the keys not update users.
     * @param unknown $user_id
     */
    public function oncron_refresh_api_key($user_id) {
        $user_ids_to_refresh = $this->get_option(FarReaches_Communication::BAD_API_KEY_TOPIC);
        return $this->register_wordpress_users_with_farreaches($user_id, $user_ids_to_refresh, false);
    }
    /**
     * This is a manual request
     * This function removes the API key and then proceeds with the two phase process of getting the API key
     */
    function onevent_request_new_api_key(FarReaches_Event $event) {
        $user_ids_to_refresh = array($event->data);
        // remove the old api keys so they will be refreshed
        foreach ($user_ids_to_refresh as $user_id) {
            $this->farReaches_Communication->remove_user_farreaches_api_key($user_id);
        }
        // and also send the users to server just in case they need to be revoked
        return $this->register_wordpress_users_with_farreaches(null, $user_ids_to_refresh, false);
    }
    /**
     * The job runs periodicly to make sure that any user changes will make it to the wireserver.
     * Listens topic self::FARREACHES_REGISTER_USERS_HOOK
     */
    function oncron_register_users($current_user_id) {
        // TODO server has no way to update plugin when the plugin is deactivated/reactivated.
        // so we lose user data ( or the reactivated plugin forces user data to be lost)
        return $this->register_wordpress_users_with_farreaches($current_user_id, null, true);
    }

    /**
     * This function is used to register a user/broadcastProvider with the farreach.es server.
     * The key returned is SPECIFIC to a user.
     * @param $user_ids_to_refresh - can be an array of user ids. if null then we are syncing the entire list of users.
     * @param $current_user_id the user that is running the current
     * @param $skip_uninteresting_users true means only send user information for users that could interact with the server
     * false for to help the server invalidate users that no longer have the correct role.
     * @return array|\WP_Error
     */
    private function register_wordpress_users_with_farreaches($current_user_id, $user_ids_to_refresh, $skip_uninteresting_users) {
        $user_registration_data = $this->get_user_registration_data($user_ids_to_refresh, $skip_uninteresting_users);
        if (empty($user_registration_data['usersList'])) {
            // no changes
            return null;
        }
        return $this->initiate_secured_api_call(FarReaches_Api_Call::API_UPDATE_USERS, $user_registration_data, null, $current_user_id);
    }
    // -------------- (end) keeping wireserver up to date about users ---------------

    /**
     * @param $user_ids_to_refresh
     * @param $skip_uninteresting_users - if true or if empty($user_ids_to_refresh) (which signals complete list)
     * @return array the data to send to the server when registering new users or refreshing what the server knows
     */
    private function get_user_registration_data($user_ids_to_refresh = null, $skip_uninteresting_users = true) {
        $complete_list = !isset($user_ids_to_refresh);
        $only_interesting_users = $complete_list || $skip_uninteresting_users;
        if ($complete_list) {
            //If complete list requested send out only interesting users. Everybody else will be registeres in ad-hoc manner.
            $user_ids_to_refresh = array($this->get_user_id(), $this->getTechnicalUserExternalId(), $this->getSocialMarketingUserExternalId(), $this->getTermsOfServiceUserId());
            $user_ids_to_refresh = array_unique($user_ids_to_refresh);
        }
        $usersList = $this->get_users_data($user_ids_to_refresh);
        // determine which users have changed roles or have been added.
        $key_map = array(FarReaches_Settings_Organization::DISPLAY_NAME => 'displayName',
                FarReaches_Settings_Organization::FIRST_NAME => 'firstName',
                FarReaches_Settings_Organization::LAST_NAME => 'lastName',
                FarReaches_Settings_Organization::JOB_TITLE => 'jobTitle',
                FarReaches_Settings_Organization::DIRECT_PHONE => 'officePhone');
        $user_map = array();
        foreach ($usersList as $user) {
            $new_wp_role = $this->get_highest_wp_role($user);
            $user_api_key = $this->farReaches_Communication->get_user_farreaches_api_key($user);
            if( !$only_interesting_users ||(isset($new_wp_role) && $new_wp_role['roleType'] != null && FarReaches_String_Util::is_blank($user_api_key))) {
                // this user is not interesting and we are sending a complete_list or only interesting users
                // TODO: clear their key if present
                // we are not sending the complete list, the role hasn't changed and the user has an api_key so ... nothing to do.
                // must still be an interesting user
                // interesting role change including downgrading user to an uninteresting role (i.e. user)
                // OR an api key is not set yet
                // don't use FarReaches_Settings constants because these are api parameters.
                $user_farreaches_registration = array(
                        'email' => $user[FarReaches_Settings_Organization::EMAIL],
                        'externalId' => $user[FarReaches_Util::ID_KEY],
                        'roleType' => $new_wp_role['roleType']);
                // check to see if interesting user. If it was null then the user info is sent only to make sure any old entry is removed
                if ( $new_wp_role['roleType'] !== null ) {
                    foreach($key_map as $key => $api_data_key) {
                        if (isset($user[$key])) {
                            // only send data with values
                            $user_farreaches_registration[$api_data_key] = $user[$key];
                        }
                    }
                }
                $user_map[] = $user_farreaches_registration;
            }
        }
        $call_data = array(
            'usersList' => $user_map,
            'completeList' => $complete_list,
            'primaryTechnicalUserExternalId' => $this->getTechnicalUserExternalId(),
            'primarySocialMarketingUserExternalId' => $this->getSocialMarketingUserExternalId(),
            'termsOfServiceUserExternalId' => $this->getTermsOfServiceUserId()
        );

        return $call_data;
    }
    // -------------- plugin registration ---------------
    /**
     * The full registration call.
     */
    private function register_plugin_with_farreaches() {
        $current_user_id =  $this->get_user_id();

        $registration_data = $this->get_registration_data();
        $user_registration_data = $this->get_user_registration_data();
        $saved_for_callback = array_merge($registration_data, $user_registration_data);

        return $this->initiate_secured_api_call(FarReaches_Api_Call::API_REGISTER_PLUGIN, $saved_for_callback, null, $current_user_id);
    }

    public function onevent_RegisterPlugin_done(FarReaches_Event $farReaches_Event) {
        $this->set_plugin_state(FarReaches_Plugin_State::SYNCED);
    }

    /**
     * @listens wireservice://RegisterPlugin/failed
     */
    function onevent_RegisterPlugin_failed(FarReaches_Event $farReaches_Event) {
        $user = $farReaches_Event->user;
        $this->farReaches_Notifications_Manager->notify_user('plugin_activation_delayed', $user);
        $job_definition = $this->create_job_definition($farReaches_Event->user, self::FARREACHES_REGISTER_PLUGIN_HOOK);
        $this->schedule_single_event(30, $job_definition);
    }
    /**
     * registration only runs as a job if the first attempt failed.
     */
    function oncron_register_plugin() {
        $plugin_state = $this->get_plugin_state();
        if ( $plugin_state == FarReaches_Plugin_State::CONFIRMED) {
            // doesn't look like the plugin has been successful getting to the server
            $this->register_plugin_with_farreaches();
        }
    }
    // -------------- (end) plugin registration ---------------

    private static function sort_users_by_role(WP_User $left, WP_User $right) {
        $left_can_manage = user_can($left, FarReachesFoundation_Permissions::MANAGE_FARREACHES_PLUGIN_CAP);
        $right_can_manage = user_can($right, FarReachesFoundation_Permissions::MANAGE_FARREACHES_PLUGIN_CAP);
        if ( $left_can_manage != $right_can_manage) {
            // put the user who can manage ahead of the user who cannot.
            return $left_can_manage?-1:1;
        } else {
            $left_can_publish = user_can($left, FarReachesFoundation_Permissions::MANAGE_PUBLISHED_CONTENT_CAP);
            $right_can_publish = user_can($right, FarReachesFoundation_Permissions::MANAGE_PUBLISHED_CONTENT_CAP);
            if ( $left_can_publish != $right_can_publish) {
                // put the user who can manage ahead of the user who cannot.
                return $left_can_publish?-1:1;
            } else {
                // both have identical permissions
                return strcasecmp($left->user_login, $right->user_login);
            }
        }
    }

    private function get_registration_data() {
        $siteName = $this->get_site_title();
        $saved_for_callback = array(
                //Since farreaches.es server assumes that any input it gets is unescaped. We are unescaping the blogname to remove the encoding.
                //So if the blog name is "San Francisco's Best Tacos" wordpress stores the blogname as "San Francisco&#039;s Best Tacos"
                //The htmlspecialchars_decode call converts the encoded string to the original one i.e. "San Francisco's Best Tacos".
            'selfName' => html_entity_decode($siteName, ENT_QUOTES),
            //Send the blogs ISO 2 character language code ( http://www.loc.gov/standards/iso639-2/php/code_list.php )
            //Note: ISO 639-1 Codes have 2 characters while ISO 639-2 Codes have three.
            'defaultLanguage' => strtolower(substr(get_locale(), 0, 2)),
            'siteCountryCode' => $this->getSiteCountry(),
            'organizationPeopleCount' => $this->getOrganizationPeopleCountFarReachesCode(),
            'broadcastProviderType' => $this->getOrganizationTypeFarReachesCode(),
            'mainPhone' => $this->getMainPhone()
        );
        return $saved_for_callback;
    }

    private function getTechnicalUserExternalId() {
        $technicalContactId = $this->get_option(self::TECHNICAL_CONTACT_USER_ID);
        if ( $technicalContactId == null ) {
            $technicalContactId = $this->get_option(self::SOCIAL_MARKETING_CONTACT_USER_ID);
        }
        if ( $technicalContactId == null ) {
            $technicalContactId = $this->get_user_id();
        }
        return $technicalContactId;
    }
    private function getSocialMarketingUserExternalId() {
        $socialMarketingContactId = $this->get_option(self::SOCIAL_MARKETING_CONTACT_USER_ID);
        if ( $socialMarketingContactId == null ) {
            $socialMarketingContactId = $this->get_option(self::TECHNICAL_CONTACT_USER_ID);
        }
        if ( $socialMarketingContactId == null ) {
            $socialMarketingContactId = $this->get_user_id();
        }
        return $socialMarketingContactId;
    }

    private function get_account_settings_data() {
        $users = $this->get_users_data();
        $siteTitle = $this->get_site_title();
        $organization_type = $this->get_option(self::ORGANIZATION_TYPE);
        $organization_people_count = $this->getOrganizationPeopleCount();
        if ( $organization_people_count === null ) {
            // TODO : look at entire db count of users
            $user_count = count($users);
            foreach($this->organization_sizes as $organization_size_key => $organization_size) {
                if ( $organization_size["min"] <= $user_count && $user_count <= $organization_size["max"]) {
                    $organization_people_count = $organization_size_key;
                    break;
                }
            }
        }
        $site_urls = $this->farReaches_Communication->get_blog_urls();
        $data = array(
            'users' => $users,
            self::FARREACHES_SITE_TITLE => $siteTitle,
            'siteUrl' => $this->farReaches_Communication->get_blog_urls(),
            'humanUrl' => $this->farReaches_Communication->get_human_uri(),
            self::ORGANIZATION_TYPE => $organization_type,
            self::ORGANIZATION_SIZE => $organization_people_count,
            self::SITE_COUNTRY => $this->getSiteCountry(),
            self::TERMS_OF_SERVICE_USER_ID  => $this->getTermsOfServiceUserId(),
            self::TECHNICAL_CONTACT_USER_ID => $this->getTechnicalUserExternalId(),
            self::SOCIAL_MARKETING_CONTACT_USER_ID => $this->getSocialMarketingUserExternalId(),
            self::MAIN_PHONE => $this->getMainPhone(),
        );
        return $data;
    }
    /**
     * Shows either the configure org settings or the show activation page_1 depending on state
     */
    public function show_page_organization_settings() {
        $plugin_state = $this->get_plugin_state();
        switch($plugin_state) {
        case FarReaches_Plugin_State::SYNCED:
            $this->_show_page_organization_settings();
            break;
         default:
             $this->show_page_activate_complete_signup_step_1();
         }
    }

    // HACK fix fn name
    private function _show_page_organization_settings() {
        if ( !current_user_can(FarReachesFoundation_Permissions::READ_FARREACHES_ORGANIZATION_SETTINGS_CAP)) {
            $this->farReaches_Ui_Handling->output_farreaches_html("You do not have permission to view this page.");
        } else {
            ob_start();
            $data = $this->get_account_settings_data();
            $current_user_can_change = current_user_can(FarReachesFoundation_Permissions::EDIT_FARREACHES_ORGANIZATION_SETTINGS_CAP);
            $data['current_user_can_change'] = $current_user_can_change;
?>
<div class="farreaches-organization-settings">
    <form id="<?php echo self::ORGANIZATION_FORM_NAME; ?>" method="post">
            <h2><?php echo FarReaches_Admin::ORGANIZATION_SETTINGS_PAGE_NAME . ": " . $data[self::FARREACHES_SITE_TITLE] ; ?></h2>
                <?php
                    $this->output_organization_settings($data);
                    $this->output_user_information($data);
                    printf('<p class="submit"><button id="confirm_activation" class="button button-primary"
                        data-publish-event="!form#%s"
                        data-publish-topic="%s"
                        data-publish-label="Saving..."
                        data-publish-label-success="%s"
                        data-publish-failure="notification_on_failure">Save Changes</button></p>',
                        self::ORGANIZATION_FORM_NAME,
                        self::ON_UPDATE_ORGANIZATION_SETTINGS,
                        "Done!"
                        );
                ?>
    </form>
</div>
<?php
            $inserted = ob_get_contents();
            ob_end_clean();
            $this->farReaches_Ui_Handling->output_farreaches_html($inserted);
        }
    }
    /**
     *
     */
    private function show_page_activate_complete_signup_step_1() {
        wp_enqueue_script(FarReaches_Ui_Handling::FARREACHES_ACTIVATION_JS);
        if (is_multisite()) {
            $this->farReaches_Admin->generate_jsrender_template(array('key' => 'activate_confirm_multisite'), true, array());
        } else if ( !current_user_can(FarReachesFoundation_Permissions::READ_FARREACHES_ORGANIZATION_SETTINGS_CAP)) {
            $this->farReaches_Ui_Handling->output_farreaches_html("You do not have permission to view this page.");
        } else {
            $data = $this->get_account_settings_data();
            $current_user_can_change = current_user_can(FarReachesFoundation_Permissions::EDIT_FARREACHES_ORGANIZATION_SETTINGS_CAP);
            $data['current_user_can_change'] = $current_user_can_change;
            ob_start();
?>
<div class="farreaches-organization-settings farreaches-settings">
    <form id="<?php echo self::ORGANIZATION_FORM_NAME; ?>" method="post">
        <div id="confirmation">
            <h2>Step 1: Register <?php echo $data['humanUrl'] ; ?></h2>
            <ol>
                <li>Confirm your business or organization’s details
                <?php
                    $this->output_organization_settings($data);
                ?>
                </li>
                <li>Select the primary social marketing and technical contacts in your organization.
                <?php /* showing as a table because in future we will want to let multiple people be contacts. (so we will need a table ) */
                    $this->output_user_information($data);
                ?>
                </li>
                <li>
                <?php
                    $tosPageLink = $this->farReaches_Admin->get_farreaches_html_a_link(FarReaches_Admin::TERMS_OF_SERVICE_MENU_SLUG);
                    printf('<label for="%s"><input name="%s" id="%s" type="checkbox"   value="%s" > I agree to the %s</label>',
	                               self::TERMS_OF_SERVICE_USER_ID, self::TERMS_OF_SERVICE_USER_ID, self::TERMS_OF_SERVICE_USER_ID, $this->get_user_id(), $tosPageLink);
                ?>
                </li>
            </ol>
            <?php
                if ( $current_user_can_change) {
                    printf('<button id="confirm_activation" class="button button-primary"
                        data-publish-event="!form#%s"
                        data-publish-topic="%s"
                        data-publish-label="Registering %s..."
                        data-publish-label-success="%s"
                        data-publish-failure="notification_on_failure">Register %s</button>',
                        self::ORGANIZATION_FORM_NAME,
                        self::ON_COMPLETE_SIGNUP_STEP_1,
                        $data['humanUrl'],
                        "Done!",
                        $data['humanUrl']);
                }
            ?>
        </div>
    </form>
</div>
<?php
            $inserted = ob_get_contents();
            ob_end_clean();
            $this->farReaches_Ui_Handling->output_farreaches_html($inserted);
            $landing_url = $this->farReaches_Admin->get_farreaches_admin_page_url(FarReaches_Admin::SOCIAL_MEDIA_ACCOUNT_SETTINGS_MENU_SLUG);
            $this->add_js_config('activation_landing_url', $landing_url);
            $this->add_js_config('plugin_state', $this->get_plugin_state());
            wp_enqueue_script(FarReaches_Ui_Handling::FARREACHES_ACTIVATION_JS);
        }
    }

    // HACK : $data is very ugly : but makes it easier if we go back to jsrender templates.
    private function output_organization_settings($data) {
?>
        <table class="form-table">
            <tr>
                <th scope="row">Business or Organization Name</th>
                <td>
                    <?php
                    printf('<input name="%s" value="%s" type="text" size="60">',
                            self::FARREACHES_SITE_TITLE,
                            $data[self::FARREACHES_SITE_TITLE]);
                    ?>
                </td>
            </tr>
            <?php
                $this->output_table_row("Type of Organization", self::ORGANIZATION_TYPE, $data[self::ORGANIZATION_TYPE], $this->organization_types);
                $this->output_table_row("Organization Size", self::ORGANIZATION_SIZE, $data[self::ORGANIZATION_SIZE], $this->organization_sizes);
            ?>
            <tr>
                <th scope="row">Main Office Phone</th>
                <td>
                <?php
                    printf('<input name="%s" value="%s" type="tel" size="16">',
                        self::MAIN_PHONE, $data[self::MAIN_PHONE]);
                ?>
                </td>
            </tr>
            <?php
            $this->output_country($data, self::SITE_COUNTRY);
            ?>
        </table>
        <?php
    }

    // HACK : $data is very ugly : but makes it easier if we go back to jsrender templates.
    private function output_country($data, $selection) {
        $label = "Country";
        $form_field_name = $selection;
        $selection = $data[$selection];
        $selection_array = $this->get_countries();
?>
        <tr>
            <th scope="row"><?php echo $label ; ?></th>
            <td>
                <select name="<?php echo $form_field_name ; ?>">
<?php
                    if(empty($selection)) {
                        echo "<option disabled selected>Choose...</option>";
                    }
                    foreach($selection_array as $value) {
                        $key = $value['countryCode'];
                        printf("<option value='%s' %s value='%s'>%s</option>", $key, ( $selection == $key)?'selected':'', $key, $value['displayText']);
                    }
                    ?>
                </select>
            </td>
        </tr>
<?php
    }

    // TODO: ideally, we use wordpress's user list display (but it seems very tied to the users.php (including that url for actions )
    // HACK : $data is very ugly : but makes it easier if we go back to jsrender templates.
    private function output_user_information($data) {
        $current_user_can_change = $data['current_user_can_change'];
?>
        <table class="wp-list-table widefat fixed farreaches-user-list-table">
           <thead>
            <tr>
                <th scope="col" class="narrow-column">Primary Marketing Contact</th>
                <th scope="col" class="narrow-column">Primary Technical Contact</th>
                <th scope="col" class="narrow-column">Username</th>
                <th scope="col" class="narrow-column">Name</th>
                <th scope="col">Contact information</th>
            </tr>
           </thead>
           <tbody>
            <?php foreach($data['users'] as $user) {
                $user_id = $this->get_user_id($user);
                $user_can_manage_publish_content = user_can($user_id, FarReachesFoundation_Permissions::MANAGE_PUBLISHED_CONTENT_CAP);
                $user_can_manage_plugin =  user_can($user_id, FarReachesFoundation_Permissions::MANAGE_FARREACHES_PLUGIN_CAP);
                if ( $user_can_manage_publish_content == false && $user_can_manage_plugin == false ) {
                    // if the user cannot do anything then don't show them
                    continue;
                }
            ?>
            <tr data-userId="<?php echo $user_id ; ?>">
                <td class="check-column">
                <?php
                    if ( $user_can_manage_publish_content) {
                        if ( $current_user_can_change) {
                            printf('<input name="%s" value="%s" %s type="radio">',
                                    self::SOCIAL_MARKETING_CONTACT_USER_ID, $user_id, $user_id == $data[self::SOCIAL_MARKETING_CONTACT_USER_ID]? "checked": "");
                        } else if ( $user_id == $data[self::SOCIAL_MARKETING_CONTACT_USER_ID] ) {
                            // TODO : display checkmark
                        }
                    }
                    ?>
                </td>
                <td class="check-column">
                <?php
                    if ( $user_can_manage_plugin) {
                        if ( $current_user_can_change) {
                            printf('<input name="%s" value="%s" %s type="radio">',
                                self::TECHNICAL_CONTACT_USER_ID, $user_id, $user_id == $data[self::TECHNICAL_CONTACT_USER_ID]? "checked": "");
                        } else if ( $user_id == $data[self::TECHNICAL_CONTACT_USER_ID] ) {
                            // TODO : display checkmark
                        }
                    }
                ?>
                </td>
                <td><?php echo $user['userName'] ; ?></td>
                <td>
                <?php
                    printf('<input name="%s_%s" type="text"  value="%s" placeholder="First Name" size="32">',
                        $user_id, self::FIRST_NAME, $user[self::FIRST_NAME]);
                    printf('<input name="%s_%s"  type="text"  value="%s" placeholder="Last Name" size="32">',
                        $user_id, self::LAST_NAME, $user[self::LAST_NAME]);
                ?>
                </td>
                <td>
                <?php
                    printf('<input name="%s_%s" type="email" value="%s" size="32">',
                        $user_id, self::EMAIL, $user[self::EMAIL]);
                    printf('<input name="%s_%s" type="text"   value="%s" placeholder="Job Title" size="32">',
                        $user_id, self::JOB_TITLE, $user[self::JOB_TITLE]);
                    printf('<input name="%s_%s" type="text"   value="%s" placeholder="Direct Phone" size="16">',
                        $user_id, self::DIRECT_PHONE, $user[self::DIRECT_PHONE]);
                ?>
                </td>
            </tr>
            <?php } ?>
        </tbody></table>
<?php
    }
    private function output_table_row($label, $form_field_name, $selection, $selection_array) {
?>
        <tr>
            <th scope="row"><?php echo $label ; ?></th>
            <td class="table-cell-border-less">
                <select name="<?php echo $form_field_name ; ?>">
<?php
                    if(empty($selection)) {
                         echo "<option disabled selected>Choose...</option>";
                    }
                    foreach($selection_array as $key => $value) {
                        printf("<option value='%s' %s value='%s'>%s</option>", $key, ( $selection == $key)?'selected':'', $key, $value['displayText']);
                    }
                    ?>
                </select>
            </td>
        </tr>
<?php
    }

    /**
     * (also can trigger retrieval of envelope statuses if known)
     * @param unknown $columns
     * @return multitype:
     */
    function set_edit_user_columns($columns) {
        return array_merge($columns, array('farreaches_user' => $this->get_plugin_display_name()));
    }

    // for some reason adding data to a column for a user needs to be returned not echoed. This is different than for posts and categories.
    // look at class-wp-users-list-table.php line 310 in wordpress code.
    // TODO: show the primary contact information.
    function custom_user_columns($result, $column_name, $userId) {
        $result .= "<div class='farreaches smallstatus'>";
        switch ($column_name) {
            case 'farreaches_user' :
                // NOTE: do not reveal the api key, temporary callback or permanent callback keys ( allows a cross-site script scraping attack to get api key )
                $user_api_key = $this->farReaches_Communication->get_user_farreaches_api_key($userId);
                $refresh_api_html = sprintf("<button type ='button' class='button-redirect-wp-tag refreshAuth' data-publish-topic='farreaches://request_new_api_key' data-publish-event='%s'><i class='icon-refresh'></i></button>",
                    $userId
                );
                if (!empty($user_api_key)) {
                    $result .= "<img src='" . $this->farReaches_Ui_Handling->get_status_img_uri("pass", "24") . "' width='24' height='24'/>User registered " . $refresh_api_html;
                } else {
                    $meta_key = $this->farReaches_Communication->get_callback_meta_key_base(FarReaches_Api_Call::API_KEY_TEMPORARY);
                    $temp_api_cb = $this->get_user_meta($userId, $meta_key);
                    if (!empty($temp_api_cb)) {
                        $result .= "User registration starting " . $refresh_api_html;
                    } else {
                        $meta_key = $this->farReaches_Communication->get_callback_meta_key_base(FarReaches_Api_Call::API_KEY_PERMANENT);
                        $perm_api_cb = $this->get_user_meta($userId, $meta_key);

                        if (!empty($perm_api_cb)) {
                            $result .= "Completing user registration " . $refresh_api_html;
                        } else if ($this->get_highest_wp_role($userId) != null) {
                            $result .= "Not yet registered " . $refresh_api_html;
                        } else {
                            $result .= "";
                        }
                    }
                }
                $result .= "</div>";
        }
        return $result;
    }

    // HACK : need better code separation ( constants )
    function on_complete_signup_step_1(FarReaches_Event $farReaches_Event) {
        if ( current_user_can(FarReachesFoundation_Permissions::MANAGE_FARREACHES_PLUGIN_CAP)) {
            FarReaches_Validate::false(is_multisite(), 'Trying to activate on a multi-site installation. Multi-site wordpress mode is not supported at the moment.');
            $termsOfServiceUserId = FarReaches_Params::get_or_fail($farReaches_Event->data, self::TERMS_OF_SERVICE_USER_ID, "Please accept the Terms of Service");
            $this->update_option(self::TERMS_OF_SERVICE_USER_ID, null, $termsOfServiceUserId);
            $this->update_organization_settings($farReaches_Event);
        	$this->set_plugin_state(FarReaches_Plugin_State::CONFIRMED);
        	$this->farReaches_Notifications_Manager->notify_user('plugin_activating');
        	$this->register_plugin_with_farreaches();
        } else {
            FarReaches_Validate::true(false, "Current user (id=". $this->get_user_id() . ") does not have ".
             FarReachesFoundation_Permissions::MANAGE_FARREACHES_PLUGIN_CAP . " permission so they cannot activate");
        }
    }
    /**
     * Called directly when updating the organization settings after signup or as part of the first signup screen.
     * @param FarReaches_Event $farReaches_Event
     */
    public function on_update_organization_settings(FarReaches_Event $farReaches_Event) {
        if ( current_user_can(FarReachesFoundation_Permissions::EDIT_FARREACHES_ORGANIZATION_SETTINGS_CAP)) {
            $this->update_organization_settings($farReaches_Event);
            $saved_for_callback = $this->get_registration_data();
            $saved_for_callback = array_merge($saved_for_callback, $this->get_user_registration_data());
            $current_user_id =  $this->get_user_id();
            return $this->initiate_secured_api_call(FarReaches_Api_Call::API_REGISTER_PLUGIN, $saved_for_callback, null, $current_user_id);
        } else {
            FarReaches_Validate::true(false, "Current user (id=". $this->get_user_id() . ") does not have ".
             FarReachesFoundation_Permissions::EDIT_FARREACHES_ORGANIZATION_SETTINGS_CAP . " permission so they cannot update the organization settings");
        }
    }

    private function update_organization_settings(FarReaches_Event $farReaches_Event) {
        $form_values = $farReaches_Event->data;
        $current_user_id =  $this->get_user_id();
        $this->set_site_title($form_values[self::FARREACHES_SITE_TITLE]);
        $siteAccountTypeStr = FarReaches_Params::get_or_fail($form_values, self::ORGANIZATION_TYPE, "Please select your organization type");
        $this->update_option(self::ORGANIZATION_TYPE, null, $siteAccountTypeStr);

        $organization_size = FarReaches_Params::def($form_values, self::ORGANIZATION_SIZE, null);
        if ( !empty($organization_size)) {
            $this->update_option(self::ORGANIZATION_SIZE, null, $organization_size);
        }

        $main_phone = FarReaches_Params::def($form_values, self::MAIN_PHONE);
        if ( empty($main_phone)) {
            $main_phone = null;
        }
        $this->update_option(self::MAIN_PHONE, null, $main_phone);

        // TODO : what happens if one of these users is removed - we should attach to the user but we still want to save the info independently of the user object
        $socialMarketingContactId = FarReaches_Params::abs_int($form_values, self::SOCIAL_MARKETING_CONTACT_USER_ID, $current_user_id);
        $this->update_option(self::SOCIAL_MARKETING_CONTACT_USER_ID, null, $socialMarketingContactId);
        $technicalContactId= FarReaches_Params::abs_int($form_values, self::TECHNICAL_CONTACT_USER_ID,$current_user_id);
        $this->update_option(self::TECHNICAL_CONTACT_USER_ID, null, $technicalContactId);

        $siteCountry = FarReaches_Params::string($form_values, self::SITE_COUNTRY);
        $this->update_option(self::SITE_COUNTRY, null, $siteCountry);
        $users = $this->get_users_data();
        foreach( $users as $user) {
            $user_id = $this->get_user_id($user);
            foreach( $this->personal_data_suffixes as $suffix) {
                $key = $user_id . '_' .$suffix;
                $value = FarReaches_Params::def($farReaches_Event->data, $key);
                $this->add_user_meta($user_id, self::PERSONAL, $suffix, $value);
            }
        }
    }

    /**
     * Triggered when the plugin is activated. Allows us to get any known information from the server.
     * @param FarReaches_Event $farReaches_Event
     */
    public function on_plugin_state_activated(FarReaches_Event $farReaches_Event) {
        // TODO: do preregistration call as a wp_cron
        // ideally this will fill in the information from a previous registration.
        // TODO: problem is that we want to go right to the registration screen even if the server is down. (so we can complete the registration)
        $this->initiate_secured_api_call(FarReaches_Api_Call::API_KEY_PREREGISTER);
    }

    public function getSiteCountry() {
        $siteCountry = $this->get_option(self::SITE_COUNTRY);
        if ( empty($siteCountry)) {
            // try to determine a good default based on the domain url.
            $blog_urls = $this->farReaches_Communication->get_blog_urls();
            foreach ($blog_urls as $url) {
                $host = $url['host'];
                $tldIndex = strrpos($host, '.');
                if ( is_numeric($tldIndex) ) {
                    $tld = substr($host, $tldIndex+1);
                    if ( FarReaches_Params::key_exists($tld, $this->country_codes) ) {
                        return $tld;
                    }
                }
            }
            return null;
        } else {
            return $siteCountry;
        }
    }

    private function get_countries() {
        if ( $this->countries === null) {
            $this->countries = array();
            foreach($this->country_codes as $value) {
                if ( FarReaches_Params::def($value, 'notCountry', false) === false) {
                    $this->countries[] = $value;
                }
            }
        }

        usort($this->countries, array(__CLASS__, "_countries_sort"));

        return $this->countries;
    }
    static function _countries_sort($a, $b) {
        if ($a == $b) {
            return 0;
        }
        return $a['displayText'] < $b['displayText'] ? -1 : 1;
    }

    private function getOrganizationTypeFarReachesCode() {
        $organizationType = $this->get_option(self::ORGANIZATION_TYPE);
        if ( $organizationType !== null ) {
            return $this->organization_types[$organizationType]['wireserverConstant'];
        } else {
            return null;
        }
    }

    private function getOrganizationPeopleCount() {
        $organizationPeopleCount = $this->get_option(self::ORGANIZATION_SIZE);
        return $organizationPeopleCount;
    }

    private function getOrganizationPeopleCountFarReachesCode() {
        $organizationPeopleCount = $this->getOrganizationPeopleCount();
        if ( $organizationPeopleCount !== null ) {
            return $this->organization_sizes[$organizationPeopleCount]['wireserverConstant'];
        } else {
            return null;
        }
    }
    private function getMainPhone() {
        $mainPhone = $this->get_option(self::MAIN_PHONE);
        if ( empty($mainPhone)) {
            return '';
        } else {
            return $mainPhone;
        }
    }
    public function getTermsOfServiceUserId() {
        $termsOfServiceUserId = $this->get_option(self::TERMS_OF_SERVICE_USER_ID);
        return $termsOfServiceUserId;
    }

    private function get_site_title() {
        $siteTitle = $this->get_option(self::FARREACHES_SITE_TITLE, null);
        if ( FarReaches_String_Util::is_blank($siteTitle)) {
            $siteTitle = get_bloginfo('name');
        }
        return $siteTitle;
    }

    public function set_site_title(&$siteTitle) {
        if ( FarReaches_String_Util::is_blank($siteTitle)) {
            $siteTitle = get_bloginfo('name');
        }
        $this->update_option(self::FARREACHES_SITE_TITLE, null, $siteTitle);
    }
}
