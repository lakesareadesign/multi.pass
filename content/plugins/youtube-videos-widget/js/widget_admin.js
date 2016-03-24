(function ($) {

function list_videos (data, channel) {
	var $root = $("#ytvw-admin-videos-list_output"),
		html = '',
		width = ($(window).width() / 3) * 2,
		width = width > 800 ? 800 : width,
		height = ($(window).height() / 5) * 4
	;
	if (!$root.length) {
		$("body").append('<div id="ytvw-admin-videos-list_output" />');
		$root = $("#ytvw-admin-videos-list_output");
	}
	html += '<p><a href="#save-selection" class="ytvw-admin-videos-save_selection button">' + ytvw_l10n.save_selection + '</a></p>';
	html += '<table class="widefat" id="ytvw-admin-videos-list_selection" data-channel="' + channel + '" >';
	$.each(data, function (idx, item) {
		var checked = item.checked ? 'checked="checked"' : '';
		html += '<tr>';
		html += '<td><input type="checkbox" value="' + encodeURIComponent(JSON.stringify(item)) + '" ' + checked + ' /></td>';
		html += '<td>' + item.title + '</td>';
		html += '<td>' + item.raw_description + '</td>';
		html += '</tr>';
	});
	html += '</table>';
	html += '<p><a href="#save-selection" class="ytvw-admin-videos-save_selection button">' + ytvw_l10n.save_selection + '</a></p>';
	$root.html(html);
	tb_show(ytvw_l10n.select_videos, '#TB_inline?height=' + height + '&width=' + width + '&inlineId=ytvw-admin-videos-list_output');
	$("#TB_window").height('auto').width('auto'); // Fix for media-upload breakage
}

$(function () {
	// List opening
	$("body").on("click", ".ytvw-admin-videos-select", function () {
		var $me = $(this),
			$root = $me.parents(".widget"),
			$channel = $root.find(':input[name$="[channel]"]'),
			$no_legacy = $root.find(':input[name$="[no_legacy]"]'),
			channel = ($channel.length ? $channel.attr("data-channel") : false),
			no_legacy = ($no_legacy.length ? $no_legacy.is(":checked") : false)
		;
		if (!$channel.length || !channel) return false;

		$me.after(" <span class='ytvw-admin-videos-waiting'>" + ytvw_l10n.please_wait + "</span>");
		$.post(ajaxurl, {
			"action": "ytvw_select_channel_videos",
			"channel": channel,
			"no_legacy": (!!no_legacy ? 1 : 0)
		}, function () {}, 'json')
			.done(function (data) {
				list_videos(data, channel);
			})
			.always(function () {
				$root.find(".ytvw-admin-videos-waiting").remove();
			})
		;
		return false;
	});
	// Selection saving
	$("body").on("click", ".ytvw-admin-videos-save_selection", function () {
		var $me = $(this),
			$items = $("#ytvw-admin-videos-list_selection :checked"),
			channel = $("#ytvw-admin-videos-list_selection").attr("data-channel"),
			videos = []
		;
		$items.each(function () {
			videos.push($(this).val());
		});
		$.post(ajaxurl, {
			"action": "ytvw_save_video_selection",
			"channel": channel,
			"videos": videos
		}, function () {}, 'json')
			.done(function () {
				//tb_remove();
				window.location.reload();
			})
		;
		return false;
	});
});
})(jQuery);