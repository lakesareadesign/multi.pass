(function($) {

	$(window).load( function() {
		$( window ).resize( function() {

			$( '.flexible-widgets .featuredpage:nth-child(odd), .flexible-widgets .widget_text:nth-child(odd)' ).each( function(){

				media_widget_height = $(this).next( '.widget_media_image' ).outerHeight();
				text_widget_height = $(this).outerHeight();

				if( media_widget_height && ( media_widget_height > text_widget_height ) ) {
					$(this).css({ "top": ( ( media_widget_height - text_widget_height) / 2 ) + "px" });
				}

			});

			$( '.flexible-widgets .featuredpage:nth-child(even), .flexible-widgets .widget_text:nth-child(even)' ).each( function(){

				media_widget_height = $(this).prev( '.widget_media_image' ).outerHeight();
				text_widget_height = $(this).outerHeight();

				if( media_widget_height && ( media_widget_height > text_widget_height ) ) {
					$(this).css({ "top": ( ( media_widget_height - text_widget_height) / 2 ) + "px" });
				}

			});

		}).resize();
	});

})(jQuery);
