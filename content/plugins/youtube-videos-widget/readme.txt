=== Plugin Name ===
Contributors: dhechler
Tags: youtube, video, widget, youtube widget, youtube id
Requires at least: 2.0.2
Tested up to: 3.3
Stable tag: trunk

Youtube Videos Widget lets you add the latest youtube video from a Youtube ID.
== Description ==

Youtube Videos Widget lets you add the latest youtube video anywhere in your Wordpress blog. You can add it to a post or a page with the short code [youtube_videos], or to a sidebar with the included widget. Customize options in the options page and on the widget itself.

== Installation ==

1. Upload `youtube-videos.php` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Place `<?php echo do_shortcode('youtube_videos'); ?>` in your templates where you want your video to appear or place the widget in any sidebar. Or [youtube_videos] in your post or page.

== Frequently Asked Questions ==

= Can I use this in my .php template files? =

Yes. Add `<?php echo do_shortcode('youtube_videos'); ?>` anywhere in your template files.

= How come I cannot customize width and height on the short code version? =

You can use the backend options to add custom width and height

== Screenshots ==

1. Youtube widget area where you can change options.

== Changelog ==
1.1 Manage username for both shortcode and widget in the Settings > Youtube Videos Options panel
1.2 Added error handling for no username.
1.3 Fixed issue with saving widget options. Added ability to resize videos in the backend.

== Upgrade Notice ==
1.3 Fixed issue with saving widget options. Added ability to resize videos in the backend.

== Arbitrary section ==

