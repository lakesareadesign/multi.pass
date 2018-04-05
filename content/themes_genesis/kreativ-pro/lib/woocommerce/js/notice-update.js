jQuery(document).on( 'click', '.kreativ-woocommerce-notice .notice-dismiss', function() {

  jQuery.ajax({
    url: ajaxurl,
    data: {
      action: 'kreativ_dismiss_woocommerce_notice'
    }
  })

})
