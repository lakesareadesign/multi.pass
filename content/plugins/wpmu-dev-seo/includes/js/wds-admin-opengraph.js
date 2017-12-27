;(function ($, undefined) {

	window.Wds = window.Wds || {};

	window.Wds.OgImage = function ($root) {

		var idx = $root.attr("data-name");

		var template = '<div class="og-image item">' +
			'<img src="{{= url }}" />' +
			'<input type="hidden" value="{{= url }}" name="{{= name }}" />' +
			'<a href="#remove" class="remove-action"><i class="wds-icon-close"></i></a>' +
		'</div>';

		var init = function () {
			if (!(wp || {}).media) {
				// No media to use
				$("td.fields.og-images").closest("tr").remove();
				return false;
			}

			wp.media.frames.wds_ogimg = wp.media.frames.wds_ogimg || {};
			wp.media.frames.wds_ogimg[idx] = wp.media.frames.wds_ogimg[idx] || new wp.media({
				multiple: false,
				library: {type: 'image'}
			});
			$root.find('a[href="#add"]').off('click').on('click', function (e) {
				if (e && e.stopPropagation) e.stopPropagation();
				if (e && e.preventDefault) e.preventDefault();

				wp.media.frames.wds_ogimg[idx].open();

				return false;
			});
			wp.media.frames.wds_ogimg[idx].off('select').on('select', add_handler);

			$root.find("input:text").each(function () {
				$(this).replaceWith(Wds.tpl_compile(template)({
					url: $(this).val(),
					name: $root.attr("data-name") + '[]'
				}));
			});

			$root.on("click", 'a[href="#remove"]', remove_handler);
		};

		var remove_handler = function (e) {
			if (e && e.stopPropagation) e.stopPropagation();
			if (e && e.preventDefault) e.preventDefault();

			$(this).closest(".og-image.item").remove();

			return false;
		}

		var add_handler = function () {
			var selection = wp.media.frames.wds_ogimg[idx].state().get('selection'),
				url
			;
			if (!selection) return false;

			selection.each(function (model) {
				url = model.get("url");
			});

			if (!url) return false;
			$root.append(Wds.tpl_compile(template)({
				url: url,
				name: $root.attr("data-name") + '[]'
			}));

		};

		idx = idx || 0;
		init();
	};

	function init () {
		$(".fields.og-images").each(function (idx, el) {
			var imgs = new Wds.OgImage($(el));
		});

		window.Wds.hook_toggleables();
	}

	$(init);

})(jQuery);
