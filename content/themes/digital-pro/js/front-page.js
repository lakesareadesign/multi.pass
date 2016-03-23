jQuery(function( $ ){

	// Set front page 1 height
	var windowHeight = $( window ).height() - 90;

	$( '.front-page-1' ) .css({'height': windowHeight +'px'});
		
	$( window ).resize(function(){
	
		var windowHeight = $( window ).height();
	
		$( '.front-page-1' ) .css({'height': windowHeight +'px'});
	
	});

	// Local Scroll Speed
	$.localScroll({
		duration: 750
	});

});