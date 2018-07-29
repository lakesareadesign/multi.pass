(function ($) {
	window.Wds = window.Wds || {};

	function init () {
		window.Wds.hook_conditionals();
		window.Wds.hook_toggleables();
		window.Wds.media_url($('.wds-media-url'));
		$('select').select2({
			minimumResultsForSearch: -1
		});
	}

	$(init);
})(jQuery);
