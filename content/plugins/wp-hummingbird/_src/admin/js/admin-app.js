jQuery(document).ready( function() {
    WPHB_Admin.init();

    /* Mobile navigation on Minification and Performance pages */
    jQuery('.mobile-nav').on('click', function(e) {
       jQuery(this).toggleClass('active');
    });

});