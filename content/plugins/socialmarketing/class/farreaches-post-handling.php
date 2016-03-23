<?php
/**
 * Class handles posts processing - changes and monitors posts statuses.
 *
 * Various Use Cases:
 *
 * Use Case I: Don't send old posts automatically.
 *
 * Post is:
 *     1. old ( > N days ago )
 *     2. post is in category that now goes to external service.
 *     3. post is edited.
 *     4. post has NOT be sent to an external service.
 *
 * Therefore,
 *     1. post should not be sent out automatically
 *     2. user should be able to explicitly allow post to be sent.
 *
 * Use Case II:
 *
 * Post is:
 *     1. not assigned to category
 *
 * Therefore,
 *     1. wp will assign to default category
 *     2. plugin needs to check if default category goes to wireservice
 *
 * See also / bring up comments on handle_post_publishing()
 */
class FarReaches_Post_Handling extends FarReaches_Base {
    // wordpress action triggered when the wordpress plugin was activated.
    const PLUGIN_INSTALLED_ACTION = 'farreaches_plugin_installed';

    // used to return configuration that rarely changes:
    //     categories
    //     external services
    //     relationships between the two.
    const FARREACHES_JS_CONSTANT_CONFIG = "farreaches_constant_config";
    const FORCE_CODE_INTO_SCRIPT = true;

    const FARREACHES_CSS = 'farreachesCss';
    const FARREACHES_JS = 'farreachesJs';
    const FARREACHES_EVENTBUS_JS = 'farreachesEventBusJs';
    const FARREACHES_NOTIFICATIONS_MANAGER = 'farreachesJsNM';
    const FARREACHES_JQUERY_SIMPLE_MODAL = 'farreachesJquerySimpleModal';
    // Unfortunately a wrapper __() may not work. wordpress has tools that look for __() method.
    // I haven't tested if using the same name as a wrapper method would work.
    // until that happens we need to use this domain explicitly.
    // See http://codex.wordpress.org/I18n_for_WordPress_Developers
    const FARREACHES_L10N_DOMAIN = "farreaches";

    const FARREACHES_STATUS = 'farreaches_status';
    // Local status: what plugin state is, Remote status: wireservice state
    // Example: plugin knows that post is published. (local state), but not yet sent to wireservice ( remote state ).
    // So the 2 states can differ as a post being processed.
    // local state just refers to the most recent attempt at communication.
    const LOCAL_TRANSMISSION_STATUS = 'local';
    // not published to any site.
    const POST_LOCAL_STATUS_TRANSMISSION_NOT = "not_transmitted";
    const POST_LOCAL_STATUS_TRANSMISSION_IN_PROGRESS = 'transmission_in_progress';
    const POST_LOCAL_STATUS_TRANSMISSION_DELAYED = 'transmission_delayed';
    const POST_LOCAL_STATUS_TRANSMISSION_SUCCESSFUL = 'transmission_successful';
    /**
     * Cases where the server returns Http 500
     * @var unknown
     */
    const POST_LOCAL_STATUS_TRANSMISSION_ERROR = 'transmission_error';
    /**
     * Cases where the server is down. Post should be retried after about 2 minutes.
     * otherwise same as POST_LOCAL_STATUS_TRANSMISSION_DELAYED
     * @var unknown
     */
    const POST_LOCAL_STATUS_SERVER_NOT_AVAILABLE_DELAYED = 'transmission_server_not_available_error';
    const POST_LOCAL_STATUS_TRANSMISSION_ABORTED = 'transmission_aborted';
    const POST_LOCAL_STATUS_TRANSMISSION_RESUMED = 'transmission_resumed';
    // Post local status transmission cancelled because post has already been published locally (in terms of wordpress blog, not wireserver)
    const POST_LOCAL_STATUS_TRANSMISSION_CANCELLED_AS_ALREADY_PUBLISHED_LOCALLY = 'transmission_cancelled_as_already_published';

    const POST_PUBLISHER = 'publisher_user';
    const REMOTE_STATUS = 'remote';

    /**
     * If a post has this set to true, then that means wireserver knows about this post.
     * Once set the value should never be unset.
     * Different that 'POST_AUTOMATIC_PUBLISHING' (which is the state of automatic publishing)
     * Different from 'POST_LOCAL_STATUS_TRANSMISSION_CANCELLED_AS_ALREADY_PUBLISHED_LOCALLY' (which is the current local status)
     * @var unknown_type
     */
    const POST_IS_MANAGED_KEY = 'managed';
    const POST_DELAY_ENABLED = true;
    const FARREACHES_DELAY_PUBLISH_ACTION_HOOK = 'farreaches_delay_publish';
    const POST_DELAY_TIME_IN_SECONDS = 60;
    const POST_DELAY_TIME_IN_SECONDS_IF_SERVER_PROBLEMS = 120;
    //POST_DELAY_MAX_COUNT is the maximum upper limit for delaying publishing of post
    const POST_DELAY_MAX_COUNT = 30;
    //Here by transmission we imply transmission from wordpress to FarReach.es

    // Post Publish Decisions
    const POST_LOCAL_PUBLISH_DECISION = 'publish_decision';
    const POST_LOCAL_PUBLISH_DECISION_PUBLISH_OK = 'publish_ok';

    const POST_LOCAL_PUBLISH_DECISION_INVALID = 'invalid_post';
    const POST_LOCAL_PUBLISH_DECISION_NO_VALID_CATEGORIES = 'no_valid_post_categories';
    const POST_LOCAL_PUBLISH_DECISION_NOT_MODIFIED = 'post_not_modified';
    const POST_LOCAL_PUBLISH_DECISION_NO_USER_DEFINED = 'no_user_defined';
    const POST_LOCAL_PUBLISH_DECISION_INVALID_STATUS = 'invalid_post_status';
    const POST_LOCAL_PUBLISH_DECISION_DELAY_COUNT_EXCEEDED = 'post_delay_count_exceeded';
    const POST_LOCAL_PUBLISH_DECISION_PASSWORD_PROTECTED = 'post_password_protected';
    const POST_LOCAL_PUBLISH_DECISION_FR_PUBLISH_CANCELLED_AS_ALREADY_PUBLISHED_LOCALLY = 'fr_publish_cancelled_as_already_published_locally';
    const POST_LOCAL_PUBLISH_DECISION_COMMUNICATION_ERROR = 'communication_error_occurred';

    //Schedule/Unschedule error messages
    const POST_LOCAL_PUBLISH_DECISION_FAILED_TO_SCHEDULE = 'post_failed_to_schedule';
    const POST_LOCAL_PUBLISH_DECISION_FAILED_TO_UNSCHEDULE = 'post_failed_to_unschedule';

    const POST_DELAY_EVENT_KEYS = 'event_keys';

    /**
     * Automatically publishing posts that have this saved in their messageThread. Can be changed with the automatically publish check box.
     * @var unknown_type
     */
    const POST_AUTOMATIC_PUBLISHING = 'post_automatic_publishing';

    const CACHE_KEY_POST_STATUS_PREFIX = 'post_status_';

    const POST_CONTENT_HASH = 'post_content_hash';

    // refresh post status times
    // 12 hours
    const LATER_TIME = 43200;
    const SOONER_TIME = 30;

    /**
     * @var FarReaches_Notifications_Manager
     */
    private $farReaches_NotificationsManager;

    /**
     * @var FarReaches_Wireservice
     */
    private $farReaches_Wireservice;
    /**
     * @var FarReaches_Ui_Handling
     */
    private $farReaches_Ui_Handling;

    function __construct(
        FarReaches_Util $farReaches_Util,
        FarReaches_Communication $farReaches_Communication,
        FarReaches_Notifications_Manager $farReaches_NotificationsManager,
        FarReaches_Wireservice $farReaches_Wireservice,
        FarReaches_Ui_Handling $farReaches_Ui_Handling
    ) {
        parent::__construct($farReaches_Util, $farReaches_Communication);
        $this->farReaches_NotificationsManager = $farReaches_NotificationsManager;
        $this->farReaches_Wireservice = $farReaches_Wireservice;
        $this->farReaches_Ui_Handling = $farReaches_Ui_Handling;

        $this->register_api_response_handler(FarReaches_Api_Call::POST_PUBLISH, 'on_post_publishing_done', 'on_post_publishing_failed');
        $this->register_api_response_handler(FarReaches_Api_Call::POST_REVOKE, 'on_post_unpublishing_done', 'on_post_unpublishing_failed');
        $this->register_api_response_handler(FarReaches_Api_Call::POST_STATUSES, 'on_EnvelopeStatusList_done', 'on_EnvelopeStatusList_failed');
        $this->register_api_response_handler(FarReaches_Api_Call::KNOWN_MESSAGE_EXTERNAL_IDS, 'on_KnownMessageExternalIds_done');

        $this->add_cron_action("do_EnvelopeStatusList", "oncron_refresh_posts_status", 'twicedaily');

        /**
         * for case when we want to force an early refresh without interfering with the regularly scheduled refresh.
         */
        $this->add_cron_action("do_EnvelopeStatusList_immediately", "oncron_refresh_posts_status");

        /**
         * Monitor post changes
         */
        #Actions that change post status...
        #http://codex.wordpress.org/Post_Status_Transitions

        #All possible post status in Jan 2012...

        #'new' - When there's no previous status
        #'publish' - A published post or page
        #'pending' - post in pending review
        #'draft' - a post in draft status
        #'auto-draft' - a newly created post, with no content
        #'future' - a post to publish in the future
        #'private' - not visible to users who are not logged in
        #'inherit' - a revision. see get_children.
        #'trash' - post is in trashbin. added with Version 2.9.

        $this->add_action('transition_post_status', 'handle_transition_post_status');
        FarReaches_EventBus_Facade::subscribeMe($this, array(
            'farreaches://post/abort' => 'onevent_post_publishing_abort',
            'farreaches://post/publish_now' => 'onevent_post_publishing_start',
        ),true);

        // we just care about the final state of the post. So 'publish_post' should be good enough.
        // TODO in future handle pages and custom taxonomies
        $this->add_action('publish_post', 'handle_user_post_publishing');
        // used when delaying the publishing of the post.
        $this->add_cron_action(self::FARREACHES_DELAY_PUBLISH_ACTION_HOOK, 'oncron_post_publishing');

        $this->add_action('save_post', 'handle_save_post');

        $possibleUnpublishStatuses = array('private', 'trash');

        //When post transitions from publish state into one of the $possibleUnpublishStatuses
        //we fire a delete request on FarReach.es.
        foreach ($possibleUnpublishStatuses as $unpublishStatus) {
            $this->add_action('publish_to_' . $unpublishStatus, 'handle_post_unpublishing');
        }
    }

    /**
     * Note: only categories with posts will be returned ( need to check about pages ) ( double check)
     * Note: this could mean that a category that was used in a published post and then not looks like the category was deleted.
     * get_all_category_ids()
     * Warning: This function returns empty array in case a post revision is passed, not the actual category list.
     */
    function get_categories_and_tags($post_ids) {
        // if requesting multiple then we want an array
        $fields = is_array($post_ids) ? 'all_with_object_id' : 'all';
        // uses wp_terms, wp_term_taxonomy, joined with wp_term_relationships
        $categories = wp_get_object_terms($post_ids,
            // regular categories and tags. (Don't think we want to pick up some custom taxonomy)
            array('category', 'post_tag'),
            array('orderby' => '', // no need to order
                // have to get everything in order to know which post has the relationship
                'fields' => 'all_with_object_id'
            )
        );
        // TODO : if a post has no categories then it MUST be in the default category ( this is wordpress behavior)
        // make sure it is reported as such.
        return $categories;
    }


    /**
     * Notable transitions:
     *   new->auto-draft when first creating an empty post ( triggered by wp_insert_post )
     *   new->inherit when creating a revision
     *   auto-draft->draft when the post has its first data. (triggered by first edit_post)
     *   draft->publish when published.
     *
     * called when do_action('transition_post_status', $new_status, $old_status, $post);
     */
    function handle_transition_post_status($new_status, $old_status, $post) {
        if ( !is_numeric($this->get_optional_id($post))) {
            // TODO:Confirm following statement:
            // a post may not yet have an id if another plugin uses wp_insert_post(array(...post data...) )
            return;
        }
        $post_is_managed = $this->get_post_is_managed($post);
        // make sure the automatic publishing option was even displayed.
        $enable_automatic_publishing = FarReaches_Post::boolean("enable_automatic_publishing", false);
        if ( $enable_automatic_publishing === true) {
            // the check box to present the choice was displayed.
            $post_eligible_for_automatic_publishing = FarReaches_Post::boolean(self::POST_AUTOMATIC_PUBLISHING, false);
            $this->set_post_eligible_for_automatic_handling($post, $post_eligible_for_automatic_publishing);
        } else {
            $post_eligible_for_automatic_publishing = $this->get_post_eligible_for_automatic_handling($post);
        }
        switch ($new_status) {
        case 'inherit': // new-> inherit : revision entry being created - so ignored
            return;
        case 'new': // the post object was just created - lets wait for a more interesting status.
            // because new can transition to inherit ( old post revision ) - we can't alter the post metadata
            return;
        case 'auto-draft': // updating the saved post. (could be interesting : i.e. stop auto publishing - but that is handled elsewhere)
        case 'draft':
            // note : it is possible to transition from publish -> draft
            // if publish happened previously we want to make sure to keep the original settings for post_is_managed and
            // automatic_handling.
            if ( $post_eligible_for_automatic_publishing === null ) {
                $this->set_post_eligible_for_automatic_handling($post, true);
            }
            if ( $post_is_managed === null) {
                $this->set_post_is_managed($post, false);
            }
            break;
        case 'trash':
            break;
        case 'pending':
        case 'private': // published privately or previously published and now private
        case 'future':
        case 'publish':
            $current_user_id = $this->get_user_id();
            $post_publisher = $this->get_post_publisher($post);
            if ( empty($post_publisher)) {
                if ( isset($current_user_id)) {
                    $this->set_post_publisher($post, $current_user_id);
                } else {
            /* enable in future
                    // no current user and publishing? probably a bot plugin. ( wprobot3, autopost, etc. )
                    // we don't like bots spamming our system.
                    $post_eligible_for_automatic_publishing = false;
                    $this->set_post_eligible_for_automatic_handling($post, false);
            */
                }
            }
            // TODO: this below can allow for spammer plugins ... but still need to handle use case.
            // server not storing publisher info / author info.
            // TODO : maybe look for the normal transistion ( draft -> publish for example )
            if ( $post_eligible_for_automatic_publishing === null ) {
                // if there is no value then the draft was not created when the plugin was activated. ( TODO : what about quick create? or mobile publishing? )
                // if the post is managed already then let it be published automatically. ( the $post_eligible_for_automatic_publishing should have already been set
                // this is extra insurance )
                $this->set_post_eligible_for_automatic_handling($post, $post_is_managed === true);
            }

            break;
        }
    }

    /**
     * reasons for returning false:
     * 1. post predated plugin being installed
     * 2. post had its publish to external service manually cancelled.
     *
     * @param unknown_type $post
     * @return true if the post should be published automatically
     * false if we are forcing a manual publish
     * null means post predated plugin activation (but FarReach.es server may know about it)
     */
    public function get_post_eligible_for_automatic_handling($post){
        $post_eligible_for_automatic_handling = $this->get_messageThread_meta($post, array(self::FARREACHES_STATUS, self::POST_AUTOMATIC_PUBLISHING));
        return $post_eligible_for_automatic_handling;
    }
    // ONLY exposed for testing ( at this point )
    /**
     *
     * @param WP_Post|numeric $post
     * @param bool $status
     */
    public function set_post_eligible_for_automatic_handling($post, $status){
        // $status === true to force to boolean
        $this->add_messageThread_meta($post, array(self::FARREACHES_STATUS, self::POST_AUTOMATIC_PUBLISHING), $status===true);
    }

    /**
     * The post publisher may not be the author as recorded by wordpress. The post publisher is the person who pressed the
     * publish button in the UI.
     *
     * We do NOT automatically set the publisher to the author because we want to know who authorize the post to be published.
     * This also defeats some spammer plugins like wprobot
     *
     * @param unknown $post
     */
    private function get_post_publisher($post) {
        $post_publisher = $this->get_messageThread_meta($post, array(self::FARREACHES_STATUS, self::POST_PUBLISHER));
        return $post_publisher;
    }

    /**
     * see note on get_post_publisher()
     *
     * Nominally private only exposed for test purposes.
     * @param unknown $post
     * @param unknown $post_publisher
     */
    function set_post_publisher($post, $post_publisher) {
        $this->add_messageThread_meta($post, array(self::FARREACHES_STATUS, self::POST_PUBLISHER), $post_publisher);
    }
    /**
     * This handles the user clicking the publish button. The separation from handle_post_publishing() allows for handle_post_publishing() to have different arguments
     * and different orders than what wordpress sends.
     *
     * delay publishing to have different
     * arguments that are more suited to the delayed publishing.
     * @param unknown_type $post
     */
    function handle_user_post_publishing($post_id, $post = null) {
        $this->handle_post_publishing(null, $post_id, $post);
    }
    private function get_post_delay_publish_event_keys($post) {
        return $this->get_messageThread_meta($post, array(self::FARREACHES_STATUS, self::POST_DELAY_EVENT_KEYS));
    }
    private function set_post_delay_publish_event_keys($post, $retry_count, $delay_count, $user_id, $timestamp) {
        $this->add_messageThread_meta($post, array(self::FARREACHES_STATUS, self::POST_DELAY_EVENT_KEYS),
                array('retry' => $retry_count, 'delay' => $delay_count,
                        'user_id'=>$user_id, 'timestamp'=>$timestamp));
    }

    // TODO: not used.. ?
    private function get_post_publish_job_definition($post) {
        $post_id = $post->ID;
        $events_keys = $this->get_post_delay_publish_event_keys($post);
        $retry_count = $events_keys['retry'];
        $delay_count = $events_keys['delay'];
        $user_id = $events_keys['user_id'];
        $job_definition = $this->create_job_definition($user_id, self::FARREACHES_DELAY_PUBLISH_ACTION_HOOK, array($post_id, null, $retry_count, $delay_count));
        return $job_definition;
    }

    /**
     * Creates a job definition that has the argument order in the same order as required by handle_post_publishing()
     *
     * This provides a single location that must be changed if the arguments to handle_post_publishing() change.
     * @param unknown_type $user_id
     * @param unknown_type $post_or_id
     * @param unknown_type $retry_count
     * @param unknown_type $delay_count
     */
    private function create_post_delayed_publish_job($user_id, $post_or_id, $retry_count, $delay_count) {
        $post_id = $this->get_id($post_or_id);
        $job_definition = $this->create_job_definition($user_id, self::FARREACHES_DELAY_PUBLISH_ACTION_HOOK, array($post_id, null, $retry_count, $delay_count));
        return $job_definition;
    }

    /**
     * Explicitly separate entry for cron jobs.
     * (We will be changing cron job method signatures to be standard)
     * @param unknown $current_user_id
     * @param unknown $post_id
     * @param unknown $post
     * @param number $retry_count
     * @param number $delay_count
     * @param bool $publish_now
     */
    public function oncron_post_publishing($current_user_id, $post_id, $post = null, $retry_count = 0, $delay_count = 0, $publish_now = false) {
        $this->handle_post_publishing($current_user_id, $post_id, $post, $retry_count, $delay_count, $publish_now);
    }
    /**
     * Note: $post properties are names the same as the columns in wp_posts table
     *
     * NOTE: This function is triggered 2 different ways:
     *    1) delayed posting
     *    2) attempted retry on a failed transmission. (see body)
     *
     * Look at http://wordpress.org/extend/plugins/better-delete-revision/
     * for ideas on how to handle nop revisions.
     *
     * Delay in Publishing Post:
     * =========================
     * The delay in post publishing caters for the following use case:
     * Post is modified within a specific time interval of its publishing on wordpress:
     * -------------------------------------------------------------------------------
     * This function maintains a counter to determine if this is the first pass to the function. If it is
     * first pass then it creates a wp_schedule_single_event and returns. Publishing of post is not done
     * in the first pass.
     * In the second pass, a call is made to function to decide if delaying post should be continued. The
     * decision is based on the post modified date. If the modified date of olde and new post matches then
     * a request is sent to the server to publish it to externa services.
     * In case the modified date doesn't match then a new wp_schedule_single_event is create. This will continue
     * until the date matches.
     * A typical post goes through the following status in order given below:
     * 1) delay => Publishing of post was delayed(Scheduled for publishing)
     * 2) abort => Publishing of post was aborted
     * 3) resume => Resume publishing of post
     * 4) delay => Publishing of post was delayed(Scheduled for publishing)
     *
     * TO_AMIT: check and document how wp handles scheduled posts. Do scheduled posts not transition to publish until
     * the scheduled time ( this is my assumption ).
     *
     *
     *Re-posting unmodified post:
     *==========================
     * TO_PAT: In this use case the user has already published the post. After some time the user hits the publish button
     * without modifying the post. The plugin needs to verify if the post has already been published and do nothing if the
     * user tries to publish unmodified already published post. My question is how to detect if the post has already been
     * published to the external services?
     *
     * TO_NEWPERSON (smart publish delay) are we publishing too early? lets check...
     * are they still editing?
     * is anyone else editing?
     * difference between the old version?
     * !TESTCASES
     * TODO user needs to see what they are pushing, especially in situations...
    nothing changed inside title, preview[more], excerpt but they still pushed update
    preview different aspects (twitter vs facebook is huge)
     *
     */
    function handle_post_publishing($current_user_id, $post_id, $post = null, $retry_count = 0, $delay_count = 0, $publish_now = false) {
        if ($post == null) {
            $post = get_post($post_id);
            if ($post == null) {
                // post went missing
                $this->debug_log("The post with ID=${post_id} was deleted from wordpress db by user before it could be sent to farreaches (this is o.k.)");
                return self::POST_LOCAL_PUBLISH_DECISION_INVALID;
            }
        }

        if (!empty( $post->post_password )) {
            if (self::POST_LOCAL_STATUS_TRANSMISSION_SUCCESSFUL != $this->get_post_local_transmission_status($post)) {
                //Do not publish password protected posts - if published then we should unpublish
                $this->set_post_local_publish_decision($post, self::POST_LOCAL_PUBLISH_DECISION_PASSWORD_PROTECTED);
                return;
            } else {
                //If previously published post become password protected, revoke the post (server needs to be informed)
                $this->handle_post_unpublishing($post);
                return;
            }
        }

        // TODO: the categories must be permanently cached. ( we never want this to have a communications problem )
        $post_categories = $this->get_registered_categories_associated_with_post($post);
        if ($this->is_response_in_error($post_categories)){
            $this->set_post_local_publish_decision($post, self::POST_LOCAL_PUBLISH_DECISION_COMMUNICATION_ERROR);
            return;
        }

        // TODO: the cateogries must be permanently cached. ( we never want this to have a communications problem )
        $has_active_message_endpoints_associated_with_categories = $this->farReaches_Wireservice->has_active_message_endpoints_associated_with_categories($post_categories);
        if ($this->is_response_in_error($has_active_message_endpoints_associated_with_categories)){
            $this->set_post_local_publish_decision($post, self::POST_LOCAL_PUBLISH_DECISION_COMMUNICATION_ERROR);
            return;
        }

        $this->debug_log('post_categories', $post_categories, 'has_active_message_endpoints_associated_with_categories', $has_active_message_endpoints_associated_with_categories, 'post_local_transmission_status', $this->get_post_local_transmission_status($post));
        if (! $has_active_message_endpoints_associated_with_categories) {
            $message_endpoints_tree = $this->farReaches_Wireservice->get_message_endpoints_tree();
            // If post was already published to the server, we need to send an update even when no categories are selected.
            // TO_EUGENE : HACK what if the post was published, updated, republished failed?
            if (self::POST_LOCAL_STATUS_TRANSMISSION_SUCCESSFUL != $this->get_post_local_transmission_status($post)) {
                $this->farReaches_NotificationsManager->notify_user('post_category_is_not_mapped', $current_user_id);
                $this->debug_log(
                    "Post not associated to a valid category or tag. This post will not be published to any external service",
                    "Post Id=", $post->ID, " parent=", $post->post_parent, " post_status=", $post->post_status);
                $this->set_post_local_publish_decision($post, self::POST_LOCAL_PUBLISH_DECISION_NO_VALID_CATEGORIES);
                return;
            }
        }

        // if the post was is not being delayed ( publish immediately ) -- maybe we should publish immediately.
        if (!$this->is_post_delayed($post) && !$this->is_post_modified($post, $post_categories)) {
            $this->debug_log("Post is not modified. It will not be published to external services", "Post Id=", $post->ID, " parent=", $post->post_parent, " post_status=", $post->post_status);
            $this->set_post_local_publish_decision($post, self::POST_LOCAL_PUBLISH_DECISION_NOT_MODIFIED);
            return;
        }
        $current_user_id = $this->get_user_id($current_user_id);
        $post_publisher = $this->get_post_publisher($post);
        if (!isset($post_publisher)) {
            if ( !isset($current_user_id)) {
                $this->error_log($post->ID, ":User id is not set. Cannot proceed with publishing (and no post publisher)");
                $this->set_post_local_publish_decision($post, self::POST_LOCAL_PUBLISH_DECISION_NO_USER_DEFINED);
                return;
            } else {
                // TODO : remove once confirmed no problems
                $this->error_log($post->ID, ":post publisher not set but current user was passed in");
                $post_publisher = $current_user_id;
                $this->set_post_publisher($post, $post_publisher);
            }
        }
        if ($post->post_status != 'publish') {
            $this->debug_log($post->ID, ":publishing to cancelled because the post status is no longer 'publish' but rather ", $post->post_status);
            $post_local_publish_decision = self::POST_LOCAL_PUBLISH_DECISION_INVALID_STATUS . $post->post_status;
            $this->set_post_local_publish_decision($post, $post_local_publish_decision);
            return;
        }

        $proceed = $this->prevent_old_post_publishing_on_update($post, $publish_now);
        if (!$proceed){
            // TODO : clear message and user is given ability to override.
            $this->set_post_local_publish_decision($post, self::POST_LOCAL_PUBLISH_DECISION_FR_PUBLISH_CANCELLED_AS_ALREADY_PUBLISHED_LOCALLY);
            return;
        }

        // Check if publishing is not forced and post delay is enabled
        if (!$publish_now && self::POST_DELAY_ENABLED) {
            // Delay publishing the post
            // =========================
            // If delay_count = 0, it implies first pass. At first pass we don't publish the post but delay it by POST_DELAY_TIME_IN_SECONDS
            // After the first pass, the delay_post_publishing method verifies if the post was modified between delay interval. If it was than we again delay posting.
            // If the post was not modified than we go ahead with publishing the post.
            if ($delay_count == 0 || $this->delay_post_publishing($post)) {
                $this->debug_log("Delaying publishing post ", $post->ID, " parent=", $post->post_parent, " post_status=", $post->post_status);
                $delay_count++;
                if ($delay_count <= self::POST_DELAY_MAX_COUNT) {
                    // The delay_count helps in determining how many times the publishing of the post is delayed. The self::POST_DELAY_MAX_COUNT helps to limit
                    // the number of time the post is delayed. If the post is delayed beyond the max count, it implies that the post is being updated for some time
                    // (self::POST_DELAY_MAX_COUNT*self::POST_DELAY_TIME_IN_SECONDS) and should not be published at that time.
                    // However user can publish the post at a later time.
                    return $this->schedule_post_publish(self::POST_DELAY_TIME_IN_SECONDS, $post, $retry_count, $delay_count);
                } else {
                    $this->error_log($post->ID, " : was to be delayed ", $delay_count, " times which is more than the maximum delay count of ", self::POST_DELAY_MAX_COUNT);
                    $this->unschedule_post_publishing($post);
                    $this->set_post_local_publish_decision($post, self::POST_LOCAL_PUBLISH_DECISION_DELAY_COUNT_EXCEEDED);
                    return;
                }
            }
        } else {
            $this->debug_log("Publishing post without delay ", $post->ID, " parent=", $post->post_parent, " post_status=", $post->post_status);
        }

        // set up the refresh time on updating status.
        $this->publish_post($post, $post_categories);
    }
    /**
     * This function will publish post
     *
     * @param $post - The post to be published
     * @param $post_categories
     * @param $user_id - The id of the user publishing the post
     * @return void
     */
    private function publish_post($post, $post_categories) {
        $this->set_post_local_transmission_status($post, self::POST_LOCAL_STATUS_TRANSMISSION_IN_PROGRESS);
        // we really want to set this after the post is sent. ( but then if user edits while post is being processed we would miss a change )
        $this->update_post_content_hash($post, $post_categories);
        $this->set_post_local_publish_decision($post, self::POST_LOCAL_PUBLISH_DECISION_PUBLISH_OK);
        $this->set_post_is_managed($post, true);
        $post_tags = '';
        $this->debug_log("Publishing post ", $post->ID, " parent=", $post->post_parent, " post_status=", $post->post_status);
        $thumbnail_uri = $this->get_post_thumbnail_uri($post);

        //FIXME If the body contains a letter š, it gets to Twitter as &scaron;
        // When I tweet, and enter a š, it gets displayed correctly.
        // Š is displayed correctly on FB, both title and content.
        $message_body = $this->unsanitize_html($post->post_content);
        $message_excerpt = $this->unsanitize_html($post->post_excerpt);

        //FIXME In case user provides no title, no visible notification appears, and post is not published via FarReaches.
        $message_title = $this->unsanitize_html($post->post_title, false);

        $post_categories = self::add_entity_type_info($post_categories, 'tag');
        $post_publisher = $this->get_post_publisher($post);

        $request = array(
                // todo: how to handle post_author ? could be different than user that published.
                // may need post author to give credit on E.S. Most important to track user that actual published
                'messageBody' => $message_body,
                'messageHeadline' => $message_title,
                'messageExcerpt' => $message_excerpt,
                'publicUri' => get_permalink($post->ID),
                'externalCategorySelection' => $post_categories,
                'selectedTags' => $post_tags,
                // send the blogs ISO 2 character language code ( http://www.loc.gov/standards/iso639-2/php/code_list.php )
                /*
        * TO_KOSTYA: I tested this in english. Looks good! But I guess it would be a good idea to test it on
        * other locales as well.
        */
                'language' => get_locale(),
                'externalContentId' => $post->ID,
                'author' => $post->post_author,
                'publisher' => $post_publisher
        );
        
        if ($thumbnail_uri) {
            $request['thumbnailUri'] = $thumbnail_uri;
        }
        // Note: must explicitly pass because in wp_cron current_user is the 0th user.
        $response = $this->initiate_secured_api_call(FarReaches_Api_Call::POST_PUBLISH, $request, null, $post_publisher);
    }
    /**
     *
     * @param unknown $post
     * @param unknown $publish_now
     * @return boolean
     */
    private function prevent_old_post_publishing_on_update($post, $publish_now){
        // TODO state of the checkbox ( which we need to add)
        $post_eligible_for_automatic_publishing = $this->get_post_eligible_for_automatic_handling($post);
        $post_is_managed = $this->get_post_is_managed($post);
        if (
            // user is forcing the older post to be published. post is now managed by FarReaches.
            $publish_now ===true
            // OR automatic publishing is enabled for this post
            || $post_eligible_for_automatic_publishing ===true){
            if ($post_eligible_for_automatic_publishing !== true) {
                $this->set_post_eligible_for_automatic_handling($post, true);
            }
            $this->set_post_is_managed($post, true);
            $this->set_post_local_transmission_status($post, self::POST_LOCAL_STATUS_TRANSMISSION_IN_PROGRESS);
            return true;
        } else if ($post_eligible_for_automatic_publishing === false) {
            // $post_eligible_for_automatic_publishing === null means we don't know if the user wants to automatically publish
            // false means we do know the answer and the user does NOT want automatic publishing
            // definitely no, automatic publishing is disabled.
            $this->set_post_local_transmission_status($post, self::POST_LOCAL_STATUS_TRANSMISSION_ABORTED);
            // ... but the post may have been previously published, so we still need to display any remote status.
            return false;
        } else if ( $post_is_managed === true ) {
            // post is managed and $post_eligible_for_automatic_publishing === null
            $this->set_post_is_managed($post, true);
            $this->set_post_eligible_for_automatic_handling($post, true);
            $this->set_post_local_transmission_status($post, self::POST_LOCAL_STATUS_TRANSMISSION_IN_PROGRESS);
            return true;
        } else {
            // post is not managed (known to have never been published), automatic publishing is null
            // therefore do not publish (note: relying on on_KnownMessageExternalIds_done )
            $this->set_post_local_transmission_status($post, self::POST_LOCAL_STATUS_TRANSMISSION_CANCELLED_AS_ALREADY_PUBLISHED_LOCALLY);
            // but at this point we know not to publish
            return false;
        }
    }

    /**
     *
     * Combines ids into tuples of (id, 'type') form.
     * Needed for server to properly distinguish between differrent entity types: posts, categories, etc.
     *
     * @param array $ids
     * @param unknown $entity_type
     * @return multitype:multitype:unknown
     */
    static function add_entity_type_info(array $ids, $entity_type) {
        $result = array();
        foreach ($ids as $id) {
            $result[] = array($id, $entity_type);
        }
        return $result;
    }

    /**
     * farreaches://post/publish/abort handler
     *
     * @param FarReaches_Event $farReaches_Event
     */
    public function onevent_post_publishing_abort(FarReaches_Event $farReaches_Event) {
        $post_id = $farReaches_Event->data;
        $post = get_post($post_id);
        $this->set_post_eligible_for_automatic_handling($post, false);
        $this->unschedule_post_publishing($post);
    }
    /**
     * farreaches://post/publish/now handler
     *
     * @param FarReaches_Event $farReaches_Event
     * @return bool success or failure
     */
    public function onevent_post_publishing_start(FarReaches_Event $farReaches_Event) {
        $post_id = $farReaches_Event->data;
        $post = get_post($post_id);
        $result = $this->unschedule_post_publishing($post);
        if ( !$result ) {
            $this->debug_log("Could not cancel post publishing for ", $post->ID);
            return false;
        } else {
            $retry_count = 0;
            $delay_count = 1;
            return $this->handle_post_publishing(null, null, $post, $retry_count, $delay_count, true);
        }
    }
    /**
     * Called when the 2-phase publishing is completed successfully.
     */
    function on_post_publishing_done(FarReaches_Event $farReaches_Event) {
        $response = $farReaches_Event->response;
        $postId = $this->get_post_id_from_event($farReaches_Event);
        $this->set_post_local_transmission_status($postId, self::POST_LOCAL_STATUS_TRANSMISSION_SUCCESSFUL);
        $this->schedule_immediate_envelope_status($farReaches_Event->user, self::SOONER_TIME, $postId);
    }

    function on_post_publishing_failed(FarReaches_Event $farReaches_Event) {
        $response = $farReaches_Event->response;
        // happens if the failure occurs while getting the temporary key for publish.
        $postId = $farReaches_Event->saved_for_callback['externalContentId'];
        if ( $postId == null ) {
            // if failure occurred after the temp key was received (or in cases where this is a read operation)
            /// TODO: check.
            $postId = $farReaches_Event->request['externalContentId'];
        }
        if ( $postId == null ) {
            // TODO: see if this alternate checking is needed
            // TODO: combine into 1 location
            $postId = $this->get_post_id_from_event($farReaches_Event);
        }
        if ( $response->is_server_available() == true) {
            $this->set_post_local_transmission_status($postId, self::POST_LOCAL_STATUS_TRANSMISSION_ERROR);
            $this->error_log("Failed to publish post. post_id = ", $postId, $response);
        } else {
            $this->set_post_local_transmission_status($postId, self::POST_LOCAL_STATUS_SERVER_NOT_AVAILABLE_DELAYED);
        }
        // retry in 2 minutes
        $this->set_post_next_refresh_time(self::POST_DELAY_TIME_IN_SECONDS_IF_SERVER_PROBLEMS, $postId);
        // retry until the server is up
        $this->schedule_post_publish(self::POST_DELAY_TIME_IN_SECONDS_IF_SERVER_PROBLEMS, $postId, 100, 0);
    }

    private function get_post_id_from_event(FarReaches_Event $farReaches_Event) {
        $apiData = $farReaches_Event->http_args['body'];
        $postId = $apiData['externalContentId'];
        return $postId;
    }

    /**
     * This function cancels scheduled post publishing if it has been delayed.
     * Nominally private ( only exposed for testing purposes)
     * @return true - if post was unscheduled or never scheduled.
     */
    function unschedule_post_publishing($post) {
        if ($this->is_post_delayed($post)) {
            $event_keys = $this->get_post_delay_publish_event_keys($post);
            if (!empty($event_keys)) {
                $job_definition = $this->create_post_delayed_publish_job($event_keys['user_id'], $post, $event_keys['retry'], $event_keys["delay"]);
                $next_schedule_timestamp = $this->get_next_scheduled($job_definition);
                if ($next_schedule_timestamp) {
                    $this->unschedule_event($job_definition, $next_schedule_timestamp);
                    if (!$this->get_next_scheduled($job_definition)) {
                        $this->debug_log("Unscheduled the post successfully. ", $post->ID, " post_status=", $post->post_status);
                        $this->set_post_local_transmission_status($post, self::POST_LOCAL_STATUS_TRANSMISSION_ABORTED);
                    } else {
                        $this->error_log("Failed to abort post. ", $post->ID, " parent=", $post->post_parent, " post_status=", $post->post_status);
                        return false;
                    }
                } else {
                    $this->set_post_local_transmission_status($post, self::POST_LOCAL_STATUS_TRANSMISSION_ABORTED);
                }
            }
        }
        return true;
    }

    /**
     * This action helps us identify when the post gets updated. If an aborted post was updated then we change
     * the status of the post to resume. The handle post publishing action detects that the post status is
     * resume and schedules the post for publishing.
     */
    function handle_save_post() {
        if (FarReaches_Request::string('action') == 'editpost') {
            if (FarReaches_Request::string('save') == 'Update' || FarReaches_Request::string('publish') == 'Publish') {
                $post = get_post(FarReaches_Request::abs_int('post_ID'));
                $post_status = $this->get_post_local_transmission_status($post);
                if (self::POST_LOCAL_STATUS_TRANSMISSION_ABORTED == $post_status
                    || self::POST_LOCAL_STATUS_TRANSMISSION_ERROR == $post_status
                    || self::POST_LOCAL_STATUS_SERVER_NOT_AVAILABLE_DELAYED == $post_status
                ) {
                    $this->set_post_local_transmission_status($post, self::POST_LOCAL_STATUS_TRANSMISSION_RESUMED);
                }
            }
        }
    }

    /**
     * This function schedules the publishing event.
     * TODO: ONLY public because some tests rely on a direct call
     */
    function schedule_post_publish($start_in_secs, $post, $retry_count, $delay_count) {
        $post_status = $this->get_post_local_transmission_status($post);
        $post_publisher = $this->get_post_publisher($post);
        $user_id = $post_publisher;
        $old_time_stamp = 1;
        if (self::POST_LOCAL_STATUS_TRANSMISSION_ABORTED == $post_status) {
            $event_keys = $this->get_post_delay_publish_event_keys($post);
            if (!empty($event_keys)) {
                $retry_count = $event_keys['retry'];
                $delay_count = $event_keys['delay'];
                $user_id = $event_keys['user_id'];
                $old_time_stamp = $event_keys['timestamp'];
            }
        }
        $job_definition = $this->create_post_delayed_publish_job($user_id, $post, $retry_count, $delay_count);
        //(AMIT) Once the event has been unscheduled we need not have to do this check. But there seems to be a cache synchronization issue due to which
        //we have to unschedule the event twice. If we don't do this step then we have a situation where the post gets published even if the user has
        //aborted the publishing. More investigation will be required to check how to force refreshing of a cache.
        //Due to this limitation we persist the next schedule timestamp while creating the event and then use it here to check if we have to unschedule
        //the event.
        $next_schedule_timestamp = $this->get_next_scheduled($job_definition);
        if ($old_time_stamp == $next_schedule_timestamp) {
            $this->debug_log("Publishing event exists, so unscheduling it. ", $next_schedule_timestamp, "  ", $post->ID, " parent=", $post->post_parent, " post_status=", $post->post_status);
            // TODO TO_PAT $event_keys variable might have not been defined
            // PAT: This would be a bug... unless you can document a good reason for such a gap.
            $this->unschedule_event($job_definition, $next_schedule_timestamp);
            $next_schedule_timestamp = $this->get_next_scheduled($job_definition);
            if (!$next_schedule_timestamp) {
                $this->debug_log("Post is no longer scheduled. ", $next_schedule_timestamp, "  ", $post->ID, " parent=", $post->post_parent, " post_status=", $post->post_status);
            } else {
                $this->error_log("Post publishing could not be unscheduled is still scheduled. ", $next_schedule_timestamp, "  ", $post->ID, " parent=", $post->post_parent, " post_status=", $post->post_status);
                $this->set_post_local_publish_decision($post, self::POST_LOCAL_PUBLISH_DECISION_FAILED_TO_UNSCHEDULE);
                return self::POST_LOCAL_PUBLISH_DECISION_FAILED_TO_UNSCHEDULE;
            }
        }
        $is_delayed = $this->is_post_delayed($post_status);
        //Schedule the event only when
        //a) The post is not delayed and it is not scheduled. Which implies it is a new post.
        //b) The post status is resume and it is not scheduled. This case occurs when an aborted post is updated.
        //   and it is unscheduled to be published.
        if ($is_delayed && !$next_schedule_timestamp) {
            $this->schedule_single_event($start_in_secs, $job_definition);
            $timestamp = $this->get_next_scheduled($job_definition);
            if ($timestamp) {
                $this->debug_log("Scheduled the post successfully. timestamp " . $timestamp . " " . $post->ID . " parent=", $post->post_parent, " post_status=", $post->post_status);
                if ( $post_status != self::POST_LOCAL_STATUS_SERVER_NOT_AVAILABLE_DELAYED ) {
                    // we want to retain the server not available status
                    $this->set_post_local_transmission_status($post, self::POST_LOCAL_STATUS_TRANSMISSION_DELAYED);
                }
                $this->set_post_delay_publish_event_keys($post, $retry_count, $delay_count, $user_id, $timestamp);
                $this->set_post_local_publish_decision($post, self::POST_LOCAL_PUBLISH_DECISION_PUBLISH_OK);
                return self::POST_LOCAL_PUBLISH_DECISION_PUBLISH_OK;
            } else {
                $this->error_log("Failed to scheduled the post. ", $post->ID, " parent=", $post->post_parent, " post_status=", $post->post_status);
                $this->set_post_local_publish_decision($post, self::POST_LOCAL_PUBLISH_DECISION_FAILED_TO_SCHEDULE);
                return self::POST_LOCAL_PUBLISH_DECISION_FAILED_TO_SCHEDULE;
            }
        }

        // what is this exit condition
        return null;
    }

    /**
     * Check if the post status is delayed
     * Post status
     * 'publish' => Post is published but not associated to any farreaches category
     * 'auto-draft'  => new post
     * 'inherit'     => Post is published but not associated to any farreaches category
     * 'success'     => Post is successfully published via farreaches
     * All other status' implies that the post is delayed.
     * post status false => post status not set yet.
     */
    function is_post_delayed($post_or_post_status) {
        if (!isset($post_or_post_status)) {
            return false;
        } else if (is_string($post_or_post_status)) {
            $post_status = $post_or_post_status;
        } else {
            $post_status = $this->get_post_local_transmission_status($post_or_post_status);
        }
        switch ($post_status) {
            case self::POST_LOCAL_STATUS_TRANSMISSION_SUCCESSFUL:
                $delay = false;
                break;
            case self::POST_LOCAL_STATUS_TRANSMISSION_RESUMED:
                // definitely delay
            default:
                $delay = true;
        }
        return $delay;
    }

    /**
     *
     * @param unknown_type $post
     * @return array (never null)
     */
    public function get_post_local_transmission_status_object($post) {
        $post_local_transmission_status = $this->get_post_local_transmission_status($post);
        // we want to default to true.
        // abort acts like uncheck on automatic publish
        $displayed_post_local_transmission_status = array(
            'post_id' => $this->get_id($post),
            'statusText' => $this->get_local_post_status_message($post, $post_local_transmission_status),
            'status' => 'local-' . $post_local_transmission_status,
            'service' => 'local',
            'local' => true
        );
        return $displayed_post_local_transmission_status;
    }

    public function get_post_local_transmission_status($post) {
        $post_local_transmission_status = $this->get_messageThread_meta($post, array(self::FARREACHES_STATUS, self::LOCAL_TRANSMISSION_STATUS));
        if ( $post_local_transmission_status == null) {
            $post_local_transmission_status = self::POST_LOCAL_STATUS_TRANSMISSION_NOT;
        }
        return $post_local_transmission_status;
    }

    public function set_post_local_transmission_status($post, $local_status) {
        $this->add_messageThread_meta($post, array(self::FARREACHES_STATUS, self::LOCAL_TRANSMISSION_STATUS), $local_status);
    }

    private function get_post_remote_transmission_status($post) {
        $post_remote_transmission_status = $this->get_messageThread_meta($post, array(self::FARREACHES_STATUS, self::REMOTE_STATUS));
        return $post_remote_transmission_status;
    }

    private function set_post_remote_transmission_status($post, $remote_status) {
        $this->add_messageThread_meta($post, array(self::FARREACHES_STATUS, self::REMOTE_STATUS), $remote_status);
    }
    public function get_post_local_publish_decision($post) {
        $post_local_publish_decision = $this->get_messageThread_meta($post, array(self::FARREACHES_STATUS, self::POST_LOCAL_PUBLISH_DECISION));
        return $post_local_publish_decision;
    }
    private function set_post_local_publish_decision($post, $post_local_publish_decision) {
        $this->add_messageThread_meta($post, array(self::FARREACHES_STATUS, self::POST_LOCAL_PUBLISH_DECISION), $post_local_publish_decision);
    }
    private function get_external_services_icons($post) {
        $external_services_icons = array();
        $category_ids = $this->get_registered_categories_associated_with_post($post);
        if (!$this->is_response_in_error($category_ids)) {
            foreach ($this->farReaches_Wireservice->get_external_service_definitions_associated_with_categories($category_ids, true) as $definition) {
                $service_alias = strtolower($definition['service_name']);
                $service_icon_url = $this->farReaches_Ui_Handling->get_extserv_img_uri($service_alias, '16');
                array_push($external_services_icons, array('service_icon' => $service_icon_url));
            }
        }
        return $external_services_icons;
    }

    // ------------------------------------------------------------------------------
    /**
     * Handles the server telling the plugin the known posts. This removes the uncertainty that could leave the plugin not knowing if the wireserver knows about the post.
     *
     * We are relying on every post that was published before plugin installation being made known to the plugin by the server.
     *
     * The KnownMessageExternalIds api call must be triggered when the plugin is installed, OR when the plugin suspects that it is out of date. (TBD)
     *
     * Important design note:
     *
     * Even though the plugin may think the wireserver doesn't know about the post, it is possible that the wireserver
     * does. This can happen under this use case:
     * 1. wordpress db backup
     * 2. post published to wireserver
     * 3. wordpress db restored from backup.
     *
     * This means that every so often the plugin needs to confirm with the wireserver.
     *
     * When a new post is created, the managed flag is set to false.
     * When published the post is set to managed - Even if the publish operation "fails" (the wireserver still may have gotten the post)
     *
     * @see also get_post_is_managed() set_post_is_managed()
     *
     * @param FarReaches_Event $farReaches_Event
     */
    public function on_KnownMessageExternalIds_done(FarReaches_Event $farReaches_Event) {
        $postIdDetailsList = $farReaches_Event->response;
        $localHosts = array();
        $humanUriHost = $this->farReaches_Communication->get_human_uri();
        $localHosts[] = '//' . $humanUriHost . '/';
        if ( stripos($humanUriHost, "www.") === 0 ) {
            $localHosts[] = '//' . substr($humanUriHost, 4) . '/';
        }
        $siteUriHost = $this->farReaches_Communication->get_code_uri();
        if ( strcasecmp($siteUriHost, $humanUriHost) !== 0) {
            $localHosts[] = '//' . $siteUriHost . '/';
            if ( stripos($siteUriHost, "www.") === 0 ) {
                $localHosts[] = '//' . substr($siteUriHost, 4) . '/';
            }
        }
        foreach($postIdDetailsList as $postIdDetails) {
            $externalBaseUri = $postIdDetails['externalBaseUri'];
            // may return ids from locations other than this blog ( facebook, etc. )
            foreach($localHosts as $localhost) {
                if ( strcasecmp($localhost, $externalBaseUri) ===0  ) {
                    $postId = $postIdDetails['externalBaseId'];
                    $post_is_managed = $this->get_post_is_managed($postId);
                    if ( $post_is_managed != true) {
                        // we did not know the post was managed

                        // checking to make sure the post exists ( may not if the wp database was rolled back )
                        $post = get_post($postId);
                        if ( $post === null) {
                            // we want this to get to the server so the server can special case the post.
                            // right now we just want an email.
                            $unknown_posts[] = $postId;
                        } else if (wp_is_post_revision($post) !== false) {
                            // we want this to get to the server so the server can special case the post.
                            // right now we just want an email.
                            $revision_not_post[] = $postId;
                        } else {
                            $this->set_post_is_managed($postId, true);
                            $this->set_post_eligible_for_automatic_handling($postId, true);
                            // ... so we need to make sure we get the statuses.
                            $refresh_posts[] = $postId;
                        }
                        break;
                    }
                }
            }
        }
        if (!empty($unknown_posts) || !empty($revision_not_post)) {
            $error_message[] = "Server knows about posts:";
            if (!empty($unknown_posts)) {
                $error_message[] = " that are unknown to WordPress:";
                $error_message[] = $unknown_posts;
                $error_message[] = ";";
            }
            if (!empty($revision_not_post)) {
                $error_message[] = "; that are marked as revisions:";
                $error_message[] = $revision_not_post;
            }
            $this->error_log($error_message);
        }
        if ( !empty($refresh_posts)) {
            // we don't pass the post ids directly because if there was a failure we want the refresh time always set.
            // and we want to pick up other posts that need to be refresh.
            $this->schedule_immediate_envelope_status($farReaches_Event->user, 0, $refresh_posts);
        }
    }
    /**
     *
     * @param WP_Post|number $post
     * @param bool $post_is_managed true if the post was freshly published to the wireserver or if the wireserver knows about this post ( from a previous installation )
     */
    public function set_post_is_managed($post, $post_is_managed = true){
        $this->add_messageThread_meta($post, array(self::FARREACHES_STATUS, self::POST_IS_MANAGED_KEY), $post_is_managed === true);
    }
    /**
     * @param unknown_type $post
     * @return true if wireserver knows (or could know) about this post. Thus the wireserver needs to be asked about this post
     * when asking about the status
     * false if the wireserver "definitely" (see design note) does not know about this post.
     * null is assumed to be false because on_KnownMessageExternalIds_done will let plugin know about published posts
     */
    public function get_post_is_managed($post){
        $post_is_managed = $this->get_messageThread_meta($post, array(self::FARREACHES_STATUS, self::POST_IS_MANAGED_KEY));
        if ( empty($post_is_managed)) {
            // because we now proactively ask the server for the list of all known posts, because we don't have a value set for this post
            // we can now assume that this post is not managed
            return false;
        }
        return $post_is_managed;
    }
    // ------------------------------------------------------------------------------

    /**
     * The server cannot trust the plugin and will encode anything the plugin sends.
     * So the plugin must unencode the text to avoid a double encoding problem.
     *
     * Additionally, the do_shortcode expansion needs to happen, BEFORE the html decoding
     *
     * Before because: shortcode expansion may remove/add html entities.
     *
     * do_shortcode expands wordpress shortcodes.
     * Read about short codes here: http://codex.wordpress.org/Shortcode_API
     * shortcodes allow plugins to have dynamic content inserted into a post body.
     * TODO: future feature, exclude certain shortcodes from being rendered.
     * For example, if another plugin uses shortcodes to insert content that does not make sense outside the context
     * of the wordpress website. (twitter retweets)
     * http://codex.wordpress.org/Function_Reference/do_shortcode
     * note that deactivated plugins with shortcodes embedded in posts results in the short code (i.e. [foo] ) being rendered literally.
     * @param string $text
     * @param $shortcode_expand
     * @return string
     */
    private function unsanitize_html($text, $shortcode_expand = true) {
        if ($shortcode_expand) {
            $shortcoded = do_shortcode($text);
        } else {
            $shortcoded = $text;
        }
        $hand_replace_nbsp = preg_replace('/&nbsp;/i', ' ', $shortcoded);
        // unfortunately html_entity_decode converts &nbsp; to character code 160  ( not space )
        // note we are relying on wordpress making sure all 160 chars are stored as &nbsp;
        $result = html_entity_decode($hand_replace_nbsp, ENT_QUOTES);
        return $result;
    }

    function get_post_thumbnail_uri($post) {
        $post_id = $this->get_id($post);

        $attached_thumb_url = wp_get_attachment_thumb_url(get_post_thumbnail_id($post_id));

        if ($attached_thumb_url) {
            $thumbnail_uri = $attached_thumb_url;
        } else {
            $thumbnail_uri = $this->get_first_image($post);
        }
        return $thumbnail_uri;
    }
    
    /**
     * 
     * http://codex.wordpress.org/Function_Reference/get_children#Examples
     * 
     * @param $postID
     * @return first image thumbnail url.
     */
    function get_first_image($post) {
        $postID = $this->get_id($post);        
    	$attachments = get_attached_media( 'image', $postID );
    	if (empty($attachments)) {
    	    $upload_dir = wp_upload_dir();
    	    if (is_array($upload_dir) && array_key_exists('baseurl', $upload_dir)) {
            	$upload_url = $upload_dir['baseurl'];
        	    //Only allow images uploaded to the site, otherwise we get all sort of problems
        	    //with images inserted by 3-d party tools (e.g. skype icon).
        	    //https://codex.wordpress.org/Function_Reference/wp_upload_dir
            	$regexp = "/<img.+src=['\"](".preg_quote($upload_url, '/')."[^'\"]+)['\"].*>/i";
    	    } else {
    	    	//Something went wrong. Uploads are managed externally? Fallback to getting everything.
    	        $regexp = "/<img.+src=['\"]([^'\"]+)['\"].*>/i";
    	    }
    	    $image_count = preg_match_all($regexp, $post->post_content, $matches);
    	    if ($image_count > 0) {
    	        return $matches[1][0];
	        }
    	} else {
            foreach ($attachments as $attachment) {    
                return wp_get_attachment_thumb_url($attachment->ID);
            }    		
    	}
    }

    /**
     * wordpress handler function
     * @param unknown $post
     * @return string
     */
    function handle_post_unpublishing($post) {
        $this->debug_log("a post is unpublished " . $post->ID);
        if (self::POST_LOCAL_STATUS_TRANSMISSION_SUCCESSFUL == $this->get_post_local_transmission_status($post)) {
            //The post was sent to server so it makes sense to send a revoke request.
            //TODO reuse delay post code
            $this->revoke_post($post, $this->get_user_id());
            return 'revoked';
        }
    }

    /**
     * REVOKE messages are processed like NORMAL messages. This allows the same message handling code on the server
     * to handle the processing of the removal of messages from the external services.
     *
     * Note: that this also allows for niceties like a revoke of a revoke.
     * @param unknown_type $post
     * @param unknown_type $user_id
     */
    function revoke_post($post, $user_id) {
        //TODO do we need a special local post status for the case?
        $this->set_post_local_transmission_status($post, self::POST_LOCAL_STATUS_TRANSMISSION_IN_PROGRESS);
        $this->debug_log("Revoking post ", $post->ID, " parent=", $post->post_parent, " post_status=", $post->post_status);
        $request = array(
            'externalContentId' => $post->ID
        );
        $response = $this->initiate_secured_api_call(FarReaches_Api_Call::POST_REVOKE, $request, null, $user_id);
    }

    /**
     *
     * @param FarReaches_Event $farReaches_Event
     */
    function on_post_unpublishing_done(FarReaches_Event $farReaches_Event) {
        $response = $farReaches_Event->response;
        $apiData = $farReaches_Event->http_args['body'];
        $user = $farReaches_Event->user;
        $post = $apiData['externalContentId'];
        //TODO do we need a special local post status for the case?
        $this->set_post_local_transmission_status($post, self::POST_LOCAL_STATUS_TRANSMISSION_SUCCESSFUL);
        //TODO only show this notification if user action required to remove the post from external service.
        $this->farReaches_NotificationsManager->notify_user("post_revoked_action_required", $user);
    }

    /**
     *
     * @param FarReaches_Event $farReaches_Event
     */
    function on_post_unpublishing_failed(FarReaches_Event $farReaches_Event) {
        $response = $farReaches_Event->response;
        $apiData = $farReaches_Event->http_args['body'];
        $user = $farReaches_Event->user;
        $post = $apiData['externalContentId'];
        //TODO do we need a special local post status for the case?
        if ( $response->is_server_available() == true) {
            $this->set_post_local_transmission_status($post, self::POST_LOCAL_STATUS_TRANSMISSION_ERROR);
            // TODO: cron job to retry unpublish
            $this->error_log("Failed to revoke post. ", $response, $post->ID, " parent=", $post->post_parent, " post_status=", $post->post_status);
        } else {
            // TODO: cron job to retry unpublish
            $this->set_post_local_transmission_status($post, self::POST_LOCAL_STATUS_SERVER_NOT_AVAILABLE_DELAYED);
        }
    }

    /**
     * This function check the modified dates of the old and new posts.
     * If dates match then no delay is required in publishing the post.
     * If dates don't match then new post becomes old for the next pass.
     */
    function delay_post_publishing(&$old_post) {
        $new_post = get_post($old_post->ID);

        if ($old_post->post_modified_gmt == $new_post->post_modified_gmt) {
            return false;
        } else {
            $old_post = $new_post;
            return true;
        }
    }

    /**
     * This function checks if there is any difference in post content between the post to be updated and
     * its last published revision (both in content and selected connected categories).
     * This ensures that only the modified post are sent to the FarReaches server.
     *
     */
    function is_post_modified($post, $post_categories) {
        $hash_prev = $this->get_messageThread_meta($post, array(self::FARREACHES_STATUS, self::POST_CONTENT_HASH));
        if ($hash_prev === null){
            return true;
        }
        $hash_curr = $this->get_post_hash($post, $post_categories);
        $content_updated = $hash_curr == $hash_prev? false: true;

        return $content_updated;
    }

    function update_post_content_hash($post, $post_categories){
        $hash = $this->get_post_hash($post, $post_categories);
        $this->add_messageThread_meta($post, array(self::FARREACHES_STATUS, self::POST_CONTENT_HASH), $hash);
    }

    private function get_last_revision($post){
        $not_in = array();

        //Get the autosave post
        $autosave = wp_get_post_autosave($post->ID);
        if ($autosave) {
            $not_in[] = $autosave->ID;
        }

        //Retrieve the last revision of the post
        $post_args = array(
                'post_type' => 'revision',
                'post_status' => 'any',
                'numberposts' => 1,
                'post_parent' => $post->ID,
                'post__not_in' => $not_in,
                'order' => 'desc',
                'orderby' => 'post_modified_gmt'
        );

        $last_revision = get_children($post_args);
        $revision = array_values($last_revision);

        if (empty($revision)) {
            return null;
        }

        return $revision[0];
    }

    private function get_post_hash($post, $post_categories){
        $hash = hash('md5', $post->post_title .' '.$post->post_content.' '.$post->post_excerpt.' '.print_r($post_categories, true));
        return $hash;
    }

    /**
     * post_is_managed is used to determine if post was ever sent to wireserver.
     *
     * @param unknown $post_local_transmission_status
     * @return string
     */
    private function get_local_post_status_message($post, $post_local_transmission_status) {
        // This only reflects the most recent attempt to send the post to the wireserver,
        // TODO done as a switch so that the message can be customized to the post.
        if ( $post_local_transmission_status == null) {
            // no status ( usually this means a draft )
            $post_local_transmission_status = self::POST_LOCAL_STATUS_TRANSMISSION_NOT;
        }
        switch($post_local_transmission_status) {
        case self::POST_LOCAL_STATUS_TRANSMISSION_IN_PROGRESS:
            // TODO : reference the ext services
            return "Sending to FarReach.es...";
        case self::POST_LOCAL_STATUS_TRANSMISSION_SUCCESSFUL:
            return "Sent to FarReach.es. (being processed)...";
        case self::POST_LOCAL_STATUS_TRANSMISSION_ABORTED:
            return "The transmission was cancelled. Nothing was sent to FarReach.es. To schedule the post, please click the update button or click the Publish Now button to publish the post immediately.";
        case self::POST_LOCAL_STATUS_TRANSMISSION_ERROR:
            return "Transmission error while sending this post to FarReach.es. Click the Update button to schedule transmission or the Publish Now button to send it immediately.";
        case self::POST_LOCAL_STATUS_TRANSMISSION_RESUMED:
            //  HACK TODO !!! this happens is user publishes while wireserver is down. User MUST have a "abort button"
            return "Resuming transmission to FarReach.es.";
        case self::POST_LOCAL_STATUS_TRANSMISSION_CANCELLED_AS_ALREADY_PUBLISHED_LOCALLY:
            // need better message as a help message
            return "This post was not sent to the FarReach.es service because it was first published before ".FARREACHES_PLUGIN_DISPLAY_NAME." plugin was activated. Click on 'Publish now' to send to FarReach.es for normal processing.";
        case self::POST_LOCAL_STATUS_SERVER_NOT_AVAILABLE_DELAYED:
            return "The post will be sent to the FarReach.es server when the server is available (it is down for maintanence)";
        case self::POST_LOCAL_STATUS_TRANSMISSION_DELAYED:
            return "The post will be sent to FarReach.es in " . self::POST_DELAY_TIME_IN_SECONDS . " seconds.";
        case self::POST_LOCAL_STATUS_TRANSMISSION_NOT:
            if ( $post->post_status !=='draft' && $post->post_status !== 'auto-draft') {
                return "Not published to any social marketing websites.";
            } else {
                return "";
            }
        default:
            return "";
        }
    }
    private function get_post_category_ids($post){
        $taxonomies = $this->get_categories_and_tags($post->ID);
        $cat_ids = array();
        foreach ($taxonomies as $taxonomy) {
            if ($taxonomy->taxonomy == 'category') {
                $cat_ids[] = $taxonomy->term_id;
            }
        }

        return $cat_ids;
    }

    /**
     * Gets registered categories associated with the post.
     */
    function get_registered_categories_associated_with_post($post) {
        $categories = array();
        $taxonomies = $this->get_categories_and_tags($post->ID);
        $message_end_points = $this->farReaches_Wireservice->list_message_endpoints();
        if ($this->is_response_in_error($message_end_points)){
            return $message_end_points;
        }
        foreach ($taxonomies as $taxonomy) {
            if ($taxonomy->taxonomy == 'category') {
                if ($this->farReaches_Wireservice->is_category_registered($taxonomy, $message_end_points)) {
                    $categories[] = $taxonomy->term_id;
                }
            }
        }
        return $categories;
    }

    /**
     * this function intentionally does not set or get FarReaches_Post_handling::*_post_is_managed() value. This is to allow the calling code to
     * apply the _post_is_managed() filtering separately.
     *
     * Use case: the periodic refresh to make sure that the plugin has the correct information about which post is managed or not would want to not apply existing and perhaps bad _post_is_managed filtering.
     *
     * @param array $post_list
     * @param unknown_type $userId
     * @param $refresh_missing false - then don't refresh (use case when rendering each post in a post list, the refresh was triggered when the post list display started)
     * @return multitype:unknown
     */
    public function get_posts_statuses(array $post_list, $userId = null, $refresh_missing = true){
        $post_status_map = array();
        if ( !empty($post_list)) {
            $post_ids = $this->get_ids($post_list);

            foreach ($post_ids as $post_id){
                $messageEndPointEnvelopeRecords = $this->get_post_remote_transmission_status($post_id);
                if ( $messageEndPointEnvelopeRecords == null) {
                    $cache_key = $this->get_post_status_cache_key($post_id);
                    $messageEndPointEnvelopeRecords = $this->get_cached($cache_key);
                }

                if ($messageEndPointEnvelopeRecords !== null){
                    $post_status_map[$post_id] = $messageEndPointEnvelopeRecords;
                }
            }
            if ($refresh_missing) {
                $found_in_cache_post_ids = array_keys($post_status_map);
                // Removing cache-contained post-ids from request array
                $not_cached_post_ids = array_diff($post_ids, $found_in_cache_post_ids);

                if ( !empty($not_cached_post_ids)) {
                    $this->debug_log("not_cached_post_ids = ", $not_cached_post_ids);
                    $this->schedule_immediate_envelope_status($userId, 0, $not_cached_post_ids);
                }
            }
        }
        return $post_status_map;
    }

    private function get_gmdate_str($offset_in_secs = 0) {
        $time = time() + $offset_in_secs;
        // 20130101080409 = 2013, jan, 1, 8:04:09 am - formats give add leading zeros
        $now_str = gmdate("YmdHis", $time);
        return $now_str;
    }

    /**
     * @deprecated -- remove : not using cache anymore ( saving permanently)
     * @param unknown $post_id
     * @return string
     */
    private function get_post_status_cache_key($post_id){
        return self::CACHE_KEY_POST_STATUS_PREFIX.$post_id;
    }

    /**
     * This is called periodically Look for all the posts that need to get their status refreshed.
     */
    public function oncron_refresh_posts_status() {
        // we want to allow for different arguments when called directly
        $this->farReaches_Util->set_a_cron_user_id();
        $this->refresh_posts_status();
    }
    public function refresh_posts_status() {
        global $wpdb;
        $after_time_string = $this->get_farreaches_meta_key('refresh_status.' . '00000000000000');
        $before_time_string = $this->get_farreaches_meta_key('refresh_status.' . $this->get_gmdate_str());
        $sql = $wpdb->prepare( "SELECT post_id FROM $wpdb->postmeta WHERE meta_key >=  '%s' AND meta_key <= '%s'", $after_time_string, $before_time_string);
        $results = $wpdb->get_col( $sql );
        if ( !empty($results)) {
            $externalContentIds = FarReaches_Post_Handling::add_entity_type_info($results, 'msg');
            // on_EnvelopeStatus_done will update the refresh time
            $api_call_result = $this->api_call(FarReaches_Api_Call::POST_STATUSES, array('externalContentIds' => $externalContentIds), $this->get_user_id());
        }
    }

    /**
     * Set refresh using special key for db querying.
     * @param number $time_offset_in_secs
     * @param unknown $posts
     */
    private function set_post_next_refresh_time($time_offset_in_secs, $posts) {
        if ( !empty($posts)) {
            $this->delete_post_next_refresh_time($posts);
            $offsetStr =$this->get_gmdate_str($time_offset_in_secs);
            $meta_key_base = 'refresh_status.' . $offsetStr;
            $postIds = $this->get_ids($posts);
            foreach($postIds as $postId) {
                $this->farReaches_Util->update_meta('post', $postId, $meta_key_base, null, $offsetStr);
            }
            // TODO : need to find out if the cron job needs to be scheduled.
        }
    }
    private function delete_post_next_refresh_time($posts) {
        global $wpdb;
        $postIds = implode( ', ', $this->get_ids($posts) );
        $after_time_string = $this->get_farreaches_meta_key('refresh_status.' .  '00000000000000');
        $before_time_string = $this->get_farreaches_meta_key('refresh_status.' . '99999999999999');
        $query = $wpdb->prepare( "DELETE FROM $wpdb->postmeta WHERE post_id in ($postIds) AND meta_key >=  '%s' AND meta_key <= '%s'", $after_time_string, $before_time_string);
        $wpdb->query($query);
    }
    /**
     * Only called if the EnvelopeStatusList/done is successfully
     *
     * @param FarReaches_Event $farReaches_Event
     */
    public function on_EnvelopeStatusList_done(FarReaches_Event $farReaches_Event) {
        $userId = $farReaches_Event->user;
        // array((array(<id>, 'msg'), ...)
        $statuses_requested_for_posts = $farReaches_Event->request['externalContentIds'];
        $post_statuses_from_server = $farReaches_Event->response;
        $postEnvelopeStatuses = array();
        $refresh_times = array();

        if ( !empty($post_statuses_from_server)) {
            $messageEndPointEnvelopeRecordsList = array();
            $notes_about_statuses = array();
            // non-empty result from server (some posts known to the server)
            // group by post id and determine if the post is in progress or had an error.
            foreach ($post_statuses_from_server as $envelopeStatus){
                $postId = $envelopeStatus['externalContentId'];
                $postEnvelopeStatuses[$postId] = $envelopeStatus;
                $messageEndPointEnvelopeRecordsList[$postId][$envelopeStatus[FarReaches_Wireservice::MESSAGE_END_POINT_API_PARAM]][] = $envelopeStatus;
                // TO_KOSTYA why are we getting nvr records?
                // TO_PAT this is because we create FILTER_BY_CATEGORY message end point records, for every broadcast envelope. So a message endpoint record is created for every endpoint, even if a message never goes in there. Such records are never posted to external services, which results in the externalEntityStatus to be returned as 'nvr'.
                // TO_KOSTYA : we need to filter at the server. Those records are essentially a server implementation detail that clients should not see.
                if ($envelopeStatus['externalEntityStatus'] == 'nvr') {
                    continue;
                }
                // (issue is that we may never finish transition - because the facebook for example does not allow for removing posts )
                if ( array_key_exists($postId, $notes_about_statuses) ) {
                    if ($envelopeStatus['inProgress'] !== false ) {
                        //TO_KOSTYA TODO: this needs to be changed to handle held posts ( look for scheduled time )
                        $notes_about_statuses[$postId]['inProgress'] = true;
                    }
                    if ( !$this->is_transmission_successful($envelopeStatus)) {
                        $notes_about_statuses[$postId]['successful'] = false;
                    }
                } else {
                    //TO_KOSTYA TODO: this needs to be changed to handle held posts ( look for scheduled time )
                    $notes_about_statuses[$postId]['inProgress'] = ($envelopeStatus['inProgress'] !== false );
                    $notes_about_statuses[$postId]['successful'] = $this->is_transmission_successful($envelopeStatus);
                }
            }
            // now look at processed returned results.
            // Note: allowing for possibility that server is informing plugin about post that plugin did not ask about (as a way of reducing network traffic)
            // Use case example: on initial registration ( which maybe a registration )
            // This would also allow for the server to inform plugin about a post that was removed from an external service (ToS violation perhaps)
            // get cached information? ( but should have complete refresh )
            foreach($messageEndPointEnvelopeRecordsList as $postId => $messageEndPointEnvelopeRecords) {
                $this->set_post_remote_transmission_status($postId, $messageEndPointEnvelopeRecords);
                $post_local_status = $this->get_post_local_transmission_status($postId);
                if ( $post_local_status == self::POST_LOCAL_STATUS_TRANSMISSION_NOT) {
                    // if we have a remote status then we probably were successful
                    // TODO: the exception is a failed update
                    $this->set_post_local_transmission_status($postId, self::POST_LOCAL_STATUS_TRANSMISSION_SUCCESSFUL);
                }
                if ( $notes_about_statuses[$postId]['inProgress'] == true) {
                    // transitioning
                    // TODO ( so we need to update more frequently ) - we should note when to ask again. ( maybe a scheduled time)
                    $refresh_times['sooner'][] = $postId;
                } else if ($notes_about_statuses[$postId]['successful'] != true) {
                    // not successful
                    // TODO : need to calculate update time.
                    $refresh_times['sooner'][] = $postId;
                } else {
                    $refresh_times['later'][] = $postId;
                }
            }
        }

        // look for posts with no status on server and mark their status
        foreach($statuses_requested_for_posts as $postId_status_requested) {
            list($postId, $externalEntityType) = $postId_status_requested;
            if ( !array_key_exists($postId, $postEnvelopeStatuses) ) {
                $post_is_managed = $this->get_post_is_managed($postId);
                if ($post_is_managed === false) {
                    // post is NOT managed therefore caching the 'no data' forever
                    $this->set_post_remote_transmission_status($postId, array());
                    $refresh_times['never'][] = $postId;
                } else {
                    // no status but the post is managed or could be managed
                    $cache_key_base = $this->get_post_status_cache_key($postId);
                    // TODO: wrong ( but idea is that this is cached
                    $this->cache($cache_key_base, array());
                    $refresh_times['sooner'][] = $postId;
                }
            }
        }
        // Every post that has its status passed should be in a $refresh_times array
        // so we know when to refresh the post status next.
        if ( array_key_exists('never', $refresh_times) ) {
            $this->delete_post_next_refresh_time($refresh_times['never']);
        }
        if ( array_key_exists('later', $refresh_times) ) {
            // the regular cron job can handle this.
            // this is the ONLY place where the refresh time is lengthened.
            $this->set_post_next_refresh_time(self::LATER_TIME, $refresh_times['later']);
        }
        if ( array_key_exists('sooner', $refresh_times) ) {
            $this->schedule_immediate_envelope_status($userId, self::SOONER_TIME, $refresh_times['sooner']);
        }
    }

    private function is_transmission_successful(array $envelopeStatus) {
        $post_status = $envelopeStatus['externalEntityStatus'];
        switch($post_status) {
        case 'pcd': // PROCESSED("pcd", false, false),
        case 'upd': // UPDATED("upd", false, false),
        case 'del': // DELETED("del", false, false),
        case 'spt':  //NOT_SUPPORTED("spt", false, false)
        case 'nvr': // (ignored) NEVER_POSTED("nvr", false, false),
            // successful transmission
            return true;
            // end point
        case 'rej': // REJECTED_BY_EXTERNAL_SERVICE("rej", true, false),
        case 'iop': // IO_PROBLEM("iop", false, false),
        case 'crt': // CRITICAL_PROBLEM ("crt", false, true),
        case 'aut': // AUTH_PROBLEM("aut", false, true),
            return false;
        }
    }
    /**
     *
     * @param FarReaches_Event $farReaches_Event
     */
    public function on_EnvelopeStatusList_failed(FarReaches_Event $farReaches_Event) {
        // array((array(<id>, 'msg'), ...)
        $statuses_requested_for_posts = $farReaches_Event->request['externalContentIds'];
        foreach($statuses_requested_for_posts as $post_requested) {
            // tuple ( postid, 'msg' )
            $postIds[] = $post_requested[0];
        }
        $this->schedule_immediate_envelope_status($farReaches_Event->user, self::SOONER_TIME, $postIds);
    }

    /**
     * For when we don't want to wait for the regular refresh time. (after publish)
     * @param unknown $user_or_id
     * @param unknown $time_from_now_in_seconds
     */
    private function schedule_immediate_envelope_status($user_or_id, $time_from_now_in_seconds, $posts) {
        $userId = $this->get_user_id($user_or_id);
        $this->set_post_next_refresh_time($time_from_now_in_seconds, $posts);
        $job_definition = $this->create_job_definition($userId, "do_EnvelopeStatusList_immediately");
        // so we know that the post refresh time will have expired.
        $this->schedule_single_event($time_from_now_in_seconds, $job_definition);
    }
}
