jQuery(function ($) {
    //bind form handler for every form inside scan section
    WDScan.formHandler();

    //bind handler for new scan form
    $('div.wdf-scanning').on('form-submitted', function (e, data, form) {
        if (form.attr('id') != 'start-a-scan') {
            return;
        }

        if (data.success == true) {
            location.reload();
        } else {
            Defender.showNotification('error', data.data.message);
        }
    });
    //processing scan
    if ($('#scanning').size() > 0) {
        $('body').addClass('wpmud');
        WDP.showOverlay("#scanning", {
            title: scan.scanning_title,
            class: 'no-close wp-defender scanning'
        });
    }
    if ($('#process-scan').size() > 0) {
        $('#process-scan').submit();
        $('div.wdf-scanning').on('form-submitted', function (e, data, form) {
            if (form.attr('id') != 'process-scan') {
                return;
            }
            if (data.success == true) {
                location.reload();
            } else {
                $('.status-text.scan-status').text(data.data.statusText);
                $('.scan-progress-text span').text(data.data.percent + '%');
                $('.scan-progress-bar span').css('width', data.data.percent + '%');
                setTimeout(function () {
                    $('#process-scan').submit();
                }, 1500);
            }
        })
    }

    //ignore form
    $('div.wdf-scanning').on('form-submitted', function (e, data, form) {
        if (!form.hasClass('ignore-item')) {
            return;
        }

        if (data.success == true) {
            //show notification
            Defender.showNotification('success', data.data.message);
            //close the modal form
            WDP.closeOverlay();
            //remove the line
            $('#' + data.data.mid).fadeOut('200', function () {
                $('#' + data.data.mid).remove();
            })
        } else {
            Defender.showNotification('error', data.data.message);
        }
    });
    //restore an ignore
    $('div.wdf-scanning').on('form-submitted', function (e, data, form) {
        if (!form.hasClass('ignore-restore')) {
            return;
        }

        if (data.success == true) {
            //show notification
            Defender.showNotification('success', data.data.message);
            $('#' + data.data.mid).fadeOut('200', function () {
                $('#' + data.data.mid).remove();
            })
        } else {
            Defender.showNotification('error', data.data.message);
        }
    });
    //delete mitem
    $('body').on('click', '.delete-mitem', function () {
        var parent = $(this).closest('form');
        var confirm_box = parent.find('.confirm-box');
        $(this).addClass('wd-hide');
        confirm_box.removeClass('wd-hide');
        confirm_box.find('.button-secondary').unbind('click').bind('click', function () {
            confirm_box.addClass('wd-hide');
            parent.find('.delete-mitem').removeClass('wd-hide');
        })
    });
    $('div.wdf-scanning').on('form-submitted', function (e, data, form) {
        if (!form.hasClass('delete-item')) {
            return;
        }
        if (data.success == true) {
            //show notification
            Defender.showNotification('success', data.data.message);
            //close the modal form
            WDP.closeOverlay();
            $('#' + data.data.mid).fadeOut('200', function () {
                $('#' + data.data.mid).remove();
            })
        } else {
            Defender.showNotification('error', data.data.message);
        }
    });
    $('div.wdf-scanning').on('form-submitted', function (e, data, form) {
        if (!form.hasClass('pull-src')) {
            return;
        }

        if (data.success == true) {
            var parent = form.closest('.source-code');
            parent.html(data.data.html);

            // hljs.highlightBlock(parent.find('pre code'));
            $('pre code').each(function (i, block) {
                hljs.highlightBlock(block);
                hljs.lineNumbersBlock(block);
            });
        } else {
            Defender.showNotification('error', data.data.message);
        }
    })
    //resolve item
    $('div.wdf-scanning').on('form-submitted', function (e, data, form) {
        if (!form.hasClass('resolve-item')) {
            return;
        }

        if (data.success == true) {
            //show notification
            Defender.showNotification('success', data.data.message);
            //close the modal form
            WDP.closeOverlay();
            $('#' + data.data.mid).fadeOut('200', function () {
                $('#' + data.data.mid).remove();
            })
        } else {
            Defender.showNotification('error', data.data.message);
        }
    });
    $('div.wdf-scanning').on('form-submitted', function (e, data, form) {
        if (!form.hasClass('scan-settings')) {
            return;
        }

        if (data.success == true) {
            WDP.closeOverlay();
            //show notification
            Defender.showNotification('success', data.data.message);
        } else {
            Defender.showNotification('error', data.data.message);
        }
    });

    $('select[name="frequency"]').change(function () {
        if ($(this).val() == '1') {
            $(this).closest('.schedule-box').find('div.days-container').hide();
        } else {
            $(this).closest('.schedule-box').find('div.days-container').show();
        }
    }).change();

    //bulk
    $('#apply-all').click(function () {
        $('.scan-chk').prop('checked', $(this).prop('checked'));
    });
    $('.scan-bulk-frm').submit(function () {
        var data = $(this).serialize();
        $('.scan-chk').each(function () {
            if ($(this).prop('checked') == true) {
                data += '&items[]=' + $(this).val();
            }
        })
        var that = $(this);
        $.ajax({
            type: 'POST',
            data: data,
            url: ajaxurl,
            beforeSend: function () {
                that.find('button').attr('disabled', 'disabled');
            },
            success: function (data) {
                if (data.success) {
                    setTimeout(function () {
                        location.reload();
                    }, 1000)
                    Defender.showNotification('success', data.data.message);
                } else {
                    that.find('button').removeAttr('disabled');
                    Defender.showNotification('error', data.data.message);
                }
            }
        })
        return false;
    });

    $('.column-col_action a').click(function () {
        setTimeout(function () {
            if ($('.source-code:visible').size() > 0) {
                $('.source-code:visible').find('form').submit();
            }
        }, 500)
    })
})

window.WDScan = window.WDScan || {};
WDScan.formHandler = function () {
    var jq = jQuery;
    jq('body').on('submit', '.scan-frm', function () {
        var data = jq(this).serialize();
        var that = jq(this);
        jq.ajax({
            type: 'POST',
            url: ajaxurl,
            data: data,
            beforeSend: function () {
                that.find('.button').attr('disabled', 'disabled');
            },
            success: function (data) {
                if (data.data != undefined && data.data.url != undefined) {
                    location.href = data.data.url;
                } else {
                    that.find('.button').removeAttr('disabled');
                    jq('div.wdf-scanning').trigger('form-submitted', [data, that])
                }
            }
        })
        return false;
    })
}