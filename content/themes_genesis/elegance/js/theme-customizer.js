(function( $ ) {
	"use strict";

	// cta Background Image - Image Control
	wp.customize( 'cta_background_image_setting', function( value ) {
		value.bind( function( to ) {
			$( '.cta-widget' ).css( 'background-image', 'url( ' + to + ')' );
		} );
	});

	// cta Background Image Repeat - Checkbox
	wp.customize( 'cta_background_image_repeat_setting', function( value ) {
		value.bind( function( to ) {
			$( '.cta-widget' ).css( 'background-repeat', true === to ? 'repeat' : 'no-repeat' );
		} );
	} );

	// cta Background Image Size - Checkbox
	wp.customize( 'cta_background_image_size_setting', function( value ) {
		value.bind( function( to ) {
			$( '.cta-widget' ).css( 'background-size', true === to ? '100%' : 'auto auto' );
		} );
	} );

})( jQuery );