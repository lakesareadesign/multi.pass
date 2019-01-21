/**
 * This script adds the jquery effects to the front page of the Infinity Pro Theme.
 *
 * @package Infinity\JS
 * @author StudioPress
 * @license GPL-2.0+
 */

// Fadeup effect for front page sections.
(function( $ ) {

	// Make sure JS is enabled.
	document.documentElement.className = 'js';

	$(document).ready(function() {

		$( 'div[class^="front-page-"] a[href*="#"]:not([href="#"])' ).click(function() {

			if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {

				var target = $(this.hash);
				target = target.length ? target : $( '[name=' + this.hash.slice(1) + ']' );

				if (target.length) {

					$( 'html,body' ).animate({
						scrollTop: target.offset().top
					}, 1000);

					return false;

				}
			}

		});

		// Run 0.25 seconds after document ready for any instances viewable on load.
		setTimeout(function() {
			animateObject();
		}, 250);

	});

	$(window).scroll(function() {

		// Run on scroll.
		animateObject();

	});

	function animateObject() {

		// Define object via class.
		var object = $( '.fadeup-effect' );

		// Loop through each object in the array.
		$.each(object, function() {

			var windowHeight = $(window).height(),
				offset = $(this).offset().top,
				top = offset - $(document).scrollTop(),
				percent = Math.floor(top / windowHeight * 100);


			if (percent < 80) {

				$(this).addClass( 'fadeInUp' );

			}

		});

	}

	$(window).on('resize.genesisMenu', function() {

		if ( ( 'relative' !== $( '.js .nav-primary' ).css( 'position' ) ) ) {
			var headerHeight = $( '.site-header' ).height();
			$( '.front-page .front-page-1' ).css( 'padding-top', headerHeight+'px' );
		} else {
			$( '.front-page .front-page-1' ).removeAttr( 'style' );
		}

	});

	// Allow images to work on all mobile devices.
	$( '.featuredpage .team-member .entry-header a' ).on( 'touchend orientationchange', function (e) {
		'use strict';
		var link = $(this);
		if ( link.hasClass( 'hover' ) ) {
			return true;
		} else {
			link.addClass( 'hover' );
			$( '.featuredpage .team-member .entry-header a' ).not(this).removeClass( 'hover' );
			e.preventDefault();
			return false; // Extra, and to make sure the function has consistent return points.
		}
	});


	// Add Keyboard Accessibility.
	$( '.featuredpage .team-member.entry *' )
	.focus( function() {
		$(this).closest( '.entry' ).addClass( 'focused' );
	})
	.blur( function() {
		$(this).closest( '.entry' ).removeClass( 'focused' );
	});

	$( '.front-page-6 .featuredpage .entry-content' ).prev( '.entry-header' ).addClass( 'position-top' );

})( jQuery );
