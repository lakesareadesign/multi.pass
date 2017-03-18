(function($, doc, win){
	if( inc_opt.is_upfront ) return;

	var Optin = window.Optin || {};
	var logView = Backbone.Model.extend({
		url: inc_opt.ajaxurl + '?action=hustle_custom_content_viewed',
		defaults: {
			page_type: inc_opt.page_type,
            page_id: inc_opt.page_id,
            type: '',
            uri: encodeURI( window.location.href )
		},
		initialize: function() {
			this.on( 'error', this.server_error, this );
		},
		parse: function( res ) {
			if ( res.success ) {
				console.log('Log success!');
			} else {
				console.log('Log failed!');
			}
		},
		server_error: function() {
			console.log('Server error during log!');
		}
	}),

	logConversion = logView.extend({
		url: inc_opt.ajaxurl + '?action=hustle_custom_content_converted'
	});

	logView = new logView();
	logConversion = new logConversion();

	Optin.CCPopUp = Optin.View.extend({
		isCC: true,
		showClass: 'wph-modal-show',
		maskClass: 'wph-modal--mask',
		cookie_key: Hustle.consts.Never_See_Aagain_Prefix,
		events: {
			'click': 'click',
			'click .wph-modal--close .wph-icon': 'closed',
			'click .wph-modal--cta': 'fire_conversion_event',
			'click .wph-modal-never-see-again': 'closed',
			'submit form': 'on_form_submit'
		},

		initialize: function( opts ) {
			this.opt = opts;
			this.type = opts.type;
			this.data = opts.content;
			this.optin_id = this.data.optin_id;
			this.settings = opts[this.type];
			this.triggers = this.settings.triggers;
			this.appear_after = this.triggers.trigger + '_trigger';
			this.cookie_key += this.type + '-' + this.optin_id;
			this.expiration_days = this.settings.expiration_days ? parseInt( this.settings.expiration_days ) : 0;

			if ( ! this.should_display() ) {
				return;
			}

			this.model = _.extend(
				this.settings,
				opts.design,
				this.data,
				{
					id: this.optin_id,
					type: this.type,
					position: this.settings.position,
					types: {
						popup: opts.popup,
						slide_in: opts.slide_in
					}
				}
			);

			if ( _.contains( ['time', 'scrolled', 'adblock'], this.triggers.trigger )
				|| ( 'exit_intent_trigger' === this.appear_after && _.isTrue( this.settings.on_exit_intent_per_session ) ) ) {
				this.should_remove = true;
			}

			this.render();
		},

		/**
		 * Check if popup should display. **/
		should_display: function() {
			var never_see = Optin.cookie.get( this.cookie_key );
			never_see = parseInt( never_see ) === parseInt( this.optin_id );

			return this.opt.should_display[this.type] && !_.isTrue(never_see);
		},

		/**
		 * Trigger to completely hide this. **/
		never_see_again: function() {
			Optin.cookie.set( this.cookie_key, this.optin_id, this.expiration_days );
		},

		render: function() {
			this.model = _.extend( this.model,
				this.handle_custom_size( this.model ),
				this.enable_fullscreen( this.model ),
				this.sanitize_cta_url( this.model )
			);

			var template = Optin.template( 'hustle-modal-tpl' );
				template = template( this.model );

			this.setElement(template);
			this.$el.appendTo('body');
			this.$el.display = $.proxy( this, 'display' );
			this.$el.on( 'show', $.proxy( this, 'onShow' ) );
			this.$el.on( 'hide', $.proxy( this, 'onHide' ) );
			this.html = this.$el.html();

			// Log view
			Hustle.Events.once( 'cc_modal_shown', this.logView, this );
			// Fix content size
			Hustle.Events.on( 'cc_modal_shown', this.fit, this );
			Hustle.Events.on( 'hustle_resize', this.fit, this );

			this[this.appear_after]();
		},

		onShow: function() {
			// for adding proper classes
			$(document).trigger("wpoi:cc_display", [this.type, this.$el, this.model]);
			Hustle.Events.trigger("cc_modal_shown", this, this.type);
		},

		logView: function() {
			logView.set( 'type', this.type );
			logView.set( 'id', this.optin_id );
			logView.save();
		},

		fire_conversion_event: function(e) {
			var source = $(e.currentTarget).hasClass( "wph-modal--cta" ) ? "cta" : "form";

			Hustle.Events.trigger('cc_modal_converted', this, source);
			logConversion.set( 'id', this.optin_id );
			logConversion.set( 'type', this.type );
			logConversion.set( 'source', source );
			logConversion.save();
		},

		enable_fullscreen: function( data ) {
			data.fullscreen = '';

			if ( 'popup' === this.type && this.settings.make_fullscreen ) {
				data.fullscreen = 'wph-modal-popup-fullscreen';
			}

			return data;
		},

		handle_custom_size: function( data ){
			data.custom_size_attr = '';
			data.custom_size_class = '';

			if ( data.customize_size && _.isTrue( data.customize_size ) ) {
				data.customize_size_class = 'wph-modal--custom';
				data.custom_size_attr += 'data-custom_width='+ data.custom_width +' data-custom_height='+ data.custom_height +'';
			}
			if ( data.border && _.isTrue( data.border ) ) {
				data.custom_size_attr += ' data-border='+ data.border_weight;
			}

			return data;
		},

		on_form_submit: function(e) {
			var self = this,
                $form = $(e.target),
                on_submit = this.settings.on_submit;

            switch ( on_submit ){
				default:
				case 'refresh_or_close':
					this.closed(e);
					break;
                case "close":
				case 'close_after_form_submit':
					this.closed(e);

                    break;
                case "redirect":
				case 'redirect_to_form_target':
                    window.location.replace( $form.attr("action") );
                    break;
				case 'refresh_or_nothing':
					break;
            }
		}
	});

	Optin.CCSlideIn = Optin.CCPopUp.extend({
		key_prefix: '',
		hide_all_key: '',
		delay_time: 0,

		should_display: function() {
			this.key_prefix = Hustle.consts.Slide_Cookie_Prefix + this.optin_id;
			this.hide_all_key = Hustle.consts.Slide_Cookie_Hide_All + this.optin_id;
			this.delay_time = this.settings.hide_after_unit === "minutes" ? parseInt( this.settings.hide_after_val, 10 ) * 60 * 1000 : parseInt( this.settings.hide_after_val, 10 ) * 1000;

			var opt_cookie_never_see = Optin.cookie.get( this.cookie_key );

			if ( _.isFalse( opt_cookie_never_see ) ) {
				// Check prefix
				opt_cookie_never_see = Optin.cookie.get( this.key_prefix );
			}
			if ( _.isFalse( opt_cookie_never_see ) ) {
				// Check hide all
				opt_cookie_never_see = Optin.cookie.get( this.hide_all_key );
			}

			if ( 'keep_showing' === this.settings.after_close && opt_cookie_never_see ) {
				opt_cookie_never_see = false;
				Optin.cookie.set( this.cookie_key,  this.optin_id, 0 );
				Optin.cookie.set( this.key_prefix, this.optin_id, 0 );
				Optin.cookie.set( this.hide_all_key, this.optin_id, 0 );
			}

			return this.opt.should_display[this.type] && !_.isTrue(opt_cookie_never_see);
		},

		onShow: function() {
			if( _.isTrue( this.settings.hide_after ) ) {
                var me = this;

                var delay_id = _.delay(function(){
					if ( ! me.prevent_hide_after ) {
						// if hide after is not prevented, then hide it
                        me.$el.removeClass(this.showClass);
						me.mask.trigger('click');
					}
                }, this.delay_time );
            }

			Optin.CCPopUp.prototype.onShow.apply(this, arguments);
		},

		onHide: function() {
			var should_remove = false;

			if ( 'hide_all' === this.after_close ) {
				Optin.cookie.set( this.key_prefix, this.optin_id, 30 );
				should_remove = true;
			}
			if( 'no_show' === this.settings.after_close ) {
                Optin.cookie.set( this.hide_all_key,  this.optin_id, 30 );
				should_remove = true;
            }

			if ( should_remove ) {
				// Remove completely
				this.mask.remove();
				this.remove();
			}
		},

		click: function() {
			this.prevent_hide_after = true;
		}
	});

}(jQuery, document, window));