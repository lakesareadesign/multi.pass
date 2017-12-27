;(function ($, undefined) {

	window.Wds = window.Wds || {};

	window.Wds.Macros = window.Wds.Macros || {
		Field: function ($field, $root) {

			var me = this;

			function init () {
				bind();
			}

			function get_template () {
				return Wds.template('macros', 'list');
			}

			function bind () {
				var $input = $field,
					box = get_template(),
					$box
				;
				$input
					.after(
						Wds.tpl_compile(box)(_.extend({}, _wds_macros))
					)
					.closest(".fields").addClass('has-trigger-button')
				;
				$box = $input.parent().find('.insert-macro button');
				if (!$box.length) return false;

				Wds.qtips($box);

				$box
					.off("click", on_macros_toggle)
					.on("click", on_macros_toggle)
				;
			}

			function hide_other_lists($current_list, $current_hub) {
				$current_list.addClass('current');
				$current_hub.addClass('current');

				$root.find('.insert-macro.is-open').not('.current').removeClass('is-open');
				var $list = $root.find('.macro-list').not('.current');
				$list
					.hide()
					.find("li").off("click", on_macro_select)
				;

				$current_list.removeClass('current');
				$current_hub.removeClass('current');
			}

			function on_macros_toggle (e) {
				if (e && e.preventDefault) e.preventDefault();
				if (e && e.stopPropagation) e.stopPropagation();

				var $list = $field.parent().find(".macro-list"),
					$hub = $field.parent().find(".insert-macro")
				;

				hide_other_lists($list, $hub);

				if (!$list.length) return false;

				if ($list.is(":visible")) {
					$hub.removeClass("is-open");
					$list
						.hide()
						.find("li").off("click", on_macro_select)
					;
				} else {
					$hub.addClass("is-open");
					$list
						.show()
						.find("li").on("click", on_macro_select)
					;
				}

				return false;
			}

			function on_macro_select (e) {
				if (e && e.preventDefault) e.preventDefault();
				if (e && e.stopPropagation) e.stopPropagation();

				var $me = $(this),
					macro = $me.attr("data-macro")
				;

				if (macro && macro.length) {
					$field.val(
						$.trim($field.val()) + ' ' + macro
					);

					$field.trigger('change');
				}

				on_macros_toggle();

				return false;
			}

			init();

			return {
				bind: bind
			};
		},
		all: function ($root) {
			var fields = [];
			$root.find(".wds-allow-macros :text, .wds-allow-macros textarea").each(function () {
				fields.push(new Wds.Macros.Field($(this), $root));
			});
			return fields;
		}
	};

})(jQuery);
