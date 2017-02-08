"use strict";
(function( $, doc, win ) {
    if( inc_opt.is_upfront ) return;

    /**
     * Prapare and show optin popup (we will take the first optin that has the pupup environment enabled, or in test mode AND set to display)
     */
    var optin_keys = _.keys(Optins);
    var popup_optin = false;
    var popup_optin_handle = false;
    $.each( optin_keys, function(i, k){
        var opt = Optins[ k ];

        if( _.isTrue( opt.settings.popup.display ) && !_.isTrue( Optin.cookie.get( Optin.POPUP_COOKIE_PREFIX + opt.data.optin_id ) )  ) {

            popup_optin_handle = k;
            popup_optin = Optins[ popup_optin_handle ];

        }
    });


    if( popup_optin !== false ) {
        var html = Optin.render_optin( popup_optin );

        var never_see_again = _.isTrue(  popup_optin.settings.popup.add_never_see_this_message ) ? '<div class="wpoi-nsa"><a class="inc_opt_never_see_again">%s</a></div>'.replace("%s", inc_opt.l10n.never_see_again ) : "";
        var popup = $( '<div class = "inc_opt_popup wpoi-animate inc_optin inc_optin_' + popup_optin.data.optin_id + '"><a href="#" aria-label="Close" class="inc-opt-close-popup">&times;</a>' + html + never_see_again +'</div>');
        // add provider args
        popup.find(".wpoi-provider-args").html( Optin.render_provider_args( popup_optin )  );

        if( popup_optin.settings.popup.animation_in ){
            popup.addClass( popup_optin.settings.popup.animation_in );
        }

        popup.data("handle", popup_optin_handle);


        popup.on( "hide", function( ){
            Optin.popup.hidden.push( popup_optin.data.optin_id);
            Optin.popup.long_hidden.push( popup_optin.data.optin_id );
            _.delay(function(){
                popup.removeClass("wpoi-show");
				$('.wpoi-overlay-mask').removeClass("wpoi-show");
            }, 750);
            if( _.isTrue( popup_optin.settings.popup.close_button_acts_as_never_see_again ) )
                Optin.cookie.set( Optin.POPUP_COOKIE_PREFIX + popup_optin.data.optin_id,  popup_optin.data.optin_id, parseInt( popup_optin.settings.popup.never_see_expiry, 10 ) );

            // If we have an In animation, we should swap the animations right after the OUT ends
            if( popup_optin.settings.popup.animation_in ){
                if( popup_optin.settings.popup.animation_out ){
                    _.delay(function(){
                        popup.removeClass( popup_optin.settings.popup.animation_out );
                        popup.addClass( popup_optin.settings.popup.animation_in );
                    }, 350);
                }else {
                    popup.addClass( popup_optin.settings.popup.animation_in );
                }
            }

            if( !popup_optin.settings.popup.animation_out )
                popup.find(".wpoi-show-message").removeClass("wpoi-show-message");

            $(document).trigger("wpoi:hide", ["popup", popup, popup.data("popup") ]);
        });

        // store the handle into popup
        popup.data("handle", popup_optin_handle);
        popup.data("popup", popup_optin);
        popup.data("type", "popup");

        popup.appendTo( "body" );

        popup.display =  function() {
            if( popup.is(".wpoi-show") ) return;

            popup.removeClass( popup_optin.settings.popup.animation_out );

            if( !$(popup).prev(".wpoi-overlay-mask").length )
                $('<div class="inc_optin_' + popup_optin.data.optin_id + ' wpoi-overlay-mask wpoi-animate fadein"><div class="wpoi-popup-overlay"></div></div>').insertBefore(popup).addClass("wpoi-show");
            else
                popup.prev(".wpoi-overlay-mask").addClass("wpoi-show");

            if( popup_optin.settings.popup.animation_in ) popup.addClass( popup_optin.settings.popup.animation_in );

            _.delay(function(){

                popup.addClass("wpoi-show");
                // If we have an OUT animation, we should swap the animations right after the IN ends
                if( popup_optin.settings.popup.animation_out ){
                    if( popup_optin.settings.popup.animation_in ){
                        _.delay(function(){
                            popup.removeClass( popup_optin.settings.popup.animation_in );
                            popup.addClass( popup_optin.settings.popup.animation_out );
                        }, 350);
                    }else {
                        popup.addClass( popup_optin.settings.popup.animation_out );
                    }
                }else if( popup_optin.settings.popup.animation_in ){
                    _.delay(function(){
                        popup.removeClass( popup_optin.settings.popup.animation_in );
                    }, 350);
                }

            }, 750);

            $(document).trigger("wpoi:display", ["popup", popup, popup.data("popup") ]);
        };

        /**
         * Triggers
         */
        if( typeof Optin.Triggers[ popup_optin.settings.popup.appear_after] === "function" )
            Optin.Triggers[ popup_optin.settings.popup.appear_after].call( null, popup_optin, popup_optin.settings.popup, popup );
        else
            console.log( "Hustle:[Popup] No trigger defined for ". popup_optin.settings.popup.appear_after );
     }

    $(document).on("click", '.inc-opt-close-popup, .wpoi-overlay-mask', function(e){
        e.preventDefault();
        var $this = $(e.target),
            $popup = $this.closest( '.inc_optin');
        if($(this).hasClass('wpoi-overlay-mask')) $popup = $(this).next( '.inc_optin');
        $popup.removeClass("wpoi-show");
        $popup.trigger('hide');

        /**
         * Make sure all contents are being hidden if popup doesn't have any animation_out
         */
        if( popup_optin.settings && !popup_optin.settings.popup.animation_out ){
            $popup.hide();
            _.defer(function(){
                // lets make sure we are not messing with style display so that animation will work later on
                ( $popup[0].style || {} ).display = "";
            });
        }

		if ( _.isTrue( popup_optin.settings.popup.close_button_acts_as_never_see_again ) ) {
			if ( _.isTrue( popup_optin.settings.popup.trigger_on_exit ) ) {
				$(doc).off( 'wpoi:exit_intended' );
			}
		}
    });


    $(document).on("click", ".inc_opt_never_see_again", function(e){
        e.preventDefault();
        Optin.cookie.set( Optin.POPUP_COOKIE_PREFIX + popup_optin.data.optin_id,  popup_optin.data.optin_id, parseInt( popup_optin.settings.popup.never_see_expiry, 10 ) );
        $(this).closest('.inc_opt_popup').find(".inc-opt-close-popup").trigger("click");

		if ( _.isTrue( popup_optin.settings.popup.add_never_see_this_message ) ) {
			if ( _.isTrue( popup_optin.settings.popup.trigger_on_exit ) ) {
				$(doc).off( 'wpoi:exit_intended' );
			}
		}
    });


}(jQuery, document, window));