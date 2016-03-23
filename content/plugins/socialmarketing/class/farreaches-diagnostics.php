<?php
/**
 * Provides means of figuring out what exactly happens to the plugin installation.
 */
class FarReaches_Diagnostics extends FarReaches_Ui_Using {

    function __construct(FarReaches_Util $farReaches_Util, FarReaches_Communication $farReaches_Communication, FarReaches_Ui_Handling $farReaches_Ui_Handling) {
        parent::__construct($farReaches_Util, $farReaches_Communication, $farReaches_Ui_Handling);
        $api_call_definition = $this->farReaches_Communication->get_api_call_definition(FarReaches_Api_Call::API_KEY_DIAGNOSTIC);
        FarReaches_EventBus_Facade::subscribeMe($this, array(
            $api_call_definition->get_success_notification_topic() => 'handle_callback_response'
        ));

        FarReaches_EventBus_Facade::subscribeMe($this, array(
            'farreaches://diagnostics/mail' => 'send_diagnostic_data_to_dev_group'), true);
    }

    /**
     * The diagnostic page is not displayed for users with roles other than admin. This is because while creating add_submenu_page (admin.php line #463), the capability is set to manage_options
     * for both the settings and diagnostic page. The manage_options capability is only applicable for super admin (in case of multi site) and admin (http://codex.wordpress.org/Roles_and_Capabilities#manage_options).
     * I confirmed this by creating users with different roles.
     */
    public function get_diagnostics_data() {
        $diagnostics_data = FarReaches_Error_Management::get_minimum_diagnostics_data(false);
        self::add_diagnostic_row($diagnostics_data, 'Farreach.es API URL', $this->farReaches_Communication->get_full_api_uri(FarReaches_Api_Call::API_KEY_INITIALIZE));

        $farreaches_server_status = $this->farReaches_Communication->is_server_reachable();
        self::add_diagnostic_row($diagnostics_data, 'Farreach.es Server Status', $farreaches_server_status ? 'Available' : 'Unavailable', $farreaches_server_status ? 'ok' : 'warn', "Farreach.es Server is temporarily unavailable.");

        /*
         * The initiate_diagnostic_api_call() requests the FarReaches server for a callback. At this point the transient "DiagnosticApiKey" will not be set. It will be
         * set only after the callback is received by the plugin. The idea here is that at first load the diagnostic page will show callback status as failed. Once the
         * callback is received by the plugin all the subsequent loading of the diagnotic page, until the life of the transient, the status will show as success.
         */
        /*
         * Commenting out the code until the server sends the callback.
        $this->initiate_diagnostic_api_call();
        $callback_status = $this->get_cached(FarReaches_Api_Call::API_KEY_DIAGNOSTIC);
        self::add_diagnostic_row('Farreach.es Server Callback Status', $callback_status? 'Succeeded': 'Failed', $callback_status? 'ok': 'error',"Farreach.es Server didn't respond to callback request. Please contact technical support.");
        */
        /* PAT : Why do we care??
        $plugin_folder_writable = is_writable($this->get_plugin_directory());
        self::add_diagnostic_row('Plugin folder writable', $plugin_folder_writable ? 'Yes' : 'No', $plugin_folder_writable ? 'ok' : 'warn', "Farreach.es plugin folder is not writable.");
        */
        $user_api_key = $this->get_current_user_api_key_if_exists();
        $api_key_present = !empty($user_api_key);

        if ( ! $api_key_present ) {
            self::add_diagnostic_row($diagnostics_data, 'API key', "No API key", 'error', "API Key is not available, try reactivating the plugin.");
        } else if ( ! $farreaches_server_status ) {
            self::add_diagnostic_row($diagnostics_data, 'API key', "API key available (but unable to confirm it is valid)", 'warn', "FarReach.es server is temporarily not available.");
        } else if ( $this->is_api_key_invalid() ) {
            self::add_diagnostic_row($diagnostics_data, 'API key', "Invalid API key", 'error', "API Key is not valid - refresh on the user page.");
        } else {
            self::add_diagnostic_row($diagnostics_data, 'API key', "Valid", 'ok', "");
        }
        /**
         * @var wpdb $wpdb
         */
        global $wpdb;
        $meta_api_key = $this->get_farreaches_meta_key(FarReaches_Communication::FARREACHES_API_KEY_BASE);
        $usermeta_data = $wpdb->get_results($wpdb->prepare("SELECT user_id, meta_key, meta_value as value FROM $wpdb->usermeta WHERE meta_key = '%s' order by user_id", $meta_api_key), ARRAY_N);
        $this->add_diagnostic_table($diagnostics_data, $usermeta_data, 'WordPress farreach.es usermeta', array('id', 'meta_key', 'meta_value'));
        $options_data = $wpdb->get_results($wpdb->prepare("SELECT option_name as name, option_value as value FROM $wpdb->options WHERE option_name like '%s'", '%' . FarReaches_Util::ARG_KEY_META_KEY_PREFIX . '%'), ARRAY_N);
        $this->add_diagnostic_table($diagnostics_data, $options_data, 'WordPress farreach.es options', array('name', 'option_value'));
        $postmeta_data = $wpdb->get_results($wpdb->prepare("SELECT post_id as id, meta_key as name, meta_value as value FROM $wpdb->postmeta WHERE meta_key like '%s' order by post_id", '%' . FarReaches_Util::ARG_KEY_META_KEY_PREFIX . '%'), ARRAY_N);
        $this->add_diagnostic_table($diagnostics_data, $postmeta_data, 'WordPress farreach.es postmeta', array('id', 'meta_key', 'meta_value'));

        $private_log_contents = FarReaches_Error_Management::get_private_log_contents();
        if ( !empty($private_log_contents)) {
            $this->add_diagnostic_table($diagnostics_data, array($private_log_contents), 'Error log', array('Contents'));
        }

        return $diagnostics_data;
    }

    /**
     * Function to add to the diagnostics return a whole table (useful for key/values on wordpress database.
     * Tables have optional name and table header names, otherwise they will be shown with default captions (look at the default parameters)
     * The $table parameter should be an array of arrays with number-indexed data
     * The $name is a string with the table name
     * The $headers are the header names you want on the table. Again a number-indexed array with as many table columns as needed
     * with the headers you want to appear
     * @param array $diagnostics_data
     * @param array $table
     * @param string $name
     * @param array $headers This are the names displayed at the top of the fields. The first one displayed is name, the second value_name
     */
    private function add_diagnostic_table(&$diagnostics_data, $table = array(), $name = 'Table Name not set', $headers = array('name' => 'Name', 'value_name' => 'Value')) {
        $diagnostics_data['tables'][] = array('table_name' => $name, 'table_data' => $table, 'table_headers' => $headers);
    }

    private static function add_diagnostic_row(&$diagnostics_data, $name = 'Name not set', $value = 'No value', $status = 'ok', $message = null) {
        return FarReaches_Error_Management::add_diagnostic_row($diagnostics_data, $name, $value, $status, $message);
    }

    /**
     * TODO reorder to match parameters.
     * Initiate callback.
     */
    function initiate_diagnostic_api_call(array $saved_for_callback = null, array $initial_call_parameters = null, $user = null) {
        $this->async_api_call(FarReaches_Api_Call::API_KEY_DIAGNOSTIC, $saved_for_callback, $user, $initial_call_parameters);
    }

    /**
     * Handle the response from the farreach.es server as part of collecting diagnostics data for callbacks
     */
    function handle_callback_response(FarReaches_Event $farReaches_Event) {
        $diagnosticApiKey = FarReaches_Request::get(FarReaches_Communication::API_CALL_KEY);
        if (!empty($diagnosticApiKey)) {
            $this->cache(FarReaches_Api_Call::API_KEY_DIAGNOSTIC, $diagnosticApiKey);
        }
    }

    function get_current_user_api_key_if_exists() {
        $user_api_key = $this->farReaches_Communication->get_user_farreaches_api_key();
        if ( $user_api_key == null ) {
            $user_api_key = "";
        }
        return $user_api_key;
    }

    function send_diagnostic_data_to_dev_group(FarReaches_Event $farReaches_Event) {
        global $current_user;
        $user_email = array_key_exists('reporting_email', $farReaches_Event) ? $farReaches_Event->reporting_email :$current_user->user_email;
        $bug_description = array_key_exists('bug_description', $farReaches_Event) ? $farReaches_Event->bug_description : "";
        $data = $this->get_diagnostics_data();
        $site_url = site_url();
        $headers = "From: Diagnostics page <$user_email>\r\n";
        $attachments = array();

        $message = $bug_description . "\nAlternate emails: " . $current_user->user_email .  "\nData:" . print_r($data, true);
        $mail_result = wp_mail(FARREACHES_HUMAN_ERROR_REPORTS_EMAIL_ADDRESS, FarReaches_Error_Management::get_standard_email_subject().': Diagnostics data from '.$site_url, $message, $headers, $attachments);
        FarReaches_Validate::true($mail_result, 'Failed to send diagnostics data by email. Copy the page contents and send it manually.');
    }

    /**
     * Make an api call to check if the api key is valid
     */
    function is_api_key_invalid() {
        // HACK really just a random call to see if the api key is any good.
        $response = $this->api_call(FarReaches_Api_Call::ACTIVE_FEATURES);
        return $this->is_response_in_error($response);
    }

    function show_page_diagnostics() {
        global $current_user;
        $diag_data = $this->get_diagnostics_data();
        ob_start();
?>
    <h2>Contact Us</h2>

    <p>Do you have a question, suggestion, compliment or concern regarding this plugin?</p>
    <p>We value your opinion and would like to hear from you.</p>

    <h3>Report an issue</h3>
    <p>Please report all issues that you find.</p>
    <form method="post" id="diagnostics_info">
        <div>From: <input id="reporting_email" name="reporting_email" type="email" value="<?php echo $current_user->user_email; ?>"></div>
        <div>Description of Issue</div>
        <textarea id="bug_description" name="bug_description" class="bug-description"></textarea>
        <button type="button"class="button button-primary"
                data-publish-event="!form#diagnostics_info"
                data-publish-topic="farreaches://diagnostics/mail"
                data-publish-label="Sending your data out..."
                data-publish-label-success="Done!"
                data-publish-failure="notification_on_failure"
            >Report Issue</button>
    </form>
    <?php
    // only show the diagnostic information to people who are allowed
    if( current_user_can(FarReachesFoundation_Permissions::READ_FARREACHES_DIAGNOSTICS_CAP) ) { ?>
        <h3>Diagnostic Data</h3>
        <div class="farreaches-list-table diagnostics-table" id="statuses">
            <div class="table-header">
                <div class="table-cell">Parameter</div>
                <div class="table-cell">Value</div>
                <div class="table-cell">Message</div>
            </div>
            <?php
            foreach($diag_data['rows'] as $diag_row) {
                printf('<div class="table-row status-%s"><div class="farreaches-label table-cell">%s</div><div class="table-cell">%s</div><div class="table-cell">%s</div></div>',
                    $diag_row['status'], $diag_row['name'], $diag_row['value'], $diag_row['message']);
            }
            ?>
        </div>
        <h3>FarReach.es data in wordpress database</h3>
        <?php
        foreach($diag_data['tables'] as $table_info) {
            printf('<h4>%s</h4>', $table_info['table_name']);
            ?>
            <div class="farreaches-list-table" id="statuses">
                <div class="table-header">
                <?php foreach($table_info['table_headers'] as $table_header) {
                    printf('<div class="table-cell">%s</div>', $table_header);
                }
                echo "</div>";
                foreach($table_info['table_data'] as $table_data) {
                    echo '<div class="table-row status-none">';
                    $table_data_arr = FarReaches_Util::ensure_array($table_data);
                    foreach($table_data_arr as $row_data) {
                        printf('<div class="table-cell">%s</div>', $row_data);
                    }
                    echo '</div>';
                }
                echo '</div>';
            }
        }
        $inserted = ob_get_contents();
        ob_end_clean();
        $this->farReaches_Ui_Handling->output_farreaches_html($inserted);
    }
}
