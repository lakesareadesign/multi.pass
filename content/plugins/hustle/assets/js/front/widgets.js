"use strict";
(function( $ ) {
	
	/**
     * Functions for saving conversion data
     */
	Optin = Optin || {};
	Optin.handle_cc_shortcode_conversion = function(cc_id, type){
        var $win =  $(window),
            $doc = $(document);
		
		$($doc).on("click", "a.wph-cc-shortcode--cta", function(e){
			var cc_data = {
				"id": cc_id,
				"type": type,
				"source": "cta"
			};
			Optin.save_cc_shortcode_conversion(cc_data);
		});
    }
	Optin.save_cc_shortcode_conversion = function(cc_data){
		$.ajax({
			type: "POST",
			url: inc_opt.ajaxurl,
			data: {
				action: "hustle_custom_content_converted",
				data: {
					id: cc_data.id,
					page_type: inc_opt.page_type,
					page_id: inc_opt.page_id,
					type: cc_data.type,
					uri: encodeURI( window.location.href ),
					source: cc_data.source
				}
			},
			success: function (res) {}
		});
	}
	
    /**
     * Render inline optins ( widget )
     */
    var inc_opt_render_widgets = _.debounce( function(){
		// rendering widgets, shortcodes for Custom Content
		$(".inc_cc_widget_wrap, .inc_cc_shortcode_wrap").each(function () {
            var $this = $(this),
                id = $this.data("id"),
                type = $this.is(".inc_cc_widget_wrap") ? "widget" : "shortcode";

            if( !id ) return;
			
            var cc = _.find(Hustle_Custom_Contents, function (opt) {
                return id == opt.content.optin_id;
            });
			
            if (!cc) return;
			
			$this.data("handle", _.findKey(Hustle_Custom_Contents, cc));
            $this.data("type", type);
			
			// sanitize cta_url 
			if ( cc.design.cta_url ) {
				if (!/^(f|ht)tps?:\/\//i.test(cc.design.cta_url)) {
					cc.design.cta_url = "http://" + cc.design.cta_url;
				}
			}
			
			var html = Optin.render_cc_shortcode( cc );
			Optin.handle_cc_scroll( $this, type, id );
			$this.html(html);
			
			_.delay(function(){
                $(document).trigger("wpoi:cc_shortcode_or_widget_viewed", [type, id]);
            }, _.random(0, 300));
			
			Optin.handle_cc_shortcode_conversion(id, type);

        });
		
		// rendering widgets, shortcodes for Opt-in
        $(".inc_opt_widget_wrap, .inc_opt_shortcode_wrap").each(function () {
            var $this = $(this),
                id = $this.data("id"),
                type = $this.is(".inc_opt_widget_wrap") ? "widget" : "shortcode";

            if( !id ) return;
			
            var optin = _.find(Optins, function (opt) {
                return id == opt.data.optin_id;
            });

            if (!optin) return;

            $this.data("handle", _.findKey(Optins, optin));
            $this.data("type", type);

            var html = Optin.render_optin( optin );

            Optin.handle_scroll( $this, type, optin );


            $this.html(html);

            // add provider args
            $this.find(".wpoi-provider-args").html( Optin.render_provider_args( optin )  );

            _.delay(function(){
                $(document).trigger("wpoi:display", [type, $this, optin ]);
            }, _.random(0, 300));

        });
		
    }, 50, true);

    inc_opt_render_widgets();

    $(document).on('upfront-load', function(){
        inc_opt_render_widgets();

        Upfront.Events.on("entity:object:refresh:start entity:object:refresh preview:build:start upfront:preview:build:stop", inc_opt_render_widgets);
    });

}(jQuery));