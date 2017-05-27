( function( $ ) {
    'use strict';
    WPHB_Admin.performance = {

        module: 'performance',
        iteration: 0,
        progress: 0,

        init: function () {

            var self = this;

            if (wphbPerformanceStrings)
                this.strings = wphbPerformanceStrings;

            this.$runTestButton = $('#run-performance-test');

            $(".performance-report-table").off('click', 'button');
            $('.performance-report-table').on('click', '.wphb-performance-report-item-cta .additional-content-opener' && 'tr.wphb-performance-report-item', function (e) {
                e.preventDefault();

                var getParentPerformanceItem = $(this).closest(".wphb-performance-report-item"),
                    getNextAdditionalContentRow = getParentPerformanceItem.nextUntil(".wphb-performance-report-item");

                getNextAdditionalContentRow.toggleClass("wphb-performance-report-item-additional-content-opened");

                if (getNextAdditionalContentRow.hasClass("wphb-performance-report-item-additional-content-opened")) {
                    getParentPerformanceItem.addClass("wphb-performance-report-item-opened");
                } else {
                    getParentPerformanceItem.removeClass("wphb-performance-report-item-opened");
                }

            });

            if (this.$runTestButton.length) {
                this.$runTestButton.click(function (e) {
                    e.preventDefault();
                    $(this).attr('disabled', true);
                    self.performanceTest(self.strings.finishedTestURLsLink);
                });
            }

            // If a hash is present in URL, let's open the rule extra content
            var hash = window.location.hash;
            if (hash) {
                var row = $(hash);
                if (row.length) {
                    row.find('.trigger-additional-content').trigger('click');
                }

            }

            // Schedule show/hide day of week
            $('select[name="email-frequency"]').change(function () {
                if ( '1' === $(this).val() ) {
                    $(this).closest('.schedule-box').find('div.days-container').hide();
                } else {
                    $(this).closest('.schedule-box').find('div.days-container').show();
                }
            }).change();

            // Remove recipient
            $('body').on('click', '.wphb-remove-recipient', function (e) {
                e.preventDefault();
                $(this).closest('li').remove();
                $('.scan-settings').find("input[id='scan_recipient'][value=" + $(this).attr('data-id') + "]").remove();
            });

            // Add recipient
            $('#add-receipt').click(function () {
                var that = $(this);
                $.ajax({
                    type: 'POST',
                    url: ajaxurl,
                    data: {
                        action: 'add_receipt_scan_receipts',
                        'id': 'scan_receipts',
                        user: $("#wphb-username-search").val()
                    },
                    beforeSend: function () {
                        that.attr('disabled', 'disabled');
                    },
                    success: function (data) {
                        var user_row = $('<li/>');
                        user_row.append($('<img/>').attr({
                            src: data.avatar,
                            width: '30'
                        }));
                        user_row.append($('<span class="name"/>').html(data.name));
                        if (data.is_current) {
                            user_row.append($('<span/>').addClass('def-tag tag-generic').html(self.strings.youLabelText));
                        }
                        user_row.append($('<a/>').attr({
                            'data-id': data.user_id,
                            'class': 'remove float-r wphb-remove-recipient',
                            'href': '#'
                        }).html(self.strings.removeButtonText));

                        $('.receipt ul').append(user_row);
                        $("#wphb-username-search").trigger('results:clear');
                        $("#wphb-username-search").val('');

                        $('<input>').attr({
                            type: 'hidden',
                            id: 'scan_recipient',
                            name: 'email-recipients[]',
                            value: data.user_id
                        }).appendTo('form.scan-settings');
                    }
                });
                return false;
            });

            // Save report settings
            $('body').on('submit', '.scan-frm', function (e) {
                e.preventDefault();
                var form_data = $(this).serialize();
                var that = $(this);

                $.ajax({
                    url: ajaxurl,
                    data: {
                        type: 'POST',
                        action: 'wphb_ajax',
                        data: form_data,
                        wphb_nonce: self.strings.performanceSaveSettingsNonce,
                        nonce_name: 'wphb-performance-report-save-settings',
                        module: self.module,
                        module_action: 'save_report_settings'
                    },
                    beforeSend: function () {
                        that.find('.button').attr('disabled', 'disabled');
                    },
                    success: function (response) {
                        if (response.data !== undefined && response.data.url !== undefined) {
                            location.href = response.data.url;
                        } else {
                            that.find('.button').removeAttr('disabled');
                            self.showUpdateMessage();
                        }
                    }
                });
                return false;
            });

            var typingTimer;                //timer identifier
            var doneTypingInterval = 1000;  //time in ms, 5 second for example
            var $inputSearch = $("#wphb-username-search");

            //on keyup, start the countdown
            $inputSearch.on('keyup', function () {
                clearTimeout(typingTimer);
                typingTimer = setTimeout(self.doneTyping, doneTypingInterval);
            });

            //on keydown, clear the countdown
            $inputSearch.on('keydown', function () {
                clearTimeout(typingTimer);
            });

            return this;

        },

        //user is "finished typing," do something
        doneTyping: function () {
            //do something
            var that = $("#wphb-username-search");
            var value = that.val();
            if (value.length > 2) {
                $.ajax({
                    type: 'POST',
                    url: ajaxurl,
                    data: {
                        'action': 'username_search_scan_receipts',
                        'id': 'scan_receipts',
                        'term': value
                    },
                    beforeSend: function () {
                        that.trigger('progress:start');
                    },
                    success: function (data) {
                        data = $.parseJSON(data);
                        that.trigger('progress:stop');
                        that.trigger('results:show', [data]);
                    }
                });
            }

            $("#wphb-username-search").on('item:select', function () {
                $(this).closest('.receipt').find('button').removeAttr('disabled');
            });
        },

        showUpdateMessage: function () {
            var notice = $('#wphb-notice-performance-report-settings-updated');
            window.scrollTo(0,0);
            notice.slideDown();
            setTimeout( function() {
                notice.slideUp();
            }, 5000 );
        },

        performanceTest: function (redirect) {
            var self = this;

            if (typeof redirect === 'undefined')
                redirect = false;

            // Update progress bar
            if ( self.progress < 90 ) {
                self.progress += 35;
            }
            if ( self.progress > 100 ) {
                self.progress = 90;
            }
            $('.wphb-scan-progress .wphb-scan-progress-text span').text(self.progress+'%');
            $('.wphb-scan-progress .wphb-scan-progress-bar span').attr('style', 'width:'+self.progress+'%');

            $.ajax({
                url: ajaxurl,
                data: {
                    action: 'wphb_ajax',
                    method: 'POST',
                    wphb_nonce: self.strings.performanceTestNonce,
                    nonce_name: 'wphb-welcome-performance-test',
                    module: self.module,
                    module_action: 'performance_test'
                }
            }).success(function (response) {
                var finished = response.success;
                if (!finished) {
                    // Try again 5 seconds later
                    window.setTimeout(function () {
                        self.performanceTest(redirect);
                    }, 5000);
                }
                else {
                    if (redirect)
                        window.location = redirect;
                }

            });

        }
    };
}( jQuery ));