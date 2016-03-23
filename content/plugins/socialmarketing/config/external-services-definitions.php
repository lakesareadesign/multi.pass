<?php

/**
 * External Service Definitions define the external services (i.e. facebook, twitter, etc. ) that a post may be sent to.
 * The definitions are hard-coded because:
 *
 *    1) services are added infrequently,
 *    2) updating from server takes additional effort,
 *    3) we are maintaining plugin
 *
 * In future, this will update from the farreach.es server (push). FarReach.es server will *add* to the list.
 *
 * Post formats are too fragile. See the wordpress code(post.php line 197) the edit_post() function checks to see if the current theme supports post-formats and the selected post-format.
 * This means that a user testing a new theme could break their wordpress-farreach.es configuration.
 */
return array(
    array(
        // Here we keep only attributes inherent to external services like their features or hyperlinks.
        // No presentation-related attributes like 'css_class_name' should be defined here.
        'name' => 'facebook.com',
        'service_name' => 'Facebook',
    ),

    array(
        'name' => 'twitter.com',
        'service_name' => 'Twitter',
    ),

    array(
        'name' => 'tumblr.com',
        'service_name' => 'Tumblr',
    )

);