(function($) {
	/**
	 * Extra JS for the Theme Two theme
	 *
	 * 1. positions the different elements:
	 *    - arrows
	 *    - dots
	 *    - caption
	 *    - filmstrip
	 */

	 // metaslider has been initilalised
 	$(document).on('metaslider/initialized', function(e, identifier) {
 		// if .ms-theme-architekt
 		if ($(identifier).closest('.metaslider.ms-theme-theme-two').length) {
 			var $slider = $(identifier);
 			var $container = $(identifier).closest('.metaslider.ms-theme-theme-two');
 			var captions = $slider.find('.caption');
 			if (captions.length) {
 				$container.addClass('ms-has-caption');
 			}
 			$container.addClass('ms-loaded');
 		}

		// Wrap nav and arrows in a div
		
		// When Dots
		$(".metaslider.ms-theme-theme-two:not(.has-carousel-mode) .flexslider:not(.filmstrip) > .flex-control-paging, .metaslider.ms-theme-theme-two:not(.has-carousel-mode) .flexslider:not(.filmstrip) > .flex-direction-nav").wrapAll("<div class='slide-control'></div>");

		// When Carousel   
		$(".metaslider.ms-theme-theme-two.has-carousel-mode .flexslider > .flex-control-paging").wrap("<div class='slide-control'></div>");

		// When Thumnbnails
		$(".metaslider.ms-theme-theme-two .flexslider > .flex-control-thumbs").each(function(index) {
			$(this).next(".flex-direction-nav").wrapAll("<div class='slide-control'></div>")
		  });
		  
		// When Filmstrip
		$(".metaslider.ms-theme-theme-two.has-filmstrip-nav .flexslider:not(.filmstrip) > .flex-direction-nav").wrap("<div class='slide-control'></div>");

		// Nivo with dots
		$(".metaslider.ms-theme-theme-two:not(.has-carousel-mode).metaslider-responsive > div > .rslides_nav, .metaslider.ms-theme-theme-two:not(.has-carousel-mode).metaslider-responsive > div > .rslides_tabs").wrapAll("<div class='slide-control'></div>");

		// Nivo wrap arrows
		$(".metaslider.ms-theme-theme-two:not(.has-carousel-mode).metaslider-responsive .slide-control > .rslides_nav").wrapAll("<div class='rslides_arrows'></div>");

		// Nivo put arrows after dots
		var nivo_arrows = $(".metaslider.ms-theme-theme-two:not(.has-carousel-mode).metaslider-responsive .rslides_arrows");
		nivo_arrows.next().insertBefore(nivo_arrows);

		$(window).trigger('resize');
 	});

// 	function controlNavHeight() {
// 		var controlTotalHeight = 0;

// 		$('.metaslider.ms-theme-theme-two .flex-control-nav.flex-control-paging li').each(function(){
// 			controlTotalHeight = controlTotalHeight + $(this).outerHeight(true);
// 		});
		
// 		return controlTotalHeight;
// 	}

//    function arrowsNavHeight() {
// 		var arrowsTotalHeight = 0;

// 	   $('.metaslider.ms-theme-theme-two .flex-direction-nav').each(function(){
// 			arrowsTotalHeight = arrowsTotalHeight + $(this).outerHeight(true);
// 		});

// 		return arrowsTotalHeight;
// 	}

	$(window).on('resize', function(e) {
		$(function() {
			// Removed these to give it a height that works for any number of slides.
			// var controlTotalHeight = controlNavHeight();
         	// var arrowsTotalHeight = arrowsNavHeight();
			$('.metaslider.ms-theme-theme-two .slide-control').css({
				  'position' : 'absolute',
				  'top' : '39%',
				  'height' : "140px",
				  'margin-top' : "-50px"
			 });
		});
	});

})(jQuery)
