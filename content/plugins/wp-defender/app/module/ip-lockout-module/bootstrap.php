<?php
/**
 * Author: Hoang Ngo
 */

require wp_defender()->get_plugin_path() . 'vendors/email-search.php';

new WP_Defender\IP_Lockout\Controller\Lockout_Controller();