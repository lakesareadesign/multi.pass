(function(doc, $){
    "use strict";
    Optin.Mixins.add_services_mixin("infusionsoft", function( service_tab_view ){

         var validate = function(){
            var _errors = [],
                $field = $("[name='optin_account_name']"),
                $icon = $('<span></span>');

            if( $("#optin_account_name").val().trim() === "" ){
                _errors.push({name: 'account_name', message: optin_vars.messages.infusionsoft.enter_account_name });
                $icon.attr("title", _errors[0].message);
                $field.addClass( "wpoi-error" );
                $field.after( $icon );
                _.defer( function(){
                    $icon.addClass( "dashicons dashicons-warning dashicons-warning-account_name" );
                });
            }


            return _( _errors );
        };

        /**
         * Register client_secret to the provider_args model
         *
         * @on services:validate:after
         */
        var add_client_secret_to_args = function(){
            if( "infusionsoft" !== Optin.step.services.model.get("optin_provider") ) return;

            Optin.step.services.provider_args.set( "account_name",  $.trim( $("#optin_account_name").val() ) );
        };

        /**
         * Clear provider_args if previous provider was Infusionsoft but then user changes to another provider
         * @on design:preview:render:start
         */
        var clear_provider_args = function(){
            if( Optin.step.services.model.previousAttributes().optin_provider === "infusionsoft" && Optin.step.services.model.get("optin_provider") !== "infusionsoft" )
                Optin.step.services.provider_args.clear( {silent: true} );
        };

        /**
         * Bind to events
         */
        Optin.Events.on("services:validate:after", add_client_secret_to_args );
        Optin.Events.on("design:preview:render:start", clear_provider_args );

        return {
            render_in_previewr: new Function(),
            validate: validate
        };
    });

}(document, jQuery));