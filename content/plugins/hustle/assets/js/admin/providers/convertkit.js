'use strict';
(function(doc, $){
	Optin.Mixins.add_services_mixin( 'convertkit', function( service_tab_view ){
		
		var validate = function(){
            var _errors = [],
                $field = $("[name='optin_api_secret']"),
                $icon = $('<span></span>');

            if( $("#optin_api_secret").val().trim() === "" ){
                _errors.push({name: 'optin_api_secret', message: optin_vars.messages.convertkit.enter_api_secret });
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
        var add_api_secret_to_args = function(){
            if( "convertkit" !== Optin.step.services.model.get("optin_provider") ) return;

            Optin.step.services.provider_args.set( "api_secret",  $.trim( $("#optin_api_secret").val() ) );
        };
		
		/**
         * Bind to events
         */
        Optin.Events.on("services:validate:after", add_api_secret_to_args );
		
		return {
			render_in_previewr: new Function(),
			validate: validate
		};
	});

	

})(document, jQuery);