(function( $ ){

	// Sticky Announcement Bar.
	var headerHeight       = $( '.site-header' ).innerHeight();
	var beforeheaderHeight = $( '.before-header' ).outerHeight();
	var abovenavHeight     = headerHeight + beforeheaderHeight - 1;

	$( window ).scroll( function() {

		if ( $( document ).scrollTop() > abovenavHeight ) {

			$( '.announcement-widget' ).addClass( 'fixed' );

		} else {

			$( '.announcement-widget' ).removeClass( 'fixed' );

		}

	});

})( jQuery );
