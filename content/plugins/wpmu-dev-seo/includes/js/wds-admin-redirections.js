;(function($, undefined) {

	var _stop = function (e) {
		if (e && e.stopPropagation) e.stopPropagation();
		if (e && e.preventDefault) e.preventDefault();
	};

	var redirect = function (data) {
		data = data || {};
		data.action = 'wds-service-redirect';
		return $.post(ajaxurl, data, function(){}, 'json');
	};

	var handle_redirect_open = function (e) {
		WDP.showOverlay('#wds-new-redirect');

		WDP.overlay.box_content
			.off('click', 'button')
			.on('click', 'button', handle_redirect)
		;
		
		return _stop(e);
	};

	var handle_redirect = function (e) {
		var $root = $(e.target).closest('.wds-redirect'),
			$fields = $root.find("input"),
			data = {}
		;

		$fields.each(function () {
			var $me = $(this);
			data[$me.attr("name")] = $me.val();
		});

		redirect(data)
			.always(function () {
				$root.find(".close").click();
				setTimeout(window.location.reload.bind(window.location));
			})
		;

		return _stop(e);
	};

	var handle_selector_change = function (e) {
		var is_checked = !!$(e.target).is(":checked"),
			$targets = $('.wds-redirections-list tbody :checkbox[name*="bulk"]')
		;
		if ($targets.length) $targets.attr("checked", is_checked);
	}

	var init = function () {
		$(".wds-redirections-list")	
			.off("click", ".box-title button.wds-add_new")
			.on("click", ".box-title button.wds-add_new", handle_redirect_open)

			.off("click", "th.selector input")
			.on("click", "th.selector input", handle_selector_change)
		;

		window.Wds.styleable_checkbox($('input[type="checkbox"]'));
	};

	$(init);

})(jQuery);