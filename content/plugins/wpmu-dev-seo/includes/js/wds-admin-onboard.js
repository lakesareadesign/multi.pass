;(function ($, undefined) {

	Wds.Onboard = Wds.Onboard || {
		get_root: function () {
			return $(".dev-overlay.wds-onboard-dialog");
		},
		get_checks: function () {
			return Wds.Onboard.get_root().find(":checkbox");
		},
		process_all: function () {
			var $checks = Wds.Onboard.get_checks();
			WDP.overlay.box_content.html(
				Wds.template('onboard', 'progress')
			);
			Wds.Onboard.process_next($checks.toArray(), $checks.length);
		},
		process_next: function ($items, total, processed) {
			if (!$items.length) {
				WDP.overlay.box_content.find(".processing-item-desc").text(Wds.l10n('onboard', 'All done'));
				window.location.reload();
				return false;
			}

			var $item = $($items.pop()),
				processed = processed || 0,
				pct = 0,
				dfr = $.Deferred()
			;
			processed++;
			pct = (processed / total) * 100;
			Wds.update_progress_bar(WDP.overlay.box_content.find(".wds-progress"), pct);

			WDP.overlay.box_content.find(".processing-item-desc").text(
				$item.attr("data-processing")
			);
			if ($item.is(":checked")) {
				$.post(ajaxurl, {
					action: "wds-boarding-toggle",
					target: $item.attr("name")
				}).always(dfr.resolve);
			} else setTimeout(dfr.resolve);

			dfr.done(function () {
				Wds.Onboard.process_next($items, total, processed);
			});
		},
		skip: function () {
			$(this).html('&hellip;');
			$.post(ajaxurl, {
				action: "wds-boarding-skip"
			}).always(function () {
				WDP.closeOverlay();
			});
		},
		update_checkbox: function () {
			var $label = $(this),
				$checkbox = $label.closest('.wds-onboarding-item').find('#' + $label.attr('for'));

			if ($checkbox.is(':checked')) {
				$checkbox.attr('checked', false);
			}
			else {
				$checkbox.attr('checked', true);
			}
		},
		toggle_enabled_actions: function () {
			var $all = $(this).closest(".wds-onboard-dialog").find(":checkbox"),
				$button = $("button.wds-onboarding-setup"),
				enabled = false
			;
			$all.each(function () {
				if (!$(this).is(":checked")) return true;
				enabled = true;
				return false;
			});
			if (enabled) {
				$button
					.attr("disabled", false)
					.removeClass("disabled")
				;
			} else {
				$button
					.attr("disabled", true)
					.addClass("disabled")
				;
			}
		}
	};

	$(document).on("click", "button.wds-onboarding-setup", Wds.Onboard.process_all);
	$(document).on("click", "button.onboard-skip", Wds.Onboard.skip);
	$(document).on("click", ".wds-onboard-dialog label", Wds.Onboard.update_checkbox);
	$(document).on("change", ".wds-onboard-dialog :checkbox", Wds.Onboard.toggle_enabled_actions);

})(jQuery);
