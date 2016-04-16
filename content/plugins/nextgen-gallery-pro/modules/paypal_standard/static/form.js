jQuery(function($){
    $('input[name="ecommerce[paypal_std_enable]"]')
        .nextgen_radio_toggle_tr('1', $('#tr_ecommerce_paypal_std_currencies_supported'))
        .nextgen_radio_toggle_tr('1', $('#tr_ecommerce_paypal_std_email'))
        .nextgen_radio_toggle_tr('1', $('#tr_ecommerce_paypal_std_sandbox'));
});