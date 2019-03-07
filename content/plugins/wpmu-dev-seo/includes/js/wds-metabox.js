(function ($) {

	/**
	 * Handles change/keyup event onpage metabox fields dispatch
	 *
	 * @param {Object} e Event object (optional)
	 */
	function classic_post_fields_change_handler (e) {
		var $currentTarget = $(e.currentTarget),
			field = $currentTarget.is('#title')
				|| $currentTarget.is('#content')
				|| $currentTarget.is('#excerpt');

		if( field ){
			refresh_meta_field_placeholders_ajax();
		}

	}

	function refresh_meta_field_placeholders_ajax() {
		$.post(ajaxurl, {
			id: get_post_data().post_id,
			action: "wds_metabox_update",
			post: get_post_data(),
			_wds_nonce: _wds_metabox.nonce
		}, 'json').done(function (rsp) {
			var description = (rsp || {}).description || '',
				title = (rsp || {}).title || '';

			$('#wds_title').attr('placeholder', title);
			$('#wds_metadesc').attr('placeholder', description);
		});
	}

	function is_classic_editor_active() {
		return $('input#title').length && (wp || {}).autosave;
	}

	function is_gutenberg_active() {
		var data = (wp || {}).data;
		return data && data.select && data.dispatch;
	}

	function get_post_data() {
		if (is_gutenberg_active()) {
			return get_gutenberg_data();
		} else if (is_classic_editor_active()) {
			return wp.autosave.getPostData();
		}

		return {};
	}

	function get_gutenberg_data() {
		var fields = ['content', 'excerpt', 'post_author', 'post_id', 'post_title', 'post_type'],
			data = {};

		_.each(fields, function (field) {
			data[field] = wp.data.select("core/editor").getEditedPostAttribute(field.replace('post_', '')) || '';
		});

		if (!data.post_id) {
			data.post_id = $('#post_ID').val() || 0;
		}

		return data;
	}

	function refresh_meta_field_placeholders() {
		if (is_classic_editor_active()) {
			// The following line will trigger a call to ajax wds_metabox_update
			$('input#title').trigger('input');
		} else {
			refresh_meta_field_placeholders_ajax();
		}
	}

	function hook_classic_editor_listeners() {
		window.setTimeout( function() {
			var editor = typeof tinymce !== 'undefined' && tinymce.get('content');
			if( editor ) {
				editor.on('change', function(e) {
					e.currentTarget = $('#content');
					_.debounce(classic_post_fields_change_handler.bind(e), 1000);
				});
			}
		}, 1000 );
		$(document).on("input","input#title,textarea#content,textarea#excerpt",_.debounce(classic_post_fields_change_handler, 1000)).trigger('input');
	}

	function hook_gutenberg_listeners() {
		if (!is_gutenberg_active()) {
			return;
		}

		var debounced = _.debounce(refresh_meta_field_placeholders_ajax, 5000);
		wp.data.subscribe(function () {
			if (wp.data.select("core/editor").isEditedPostDirty()) {
				debounced();
			}
		});
	}

	function init() {
		if (is_gutenberg_active()) {
			hook_gutenberg_listeners();
		} else if (is_classic_editor_active()) {
			hook_classic_editor_listeners();
		}

		$('.wds-horizontal-tab-nav').on('click', '.wds-nav-item', function () {
			$('.wds-horizontal-tab-nav .active').removeClass('active');
			$(this).addClass('active');
		});

		var tlimit = (l10nWdsCounters || {}).title_limit || 70;
		Wds.optimum_length_indicator($('#wds_title'), 50, parseInt(tlimit, 10));

		var mlimit = (l10nWdsCounters || {}).metad_limit || 160;
		Wds.optimum_length_indicator($('#wds_metadesc'), 135, parseInt(mlimit, 10));

		Wds.hook_toggleables();
		Wds.accordion();
	}
	// Boot
	$(init);

	function is_edited_post_dirty() {
		if (is_gutenberg_active()) {
			return wp.data.select("core/editor").isEditedPostDirty();
		} else {
			return wp.autosave.server.postChanged();
		}
	}

	/**
	 * Deal with SEO analysis updates
	 */
	function render_update(extended_data) {
		var $metabox = $("#wds-wds-meta-box"),
			$seo_report = $('.wds-seo-analysis', $metabox),
			$readability_report = $(".wds-readability-report", $metabox),
			$postbox_fields = $('.wds-post-box-fields'),
			title = $('#wds_title').val(),
			description = $('#wds_metadesc').val(),
			focus_keywords = $('#wds_focus').val();

		var data = $.extend({
			action: 'wds-analysis-get-editor-analysis',
			post_id: get_post_data().post_id,
			is_dirty: is_edited_post_dirty() ? 1 : 0,
			wds_title: title,
			wds_description: description,
			wds_focus_keywords: focus_keywords,
            _wds_nonce: _wds_metabox.nonce
		}, extended_data);

		return $.post(ajaxurl, data, 'json').done(function (rsp) {
			if (!(rsp || {}).success) return false;
			var data = (rsp || {}).data;

			$seo_report.replaceWith(
				((data || {}).seo || '')
			);

			$readability_report.replaceWith(
				((data || {}).readability || '')
			);

			$postbox_fields.replaceWith(
				((data || {}).postbox_fields || '')
			);

			// Enable the refresh button.
			if (focus_keywords && focus_keywords.length) {
				$(".wds-refresh-analysis", $metabox).attr('disabled', false);
			}

			update_metabox_state();
		});
	}

	function handle_autosave() {
		refresh_meta_field_placeholders();
		refresh_preview();
		render_update();
	}

	function handle_page_load() {
		before_ajax_request_blocking();
		refresh_meta_field_placeholders();
		refresh_preview();
		render_update();
	}

	function handle_meta_change() {
		render_update();
		refresh_preview();
	}

	function handle_refresh_click() {
		before_ajax_request_blocking();
		if (is_classic_editor_active()) {
			hook_to_heartbeat();
			trigger_tinymce_save();
		}
		trigger_autosave();
	}

	function hook_to_heartbeat() {
		var handle_heartbeat = function () {
			handle_autosave();
			// Re-hook our regular autosave handler
			$(document).on('after-autosave.smartcrawl', handle_autosave);
		};

		// We are already hooked to autosave so let's disable our regular autosave handler momentarily to avoid multiple calls ...
		$(document).off('after-autosave.smartcrawl');
		// hook a new handler to heartbeat-tick.autosave
		$(document).one('heartbeat-tick.autosave', handle_heartbeat);
	}

	function trigger_tinymce_save() {
		var editorSync = (tinyMCE || {}).triggerSave;
		if (editorSync) {
			editorSync();
		}
	}

	function trigger_autosave() {
		if (is_gutenberg_active()) {
			if (wp.data.select("core/editor").isEditedPostAutosaveable()) {
				wp.data.dispatch("core/editor").autosave();
			} else {
				trigger_custom_autosave_event();
			}
		} else if (is_classic_editor_active()) {
			wp.autosave.server.triggerSave();
		}
	}

	function before_ajax_request_blocking() {
		$('.wds-analysis-working').show();
		$('.wds-report-inner').hide();
		$('.wds-disabled-during-request').prop('disabled', true);
		$('.wds-nav-item .wds-issues').addClass('wds-item-loading');
	}

	function before_ajax_request($target_element) {
		$target_element.addClass('wds-item-loading');
		$('.wds-disabled-during-request').prop('disabled', true);
		$('.wds-nav-item.active .wds-issues').addClass('wds-item-loading');
	}

	function update_focus_keyword_state() {
		var $focus_keyword = $('.wds-focus-keyword'),
			invalid_class = 'wds-focus-keyword-invalid',
			invalid_selector = '.' + invalid_class,
			loaded_class = 'wds-focus-keyword-loaded',
			was_invalid = $focus_keyword.is(invalid_selector),
			$seo_report = $('.wds-seo-analysis'),
			seo_errors = $seo_report.data('errors');

		$focus_keyword.removeClass(invalid_class);

		if (was_invalid) {
			$focus_keyword.addClass(loaded_class);
			setTimeout(function () {
				$focus_keyword.removeClass(loaded_class);
			}, 2000);
		}

		if (!(seo_errors >= 0)) {
			$focus_keyword.addClass(invalid_class).removeClass(loaded_class);
		}
	}

	function update_metabox_state() {
		var $metabox = $("#wds-wds-meta-box"),
			$seo_report = $('.wds-seo-analysis', $metabox),
			seo_errors = $seo_report.data('errors'),
			$seo_issues = $('label[for="wds_seo"]').find('.wds-issues'),
			$readability_report = $('.wds-readability-report', $metabox),
			$readability_issues = $('label[for="wds_readability"]').find('.wds-issues'),
			$all_issues = $('.wds-issues'),
			$analysis_working_message = $('.wds-analysis-working', $metabox),
			was_metabox_closed = $metabox.is('.closed');

		$all_issues.find('span').html('');
		$all_issues.removeClass().addClass('wds-issues');
		$metabox.removeClass().addClass('postbox');

		$('.wds-disabled-during-request', $metabox).prop('disabled', false);
		$('.wds-item-loading', $metabox).removeClass('wds-item-loading');

		if (was_metabox_closed) {
			$metabox.addClass('closed');
		}

		if (seo_errors > 0) {
			$metabox.addClass('wds-seo-warning');
			$seo_issues.addClass('wds-issues-warning').find('span').html(seo_errors);
		}
		else if (seo_errors === 0) {
			$metabox.addClass('wds-seo-success');
			$seo_issues.addClass('wds-issues-success');
		}
		else {
			$metabox.addClass('wds-seo-invalid');
			$seo_issues.addClass('wds-issues-invalid');
		}

		var readability_state = $readability_report.data('readabilityState');
		$metabox.addClass('wds-readability-' + readability_state);
		$readability_issues.addClass('wds-issues-' + readability_state);
		if ($readability_issues.is('.wds-issues-warning') || $readability_issues.is('.wds-issues-error')) {
			$readability_issues.find('span').html('1');
		}

		$('.wds-report-inner').show();
		$analysis_working_message.hide();

		update_focus_keyword_state();
	}

	function ignore_toggle (check_id, ignore) {
		var action = !!ignore
			? 'wds-analysis-ignore-check'
			: 'wds-analysis-unignore-check'
		;
		return $.post(ajaxurl, {
			action: action,
			post_id: get_post_data().post_id,
			check_id: check_id,
            _wds_nonce: _wds_metabox.nonce
		}, 'json');
	}

	function handle_ignore_toggle (e) {
		if (e && e.preventDefault && e.stopPropagation) {
			e.preventDefault();
			e.stopPropagation();
		}

		var $me = $(this),
			check_id = $me.attr('data-check_id'),
			ignore = !!$me.is('.wds-ignore')
		;
		before_ajax_request($me);
		return ignore_toggle(check_id, ignore).done(render_update);
	}

	function handle_update (e) {
		if (e && e.preventDefault) e.preventDefault();
		return render_update();
	}

	function save_focus_keywords() {
		var $this = $(this);

		before_ajax_request($this.closest('.wds-focus-keyword'));
		render_update();
	}

	function hook_select2() {
		var $select_elements = $('.wds-advanced-metabox-section select');
		$select_elements.select2({
			minimumResultsForSearch: -1
		});

		var $dropdown_element = ($select_elements.data('select2') || {}).$dropdown;
		if ($dropdown_element) {
			$dropdown_element.addClass('wds-select2-dropdown-container');
		}
	}

	function refresh_preview() {
		var title = $('#wds_title').val(),
			description = $('#wds_metadesc').val(),
			post_id = $('[name="post_ID"]').val();

		$('.wds-preview-container').addClass('wds-preview-loading');

		$.post(ajaxurl, {
			action: "wds-metabox-preview",
			wds_title: title,
			wds_description: description,
			post_id: post_id,
			is_dirty: is_edited_post_dirty() ? 1 : 0,
            _wds_nonce: _wds_metabox.nonce
		}, 'json').done(function (data) {
			if ((data || {}).success) {
				$('.wds-metabox-preview').replaceWith(
					$((data || {}).markup)
				);
			}
		}).always(function () {
			$('.wds-preview-container').removeClass("wds-preview-loading");
		});
	}

	function register_api_fetch_middleware() {
		if (!(wp || {}).apiFetch) {
			return;
		}

		wp.apiFetch.use(function (options, next) {
			var result = next(options);
			result.then(function () {
				if (is_autosave_request(options) || is_post_save_request(options)) {
					trigger_custom_autosave_event();
				}
			});

			return result;
		});
	}
	
	function is_autosave_request(request) {
		return request && request.path
			&& request.path.includes('/autosaves');
	}

	function is_post_save_request(request) {
		var post = get_post_data(),
			post_id = post.post_id,
			post_type = post.post_type;

		return request && request.path
			&& request.method === 'PUT'
			&& request.path.includes('/' + post_id)
			&& request.path.includes('/' + post_type);
	}

	function trigger_custom_autosave_event() {
		$(document).trigger('wds-after-autosave');
	}

	function init_analysis () {
		window.render_update = render_update;
		window.Wds.dismissible_message();

		$(document)
			.on('after-autosave.smartcrawl', trigger_custom_autosave_event)
			.on('wds-after-autosave', handle_autosave)
			.on('click', '#wds-wds-meta-box .wds-ignore', handle_ignore_toggle)
			.on('click', '#wds-wds-meta-box .wds-unignore', handle_ignore_toggle)
			.on('click', '#wds-wds-meta-box a[href="#reload"]', handle_update)
			.on('input propertychange', '.wds-focus-keyword input', _.debounce(save_focus_keywords, 2000))
			.on('input propertychange', '.wds-meta-field', _.debounce(handle_meta_change, 2000))

			// Refresh analysis button handler (both SEO and readability)
			.on('click', '.wds-refresh-analysis', handle_refresh_click)
		;
		update_metabox_state();
		hook_select2();

		/**
		 * Set cookie value each time the metabox is toggled.
		 */
		$("#wds-wds-meta-box").on('click', function() {
			if ($(this).is(".closed")) {
				window.Wds.set_cookie('wds-seo-metabox', '');
			} else {
				window.Wds.set_cookie('wds-seo-metabox', 'open');
			}
		});

		$(window)
			.on('load', handle_page_load)
			.on('load', register_api_fetch_middleware)
		;

		// Set metabox state on page load based on cookie value.
		// Fixes: https://app.asana.com/0/0/580085427092951/f
		if ('open' === window.Wds.get_cookie('wds-seo-metabox')) {
			$("#wds-wds-meta-box").removeClass('closed');
		}
	}

	$(init_analysis);
})(jQuery);
