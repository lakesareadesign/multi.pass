(function ($) {

	/**
	 * Handles change/keyup event onpage metabox fields dispatch
	 *
	 * @param {Object} e Event object (optional)
	 */
	function render_fields_change (e) {
		var $currentTarget = $(e.currentTarget),
			field = false,
			value = false;

		if($currentTarget.is('#title')) {
			field = 'title';
		} else if($currentTarget.is('#content') || $currentTarget.is('#excerpt')) {
			field = 'desc';
		}

		if( field ){
			$.post(ajaxurl, {
				id: wp.autosave.getPostData().post_id,
				action: "wds_metabox_update",
				post: wp.autosave.getPostData(),
			}, 'json').done(function (rsp) {
				var description = (rsp || {}).description || '',
					title = (rsp || {}).title || '';
				$('#wds_title').attr('placeholder',title);
				$('#wds_metadesc').attr('placeholder',description);
			});
		}

	}

	function init () {
		window.setTimeout( function() {
			var editor = typeof tinymce !== 'undefined' && tinymce.get('content');
			if( editor ) {
				editor.on('change', function(e) {
					e.currentTarget = $('#content');
					_.debounce(render_fields_change.bind(e), 1000);
				}).trigger('change');
			}
		}, 1000 );
		$(document).on("input","input#title,textarea#content,textarea#excerpt",_.debounce(render_fields_change, 1000)).trigger('input');
	}
	// Boot
	$(init);

})(jQuery);
