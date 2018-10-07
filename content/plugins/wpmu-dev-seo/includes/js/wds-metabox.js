(function ($) {

	/**
	 * Handles change/keyup event onpage metabox fields dispatch
	 *
	 * @param {Object} e Event object (optional)
	 */
	function render_fields_change (e) {
		var $currentTarget = $(e.currentTarget),
			field = false,
			value = false;

		if($currentTarget.is('#title')) {
			field = 'title';
		} else if($currentTarget.is('#content') || $currentTarget.is('#excerpt')) {
			field = 'desc';
		}

		if( field ){
			$.post(ajaxurl, {
				id: wp.autosave.getPostData().post_id,
				action: "wds_metabox_update",
				post: wp.autosave.getPostData(),
                _wds_nonce: _wds_metabox.nonce
			}, 'json').done(function (rsp) {
				var description = (rsp || {}).description || '',
					title = (rsp || {}).title || '';
				$('#wds_title').attr('placeholder',title);
				$('#wds_metadesc').attr('placeholder',description);
			});
		}

	}

	function init () {
		window.setTimeout( function() {
			var editor = typeof tinymce !== 'undefined' && tinymce.get('content');
			if( editor ) {
				editor.on('change', function(e) {
					e.currentTarget = $('#content');
					_.debounce(render_fields_change.bind(e), 1000);
				});
			}
		}, 1000 );
		$(document).on("input","input#title,textarea#content,textarea#excerpt",_.debounce(render_fields_change, 1000)).trigger('input');

		$('.wds-horizontal-tab-nav').on('click', '.wds-nav-item', function(){
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

})(jQuery);

/**
 * Deal with SEO analysis updates
 */
;(function ($, undefined) {

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
			post_id: wp.autosave.getPostData().post_id,
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
			if (focus_keywords.length) {
				$(".wds-refresh-analysis", $metabox).attr('disabled', false);
			}

			update_metabox_state();
		});
	}

	function render_update_after_autosave() {
		render_update();
	}

	function render_update_refresh_click() {
		var $metabox = $("#wds-wds-meta-box"),
			$refresh_button = $(this),
			$seo_report = $('.wds-report .wds-accordion', $metabox),
			$seo_notification = $('.wds-nav-item.active label .wds-issues')
		;
		if ($('.wds-analysis-working', $metabox).length) {
			// We're already working, pass.
			return false;
		}
		$seo_report.hide();
		$seo_notification.attr('class', 'wds-issues wds-item-loading');
		$seo_report.after('<div class="wds-analysis-working"><p>' + l10nWdsMetabox.content_analysis_working + '</p></div>');
		$refresh_button.prop('disabled', true);

		var cback = function() {
			render_update().always(function() {
				$refresh_button.prop('disabled', false);
				$seo_report.show();
				$('.wds-analysis-working', $metabox).remove();
			});
		};
		var editorSync = (tinyMCE || {}).triggerSave;
		if (editorSync) {
			editorSync();
		}
		var save = (((wp || {}).autosave || {}).server || {}).triggerSave;
		if (save) {
			$(document).one('heartbeat-tick.autosave', cback);
			wp.autosave.server.triggerSave();
		} else cback();
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
		else if (seo_errors == 0) {
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

		update_focus_keyword_state();
	}

	function ignore_toggle (check_id, ignore) {
		var action = !!ignore
			? 'wds-analysis-ignore-check'
			: 'wds-analysis-unignore-check'
		;
		return $.post(ajaxurl, {
			action: action,
			post_id: wp.autosave.getPostData().post_id,
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
            _wds_nonce: _wds_metabox.nonce
		}, 'json').done(function (data) {
			if ((data || {}).success) {
				$('.wds-metabox-preview').replaceWith(
					$((data || {}).markup)
				);
				render_update();
			}
		}).always(function () {
			$('.wds-preview-container').removeClass("wds-preview-loading");
		});
	}

	function init () {
		window.render_update = render_update;
		window.Wds.dismissible_message();

		$(document)
			.on('after-autosave', render_update_after_autosave)
            .on('after-autosave', refresh_preview)
			.on('click', '#wds-wds-meta-box .wds-ignore', handle_ignore_toggle)
			.on('click', '#wds-wds-meta-box .wds-unignore', handle_ignore_toggle)
			.on('click', '#wds-wds-meta-box a[href="#reload"]', handle_update)
			.on('input propertychange', '.wds-focus-keyword input', _.debounce(save_focus_keywords, 2000))
			.on('input propertychange', '.wds-meta-field', _.debounce(refresh_preview, 2000))

			// Refresh analysis button handler (both SEO and readability)
			.on('click', '.wds-refresh-analysis', render_update_refresh_click)
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
		// Set metabox state on page load based on cookie value.
		// Fixes: https://app.asana.com/0/0/580085427092951/f
		if ('open' === window.Wds.get_cookie('wds-seo-metabox')) {
			$("#wds-wds-meta-box").removeClass('closed');
		}
	}

	$(init);
})(jQuery);
