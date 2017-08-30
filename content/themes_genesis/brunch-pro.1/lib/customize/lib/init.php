<?php
/**
 * Set up and include all necessary library files.
 *
 * @package FeastcoCustomizer
 */

defined( 'WPINC' ) || die;

/**
 * The absolute path to library's root directory with a trailing slash.
 *
 * @since 1.0.0
 * @uses  get_template_directory()
 * @uses  trailingslashit()
 */
define( 'FEASTCO_CUSTOMIZER_VERSION', '1.0.0' );

/**
 * The absolute path to library's root directory with a trailing slash.
 *
 * @since 1.0.0
 * @uses  get_template_directory()
 * @uses  trailingslashit()
 */
define( 'FEASTCO_CUSTOMIZER_DIR', trailingslashit( dirname( __FILE__ ) ) );

require_once FEASTCO_CUSTOMIZER_DIR . 'class-options.php';
require_once FEASTCO_CUSTOMIZER_DIR . 'class-styles.php';
require_once FEASTCO_CUSTOMIZER_DIR . 'fonts.php';
require_once FEASTCO_CUSTOMIZER_DIR . 'utilities.php';
require_once FEASTCO_CUSTOMIZER_DIR . 'interface.php';
require_once FEASTCO_CUSTOMIZER_DIR . 'sanitization.php';
