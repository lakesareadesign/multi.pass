(function( $ ) {

    /**
     * Log optin view when it's being viewed
     */
    $(document).on("wpoi:display", function (e, type, $optin, optin) {

        /**
         * Log number of times this optin type has been shown so far
         *
         * @type {string}
         */
        var k = 'wpoi-optin-{type}-shown-count-'.replace("{type}", type)  + optin.data.optin_id,
            prev_shown_count = Optin.cookie.get( k ) || 0,
            is_test = type && optin.settings[type].is_test;

        if( !is_test )
            Optin.cookie.set( k , prev_shown_count + 1 , 30 );

        $.ajax({
            type: "POST",
            url: inc_opt.ajaxurl,
            dataType: "json",
            data: {
                action: "inc_opt_optin_viewed",
                data: {
                    optin_id: optin.data.optin_id,
                    page_type: inc_opt.page_type,
                    page_id: inc_opt.page_id,
                    type: type,
                    uri: encodeURI( window.location.href )
                }
            },
            success: function (res) {}
        });
    });
	
	/**
     * Log CC shortcode or widget when it's being viewed
     */
	$(document).on("wpoi:cc_shortcode_or_widget_viewed", function (e, type, cc_id) {
		$.ajax({
			type: "POST",
			url: inc_opt.ajaxurl,
			data: {
				action: "hustle_custom_content_viewed",
				data: {
					id: cc_id,
					page_type: inc_opt.page_type,
					page_id: inc_opt.page_id,
					type: type,
					uri: encodeURI( window.location.href )
				}
			},
			success: function (res) {}
		});
	});

}(jQuery));