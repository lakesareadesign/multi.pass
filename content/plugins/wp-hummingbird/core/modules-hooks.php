<?php
/**
 * Manage tweaks for modules
 */

add_filter( 'wphb_minification_display_enqueued_file', 'wphb_minification_hooks_hide_jquery_switchers', 10, 3 );
function wphb_minification_hooks_hide_jquery_switchers( $display, $handle, $type ) {
	if ( 'scripts' === $type && 'jquery' === $handle['handle'] ) {
		return false;
	}

	return $display;
}