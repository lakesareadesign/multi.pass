jQuery( document ).on( 'click', '.boss-woocommerce-notice .notice-dismiss', function() {

    jQuery.ajax({
        url: ajaxurl,
        data: {
            action: 'boss_dismiss_woocommerce_notice'
        }
    });

});
