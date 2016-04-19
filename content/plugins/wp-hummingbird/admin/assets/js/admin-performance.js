( function( $ ) {
    'use strict';
    WPHB_Admin.performance = {

        module: 'performance',
        iteration: 0,

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

            return this;

        },

        performanceTest: function (redirect) {
            var self = this;

            if (typeof redirect === 'undefined')
                redirect = false;

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
                    }, 10000);
                }
                else {
                    if (redirect)
                        window.location = redirect;
                }

            });

        }
    };
}( jQuery ));