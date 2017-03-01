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
    var mediaUploader;
    $('.file-picker').click(function () {
        if (mediaUploader) {
            mediaUploader.open();
            return;
        }
        // Extend the wp.media object
        mediaUploader = wp.media.frames.file_frame = wp.media({
            title: 'Choose an Import file',
            button: {
                text: 'Choose File'
            }, multiple: false
        });

        // When a file is selected, grab the URL and set it as the text field's value
        mediaUploader.on('select', function () {
            var attachment = mediaUploader.state().get('selection').first().toJSON();
            $('#import').val(attachment.url);
            $('#file_import').val(attachment.id);
        });
        // Open the uploader dialog
        mediaUploader.open();
    })
    $('.btn-import-ip').click(function () {
        var that = $(this);
        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
                action: 'wd_import_ips',
                file: $('#file_import').val()
            }, beforeSend: function () {
                that.attr('disabled', 'disabled');
            },
            success: function (data) {
                that.removeAttr('disabled');
                if (data.status == 1) {
                    //$('#ip_whitelist').val(data.whitelist);
                    //$('#ip_blacklist').val(data.blacklist);
                    location.reload();
                } else {
                    that.notify(data.err, {
                        position: 'top right',
                        className: 'error'
                    })
                }
            }
        })
    })
})