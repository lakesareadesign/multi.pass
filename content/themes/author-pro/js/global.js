jQuery(function( $ ){
	
	// Add opacity class to site header
	if( $( document ).scrollTop() > 0 ){
		$( '.site-header' ).addClass( 'shrink' );
		$( '.nav-secondary' ).addClass( 'shrink' );			
	}
	
	$( document ).on('scroll', function(){

		if ( $( document ).scrollTop() > 0 ){
			$( '.site-header' ).addClass( 'shrink' );
			$( '.nav-secondary' ).addClass( 'shrink' );			

		} else {
			$( '.site-header' ).removeClass( 'shrink' );
			$( '.nav-secondary' ).removeClass( 'shrink' );			
		}

	});
	
	// Add class for tertiary menu
	$(window).scroll(function() {
	       var distanceFromTop = $(document).scrollTop();
	       if (distanceFromTop >= $( '.front-page-1' ).height() + 40 )
	       {
	           $( '.nav-secondary' ).addClass( 'fixed' );
	       }
	       else
	       {
	           $( '.nav-secondary' ).removeClass( 'fixed' );
	       }
	   });


	$( '.nav-primary .genesis-nav-menu, .nav-secondary .genesis-nav-menu' ).addClass( 'responsive-menu' ).before( '<div class="responsive-menu-icon"></div>' );

	$( '.responsive-menu-icon' ).click(function(){
		$(this).next( '.nav-primary .genesis-nav-menu,  .nav-secondary .genesis-nav-menu' ).slideToggle();
	});

	$( window ).resize(function(){
		if ( window.innerWidth > 800 ) {
			$( '.nav-primary .genesis-nav-menu,  .nav-secondary .genesis-nav-menu, nav .sub-menu' ).removeAttr( 'style' );
			$( '.responsive-menu > .menu-item' ).removeClass( 'menu-open' );
		}
	});

	$( '.responsive-menu > .menu-item' ).click(function(event){
		if ( event.target !== this )
		return;
			$(this).find( '.sub-menu:first' ).slideToggle(function() {
			$(this).parent().toggleClass( 'menu-open' );
		});
	});

});