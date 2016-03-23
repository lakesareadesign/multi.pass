<?php
/**
 * All add_action()/add_filter() are wrapped by this class.
 *
 * IMPORTANT : This file must have no external dependencies. This file is used to report errors
 * Because we cannot be certain as to the exact source of the error, any external dependency may fail.
 *
 * TODO: error_handler should handle validation
 *
 * @author patmoore
 *
 */
class FarReaches_Error_Management {
    private $callable;
    private $hook_type;
    private $action_str;
    private $clazz_name;
    private $method_name;
    private $context_information;
    private $init_user = false;

    private $rethrow_exceptions;

    /**
     * static so shared across instances
     * @var bool
     */
    private static $log_file_writable;
    private static $log_file_size_checked;
    private static $standard_email_subject;
    /**
     * If false the error reporting code will not bother sending a error message. All sorts of things can go wrong
     * with an unsupported wordpress.
     * @var bool true if the current wordpress version is allowed.
     */
    private static $wp_version_allowed;

    public static function instantiate($callable, $action_str) {
        $that = new FarReaches_Error_Management($callable, 'action', $action_str);
        return $that;
    }
    /**
     *
     * @param unknown $callable array(object, method_name) | global function name | array('class_name', 'method_name')
     * @param unknown $hook_type
     * @param unknown $action_str
     * @param string $clazz_name
     * @param string $method_name
     */
    public function __construct($callable, $hook_type, $action_str, $clazz_name = null, $method_name = null) {
        $this->callable = $callable;
        $this->hook_type = $hook_type;
        $this->action_str = $action_str;
        $this->clazz_name = $clazz_name;
        $this->method_name = $method_name;
        if (is_array($callable)) {
        	if ($clazz_name == null) {
        	    $this->clazz_name = empty($callable[0])||is_string($callable[0])?$callable[0]:get_class($callable[0]);
        	}
        	if ($method_name == null) {
        	    $this->method_name = $callable[1];
        	}
        } else if($method_name == null && is_string($callable)) {
            $this->method_name = $callable;
        }
    }

    /**
     *
     * @return FarReaches_Error_Management
     */
    public function set_rethrow_exceptions() {
        $this->rethrow_exceptions = true;
        return $this;
    }

    /**
     * for context info creation. (default is 'action') 'filter' is also common
     * @param unknown $hook_type
     * @return FarReaches_Error_Management
     */
    public function set_hook_type($hook_type) {
        $this->hook_type = $hook_type;
        return $this;
    }

    /**
     * the first argument when the action is triggered is the user_id.
     * @return FarReaches_Error_Management
     */
    public function set_user() {
        $this->init_user = true;
        return $this;
    }

    public static function is_wordpress_version_allowed() {
        if (!isset(self::$wp_version_allowed)) {
            $wordpress_version = self::get_wordpress_version();
            self::$wp_version_allowed = version_compare($wordpress_version, FARREACHES_WP_MINIMUM) >=0?true:false;
        }
        return self::$wp_version_allowed;
    }

    public static function get_wordpress_version() {
        return get_bloginfo('version');
    }

    public function call() {
        global $farreaches_timing_array;
        $timing = array();
        $farreaches_timing_array[] = &$timing;
        $args = func_get_args();
        self::set_handlers();
        try {
            $timing[] = $this->action_str;
            $timing[] = microtime(true);
            // TODO: use the util->set_current_user() code
            // need to get away from positional parameters.
            // TODO: getting a default value for cron jobs
            if ( $this->init_user == true && count($args) > 0 && is_numeric($args[0])) {
                // see wp-includes/pluggable.php
                // TODO : use util->set_current_user() code
                wp_set_current_user($args[0]);
            }
            // TODO: use FarReaches_Event as the argument to the callable?
            $value = call_user_func_array($this->callable, $args);
            restore_error_handler();
            $timing[] = microtime(true);
            $timing[] = $timing[2] - $timing[1];
            return $value;
        } catch(Exception $exception) {
            self::error_recovery($exception, $this->get_context_information());
            // some times we want to rethrow exception ( for example when activating the plugin )
            if ( $this->rethrow_exceptions === true) {
                throw $exception;
            }
        }
        // finally blocks are in PHP 5.5 :-P
    }

    public function as_callable() {
        return array(&$this, 'call');
    }

    private function get_context_information() {
        if (!isset($this->context_information)) {
            if ( $this->clazz_name == null ) {
                $this->context_information = sprintf("%s(global function) Hook %s(%s) : Call failed",
                        $this->method_name, $this->hook_type, $this->action_str);
            } else {
                $this->context_information = sprintf("%s::%s Hook %s(%s) : Call failed",
                        $this->clazz_name, $this->method_name, $this->hook_type, $this->action_str);
            }
        }
        return $this->context_information;
    }
    /**
     * Converts errors ( which cause execution stop to exceptions )
     * from example at : http://php.net/manual/en/class.errorexception.php
     * @param int $errno
     * @param string $errstr
     * @param string $errfile
     * @param int $errline
     * @param array $errcontext
     * @throws ErrorException
     */
    public static function farreaches_error_handler($errno, $errstr, $errfile = null, $errline = 0, $errcontext = array()) {
        if ( self::is_warning($errno)) {
            self::error_log(__FUNCTION__ . ": PHP Error number $errno, $errstr File $errfile Line $errline");
        } else {
            throw new ErrorException($errstr, $errno, 0, $errfile, $errline);
        }
    }

    private static function is_warning($errno) {
        switch($errno) {
        case E_COMPILE_WARNING:
        case E_CORE_WARNING:
        case E_NOTICE:
        case E_STRICT:
        case E_USER_NOTICE:
        case E_USER_WARNING:
        case E_WARNING:
            return true;
        default :
            return false;
        }
    }
    /**
     * We do not want to handle notices and warnings.
     * Dropping STRICT, otherwise deprecated method errors show up on Guy's blog.
     * http://wordpress.org/support/topic/error-message-is_a-deprecated-please-use-the-instanceof-operator
     */
    public static function set_handlers() {
        set_error_handler(array(__CLASS__,'farreaches_error_handler'), E_ERROR | E_CORE_ERROR | E_COMPILE_ERROR | E_RECOVERABLE_ERROR);
    }
    /**
     * Used to report error conditions. and restore_error_handler
     *
     * @param Exception $exception - if null then just call restore_error_handler()
     */
    public static function error_recovery(Exception $exception = null, $context_information = '') {
        if ( $exception != null) {
            global $farreaches_timing_array;

            $output = array(
                    'context_information' => $context_information,
                    'error_message' => $exception->getMessage(),
                    // getTraceAsString() trims the interesting parts of the stack trace.
                    'stacktrace' => self::stacktrace($exception),
                    // TODO : remove this dependency on FarReaches_Diagnostics
                    'diagnostics_data' => self::get_minimum_diagnostics_data(true),
                    'timings' => $farreaches_timing_array);
            //Not using out json service here, so the wrapper code is not subject to any errors in the farreaches-json.
            $log_message = var_export($output, true);
            self::fatal_log($log_message);
        } else {
            $log_message = null;
        }
        restore_error_handler();
        return $log_message;
    }

    private static function get_error_log_name() {
        return FARREACHES_LOG_DIRECTORY . '/error.log';
    }

    public static function email_log_if_larger($size) {
        $filename = self::get_error_log_name();
        if (filesize($filename) >= $size) {
            self::email_log();
        }
    }
    public static function email_log() {
        $filename = self::get_error_log_name();
        $error_log_contents = file_get_contents($filename);
        self::emergency_error_email($error_log_contents);
        unlink($filename);
    }
    private static function emergency_error_email($message) {
        if ( self::is_wordpress_version_allowed() && !empty($message)) {
            // if the wordpress version is too old, it is likely that the error is an incompatibility and not interesting.
            $to = FARREACHES_AUTOERROR_EMAIL_ADDRESS;
            $email_address_set = !empty($to)
                                    //Not on tests. We do not filter files for tests yet, so all those constansts start with @ on test run.
                                    //FIXME enable filtering for tests.
                                    && $to[0] != '@';
            if ($email_address_set) {
                try {
                    $subject = self::get_standard_email_subject();
                    // wp_mail does wordpress filtering - so this may be broken.
                    if ( false === wp_mail( $to, $subject, $message) ) {
                        // send message via @error_log just in case wp_mail is broken
                        @error_log($message, 1, $to, "Subject:". $subject);
                    }
                } catch(Exception $exception) {
                    // trap/ignore any errors while trying to report errors.
                    self::error_log('could not email log:' . $exception->getMessage());
                }
            }
        }
    }

    public static function get_standard_email_subject() {
        if ( !isset(self::$standard_email_subject)) {
            self::$standard_email_subject = sprintf("%s(%s,%s,%s,%s): error ",  site_url(), FARREACHES_PLUGIN_NAME, FARREACHES_PLUGIN_VERSION, self::get_wordpress_version(), PHP_VERSION);
        }
        return self::$standard_email_subject;
    }

    /**
     * The logs are in a subdirectory so that the plugin directory itself doesn't have to be writable ( security )
     */
    public static function create_logs_directory_if_needed() {
        if ( !file_exists(FARREACHES_LOG_DIRECTORY)) {
            mkdir(FARREACHES_LOG_DIRECTORY, 0777, true);
        } else if ( !is_writable(FARREACHES_LOG_DIRECTORY)) {
            chmod(FARREACHES_LOG_DIRECTORY, 0777);
        }
    }

    public static function is_log_writable() {
        if ( !isset(self::$log_file_writable)) {
            self::create_logs_directory_if_needed();
            $filename = self::get_error_log_name();
            if (file_exists($filename)) {
                self::$log_file_writable = is_writable($filename);
            } else {
                self::$log_file_writable = is_writable(FARREACHES_LOG_DIRECTORY);
            }
        }
        return self::$log_file_writable;
    }

    public static function check_log_size($private_log) {
        if ( file_exists($private_log) && filesize($private_log) > FARREACHES_LOG_SIZE) {
            @unlink($private_log);
        }
    }

    /**
     * Whenever possible
     * @param unknown $message
     */
    public static function debug_log($message) {
        self::_log("Error: " . $message);
    }
    /**
     * log to a log file.
     * @param unknown $message
     */
    public static function error_log($message) {
        self::_log("Error: " . $message);
    }

    public static function fatal_log($message) {
        self::_log("FATAL: " . $message);
        //Kostya: Commented out since sending email on main thread may kill performance.
        //Emails only to be sent out on explicit user request OR in a cron job.
        //self::email_log();
    }

    private static function _log($message) {
        $private_log = self::get_error_log_name();
        // error log in social marketing directory.

        if (self::is_log_writable()) {
            if (!isset(self::$log_file_size_checked)) {
                // only once / request do we check so a single request's log is more likely to be complete
                self::check_log_size($private_log);
                self::$log_file_size_checked = true;
            }
            $file_log_message = sprintf("%s : %s\n",
                    date('D, d M Y H:i:s T'),
                    $message);
            @error_log($file_log_message, 3, $private_log);
        }
    }
    /**
     * @return log contents (log file size is limited to lowish value)
     */
    public static function get_private_log_contents() {
        $private_log = self::get_error_log_name();
        if ( file_exists($private_log) && is_readable($private_log)) {
            return @file_get_contents($private_log);
        } else {
            return '';
        }
    }
    /**
     * get the minimum environmental data for the customer environment.
     * @param string $include_request_information
     * @return multitype:multitype: NULL
     */
    public static function get_minimum_diagnostics_data($include_request_information = false) {
        global $current_user;
        $diagnostics_data = array('rows' => array(), 'tables' => array());

        $wordpress_version = get_bloginfo('version');
        self::add_diagnostic_row($diagnostics_data, 'Wordpress version', $wordpress_version, $wordpress_version >= FARREACHES_WP_MINIMUM ? 'ok' : 'error', "Your wordpress version (" . $wordpress_version . ") is older then wordpress required minimum. You need to install wordpress " . FARREACHES_WP_MINIMUM . " or newer.");

        // Do not check for php minimum - wordpress does that for us. see update-core.php
        $php_version = phpversion();
        self::add_diagnostic_row($diagnostics_data, 'PHP version', $php_version);

        $wordpress_url = site_url();
        self::add_diagnostic_row($diagnostics_data, 'Wordpress URL', $wordpress_url, strpos($wordpress_url, '.') ? 'ok':'error', "Your wordpress is configured to serve on localhost address (or is specifying a ip address rather than a domain). Farreach.es server can't talk to localhost addresses. Please update your wordpress configuration.");

        $plugin_version = FARREACHES_PLUGIN_VERSION;
        // Display last time version was checked with wordpress version checking code ( see farreaches-autoupdate.php )
        //Advice user to update, if needed.
        self::add_diagnostic_row($diagnostics_data, 'Plugin version', $plugin_version);

        // report about the current user
        self::add_diagnostic_row($diagnostics_data, 'Current User', $current_user->ID);
        self::add_diagnostic_row($diagnostics_data, 'Current User Email', $current_user->user_email);
        self::add_diagnostic_row($diagnostics_data, 'Admin Email', get_option('admin_email'));

        self::add_diagnostic_row($diagnostics_data, 'active plugins', implode(", ", get_option('active_plugins')));

        if ($include_request_information) {
            $diagnostics_data['request_headers'] = self::getallheaders();
        }

        return $diagnostics_data;
    }

    public static function add_diagnostic_row(&$diagnostics_data, $name = 'Name not set', $value = 'No value', $status = 'ok', $message = null) {
        $data_row = array('name' => $name, 'value' => $value, 'status' => $status);
        $show_message = $status != 'ok' && !empty($message);
        if ($show_message) {
            $data_row['message'] = $message;
        } else {
            $data_row['message'] = '';
        }
        $diagnostics_data['rows'][] = $data_row;
    }

    /**
     * This one is needed for when PHP is not installed as apache module (e.g. is running on ngnix);
     * in this case core PHP getallheaders() is not available.
     * See https://forums.digitalpoint.com/threads/fatal-error-call-to-undefined-function-getallheaders.32827/ for more details.
     */
    private static function getallheaders() {
        $headers = '';
        foreach ($_SERVER as $name => $value)
        {
            if (substr($name, 0, 5) == 'HTTP_') {
                $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
            }
        }
        return $headers;
    }

    /**
     * $parameter_1 : some message
     * $parameter_2 : debug_backtrace() but can be omitted if the current location is to be returned
     */
    public static function stacktrace($parameter_1 =null, $parameter_2 = null) {
        $collapsed = array();
        if ( $parameter_1 instanceof Exception) {
            $collapsed[] = $parameter_1->getMessage();
            $stack = $parameter_1->getTrace();
        } else if (!isset($parameter_2)) {
            $collapsed[] = $parameter_1;
            $stack = array_slice(debug_backtrace(), 1);
        } else if ( $parameter_2 instanceof Exception) {
            $collapsed[] = $parameter_1;
            $collapsed[] = $parameter_2->getMessage();
            $stack = $parameter_2->getTrace();
        }
        foreach ($stack as $stackline) {

            if (isset($stackline['file'])) {
                $out = sprintf("\t%s line %d : ", $stackline['file'], $stackline['line']);
            } else {
                $out = "\t";
            }
            if (isset($stackline['class'])) {
                $out .= $stackline['class'] . '::';
            }
            $collapsed[] = $out . $stackline['function'];
        }
        return implode($collapsed, "<br />\n");
    }
}

// used to help track down timeout
global $farreaches_timing_array;
$farreaches_timing_array = array();
