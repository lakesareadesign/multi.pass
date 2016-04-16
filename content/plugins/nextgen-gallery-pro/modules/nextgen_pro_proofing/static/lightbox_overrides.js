jQuery(function($) {
    if (typeof ngg_pro_proofing_i18n != 'undefined') {
    $('#npl_content').on('npl.ready', function (e, data) {
        var methods = data.methods;
        var self = data.galleria_theme;
        methods.thumbnails.proofing = {
            init: function() {},

            proofing_button: $('<i/>')
                .addClass('nggpl-toolbar-button-proofing fa fa-star')
                .attr({'title': ngg_pro_proofing_i18n.nggpl_title}),

            get_active_color: function() {
                var retval = '#ffff00';
                if (typeof ngg_proofing_settings != 'undefined') {
                    retval = ngg_proofing_settings.active_color;
                }
                return retval;
            },

            events: {
                bind: function() {
                    if (typeof ngg_image_proofing != 'undefined') {
                        self.bind('npl.init', this.npl_init);
                        self.bind('image', this.image);
                        methods.thumbnails.proofing.proofing_button.bind('click', this.button_clicked);
                    }
                },

                is_proofing_enabled: function() {
                    return methods.galleria.get_displayed_gallery_setting('ngg_proofing_display', false);
                },

                image: function() {
                    if (methods.thumbnails.proofing.events.is_proofing_enabled()) {
                        var image_id = methods.galleria.get_current_image_id();
                        var gallery_id = $.nplModal('get_state').gallery_id;
                        var proofed_list = ngg_image_proofing.getList(gallery_id);
                        var index = proofed_list.indexOf(image_id.toString());

                        if (index > -1) {
                            methods.thumbnails.proofing.proofing_button.css({color: methods.thumbnails.proofing.get_active_color()});
                        } else {
                            // If there's no custom icon color then setting the color attribute to '' will not
                            // remove our above color attribute. Remove the style attribute entirely and reset
                            methods.thumbnails.proofing.proofing_button.removeAttr('style');
                        }
                    }
                },

                npl_init: function() {
                    if (methods.thumbnails.proofing.events.is_proofing_enabled()) {
                        methods.thumbnails.register_button(methods.thumbnails.proofing.proofing_button);
                    }
                },

                button_clicked: function (event) {
                    var state = $.nplModal('get_state');
                    ngg_image_proofing.addOrRemoveImage(state.gallery_id, state.image_id);
                    methods.thumbnails.proofing.events.image();
                    event.preventDefault();
                }
            }
        };

        methods.thumbnails.proofing.events.bind();
    });
}});
