(function($) {
    // this moves the optionto under "Display comments" rather than the very bottom of the form
    var rowtomove = $('#tr_photocrati-nextgen_pro_lightbox_display_cart').detach();
    rowtomove.insertAfter('#tr_photocrati-nextgen_pro_lightbox_display_comments');
})(jQuery);
