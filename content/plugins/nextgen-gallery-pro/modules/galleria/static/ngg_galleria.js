/*! GetDevicePixelRatio | Author: Tyson Matanich, 2012 | License: MIT */
(function (window) {
    window.getDevicePixelRatio = function() {
        var ratio = 1;
        // To account for zoom, change to use deviceXDPI instead of systemXDPI
        if (window.screen.systemXDPI !== undefined
        &&  window.screen.logicalXDPI !== undefined
        &&  window.screen.systemXDPI > window.screen.logicalXDPI) {
            // Only allow for values > 1
            ratio = window.screen.systemXDPI / window.screen.logicalXDPI;
        } else if (window.devicePixelRatio !== undefined) {
            ratio = window.devicePixelRatio;
        }
        return ratio;
    };
})(this);

(function ($) {
    "use strict";

    window.ngg_galleria = {
        gallery_selector: '.ngg-galleria-parent',
        gallery_target_selector: '.ngg-galleria',

        start: function(themename) {
            var self     = this;
            var selector = this.gallery_selector + '.' + themename;
            $(selector).each(function(ndx, gallery_parent) {
                $(document).on('ready', function() {
                    self.create(gallery_parent, themename);
                });
            });
        },

        get_gallery_from_id: function (gallery_id) {
            var retval = null;

            if ('undefined' == typeof window.galleries) {
                return retval;
            }

            $.each(window.galleries, function(index, gallery) {
                if (gallery.ID == gallery_id) {
                    retval = gallery;
                }
            });

            return $.extend({}, retval);
        },

        get_setting: function(gallery, name, def) {
            if (typeof gallery != 'object') {
                gallery = this.get_gallery_from_id(gallery);
            }

            var settings = gallery.display_settings;
            var tmp = '';

            if (typeof settings !== 'undefined'
            &&  typeof settings[name] !== 'undefined'
            &&  settings[name] !== '') {
                tmp = settings[name];
            } else {
                tmp = def;
            }

            if (tmp == 1)   tmp = true;
            if (tmp == 0)   tmp = false;
            if (tmp == '1') tmp = true;
            if (tmp == '0') tmp = false;
            return tmp;
        },

        create: function(gallery_parent, themename) {
            var gallery_id = $(gallery_parent).data('id');
            var gallery = $.extend({}, this.get_gallery_from_id(gallery_id));
            var target = $(gallery_parent).find(this.gallery_target_selector).first();

            this.configure_galleria(gallery_parent, target, gallery);

            var images = gallery.images_list;

            // Massage our data for High-DPI screens
            if (window.getDevicePixelRatio() > 1) {
                $(images).each(function(ndx, image) {
                    if (image.use_hdpi) {
                        image.image = image.srcsets.hdpi;
                    }
                });
            }

            // Galleria is very picky about the data type provided to the imageMargin option
            var border_margin = this.get_setting(gallery, 'border_size', '0');
            if (typeof border_margin == 'boolean') {
                if (border_margin)  border_margin = 1;
                if (!border_margin) border_margin = 0;
            }
            border_margin = parseInt(border_margin);

            var settings = {
                theme:         themename,
                responsive:    true,
                debug:         true,
                maxScaleRatio: 1,
                dataSource:    images,

                showInfo:    this.get_setting(gallery, 'show_captions', false),
                imagePan:    this.get_setting(gallery, 'image_pan',     false),
                imageCrop:   this.get_setting(gallery, 'image_crop',    false),
                transition:  this.get_setting(gallery, 'transition',   'fade'),
                imageMargin: border_margin,

                transitionSpeed: this.get_setting(gallery, 'transition_speed', 1) * 1000,

                _nggGalleryID:     gallery_id,
                _nggGalleryParent: gallery_parent,
                _nggCaptionClass:         this.get_setting(gallery, 'caption_class',          'caption_overlay_bottom'),
                _nggCaptionHeight:        this.get_setting(gallery, 'caption_height',         52),
                _nggShowPlaybackControls: this.get_setting(gallery, 'show_playback_controls', true),
                _nggImageCrop:            this.get_setting(gallery, 'image_crop',             false),
                _nggBorderSize:           border_margin,
                _nggBorderColor:          this.get_setting(gallery, 'border_color',           '#ffffff'),
                _nggSlideshowSpeed:       this.get_setting(gallery, 'slideshow_speed',        5) * 1000
            };

            Galleria.run(target, settings);
        },

        configure_galleria: function(gallery_parent, target, gallery) {
            // NOTE: .extend() is important! 'settings = displayed_gallery.settings' will
            // create a 'pointer' -- changes to this 'settings' var will alter the
            // displayed gallery settings. This causes havoc with fields like transition
            // and slideshow speed.
            gallery_parent = $(gallery_parent);
            var self = this;
            var settings = $.extend({}, gallery.display_settings);
            for (var index in settings) {
                var numeric_val = Number(settings[index]);
                if (!isNaN(numeric_val)) {
                    settings[index] = numeric_val;
                }
                if (numeric_val == 0 || numeric_val == 1 && !index.match(/width|size|height|dimensions|percent/)) {
                    settings[index] = numeric_val ? true : false;
                }
            }

            this.adjust_size(gallery_parent, target, settings);

            $(window).on('resize orientationchange onfullscreenchange onmozfullscreenchange onwebkitfullscreenchange', function() {
                self.adjust_size(gallery_parent, target, settings);
            });
        },

        adjust_size: function(gallery_parent, target, settings) {
            var parent_width = gallery_parent.width();
            var width = settings.width;

            if (settings.width_unit == '%') {
                width = Math.round(parent_width * (settings.width / 100));
            }

            if (parent_width > 0 && parent_width < width) {
                width = parent_width;
            }

            target.width(width);

            // Calculate height using aspect ratio of device/browser
            var aspect_ratio = gallery_parent.width() / gallery_parent.height();
            if (typeof(settings.aspect_ratio) != 'undefined' && settings.aspect_ratio != 0) {
                aspect_ratio = settings.aspect_ratio;
                if (!parseFloat(aspect_ratio)) {
                    if (settings.aspect_ratio_computed && parseFloat(settings.aspect_ratio_computed)) {
                        aspect_ratio = settings.aspect_ratio_computed;
                    } else {
                        aspect_ratio = 1.5;
                    }
                } else {
                    aspect_ratio = parseFloat(aspect_ratio);
                }
            }

            var frame_height = ((width - 20) / aspect_ratio);

            if (typeof(settings.thumbnail_height) != 'undefined') {
                var thumb_height = settings.thumbnail_height;
                if (typeof(thumb_height) === 'string') {
                    thumb_height = parseFloat(thumb_height);
                }
                frame_height += thumb_height;
            }

            frame_height += 20;

            var caption = settings.caption_class;
            if (caption == 'caption_above_stage' || caption == 'caption_below_stage') {
                frame_height += 52;
            }

            gallery_parent.height(frame_height);
        }
    };

    $(window).on('ngg.galleria.themeadded', function(event, themename) {
        ngg_galleria.start(themename);
    });

})(jQuery);
