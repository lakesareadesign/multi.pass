(function ($) {

function show_play_overlays () {
	var $overlays = $(".ytvw-video-play_overlay");
	$overlays.each(function () {
		var $me = $(this),
			$parent = $me.parents(".ytvw-watch_video"),
			me_offset = $me.offset(),
			me_h = $me.height(),
			parent_offset = $parent.offset(),
			parent_h = $parent.height(),
			parent_w = $parent.width()
		;
		$me
			.css({
				"position": "absolute",
				"top": parent_offset.top + ((parent_h - me_h) / 2),
				"width": parent_w,
				"text-align": "center"
			})
			.fadeIn('slow')
		;
	});
}

function init_player_overlays () {
	var window_width = $(window).width(),
		window_height = $(window).height(),
		close_dialog = function () {
			$(".ytvw-video_overlay").empty().hide();
			$("#ytwv-video_overlay-background").hide();
			return false;
		}
	;
	if (window_width < 600 || window_height < 355) return true;

	$("body").on("click", ".ytvw-watch_video, .ytvw-video-play_overlay", function () {
		var window_width = $(window).width(),
			window_height = $(window).height()
		;
		if (window_width < 600 || window_height < 355) return true;
		var $temp = $(this),
			$me = $temp.is(".ytvw-watch_video") ? $temp : $temp.parents(".ytvw-watch_video"),
			video = $me.attr("data-video"),
			protocol = window.location.protocol,
			$root = $("#ytwv-video_overlay-background"),
			$root = $root.length ? $root : ($("body").append("<div id='ytwv-video_overlay-background' style='display:none' />") && $("#ytwv-video_overlay-background")),
			$player = $me.find(".ytvw-video_overlay")
		;
		$root
			.css({
				"position": "fixed",
				"top": 0,
				"left": 0,
				"height": 1200000,
				"width": 2000000
			})
			.on("click", close_dialog)
			.show()
		;
		$player
			.html('<iframe width="560" height="315" src="' + protocol + '//www.youtube.com/embed/' + video + '" class="ytvw-video-' + video + '" frameborder="0" allowfullscreen style="display:none"></iframe><a href="#" class="ytvw-close"><span>Close</span></a>')
			.append("<span class='ytvw-loading'>Loading...</span>")
			.css({
				"position": "fixed",
				"width": 560,
				"height": 315,
				"z-index": 99999,
				"top": (window_height - 355) / 2,
				"left": (window_width - 600) / 2
			})
			.find('.ytvw-video-' + video).on("load", function () {
				$player.find(".ytvw-loading").hide();
				$(this).show();
			}).end()
			.find(".ytvw-close").on("click", close_dialog).end()
			.show()
		;
		return false;
	}).on("keydown", function (e) {
		if (27 != e.keyCode) return true;
		close_dialog();
	});
}

$(init_player_overlays);
$(window)
	.load(show_play_overlays)
	.on("resize", function () {
		init_player_overlays();
		show_play_overlays();
	})
;

})(jQuery);