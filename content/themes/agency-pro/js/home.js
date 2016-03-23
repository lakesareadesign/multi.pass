jQuery(function( $ ){

    $.localScroll({
    	duration: 900
    });
    
	function fade_home_top() {
		if ( $(window).width() > 800 ) {
			window_scroll = $(this).scrollTop();
	   		$( ".home-top" ).css({
				  'opacity' : 1-(window_scroll/300)
	    	});
		} else {
			$( ".home-top" ).css({
				'opacity' : 1
			});
		}
	}
	$(window).scroll(function() { fade_home_top(); });

	//Allow images to work on all mobile devices
	if ( $(window).width() >= 480 ) {
		$( ".home-middle .featuredpost a.aligncenter,.home-middle .featuredpost a.alignleft, .home-middle .featuredpost a.alignright, .home-middle .featuredpost a.alignnone").on( "touchend orientationchange", function (e) {
			"use strict";
			var link = $(this);
			if ( link.hasClass( "hover" ) ) {
				return true;
			} else {
				link.addClass( "hover" );
				$( ".home-middle .featuredpost a.aligncenter,.home-middle .featuredpost a.alignleft, .home-middle .featuredpost a.alignright, .home-middle .featuredpost a.alignnone").not(this).removeClass( "hover" );
				e.preventDefault();
				return false; //extra, and to make sure the function has consistent return points
			}
		});
	}
	
	//Add Keyboard Accessibility
	$( ".home-middle .featuredpost .entry *" )
	.focus( function() {
		$(this).closest( ".entry" ).addClass( "focused" );
	})
	.blur( function() {
		$(this).closest( ".entry" ).removeClass( "focused" );
	});
	
});

