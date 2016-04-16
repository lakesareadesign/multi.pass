(function($) {
    Galleria.addTheme({
        name: 'nextgen_pro_horizontal_filmstrip',
        author: 'Photocrati Media',
        version: 2.0,
        defaults: {
            carousel:   true,
            thumbnails: true,
            autoplay:   true,
            showInfo:   false,
            fullscreenDoubleTap: false,
            trueFullscreen:      false
        },
        init: function(options) {
            Galleria.requires(1.41, 'This version of Classic theme requires Galleria 1.4.1 or later');

            var self = this;

            // Adjust some settings specific to this gallery
            options.showInfo               = (options.showInfo && options._nggCaptionClass.length > 0) ? true : false;
            options._nggCaptionPadding     = parseInt(window.ngg_galleria.get_setting(options._nggGalleryID, 'caption_padding',  '5'));
            options._nggOverrideThumbnails = window.ngg_galleria.get_setting(options._nggGalleryID, 'override_thumbnail_settings',  '0') != '0';

            // Galleria doesn't correctly position images with borders
            var adjust_border_positioning = function($img) {
                if (options._nggBorderSize > 0 && options.imageCrop !== true) {
                    var top  = (parseInt($img.css('top')) - options._nggBorderSize);
                    var left = (parseInt($img.css('left')) - options._nggBorderSize);
                    if (top < 0)  top  = 0;
                    if (left < 0) left = 0;
                    $img.css('top',  top + 'px');
                    $img.css('left', left + 'px');
                }
            };

            // Set our thumbnail sizes to exactly the dimensions requested by the user
            if (options._nggOverrideThumbnails) {
                options._nggThumbnailWidth  = parseInt(window.ngg_galleria.get_setting(options._nggGalleryID, 'thumbnail_width', '120'));
                options._nggThumbnailHeight = parseInt(window.ngg_galleria.get_setting(options._nggGalleryID, 'thumbnail_height', '90'));

                this.$('thumbnails').find('.galleria-image').each(function(ndx, image) {
                    $(image).css({
                        width:  options._nggThumbnailWidth  + 'px',
                        height: options._nggThumbnailHeight + 'px'
                    }).find('img').css({'max-width': options._nggThumbnailWidth});
                });
            } else {
                // Will be the height of the tallest thumbnail to display
                options._nggThumbnailHeight = 1;

                // Because Galleria replaces our CSS' 'auto' attribute with an inline width/height:0
                this.$('thumbnails').find('.galleria-image').each(function(ndx, image) {
                    $(image).css({
                        width: 'auto',
                        height: 'auto'
                    });
                });

                // Find the tallest thumbnail
                for (var i = 0; i <= (this.getDataLength() - 1); i++) {
                    var img = this.getData(i);
                    if (img.thumb_dimensions.height > options._nggThumbnailHeight) {
                        options._nggThumbnailHeight = img.thumb_dimensions.height;
                    }
                }

                // Position shorter thumbnails to be vertically centered
                this.$('thumbnails').find('.galleria-image').each(function(ndx, image) {
                    var cur_h = self._data[ndx].thumb_dimensions.height;
                    if (cur_h < options._nggThumbnailHeight) {
                        $(image).css('top', (options._nggThumbnailHeight - cur_h) / 2);
                    }
                });
            }

            // It's much faster to add this by CSS than hooking onto 'loadfinish'
            if (options._nggBorderSize > 0 && options.imageCrop !== true) {
                $("<style type='text/css'>#displayed_gallery_" + options._nggGalleryID + " .galleria-stage .galleria-image img {"
                    + "border: solid " + parseInt(options._nggBorderSize) + 'px ' + options._nggBorderColor
                    + " } </style>").appendTo("head");
            }

            // Adjust some dimensions before Galleria starts the display
            this.$('info').css('max-height', options._nggCaptionHeight + 'px');
            this.$('thumbnails-container').css('height', options._nggThumbnailHeight + 'px');

            // Calculate how far from the bottom the carousel should appear. The
            // extra 2 pixels is for the border-top/border-bottom of the thumbnails.
            // The last 4 pixels is to match what Photocrati Slideshows look like
            this.$('stage').css(
                'bottom',
                options._nggThumbnailHeight + (parseInt(options._nggBorderSize) > 0 ? parseInt(options._nggBorderSize) : 0)
                + 2 + 4 + 'px'
            );

            this.$('thumbnails-container').height(options._nggThumbnailHeight);
            this.$('stage').css({
                bottom: (($(options._nggGalleryParent).offset()
                        + $(options._nggGalleryParent).outerHeight())
                        - this.$('thumbnails-container').offset().top)
                        + 6
            });

            // Let Galleria reflow itself after we've altered so much
            this.rescale();

            if (!Galleria.TOUCH) {
                this.addIdleState(this.get('image-nav-left'),  { left:  -50 });
                this.addIdleState(this.get('image-nav-right'), { right: -50 });
                this.addIdleState(this.get('counter'),         { opacity: 0 });
            }

            // Add the caption class to the Galleria container
            if (options.showInfo && options._nggCaptionClass.length > 0) {
                this.$('info').show();
                this.$('container').addClass(options._nggCaptionClass);

                // if the info overflows its container this effect will let viewers read the remaining description
                this.$('info').hover(
                    function() {
                        var $info = $(this);
                        var text = self.$('info-text');
                        var diff = $info.outerHeight() - text.outerHeight();
                        if (diff < 0) {
                            $info.stop().animate({ scrollTop: -diff }, ((-diff) / 17) * 450);
                        }
                    },
                    function() {
                        var $info = $(this);
                        var text = self.$('info-text');
                        var diff = $info.outerHeight() - text.outerHeight();
                        if (diff < 0) {
                            $info.stop().animate({ scrollTop: 0 }, 'fast');
                        }
                    }
                );

                // Adjust the dimensions of the stage to fit captions
                switch (options._nggCaptionClass) {
                    case 'caption_above_stage': {
                        this.$('stage').css({
                            top: parseInt(options._nggCaptionHeight)
                                 + options.imageMargin});
                        break;
                    }
                    case 'caption_below_stage': {
                        this.$('thumbnails-container').css(
                            'bottom',
                            (parseInt(options._nggCaptionHeight) + parseInt(options._nggCaptionPadding)) + 'px'
                        );
                        var bottomheight = parseInt(options._nggCaptionHeight)
                            + (options._nggCaptionPadding * 2)
                            + this.$('thumbnails-container').height()
                            + options.imageMargin
                            + 6;
                        this.$('stage').css({bottom: bottomheight});
                        break;
                    }
                    case 'caption_overlay_bottom': {
                        this.$('info').css(
                            'bottom',
                            parseInt(this.$('stage').css('bottom'))
                        );
                        break;
                    }
                }

                this.rescale();
            }

            // Thumbnail navigation shown on hover
            $([this.$('thumb-nav-left'), this.$('thumb-nav-right')])
                .css({ display: 'none' })
                .hover(function() {
                    if (!$(this).hasClass('disabled')) {
                        $(this).stop().animate({
                            opacity: 1
                        }, 'fast');
                    }
                },
                function() {
                    if (!$(this).hasClass('disabled')) {
                        $(this).stop().animate({
                            opacity: 0.8
                        }, 'fast');
                    }
                }
            );
            this.$('thumbnails-container').hover(
                this.proxy(function() {
                    var navList = [this.get('thumb-nav-left'), this.get('thumb-nav-right')];
                    $(navList).css({ display : 'block' });
                    $(navList).stop().animate({
                        opacity: 0.8
                    });
                }),
                this.proxy(function() {
                    var navList = [this.get('thumb-nav-left'), this.get('thumb-nav-right')];
                    $(navList).stop().animate({
                        opacity: 0
                    }, function() {
                        $(this).css({ display: 'none' });
                    });
                })
            );

            // set slideshow speed
            if (options._nggSlideshowSpeed) {
                this.setPlaytime(options._nggSlideshowSpeed);
            }

            // add playback controls if we're to do so
            if (options._nggShowPlaybackControls) {
                // Add playback controls
                var playback_button = $('<div/>').addClass('galleria-playback-button');
                if (this._playing) {
                    playback_button.removeClass('play').addClass('pause');
                } else {
                    playback_button.removeClass('pause').addClass('play');
                }
                $(this._dom.stage).append(playback_button);

                var button = $('<a/>')
                    .hover(
                    function() { $(this).parent().css('opacity', 0.9); },
                    function() { $(this).parent().css('opacity', 0.7); }
                ).click(this.proxy(function(e) {
                        var controls = $(e.target).parent();
                        if (this._playing) {
                            this.pause();
                            controls.removeClass('pause').addClass('play');
                        } else {
                            this.play().next();
                            controls.removeClass('play').addClass('pause');
                        }
                    }));
                playback_button.append(button);

                playback_button.hover(
                    function() { $(this).css('opacity', 0.7); },
                    function() { $(this).animate({ opacity: 0.0}); }
                );
            }

            this.bind('rescale', this.proxy(function(e) {
                var $img = $(self.getActiveImage());
                setTimeout(function() {
                    adjust_border_positioning($img);
                }, 30);
            }));

            this.bind('loadfinish', this.proxy(function(e) {
                var $img = $(e.imageTarget);
                adjust_border_positioning($img);

                // Adjust the Pro Lightbox triggers if they exist
                $(options._nggGalleryParent).siblings('div.ngg-trigger-buttons').each(function () {
                    $(this).width(self.$('stage').width());
                    $(this).css('margin', '0 auto');
                    $(this).find('i').each(function () {
                        $(this).data('nplmodal-image-id', self.getData(self.getIndex()).image_id);
                    });
                });

                // The current thumbnail should have full opacity
                $(e.thumbTarget).css('opacity', 1)
                                .parent()
                                .siblings()
                                .children()
                                .css('opacity', 0.6);
            }));

            this.bind('thumbnail', this.proxy(function(e) {
                if (!Galleria.TOUCH ) {
                    // fade thumbnails
                    $(e.thumbTarget).css('opacity', 0.6).parent().hover(function() {
                        $(this).not('.active').children().stop().fadeTo(100, 1);
                    }, function() {
                        $(this).not('.active').children().stop().fadeTo(400, 0.6);
                    });
                    if (e.index === this.getIndex()) {
                        $(e.thumbTarget).css('opacity', 1);
                    }
                } else {
                    $(e.thumbTarget).css('opacity', this.getIndex() ? 1 : 0.6);
                }
            }));

            // Disable image right-click and drag when requested
            if (window.ngg_galleria.get_setting(options._nggGalleryID, 'protect_images', false)) {
                this.addElement('image-protection');
                document.oncontextmenu = function(event) {
                    event = event || window.event;
                    event.preventDefault();
                };
                this.prependChild('images', 'image-protection');
                this.$('thumbnails').find('.galleria-image').bind('dragstart', function(event) {
                    event.preventDefault();
                });
            }
        }
    });

    $(window).trigger('ngg.galleria.themeadded', ['nextgen_pro_horizontal_filmstrip']);

}(jQuery));
