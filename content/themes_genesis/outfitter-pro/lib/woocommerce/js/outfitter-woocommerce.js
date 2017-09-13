/**
 * This script adds the WooCommerce jquery effects to the Outfitter Pro theme.
 *
 * @package Outfitter_Pro\JS
 * @author StudioPress
 * @license GPL-2.0+
 */

( function($) {

	var $body        = $( 'body' ),
		$content     = $( '.off-screen-cart' ),
		sOpen        = false;

	$(document).ready(function() {

		// Toggles the off-screen cart content on click.
		$( '.toggle-off-screen-cart' ).click(function() {
			__toggleOffscreenCartContent();
		});

	});

	// Toggles the off-screen cart content.
	function __toggleOffscreenCartContent() {

		if (sOpen) {
			$content.fadeOut();
			$body.toggleClass( 'no-scroll' );
			sOpen = false;
		} else {
			$content.fadeIn();
			$body.toggleClass( 'no-scroll' );
			sOpen = true;
		}

	}

	// Toggles second product image.
	$( 'ul.products li.product-has-gallery' ).hover( function() {

		$( this ).find( '.wp-post-image' ).removeClass( 'fadeIn' ).addClass( 'fadeOut' );
		$( this ).find( '.secondary-image' ).removeClass( 'fadeOut' ).addClass( 'fadeIn' );

	}, function() {

		$( this ).find( '.wp-post-image' ).removeClass( 'fadeOut' ).addClass( 'fadeIn' );
		$( this ).find( '.secondary-image' ).removeClass( 'fadeIn' ).addClass( 'fadeOut' );

	});

	// Show product details on mobile devices.
	$( '.woocommerce-LoopProduct-link' ).on( 'touchend orientationchange', function (e) {
		'use strict';
		var link = $(this);
		if ( link.hasClass( 'hover' ) ) {
			return true;
		} else {
			link.addClass( 'hover' );
			link.find( '.wp-post-image' ).removeClass( 'fadeIn' ).addClass( 'fadeOut' );
			link.find( '.secondary-image' ).removeClass( 'fadeOut' ).addClass( 'fadeIn' );
			$( '.woocommerce-LoopProduct-link' ).not(this).removeClass( 'hover' );
			$( '.woocommerce-LoopProduct-link' ).not(this).find( '.wp-post-image' ).removeClass( 'fadeOut' ).addClass( 'fadeIn' );
			$( '.woocommerce-LoopProduct-link' ).not(this).find( '.secondary-image' ).removeClass( 'fadeIn' ).addClass( 'fadeOut' );
			e.preventDefault();
			return false; // Extra, and to make sure the function has consistent return points.
		}
	});

	// Add Keyboard Accessibility to product focus.
	$( '.woocommerce ul.products *' )
	.focus( function() {
		$(this).closest( '.product' ).addClass( 'focused' );
		$(this).closest( '.product' ).find( '.wp-post-image' ).removeClass( 'fadeIn' ).addClass( 'fadeOut' );
		$(this).closest( '.product' ).find( '.secondary-image' ).removeClass( 'fadeOut' ).addClass( 'fadeIn' );
	})
	.blur( function() {
		$(this).closest( '.product' ).removeClass( 'focused' );
		$(this).closest( '.product' ).find( '.wp-post-image' ).removeClass( 'fadeOut' ).addClass( 'fadeIn' );
		$(this).closest( '.product' ).find( '.secondary-image' ).removeClass( 'fadeIn' ).addClass( 'fadeOut' );
	});

})(jQuery);
