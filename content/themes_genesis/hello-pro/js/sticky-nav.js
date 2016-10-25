jQuery(document).ready(function($) {

	// Set margin-top on .site-inner
	function siteInnerTopMargin(){
		var navHeight = $('.site-header').outerHeight();

		// If Primary Nav is being used, apply top margin to that
		if ( $( "nav.nav-primary" ).length ) {
			$( "nav.nav-primary" ).css("margin-top", navHeight);
		}else{
			// otherwise apply top margin to .site-inner div
			$('.site-inner').css("margin-top", navHeight);
		}

	}
	siteInnerTopMargin();



	// Optimization: Store the references outside the event handler:
	var $window = $(window);


	/* // STICKY NAV // */
	// Do sticky nav on smartscroll
	jQuery(window).smartscroll(function(e){

		var windowsize = $window.width();
		if (windowsize > 800) {
			//sticky nav


			var elemHeight = $('.site-header').outerHeight() + 20;

			var scroll = $(window).scrollTop();

			if (scroll >= elemHeight) {
				$(".site-header").addClass("sticky");

				setTimeout(function() {
					$(".site-header").addClass("active");
				});

			} else {
				$(".site-header").removeClass("sticky").removeClass("active");
			}

		}else{
			//no sticky nav on mobile
		}

	});

	// Execute functions on smartresize
	jQuery(window).smartresize(function(e){
		siteInnerTopMargin();
	});


});
