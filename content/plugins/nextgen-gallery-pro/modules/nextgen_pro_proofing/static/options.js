jQuery(function($) {
    $('input[name="proofing[enable_user_email]"]')
        .nextgen_radio_toggle_tr('1', $('#tr_proofing_user_email_subject'))
        .nextgen_radio_toggle_tr('1', $('#tr_proofing_user_email_template'));
});