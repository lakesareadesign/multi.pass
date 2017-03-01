;(function ($) {

	$(function () {
		window.Wds.Keywords.custom_pairs($(".box-autolinks-custom-keywords-settings"));
		window.Wds.Postlist.exclude($("#ignorepost").closest(".wds-group"));
	});

})(jQuery);
