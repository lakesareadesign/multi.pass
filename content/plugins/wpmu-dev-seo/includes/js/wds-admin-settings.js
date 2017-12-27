(function ($) {
	window.Wds = window.Wds || {};

	function add_custom_meta_tag_field() {
		var $this = $(this),
			$container = $this.closest('.wds-custom-meta-tags'),
			$new_input = $container.find('.wds-custom-meta-tag:first-of-type').clone();

		$new_input.insertBefore($this);
		$new_input.find('input').val('').focus();
	}

	function init () {
		window.Wds.styleable_file_input($('.wds-styleable-file-input'));
		$('select').select2({
			minimumResultsForSearch: -1
		});
		$('.wpmud').on('click', '.wds-custom-meta-tags button', add_custom_meta_tag_field);
	}

	$(init);
})(jQuery);