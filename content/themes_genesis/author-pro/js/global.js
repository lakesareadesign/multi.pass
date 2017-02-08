/**
 * This script adds the jquery effects to the Author Pro Theme.
 *
 * @package Author\JS
 * @author StudioPress
 * @license GPL-2.0+
 */

( function ( document, $ ) {

	'use strict';

	function _shrinkClass() {

		if ( $( document ).scrollTop() > 0 && ( $( '.genesis-responsive-menu' ).css( 'position' ) !== 'relative' ) ) {
			$( '.site-header' ).addClass( 'shrink' );
			$( '.nav-secondary' ).addClass( 'shrink' );
		} else {
			$( '.site-header' ).removeClass( 'shrink' );
			$( '.nav-secondary' ).removeClass( 'shrink' );
		}

	}

	function _fixedClass() {
		var distanceFromTop = $( document ).scrollTop();
		if ( distanceFromTop >= $( '.front-page-1' ).height() + 40 && ( $( '.js nav' ).css( 'position' ) !== 'relative' ) ) {
			$( '.nav-secondary' ).addClass( 'fixed' );
		} else {
			$( '.nav-secondary' ).removeClass( 'fixed' );
		}
	}

	function _adjustNavLocations( primary, secondary ) {
		var mobileActive  = $( '.menu-toggle' ).is( ':visible' );
		if ( primary.length == 0 && secondary.length > 0 && mobileActive ) {
			secondary.insertAfter( '.title-area' );
		} else if ( primary.length == 0 && secondary.length > 0 && ! mobileActive ) {
			secondary.insertBefore( '.content-sidebar-wrap' );
		}
	}

	$( document ).ready( function () {

		// Reposition the secondary navigation on mobile if necessary.
		var $primaryNav      = $( '.nav-primary' ),
			$secondaryNav    = $( '.nav-secondary, #genesis-mobile-nav-secondary' );

		if ( $primaryNav.length == 0 && $secondaryNav.length > 0 ) {
			$( window ).on( 'resize.moveNavs', function() {
				_adjustNavLocations( $primaryNav, $secondaryNav );
			}).trigger( 'resize.moveNavs' );
		}

		// Load match height for content-sidebar layouts.
		var $body = $('body');
		if ( $body.hasClass( 'content-sidebar' ) || $body.hasClass( 'sidebar-content' ) ) {
			$( '.content, .sidebar' ).matchHeight({
				property: 'min-height'
			});
		}

		// Run test on initial page load.
		_shrinkClass();

		// Run test on resize of the window.
		$( window ).resize( _shrinkClass );
		$( window ).resize( _fixedClass );

		// Run test on scroll.
		$( document ).on( 'scroll', _shrinkClass );

		// Add class for secondary menu.
		$(	window	).scroll( _fixedClass );

	});

})( document, jQuery );
