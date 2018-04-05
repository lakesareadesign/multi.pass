jQuery(function($){

	"use strict";


	/* Match height for portfolio archive entry.
	--------------------------------------------- */
	$( '.genesis-pro-portfolio .entry' ).matchHeight();


	/* Sticky Header
	--------------------------------------------- */
	function kreativ_sticky_header() {
		var header = $('.site-header'),
		body = $('body'),
		wrap = header.find('.wrap').first(),
		spacer = $('<div />', {
			'class': 'header-spacer',
		});

		if(!body.hasClass('sticky-header-active')) {
			return;
		}

		if (header.length) {
			$(window).scroll(function () {
				if ( window.innerWidth > 1024 ) {

					var spacerHeight = header.outerHeight(),
					scrolltop = $(window).scrollTop();

					// Get admin bar height
					if(body.hasClass('admin-bar')) {
						scrolltop = scrolltop + 32;
					}

					// Set the spacer height
					spacer.height(spacerHeight);

					// Set sticky header
					if (!header.hasClass('sticky') && scrolltop > header.offset().top) {
						// Add spacer before header
						header.before(spacer);
						// Add sticky class to header
						header.addClass('sticky');
					}

					// Unset sticky header
					else if (header.hasClass('sticky')  && ( scrolltop < spacer.offset().top || scrolltop == 0 ) ) {
						// Remove spacer
						spacer.remove();
						// Remove sticky class from header
						header.removeClass('sticky');
					}
				}
			});
		}

		//* Remove sticky header styles
		$(window).resize(function(){
			if ( window.innerWidth < 1024 ) {
				if(header.hasClass('sticky')) {
					header.removeClass('sticky');
				}
				if (spacer.size()) {
					spacer.remove();
				}
			}
		});
	}

	//* Init sticky header
	kreativ_sticky_header();


	/* Scroll to top
	--------------------------------------------- */
	function kreativ_scroll_top() {
		// Toggle scrollup icon
		var scrollup = $('.scrollup');
		$(window).scroll(function(){
			if ($(this).scrollTop() > 100) {
				// Show scrollup button
				scrollup.fadeIn();
			} else {
				// Hide scrollup button
				scrollup.fadeOut();
			}
		});

		// Init scroll to top
		scrollup.click(function(){
			$("html, body").animate({ scrollTop: 0 }, 600);
			return false;
		});
	}

	//* Init scroll top
	kreativ_scroll_top();

});
