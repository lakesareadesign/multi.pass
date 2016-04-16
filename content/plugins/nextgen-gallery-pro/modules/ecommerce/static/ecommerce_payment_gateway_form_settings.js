jQuery(function($) {
    // TODO: Move to stripe module
    $('input[name="ecommerce[stripe_enable]"]')
        .nextgen_radio_toggle_tr('1', $('#tr_ecommerce_stripe_sandbox'))
        .nextgen_radio_toggle_tr('1', $('#tr_ecommerce_stripe_currencies_supported'))
        .nextgen_radio_toggle_tr('1', $('#tr_ecommerce_stripe_key_public'))
        .nextgen_radio_toggle_tr('1', $('#tr_ecommerce_stripe_key_private'));
    $('#tr_ecommerce_stripe_key_private input').attr('type', 'password');

    // TODO: Move to paypal express checkout module
    $('input[name="ecommerce[paypal_enable]"]')
        .nextgen_radio_toggle_tr('1', $('#tr_ecommerce_paypal_sandbox'))
        .nextgen_radio_toggle_tr('1', $('#tr_ecommerce_paypal_currencies_supported'))
        .nextgen_radio_toggle_tr('1', $('#tr_ecommerce_paypal_email'))
        .nextgen_radio_toggle_tr('1', $('#tr_ecommerce_paypal_username'))
        .nextgen_radio_toggle_tr('1', $('#tr_ecommerce_paypal_password'))
        .nextgen_radio_toggle_tr('1', $('#tr_ecommerce_paypal_signature'));

    // TODO: move to the cheque module
    $('input[name="ecommerce[cheque_enable]"]')
        .nextgen_radio_toggle_tr('1', $('#tr_ecommerce_cheque_instructions'));
    $('#ecommerce_cheque_instructions').css({
        height: '150px',
        width: '400px'
    });

    $('#tr_ecommerce_paypal_password input').attr('type', 'password');
});