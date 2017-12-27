;(function ($) {

	$(function () {
		$(".box-autolinks-custom-keywords-settings").each(function () {
			window.Wds.Keywords.custom_pairs($(this));
		});
		$("#ignorepost").closest(".wds-group").each(function () {
			window.Wds.Postlist.exclude($(this));
		});

		$('select.select-container').select2({
			minimumResultsForSearch: -1
		});

		window.Wds.upsell();
		window.Wds.link_dropdown();
		window.Wds.accordion();
	});

})(jQuery);
