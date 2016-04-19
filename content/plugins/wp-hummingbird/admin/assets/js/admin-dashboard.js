( function( $ ) {
    WPHB_Admin.dashboard = {
        module: 'dashboard',

        init: function() {
            var self = this;

            if ( wphbDashboardStrings ) {
                self.strings = wphbDashboardStrings;
            }

            $( '.box-dashboard-welcome .close').click( function() {
                $.ajax({
                    url: ajaxurl,
                    method: 'POST',
                    data: {
                        action: 'wphb_ajax',
                        wphb_nonce: self.strings.removeWelcomeBoxNonce,
                        nonce_name: 'wphb-remove-welcome-box',
                        module: self.module,
                        module_action: 'remove_welcome_box'
                    }
                });
            });

            $('#wphb-activate-minification').change( function() {
                var value = $(this).val();
                $.ajax({
                        url: ajaxurl,
                        method: 'POST',
                        data: {
                            action: 'wphb_ajax',
                            wphb_nonce: self.strings.activateMinificationNonce,
                            nonce_name: 'wphb-activate-minification',
                            module: self.module,
                            module_action: 'activate_network_minification',
                            data: {
                                value: value
                            }
                        }
                    })
                    .done( function() {
                        var notice = $('#wphb-notice-minification-settings-updated');
                        notice.slideDown();
                        setTimeout( function() {
                            notice.slideUp();
                        }, 5000 );
                    });
            });

            $('.wphb-performance-report-item').click( function( e ) {
                var url = $(this).data( 'performance-url' );
                if ( url ) {
                    location.href = url;
                }
            });
            return this;
        }
    };
}( jQuery ));