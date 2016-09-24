jQuery(function( $ ){

	// Show sticky message after 200px
	$( document ).on( 'scroll', function() {

		if( $( document ).scrollTop() > 200 ) {

			$( '.sticky-message' ).fadeIn();

		} else {

			$( '.sticky-message' ).fadeOut();

		}

	});

	return $('.dismiss').on('click', function() {
		$( '.sticky-message' ).remove();
	});

});