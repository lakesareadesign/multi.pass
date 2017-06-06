import Fetcher from './utils/fetcher';

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
                $(this).closest('.recipient').remove();
                $('.scan-settings').find("input[id='scan_recipient'][value=" + $(this).attr('data-id') + "]").remove();
            });

            // Add recipient
            $('#add-receipt').click(function () {
                const email = $("#wphb-username-search").val();
                const name = $("#wphb-first-name").val();
                Fetcher.performance.addRecipient( email, name )
                    .then( ( response ) => {
                        var user_row = $('<div class="recipient"/>');

                        var img = $('<img/>').attr({
                            'src': response.avatar,
                            'width': '30'
                        });
                        var name = $('<span/>').html(response.name);

                        user_row.append('<span class="name"/>');
                        user_row.find('.name').append( img, name);


                        user_row.append($('<span class="email"/>').html(email));
                        user_row.append($('<a/>').attr({
                            'data-id': response.user_id,
                            'class': 'remove float-r wphb-remove-recipient',
                            'href': '#',
                            'alt': self.strings.removeButtonText
                        }).html('<i class="dev-icon dev-icon-cross"></i>'));

                        $('<input>').attr({
                            type: 'hidden',
                            id: 'scan_recipient',
                            name: 'email-recipients[]',
                            value: JSON.stringify( { email: response.email, name: response.name } )
                        }).appendTo(user_row);

                        $('.receipt .recipients').append(user_row);
                        $("#wphb-username-search").val('');
                        $("#wphb-first-name").val('');
                    })
                    .catch( (error) => {
                        console.error( error.response );
                        alert( error.message );
                    } );
                return false;
            });

            // Save report settings
            $('body').on('submit', '.scan-frm', function (e) {
                e.preventDefault();
                var form_data = $(this).serialize();
                var that = $(this);

                that.find('.button').attr('disabled', 'disabled');

                Fetcher.performance.saveReportsSettings( form_data )
                    .then( ( response ) => {
                        that.find('.button').removeAttr('disabled');
                        self.showUpdateMessage();
                    });
                return false;
            });

            return this;

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