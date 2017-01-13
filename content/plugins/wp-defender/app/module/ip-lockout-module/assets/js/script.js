jQuery(function ($) {
    $('#logs-filter').change(function () {
        var url = window.location.pathname + '?page=wdf-ip-lockout&view=logs';
        url += '&filter=' + $(this).val();
        location.href = url;
    });
    $('select[name="report_frequency"]').change(function () {
        if ($(this).val() == 'daily') {
            $('.days-of-week').hide();
        } else {
            $('.days-of-week').show();
        }
    }).trigger('change');
    $('body').on('click', '.ip-action', function (e) {
        e.preventDefault();
        var that = $(this);
        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
                action: 'add_ip_to_list',
                id: that.data('id'),
                type: that.data('type')
            },
            beforeSend: function () {
                that.parent().find('a').attr('disabled')
            },
            success: function (data) {
                if (data.status != undefined && data.status == 1) {
                    that.closest('tr').notify(data.notification, {
                        position: 'top right',
                        className: 'wd-notification'
                    });
                    that.parent().html(data.html);
                }
            }
        })
    })
    $('select.def-mobile-nav').change(function () {
        var url = $(this).val();
        location.href = url;
    })
})