;(function ($, undefined) {

	window.Wds = window.Wds || {};

	window.Wds.Postlist = window.Wds.Postlist || {
		
		/**
		 * Simple post representation
		 *
		 * @param {Integer} post_id (Optional)
		 */
		Post: function (post_id) {
			
			var _post_id = parseInt(post_id, 10) || undefined,
				_title = '',
				_type = '',
				_date = '',
				_deferred = false
			;

			/**
			 * Checks post loaded state
			 *
			 * @return {Boolean}
			 */
			var is_loaded = function () {
				if (!_deferred) return false;
				return 'pending' !== _deferred.state();
			}

			/**
			 * Gets post instance ID
			 *
			 * @return {Integer} Post WP ID
			 */
			var get_id = function () {
				return _post_id || 0;
			};

			/**
			 * Gets post title
			 *
			 * @return {String} Post title
			 */
			var get_title = function () {
				return _title || '';
			};

			/**
			 * Gets post type
			 *
			 * @return {String} Post type
			 */
			var get_type = function () {
				return _type || '';
			};

			/**
			 * Gets post date
			 *
			 * @return {String} Post date
			 */
			var get_date = function () {
				return _date || '';
			};

			/**
			 * Gets post data as simple object
			 *
			 * @return {Object} Post data
			 */
			var get = function () {
				return {
					id: get_id(),
					title: get_title(),
					type: get_type(),
					date: get_date(),
					is_loaded: is_loaded()
				};
			};

			/**
			 * Dry-initializes data via passed post simple object
			 *
			 * @param {Object} data Post data
			 */
			var set = function (data) {
				_deferred = new $.Deferred();

				data = data || {};
				_post_id = parseInt(data.id, 10) || undefined;
				_title = data.title || '';
				_type = data.type || '';
				_date = data.date || '';

				_deferred.resolve();
			};

			/**
			 * Populates local post data via remote request
			 *
			 * @param {Integer} post_id Optional post ID
			 *
			 * @return {Object} jQuery Deferred promise
			 */
			var load = function (post_id) {
				var pid = parseInt(post_id, 10) || get_id(),
					prm
				;
				_deferred = new $.Deferred();
				prm = _deferred.promise();

				if (pid) {
					_post_id = pid;
					// Send post request
					$.post(ajaxurl, { action: 'wds-load_exclusion-post_data', id: pid }, _.noop, 'json')
						.done(function (data) {
							set(data);
						})
						.always(function () {
							setTimeout(dfr.resolve);
						})
					;
				} else {
					setTimeout(dfr.reject);
				}

				return dfr.promise();
			};

			return {
				get_id: get_id,
				get_title: get_title,
				get_type: get_type,
				get: get,
				set: set,
				load: load,
				is_loaded: is_loaded
			};
		},

		Selector: function (type) {

			var _post_types = Wds.get('postlist', 'post_types'),
				_lists = {},
				_is_open = false,
				_selector_template = Wds.tpl_compile(Wds.template('postlist', 'selector')),
				_list_template = Wds.tpl_compile(Wds.template('postlist', 'selector-list')),
				_item_template = Wds.tpl_compile(Wds.template('postlist', 'selector-list-item')),
				_close_callback = _.noop,

				_already_selected = [],

				_current_tab = false
			;

			var _handlers = {
				/**
				 * Event propagation helper
				 *
				 * @param {Object} e Event
				 *
				 * @return {Boolean} Always false
				 */
				stop: function (e) {
					if (e && e.stopPropagation) e.stopPropagation();
					if (e && e.preventDefault) e.preventDefault();
				},

				/**
				 * Closes the postlist popup and calls the update callback
				 *
				 * @param {Object} e Event
				 *
				 * @return {Boolean}
				 */
				close_and_update: function (e) {
					var $posts = WDP.overlay.box_content.find(".wds-postlist-selector-list-item:checked"),
						posts = []
					;
					$posts.each(function () {
						var $post = $(this),
							post = new Wds.Postlist.Post(),
							data = {
								id: $post.attr('data-id') || 0,
								title: $post.attr('data-title') || '',
								type: $post.attr('data-type') || '',
								date: $post.attr('data-date') || ''
							}
						;
						if (!data.id) return true;
						post.set(data);
						posts.push(post);
					});

					_close_callback(posts);
					close();

					return _handlers.stop(e);
				},

				/**
				 * Loads up the next/prev postlist page
				 *
				 * @param {Object} e Event
				 *
				 * @return {Boolean}
				 */
				paginate: function (e) {
					var $input = $(e.target),
						page = parseInt($input.val(), 10) || 0,
						list_type = $input.closest(".wds-postlist-list").find(":radio").val(),
						list = _lists[list_type]
					;

					if (!list) return false;
					if (!page || page <= 0) return false;
					if (page > (list.get_meta() || {}).total) return false;
					if (page == (list.get_meta() || {}).page) return false;

					list.load_posts(page).done(render);

					return _handlers.stop(e);
				},

				/**
				 * Vertical tab swapping handler
				 *
				 * Doing it here instead of relying on .vertical-tabs implementation quirks
				 *
				 * @param {Object} e Event
				 *
				 * @return {Boolean}
				 */
				swap_tab: function (e) {
					var $me = $(e.target).parent().find(":radio"),
						$all = $me.closest(".vertical-tabs").find(".wds-postlist-list :radio")
					;
					$all.attr("checked", false);
					$me.attr("checked", true);

					_handlers.recalc_height();
					_current_tab = $me.val();

					return _handlers.stop(e);
				},

				/**
				 * Recalculates vertical tabs (minimum) heights
				 *
				 * Side-effects only, needed because of the .vertical-tabs implementation
				 */
				recalc_height: function () {
					var $content = ((WDP.overlay || {}).box_content),
						$tabs, $tab, $box, minh, tabh, contenth, sidebarh
					;
					if (!($content || {}).length) return false;
					
					$tabs = $content.find(".vertical-tabs");
					if (!$tabs.length) return false;

					$tab = $content.find(".tab>:radio:checked").closest(".tab").find(".content");
					if (!$tab.length) return false;

					$box = $content.find(".box-footer");
					if (!$box.length) return false;

					tabh = parseInt($tab.css('min-height'), 10) || 10000;
					contenth = $tab.outerHeight() + $box.outerHeight();
					sidebarh = $tabs.find(".tab>label").outerHeight() * $tabs.find(".tab").length;

					minh = Math.max(contenth, sidebarh);

					$tabs.height(minh);
					if (tabh > minh) $tab.css("min-height", minh);
				}				
			};

			var get_selector = function () { return 'wds-postlist-selector'; };

			var open = function (close_callback, previous_selection) {
				_is_open = true;
				_already_selected = previous_selection || [];
				if (_is_open) WDP.showOverlay("#" + get_selector(), {});
				_close_callback = close_callback;
				render();
			};

			var close = function () {
				WDP.closeOverlay();
				_is_open = false;
			};

			var render = function () {
				var out = '',
					ptypes = [],
					plabels = {},
					current = _current_tab
				;

				_.each(_post_types, function (pto, ptype) {
					var label = (pto || {}).label;
					if (!label) return true;

					ptypes.push(ptype);
					plabels[ptype] = pto.label;
				});

				if (!current) current = _.first(ptypes);

				_.each(_.toArray(_lists), function (lst) {
					var list_out = '',
						list_type = lst.get_type()
					;
					_.each(lst.get_posts(), function (post) {
						var data = post.get();
						data.existing = _.some(_already_selected, function (sel) {
							return sel.get_id() === data.id;
						});
						list_out += _item_template(data);
					});
					out += _list_template({
						tab: list_type,
						tab_label: plabels[list_type],
						is_loading: lst.is_loading(),
						checked: (list_type === current ? 'checked' : ''),
						meta: lst.get_meta(),
						posts: list_out,
					});

				});
				$("#" + get_selector())
					.replaceWith(_selector_template({ lists: out }))
				;

				// Deal with the WDP weirdness
				if ((WDP.overlay || {}).box_content && (WDP.overlay || {}).box_content.find('.wds-postlist-selector').length > 0) {
					WDP.overlay.box_content.html($("#" + get_selector()).html());
					WDP.overlay.box_content
						.off("click.wds-selector", ".wds-postlist-selector+.buttons button")
						.on("click.wds-selector", ".wds-postlist-selector+.buttons button", _handlers.close_and_update)

						.off("change.wds-selector", ".wds-postslist-list-pagination select")
						.on("change.wds-selector", ".wds-postslist-list-pagination select", _handlers.paginate)

						// So this is to to the actual tabs
						.off("click.wds-selector", '.wds-postlist-list>label')
						.on("click.wds-selector", '.wds-postlist-list>label', _handlers.swap_tab)
					;
					WDP.positionOverlay();

					_handlers.recalc_height();
				}

			};

			var init = function () {
				var prms = [];
				_.each(_post_types, function (pto, type) {
					var list = new Wds.Postlist._List(type);
					
					prms.push(list.load_posts());
					
					_lists[type] = list;
				});
				$("body")
					.append(_selector_template({ lists: '' }))
				;
				$.when.apply($, prms).then(render);
			};

			setTimeout(init);

			return {
				open: open,
			}
		},

		/**
		 * General list abstraction
		 *
		 * @param {string} type List type
		 */
		_List: function (type) {

			this._type = type || 'general';
			this._posts = [];
			this._cache = {};
			this._meta = {};

			this.get_type = function () { return this._type; };

			this.is_loading = function () { return _.isEmpty(this.get_meta()); };

			/**
			 * Adds a post by its ID to internal list and cache
			 *
			 * Also initializes the post
			 *
			 * @param {Integer} pid Post WP ID
			 * @param {Function} cback Optional callback
			 */
			this.add = function (pid, cback) {
				var post = new Wds.Postlist.Post(),
					me = this
				;

				if (this.has(pid)) return false;

				if (this._cache[pid]) {
					post.set(this._cache[pid]);
				} else {
					post.load(pid).done(function () {
						me._cache[pid] = post.get();
						if (cback) cback();
					});
				}
				this._posts.push(post);
			};

			/**
			 * Removes post from the internal list, by ID
			 *
			 * @param {Integer} pid Post WP ID
			 */
			this.remove = function (pid) {
				this._posts = _(this._posts).reject(function (post) {
					return post.get_id() === pid;
				});
			};

			/**
			 * Adds initialized post to internal list and cache
			 *
			 * Also initializes the post
			 *
			 * @param {Object} post A Wds.Postlist.Post instance
			 */
			this.add_post = function (post) {
				var pid = post.get_id();
				if (this.has(pid)) return false;

				this._cache[pid] = post.get();
				this._posts.push(post);
			};

			/**
			 * Check if the current post ID is already in the list
			 *
			 * @param {Integer} pid Post WP ID
			 *
			 * @return {Boolean} [description]
			 */
			this.has = function (pid) {
				return _.contains(
					_.invoke(this._posts, 'get_id'),
					pid
				);
			}

			this.get_cached = function (pid) {
				return this._cache[pid] || false;
			};

			this.get_meta = function () {
				return this._meta || {};
			}

			this.get_post = function (pid) {
				return this._posts[pid] || false;
			};

			this.get_posts = function () {
				return this._posts;
			};

			/**
			 * Bulk-load posts for certain type
			 *
			 * @param {Mixed} arg Either a page offset for paged request (optional - integer), or (Array)post IDs
			 *
			 * @return {Object} jQuery Deferred promise
			 */
			this.load_posts = function (arg) {
				this._posts = [];
				this._meta = {};
				var dfr = new $.Deferred(),
					me = this
					pg = _.isArray(arg) ? false : (arg || 0),
					ps = _.isArray(arg) ? arg : [],
					_load_paged_posts = function (type) {
						return $.post(ajaxurl, {
							action: 'wds-load_exclusion_posts-posts_data-paged',
							type: type,
							page: pg
						}, _.noop, 'json');
					},
					_load_specific_posts = function (type) {
						return $.post(ajaxurl, {
							action: 'wds-load_exclusion_posts-posts_data-specific',
							type: type,
							posts: ps
						}, _.noop, 'json');
					},
					promise = false === pg && ps.length ? _load_specific_posts(this.get_type()) : _load_paged_posts(this.get_type())
				;
				promise
					.done(function (data) {
						var posts = (data || {}).posts || [],
							meta = (data || {}).meta
						;
						_.each(posts, function (raw) {
							var post = new Wds.Postlist.Post();
							post.set(raw);
							me.add_post(post);
						});
						me._meta = meta;
						if (posts.length || !_.isEmpty(meta)) dfr.resolve();
					})
					.fail(dfr.reject)
					.always(function () {
						var state = dfr.state();
						if ('resolved' !== state && 'rejected' !== state) setTimeout(dfr.reject);
					})
				;
				return dfr.promise();
			};


			return this;
		},

		/**
		 * Post list rendering implementation
		 *
		 * @param {Object} $root Root element
		 * @param {String} $type List type
		 */
		List: function ($root, type) {

			var _list = new Wds.Postlist._List(type),
				_loaded = false,
				_list_template = Wds.tpl_compile(Wds.template('postlist', _list.get_type())),
				_post_item_template = Wds.tpl_compile(Wds.template('postlist', _list.get_type() + '-item')),
				_$box = $root.find(":text"),
				_selector = new Wds.Postlist.Selector('exclude')
			;

			var _handlers = {
				/**
				 * Event propagation helper
				 *
				 * @param {Object} e Event
				 *
				 * @return {Boolean} Always false
				 */
				stop: function (e) {
					if (e && e.stopPropagation) e.stopPropagation();
					if (e && e.preventDefault) e.preventDefault();
				},

				remove: function (e) {
					var id = parseInt($(e.target).closest('tr').attr('data-id'), 10) || 0;
					if (!id) return _handlers.stop();

					_list.remove(id);
					sync();

					return _handlers.stop();
				},

				open_selector: function (e) {
					_selector.open(_handlers.selected, _list.get_posts());
					return _handlers.stop(e);
				},

				selected: function (posts) {
					if (!(posts || []).length) return false;
					_.each(posts, function (post) {
						_list.add_post(post);
					});
					sync();
				}
			};

			var boot = function () {
				box_to_list();
				render();

				$root.on('click', 'a[rel="dialog"]', _handlers.open_selector);
				$root.on('click', 'a[href="#remove"]', _handlers.remove);
			};

			var destroy = function () {
				var selector = 'wds-postlist-list-' + _list.get_type();
				$root
					.find("." + selector).remove().end()
					.find(".wds-replaceable").show().end()
				;
				$root.off('click', 'a[rel="dialog"]');
				$root.off('click', 'a[href="#remove"]');
			};

			/**
			 * Actually renders the post list
			 */
			var render = function () {
				var selector = 'wds-postlist-list-' + _list.get_type(),
					out = ''
				;
				$root
					.find("." + selector).remove().end()
					.find(".wds-replaceable").hide().end()
				;
				_.each(_list.get_posts(), function (post) {
					out += _post_item_template(post.get());
				});
				$root.append(
					_list_template({posts: out, loaded: _loaded})
				);

				window.Wds.readjust_vertical_tabs_height();
			};

			/**
			 * Converts box content to internal post list representation
			 */
			var box_to_list = function () {
				var raw = _.map(_$box.val().split(','), $.trim),
					ps = []
				;
				_loaded = false;
				_.each(raw, function (pid) {
					pid = parseInt(pid, 10);
					if (!pid) return true;

					ps.push(pid);
				});
				
				if (!ps.length) {
					_loaded = true;
				} else {
					_list.load_posts(ps)
						.always(function () {
							_loaded = true;
						})
						.done(function () {
							setTimeout(render);
						})
						.fail(destroy)
					;
				}
			};

			/**
			 * Converts internal list post list to box representation
			 */
			var list_to_box = function () {
				var list = [];
				_.each(_list.get_posts(), function (post) {
					var pid = post.get_id();
					if (pid) list.push(pid);
				});
				_$box.val(list.join(", "));
			};

			/**
			 * Updates text box and re-renders the list
			 */
			var sync = function () {
				list_to_box();
				render();
			};

			return {
				boot: boot,
				sync: sync,
				destroy: destroy
			};

		},
		
		exclude: function ($el) {
			var list = new Wds.Postlist.List($el, 'exclude');
			list.boot();
		}
	};

})(jQuery);
