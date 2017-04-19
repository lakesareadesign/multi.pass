jQuery( function ( $ ) {

	// Add header class to body after 10px
	$(window).bind( 'load scroll', function() {

		if ( $(window).scrollTop() > 10 ) {

			$( 'body' ).addClass( 'header-scroll' );

		} else {

			$( 'body' ).removeClass( 'header-scroll' );

		}

	});

	$( 'div[class^="front-page-"] a[href*=#]:not([href=#])' ).click(function() {

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

});
