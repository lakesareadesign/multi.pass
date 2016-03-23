<?php
/*
Plugin Name: Social Marketing
Plugin URI: http://wordpress.org/plugins/socialmarketing/
Description: Get your marketing content from WordPress onto Facebook, Twitter and Tumblr. Create marketing content once and Social Marketing distributes it. Get started: 1) Click the "Activate" link to the left of this description; 2) Select your social marketing platforms; 3) Post!
Version: 1.8.2.2
Author: FarReach.es ( wp-plugin@FarReach.es )
Author URI: http://FarReach.es/
License: GPL2

Copyright 2012-2013  FarReach.es ( wp-plugin@FarReach.es )  (email : wp-plugin@FarReach.es)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

// Make sure we don't expose any info if called directly
if (!function_exists('add_action')) {
    echo "Hi there!  I'm just a plugin, not much I can do when called directly.";
    exit;
}

// PAT: HACK TODO :  the number of defines is getting excessive
// TODO we need a configuration file in the config directory that is automatically generated with the values stored in a single global
// or available via FarReaches_Util instance.
define('FARREACHES_PLUGIN_VERSION', '1.8.2.2');
define('FARREACHES_COMPATIBLE_VERSION', '1.8.');
// only used right now for reporting version to wireserver
define('FARREACHES_PLUGIN_NAME', 'socialmarketing');
//  FARREACHES_WP_MINIMUM = minimum version needed to run the plugin
define('FARREACHES_WP_MINIMUM', '3.5.0');
//  FARREACHES_WP_RECOMMENDED = wordpress versions less than minimum will be warned that future versions of plugin will not support their version of wordpress.
define('FARREACHES_WP_RECOMMENDED', '3.8.1');
define('FARREACHES_API_HOST', 'api.farreach.es');
define('FARREACHES_API_PORT', '80');
define('FARREACHES_API_STATUS_HOST', 'api.farreach.es:9000');
define('FARREACHES_API_VERSION', '1.2');
define('FARREACHES_PLUGIN_DISPLAY_NAME', 'Social Marketing');
// enabled to get beta versions of plugins
define('FARREACHES_CUSTOM_AUTOUPDATE_ENABLED', 'false'==='true');

// enable if you need debug logging. ( a little odd looking so that even w/o substitution stmt is still legal php )
// also means that http requests to server will not have time out value ( makes it easier to debug )
define('FARREACHES_DEBUG', 'false' === 'true');
define('FARREACHES_PAYMENTS_ENABLED', 'false' === 'true');
define('FARREACHES_HUMAN_ERROR_REPORTS_EMAIL_ADDRESS', 'support@FarReach.es');
define('FARREACHES_AUTOERROR_EMAIL_ADDRESS', 'autoerror_1.8.2@FarReach.es');

if ( !defined('FARREACHES_LOG_DIRECTORY')) {
    define('FARREACHES_LOG_DIRECTORY', dirname(__FILE__) . '/logs');
}
// trim if more than 100Kish ... yes we might lose info but better than impacting customer.
define('FARREACHES_LOG_SIZE', 102400);
define('FARREACHES_DATE_FORMAT_POST_LIST', 'Y/m/d');
define('FARREACHES_DATE_FORMAT_POST_INFO', 'M j, Y @ h:i');

/**
 * NOTE: README :
 *     1) All classes must start with the ( 'FarReaches_' or 'FarReachesConfig_' ) string.
 *     2) All class names must be the same as the file name with '_' substituted for '-'
 *
 * Set up PHP5 autoloading so that plugin does not need require_once.
 * Ref: http://php.net/manual/en/language.oop5.autoload.php
 * if there is another autoloading function (i.e. another plugin that uses the autoloading mechanism.)
 * AMIT: Found the following:
 *     a) If autoloader function names are same, wordpress detects conflict and throws error. Which is good!
 *     b) If the names are different, the autoloader of other plugins also get called and vice versa.
 */
function farreaches_autoloader($class_name) {
    if (strpos($class_name, 'FarReaches_') === 0) {
        $class_file = dirname(__FILE__) . '/class/' . strtolower(str_replace('_', '-', $class_name)) . '.php';
        if (file_exists($class_file)) {
            require_once $class_file;
        }
    } else if (strpos($class_name, 'FarReachesConfig_') === 0) {
        $class_file = dirname(__FILE__) . '/config/' . strtolower(str_replace('_', '-', $class_name)) . '.php';
        if (file_exists($class_file)) {
            require_once $class_file;
        }
    } else if (strpos($class_name, 'FarReachesFoundation_') === 0) {
        $class_file = dirname(__FILE__) . '/foundation/' . strtolower(str_replace('_', '-', $class_name)) . '.php';
        if (file_exists($class_file)) {
            require_once $class_file;
        }
    }
}
spl_autoload_register('farreaches_autoloader');

// NOTE: be super very careful with everything in this function since we already are in an error situation.
function farreaches_fatal_handler() {
    global $farreaches_timing_array;
    if (connection_status() == CONNECTION_TIMEOUT) {
        $last_timing = end($farreaches_timing_array);
        //If last timing's end wasn't recorded, then timeout is in our code.
        if (is_array($last_timing) && sizeof($last_timing) < 3) {
            $error = array('type' => E_ERROR,
                           'message' => 'farreaches script was shut down by timeout.');
        };
    } else {
        $error = error_get_last();
    }

    if( $error !== NULL) {
        $errno = @$error["type"];
        switch( $errno) {
        case E_ERROR:
            $error_type = 'Fatal Error';
            break;
        case E_COMPILE_ERROR:
            $error_type = 'Compile Error';
            break;
        case E_CORE_ERROR:
            $error_type = 'Fatal Core Error';
            break;
        case E_RECOVERABLE_ERROR:
            // for example - passing 2 arguments to a function that expects 3.
            $error_type = 'Recoverable error';
            break;
        case E_STRICT:
        case E_WARNING:     // explicitly ignore
        case E_CORE_WARNING: // explicitly ignore
        case E_NOTICE: // explicitly ignore
        default:
            return;
        }
        $errfile = @$error["file"];
        $errline = @$error["line"];
        $errstr  = @$error["message"];
        $interesting_strings = array('farreaches', 'socialmarketing');
        $report_as_our_problem = false;
        foreach($interesting_strings as $interesting_string) {
            if ( (is_string($errfile) && stristr($errfile, $interesting_string))
                || (is_string($errstr) && stristr($errstr, $interesting_string))
                || (array_key_exists('SCRIPT_FILENAME', $_SERVER) && stristr($_SERVER['SCRIPT_FILENAME'], $interesting_string))
                ) {
                // appears to be an error that socialmarketing caused or was part of.
                $report_as_our_problem = true;
                break;
            }
        }
        if ( $report_as_our_problem == true) {
            // we don't want to be blamed for something that we didn't cause ... so look to see if the error file is ours.
            // or it affects us.  (WP_Feed_Cache::create is called incorrectly and triggers this call)
            // problem - fsockopen() will trigger this as well checking for the server being up.
            @header('HTTP/1.1 500 Internal Server Error');

            $diagnostics_data = FarReaches_Error_Management::get_minimum_diagnostics_data(true);
            $exported_diagnostics_data = var_export($diagnostics_data, true);

            $content ="<div>PLEASE report this to " . FARREACHES_HUMAN_ERROR_REPORTS_EMAIL_ADDRESS . "</div>";
            $content .= "<table><thead bgcolor='#c8c8c8'><th>Item</th><th>Description</th></thead><tbody>";
            $content .= "<tr valign='top'><td><b>Diagnostics</b></td><td><pre>$exported_diagnostics_data</pre></td></tr>";
            $content .= "<tr valign='top'><td><b>Error</b></td><td><pre>$errstr</pre></td></tr>";
            $content .= "<tr valign='top'><td><b>Error Type</b></td><td><pre>$error_type</pre></td></tr>";
            $content .= "<tr valign='top'><td><b>File</b></td><td>$errfile</td></tr>";
            $content .= "<tr valign='top'><td><b>Line</b></td><td>$errline</td></tr>";
            $timings = var_export($farreaches_timing_array, true);
            $content .= "<tr valign='top'><td><b>Timings</b></td><td>$timings</td></tr>";
            $environment = var_export($_SERVER, true);
            $content .= "<tr valign='top'><td><b>Environment</b></td><td>$environment</td></tr>";
            $content .= '</tbody></table>';

            echo $content;
            FarReaches_Error_Management::fatal_log($content);
        }
    }
}

register_shutdown_function( "farreaches_fatal_handler" );

/**
 * Isolate the bootstrap functions to avoid polluting the namespace.
 *
 */
class FarReaches_Bootstrap {
    private $farReachesAdmin;
    /**
     * Triggered on action 'init'
     *
     * This function initializes all the code including the action hooking.
     *
     * TO_PAT TO_KOSTYA: I don't like entangled dependency management that take place here.
     * Lets consider using IoC, e.g.  https://github.com/Elfet/IoC
     */
    function farreaches_init() {
        if ( isset($this->farReachesAdmin)) {
            return;
        }
        //
        // TODO: check case if plugin was activated, upgraded to a plugin version that requires a newer wp.
        // (particularily when being upgraded outside UI screen) - can we check and deactivate?
        // right now we just do permission blocking with results in confusing "no permission message"
        //

        // code in FarReaches_Util relies on this file being in the root directory of the plugin.
        $farReaches_Util = new FarReaches_Util(__FILE__);
        if (FARREACHES_DEBUG) {
            $api_call_log = FARREACHES_LOG_DIRECTORY . '/api_call.log';
        } else {
            $api_call_log = null;
        }
        $farReaches_Communication = new FarReaches_Communication($farReaches_Util, new FarReaches_Http_Handler_Wordpress($api_call_log));
        $farReaches_Ui_Handling = new FarReaches_Ui_Handling(
                $farReaches_Util,
                $farReaches_Communication
        );

        $farReaches_Notification_Mgr = new FarReaches_Notifications_Manager(
            $farReaches_Util,
            $farReaches_Communication
        );

        $farReaches_Wireservice = new FarReaches_Wireservice(
            $farReaches_Util,
            $farReaches_Communication
        );

        $farReaches_Post_Handling = new FarReaches_Post_Handling(
            $farReaches_Util,
            $farReaches_Communication,
            $farReaches_Notification_Mgr,
            $farReaches_Wireservice,
            $farReaches_Ui_Handling
        );

        $this->farReachesAdmin = new FarReaches_Admin($farReaches_Util, $farReaches_Communication, $farReaches_Post_Handling, $farReaches_Notification_Mgr, $farReaches_Wireservice, $farReaches_Ui_Handling);

        FarReaches_EventBus_Facade::initialize($farReaches_Util, $farReaches_Communication);

        if ( !defined('FARREACHES_DOING_DEACTIVATION')) {
            $this->farReachesAdmin->check_for_upgrade();
        }
    }

    /**
     * See discussion about how plugin activation functions are different than all other hooks that
     * are made by normal plugin behavior.
     * http://wordpress.org/support/topic/register_activation_hook-does-not-work
     * In particular this function must be in this main file
     *
     */
    function farreaches_activated() {
        define('FARREACHES_ACTIVATING', true);
        // see http://wordpress.stackexchange.com/questions/25910/uninstall-activate-deactivate-a-plugin-typical-features-how-to/25979#25979
        $plugin = isset( $_REQUEST['plugin'] ) ? $_REQUEST['plugin'] : '';
        check_admin_referer( "activate-plugin_{$plugin}" );

        // permission checks first (failure does not affect activation status)
        if ( !current_user_can( FarReachesFoundation_Permissions::MANAGE_FARREACHES_PLUGIN_CAP ) ) {
            wp_die(sprintf("You don't have permission to manage the %s plugin. You need the %s permission.",
                FARREACHES_PLUGIN_DISPLAY_NAME, FarReachesFoundation_Permissions::MANAGE_FARREACHES_PLUGIN_CAP));
        }

        $this->check_for_severe_issues_deactivate();
        $this->farreaches_init();
        $this->farReachesAdmin->activate();
    }

    function farreaches_deactivated() {
        define('FARREACHES_DOING_DEACTIVATION', true);
        // see http://wordpress.stackexchange.com/questions/25910/uninstall-activate-deactivate-a-plugin-typical-features-how-to/25979#25979
        $plugin = isset( $_REQUEST['plugin'] ) ? $_REQUEST['plugin'] : '';
        check_admin_referer( "deactivate-plugin_{$plugin}" );
        // permission checks first (failure does not affect activation status)
        if ( !current_user_can( FarReachesFoundation_Permissions::MANAGE_FARREACHES_PLUGIN_CAP ) ) {
            wp_die(sprintf("You don't have permission to manage the %s plugin. You need the %s permission.",
                FARREACHES_PLUGIN_DISPLAY_NAME, FarReachesFoundation_Permissions::MANAGE_FARREACHES_PLUGIN_CAP));
        }
        $this->farreaches_init();
        $this->farReachesAdmin->deactivate();
    }

    /**
     * There is something to running this all the time except that we don't want to have any old random visitor triggering this and
     * seeing the failure.
     */
    function check_for_severe_issues_deactivate() {
        if ( !defined('FARREACHES_DOING_DEACTIVATION')) {
            $error_messages = array();
            // if we are deactivating these checks are not needed because plugin will be off anyhow.
            if ( !FarReaches_Error_Management::is_wordpress_version_allowed()) {
                $error_messages[] = sprintf('Your wordpress version (%s) is too old. %s needs at least %s but recommends version %s. The plugin is deactivated.',
                        FarReaches_Error_Management::get_wordpress_version(),
                        FARREACHES_PLUGIN_DISPLAY_NAME,
                        FARREACHES_WP_MINIMUM, FARREACHES_WP_RECOMMENDED);
            }
            $home_url_str = get_option("home");
            $home_url = parse_url($home_url_str);
            // skip last position
            if ( strrpos($home_url['host'], '.', -2) === FALSE ) {
                $error_messages[] = "Your WordPress site must be publicly accessible by our server. Unfortunately this WordPress site is configured as: $home_url_str which is not accessible.";
            }
            $this->check_and_deactivate($error_messages);
        }
    }
    private function check_and_deactivate($error_messages) {
        if (!empty($error_messages)) {
            deactivate_plugins(basename(__FILE__)); // Deactivate ourself if we can't activate because of permissioning issue
            if ( count($error_messages) > 1) {
                $die_message = implode("<li>", $error_messages);
            } else {
                $die_message = "<li>".$error_messages[0];
            }
            wp_die("<h3>".FARREACHES_PLUGIN_DISPLAY_NAME . " automatic deactivation</h3><p>We detected blocking issue(s) with trying to use the plugin on this site:</p><ul>".$die_message."</ul>");
        }
    }
    function add_action_hooks() {
        // TODO : do we need to hook the 'wp' action to get the wp_head early enough?
        // TODO: We need to make sure that delayed operations are run even if the only visitors are unlogged in (i.e. webvisitors)
        // so we can restrict ourselves to actions that only happen for logged in visitors.
        if (defined('DOING_AJAX') || defined('WP_ADMIN') || defined('DOING_CRON') || defined('XMLRPC_REQUEST')) {
            // MUST be 'init'
            // admin_init is called AFTER many interesting actions have already been triggered:
            // admin_bar_init, add_admin_bar_menus, _admin_menu, admin_menu
            // furthermore ajax calls do not trigger admin_init.
            //
            $init_action_wrapper = new FarReaches_Error_Management(array($this, 'farreaches_init'), 'action', 'init');
            add_action('init', $init_action_wrapper->as_callable());
        }
        $activation_action_wrapper = new FarReaches_Error_Management(array($this, 'farreaches_activated'), 'activation', 'farreaches_activated');
        $activation_action_wrapper->set_rethrow_exceptions();
        register_activation_hook(__FILE__, $activation_action_wrapper->as_callable());

        $deactivation_action_wrapper = new FarReaches_Error_Management(array($this, 'farreaches_deactivated'), 'deactivation', 'farreaches_deactivated');
        register_deactivation_hook(__FILE__, $deactivation_action_wrapper->as_callable());
    }
}

$farReachesBootstrap = new FarReaches_Bootstrap();
$farReachesBootstrap->add_action_hooks();
// TODO: http://codex.wordpress.org/Function_Reference/register_uninstall_hook
// suggestion is to have a uninstall.php
// we don't do anything special so don't hook
// maybe in future we will do more clean up.
// function farreaches_uninstall() {
// see http://wordpress.stackexchange.com/questions/25910/uninstall-activate-deactivate-a-plugin-typical-features-how-to/25979#25979
//     if ( ! current_user_can( 'activate_plugins' ) )
//         return;
//     check_admin_referer( 'bulk-plugins' );

//     // Important: Check if the file is the one
//     // that was registered during the uninstall hook.
//     if ( __FILE__ != WP_UNINSTALL_PLUGIN )
//         return;
       // do uninstall
// }
// /**
//  * Only a static class method or function can be used in an uninstall hook.
//  * for any special uninstall code.
//  * Please see <a href="http://codex.wordpress.org/Debugging_in_WordPress">Debugging in WordPress</a> for more information.
//  *  (This message was added in version 3.1.)
//  */
// register_uninstall_hook(__FILE__, 'farreaches_uninstall');

