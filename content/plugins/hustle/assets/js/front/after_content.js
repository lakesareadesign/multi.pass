(function( $ ) {
    /**
     * Render inline optins ( after_content )
     */
    $(".inc_opt_after_content_wrap").each(function () {
        var $this = $(this),
            id = $this.data("id");

        if( !id ) return;

        var optin = _.find(Optins, function (opt) {
            return id == opt.data.optin_id;
        });


        if (!optin) return;

        $this.data("handle", _.findKey(Optins, optin));
        $this.data("type", "after_content");

        if ( !_.isTrue( optin.settings.after_content.display ) ) return;

        var html = Optin.render_optin( optin );
        Optin.handle_scroll( $this, "after_content", optin );

        $this.html(html);
        // add provider args
        $this.find(".wpoi-provider-args").html( Optin.render_provider_args( optin )  );

        $(document).trigger("wpoi:display", ["after_content", $this, optin ]);

        if (optin.settings.after_content.animate && optin.settings.after_content.animate == "true") {
            $this.addClass(optin.settings.after_content.animation);
        }
    });

}(jQuery));