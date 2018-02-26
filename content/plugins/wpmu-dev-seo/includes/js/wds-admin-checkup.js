(function ($, undefined) {
	window.Wds = window.Wds || {};

	function switch_reporting(on) {
		var $checkbox = $(":checkbox[name*='checkup-cron-enable']"),
			$tab = $('label[for="tab_settings"]'),
			$enable_button = $('.wds-enable-reporting'),
			$disable_button = $('.wds-disable-reporting');

		$tab.click();
		$checkbox.attr('checked', on);
		$checkbox.trigger('change');
		if (on) {
			$enable_button.hide();
			$disable_button.show();
		}
		else {
			$enable_button.show();
			$disable_button.hide();
		}
	}

	function toggle_stats_button() {
		var $checkbox = $(this),
			$enable_button = $('.wds-enable-reporting'),
			$disable_button = $('.wds-disable-reporting');

		if ($checkbox.is(':checked')) {
			$enable_button.hide();
			$disable_button.show();
		}
		else {
			$enable_button.show();
			$disable_button.hide();
		}
	}

	function enable_reporting(e) {
		e.preventDefault();

		switch_reporting(true);
	}

	function disable_reporting(e) {
		e.preventDefault();

		switch_reporting(false);
	}

	function update_report_state() {
		var issue_count = $('[data-issue-count]').data('issueCount'),
			$tab_label_issues = $('label[for="tab_checkup"]').find('.wds-issues'),
			$tab_title_issues = $('.tab-title').find('.wds-issues');

		if (issue_count > 0) {
			$tab_label_issues.show().find('span').html(issue_count);
			$tab_title_issues.show().find('span').html(issue_count);
		}
		else {
			$tab_label_issues.hide();
			$tab_title_issues.hide();
		}
	}

	function update_checkup_progress () {
		var previous = update_checkup_progress.previous || 0,
			base_timeout = 30 * 1000,
			incr = 30 * 1000
		;
		return $.post(ajaxurl, {
			action: 'wds-checkup-status'
		}, function (resp) {
			var status = (resp || {}).success || false,
				percentage = ((resp || {}).data || {}).percentage || 0
			;

			$('.wds-report .wds-progress')
				.find('.wds-progress-bar-current-percent').text(percentage + '%').end()
				.find('.wds-progress-bar-inside').width(percentage + '%')
			;

			if (status && parseInt(percentage, 10) >= 100) {
				return window.location.reload();
			} else {
				if (percentage === previous) {
					base_timeout += incr;
				} else {
					update_checkup_progress.previous = percentage;
				}

				setTimeout(update_checkup_progress, base_timeout);
			}
		});
	}

	function init() {
		window.Wds.hook_toggleables();
		window.Wds.hook_user_search();
		window.Wds.accordion();
		window.Wds.upsell();
		window.Wds.conditional_fields();
		window.Wds.qtips($('.wds-has-tooltip'));

		$('select.select-container').select2({
			minimumResultsForSearch: -1
		});

		update_report_state();

		$('.wpmud')
			.on('click', '.wds-enable-reporting', enable_reporting)
			.on('click', '.wds-disable-reporting', disable_reporting);

		$(":checkbox[name*='checkup-cron-enable']").on('change', toggle_stats_button);

		if ($(".tab_checkup .wds-progress").length) {
			update_checkup_progress();
		}
	}

	$(init);
})(jQuery);
