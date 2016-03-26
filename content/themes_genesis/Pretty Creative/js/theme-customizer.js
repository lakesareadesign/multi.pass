(function( $ ) {
	"use strict";

	// Home Top Background Image - Image Control
	wp.customize( 'pc_home_top_background_image', function( value ) {
		value.bind( function( to ) {
			$( '.home-top' ).css( 'background-image', 'url( ' + to + ')' );
		} );
	});


})( jQuery );