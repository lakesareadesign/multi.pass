jQuery( function ( $ ) {

	// FitVids
	$('.site-inner').fitVids();

	// Testimonial Slider
    if( $('.testimonial-slider').length ) {

        $('.testimonial-slider').bxSlider({
            controls: false,
            nextText: '',
            prevText: '',
            auto: true,
            pause: 7000,
            adaptiveHeight: true,
        });

    }

	$('.js-scroll-to-link').click(function() {

		if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {

			var target = $(this.hash);
			target = target.length ? target : $('[name=' + this.hash.slice(1) +']');

			if (target.length) {

				$('html, body').animate({
					scrollTop: target.offset().top
				}, 500);

				return false;
			}

		}

	});

});