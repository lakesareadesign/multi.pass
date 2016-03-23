jQuery(function( $ ){

	$("nav .genesis-nav-menu").addClass("responsive-menu").before('<div class="responsive-menu-icon"></div>');
	
	$(".responsive-menu-icon").click(function(){
		$(this).next("nav .genesis-nav-menu").slideToggle();
	});
	
	$(window).resize(function(){
		if(window.innerWidth > 768) {
			$("nav .genesis-nav-menu").removeAttr("style");
		}
	});
	
});