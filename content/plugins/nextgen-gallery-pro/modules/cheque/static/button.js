jQuery(function($) {
    // We move the form to the bottom of the body element. This ensures that the form has no parent element that could use a positioning method other
    // than static, and that has a different z-index value that conflicts (and makes the form appear behind the overlay).
    // This problem happens with the Photocrati Theme
    var cheque_form_container = $('#ngg_cheque_form_container').detach();
    var cheque_form = $('<form/>').attr('id', 'ngg_cheque_form');
    cheque_form.append(cheque_form_container);
    $('body').append(cheque_form);

    $('#ngg_cheque_button').on('click', function(event) {
        event.preventDefault();
        var overlay = $('<div id="ngg_cheque_overlay"></div>');
        $('body').append(overlay);
        $('html, body').addClass('cheque_form_open');
        $('#ngg_cheque_form_container').show();
        $('#customer_name').focus();
    });

    $('#ngg_cheque_button_cancel').on('click', function(event) {
        event.preventDefault();
        $('html, body').removeClass('cheque_form_open');
        $('#ngg_cheque_form_container').hide();
        $('#ngg_cheque_overlay').remove();
    });

    cheque_form_container.find('input').each(function() {
        $(this).placeholder();
    });

    $('#ngg_cheque_button_submit').click(function(event) {
        event.preventDefault();
        $(this).attr('disabled', 'disabled');
        $(this).text($(this).attr('data-processing-msg'));
        var post_data = $('#ngg_pro_checkout').serialize() + '&' + $('#ngg_cheque_form').serialize();

        post_data += "&action=cheque_checkout";

        var $button = $(this);

        $.post(photocrati_ajax.url, post_data, function(response){
            if (typeof(response) != 'object') {
                response = JSON.parse(response);
            }
            if (typeof(response.error) != 'undefined') {
                $button.removeAttr('disabled');
                $button.text($button.attr('data-submit-msg'));

                alert(response.error);
            } else {
                window.location = response.redirect;
            }
        });
    });
});