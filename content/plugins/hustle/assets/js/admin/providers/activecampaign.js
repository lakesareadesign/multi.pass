(function(doc, $){
    "use strict";
    Optin.Mixins.add_services_mixin("activecampaign", function( service_tab_view ){

        var validate = function(){
            var _errors = [],
                $field = $("[name='optin_url']"),
                $icon = $('<span></span>');

            if( $("#optin_url").val().trim() === "" ){
                _errors.push({name: 'optin_url', message: optin_vars.messages.activecampaign.enter_url });
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
        var add_url_to_args = function(){
            if( "activecampaign" !== Optin.step.services.model.get("optin_provider") ) return;

            Optin.step.services.provider_args.set( "url",  $.trim( $("#optin_url").val() ) );
        };

        /**
         * Clear provider_args if previous provider was Activecampaign but then user changes to another provider
         * @on design:preview:render:start
         */
        var clear_provider_args = function(){
            if( Optin.step.services.model.previousAttributes().optin_provider === "activecampaign" && Optin.step.services.model.get("optin_provider") !== "activecampaign" )
                Optin.step.services.provider_args.clear( {silent: true} );
        };

        /**
         * Bind to events
         */
        Optin.Events.on("services:validate:after", add_url_to_args );
        Optin.Events.on("design:preview:render:start", clear_provider_args );

        return {
            render_in_previewr: new Function(),
            validate: validate
        };
    });

}(document, jQuery));