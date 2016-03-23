jQuery(function( $ ){

	// Enable responsive menu icon for mobile
	$(".nav-primary .genesis-nav-menu").addClass("responsive-menu").after('<div class="responsive-menu-icon"></div>');

	$(".responsive-menu-icon").click(function(){
		$(".nav-primary .genesis-nav-menu").slideToggle();
	});
	
	$(window).resize(function(){
		if(window.innerWidth > 799) {
			$("nav .sub-menu").removeAttr("style");
			$(".responsive-menu > .menu-item").removeClass("menu-open");
		}
	});

	$(".responsive-menu > .menu-item").click(function(event){
		if (event.target !== this)
		return;
			$(this).find(".sub-menu:first").slideToggle(function() {
			$(this).parent().toggleClass("menu-open");
		});
	});

});