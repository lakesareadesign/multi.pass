(function($) {
    "use strict";

    function nplModal() {

        var core = {
            state: {
                slug: null,
                gallery_id: null,
                image_id: null,
                sidebar: null
            },
            selector: nextgen_lightbox_filter_selector($, $(".nextgen_pro_lightbox")),
            options: {},
            defaults: {
                speed: 'medium', // see jQuery docs for setting

                // the url is restored to this location when the lightbox closes
                initial_url: window.location.toString().split('#')[0],

                ajax_url: photocrati_ajax.url,
                router_slug: 'gallery'
            },

            init: function(parameters) {
                var overlay   = $("<div id='npl_overlay'></div>");
                var wrapper   = $("<div id='npl_wrapper'></div>");
                var spinner   = $("<div id='npl_spinner_container' class='npl-loading-spinner'><i id='npl_spinner' class='fa fa-spin fa-spinner hidden'></i></div>");
                var btn_close = $("<div id='npl_button_close' class='hidden'><i class='fa fa-times-circle'></i></div>");
                var content   = $("<div id='npl_content'></div>");

                if (core.methods.mobile.browser.ios()) {
                    overlay.addClass('npl_ios_no_opacity');
                    wrapper.addClass('npl_ios_hack');
                }

                // Provide a hook for third-parties to add their own methods
                $(window).trigger('override_nplModal_methods', core.methods);

                overlay.css({background: core.methods.get_setting('background_color')});
                spinner.css({color: core.methods.get_setting('icon_color')});
                btn_close.css({color: core.methods.get_setting('overlay_icon_color')});

                var body = $('body');
                body.append(overlay);
                body.append(wrapper);
                wrapper.append(spinner);
                wrapper.append(btn_close);
                wrapper.append(content);

                // get_setting() isn't available when declaring the base defaults
                parameters = $.extend(parameters, {router_slug: core.methods.get_setting('router_slug')});
                core.options = $.extend(core.defaults, parameters);

                core.methods.bind_images();
                core.methods.set_events();
                core.methods.mobile.init();

                if (parseInt(core.methods.get_setting('padding', '0')) > 0) {
                    var space = core.methods.get_setting('padding', '0') + core.methods.get_setting('padding_unit', 'px');
                    $("<style type='text/css'>#npl_wrapper.npl_open_with_padding {"
                        + 'top: ' + space + ';'
                        + 'bottom: ' + space + ';'
                        + 'left: ' + space + ';'
                        + 'right: ' + space + ';'
                    + " } </style>").appendTo("head");
                }

                core.methods.router.routes.push({
                    re: new RegExp('^' + core.options.router_slug + '\/(.*)\/(.*)\/(.*)$', 'i'),
                    handler: core.methods.url_handler
                });

                core.methods.router.routes.push({
                    re: new RegExp('^' + core.options.router_slug + '\/(.*)\/(.*)$', 'i'),
                    handler: core.methods.url_handler
                });

                core.methods.router.routes.push({
                    re: new RegExp('^' + core.options.router_slug + '$', 'i'),
                    handler: core.methods.close_modal
                });

                core.methods.router.routes.push({
                    re: '',
                    handler: core.methods.close_modal
                });

                core.methods.router.listen();

                // Hack for iOS and some Android browsers that can't handle position:fixed when the keyboard is open
                if (core.methods.mobile.browser.ios()
                ||  core.methods.mobile.browser.android()) {
                    wrapper.addClass('npl_mobile');
                }

                // The theme uses the same check and will *not* open the sidebar automatically at startup
                // So hide the trigger icons lest users think they can actually use them
                if (core.methods.mobile.browser.any()) {
                    core.methods.mobile.hide_triggers();
                }
            },

            methods: {
                _pre_open_callbacks: [],
                _is_open: false,

                getDPIRatio: function() {
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
                },

                url_handler: function() {
                    var slug     = arguments[0];
                    var image_id = arguments[1];
                    var sidebar  = null;
                    if (arguments.length == 3) {
                        sidebar = arguments[2];
                        if (sidebar == '1') {
                            sidebar = 'comments';
                        }
                    }

                    // need to get slug, image_id, and sidebar
                    // determine the ID from our slug. if nothing comes back, assume we're already looking at the ID
                    var gallery_id = this.get_id_from_slug(slug);
                    if (!gallery_id) {
                        gallery_id = slug;
                    }

                    var state = {
                        gallery_id: gallery_id,
                        image_id: image_id,
                        sidebar: sidebar,
                        slug: slug
                    };

                    this.set_state(state);

                    $('#npl_content').trigger('npl.url_handler', [state]);

                    // the galleria theme handles url updates between image ids, so if the modal window is already open
                    // and is already looking at the same gallery we don't need to do anything here
                    if (this.is_open() && gallery_id == core.state.gallery_id) {
                        return;
                    }

                    this.open_modal(gallery_id, image_id, sidebar);
                },

                run_pre_open_lightbox_callbacks: function(link, params) {
                    for (var i = 0; i < this._pre_open_callbacks.length; i++) {
                        var callback = this._pre_open_callbacks[i];
                        params = callback(link, params);
                    }
                    return params;
                },

                add_pre_open_callback: function(callback) {
                    this._pre_open_callbacks.push(callback);
                },

                get_state: function() {
                    return core.state;
                },

                set_state: function(state) {
                    core.state = state;
                },

                get_setting: function (name, def) {
                    var tmp = '';
                    if (typeof nplModalSettings !== 'undefined'
                        &&  typeof nplModalSettings[name] !== 'undefined'
                        &&  nplModalSettings[name] !== '') {
                        tmp = window.nplModalSettings[name];
                    } else {
                        tmp = def;
                    }
                    if (tmp == 1)   tmp = true;
                    if (tmp == 0)   tmp = false;
                    if (tmp == '1') tmp = true;
                    if (tmp == '0') tmp = false;
                    return tmp;
                },

                get_slug: function (gallery_id) {
                    var slug = gallery_id;
                    if ('undefined' == typeof window.galleries) { return slug; }

                    $.each(galleries, function(index, gallery) {
                        if (gallery.slug && gallery.ID == gallery_id) {
                            slug = gallery.slug;
                        }
                    });

                    return slug;
                },

                open: function($el) {
                    if (this.mobile.browser.any()) {
                        this.fullscreen.enter();
                    }

                    // Define parameters for opening the Pro Lightbox
                    var params = {
                        show_sidebar: '',
                        gallery_id: '!',
                        image_id: '!',
                        slug: null,
                        revert_image_id: '!',
                        open_the_lightbox: true
                    };

                    // Determine if we should show the comment sidebar
                    if ($el.data('nplmodal-show-comments'))
                        params.show_sidebar = '/comments';

                    // Determine the gallery id
                    if ($el.data('nplmodal-gallery-id'))
                        params.gallery_id = $el.data('nplmodal-gallery-id');

                    // Determine the image id
                    if ($el.data('nplmodal-image-id'))
                        params.image_id = $el.data('nplmodal-image-id');
                    else if ($el.data('image-id'))
                        params.image_id = $el.data('image-id');
                    else if (params.gallery_id == '!')
                        params.image_id = $el.attr('href');

                    // Determine the slug
                    if (params.gallery_id !== '!') {
                        params.slug = this.get_slug(params.gallery_id);
                        if (params.slug !== 'undefined' && params.slug !== null) {
                            if (params.slug.toString().indexOf('widget-ngg-images-') !== -1) {
                                params.revert_image_id = params.image_id;
                                params.image_id = '!';
                            }
                        }
                    }

                    // Run any registered callbacks for modifying lightbox params
                    params = this.run_pre_open_lightbox_callbacks($el, params);

                    // Are we to still open the lightbox?
                    if (params.open_the_lightbox) {
                        // open the pro-lightbox manually
                        if (params.gallery_id == '!' || !this.get_setting('enable_routing')) {
                            this.open_modal(params.gallery_id, params.image_id, null);
                        } else {
                            // open the pro-lightbox through our backbone.js router
                            core.methods.router.front_page_pushstate(params.gallery_id, params.image_id);

                            this.router.navigate(
                                core.options.router_slug
                                + '/' + params.slug
                                + '/' + params.image_id
                                + params.show_sidebar
                            );

                            // some displays (random widgets) may need to disable routing
                            // but still pass an image-id to display on startup
                            if (params.revert_image_id !== '!') {
                                core.state.image_id = params.revert_image_id;
                            }
                        }
                    }
                },

                bind_images: function() {
                    // to handle ajax-pagination events this method is called on the 'refreshed' signal
                    var selector = nextgen_lightbox_filter_selector($, $(".nextgen_pro_lightbox"));

                    // Modify the selector to exclude any Photocrati Lightboxes
                    var new_selector = [];
                    for (var index = 0; index < selector.length; index++) {
                        var el = selector[index];
                        if (!$(el).hasClass('photocrati_lightbox_always') && !$(el).hasClass('decoy')) {
                            new_selector.push(el);
                        }
                    }

                    core.selector = $(new_selector);
                    core.selector.on('click', function (event) {
                        // pass these by
                        if ($.inArray($(this).attr('target'), ['_blank', '_parent', '_top']) > -1) {
                            return;
                        }

                        // NextGEN Basic Thumbnails has an option to link to an imagebrowser display; this disables the effect
                        // code (we have no gallery-id) but we may be asked to open it anyway if lightboxes are set to apply
                        // to all images. Check for and do nothing in that scenario:
                        if ($(this).data('src')
                        &&  $(this).data('src').indexOf(core.methods.get_setting('router_slug') + '/image') !== -1
                        &&  !$(this).data('nplmodal-gallery-id')) {
                            return;
                        }

                        event.stopPropagation();
                        event.preventDefault();

                        if (event.handled !== true) {
                            event.handled = true;
                            core.methods.open($(this));
                        }
                    });
                },

                // establishes bindings of events to actions
                set_events: function() {
                    var self = this;

                    $(window).on('refreshed', self.bind_images);
                    $(window).bind('keydown', self.handle_keyboard_input);

                    // handle exit clicks/touch events
                    $('#npl_overlay, #npl_button_close').on('touchstart click', function(event) {
                        event.stopPropagation();
                        event.preventDefault();
                        if (event.handled !== true) {
                            event.handled = true;
                            self.close_modal();
                        }
                    });
                },

                open_modal: function(gallery_id, image_id, sidebar) {
                    this._is_open = true;
                    var self = this;

                    // disables browser scrollbar display
                    $('html, body').toggleClass('nextgen_pro_lightbox_open');
                    core.state.image_id   = image_id;
                    core.state.gallery_id = gallery_id;

                    $('#npl_spinner, #npl_button_close').removeClass('hidden');

                    self.fullsize.exit();
                    self.mobile.open();

                    setTimeout(function() {
                        var images = core.methods.fetch_images.fetch_images(gallery_id, image_id);
                        var show_ndx = 0;
                        var show_hdpi = core.methods.getDPIRatio() > 1;

                        $.each(images, function(index, element) {
                            // Mark the requested image as the one to show at startup
                            if (image_id == element.image_id) {
                                show_ndx = index;
                            }

                            // In case we're viewing a WP or non-NGG image
                            if (typeof element.full_use_hdpi != 'undefined') {
                                // Massage our data for High-DPI screens
                                if (show_hdpi && element.full_use_hdpi) {
                                    element.image = element.full_srcsets.hdpi;
                                } else {
                                    // In case the plain 'image' is a dynamically-shrunk version:
                                    // we always want to use the 'full' size image when available
                                    element.image = element.full_image;
                                }
                            }
                        });

                        Galleria.run('#npl_content', {
                            responsive: true,
                            thumbQuality: false,
                            preload: 4,
                            theme: 'nextgen_pro_lightbox',
                            dataSource: images,
                            show: show_ndx,
                            variation:           'nggpl-variant-' + self.get_setting('style', ''),
                            transition:          self.get_setting('transition_effect', 'slide'),
                            touchTransition:     self.get_setting('touch_transition_effect', 'slide'),
                            imagePan:            self.get_setting('image_pan', false),
                            pauseOnInteraction:  self.get_setting('interaction_pause', true),
                            imageCrop:           self.get_setting('image_crop', true),
                            transitionSpeed:    (self.get_setting('transition_speed', 0.4) * 1000),
                            nggSidebar:          sidebar
                        });

                        $('#npl_spinner').addClass('hidden');
                    }, 5);
                },

                // When rotaning or opening the keyboard some mobile browsers increase the user zoom level beyond the default.
                // To handle this we update the viewport setting to disable zooming when open_modal is run and restore it to
                // the original value when calling close_modal()
                mobile: {
                    meta: null,
                    original: null, // original viewport setting; it's restored at closing
                    adjust: true,
                    ontouch: !!('ontouchstart' in window),
                    init: function() {
                        // suppress a warning in desktop chrome (provided no touch input devices are attached) that the following
                        // content meta-attribute we're about to set is invalid. it technically is, but it's the only way
                        // to make every mobile browser happy without ridiculous user agent matching that I've come across so far
                        if (!this.ontouch) {
                            this.adjust = false;
                        }
                        var version = this.ios_version();
                        var doc = window.document;
                        if (!doc.querySelector) { return; } // this isn't available on pre 3.2 safari
                        this.meta     = doc.querySelector("meta[name=viewport]");
                        this.original = this.meta && this.meta.getAttribute("content");
                    },
                    open: function() {
                        if (this.adjust && this.meta) {
                            this.meta.setAttribute("content", this.original + ', width=device-width, height=device-height, initial-scale=1.0, minimum-scale=1, maximum-scale=1, user-scalable=0, shrink-to-fit=no');
                        }
                    },
                    close: function() {
                        if (this.adjust && this.meta) {
                            this.meta.setAttribute("content", this.original);
                        }
                    },
                    ios_version: function() {
                        if (/iP(hone|od|ad)/.test(navigator.platform)) {
                            var v = (navigator.appVersion).match(/OS (\d+)_(\d+)_?(\d+)?/);
                            return [parseInt(v[1], 10), parseInt(v[2], 10), parseInt(v[3] || 0, 10)];
                        }
                    },
                    browser: {
                        any: function() {
                            return core.methods.mobile.browser.android()
                                || core.methods.mobile.browser.ios()
                                || core.methods.mobile.browser.windowsphone()
                                || core.methods.mobile.browser.blackberry();
                        },
                        android: function() {
                            return /Android/i.test(navigator.userAgent);
                        },
                        ios: function() {
                            return /crios|iP(hone|od|ad)/i.test(navigator.userAgent);
                        },
                        windowsphone: function() {
                            return /(iemobile|Windows Phone)/i.test(navigator.userAgent);
                        },
                        blackberry: function() {
                            return /(blackberry|RIM Tablet|BB10; )/i.test(navigator.userAgent);
                        }
                    },
                    hide_triggers: function() {
                        $('.ngg-trigger').each(function() {
                            var $this = $(this);
                            if ($this.hasClass('fa-comment') || $this.hasClass('fa-shopping-cart')) {
                                $this.hide();
                            }
                        });
                    }
                },

                // hide our content and close up
                close_modal: function() {
                    if (!this._is_open) {
                        return;
                    }

                    var content = $('#npl_content');

                    // allow for cleanup handlers to run
                    content.trigger('npl.closing');

                    this.fullsize.enter();
                    this.fullscreen.exit();

                    // for use with Galleria it is important that npl_content never have display:none set
                    $('#npl_spinner, #npl_button_close').addClass('hidden');

                    // enables displaying browser scrollbars
                    $('html, body').toggleClass('nextgen_pro_lightbox_open');

                    this.mobile.close();

                    // kills Galleria so it won't suck up memory in the background
                    content.data('galleria').destroy();

                    // reset our modified url to our original state
                    if (this.get_setting('enable_routing')) {
                        history.pushState('', document.title, window.location.pathname + window.location.search);
                        if (this.get_setting('is_front_page') && history.pushState) {
                            history.pushState({}, document.title, core.options.initial_url);
                        }
                    }

                    this._is_open = false;
                },

                fullsize: {
                    _is_fullsize: false,

                    enter: function() {
                        $('#npl_wrapper').removeClass('npl_open_with_padding');
                        this._is_fullsize = true;
                    },

                    exit: function() {
                        if (parseInt(core.methods.get_setting('padding', '0')) > 0
                        &&  !core.methods.mobile.browser.ios()) {
                            $('#npl_wrapper').addClass('npl_open_with_padding');
                        }

                        this._is_fullsize = false;
                    },

                    toggle: function() {
                        if (this.fullsize._is_fullsize) {
                            this.fullsize.exit();
                        } else {
                            this.fullsize.enter();
                        }
                        $(window).trigger('resize');
                    }
                },

                fullscreen: {
                    // make a request to enter fullscreen mode.
                    //
                    // NOTE: this can only be done in response to a user action; just calling enter_fullscreen() programatically
                    // will not work. Firefox & IE will produce errors, but Chrome (presently, 2013-04) silently fails
                    enter: function() {
                        // do not use a jquery selector, it will not work
                        var element = document.getElementById('npl_wrapper');

                        if (element.requestFullScreen) {
                            element.requestFullScreen();
                        } else if (element.mozRequestFullScreen) {
                            element.mozRequestFullScreen();
                        } else if (element.webkitRequestFullScreen) {
                            element.webkitRequestFullScreen();
                        }
                    },

                    exit: function() {
                        if (document.cancelFullScreen) {
                            document.cancelFullScreen();
                        } else if (document.mozCancelFullScreen) {
                            document.mozCancelFullScreen();
                        } else if (document.webkitCancelFullScreen) {
                            document.webkitCancelFullScreen();
                        }
                    },

                    toggle: function() {
                        if (document.fullScreen || document.mozfullScreen || document.webkitIsFullScreen) {
                            this.fullscreen.exit();
                        } else {
                            this.fullscreen.enter();
                        }
                    }
                },

                handle_keyboard_input: function(event) {
                    if (core.methods.is_open()) {
                        // escape key closes the modal
                        if (event.which == 27) {
                            core.methods.close_modal();
                        }
                    }
                },

                is_open: function() {
                    return this._is_open;
                },

                fetch_images: {
                    gallery_image_cache: [],
                    ajax_current: 0,
                    ajax_page: 1,
                    ajax_interval: null,
                    ajax_delay: 1400,

                    is_cached: function(gallery_id, image_id) {
                        var found = false;
                        $.each(this.gallery_image_cache[gallery_id], function (ndx, image) {
                            if (image_id == image.image_id) {
                                found = true;
                            }
                        });
                        return found;
                    },

                    fetch_images: function(gallery_id, image_id) {
                        var self = this;

                        this.ajax_delay = core.methods.get_setting('ajax_delay', 1400);

                        if (typeof this.gallery_image_cache[gallery_id] == 'undefined') {
                            this.gallery_image_cache[gallery_id] = [];
                        }

                        var gallery = core.methods.get_gallery_from_id(gallery_id);
                        if (gallery !== null) {
                            // the cache may not be filled thanks to a looping, async fetch
                            if (this.gallery_image_cache[gallery_id].length == gallery.images_list_count) {
                                return this.gallery_image_cache[gallery_id];
                            }

                            $.each(gallery.images_list, function(ndx, image) {
                                if (!self.is_cached(gallery_id, image.image_id)) {
                                    self.gallery_image_cache[gallery_id].push(image);
                                }
                            });

                            if (this.gallery_image_cache[gallery_id].length < gallery.images_list_count) {
                                this.fetch_images_from_page(gallery_id);
                                if (!this.is_cached(gallery_id, image_id)) {
                                    this.fetch_images_from_ajax(gallery_id, image_id);
                                } else {
                                    this.fetch_images_from_ajax(gallery_id);
                                }
                            }
                        }
                        else {
                            // It's not a NextGen gallery, just read from the page
                            this.fetch_images_from_page(gallery_id);
                        }

                        return this.gallery_image_cache[gallery_id];
                    },

                    fetch_images_from_page: function (gallery_id) {
                        var self = this;

                        core.selector.each(function() {
                            var anchor = $(this);

                            if (anchor.hasClass('ngg-trigger')) {
                                return true; // exclude NextGEN trigger icons
                            }

                            if (gallery_id !== '!' && gallery_id !== anchor.data('nplmodal-gallery-id')) {
                                return true; // exclude images from other galleries
                            }


                            if (gallery_id !== core.methods.get_state().gallery_id) {
                                return true; // exclude images from other galleries
                            }

                            if (core.methods.get_state().gallery_id == '!' && anchor.data('nplmodal-gallery-id')) {
                                return true; // when viewing non-nextgen images; exclude nextgen-images
                            }

                            var image         = $(this).find('img').first();
                            var gallery_image = {};
                            var expr          = /\.(jpeg|jpg|gif|png|bmp)$/;

                            gallery_image.image = (anchor.data('fullsize') == undefined) ? anchor.attr('href') : anchor.data('fullsize');

                            if (typeof gallery_image.image != 'undefined'
                            &&  !gallery_image.image.match(expr)
                            &&  image.attr('srcset')) {
                                var sizes = parseSrcset(image.attr('srcset'));
                                var largest_w = 0;

                                _.each(sizes, function (row) {
                                    if (typeof row.w != undefined && row.w > largest_w) {
                                        largest_w = row.w;
                                        gallery_image.image = row.url;
                                    }
                                });
                            }

                            // Workaround WP' "link to attachment page" feature
                            if (!gallery_image.image.match(expr)) {
                                gallery_image.image = image.attr('src');
                            }

                            // When in doubt we id images by their href
                            gallery_image.image_id = (anchor.data('image-id') == undefined) ? gallery_image.image : anchor.data('image-id');

                            // no need to continue
                            if (self.is_cached(gallery_id, gallery_image.image_id)) {
                                return true;
                            }

                            // optional attributes
                            if (anchor.data('thumb') !== undefined) gallery_image.thumb = anchor.data('thumb');
                            else if (anchor.data('thumbnail') !== 'undefined') gallery_image.thumb = anchor.data('thumbnail');

                            if (anchor.data('title') !== undefined) {
                                gallery_image.title = anchor.data('title');
                            } else if (typeof image.attr('title') !== 'undefined') {
                                gallery_image.title = image.attr('title');
                            } else if (typeof anchor.siblings('.wp-caption-text').html() !== 'undefined') {
                                gallery_image.title = anchor.siblings('.wp-caption-text').html();
                            }

                            if (anchor.data('description') !== undefined) {
                                gallery_image.description = anchor.data('description');
                            } else {
                                gallery_image.description = image.attr('alt');
                            }

                            self.gallery_image_cache[gallery_id].push(gallery_image);
                        });
                    },

                    fetch_images_from_ajax: function(gallery_id, image_id) {
                        if (!core.methods.is_open()) {
                            return;
                        }

                        // This must be done early to prevent more than one request being made
                        this.ajax_current++;

                        var self = this;
                        var async = (typeof image_id == 'undefined' || typeof image_id == 'boolean');
                        var content = $('#npl_content');

                        var original_gallery = core.methods.get_gallery_from_id(gallery_id);
                        var gallery = $.extend({}, original_gallery);
                        delete gallery.images_list;
                        delete gallery.display_settings;

                        $.ajax({
                            async: async,
                            url: core.options.ajax_url,
                            method: 'POST',
                            data: {
                                id: gallery_id,
                                gallery: gallery,
                                action: 'pro_lightbox_load_images',
                                lang: core.methods.get_setting('lang', null),
                                page: self.ajax_page
                            },
                            dataType: 'json',
                            success: function(data) {
                                if (async) {
                                    if (!core.methods.is_open()) {
                                        return;
                                    }
                                    $.each(data, function (ndx, newimage) {
                                        if (!self.is_cached(gallery_id, newimage.image_id)) {
                                            var galleria = content.data('galleria');
                                            content.trigger('npl.newimage', {image: newimage});
                                            self.gallery_image_cache[gallery_id].push(newimage);
                                            galleria.push(newimage);
                                            // the user has requested an image not on this page; once the ajax request has
                                            // loaded the image the user wants we ask that Galleria show it right away.
                                            // We use setTimeout() here because Galleria requires a minor pause after .push()
                                            if (newimage.image_id == core.state.image_id) {
                                                var ndxtoshow = self.gallery_image_cache[gallery_id].length - 1;
                                                setTimeout(function() {
                                                    galleria.show(ndxtoshow);
                                                }, 20);
                                            }
                                        }
                                    });

                                    // (possibly) start the whole procedure over again
                                    self.ajax_current--;
                                    self.set_fetch_interval(gallery_id);

                                } else if (!async) {
                                    $.each(data, function(ndx, newimage) {
                                        $('#npl_content').trigger('npl.newimage', {image: newimage});
                                        self.gallery_image_cache[gallery_id].push(newimage);
                                    });

                                    self.ajax_current--;
                                    if (!self.is_cached(gallery_id, image_id)) {
                                        // we haven't loaded the requested image id yet, keep making more
                                        // syncronous requests until we've pulled it from the server
                                        self.ajax_page++;
                                        self.fetch_images_from_ajax(gallery_id, image_id);
                                    } else {
                                        // Let the synchronous requests end; begin async polling for more at a reduced speed
                                        self.set_fetch_interval(gallery_id);
                                    }
                                }
                            }
                        });

                        return self.gallery_image_cache[gallery_id];
                    },

                    /**
                     * Assigns an interval timer to this.ajax_interval controlling how frequently we poll for new images
                     *
                     * @param gallery_id
                     */
                    set_fetch_interval: function(gallery_id) {
                        if (!core.methods.is_open() || this.ajax_interval !== null) {
                            return;
                        }

                        var self = this;
                        this.ajax_interval = setInterval(function() {
                            self.do_interval_fetch(gallery_id);
                        }, this.ajax_delay);
                    },

                    /**
                     * Determines if polling should continue and handles the interval check
                     *
                     * @param gallery_id
                     */
                    do_interval_fetch: function(gallery_id) {
                        // no more than one request at a time
                        if (this.ajax_current >= 1) {
                            return;
                        }

                        // stop if the pro lightbox is closed
                        if (!core.methods.is_open()
                            ||  gallery_id !== core.methods.get_state().gallery_id) {
                            clearInterval(this.ajax_interval);
                            this.ajax_interval = null;
                            return;
                        }

                        var gallery = core.methods.get_gallery_from_id(gallery_id);
                        if (this.gallery_image_cache[gallery_id].length < gallery.images_list_count) {
                            this.ajax_page++;
                            this.fetch_images_from_ajax(gallery_id);
                        } else {
                            // the cache is full, this loop now may end
                            clearInterval(this.ajax_interval);
                            this.ajax_interval = null;
                        }
                    }
                },

                get_gallery_from_id: function (gallery_id) {
                    if ('undefined' == typeof window.galleries) { return null; }
                    var retval = null;
                    $.each(galleries, function(index, gallery) {
                        if (gallery.ID == gallery_id) {
                            retval = gallery;
                        }
                    });
                    return retval;
                },

                get_id_from_slug: function (slug) {
                    var id = slug;
                    if ('undefined' == typeof window.galleries) { return id; }

                    $.each(galleries, function(index, gallery) {
                        if (gallery.slug == slug) {
                            id = gallery.ID;
                        }
                    });
                    return id;
                },

                get_displayed_gallery_setting: function(gallery_id, name, def) {
                    var tmp = '';
                    var gallery = this.get_gallery_from_id(gallery_id);
                    if (gallery && typeof gallery.display_settings[name] != 'undefined') {
                        tmp = gallery.display_settings[name];
                    } else {
                        tmp = def;
                    }
                    if (tmp == 1) tmp = true;
                    if (tmp == 0) tmp = false;
                    return tmp;
                },

                router: {
                    routes: [],
                    interval: null,

                    listen: function(current) {
                        var self = this;
                        current = current || '';

                        var listener = function() {
                            if (current !== self.get_fragment()) {
                                current = self.get_fragment();
                                self.match(current);
                            }
                        };
                        clearInterval(this.interval);
                        this.interval = setInterval(listener, 50);
                    },

                    get_fragment: function(url) {
                        url = url || window.location.href;
                        var match = url.match(/#(.*)$/);
                        var fragment = match ? match[1] : '';
                        return fragment.toString().replace(/\/$/, '').replace(/^\//, '');
                    },

                    navigate: function(path, notrigger) {
                        notrigger = notrigger || false;
                        if (notrigger) {
                            clearInterval(this.interval);
                        }

                        path = path ? path : '';
                        window.location.href.match(/#(.*)$/);
                        window.location.href = window.location.href.replace(/#(.*)$/, '') + '#' + path;

                        if (notrigger) {
                            this.router.listen(this.router.get_fragment());
                        }
                    },

                    match: function(f) {
                        var fragment = f || this.get_fragment();
                        for (var i = 0; i < this.routes.length; i++) {
                            var match = fragment.match(this.routes[i].re);
                            if (match) {
                                match.shift();
                                this.routes[i].handler.apply(core.methods, match);
                                return this;
                            }
                        }
                    },

                    front_page_pushstate: function(gallery_id, image_id) {
                        if (!core.methods.get_setting('is_front_page') || gallery_id == undefined) {
                            return false;
                        }

                        if ('undefined' == typeof window.galleries) {
                            return false;
                        }

                        var url  = '';
                        var slug = gallery_id;

                        $.each(galleries, function(index, gallery) {
                            if (gallery.ID == gallery_id) {
                                url = gallery.wordpress_page_root;
                                if (gallery.slug) {
                                    slug = gallery.slug;
                                }
                            }
                        });

                        url += '#' + this.get_fragment(core.methods.get_setting('router_slug') + '/' + slug + '/' + image_id);

                        // redirect those browsers that don't support history.pushState
                        if (history.pushState) {
                            history.pushState({}, document.title, url);
                            return true;
                        } else {
                            window.location = url;
                            return false;
                        }
                    }
                }
            }
        };

        this.core = core;
    }

    var nplModalObj = new nplModal();

    $.nplModal = function(param) {
        function getDescendantProp(obj, desc) {
            var arr = desc.split(".");
            while(arr.length) {
                obj = obj[arr.shift()];
            }
            return obj;
        }

        if (typeof param == 'undefined') {
            return nplModalObj.core.init.apply(nplModalObj, {});
        } else if (typeof param === 'object') {
            return nplModalObj.core.init.apply(nplModalObj, param);
        } else {
            var method  = getDescendantProp(nplModalObj.core.methods, param);
            if (method) {
                return method.apply(nplModalObj.core.methods, Array.prototype.slice.call(arguments, 1));
            } else {
                $.error('Method ' + param + ' does not exist on jQuery.nplModal');
            }
        }
    };

})(jQuery);

jQuery(document).ready(function($) {
    $.nplModal();
});
