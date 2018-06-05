/**
 * Essence Pro.
 *
 * This file adds the Customizer Live Preview additions to the Essence Pro Theme.
 *
 * @package Essence
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    https://my.studiopress.com/themes/essence/
 */
(function($, wp) {
    "use strict";

    var $globalCSS = $('<style id="essence-custom-css" type="text/css" /></style>'),
        css = {};

    $(document).ready(function() {
        $('head').append( $globalCSS );
    }).on( 'essence-cssRefresh', function() { printGlobalCSS(css); });

})(jQuery, wp);
