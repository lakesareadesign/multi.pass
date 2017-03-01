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
			$text = $tab.find(':text[name*="title-"]')
		;
		if ($text.length) render_preview_change.apply($text.get(), arguments);
	}

	/**
	 * Handles change/keyup event title&meta preview update dispatch
	 *
	 * @param {Object} e Event object (optional)
	 */
	function render_preview_change (e) {
		var $hub = $(this).closest(".wds-content-tabs-inner"),
			$tab = $hub.closest(".tab").find(':radio[name="tab_onpage_group"]'),
			$title = $hub.find(':text[name*="title-"]').not('[name*="og-"]'),
			$meta = $hub.find('textarea[name*="metadesc-"]').not('[name="og-"]'),
			$target = $(".wds-preview")
		;

		if (!$tab.length || !$title.length || !$meta.length) return;
		if ($title.length > 1 || $meta.length > 1) return;

		$target.addClass("wds-preview-loading");

		$.post(ajaxurl, {
			action: "wds-onpage-preview",
			type: $tab.attr("id"),
			title: $title.val(),
			description: $meta.val()
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
			})
			.always(function () {
				$target.removeClass("wds-preview-loading");
			})
		;
	}

	function init_onpage () {
		window.Wds.Macros.all($("#page-title-meta-tabs"));
		$(document).on("change, keyup", ":text, textarea", _.throttle(render_preview_change, 1000));
		$(document).on("change", ".tab>:radio", tab_preview_change);

		// Also update on init, because of potential hash change
		setTimeout(tab_preview_change);
	}

	function init () {
		if ($("body").is(".smartcrawl_page_wds_onpage")) init_onpage();
	}

	// Boot
	$(init);

})(jQuery);
