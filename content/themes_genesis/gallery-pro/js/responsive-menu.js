jQuery(function( $ ){

	$("nav .genesis-nav-menu").addClass("responsive-nav").before('<div class="icon-responsive-nav"></div>');

	$(".icon-responsive-nav").click(function(){
		$(this).next("nav .genesis-nav-menu").slideToggle(150);
		$(this).toggleClass("open");
	});

	$(window).resize(function(){
		if(window.innerWidth > 767) {
			$("nav .genesis-nav-menu, nav .sub-menu").removeAttr("style");
			$(".responsive-nav .menu-item").removeClass("menu-open");
		}
	});

	$(".responsive-nav .menu-item").click(function(event){
		if (event.target !== this)
		return;
		$(this).find(".sub-menu:first").slideToggle(150, function() {
			$(this).parent().toggleClass("menu-open");
		});
	});

});
