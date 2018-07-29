;(function ($, undefined) {
	/**
	 * Wraps a raw notice string with appropriate markup
	 *
	 * @param {String} str Raw notice
	 *
	 * @return {String} Notice markup
	 */
	function to_warning_string (str) {
		if (!str) return '';
		return '<div class="wds-onpage-warning wds-notice wds-notice-warning">' +
			'<p>' + str + '</p>' +
		'</div>';
	}

	/**
	 * Handles tab switching title&meta preview update dispatch
	 *
	 * @param {Object} e Event object (optional)
	 */
	function tab_preview_change (e) {
		var $tab = $(".content.wds-content-tabs:visible"),
			$text;

		if ($tab.is('.wds-accordion')) {
			var $section = $tab.find('.wds-accordion-section.open .wds-content-tabs-inner');
			$text = $section.find(':text[name*="title-"]');
		}
		else {
			$text = $tab.find(':text[name*="title-"]');
		}

		if ($text.length) {
			render_preview_change.apply($text.get(), arguments);
		}
	}

	/**
	 * Handles change/keyup event title&meta preview update dispatch
	 *
	 * @param {Object} e Event object (optional)
	 */
	function render_preview_change (e) {
		var $hub = $(this).closest(".wds-content-tabs-inner"),
			$tab = $hub.closest(".tab").find(':radio[name="wds-admin-active-tab"]'),
			$title = $hub.find(':text[name*="title-"]').not('[name*="og-"]').not('[name*="twitter-"]'),
			$meta = $hub.find('textarea[name*="metadesc-"]').not('[name="og-"]').not('[name*="twitter-"]'),
			$target = $hub.find(".wds-preview-container")
		;

		if (!$tab.length || !$title.length || !$meta.length) return;
		if ($title.length > 1 || $meta.length > 1) return;

		$target.addClass("wds-preview-loading");

		$.post(ajaxurl, {
			action: "wds-onpage-preview",
			type: $hub.data("type"),
			title: $title.val(),
			description: $meta.val(),
			_wds_nonce: _wds_onpage.nonce
		}, 'json')
			.done(function (rsp) {
				var status = (rsp || {}).status || false,
					html = (rsp || {}).markup || false,
					warnings = (rsp || {}).warnings || {}
				;

				if (status && !!html) {
					$target.replaceWith(html);
				}

				$hub.find(".wds-onpage-warning").remove();

				if ((warnings || {}).title) {
					$title.after(to_warning_string(warnings.title));
				}
				if ((warnings || {}).description) {
					$meta.after(to_warning_string(warnings.description));
				}

				window.Wds.readjust_vertical_tabs_height();
			})
			.always(function () {
				$target.removeClass("wds-preview-loading");
			})
		;
	}

	function toggle_archive_status() {
		var $checkbox = $(this),
			$sub_title = $checkbox.closest('.tab-sub-title'),
			archiveDisabledClass = 'wds-archive-disabled';

		if (!$checkbox.is(':checked')) {
			$sub_title.addClass(archiveDisabledClass);
		}
		else {
			$sub_title.removeClass(archiveDisabledClass);
		}
	}

	function init_onpage () {
		window.Wds.Macros.all($("#page-title-meta-tabs"));
		$(document).on("change keyup", ":text, textarea", _.throttle(render_preview_change, 1000));
		$(document).on("change", ".tab>:radio", tab_preview_change);

		// Also update on init, because of potential hash change
		setTimeout(tab_preview_change);

		window.Wds.accordion(function () {
			// Dispatch a call to refresh preview
			setTimeout(tab_preview_change);
		});

		var $tab_status_checkboxes = $('.tab-sub-title .toggle input[type="checkbox"]');
		$tab_status_checkboxes.each(function () {
			toggle_archive_status.apply($(this));
		});
		$tab_status_checkboxes.change(toggle_archive_status);

		window.Wds.qtips($('.wds-has-tooltip'));
	}

	function init () {
		if ($("body").is(".smartcrawl_page_wds_onpage")) init_onpage();
	}

	// Boot
	$(init);

})(jQuery);
