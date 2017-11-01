/**
 * Authority Pro.
 *
 * This file adds the Customizer Live Preview additions to the Authority Pro Theme.
 *
 * @package Authority
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    https://my.studiopress.com/themes/authority/
 */
(function($, wp) {
	"use strict";

	var $globalCSS = $('<style id="authority-custom-css" type="text/css" /></style>'),
		css = {};

	$(document).ready(function() {
		$('head').append( $globalCSS );
	}).on( 'authority-cssRefresh', function() { printGlobalCSS(css); });

})(jQuery, wp);
