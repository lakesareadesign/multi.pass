(function($, doc, win){
    "use strict";

    var Display_Triggers = Hustle.get("Custom_Content.Display_Triggers");

    _(Hustle_Custom_Contents).each( function( CC ){

        var model = new Backbone.Model( _.extend(
            {},
            {
                id: CC.content.optin_id,
                type: "popup"
            },
            CC.design,
            CC.content,
            {
                types: {
                    popup: CC.popup,
                    slide_in: CC.slide_in,
                    magic_bar: CC.magic_bar
                }
            }
        ) );

        _.chain({
           popup: CC.popup,
           slide_in: CC.slide_in,
           magic_bar: CC.magic_bar
        })
        .reduce( function( obj, type_data, type ){
			var never_see = Hustle.cookie.get( Hustle.consts.Never_See_Aagain_Prefix + type  + "-" + CC.content.optin_id ) == CC.content.optin_id;
			
            // handle slide_in "after_close" settings
            if ( typeof type_data.after_close !== "undefined" && type == "slide_in" ) {
                // if "after_close" set/updated to "keep showing" from "no_show" or "hide_all"
                if ( type_data.after_close == "keep_showing" && never_see ) {
                    never_see = false;
                    Hustle.cookie.set( Hustle.consts.Never_See_Aagain_Prefix + type + "-" + CC.content.optin_id , CC.content.optin_id, 0 );
                }
            }
			
            if( CC.should_display[ type ] && _.isTrue( type_data.enabled ) && !never_see )
                obj[ type ] = type_data;

            return obj;
        }, {} )
        .map(function( type_data, type  ){
            if( "magic_bar" === type ) return;
            /**
             * Triggers
             */
            if( typeof Display_Triggers[ type_data.triggers.trigger ] === "function" )
                Display_Triggers[ type_data.triggers.trigger ].call( null, type_data.triggers, type, model );
            else
                console.log( "Hustle:[Popup] No trigger defined for ". type_data.triggers.trigger  );

        })

    });
}(jQuery, document, window));