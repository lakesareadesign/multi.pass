;(function ($) {

	var redirect_selector = '.wds-redirects',
		_templates;

	var handle_redirect_selector_change = function (e) {
		var is_checked = !!$(e.target).is(":checked"),
			$redirects = $(redirect_selector),
			$targets = $('tbody :checkbox[name*="bulk"]', $redirects);

		if ($targets.length) {
			$targets.attr("checked", is_checked);
		}

		maybe_hide_bulk_remove();
	};

	var remove_redirect_row = function (e) {
		e.preventDefault();

		var $remove_button = $(this),
			$redirects = $(redirect_selector),
			$message = $('.wds-redirects-unsaved-notice', $redirects);

		$remove_button.closest('tr').remove();
		$message.show();
		update_select_all_checkbox();
		maybe_hide_bulk_remove();
	};

	var add_new_redirect = function (e) {
		e.preventDefault();

		var $redirects = $(redirect_selector),
			index = $('tbody tr', $redirects).length,
			new_row = _templates.redirect_item({
				source: '',
				destination: '',
				selected_type: $('#wds-default-redirection-type').val(),
				index: index
			});

		$('tbody', $redirects).append(new_row);

		hook_select2($('[data-index="' + index + '"]', $redirects).find('select'));
		Wds.styleable_checkbox($('input[type="checkbox"]', $redirects));
		update_select_all_checkbox();
	};

	var bulk_remove = function (e) {
		e.preventDefault();

		var $redirects = $(redirect_selector),
			$message = $('.wds-redirects-unsaved-notice', $redirects);

		$('tbody tr input[type="checkbox"]:checked', $redirects).each(function () {
			var $checkbox = $(this);
			$checkbox.closest('tr').remove();
		});

		$message.show();
		update_select_all_checkbox();
		maybe_hide_bulk_remove();
	};

	var update_items = function (e) {
		e.preventDefault();

		var $redirects = $(redirect_selector),
			indices_input = WDP.overlay.box_content.find('input[type="hidden"]'),
			indices_val = indices_input.val(),
			indices = indices_val.split(','),
			new_url_input = WDP.overlay.box_content.find('input[type="text"]'),
			new_url = new_url_input.val(),
			type_select = WDP.overlay.box_content.find('select'),
			type = type_select.val(),
			$checkboxes = $('input[type="checkbox"]', $redirects);

		$.each(indices, function (index, value) {
			var $row = $('tr[data-index="' + value + '"]', $redirects),
				$destination_input = $row.find('.wds-redirection_item-destination input'),
				$type_select = $row.find('.wds-redirection_item-type select');

			$destination_input.val(new_url);
			$destination_input.trigger('change');
			$type_select.val(type);
			$type_select.trigger('change');
		});

		$checkboxes.prop('checked', false);

		WDP.closeOverlay();
	};

	var bulk_update = function (e) {
		e.preventDefault();

		var overlay_selector = '#wds-bulk-update-redirects',
			indices = [];

		$('tbody tr input[type="checkbox"]:checked', $(redirect_selector)).each(function () {
			var $checkbox = $(this),
				index = $checkbox.closest('tr').data('index');

			indices.push(index);
		});

		var updated_form = _templates.update_form({
			indices: indices.join(',')
		});

		$(overlay_selector).replaceWith(updated_form);
		WDP.showOverlay(overlay_selector, {});

		hook_select2(WDP.overlay.box_content.find('select'));
		WDP.overlay.box_content.on("click.wds-bulk-update-redirects-modal", ".wds-action-button", update_items);
		WDP.overlay.box_content.on("click.wds-bulk-update-redirects-modal", ".wds-cancel-button", WDP.closeOverlay);
	};

	var get_checked_boxes = function () {
		var $redirects = $(redirect_selector);

		return $('tbody tr input[type="checkbox"]:checked', $redirects);
	};

	function maybe_hide_bulk_remove() {
		var $redirects = $(redirect_selector),
			$checked_checkboxes = get_checked_boxes(),
			$bulk_remove_button = $('.wds-bulk-remove', $redirects);

		if ($checked_checkboxes.length > 0) {
			$bulk_remove_button.show();
		}
		else {
			$bulk_remove_button.hide();
		}
	}

	function update_select_all_checkbox() {
		var $redirects = $(redirect_selector),
			$check_all = $('th.selector input[type="checkbox"]', $redirects),
			$all_checkboxes = $('tbody tr input[type="checkbox"]', $redirects),
			$checked_checkboxes = get_checked_boxes();

		if (!$check_all.is(':checked') && $all_checkboxes.length == $checked_checkboxes.length) {
			$check_all.prop('checked', true);
		}

		if (
			$check_all.is(':checked')
			&& (
				$all_checkboxes.length > $checked_checkboxes.length
				|| ($all_checkboxes.length == 0 && $checked_checkboxes.length == 0)
			)
		) {
			$check_all.prop('checked', false);
		}
	}

	var handle_checkbox_change = function (e) {
		e.preventDefault();

		update_select_all_checkbox();
		maybe_hide_bulk_remove();
	};

	function hook_select2($select) {
		$select.select2({
			minimumResultsForSearch: -1
		});
	}

	$(function () {
		$(redirect_selector)
			.on('click', 'th.selector input', handle_redirect_selector_change)
			.on('click', 'a[href="#remove"]', remove_redirect_row)
			.on('click', '.wds-add-redirect', add_new_redirect)
			.on('click', '.wds-bulk-remove', bulk_remove)
			.on('click', '.wds-bulk-update', bulk_update)
			.on('change', 'tbody tr input[type="checkbox"]', handle_checkbox_change);

		hook_select2($('select', $(redirect_selector)));

		_templates = {
			redirect_item: Wds.tpl_compile(Wds.template('redirects', 'redirect-item')),
			update_form: Wds.tpl_compile(Wds.template('redirects', 'update-form'))
		};

		$("body").append(_templates.update_form({indices: ''}));

		Wds.styleable_checkbox($('input[type="checkbox"]', $(redirect_selector)));
	});

})(jQuery);
