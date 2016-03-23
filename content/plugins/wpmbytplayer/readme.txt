=== mb.YTPlayer for background videos ===

Contributors: pupunzi
Tags: video player, youtube, full background, video, HTML5, flash, mov, jquery, pupunzi, mb.components, cover video, embed, embed videos, embed youtube, embedding, plugin, shortcode, video cover, video HTML5, youtube, youtube embed, youtube player, youtube videos
Requires at least: 3.0
Tested up to: 4.4
Stable tag:  2.0.6
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=DSHAHSJJCQ53Y
License: GPLv2 or later

Play any Youtube video as background of your page or as custom player inside an element of the page.

== Description ==

A Chrome-less Youtube® video player that let you play any YouTube® video as background of your WordPress® page or post.
You can activate it for your home page from the settings panel or on any post or page using the short code as described in the Reference section of the settings.

[youtube http://www.youtube.com/watch?v=lTW937ld02Y]

**From version 1.0 the player is using the Youtube® iframe API displaying the video using the HTML5 VIDEO tag for all the browsers that support it.**

**From version 1.7.6 the plug in is internationalized; available in English, Italian and Spanish (thanks to Andrew Kurtis http://www.webhostinghub.com ).**


The mb.YTPlayer doesn't work on any mobile devices (iOs, Android, Windows, etc.) due to restrictions applied by the vendors on media controls via javascript.
Adding a background image to the body as mobile devices fallback is a good practice and it will also prevent unwanted white flickering on desktop browsers when the video is buffering.



note:
If you doesn't want ADs on your background video and you are the owner of it you can disable this on your Youtube channel as explained here: http://candidio.com/blog/how-to-remove-ads-from-your-youtube-videos .


Links:/Users/mbicocchi/Dropbox/wordpress/My-Game/wordpress/wp-content/themes/myGame/templates/urban-1/css/intro.css

* demo: http://pupunzi.com/mb.components/mb.YTPlayer/demo/demo.html
* video: http://www.youtube.com/watch?v=lTW937ld02Y
* pupunzi blog: http://pupunzi.open-lab.com
* pupunzi site: http://pupunzi.com

This plug in has been tested successfully on:

* Chrome 11+, Firefox 7+, Opera 9+    on Mac OsX, Windows and Linux
* Safari 5+    on Mac OsX
* IE7+    on Windows (via Adobe Flash player)

== Installation ==

Extract the zip file and upload the contents to the wp-content/plugins/ directory of your WordPress installation, and then activate the plugin from the plugins page.

== Screenshots ==

1. The settings panel.
2. You can add a video as background or targeted to a DOM element in any page or post by inserting a shortcode generated via the editor button.
3. The shortcode editor.

== To set your homepage background video: ==

1. Go to the mbYTPlayer settings panel (you can find it under the "settings" section of the WP backend.
2. set the complete YT video url
3. set all the other parameters as you need.

To remove the video just leave the url blank.

You can also set it by placing a shortcode in the home page via the YTPlayer shortcode window. 
You can open it by clicking on the YTPlayer button in the top toolbar of the page editor.

== To set a video as background of a post or a page: ==
Use the editor button or write the below shortcode into the content of your post or page:

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

== What about mobile ==

The mb.YTPlayer doesn't work on any mobile devices (iOs, Android, Windows, etc.) due to restrictions applied by the vendors on media controls via javascript.
Adding a background image to the body as mobile devices fallback is a good practice and it will also prevent unwanted white flickering on desktop browsers when the video is buffering.

== Changelog ==

= 2.0.6 =
* Bug fix: the volume value was not preserved in the settings page.

= 2.0.5 =
* Update the jquery.mb.YTPlayer.js file with better performances for the initial video start.

= 2.0.4 =
* Add the text-domain declaration for the translate.wordpress.org.

= 2.0.3 =
* Bug fix: The loop on webkit browsers randomly failed.
* Feature: The video now stops just 1.5 seconds from the end (it was 3 sec.).

= 2.0.2 =
* Bugfix: If the autoPlay option was set to false the player was hidden.

= 2.0.1 =
* Bugfix: If the control-bar was not displayed there were several javascript errors due to a missed code condition.

= 2.0.0 =
* Bugfix: updated to the new Google API 3 fixing the display of the poster-frame if used as in-line player.

...

= 0.1 =
* First release

== Frequently Asked Questions ==

= I'm using the plug in as background video and I can see the control bar on the bottom but the video doesn't display =
 Your theme is probably using a wrapper for the content and it probably has a background color or image. You should check the CSS and remove that background to let the video that is behind do display correctly.

= Everything is working fine on my desktop but it doesn't work on any mobile devices =
Due to restrictions adopted by browser vendors and Youtube team this plugin can't work on touch devices.

= I would have an image on the background before the video starts and after the video end; how can I do? =
The simplest way is to add an image as background of the body via CSS.

= I set the video quality to hd1080 but it doesn't display at this quality; why? =
The video quality option is just a suggestion for the Youtube API; the video is served by Youtube with the quality that best fits the bandwidth and the display size according to that setting.

= The video stops some seconds before the real end; why? =
To prevent the display of the "play" button provided by the Youtube API the video intentionally stops some seconds before the end; if you are the owner of the video I can suggest to make it a little bit longer (about 3/4 seconds).
