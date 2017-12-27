/**
 * This script adds basic features to the Academy Pro theme.
 *
 * @package Academy\JS
 * @author StudioPress
 * @license GPL-2.0+
 */

 // Add Keyboard Accessibility.
(function($) {

 	$( '.content .entry *' )
 	.focus( function() {
 		$(this).closest( '.entry' ).addClass( 'focused' );
 	})
 	.blur( function() {
 		$(this).closest( '.entry' ).removeClass( 'focused' );
 	});

})(jQuery);
