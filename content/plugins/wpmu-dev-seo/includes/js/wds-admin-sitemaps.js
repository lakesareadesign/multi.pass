(function ($, undefined) {
	window.Wds = window.Wds || {};

	function reload_report() {
		var $report = $('.wds-crawl-results-report'),
			$open_section = $('.wds-accordion-section.open');

		return $.post(ajaxurl, {
			action: 'wds-get-sitemap-report',
			open_type: $open_section.length ? $open_section.data('type') : ''
		}).done(function (data) {
			data = (data || {});
			if (data.success && data.markup) {
				$report.replaceWith(data.markup);
				update_report_state();
			}
		});
	}

	function change_issue_status(issue_id, action) {
		return $.post(ajaxurl, {
			action: action,
			issue_id: issue_id
		}).done(function (data) {
			var status = parseInt(
				(data || {}).status || '0',
				10
			);
			if (status > 0) {
				reload_report();
			}
		});
	}

	function ignore_issue(issue_id) {
		return change_issue_status(issue_id, 'wds-service-ignore');
	}

	function restore_issue(issue_id) {
		change_issue_status(issue_id, 'wds-service-unignore');
	}

	function ignore_single_issue(e) {
		e.preventDefault();

		var $link = $(e.target),
			$container = $link.closest('[data-issue-id]'),
			issue_id = $container.data('issueId');

		before_ajax_request($link.closest('.wds-links-dropdown'));

		return ignore_issue(issue_id);
	}

	function restore_single_issue(e) {
		e.preventDefault();

		var $button = $(e.target),
			$container = $button.closest('[data-issue-id]'),
			issue_id = $container.data('issueId');

		before_ajax_request($button);

		return restore_issue(issue_id);
	}

	function ignore_group_issues(e) {
		e.preventDefault();

		var $button = $(e.target),
			$container = $button.closest('.wds-crawl-issues-table'),
			$issues = $container.find('[data-issue-id]'),
			issue_ids = [];

		before_ajax_request($button);

		$issues.each(function (index, issue) {
			issue_ids.push($(issue).data('issueId'));
		});

		return ignore_issue(issue_ids);
	}

	function ignore_all_issues(e) {
		e.preventDefault();

		var $button = $(e.target),
			$vertical_tab = $button.closest('.tab_url_crawler'),
			$issues = $vertical_tab.find('.wds-crawl-issues-table [data-issue-id]'),
			issue_ids = [];

		before_ajax_request($button);

		$issues.each(function (index, issue) {
			issue_ids.push($(issue).data('issueId'));
		});

		return ignore_issue(issue_ids);
	}

	function add_to_sitemap(path, issue_id) {
		return $.post(ajaxurl, {
			action: 'wds-sitemap-add_extra',
			path: path
		}).done(function (data) {
			var status = parseInt(
				(data || {}).status || '0',
				10
			);
			if (status > 0) {
				reload_report();
			}
		});
	}

	function add_single_to_sitemap(e) {
		var $link = $(e.target),
			$item = $link.closest('[data-issue-id]'),
			issue_id = $item.data('issueId'),
			path = $item.data('path');

		before_ajax_request($link.closest('.wds-links-dropdown'));

		return add_to_sitemap(path, issue_id);
	}

	function add_all_to_sitemap(e) {
		e.preventDefault();

		var $button = $(e.target),
			$container = $button.closest('.wds-crawl-issues-table'),
			$issues = $container.find('[data-issue-id]'),
			issue_ids = [],
			paths = [];

		before_ajax_request($button);

		$issues.each(function (index, issue) {
			issue_ids.push($(issue).data('issueId'));
			paths.push($(issue).data('path'));
		});

		return add_to_sitemap(paths, issue_ids);
	}

	function update_report_state() {
		var $report = $('.wds-crawl-results-report'),
			active_issues = $report.data('activeIssues'),
			ignored_issues = $report.data('ignoredIssues'),
			$vertical_tab = $report.closest('.tab_url_crawler'),
			$title_issues_indicator = $vertical_tab.find('.tab-title .wds-issues'),
			$label_issues_indicator = $('.wds-issues', $('label[for="tab_url_crawler"]')),
			$title_ignore_all_button = $('.tab-title .wds-ignore-all');

		$('.wds-disabled-during-request').prop('disabled', false);
		$('.wds-item-loading').removeClass('wds-item-loading');

		$('.wds-url-crawler-stats-container').html($('.wds-crawl-results-report .wds-url-crawler-stats').clone());

		if (active_issues > 0) {
			$title_issues_indicator.show().find('span').html(active_issues);
			$label_issues_indicator.show().find('span').html(active_issues);
			$title_ignore_all_button.show();
		}
		else {
			$title_issues_indicator.hide();
			$label_issues_indicator.hide();
			$title_ignore_all_button.hide();
		}
	}

	function before_ajax_request($target_element) {
		if (!$target_element.is('.wds-item-loading')) {
			$target_element.addClass('wds-item-loading');
			$('.wds-disabled-during-request').prop('disabled', true);
		}
	}

	function list_occurrences(e) {
		e.preventDefault();

		var $link = $(e.target),
			$container = $link.closest('[data-issue-id]'),
			$dialog = $container.find('.wds-occurences'),
			dialog_id = $dialog.attr("id");

		if (dialog_id) {
			WDP.showOverlay('#' + dialog_id);
			WDP.overlay.box_content.off().on("click", ".wds-cancel-button", WDP.closeOverlay);
		}
	}

	function open_redirect_dialog(e) {
		e.preventDefault();

		var $link = $(e.target),
			$container = $link.closest('[data-issue-id]'),
			$dialog = $container.find('.wds-redirect'),
			dialog_id = $dialog.attr("id");

		if (dialog_id) {
			WDP.showOverlay('#' + dialog_id);
			WDP.overlay.box_content.off()
				.on("click", ".wds-cancel-button", WDP.closeOverlay)
				.on("click", ".wds-action-button", do_redirect);
		}
	}

	function do_redirect(e) {
		var $button = $(e.target),
			$container = $button.closest('[data-issue-id]'),
			$modal = $container.closest('.wds-redirect'),
			$fields = $container.find("input"),
			data = {
				action: 'wds-service-redirect'
			};

		before_ajax_request($button);

		$fields.each(function () {
			var $me = $(this);
			data[$me.attr("name")] = $me.val();
		});

		$.post(ajaxurl, data, function () {
		}, 'json').always(function () {
			$modal.find(".close").click();
			ignore_issue($container.data('issueId'));
		});
	}
	
	function update_progress() {
		var $container = $('.tab_url_crawler');

		if($container.find('.wds-url-crawler-progress').length)
		{
			reload_report();
			setTimeout(update_progress, 20000);
		}
	}

    function toggle_sitemap_status() {
        var $toggle = $(this),
            new_status = $toggle.is(':checked') ? 1 : 0;

        $toggle.attr('disabled', true);

        return $.post(ajaxurl, {
            action: 'wds-toggle-sitemap-status',
            sitemap_active: new_status
        }).done(function (data) {
            data = (data || {});
            if (data.success) {
            	window.location.reload();
            }
        });
    }

	function init() {
		window.Wds.hook_toggleables();
		window.Wds.accordion();
		window.Wds.link_dropdown();
		window.Wds.upsell();
		window.Wds.conditional_fields();
		window.Wds.qtips($('.wds-has-tooltip'));

		$('select.select-container').select2({
			minimumResultsForSearch: -1
		});

		update_report_state();
		update_progress();

		$(document)
			.on('click', '[href="#ignore"]', ignore_single_issue)
			.on('click', '[href="#add-to-sitemap"]', add_single_to_sitemap)
			.on('click', '.wds-crawl-issues-table .wds-add-all-to-sitemap', add_all_to_sitemap)
			.on('click', '.wds-crawl-issues-table .wds-ignore-all', ignore_group_issues)
			.on('click', '.wds-ignored-items-table .wds-unignore', restore_single_issue)
			.on('click', '.tab-title .wds-ignore-all', ignore_all_issues)
			.on('click', '[href="#occurences"]', list_occurrences)
			.on('click', '[href="#redirect"]', open_redirect_dialog)
			.on('change', '.sitemap-status-toggle', toggle_sitemap_status);
	}

	$(init);
})(jQuery);
