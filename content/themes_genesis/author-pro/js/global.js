( function ( document, $ ) {

	'use strict';

	function _shrinkClass() {
		
		if ( $( document ).scrollTop() > 0 && ( $( '.js nav' ).css( 'position' ) !== 'relative' ) ) {
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

	$( document ).ready( function () {

		// run test on initial page load
		_shrinkClass();

		// run test on resize of the window
		$( window ).resize( _shrinkClass );
		$( window ).resize( _fixedClass );
		
		//run test on scroll
		$( document ).on( 'scroll', _shrinkClass );

		// Add class for secondary menu
		$(	window	).scroll( _fixedClass );

	});
	
})( document, jQuery );