;(function ($, undefined) {

	window.Wds = window.Wds || {};

	window.Wds.Service = window.Wds.Service || {

		/**
		 * Service poll interval (in seconds)
		 *
		 * @var {NUMBER}
		 */
		POLL_INTERVAL: 30,

		Request: function () {
			var _started = false,
				_ended = false,
				_updated = false,
				_tmout = false,
				_percentage = 0
			;

			/**
			 * Perform remote request
			 *
			 * @access @private
			 *
			 * @param {string} verb Action suffix
			 *
			 * @return {Object} Deferred promise
			 */
			function request (verb) {
				return $.post(ajaxurl, {
					action: 'wds-service-' + verb
				});
			}

			/**
			 * Service start method
			 *
			 * @access @private
			 *
			 * @return {Object} Deferred promise
			 */
			function start () {
				var dfr = new $.Deferred(),
					me = this
				;
				_started = false;
				_ended = false;
				_updated = false;
				_percentage = 0;
				request('start')
					.done(function (data) {
						var success = !("success" in (data || {}));
						if (success) {
							_started = true;
							dfr.resolve();
						} else {
							_started = false;
							dfr.rejectWith(me, [data]);
						}
					})
					.fail(function () {
						_started = false;
						dfr.reject();
					})
				;
				return dfr;
			}

			function started () {
				_started = true;
			}

			/**
			 * Status polling method
			 *
			 * Starts the service request cascade if not started already
			 *
			 * @access @public
			 *
			 * @return {Object} Deferred promise
			 */
			function status () {
				var dfr = new $.Deferred(),
					me = this
				;
				if (!_started) {
					start()
						.done(function () {
							status()
								.done(function (percentage) {
									_updated = (new Date()).time;
									dfr.resolveWith(me, [percentage]);
								})
								.fail(function (data) {
									dfr.rejectWith(me, [data]);
								})
							;
						})
						.fail(function (data) {
							dfr.rejectWith(me, [data]);
						})
					;
				} else {
					setTimeout(function () {
						request('status')
							.done(function (data) {
									var pct = parseInt((data || {}).percentage, 10) || 0,
										end = (data || {}).end || false,
										success = !("success" in (data || {}))
									;
									if (end) _ended = true;
									if (success) {
										_percentage = pct;
										_updated = (new Date()).time;
										dfr.resolveWith(me, [pct]);
									} else {
										dfr.rejectWith(me, [data]);
									}
							})
							.fail(function (data) {
								dfr.rejectWith(me, [data]);
							})
						;
					}, Wds.Service.POLL_INTERVAL * 1000);
				}

				return dfr;
			}

			/**
			 * Simplistic result polling method
			 *
			 * @return {Object} Deferred promise
			 */
			function result () {
				var dfr = new $.Deferred(),
					me = this
				;
				request('result')
					.done(function (data) {
						var success = !("success" in (data || {}))
						_ended = true;
						if (success) dfr.resolveWith(me, [data]);
						else dfr.rejectWith(me, [data]);
					})
					.fail(function () {
						dfr.reject();
					})
					.always(function () {
						_started = false;
						_percentage = 0;
						_updated = false;
						_ended = true;
					})
				;
				return dfr;
			}

			/**
			 * Status polling method
			 *
			 * Periodically runs the status callback, and checks where we are.
			 * On status update, notifies progress update.
			 * On complete, polls results callback
			 *
			 * @access @public
			 *
			 * @return {Object} Deferred promise
			 */
			function status_update () {
				var me = this,
					dfr = new $.Deferred,
					cback = function () {
						clearTimeout(_tmout);
						if (_ended) {
							result()
								.done(function (data) {
									dfr.resolveWith(me, [data]);
								})
								.fail(function (data) {
									dfr.rejectWith(me, [data]);
								})
							;
						} else {
							_tmout = setTimeout(function () {
								status()
									.done(function () {
										dfr.notify(_percentage);
										cback();
									})
									.fail(function (data) {
										dfr.rejectWith(me, [data]);
									})
								;
							}, 1000);
						}
					}
				;
				clearTimeout(_tmout);
				cback();


				return dfr;
			}

			/**
			 * Gets last updated timestamp
			 *
			 * @access @public
			 *
			 * @return {Number} Last meaningful update time received
			 */
			function get_updated () {
				return _updated || 0;
			}

			return {
				status: status,
				started: started,
				update: status_update,
				get_last_update_time: get_updated,
			};
		},

		Report: function ($el) {

			var _$root = $el;

			var redirect = function (data) {
				data = data || {};
				data.action = 'wds-service-redirect';
				return $.post(ajaxurl, data, function(){}, 'json');
			}

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

				toggle_actions: function (e) {
					var $tgt = $(e.target).closest(".wds-issue-actions").find(".wds-issue-actions-options"),
						is_visible = $tgt.is(":visible")
					;
					$(".wds-issue-actions-options").removeClass("wds-visible").hide(); // Start by hiding all

					if (is_visible) {
						$tgt
							.removeClass("wds-visible").hide()
							.closest(".wds-issue-actions").removeClass("wds-visible")
						;
					} else {
						$tgt
							.addClass("wds-visible").show()
							.closest(".wds-issue-actions").addClass("wds-visible")
						;
					}

					return _handlers.stop(e);
				},

				_get_dialog: function (root, type) {
					return $(root).closest(".wds-issue-item").find("dialog.wds-" + type);
				},

				list_occurences: function (e) {
					var $dialog = _handlers._get_dialog(e.target, 'occurences'),
						dialog_id = $dialog.attr("id")
					;

					if (dialog_id) WDP.showOverlay('#' + dialog_id);

					return _handlers.stop(e);
				},

				redirect: function (e) {
					var $dialog = _handlers._get_dialog(e.target, 'redirect'),
						dialog_id = $dialog.attr("id")
					;

					if (dialog_id) WDP.showOverlay('#' + dialog_id);

					WDP.overlay.box_content
						.off('click', 'button')
						.on('click', 'button', _handlers.do_redirect)
					;

					return _handlers.stop(e);
				},

				do_redirect: function (e) {
					var $root = $(e.target).closest('.wds-redirect'),
						$fields = $root.find("input"),
						data = {}
					;

					$fields.each(function () {
						var $me = $(this);
						data[$me.attr("name")] = $me.val();
					});

					redirect(data)
						.always(function () {
							$root.find(".close").click();
						})
					;

					return _handlers.stop(e);
				},

				fix: function (e) {
					var $tgt = $(e.target),
						$issues = $tgt.closest('.wds-service-issue').find('.wds-issue-items')
					;

					if (!$issues.is(":visible")) {
						$issues
							.addClass("wds-expanded").show()
							.closest(".wds-service-issue").addClass("wds-expanded")
						;
					} else {
						$issues
							.removeClass("wds-expanded").hide()
							.closest(".wds-service-issue").removeClass("wds-expanded")
						;
					}

					return _handlers.stop(e);
				}
			};


			var init = function () {
				if (!_$root.length) return false;

				_$root

					.off("click", ".wds-issue-actions a[href='#actions']")
					.on("click", ".wds-issue-actions a[href='#actions']", _handlers.toggle_actions)

					.off("click", ".wds-issue-actions .wdv-icon-remove")
					.on("click", ".wds-issue-actions .wdv-icon-remove", _handlers.toggle_actions)

					.off("click", ".wds-issue-actions-options a[href='#list']")
					.on("click", ".wds-issue-actions-options a[href='#list']", _handlers.list_occurences)

					.off("click", ".wds-issue-actions-options a[href='#redirect']")
					.on("click", ".wds-issue-actions-options a[href='#redirect']", _handlers.redirect)

					.off("click", "button.wds-fix")
					.on("click", "button.wds-fix", _handlers.fix)
				;
			};

			init();

			return {

			}
		},
	}

})(jQuery);


;(function ($, undefined) {

	function get_bar_selector () {
		return '.wds-seo_service-run .wds-progress-bar';
	}
	function get_notice_selector () {
		return '.wds-progress-bar-current-percent';
	}
	function get_checking_msg_selector () {
		return '.wds-seo_service-run .wds-progress-state-text';
	}

	function run_updates (started) {
		var srv = new Wds.Service.Request(),
			bar_selector = get_bar_selector(),
			notice_selector = get_notice_selector(),
			checking_msg_selector = get_checking_msg_selector(),
			dfr,
			_tmout = false,
			previous_time = false,
			working_notice = Wds.l10n('service', 'Checking the site ...'),
			waiting_notices = [
				Wds.l10n('service', 'Still working ...'),
				Wds.l10n('service', 'Waiting for service response ...'),
				Wds.l10n('service', 'Request queued, waiting ...')
			]
		;

		if (started) {
			srv.started();
		}
		dfr = srv.update();

		if (!dfr) return false;

		/**
		 * Updates the status notice message if the process takes too long
		 */
		var wrkmsg_interval_handler = function () {
			var upd = srv.get_last_update_time();
			if (0 === upd || previous_time === upd) {
				$(checking_msg_selector).text(
					waiting_notices[Math.floor(Math.random() * waiting_notices.length)]
				);
			} else {
				previous_time = upd;
				$(checking_msg_selector).text(working_notice);
			}
		};

		/**
		 * Launches the status notice update timer
		 */
		var wrkmsg_interval_setup = function () {
			clearInterval(_tmout);
			_tmout = setInterval(wrkmsg_interval_handler, Wds.Service.POLL_INTERVAL * 1000);
		};

		wrkmsg_interval_setup();

		dfr
			.progress(function (pct) {
				pct = parseInt(pct, 10) || 0;
				if (pct > 100) pct = 100;

				var percentage = pct + '%';
				$(bar_selector)
					.css({width: percentage})
					.find(notice_selector).text(percentage)
				;

				// Reboot status notice
				$(checking_msg_selector).text(working_notice);
				wrkmsg_interval_setup();
			})
			.done(function (result) {
				var issues = (result || {}).issues || {};
				$(bar_selector)
					.css({width: '100%'})
					.find(notice_selector).text(Wds.l10n('service', 'Parsing results'))
				;
				clearInterval(_tmout);
				setTimeout(function () {
					window.location.reload();
				});
			})
			.fail(function (data) {
				var msg = (data || {}).message || Wds.l10n('service', 'Something went wrong');
				var code = (data || {}).code || false;

				clearInterval(_tmout);

				if (code && 'crawl_cooldown' == code) {
					$(checking_msg_selector).text(Wds.l10n('service', 'Come back in a few minutes ...'));
				} else {
					$(checking_msg_selector).text(working_notice);
				}
				$(bar_selector)
					.css({width: '100%'})
					.find(notice_selector).text(msg)
				;
			})
			.always(function () {
				clearInterval(_tmout);
			})
		;

	}

	function init_dashboard () {
		var bar_selector = get_bar_selector();
		if ($(bar_selector).length) {
			run_updates(true);
		}

		/**
		 * Analysis launch
		 */
		$('a[href="#run-seo-analysis-modal"]').on("click", function () {
			var $wrapper = $(this).closest(".dev-box"),
				$hubs = $wrapper.find(".box-content"),
				$hub = $hubs.length > 1 ? $hubs.filter(".wds-seo_service-results-parent") : $hubs,
				markup = Wds.template('service', 'run') || '',
				notice_selector = get_notice_selector()
			;

			if (!$hub.length || !markup.length) return false;
			$hubs.empty();
			$hubs = $wrapper.find(".box-content");
			$hub = $hubs.filter(".wds-seo_service-results-parent");
			($hub.length ? $hub : $hubs).replaceWith(markup);

			$(bar_selector)
				.css({width: '100%'})
				.find(notice_selector).text(Wds.l10n('service', 'Connecting'))
			;
			run_updates(false);
		});

		/**
		 * Sitemap URLs listing handling
		 */
		$('a[href="#toggle-sitemap-urls"]').on('click', function (e) {
			if (e && e.preventDefault) e.preventDefault();
			if (e && e.stopPropagation) e.stopPropagation();

			var $list = $(this).closest(".wds-sitemap").find(".wds-sitemap-issues_list");
			if (!$list.length) return false;

			if ($list.is(":visible")) $list.hide();
			else $list.show();

			return false;
		})

		/**
		 * Sitemap updates handling
		 */
		$(document).on("click", ".wds-update-sitemap", function (e) {
			if (e && e.preventDefault) e.preventDefault();
			if (e && e.stopPropagation) e.stopPropagation();

			var $el = $(".wds-update-sitemap"),
				working_msg = $el.attr("data-working") || $el.text() + "&hellip;",
				static_msg = $el.attr("data-static") || $el.text(),
				done_msg = $el.attr("data-done") || static_msg,
				done = function () {
					$el.text(done_msg);
					setTimeout(function () {
						window.location.reload();
					});
				}
			;

			$el.text(working_msg);
			$.post(ajaxurl, {"action": "wds-service-update_sitemap"}, done).always(done);

			return false;
		});

		var report = new Wds.Service.Report($(".wds-seo_service-results"));
	}

	function init () {
		if ($("body").is(".toplevel_page_wds_wizard")) init_dashboard();
	}

	// Boot
	$(init);

})(jQuery);
