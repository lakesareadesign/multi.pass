"use strict";
(function( $, doc, win ) {
    if( inc_opt.is_upfront ) return;

    /**
     * Don't do anything if slide in is hide all!
     */
    if( _.isTrue( Optin.cookie.get( Optin.SLIDE_IN_COOKIE_HIDE_ALL ) )  )
        return;

    /**
     * Prapare and show optin slidein (we will take the first optin that has the slidein environment enabled or in test mode AND set to display)
     */
    var optin_keys = _.keys(Optins);
    var slidein_optin = false;
    var slidein_optin_handle = false;

    $.each( optin_keys, function(i, k){
        var opt = Optins[ k ],
			opt_cookie_never_see = Optin.cookie.get( Optin.SLIDE_IN_COOKIE_PREFIX + opt.data.optin_id )
		;
		
		// if "after_close" set/updated to "keep_showing" from "no_show" or "hide_all"
		if ( opt.settings.slide_in.after_close == "keep_showing" && opt_cookie_never_see ) {
			opt_cookie_never_see = false;
			Optin.cookie.set( Optin.SLIDE_IN_COOKIE_PREFIX + opt.data.optin_id,  opt.data.optin_id, 0 );
		}
		
        if( _.isTrue( opt.settings.slide_in.display ) && !_.isTrue( opt_cookie_never_see )  ) {
            slidein_optin_handle = k;
            slidein_optin = opt;
        }
    });

    if( slidein_optin != false ) {
        var html = Optin.render_optin( slidein_optin );

        var never_see_again = _.isTrue(  slidein_optin.settings.slide_in.add_never_see_this_message ) ? '<div class="wpoi-nsa"><a class="inc_opt_never_see_again">%s</a></div>'.replace("%s", inc_opt.l10n.never_see_again ) : "";
        var slide_in = $( '<div class="inc_opt_slidein inc_opt_slidein_'+ slidein_optin.settings.slide_in.position +' inc_optin inc_optin_'+slidein_optin.data.optin_id+' wpoi-slide"><a href="#" class="inc-opt-close-popup" aria-label="Close" >&times;</a>' + html + never_see_again +'</div>');

        // add provider args
        slide_in.find(".wpoi-provider-args").html( Optin.render_provider_args( slidein_optin )  );

        slide_in.data("handle", slidein_optin_handle);

        slide_in.on("show", function(){ //  on show log view
            Optin.popup.shown.push( slide_in.id );

            if( _.isTrue( slidein_optin.settings.slide_in.hide_after ) ) {
                var delay = slidein_optin.settings.slide_in.hide_after_unit === "minutes" ?
                parseInt( slidein_optin.settings.slide_in.hide_after_val, 10 ) * 60 * 1000 :
                parseInt( slidein_optin.settings.slide_in.hide_after_val, 10 ) * 1000;
                var delay_id = _.delay(function(){
                    if( !slide_in.data('prevent_hide_after') ) {
						// if hide after is not prevented, then hide it
                        slide_in.removeClass("wpoi-show");
						slide_in.trigger( 'hide' );
					}
                }, delay);

                slide_in.data("delay_id", delay_id);
            }

        });

        // store the handle into popup
        slide_in.data("handle", slidein_optin_handle);
        slide_in.data("popup", slidein_optin);
        slide_in.data("type", "slide_in");

        slide_in.on("hide", function( ){
            var $slide_in = $(this),
                slide_in = $slide_in.data("popup");

            if( "hide_all" === slide_in.settings.slide_in.after_close ) {
                Optin.cookie.set( Optin.SLIDE_IN_COOKIE_HIDE_ALL, slide_in.data.optin_id, 30 );
            }

            if( "no_show" === slide_in.settings.slide_in.after_close ) {
                Optin.cookie.set( Optin.SLIDE_IN_COOKIE_PREFIX + slide_in.data.optin_id,  slide_in.data.optin_id, 30 );
            }

            $(document).trigger("wpoi:hide", ["slide_in", $slide_in, slide_in]);
        } );

        slide_in.appendTo( "body" );

        /**
         * Prevent hide after if user clicks on slide in
         *
         */
        slide_in.on("click", function(){
            slide_in.data("prevent_hide_after", true);
        });

        slide_in.display =  function() {
            if( slide_in.is(".wpoi-show") || slide_in.is(".wpoi-shown") ) return;

            slide_in.addClass("wpoi-show");
            slide_in.addClass("wpoi-shown"); // quick fix to avoid showing the slidein several times
            slide_in.show();
            // If we have an OUT animation, we shoul swap the animations right after the IN ends
            if( slidein_optin.settings.slide_in.animation_out ){
                if( slidein_optin.settings.slide_in.animation_in ){
                    _.delay(function(){
                        slide_in.removeClass( slidein_optin.settings.slide_in.animation_in );
                        slide_in.addClass( slidein_optin.settings.slide_in.animation_out );
                    }, 350);
                }else slide_in.addClass( slidein_optin.settings.slide_in.animation_out );
            }else if( slidein_optin.settings.slide_in.animation_in ){
                _.delay(function(){
                    slide_in.removeClass( slidein_optin.settings.slide_in.animation_in );
                }, 350);
            }
            slide_in.trigger("show");
            $(document).trigger("wpoi:display", ["slide_in", slide_in, slide_in.data("popup") ]);
        };

        /**
         * Triggers
         */
        if( typeof Optin.Triggers[ slidein_optin.settings.slide_in.appear_after] === "function"  )
            Optin.Triggers[ slidein_optin.settings.slide_in.appear_after].call( null, slidein_optin, slidein_optin.settings.slide_in, slide_in );
        else
            console.log( "Hustle:[Popup] No trigger defined for ". popup_optin.settings.popup.appear_after );
    }

})( jQuery, document, window );
