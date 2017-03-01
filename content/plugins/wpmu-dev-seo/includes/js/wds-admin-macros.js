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
				$field.on("focus", on_focus);
				return me;
			}
			function unbind () {
				$field.on("focus", on_focus);
				return me;
			}

			function on_focus () {
				var $input = $field,
					box = get_template(),
					$box
				;
				$root
					.find('.insert-macro').remove().end()
					.find('.has-trigger-button').removeClass('has-trigger-button').end()
				;
				$input
					.after(
						_.template(box)(_.extend({}, _wds_macros))
					)
					.closest(".fields").addClass('has-trigger-button')
				;
				$box = $input.parent().find('.insert-macro button');
				if (!$box.length) return false;

				$box
					.off("click", on_macros_toggle)
					.on("click", on_macros_toggle)
				;
			}

			function on_macros_toggle (e) {
				if (e && e.preventDefault) e.preventDefault();
				if (e && e.stopPropagation) e.stopPropagation();

				var $list = $field.parent().find(".macro-list"),
					$hub = $field.parent().find(".insert-macro")
				;
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
				}

				on_macros_toggle();

				return false;
			}

			init();

			return {
				bind: bind,
				unbind: unbind
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
