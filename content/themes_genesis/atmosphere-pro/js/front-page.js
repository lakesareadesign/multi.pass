/**
 * This script adds the jquery effects to the front page of the Atmosphere Pro Theme.
 *
 * @package Atmosphere\JS
 * @author StudioPress
 * @license GPL-2.0+
 */

jQuery(function( $ ){

	// Set front page 1 height.
	var windowHeight = $( window ).height() - 77;

	$( '.front-page-1' ) .css({'height': windowHeight +'px'});

	$( window ).resize(function(){

		var windowHeight = $( window ).height();

		$( '.front-page-1' ) .css({'height': windowHeight +'px'});

	});

	// Scroll to target function.
	$( '.front-page-1 a[href*=#]:not([href=#])' ).click(function() {

		if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {

			var target = $(this.hash);
			target = target.length ? target : $( '[name=' + this.hash.slice(1) + ']' );

			if (target.length) {

				$( 'html,body' ).animate({
					scrollTop: target.offset().top
				}, 750 );

				return false;

			}
		}

	});

});
