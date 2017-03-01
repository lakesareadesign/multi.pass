;(function ($, undefined) {

	window.Wds = window.Wds || {};

	window.Wds.OgImage = function ($root) {

		var idx = $root.attr("data-name");

		var template = '<div class="og-image item">' +
			'<img src="<%= url %>" />' +
			'<input type="hidden" value="<%= url %>" name="<%= name %>" />' +
			'<a href="#remove" class="remove-action">&times;</a>' +
		'</div>';

		var init = function () {
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
				$(this).replaceWith(_.template(template)({
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
			$root.append(_.template(template)({
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
		$("fieldset.toggleable legend").off("click").on("click", function (e) {
			if (e && e.stopPropagation) e.stopPropagation();
			if (e && e.preventDefault) e.preventDefault();

			$(this).closest("fieldset").toggleClass("inactive");

			// So this is pretty horrible, but we have to work around the
			// DEV ui library inflexibility. So, retrigger the current
			// vertical tab click, in order to force it to recalculate heights.
			// Only do it if we really need to, though.
			if ($(".vertical-tabs").length) {
				$(".vertical-tabs .tab>:radio:checked").trigger("click");
			}

			return false;
		});
	}

	$(init);

})(jQuery);
