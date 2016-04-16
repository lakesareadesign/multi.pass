(function($) {

    var ngg_image_proofing = {

        initialize: function() {
            this.bind_events();
        },

        formatString: function() {
            var args = arguments;
            return this.replace(/{(\d+)}/g, function (match, number) {
                return typeof args[number] != 'undefined' ? args[number] : match;
            });
        },

        setTriggerProof: function($jel, proofed) {
            var classOn = $jel.data('class-on');
            var classOff = $jel.data('class-off');
            $jel.data('proofed', proofed ? '1' : '0');
            if (proofed) {
                $jel.removeClass(classOff);
                $jel.addClass(classOn);
                $jel.addClass('ngg-proofing-on');
            } else {
                $jel.removeClass(classOn);
                $jel.addClass(classOff);
                $jel.removeClass('ngg-proofing-on');
            }
        },

        removeAllProofs: function(gallery_id) {
            var self = this;
            var proofed_list = self.getList(gallery_id);
            if (proofed_list.length <= 0) {
                return;
            }
            $('.ngg-trigger-proofing').each(function(i, el) {
                var $el = jQuery(el);
                var id = $el.data('image-id');
                var trigger_gallery_id = $el.data('nplmodal-gallery-id');
                if (trigger_gallery_id != gallery_id) {
                    return true; // 'continue' for $.each()
                }
                self.setTriggerProof($el, false);
            });
            Ngg_Store.set('ngg_proofing_' + gallery_id, '');
        },

        setActiveTriggers: function(gallery_id) {
            var self = this;
            var proofed_list = self.getList(gallery_id);
            if (proofed_list.length <= 0) {
                return;
            }
            $('.ngg-trigger-proofing').each(function(i, el) {
                var $el = jQuery(el);
                var id = $el.data('image-id');
                var trigger_gallery_id = $el.data('nplmodal-gallery-id');
                if (trigger_gallery_id != gallery_id) {
                    return true; // 'continue' for $.each()
                }
                if (proofed_list.indexOf(id.toString()) > -1) {
                    self.setTriggerProof($el, true);
                }
            });
        },

        getDialog: function(gallery_id) {
            var self = this;
            var dialog = jQuery('#ngg-proofing-dialog-' + gallery_id);
            if (dialog.length == 0) {
                var proofed_list = self.getList(gallery_id);
                var imgcount = self.formatString.call(ngg_pro_proofing_i18n.image_list, proofed_list.length, proofed_list.length != 1 ? 's' : '');
                var disabled = '';
                if (proofed_list.length <= 0) {
                    disabled = ' disabled="disabled" '
                }

                var tmp = '<div id="ngg-proofing-dialog-' + gallery_id + '" class="ngg-proofing-dialog" style="display:none;">';

                tmp += '<a href="javascript:void(0)" class="ngg-proofing-cancel">';
                tmp += '<span class="fa-stack"><i class="fa fa-circle fa-stack-2x"></i><i class="fa fa-times fa-stack-1x"></i></span>';
                tmp += '</a>';

                tmp += '<h3 class="ngg-proofing-label">' + imgcount + '</h3>';
                tmp += '<div class="ngg-proofing-form">';
                tmp += '<div class="ngg-proofing-form-entry">';
                tmp += '<input type="hidden" class="ngg-proofing-list" name="list" value=""/>';

                tmp += '<div class="ngg-proofing-fullname-wrapper">';
                tmp += '<span><i class="fa fa-fw fa-user"></i></span>';
                tmp += '<input type="text" required class="ngg-proofing-fullname" name="customer_name" placeholder="' + ngg_pro_proofing_i18n.example_name+ '"/>';
                tmp += '</div>';

                tmp += '<div class="ngg-proofing-email-wrapper">';
                tmp += '<span><i class="fa fa-fw fa-envelope"></i></span>';
                tmp += '<input type="email" required class="ngg-proofing-email" name="email" placeholder="' + ngg_pro_proofing_i18n.example_email + '"/>';
                tmp += '</div>';

                tmp += '</div>';
                tmp += '<div class="ngg-proofing-form-entry ngg-form-entry-submit">';
                tmp += '<button class="ngg_pro_btn ngg-proofing-submit" type="submit" name="submit"' + disabled + '>' + ngg_pro_proofing_i18n.submit_button + '&nbsp;<i class="fa fa-arrow-circle-right"></i></button>';
                tmp += '</div>';
                tmp += '</div></div>';
                dialog = $(tmp);
                $(dialog).find('.ngg-proofing-fullname, .ngg-proofing-email').each(function() {
                    $(this).placeholder();
                });
                dialog.find('.ngg-proofing-cancel').click(function(event) {
                    event.preventDefault();
                    // var new_proofed_list = [];
                    // self.removeAllProofs(gallery_id);
                    // self.setDialogStrings(dialog, new_proofed_list);
                    $('html, body').removeClass('ngg_proofing_form_open');
                    dialog.hide();
                    $('#ngg_proofing_overlay').hide();
                });
                dialog.find('.ngg-proofing-submit').click(function(event) {
                    event.preventDefault();
                    var email = dialog.find('.ngg-proofing-email');
                    var fullname = dialog.find('.ngg-proofing-fullname');
                    var image_list = self.getList(gallery_id);
                    var submitbtn = dialog.find('.ngg-proofing-submit');

                    submitbtn.html(ngg_pro_proofing_i18n.submit_message);
                    submitbtn.attr('disabled', 'disabled');
                    $.post(
                        photocrati_ajax.url,
                        {
                            action: 'submit_proofed_gallery',
                            email: email.attr('value'),
                            customer_name: fullname.attr('value'),
                            proofed_gallery: {
                                'image_list': image_list
                            }
                        },
                        function(data) {
                            if (typeof(data) == 'string') {
                                data = JSON.parse(data);
                            }
                            if (data['error']) {
                                alert(data['error']);
                            } else if (data['message'] && data['message'] == 'Done') {
                                self.removeAllProofs(gallery_id);
                                dialog.hide();
                                $('#ngg_proofing_overlay').hide();
                                if (data['redirect']) {
                                    window.location = data['redirect'];
                                }
                            }
                            submitbtn.html(ngg_pro_proofing_i18n.submit_button);
                            submitbtn.removeAttr('disabled');
                        }
                    );
                });
                dialog.appendTo(document.body);
            }
            return dialog;
        },

        getList: function(gallery_id) {
            var proofed_list = [];
            var proofed_string = Ngg_Store.get('ngg_proofing_' + gallery_id);
            if (proofed_string) {
                proofed_list = proofed_string.split(',');
            }
            return proofed_list;
        },

        updateAllGalleries: function() {
            var self = this;
            $.each(galleries, function(index, gallery) {
                self.setActiveTriggers(gallery.ID);
            });
        },

        setDialogStrings: function(dialog, proofed_list) {
            var self = this;

            // set the hidden input field
            dialog.find('.ngg-proofing-list').val(proofed_list.join(','));

            // update the "you are proofing X images" string
            var label = dialog.find('.ngg-proofing-label');
            label.html(self.formatString.call(ngg_pro_proofing_i18n.image_list, proofed_list.length, proofed_list.length != 1 ? 's' : ''));

            // don't let users submit if there's nothing to send
            if (proofed_list.length > 0) {
                dialog.find('.ngg-proofing-submit').removeAttr('disabled');
            } else {
                dialog.find('.ngg-proofing-submit').attr('disabled', 'disabled');
            }
        },

        addOrRemoveImage: function(gallery_id, image_id) {
            var self         = this;
            var dialog       = self.getDialog(gallery_id);
            var proofed_list = self.getList(gallery_id);
            var index        = proofed_list.indexOf(image_id.toString());

            if (index > -1) {
                proofed_list.splice(index, 1);
                // turn this specific image's trigger off
                $('.ngg-trigger-proofing').each(function(i, el) {
                    var $el = jQuery(el);
                    var trigger_gallery_id = $el.data('nplmodal-gallery-id');
                    if (trigger_gallery_id != gallery_id) {
                        return true; // 'continue' for $.each()
                    }
                    if ($el.data('image-id') == image_id) {
                        self.setTriggerProof($el, false);
                    }
                });
            } else {
                proofed_list.push(image_id.toString());
            }

            Ngg_Store.set('ngg_proofing_' + gallery_id, proofed_list.join(','));

            self.setActiveTriggers(gallery_id);
            self.setDialogStrings(dialog, proofed_list);

            return proofed_list;
        },

        bind_events: function() {
            var self = this;

            $(function() {
                $('body').append('<div id="ngg_proofing_overlay" style="display: none;"></div>');

                // setup which images are active on this page
                self.updateAllGalleries();
            });

            $(document).on('ngg-captions-added', function() {
                self.updateAllGalleries();
            });

            $(document).on('ngg-caption-add-icons', function(event, obj) {

                if (!$.nplModal('get_displayed_gallery_setting', obj.gallery_id, 'ngg_proofing_display', false)) {
                    return;
                }

                var proofing_icon = $('<i/>', {
                    'class': 'fa fa-star ngg-trigger-proofing ngg-caption-icon',
                    'data-nplmodal-gallery-id': obj.gallery_id,
                    'data-nplmodal-image-id': obj.image_id,
                    'data-image-id': obj.image_id
                }).on('click', function(event) {
                    event.preventDefault();
                    self.addOrRemoveImage(obj.gallery_id, obj.image_id);
                    return false;
                });

                obj.el.append(proofing_icon);
            });

            // nextgen's ajax pagination triggers refreshed on document when updating
            $(document).on('refreshed', function(event) {
                self.updateAllGalleries();
            });

            $(document).on('click', '.ngg-pro-proofing-trigger-link', function(event) {
                event.preventDefault();
                var dialog = self.getDialog($(this).data('gallery-id'));
                $('#ngg_proofing_overlay').show();
                $('html, body').addClass('ngg_proofing_form_open');
                dialog.show();
            });

            $(document).on('click', '.ngg-trigger-proofing', function(event) {
                var $this      = jQuery(this);
                var gallery_id = $this.data('nplmodal-gallery-id');
                var image_id   = $this.data('image-id');

                self.addOrRemoveImage(gallery_id, image_id);
            });
        }
    };

    ngg_image_proofing.initialize();
    window.ngg_image_proofing = ngg_image_proofing;
})(jQuery);
