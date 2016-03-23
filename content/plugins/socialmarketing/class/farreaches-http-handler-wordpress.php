<?php
/**
 * Wrapper around very lowest level of http to make it easy to mock or log.
 * TODO: add logging ability.
 * @author patmoore
 *
 */
class FarReaches_Http_Handler_Wordpress implements FarReaches_Http_Handler {

    private $log_file;

    private static $log_file_size_checked;

    public function __construct($log_file = null) {
        $this->log_file = $log_file;
    }
    function http_post($full_api_uri, $http_args) {
        $response = @wp_remote_post($full_api_uri, $http_args);
        if ( !is_null($this->log_file) && (is_writeable($this->log_file) || (!file_exists($this->log_file) && is_writeable(dirname($this->log_file))))) {
            FarReaches_Error_Management::create_logs_directory_if_needed();
            $message = var_export(array(FarReaches_Http_Handler::FULL_API_URI => $full_api_uri,
                    FarReaches_Http_Handler::HTTP_ARGS => $http_args,
                    FarReaches_Http_Handler::RESPONSE => $response), true) . ",\n";
            if (!isset(self::$log_file_size_checked)) {
                FarReaches_Error_Management::check_log_size($this->log_file);
                self::$log_file_size_checked = true;
            }
            @error_log($message, 3, $this->log_file);
        }
        return $response;
    }
    function http_get($full_api_uri, $http_args = null) {
        $response = @wp_remote_get($full_api_uri, $http_args);
        return $response;
    }

    function nonce() {
        // $nonce should NOT be a wp_nonce object for these reasons:
        // 1) WP Nonces are not random in common meaning of this word (this is the cause why swiched to the current solution).
        // For example, wp_create_nonce('action1') for one blog user will return same values now and ten minutes after.
        // 2) WP Nonces are not stored anywhere, they are just hashes.
        // 3) WP Nonces don't get invalidated. They are invalidated by time only (24 hours with default WP settings).
        $nonce = uniqid("fr", true);
        return $nonce;
    }
}