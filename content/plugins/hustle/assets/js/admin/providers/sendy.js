"use strict";
(function(doc, $){

    Optin.Mixins.add_services_mixin("sendy", function( service_tab_view ){

        var validate = function(){
            var _errors = [],
                $field = $("[name='optin_sendy_installation_url']"),
                $icon = $('<span></span>');

            if( $("#optin_sendy_installation_url").val().trim() === "" ){
                _errors.push({name: 'installation_url', message: optin_vars.messages.sendy.enter_url });
                $icon.attr("title", _errors[0].message);
                $field.addClass( "wpoi-error" );
                $field.after( $icon );
                _.defer( function(){
                    $icon.addClass( "dashicons dashicons-warning dashicons-warning-url" );
                });
            }


            return _( _errors );
        };

        /**
         * Register installation_url to the provider_args model
         *
         * @on services:validate:after
         */
        var add_installation_url_to_args = function(){
            if( "sendy" !== Optin.step.services.model.get("optin_provider") ) return;

            Optin.step.services.provider_args.set( "installation_url",  $.trim( $("#optin_sendy_installation_url").val() ) );
        };

        /**
         * Clear provider_args if previous provider was Sendy but then user changes to another provider
         * @on design:preview:render:start
         */
        var set_provider_args = function(){
            if( Optin.step.services.model.previousAttributes().optin_provider === "sendy" && Optin.step.services.model.get("optin_provider") !== "sendy" )
                Optin.step.services.provider_args.clear( {silent: true} );
        };

        /**
         * Bind to events
         */
        Optin.Events.on("services:validate:after", add_installation_url_to_args );
        Optin.Events.on("design:preview:render:start", set_provider_args );


        return {
            render_in_previewr: new Function(),
            validate: validate
        };
    });

}(document, jQuery));