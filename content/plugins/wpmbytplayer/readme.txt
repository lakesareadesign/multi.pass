=== mb.YTPlayer for background videos ===

Contributors: pupunzi
Tags: video player, youtube, full background, video, HTML5, flash, mov, jquery, pupunzi, mb.components, cover video, embed, embed videos, embed youtube, embedding, plugin, shortcode, video cover, video HTML5, youtube, youtube embed, youtube player, youtube videos
Requires at least: 3.0
Tested up to: 4.9
Stable tag:  3.2.3
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=DSHAHSJJCQ53Y
License: GPLv2 or later

Play any Youtube video as background of your page or as custom player inside an element of the page.

== Description ==

A Chrome-less Youtube® video player that let you play any YouTube® video as background of your WordPress® page or post.
You can activate it for your home page from the settings panel (no license needed) or on any post or page using the short code (need the <a href="https://pupunzi.com/wpPlus/go-plus.php?plugin_prefix=YTPL" target="_blank">Plus version</a>) as described in the Reference section of the settings.

[youtube http://www.youtube.com/watch?v=lTW937ld02Y]

If you prefer to use a Vimeo video you can take a look at <a href="https://wordpress.org/plugins/wp-vimeoplayer/">mb.VimeoPlayer Wordpress plug-in</a>

note:
If you don't want ADs on your background video and you are the owner of it you can disable this on your Youtube channel as explained here: http://candidio.com/blog/how-to-remove-ads-from-your-youtube-videos .


* demo: <a href="http://pupunzi.com/mb.components/mb.YTPlayer/demo/demo.html" target="_blank">See the Youtube background video in action!</a>
* video: <a href="http://www.youtube.com/watch?v=lTW937ld02Y" target="_blank">See a short video tutorial</a>
* pupunzi blog: <a href="http://pupunzi.open-lab.com" target="_blank">Go to my blog</a>
* pupunzi site: <a href="http://pupunzi.com" target="_blank">Go to my site</a>

This plug in has been tested successfully on:

* Chrome 11+, Firefox 7+, Opera 9+    on Mac OsX, Windows and Linux
* Safari 5+    on Mac OsX
* IE7+    on Windows (via Adobe Flash player)

== Installation ==

Extract the zip file and upload the contents to the wp-content/plugins/ directory of your WordPress installation, and then activate the plugin from the plugins page.

== Screenshots ==

1. The settings panel.
2. You can add a video as background or targeted to a DOM element in any page or post by inserting a shortcode (<a href="https://pupunzi.com/wpPlus/go-plus.php?plugin_prefix=YTPL" target="_blank">Plus version</a>) generated via the editor button.
3. The shortcode editor (<a href="https://pupunzi.com/wpPlus/go-plus.php?plugin_prefix=YTPL" target="_blank">Plus version</a>).

== To set your homepage background video: ==

1. Go to the mbYTPlayer settings panel (you can find it under the "settings" section of the WP backend.
2. set the complete YT video url
3. set all the other parameters as you need.

You can also set it by placing a shortcode in the home page via the YTPlayer shortcode window (<a href="https://pupunzi.com/wpPlus/go-plus.php?plugin_prefix=YTPL" target="_blank">Plus version</a>).
You can open it by clicking on the YTPlayer button in the top toolbar of the page editor.

== To set a video as background of a post or a page: ==
Use the editor button or write the below shortcode into the content of your post or page (<a href="https://pupunzi.com/wpPlus/go-plus.php?plugin_prefix=YTPL" target="_blank">Plus version</a>):

[mbYTPlayer url="http://www.youtube.com/watch?v=V2rifmjZuKQ" ratio="4/3" mute="false" loop="true" showcontrols="true" opacity=1]

* @ url = the YT url of the video you want as background
* @ ratio = the aspect ratio of the video 4/3 or 16/9
* @ mute = a boolean to mute the video
* @ loop = a boolean to loop the video on its end
* @ showcontrols = a boolean to show or hide controls and progression of the video
* @ opacity = a value from 0 to 1 that set the opacity of the background video
* @ id = The ID of the element in the DOM where you want to target the player (default is the BODY)
* @ quality:
  * small: Player height is 240px, and player dimensions are at least 320px by 240px for 4:3 aspect ratio.
  * medium: Player height is 360px, and player dimensions are 640px by 360px (for 16:9 aspect ratio) or 480px by 360px (for 4:3 aspect ratio).
  * large: Player height is 480px, and player dimensions are 853px by 480px (for 16:9 aspect ratio) or 640px by 480px (for 4:3 aspect ratio).
  * hd720: Player height is 720px, and player dimensions are 1280px by 720px (for 16:9 aspect ratio) or 960px by 720px (for 4:3 aspect ratio).
  * hd1080: Player height is 1080px, and player dimensions are 1920px by 1080px (for 16:9 aspect ratio) or 1440px by 1080px (for 4:3 aspect ratio).
  * highres: Player height is greater than 1080px, which means that the player's aspect ratio is greater than 1920px by 1080px.
  * default: YouTube selects the appropriate playback quality.

== mb.YTPlayer Plus ==
With the <a href="https://pupunzi.com/wpPlus/go-plus.php?plugin_prefix=YTPL" target="_blank">Plus version</a> you'll get:

* Remove the water-mark from the video
* Set the video opacity
* Set the video quality
* Set the video aspect ratio
* Set the video start point
* Set the video end point
* Show the control bar
* Choose the full screen behavior
* Set the starting audio volume
* Choose if the video should start mute or not
* Choose if the video should loop
* Add a raster image over the video
* Track the video views on Google Analytics
* Choose if the player should pause if the windows blur
* Add any YTPlayer video as background of any page or as backgraund of any element of your page enabling the short-code editor.
* Use the YTPlayer to display a clean Youtube video as player (via short-code).

== What about mobile ==
<b>The mb.YTPlayer now works on mobile devices!</b>
The video starts as soon the device screen is touched.

== Changelog ==

= 3.2.3 =
Bug fix: The startAt option didn't work as aspected with the latest Chrome.

= 3.2.2 =
Update: Updated to the latest version of the javascript.

= 3.2.1 =
Bug fix: Some times video didn't start on Safari.

= 3.2.0 =
new feature: Added "playOnlyIfVisible" property to play the video only if it is visible on screen.

= 3.1.9 =
Bug fix: Fixed a bug that was preventing the correct behavior if the "Remember last video time position" was checked.

= 3.1.8 =
Improve: the "delay" option for the initialization is now in seconds.

= 3.1.7 =
New feature: Added a delay parameter for the player initialization that can be set to solve initialization issue on rare theme or plugin conflicts.

= 3.1.6 =
Bug fix: Fix a bug that was preventing the correct behavior on certain devices.

= 3.1.5 =
Updates: Added a new option to remember the video time elapse next time you enter the page.

= 3.1.4 =
Updates: Added a new option to remember the video time elapse next time you enter the page.

= 3.1.2 =
Updates: various fixes to improve performance and to reduce external calls.

= 3.1.1 =
Updates: better performances and some changes in the admin panel.

= 3.1.0 =
Updates: Updated to the latest version of the jquery.mb.YTPlayer.js file (3.0.20) fixing a error if viewed on mobile devices; updated the PLUS box.

= 3.0.12 =
Bug fix: With the previous release I introduced a bug on OS detection that was generating an error on Linux OS.

= 3.0.11 =
Bug fix: There was an error on the options that prevent the player to work.

= 3.0.10 =
Update: Updated to the last javascript version (3.0.16).
Update: Updated the upgrade to Plus procedure to remove the free plug-in once installed the Plus.

= 3.0.9 =
Bug fix: There was an hack for Safari freeze that is not needed anymore with the latest safari release (it was breaking the plugin on Safari).

= 3.0.8 =
Updated to the latest jquery.mb.YTPlayer.js version.

= 3.0.7 =
New feature: Added the videos thumbnails in the plug-in options page.

= 3.0.6 =
New feature: Added a new option to set the background video on all pages.

= 3.0.5 =
Bug fix: The plug-in crashed with Wordpress version previous of 4.3.0.

= 3.0.4 =
Bug fix: There was a bug that prevents in some WP configuration the correct load of the plug-in.

= 3.0.3 =
Bug fix: The mb_notice class bug ($this->name_space) has been fixed.

= 3.0.2 =
Bug fix: In some cases the notice class did fire an error preventing the plug-in activation.

= 3.0.0 =
* From this release the FREE version of this plug-in allows the display of the background video only on the homepage. If you want to add it on any other page and customize its settings you need a Plus version available from the link in the settings page.


== Frequently Asked Questions ==

= I'm using the plug in as background video and I can see the control bar on the bottom but the video doesn't display =
 Your theme is probably using a wrapper for the content and it probably has a background color or image. You should check the CSS and remove that background to let the video that is behind do display correctly.

= Does it work on mobile devices =
Yes! the only difference is that the background video starts once the device scrin is touched after the page has been loaded.

= I would have an image on the background before the video starts and after the video end; how can I do? =
The simplest way is to add an image as background of the body via CSS.

= I set the video quality to hd1080 but it doesn't display at this quality; why? =
The video quality option is just a suggestion for the Youtube API; the video is served by Youtube with the quality that best fits the bandwidth and the display size according to that setting.

= The video stops some seconds before the real end; why? =
To prevent the display of the "play" button provided by the Youtube API the video intentionally stops some seconds before the end; if you are the owner of the video I can suggest to make it a little bit longer (about 3/4 seconds).

= I love your plugin! What can I do to help?
Creating and supporting this plugin takes up a lot of my free time, therefore I would highly appreciate if you could take a couple of minutes to write a review. This will help other WordPress users to start using this plugin and keep me motivated to maintain and support it. You can also make a donation to support my work!
