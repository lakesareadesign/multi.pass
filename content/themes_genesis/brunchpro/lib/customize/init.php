<?php
/**
 * Set up and include all necessary customizer files.
 *
 * @package   BrunchPro\Functions\Customizer
 * @copyright Copyright (c) 2017, Feast Design Co.
 * @license   GPL-2.0+
 * @since     1.0.0
 */

defined( 'WPINC' ) || die;

require_once BRUNCH_PRO_DIR . 'lib/customize/lib/init.php';
require_once BRUNCH_PRO_DIR . 'lib/customize/defaults.php';
require_once BRUNCH_PRO_DIR . 'lib/customize/display.php';
require_once BRUNCH_PRO_DIR . 'lib/customize/helpers.php';

if ( genesis_is_customizer() ) {
	require_once BRUNCH_PRO_DIR . 'lib/customize/settings.php';
}
