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

	function init() {
		window.Wds.styleable_file_input($('.wds-styleable-file-input'));
		$('select').select2({
			minimumResultsForSearch: -1
		});
		$('.wpmud').on('click', '.wds-custom-meta-tags button', add_custom_meta_tag_field);
		$('.wds-yoast .button').on('click', import_yoast_data_button_clicked);
		$('.wds-aioseop .button').on('click', import_aioseop_data_button_clicked);
	}

	$(init);
})(jQuery);