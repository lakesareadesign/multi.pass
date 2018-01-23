<?php
/**
 * Sets up deprecated support.
 *
 * @since 1.4.0
 */

defined( 'ABSPATH' ) || die();

add_action( 'after_setup_theme', 'rbm_fh_deprecated_support' );

/**
 * Creates a new RBM_FieldHelpers instance if the deprecated support is enabled.
 *
 * @since 1.4.0
 * @access private
 */
function rbm_fh_deprecated_support() {

	if ( ! defined( 'RBM_FH_DEPRECATED_SUPPORT' ) || RBM_FH_DEPRECATED_SUPPORT !== true ) {

		return;
	}

	global $rbm_fh_deprecated_support;

	$rbm_fh_deprecated_support = new RBM_FieldHelpers();
}