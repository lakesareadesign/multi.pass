jQuery(document).on( 'click', '.showcase-woocommerce-notice .notice-dismiss', function() {

    jQuery.ajax({
        url: ajaxurl,
        data: {
            action: 'showcase_dismiss_woocommerce_notice'
        }
    })

})