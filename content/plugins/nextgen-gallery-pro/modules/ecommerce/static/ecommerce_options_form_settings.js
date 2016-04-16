(function($) {
    $('span.tooltip, label.tooltip').tooltip();

    $('select[name="ecommerce[home_country]"]').on('change', function() {
        var $this = $(this);
        if (typeof NGG_Pro_EComm_Settings.iso_4217_countries[$this.val()] !== 'undefined') {
            var currency_id = NGG_Pro_EComm_Settings.iso_4217_countries[$this.val()].currency_code;
            $('select[name="ecommerce[currency]"]').val(currency_id);
        }
    });

    // Hide/show e-amil receipt fields
    var enable_email_receipt = $('.ecommerce_enable_email_receipt');
    enable_email_receipt.change(function(e){
        if (parseInt($(e.target).val()) == 1) {
            $('#tr_ecommerce_email_receipt_subject.hidden, #tr_ecommerce_email_receipt_body.hidden').each(function(){
                $(this).fadeIn('fast', function(){
                    $(this).removeClass('hidden');
                });
            });
        }
        else {
            $('#tr_ecommerce_email_receipt_subject, #tr_ecommerce_email_receipt_body').each(function(){
                $(this).fadeOut('fast', function(){
                    $(this).addClass('hidden');
                });
            });
        }
    });

})(jQuery);
