<?php
/**
 * Manage tweaks for modules
 */

/**
 * We check for current screen, because on the Dashboard page we need to ignore files without original_size
 * parameter. If we include them there are two notices in the error log.
 * On the Minification dedicated page we include files without sizes.
 */
add_filter( 'wphb_minification_display_enqueued_file', 'wphb_minification_hooks_hide_jquery_switchers', 10, 3 );
function wphb_minification_hooks_hide_jquery_switchers( $display, $handle, $type ) {

	if ( 'toplevel_page_wphb' === get_current_screen()->id ) {
		if ( ( 'scripts' === $type && 'jquery' === $handle['handle'] ) || ( ! isset( $handle['original_size'] ) ) ) {
			return false;
		}
	} else {
		if ( 'scripts' === $type && 'jquery' === $handle['handle'] ) {
			return false;
		}
	}


	return $display;
}