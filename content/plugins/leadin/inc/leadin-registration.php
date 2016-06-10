<?php
if (!defined('LEADIN_PLUGIN_VERSION')) {
    header('HTTP/1.0 403 Forbidden');
    wp_die();
}

if (is_admin()) {
    add_action('wp_ajax_leadin_registration_ajax', 'leadin_registration_ajax'); // Call when user logged in
}

function leadin_registration_ajax()
{
    $existingPortalId = get_option('leadin_portalId');
    $existingHapikey = get_option('leadin_hapikey');

    if (!empty($existingPortalId) || !empty($existingHapikey)) {
        header('HTTP/1.0 400 Bad Request');
        wp_die('{"error": "Registration is already complete for this portal"}');
    }

    $data = json_decode(file_get_contents('php://input'), true);

    $newPortalId = $data['portalId'];
    $newHapiKey = $data['hapikey'];
    $slumberMode = $data['slumberMode'];

    error_log($data['hapikey']);

    if (empty($newPortalId) OR (empty($newHapiKey) AND empty($slumberMode))) {
        error_log("Registration error");
        header('HTTP/1.0 400 Bad Request');
        wp_die('{"error": "Registration missing required fields"}');
    }

    add_option('leadin_portalId', $newPortalId);

    if (!empty($newHapiKey)) {
        add_option('leadin_hapikey', $newHapiKey);
    }
    if (!empty($slumberMode)) {
        add_option('leadin_slumber_mode', $slumberMode);
    }

    wp_die('{"message": "Success!"}');
}

?>