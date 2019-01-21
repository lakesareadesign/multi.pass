/**
 * This script adds the entry date to the Magazine Pro theme.
 *
 * @package Magazine\JS
 * @author StudioPress
 * @license GPL-2.0-or-later
 */

jQuery(function( $ ){

	// Add js body class.
	$('body').addClass('js');

	// Find time for each entry and move it inside the image link.
	$('.home-middle article, .home-top article').each(function(){
		var $time = $(this).find('.entry-time');

		$(this).find('a.alignleft, a.alignnone, a.alignright').append($time);

	});

});