<script type="text/javascript">
(function ($) {

$("td.column-title").on('click', 'a.editinline', function () {
	var id = inlineEditPost.getId(this),
		loading =  "<?php echo esc_js('Loading, please hold on...', 'wds'); ?>"
	;
	setTimeout(function () {
		$(".wds_title:visible").attr("placeholder", loading);
		$(".wds_metadesc:visible").attr("placeholder", loading);
	}); // Just move off stack
	$.post(ajaxurl, {"action": "wds_get_meta_fields", "id": id}, function (data) {
		$(".wds_title:visible, .wds_metadesc:visible").attr("placeholder", "");
		if (!data) return false;
		if ("title" in data && data.title) {
			$(".wds_title:visible")
				.val(data.title)
			;
		}
		if ("description" in data && data.description) {
			$(".wds_metadesc:visible")
				.val(data.description)
			;
		}
	}, "json");
});

})(jQuery);
</script>