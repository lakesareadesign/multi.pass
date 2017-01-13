( function( $ ) {
    WPHB_Admin.DashboardCloudFlare = {
        init: function( settings ) {
            this.currentStep = settings.currentStep;
            this.data = settings;
            this.email = settings.email;
            this.apiKey = settings.apiKey;
            this.$stepsContainer = $('#cloudflare-steps');
            this.$infoBox = $('#cloudflare-info');
            this.$spinner = $( '.cloudflare-spinner' );
            this.$deactivateButton = $('#wphb-box-dashboard-cloudflare .box-title .buttons');

            this.renderStep( this.currentStep );

            $('body').on( 'click', '.cloudflare-clear-cache .button', function(e ) {
                e.preventDefault();
                this.purgeCache.apply( $(e.target), [this] );
            }.bind(this));

        },

        purgeCache: function( self ) {
            var data = {
                action: 'cloudflare_purge_cache'
            };

            var $button = this;
            $button.attr( 'disabled', true );
            self.showSpinner();
            $.post( ajaxurl, data )
                .always( function() {
                    $button.removeAttr( 'disabled' );
                    self.hideSpinner();
                });
        },

        renderStep: function( step ) {
            var template = WPHB_Admin.DashboardCloudFlare.template( '#cloudflare-step-' + step );
            var content = template( this.data );
            var self = this;


            if ( content ) {
                this.currentStep = step;
                this.$stepsContainer
                    .hide()
                    .html( template( this.data ) )
                    .fadeIn()
                    .find( 'form' )
                    .on( 'submit', function( e ) {
                        e.preventDefault();
                        self.submitStep.call( self, $(this) );
                    });

                this.$spinner = this.$stepsContainer.find( '.cloudflare-spinner' );
            }

            this.bindEvents();
        },

        bindEvents: function() {
            var $howToInstructions = $('#cloudflare-how-to');

            $howToInstructions.hide();

            $('#cloudflare-how-to-title > a').click( function( e ) {
                e.preventDefault();
                $howToInstructions.toggle();
            });

            this.$stepsContainer.find( 'select' ).each( function() {
                WDP.wpmuSelect( this );
            });

            if ( 'final' === this.currentStep ) {
                this.$deactivateButton.removeClass( 'hidden' );
            }
            else {
                this.$deactivateButton.addClass( 'hidden' );
            }



        },

        emptyInfoBox: function() {
            this.$infoBox.html('');
            this.$infoBox.removeClass();
        },

        showInfoBox: function( message ) {
            this.$infoBox.addClass( 'wphb-notice' );
            this.$infoBox.addClass( 'wphb-notice-error' );
            this.$infoBox.html( message );
        },

        showSpinner: function() {
            this.$spinner.css( 'visibility', 'visible' );
        },

        hideSpinner: function() {
            this.$spinner.css( 'visibility', 'hidden' );
        },

        submitStep: function( $form ) {
            var data = {
                action: 'cloudflare_connect',
                step: this.currentStep,
                formData: $form.serialize(),
                cfData: this.data
            };

            $form.find( 'input[type=submit]' ).attr( 'disabled', 'true' );


            this.emptyInfoBox();
            this.showSpinner();

            var self = this;

            $.post( ajaxurl, data, function(response) {
                if ( response.success ) {
                    self.data = response.data.newData;
                    self.renderStep( response.data.nextStep );
                }
                else {
                    self.showInfoBox( response.data.error );
                }
            })
                .error( function( jqXHR, textStatus, errorThrown ) {
                    self.showInfoBox( textStatus + ':' + errorThrown );
                })
                .always( function() {
                    $form.find( 'input[type=submit]' ).removeAttr( 'disabled' );
                    self.hideSpinner();
                });
        }
    };

    WPHB_Admin.DashboardCloudFlare.template = _.memoize(function ( id ) {
        var compiled,
            options = {
                evaluate:    /<#([\s\S]+?)#>/g,
                interpolate: /\{\{\{([\s\S]+?)\}\}\}/g,
                escape:      /\{\{([^\}]+?)\}\}(?!\})/g,
                variable:    'data'
            };

        return function ( data ) {
            _.templateSettings = options;
            compiled = compiled || _.template( $( id ).html() );
            return compiled( data );
        };
    });
}(jQuery));
