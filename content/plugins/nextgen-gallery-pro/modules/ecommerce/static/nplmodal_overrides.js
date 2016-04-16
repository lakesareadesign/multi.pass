(function($) {
   $(window).on('override_nplModal_methods', function(e, methods) {
       methods.add_pre_open_callback(function(link, params) {
           // Should we show the cart sidebar?
           if ($(link).data('nplmodal-show-cart'))
               params.show_sidebar = '/cart';
           return params;
       });
   });
})(jQuery);