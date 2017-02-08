"use strict";
(function(doc, $){

    Optin.Mixins.add_services_mixin("mailchimp", function( service_tab_view ){
        var tab = service_tab_view,
            $form = tab.$("#hustle_service_details_form"),
            $prev_args = $("#wpoi-mailchimp-prev-group-args"),
            $_preview = false;

        /**
         * Updates list groups on list change
         *
         */
        var update_list_groups = function(e){
            var $this = $(e.target),
                $wrapper = $('.wpoi-list-groups'),
                $interests_wrapper = $(".wpoi-list-group-interests-wrap"),
                data = _.reduce( $form.serializeArray(), function(obj, item){
                    obj[ item['name'] ] = item['value'];
                    return obj;
                }, {});

            data.action = 'hustle_mailchimp_get_list_groups';

            data._ajax_nonce = $this.data("nonce");

            //clear provider model
            Optin.step.services.provider_args.clear({silent: true});
            $interests_wrapper.empty();
            $prev_args.empty();

            $.get( ajaxurl, data)
                .done(function(res){
                    if( res && res.success ){
                        $wrapper.html( res.data );

                        $wrapper.find("select").wpmuiSelect();
                    }

                    if( res && !res.success )
                        $wrapper.empty();
                });

        };
        /**
         * Updates group interests on group change
         *
         */
        var update_group_interests = function(e){

            var $wrapper = $(".wpoi-list-group-interests-wrap"),
                $this = $(e.target),
                data = _.reduce( $form.serializeArray(), function(obj, item){
                    obj[ item['name'] ] = item['value'];
                    return obj;
                }, {});

            if( ["-1", "0"].indexOf(e.target.value) !== -1 ){ // return if selection is not meaningful
                $wrapper.empty();
                return;
            }

            data._ajax_nonce = $this.data("nonce");
            data.action = 'hustle_mailchimp_get_group_interests';

            $.get( ajaxurl, data )
                .done(function(res){
                    if( res && res.success ){

                        $wrapper.html( res.data.html );

                        Optin.step.services.provider_args.set( "group", res.data.group );

                        $wrapper.find("select").wpmuiSelect();
                        /**
                         * Select all interests
                          */
                        if( res.data.group && res.data.group.groups && _.isArray( res.data.group.groups ) ) {
                            var group = Optin.step.services.provider_args.get("group");
                        }

                    }

                    if( res && !res.success )
                        $wrapper.empty();
                })
                .fail(function(res){

                });
        };

        var update_selected_group_interests = function(e){
            var $this = $(e.target),
                val;

            if( $this.is(":radio") || $this.is("select") )
                val = $this.val();

            if( $this.is(":checkbox") ){
                val = [];
                $( "[name='" + e.target.name + "'" ).filter( ":checked" ).each(function(){
                  val.push( this.value );
                });

            }

            Optin.step.services.provider_args.set( "group", _.extend( {}, Optin.step.services.provider_args.get("group"), {
                selected: val
            }) );

        };

        var render_in_preview = function($preview){
            $_preview = $preview.$el ? $preview.$el : $preview;
            if( !Optin.step.services.provider_args.isEmpty() && "mailchimp" === Optin.step.services.model.get("optin_provider") ){
                var provider_args_template = Optin.template( "optin-" + Optin.step.services.model.get("optin_provider") + "-args"  );
                $_preview.find(".wpoi-provider-args").html( provider_args_template( Optin.step.services.provider_args.toJSON() ) );
            }
        };

        var unselect_radio_interest = function(e){
            e.preventDefault();
            $("[name='mailchimp_groups_interests']").prop("checked", false);
            Optin.step.services.provider_args.set( "group", _.extend( {}, Optin.step.services.provider_args.get("group"), {
                selected: []
            }) );
        };

        /**
         * Bind to events
         */
        $(doc).on("change", "#optin_email_list.mailchimp_optin_email_list", update_list_groups );
        $(doc).on("change", "#mailchimp_groups", update_group_interests );
        $(doc).on("change", "[name='mailchimp_groups_interests'], [name='mailchimp_groups_interests[]']", update_selected_group_interests );
        $(doc).on("click", ".wpoi-leave-group-intrests-blank-radios", unselect_radio_interest);
        Optin.Events.on("design:preview:render:finish", render_in_preview );

        return {
            render_in_previewr: render_in_preview
        };
    });

}(document, jQuery));