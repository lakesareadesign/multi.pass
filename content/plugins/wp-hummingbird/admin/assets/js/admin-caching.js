( function( $ ) {
    WPHB_Admin.caching = {

        module: 'caching',
        selectedServer: '',
        $serverSelector: null,
        $serverInstructions: [],
        $expirySelectors: [],
        $snippets: [],

        init: function () {
            var self                    = this,
                cachingMetabox          = $('#wphb-box-caching-enable'),
                cachingContent          = cachingMetabox.find('.box-content'),
                cachingContentSpinner   = cachingContent.find('.spinner'),
                cachingFooter           = cachingMetabox.find('.box-footer');

            if ( wphbCachingStrings )
                self.strings = wphbCachingStrings;

            this.$serverSelector = $( '#wphb-server-type' );
            this.selectedServer = this.$serverSelector.val();
            //this.$spinner = $('#wphb-box-caching-enable .spinner');

            self.$snippets.apache = $('#wphb-code-snippet-apache pre').first();
            self.$snippets.nginx = $('#wphb-code-snippet-nginx pre').first();

            var instructionsList = $( '.wphb-server-instructions' );
            instructionsList.each( function( i, element ) {
                self.$serverInstructions[ $(this).data('server') ] = $(this);
            });

            var expirySelectors = $( '.wphb-expiry-select' );

            expirySelectors.each( function( i, element ) {
                var type = $(this).data('type');
                if ( type ) {
                    $(this).change( function() {
                        //self.$spinner.css( 'visibility', 'visible' );
                        cachingContent.find('.wphb-content').hide();
                        cachingFooter.hide();
                        cachingContentSpinner.fadeIn();
                        $('.wphb-notice').hide();

                        // Expiration selector has changed
                        ( function( element ) {
                            var value = $( element ).val();
                            // Change the plugin settings
                            $.ajax({
                                url: ajaxurl,
                                method: 'POST',
                                data: {
                                    action: 'wphb_ajax',
                                    wphb_nonce: self.strings.setExpirationNonce,
                                    nonce_name: 'wphb-set-expiration',
                                    module: self.module,
                                    module_action: 'set_expiration',
                                    data: {
                                        type: type,
                                        value: value
                                    }
                                }
                            }).done( function(response) {
                                // And reload the code snippet
                                self.reloadSnippets();
                            });
                        })( this );
                    });
                }

            });

            this.showServerInstructions( this.selectedServer );

            this.$serverSelector.change( function() {
                var value = $(this).val();
                self.hideCurrentInstructions();
                self.showServerInstructions( value );
                self.setServer(value);
                self.selectedServer = value;
            });

            $( '#toggle-apache-instructions').click( function( e ) {
                e.preventDefault();
                $('.apache-instructions').slideToggle();
            });

            $( '#toggle-litespeed-instructions').click( function( e ) {
                e.preventDefault();
                $('.litespeed-instructions').slideToggle();
            });


            return this;
        },

        setServer: function( value ) {
            var self = this;
            $.ajax({
                url: ajaxurl,
                method: 'POST',
                data: {
                    action: 'wphb_ajax',
                    wphb_nonce: self.strings.setServerNonce,
                    nonce_name: 'wphb-set-server',
                    module: self.module,
                    module_action: 'set_server_type',
                    data: {
                        type: value
                    }
                }
            });
        },

        hideCurrentInstructions: function() {
            var selected = this.selectedServer;
            if ( this.$serverInstructions[ selected ] ) {
                this.$serverInstructions[ selected ].hide();
            }

        },

        showServerInstructions: function( server ) {
            if ( typeof this.$serverInstructions[ server ] != 'undefined' ) {
                this.$serverInstructions[ server ].show();
            }

            if ( 'apache' == server || 'LiteSpeed' == server ) {
                $( '#enable-cache-wrap').show();
            }
            else {
                $( '#enable-cache-wrap').hide();
            }
        },

        reloadSnippets: function() {
            var self = this;
            var stop = false;
            for ( var i in self.$snippets ) {
                if ( self.$snippets.hasOwnProperty( i ) ) {
                    $.ajax({
                        url: ajaxurl,
                        method: 'POST',
                        data: {
                            action: 'wphb_ajax',
                            wphb_nonce: self.strings.setExpirationNonce,
                            nonce_name: 'wphb-set-expiration',
                            module: self.module,
                            module_action: 'reload_snippet',
                            data: {
                                type: i
                            }
                        }
                    }).success( function( result ) {
                        if ( result.success && ! stop ) {
                            self.$snippets[result.data.type].text( result.data.code );

                            // Make sure that we only do things when server displayed is the processed one
                            if ( result.data.type != self.selectedServer ) {
                                return;
                            }

                            if ( result.data.type == 'apache' && result.data.updatedFile ) {
                                $('#wphb-notice-code-snippet-htaccess-updated').show();
                                location.href = self.strings.recheckURL + '&caching-updated=true';
                            }
                            else if ( result.data.type == 'apache' && self.strings.cacheEnabled && ! result.data.updatedFile ) {
                                $('#wphb-notice-code-snippet-htaccess-error').show();
                                location.href = self.strings.htaccessErrorURL;
                            }
                            else {
                                $('#wphb-notice-code-snippet-updated').show();
                                location.href = self.strings.recheckURL + '&caching-updated=true';
                            }

                            //self.$spinner.css( 'visibility', 'hidden' );
                        }
                        else {
                        }
                    });

                }
            }
        }
    };
}( jQuery ));