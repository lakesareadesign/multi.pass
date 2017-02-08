"use strict";
(function(doc, $){

    Optin.Mixins.add_services_mixin("mad_mimi", function( service_tab_view ){

        var validate = function(){
            var _errors = [],
                $field = $("[name='optin_username']"),
                $icon = $('<span></span>');

            if( $("#optin_username").val().trim() === "" ){
                _errors.push({name: 'username', message: optin_vars.messages.sendy.enter_url });
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
         * Register username to the provider_args model
         *
         * @on services:validate:after
         */
        var add_username_to_args = function(){
            if( "mad_mimi" !== Optin.step.services.model.get("optin_provider") ) return;

            Optin.step.services.provider_args.set( "username",  $.trim( $("#optin_username").val() ) );
        };

        /**
         * Clear provider_args if previous provider was Mad Mimi but then user changes to another provider
         * @on design:preview:render:start
         */
        var set_provider_args = function(){
            if( Optin.step.services.model.previousAttributes().optin_provider === "mad_mimi" && Optin.step.services.model.get("optin_provider") !== "mad_mimi" )
                Optin.step.services.provider_args.clear( {silent: true} );
        };

        /**
         * Bind to events
         */
        Optin.Events.on("services:validate:after", add_username_to_args );
        Optin.Events.on("design:preview:render:start", set_provider_args );


        return {
            render_in_previewr: new Function(), // since we have no specific stuff to show in preview
            validate: validate
        };
    });

}(document, jQuery));