/*! CoursePress - v3.0.0
 * https://premium.wpmudev.org/project/coursepress-pro/
 * Copyright (c) Thu Jul 06 2017; * Licensed GPLv2+ */
/* jshint -W065 */
/* global jQuery, Backbone */

(function() {
    'use strict';

    window.CoursePress = (function ($, doc, win) {
        var self = {
            Events: Backbone.Events || {}
        };

        self.Define = function (name, callback) {

            if ( !self[name] ) {
                self[name] = callback.call(null, $, doc, win);
            }
        };

        self.Cookie = function( cookie_name ) {
            var cookies, name;

                cookies = {},
                name = cookie_name + '_' + win._coursepress.cookie.hash;

            return {
                get: function() {
                    // Get the list of available cookies
                    doc.cookie.split(';').map(this.trim).map(this.toObject);

                    return cookies[name] ? cookies[name] : null;
                },
                set: function( cookie_value, time ) {
                    var d, expires;
                    d = new Date();
                    expires = d.getTime() + parseInt(time);

                    doc.cookie = name + '=' + cookie_value + ';expires=' + expires + ';path=' + win._coursepress.cookie.path;
                },
                unset: function() {

                },
                trim: function(cookie) {
                    cookie = cookie.trim();
                    return cookie;
                },
                toObject: function(cookie) {
                    cookie = cookie.split('=');
                    cookies[cookie[0]] = cookie[1];
                }
            };
        };

        return self;
    }(jQuery, document, window));
})();

/* global CoursePress, Backbone */

(function() {
    'use strict';

    CoursePress.Define('Request', function ($, doc, win) {
        return Backbone.Model.extend({
            url: win._coursepress.ajaxurl + '?action=coursepress_request',
            defaults: {
                _wpnonce: win._coursepress._wpnonce
            },

            initialize: function () {
                this.on('error', this.serverError, this);

                Backbone.Model.prototype.initialize.apply(this, arguments);
            },

            parse: function ( response ) {
                var action = this.get('action');

                if ( response.success ) {
                    this.trigger('coursepress:success_' + action, response.data);
                } else {
                    this.trigger('coursepress:error_' + action, response.data);
                }
            },

            serverError: function () {
                // @todo: Show friendly error here
            }
        });
    });
})();
/* global CoursePress, _, Backbone */

(function(){
    'use strict';

    CoursePress.Define('View', function ($) {
        _.mixin({
            isTrue: function (value, selected) {
                if (_.isArray(selected) ) {
                    return _.contains(selected, value);
                } else if (_.isObject(selected ) ) {
                    return !!selected[value];
                } else {
                    if ( _.isBoolean( value ) ) {
                        selected = parseInt(selected, 10) > 0 ? true : false;
                    }
                    return value === selected;
                }
            },
            checked: function (value, selected) {
                return _.isTrue(value, selected) ? 'checked="checked"' : '';
            },
            selected: function (value, selected) {
                return _.isTrue(value, selected) ? 'selected="selected"' : '';
            },
            _getTemplate: function (template_id, data) {
                var settings = {
                        evaluate: /<#([\s\S]+?)#>/g,
                        interpolate: /\{\{\{([\s\S]+?)\}\}\}/g,
                        escape: /\{\{([^\}]+?)\}\}(?!\})/g
                    },
                    tpl = $('#' + template_id);

                if ( tpl.length ) {
                    tpl = _.template( tpl.html(), null, settings);
                }

                return tpl(data);
            }
        });

        return Backbone.View.extend({
            template_id: '',
            model: {},
            events: {
                'change [name]': 'updateModel'
            },
            initialize: function () {
                if (arguments && arguments[0]) {
                    this.model = new CoursePress.Request(arguments[0]);
                }
                this.render();
            },
            render: function () {
                if ( ! _.isEmpty(this.template_id) ) {
                    var data = !!this.model.get ? this.model.toJSON() : this.model;
                    this.$el.html(_._getTemplate(this.template_id, data));
                }

                this.trigger( 'view_rendered' );

                /**
                 * Trigger whenever the view template is loaded
                 */
                CoursePress.Events.trigger('coursepress:view_rendered', this);

                return this;
            },
            updateModel: function(ev) {
                var input, name, type, value;

                input = $(ev.currentTarget);
                name = input.attr('name');

                if ( ( type = input.attr('type') ) &&
                    _.contains(['checkbox', 'radio'], type ) ) {
                    value = input.is(':checked') ? input.val() : false;
                } else {
                    value = input.val();
                }

                if ( !!this.model.get ) {
                    this.model.set(name, value);
                } else {
                    this.model[name] = value;
                }
            }
        });
    });
})();
/* global CoursePress */

(function() {
    'use strict';

    CoursePress.Define( 'CourseOverview', function( $ ) {
        var Progress;

        Progress = CoursePress.View.extend({
            render: function() {
                var data = _.extend({
                    animation: {duration: 1200}
                }, this.$el.data() );

                this.$el.circleProgress({
                    fill: {
                        color: data.fillColor
                    },
                    emptyFill: data.emptyFill,
                    animation: data.animation
                });

                this.data = data;
                this.$el.on( 'circle-animation-progress', this.animationProgress );
            },

            animationProgress: function( e, v ) {
                var obj = $(this).data( 'circle-progress' ),
                    ctx = obj.ctx,
                    s = obj.size,
                    sv = (100 * v).toFixed(),
                    ov = (100 * obj.value ).toFixed();
                sv = 100 - sv;

                if ( sv < ov ) {
                    sv = ov;
                }
                ctx.save();

                if ( obj.knobTextShow ) {
                    ctx.font = s / obj.knobTextDenominator + 'px sans-serif';
                    ctx.textAlign = obj.knobTextAlign;
                    ctx.textBaseline = 'middle';
                    ctx.fillStyle = obj.knobTextColor;
                    ctx.fillText( sv + '%', s / 2 + s / 80, s / 2 );
                }

                ctx.restore();
            }
        });

        $('.course-progress-disc').each(function() {
            var UnitProgress = Progress.extend({
                el: this
            });
            UnitProgress = new UnitProgress();
        });
    });
})();