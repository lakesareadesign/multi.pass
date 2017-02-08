Hustle.define("Custom_Content.Display_Triggers", function( $, doc, win ){

    var Modal = Hustle.get("Modal"),
        on_show = function(modal, type){
            $.ajax({
                type: "POST",
                url: inc_opt.ajaxurl,
                data: {
                    action: "hustle_custom_content_viewed",
                    data: {
                        id: modal.model.get("id"),
                        page_type: inc_opt.page_type,
                        page_id: inc_opt.page_id,
                        type: type,
                        uri: encodeURI( window.location.href )
                    }
                },
                success: function (res) {}
            });
        },
        on_conversion = function(modal, source){
            $.ajax({
                type: "POST",
                url: inc_opt.ajaxurl,
                data: {
                    action: "hustle_custom_content_converted",
                    data: {
                        id: modal.model.get("id"),
                        page_type: inc_opt.page_type,
                        page_id: inc_opt.page_id,
                        type: modal.model.get("type"),
                        uri: encodeURI( window.location.href ),
                        source: source
                    }
                },
                success: function (res) {}
            });
        },
        show = function( model, type ){
			model.set({ type: type }, {silent: true});
            var modal = new Modal( { model: model } );

            if(  _.indexOf( ["popup"],  type ) !== -1 )
                modal.$mask.appendTo("body");

            modal.$el.appendTo("body");

            modal.on("shown", on_show);
            modal.on("converted", on_conversion);

			if ( 'slide_in' === type ) {
				var settings = model.get( 'types' )[type];

				if ( settings.hide_after ) {
					var duration = parseInt( settings.hide_after_val ),
						unit = settings.hide_after_unit;

					if ( 'minutes' === unit ) {
						duration *= 60;
					} else if ( 'hours' === unit ) {
						duration *= 3600;
					}
					duration *= 1000;

					modal.on( 'shown', function() {
						_.delay(function(){
							if ( _.contains( ['hide_all', 'no_show'], settings.after_close ) ) {
								modal.never_see_again();
							} else {
								modal.hide();
							}
						}, duration );
					});
				}
			}

            modal.show();

            Hustle.Events.trigger("cc_modal_shown", modal, type);
			// for adding proper classes
			$(document).trigger("wpoi:cc_display", [type, modal.$el, model.toJSON() ]);
    },
    listening_to_exit_intent = false,
    listen_to_exit_intend = function(){

        if( listening_to_exit_intent ) return;

        $(doc).on("mouseleave", _.debounce( function(e){
            Hustle.Events.trigger("exit_intended", e);
        }, 10, true));

        listening_to_exit_intent = true;
    },
    checking_adblock = false,
    is_adblock_enabled = function(){
        if( checking_adblock ) return;

        if( $("#hustle_optin_adBlock_detector").length ){
            return false;
        }else{
            return true;
        }

        checking_adblock = true;
    };

    var time_trigger = function( triggers, type, model  ){

        if( triggers.on_time === "immediately" ){
            show( model, type );
        }else{
            var delay = parseInt( triggers.on_time_delay, 10 ) * 1000;

            if(  triggers.on_time_unit === "minutes" )
                delay *= 60;
            else if( triggers.on_time_unit === "hours" )
                delay *= ( 60 * 60 );

            _.delay( show, delay, model, type );
        }
    };

    var scroll_trigger = function( triggers, type, model  ){
		var popup_shown = false;
        if( "scrolled" === triggers.on_scroll  ){
            $(win).scroll(_.debounce( function(){
				if ( popup_shown ) {
					return;
				}
                if( (  win.pageYOffset * 100 / $(doc).height() ) >= parseFloat( triggers.on_scroll_page_percent ) ){
                   show( model, type );
				   popup_shown = true;
                }

            }, 50) );
        }

        if( "selector" === triggers.on_scroll  ){
            var $el = $( triggers.on_scroll_css_selector );
            if( $el.length ){
                $(win).scroll(_.debounce( function(){
					if ( popup_shown ) {
						return;
					}
                    if( win.pageYOffset >= $el.position().top ) {
                        show( model, type );
						popup_shown = true;
                    }

                }, 50));
            }
        }
    };

    var click_trigger = function( triggers, type, model  ){
        if( "" !== $.trim( triggers.on_click_element )  ){
            var $clickable = $( $.trim( triggers.on_click_element ) );
            if( $clickable.length )
                $(doc).on( "click", $.trim( triggers.on_click_element ),  _.bind(show, null, model, type) );
        }

    };

    var exit_intent_trigger = function( triggers, type, model   ){
        if(_.isTrue( triggers.on_exit_intent  ) ){
            listen_to_exit_intend();
            if( _.isTrue( triggers.on_exit_intent_per_session  ) ){
                Hustle.Events.once("exit_intended", _.bind(show, null, model, type) );
            }else{
                Hustle.Events.on("exit_intended", _.bind(show, null, model, type) );
            }
            
        }
    };


    var adblock_trigger = function( triggers, type, model  ) {

        if( _.isTrue( triggers.on_adblock ) ){

            if( !is_adblock_enabled() ) return;

            if( _.isFalse( triggers.on_adblock_delayed ) ){
                show( model, type );
            }else{
                var delay = parseInt( triggers.on_adblock_delayed_time, 10 ) * 1000;

                if(  triggers.on_adblock_delayed_unit === "minutes" )
                    delay *= 60;
                else if( triggers.on_adblock_delayed_unit === "hours" )
                    delay *= ( 60 * 60 );

                _.delay( show, delay, model, type );
            }

        }
    };

    return {
        time: time_trigger,
        scroll: scroll_trigger,
        scrolled: scroll_trigger,
        click: click_trigger,
        exit_intent: exit_intent_trigger,
        adblock: adblock_trigger
    };

});