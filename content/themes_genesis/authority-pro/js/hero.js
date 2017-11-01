(function($) {

	$(window).load( function() {
		$( window ).resize( function() {

			if( $( '.hero-section' ).hasClass( 'has-columns' ) ) {

				hero_left_height = $( '.hero-section-column.left' ).outerHeight();
				hero_right_height = $( '.hero-section-column.right' ).outerHeight();

				if( hero_right_height > hero_left_height ) {
					$( '.hero-section-column.left' ).css({ "top": ( ( hero_right_height - hero_left_height) / 2 ) + "px" });
				}

			}

		}).resize();
	});

})(jQuery);
