(function ($) {
	window.Wds = window.Wds || {};

	function add_custom_meta_tag_field() {
		var $this = $(this),
			$container = $this.closest('.wds-custom-meta-tags'),
			$new_input = $container.find('.wds-custom-meta-tag:first-of-type').clone();

		$new_input.insertBefore($this);
		$new_input.find('input').val('').focus();
	}

	function import_yoast_data_button_clicked(e) {
		e.preventDefault();

		var $target = $(e.target),
			$importButtons = $('.wds-third-party-plugins .button');

		$target.html(_wds_setting.strings.importing);
		$importButtons.prop('disabled', true);

		import_yoast_data(function (data) {
			navigate_to_success_url(data.url);
		}, function (data) {
			alert(data.message);
			$target.html(_wds_setting.strings.import);
			$importButtons.prop('disabled', false);
		});
	}

	function import_aioseop_data_button_clicked(e) {
		e.preventDefault();

		var $target = $(e.target),
			$importButtons = $('.wds-third-party-plugins .button');

		$target.html(_wds_setting.strings.importing);
		$importButtons.prop('disabled', true);

		import_aioseop_data(function (data) {
			navigate_to_success_url(data.url);
		}, function (data) {
			alert(data.message);
			$target.html(_wds_setting.strings.import);
			$importButtons.prop('disabled', false);
		});
	}

	function navigate_to_success_url(url) {
		if (window.location.href == url) {
			window.location.reload();
		}
		else {
			window.location.href = url;
		}
	}

	function import_yoast_data(onComplete, onError) {
		import_data(onComplete, onError, 'import_yoast_data');
	}

	function import_aioseop_data(onComplete, onError) {
		import_data(onComplete, onError, 'import_aioseop_data');
	}

	function import_data(onComplete, onError, action) {
		$.post(ajaxurl, {
			action: action
		}, function (data) {
			if (data.success) {
				if (data.in_progress) {
					import_data(onComplete, onError, action);
				} else {
					onComplete(data);
				}
			} else {
				onError(data);
			}
		}, 'json');
	}

	function update_toggles() {
		var $sitewide_toggle = $('[name="wds_settings_options[wds_sitewide_mode]"]');

		$('[data-prereq]').each(function () {
			var $checkbox = $(this),
				$toggle = $checkbox.closest('.wds-toggle-table'),
				prereq = $checkbox.data('prereq'),
				$prereq_checkbox = $('[name="wds_settings_options[' + prereq + ']"]');

			$toggle.removeClass('disabled');
			$checkbox.prop('disabled', false);
			if (
				$sitewide_toggle.is(':checked')
				|| ($prereq_checkbox.length && !$prereq_checkbox.is(':checked'))
			) {
				$toggle.addClass('disabled');
				$checkbox.prop('disabled', true);
				$checkbox.prop('checked', false);
			}

			$prereq_checkbox.off('change', update_toggles).on('change', update_toggles);
		});

		$sitewide_toggle.off('change', update_toggles).on('change', update_toggles);
	}

	function init() {
		window.Wds.styleable_file_input($('.wds-styleable-file-input'));
		$('select').select2({
			minimumResultsForSearch: -1
		});
		$('.wpmud').on('click', '.wds-custom-meta-tags button', add_custom_meta_tag_field);
		$('.wds-yoast .button').on('click', import_yoast_data_button_clicked);
		$('.wds-aioseop .button').on('click', import_aioseop_data_button_clicked);

		update_toggles();
	}

	$(init);
})(jQuery);
