(function($) {
    Galleria.addTheme({
        name: 'nextgen_pro_slideshow',
        author: 'Photocrati Media',
        version: 2.0,
        defaults: {
            carousel:   false,
            thumbnails: false,
            autoplay:   true,
            showInfo:   false,
            fullscreenDoubleTap: false,
            trueFullscreen:      false
        },
        init: function(options) {
            Galleria.requires(1.41, 'This version of NextGen Pro Slideshow theme requires Galleria 1.4.1 or later');

            var self = this;

            // Adjust some settings specific to this gallery
            options.showInfo = (options.showInfo && options._nggCaptionClass.length > 0) ? true : false;
            options._nggCaptionPadding = parseInt(window.ngg_galleria.get_setting(options._nggGalleryID, 'caption_padding', '5'));

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

            // It's much faster to add this by CSS than hooking onto 'loadfinish'
            if (options._nggBorderSize > 0 && options.imageCrop !== true) {
                $("<style type='text/css'>#displayed_gallery_" + options._nggGalleryID + " .galleria-stage .galleria-image img {"
                    + "border: solid " + parseInt(options._nggBorderSize) + 'px ' + options._nggBorderColor
                    + " } </style>").appendTo("head");
            }

            // Adjust some dimensions before Galleria starts the display
            this.$('info').css('max-height', options._nggCaptionHeight + 'px');

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
                        var bottomheight = parseInt(options._nggCaptionHeight)
                            + (options._nggCaptionPadding)
                            + options.imageMargin;
                        this.$('stage').css({bottom: bottomheight});
                        break;
                    }
                }

                this.rescale();
            }

            // Automatically begin playback
            this.setPlaytime(options._nggSlideshowSpeed);

            if (options._nggShowPlaybackControls) {
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
                    function() { $(this).css(    'opacity', 0.7);  },
                    function() { $(this).animate({ opacity:  0.0}); }
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
                $(options._nggGalleryParent).siblings('div.ngg-trigger-buttons').each(function() {
                    $(this).width(self.$('stage').width());
                    $(this).css('margin', '0 auto');
                    $(this).find('i').each(function() {
                        $(this).data('nplmodal-image-id', self.getData(self.getIndex()).image_id);
                    });
                });
            }));

            // Disable image right-click and drag when requested
            if (window.ngg_galleria.get_setting(options._nggGalleryID, 'protect_images', false)) {
                this.addElement('image-protection');
                document.oncontextmenu = function(event) {
                    event = event || window.event;
                    event.preventDefault();
                };
                this.prependChild('images', 'image-protection');
                this.$('image').bind('dragstart', function(event) {
                    event.preventDefault();
                });
            }
        }

    });

    $(window).trigger('ngg.galleria.themeadded', ['nextgen_pro_slideshow']);

}(jQuery));
