(function ($, undefined) {
	window.Wds = window.Wds || {};

	function reload_box(box_id) {
		$.post(ajaxurl, {
			action: 'wds-reload-box',
			box_id: box_id
		}, function (data) {
			if ((data || {}).success) {
				if (!$.isArray(box_id)) {
					box_id = [box_id];
				}

				$.each(box_id, function (index, value) {
					var $box = $('#' + value);

					if ($box.length && data[value]) {
						$box.replaceWith(data[value]);
					}
				});
			}
		}, 'json').always(function () {
			update_page_status();
			load_qtips();
		});
	}

	function activate_component(e) {
		e.preventDefault();
		var $button = $(this),
			$box = $button.closest('.dev-box'),
			box_id = $box.attr('id'),
			dependent = $box.data('dependent'),
			reload_boxes = [box_id];

		if (dependent) {
			reload_boxes.push(dependent);
		}

		before_ajax_request($button);

		$.post(ajaxurl, {
			action: 'wds-activate-component',
			option: $button.data('optionId'),
			flag: $button.data('flag')
		}, function (data) {
			if ((data || {}).success) {
				reload_box(reload_boxes);
			}
		}, 'json');
	}

	function update_page_status() {
		$('.wds-disabled-during-request').prop('disabled', false);
		$('.wds-item-loading').removeClass('wds-item-loading');
	}

	function before_ajax_request($target_element) {
		if (!$target_element.is('.wds-item-loading')) {
			$target_element.addClass('wds-item-loading');
			$('.wds-disabled-during-request').prop('disabled', true);
		}
	}

	function reload_boxes() {
		var $boxes_requiring_refresh = $('.wds-box-refresh-required'),
			box_ids = [];

		if ($boxes_requiring_refresh.length) {
			$.each($boxes_requiring_refresh, function () {
				var $box = $(this).closest('.dev-box');
				box_ids.push($box.attr('id'));
			});

			reload_box(box_ids);
		}

		setTimeout(reload_boxes, 20000);
	}

	function load_qtips() {
		window.Wds.qtips($('.wds-has-tooltip'));
	}

	function init() {
		reload_boxes();
		load_qtips();

		window.Wds.upsell();
		window.Wds.accordion();
		window.Wds.dismissible_message('dashboard-sitemap-disabled-warning');

		$(document).on('click', '.wds-activate-component', activate_component);
	}

	$(init);
})(jQuery);
