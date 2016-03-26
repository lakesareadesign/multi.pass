jQuery(function( $ ){

	// Show sticky message after 100px
	$( document ).on( 'scroll', function() {

		if( $( document ).scrollTop() > 100 ) {

			$( '.sticky-message' ).fadeIn();

		} else {

			$( '.sticky-message' ).fadeOut();

		}

	});

});