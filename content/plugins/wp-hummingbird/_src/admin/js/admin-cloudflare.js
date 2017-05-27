( function( $ ) {
    WPHB_Admin.cloudflare = {
        module: 'cloudflare',
        $cfSelector: false,
        $spinner: false,

        init: function () {
            this.$spinner = $('.wphb-spinner');
            this.$cfSelector = $('#wphb-caching-cloudflare-summary-set-expiry');
            var self = this;
            if ( wphb.cloudflare.is.connected ) {
                this.$cfSelector.change( function() {
                    self.setExpiry.call( self, [this] );
                } );
            }

            return this;
        },

        setExpiry: function( selector ) {
            this.displaySpinner();
            var request = {
                action: 'cloudflare_set_expiry',
                security: wphb.cloudflare.nonces.expiry,
                value: $(selector).val()
            };
            $.post( ajaxurl, request, function( response ) {
                window.location.reload();
            });
        },

        displaySpinner: function() {
            this.$spinner.css( 'visibility', 'visible' );
        }
    };
}( jQuery ) );