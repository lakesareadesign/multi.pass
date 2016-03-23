jQuery(function( $ ){

	// Add shrink class to site header after 50px
	$(document).on("scroll", function(){

		if($(document).scrollTop() > 50){
			$(".site-header").addClass("shrink");			

		} else {
			$(".site-header").removeClass("shrink");			
		}

	});

});