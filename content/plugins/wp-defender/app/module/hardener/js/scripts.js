jQuery(function ($) {
    WDHardener.formHandler();
    WDHardener.rules();
    $('div.hardener').on('form-submitted', function (e, data, form) {
        if (form.hasClass('rule-process') == false) {
            return;
        }
        if (data.success == true) {
            Defender.showNotification('success', data.data.message);
            $('.count-issues').text(data.data.issues);
            $('.count-ignored').text(data.data.ignore);
            $('.count-resolved').text(data.data.fixed);
            if (data.data.issues > 0) {
                $('.issues-count i').removeClass('def-icon icon-tick').addClass('def-icon icon-warning');
                $('.count-issues').removeClass('wd-hide');
            } else {
                $('.count-issues').addClass('wd-hide');
                $('.issues-count i').removeClass('def-icon icon-warning').addClass('def-icon icon-tick');
            }
            if (data.data.ignore > 0) {
                $('.count-ignored').removeClass('wd-hide');
            } else {
                $('.count-ignored').addClass('wd-hide');
            }
            if (data.data.fixed > 0) {
                $('.count-resolved').removeClass('wd-hide');
            } else {
                $('.count-resolved').addClass('wd-hide');
            }
            form.closest('.rule').slideUp(500, function () {
                $(this).remove();
                if ($('.rule').size() == 0) {
                    setTimeout(function () {
                        location.reload();
                    }, 500)
                }
            })
        } else {
            Defender.showNotification('error', data.data.message);
        }
    });
});
function debounce(fn, delay) {
    var timer = null;
    return function () {
        var context = this, args = arguments;
        clearTimeout(timer);
        timer = setTimeout(function () {
            fn.apply(context, args);
        }, delay);
    };
}
window.WDHardener = window.WDHardener || {};

WDHardener.formHandler = function () {
    var jq = jQuery;
    jq('body').on('submit', '.hardener-frm', function () {
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
                if (data.data != undefined && data.data.reload != undefined) {
                    if (data.data.message != undefined) {
                        Defender.showNotification('success', data.data.message);
                    }
                    setTimeout(function () {
                        location.reload()
                    }, 1500)
                } else if (data.data != undefined && data.data.url != undefined) {
                    location.href = data.data.url;
                } else {
                    that.find('.button').removeAttr('disabled');
                    jq('div.hardener').trigger('form-submitted', [data, that])
                }
            }
        })
        return false;
    })
}

WDHardener.rules = function () {
    var jq = jQuery;
    if (jq('.rules.ignored').size() > 0) {
        //no animation for ignored
        return;
    }
    var id = window.location.hash.substr(1);
    if (id == undefined) {
        jq('.rule').first().removeClass('closed');
    } else {
        jq('#' + id).removeClass('closed');
    }
    jq('.rule .rule-title').click(function () {
        var parent = jq(this).closest('.rule');
        var otherRules = jq('.rule').not(parent);
        otherRules.each(function () {
            var that = jq(this);
            jq(this).find('.rule-content').first().slideUp(function () {
                that.addClass('closed');
            })
        })
        if (parent.hasClass('closed')) {
            //jq(this).switchClass('closed', '', 1000, 'swing');
            parent.find('.rule-content').first().slideDown();
            parent.removeClass('closed');
        } else {
            //jq(this).switchClass('', 'closed', 1000, 'swing');
            parent.find('.rule-content').first().slideUp(function () {
                parent.addClass('closed');
            })
        }
    })
}