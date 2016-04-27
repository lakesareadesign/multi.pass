jQuery(document).ready(function($) {
    
    /* // STICKY NAV // */
    
    // Do sticky nav on scroll
    $(window).scroll(function() {
        
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
        
    });
    
    
});