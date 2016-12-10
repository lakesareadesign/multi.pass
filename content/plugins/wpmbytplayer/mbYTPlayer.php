<?php
/*
Plugin Name: mb.YTPlayer for background videos
Plugin URI: http://pupunzi.com/#mb.components/mb.YTPlayer/YTPlayer.html
Description: Play a Youtube video as background of your page. Go to <strong>mb.ideas > mb.YTPlayer</strong> to activate the background video option for your homepage.
Author: Pupunzi (Matteo Bicocchi)
Version: 3.0.3
Author URI: http://pupunzi.com
Text Domain: wpmbytplayer
*/

require('inc/mb_notice/notice.php');

define("MBYTPLAYER_VERSION", "3.0.3");

//$ytp_notice->reset_notice();

$link = "https://pupunzi.com/wpPlus/go-plus.php?locale=" . get_locale() . "&plugin_prefix=YTPL&plugin_version=" . MBYTPLAYER_VERSION . "&lic_domain=" . $plugin_domain . "&lic_theme=" . get_template();
$ytp_message = '<b>WP-YTPLAYER 3.0</b>: <br>From this release you need the <b>Plus version</b> to use the short-code generator on the post/page editor and to remove the watermark from the video. Just follow the link to get one!' . ' <a target="_blank" href="' . $link . '">' . __('Get your <b>Plus</b> now!', 'wpmbytplayer') . '</a>';
$ytp_notice = new mb_notice('mbYTPlayer', plugin_basename(__FILE__));
$ytp_notice->add_notice($ytp_message, 'success');

$this_plugin = plugin_basename(__FILE__);

function isMbMobile()
{
  if (isset($_SERVER["HTTP_X_WAP_PROFILE"])) {
    return true;
  }
  if (preg_match("/wap.|.wap/i", $_SERVER["HTTP_ACCEPT"])) {
    return true;
  }
  if (preg_match("/iphone|ipad/i", $_SERVER["HTTP_USER_AGENT"])) {
    return true;
  }
  return false;
}

function mbYTPlayer_install()
{
// add and update our default options upon activation
  add_option('mbYTPlayer_version', MBYTPLAYER_VERSION);
  add_option('mbYTPlayer_Home_is_active', 'true');

  add_option('mbYTPlayer_home_video_url', '');
  add_option('mbYTPlayer_home_video_page', 'static');
}

register_activation_hook(__FILE__, 'mbYTPlayer_install');

$mbYTPlayer_version = get_option('mbYTPlayer_version');
$mbYTPlayer_Home_is_active = get_option('mbYTPlayer_Home_is_active');
$mbYTPlayer_home_video_url = get_option('mbYTPlayer_home_video_url');
$mbYTPlayer_home_video_page = get_option('mbYTPlayer_home_video_page');

$mbYTPlayer_show_controls = "false";
$mbYTPlayer_show_videourl = "false";
$mbYTPlayer_ratio = "16/9";
$mbYTPlayer_audio_volume = 50;
$mbYTPlayer_mute = true;
$mbYTPlayer_start_at = 0;
$mbYTPlayer_stop_at = 0;
$mbYTPlayer_loop = "true";
$mbYTPlayer_opacity = 10;
$mbYTPlayer_quality = "default";
$mbYTPlayer_add_raster = "true";
$mbYTPlayer_realfullscreen = "false";
$mbYTPlayer_stop_on_blur = "true";
$mbYTPlayer_track_ga = "false";

//set up defaults if these fields are empty
if ($mbYTPlayer_version != MBYTPLAYER_VERSION) {
  $mbYTPlayer_version = MBYTPLAYER_VERSION;
}
if (empty($mbYTPlayer_Home_is_active)) {
  $mbYTPlayer_Home_is_active = false;
}
if (empty($mbYTPlayer_show_videourl)) {
  $mbYTPlayer_show_videourl = "false";
}
if (empty($mbYTPlayer_home_video_page)) {
  $mbYTPlayer_home_video_page = "static";
}

//action link http://www.wpmods.com/adding-plugin-action-links
add_filter('plugin_action_links', 'mbYTPlayer_action_links', 10, 2);
function mbYTPlayer_action_links($links, $file)
{
  global $this_plugin;
  // check to make sure we are on the correct plugin
  if ($file == $this_plugin) {
    // the anchor tag and href to the URL we want. For a "Settings" link, this needs to be the url of your settings page
    $settings_link = '<a href="' . get_bloginfo('wpurl') . '/wp-admin/admin.php?page=wpmbytplayer/mbYTPlayer.php">Settings</a>';
    // add the link to the list
    array_unshift($links, $settings_link);
  }
  return $links;
}

add_action('wp_enqueue_scripts', 'mbYTPlayer_init');
function mbYTPlayer_init()
{
  global $mbYTPlayer_version;

  if (!is_admin()) {
    wp_enqueue_script('jquery');
    wp_enqueue_script('mb.YTPlayer', plugins_url('/js/jquery.mb.YTPlayer.js', __FILE__), array('jquery'), $mbYTPlayer_version, true, 1000);
    wp_enqueue_style('mb.YTPlayer_css', plugins_url('/css/mb.YTPlayer.css', __FILE__), array(), $mbYTPlayer_version, 'screen');
  }
}

add_action('plugins_loaded', 'mbytp_localize');
function mbytp_localize()
{
  load_plugin_textdomain('wpmbytplayer', false, dirname(plugin_basename(__FILE__)) . '/languages/');
}

// scripts to load in the footer
add_action('wp_footer', 'mbYTPlayer_player_head', 20);
function mbYTPlayer_player_head()
{
  global $mbYTPlayer_home_video_url, $mbYTPlayer_show_controls, $mbYTPlayer_ratio, $mbYTPlayer_show_videourl, $mbYTPlayer_start_at, $mbYTPlayer_stop_at, $mbYTPlayer_mute, $mbYTPlayer_loop, $mbYTPlayer_opacity, $mbYTPlayer_quality, $mbYTPlayer_add_raster, $mbYTPlayer_track_ga, $mbYTPlayer_realfullscreen, $mbYTPlayer_stop_on_blur, $mbYTPlayer_home_video_page, $mbYTPlayer_Home_is_active, $mbYTPlayer_audio_volume;
  echo '
	<!-- mbYTPlayer -->
	<script type="text/javascript">

    function onYouTubePlayerAPIReady() {
    	if(ytp.YTAPIReady)
		    return;
	    ytp.YTAPIReady=true;
	    jQuery(document).trigger("YTAPIReady");
    }

    jQuery.mbYTPlayer.rasterImg ="' . plugins_url('/images/', __FILE__) . 'raster.png";
	jQuery.mbYTPlayer.rasterImgRetina ="' . plugins_url('/images/', __FILE__) . 'raster@2x.png";

	jQuery(function(){
        jQuery(".mbYTPMovie").YTPlayer()
	});

	</script>
	<!-- end mbYTPlayer -->
	';

  $canShowMovie = is_front_page() && !is_home(); // A static page set as home;

  if ($mbYTPlayer_home_video_page == "blogindex")
    $canShowMovie = is_home(); // the blog index page;

  else if ($mbYTPlayer_home_video_page == "both")
    $canShowMovie = is_front_page() || is_home(); // A static page set as home;

  if ($canShowMovie && !isMbMobile() && $mbYTPlayer_Home_is_active) {

    if (empty($mbYTPlayer_home_video_url))
      return false;

    if ($mbYTPlayer_opacity > 1)
      $mbYTPlayer_opacity = $mbYTPlayer_opacity / 10;

    $vids = explode(',', $mbYTPlayer_home_video_url);
    $n = rand(0, count($vids) - 1);
    $mbYTPlayer_home_video_url_revised = $vids[$n];

    $mbYTPlayer_start_at = $mbYTPlayer_start_at > 0 ? $mbYTPlayer_start_at : 1;
    $mbYTPlayer_player_homevideo =
      '<div id=\"bgndVideo_home\" data-property=\"{ videoURL:\'' . $mbYTPlayer_home_video_url_revised . '\',opacity:' . $mbYTPlayer_opacity . ',autoPlay:true,containment:\'body\',startAt:' . $mbYTPlayer_start_at . ',stopAt:' . $mbYTPlayer_stop_at . ',mute:' . $mbYTPlayer_mute . ',vol:' . $mbYTPlayer_audio_volume . ',optimizeDisplay:true,showControls:' . $mbYTPlayer_show_controls . ',printUrl:' . $mbYTPlayer_show_videourl . ',loop:' . $mbYTPlayer_loop . ',addRaster:' . $mbYTPlayer_add_raster . ',quality:\'' . $mbYTPlayer_quality . '\',ratio:\'' . $mbYTPlayer_ratio . '\',realfullscreen:\'' . $mbYTPlayer_realfullscreen . '\',gaTrack:\'' . $mbYTPlayer_track_ga . '\',stopMovieOnBlur:\'' . $mbYTPlayer_stop_on_blur . '\'}\"></div>';
    echo '
	<!-- mbYTPlayer Home -->
	<script type="text/javascript">

	jQuery(function(){
	    var homevideo = "' . $mbYTPlayer_player_homevideo . '";
	    jQuery("body").prepend(homevideo);
	    jQuery("#bgndVideo_home").YTPlayer();
    });

	</script>
	<!-- end mbYTPlayer Home -->
        ';
  }
}

;


// define the shortcode function
add_shortcode('mbYTPlayer', 'mbYTPlayer_player_shortcode');
add_filter('widget_text', 'do_shortcode');
function mbYTPlayer_player_shortcode($atts)
{

  extract(shortcode_atts(array(
    'url' => '',
    'showcontrols' => '',
    'printurl' => '',
    'mute' => '',
    'ratio' => '',
    'loop' => '',
    'opacity' => '',
    'quality' => '',
    'addraster' => '',
    'isinline' => '',
    'playerwidth' => '',
    'playerheight' => '',
    'autoplay' => '',
    'gaTrack' => '',
    'stopmovieonblur' => '',
    'realfullscreen' => 'true',
    'elementselector' => null,
    'startat' => '',
    'stopat' => '',
    'volume' => ''
  ), $atts));
  // stuff that loads when the shortcode is called goes here

  $mbYTPlayer_player_shortcode = '<div class="ytp_alert">' . __('<h3>[YTPlayer short code]</h3><p>You need a <b>license key</b> to display a <b>YTPlayer video</b> using the shortcode.<br> Go to the <b>YTPlayer settings page</b> to get your license</p>', 'wpmbytplayer') . '</div>';

  return $mbYTPlayer_player_shortcode;
}

add_action('admin_init', 'register_YTPlayerSettings');
function register_YTPlayerSettings()
{
  //register YTPlayer settings
  register_setting('YTPlayer-activate-group', 'mbYTPlayer_Home_is_active');

  register_setting('YTPlayer-settings-group', 'mbYTPlayer_version');
  register_setting('YTPlayer-settings-group', 'mbYTPlayer_home_video_url');
  register_setting('YTPlayer-settings-group', 'mbYTPlayer_home_video_page');
}

/**
 * Add root menu
 */
require("inc/mb-admin-menu.php");

add_action('admin_menu', 'add_mbYTPlayer_option_page');
function add_mbYTPlayer_option_page()
{
  add_submenu_page('mb-ideas-menu', 'YTPlayer', 'YTPlayer', 'manage_options', __FILE__, 'mbYTPlayer_options_page');
}

add_action('admin_enqueue_scripts', 'load_ytp_admin_script');
function load_ytp_admin_script($hook)
{
  if ($hook == 'mb-ideas_page_wpmbytplayer/mbYTPlayer' && $hook != 'toplevel_page_mb-ideas-menu') {
    wp_enqueue_style('ytp_admin_css', plugins_url('/inc/mb_admin.css', __FILE__), null, MBTG_VERSION);
  }
}

add_filter('admin_body_class', 'ytp_add_body_classes');
function ytp_add_body_classes($classes)
{
  $screen = (get_current_screen()->id == "mb-ideas_page_wpmbytplayer/mbYTPlayer") ? 1 : 0;
  $classes = '';
  if ($screen)
    $classes = 'mb-free';
  return $classes;
}

function mbYTPlayer_options_page()
{ // Output the options page
  $link = "https://pupunzi.com/wpPlus/go-plus.php?locale=" . get_locale() . "&plugin_prefix=YTPL&plugin_version=" . MBYTPLAYER_VERSION . "&lic_domain=" . $_SERVER['SERVER_NAME'] . "&lic_theme=" . get_template();
  ?>

  <div class="wrap">
    <a href="http://pupunzi.com"><img style=" width: 350px" src="<?php echo plugins_url('images/logo.png', __FILE__); ?>" alt="Made by Pupunzi"/></a>

    <h2 class="title"><?php _e('mb.YTPlayer', 'wpmbytplayer'); ?></h2>

    <img style=" width: 150px; position: absolute; right: 0; top: 0; z-index: 100" src="<?php echo plugins_url('images/YTPL.svg', __FILE__); ?>" alt="mb.YTPlayer icon"/>

    <h3><?php _e('From here you can set a background video for your home page.', 'wpmbytplayer'); ?></h3>

    <form id="optionsForm" method="post" action="options.php">
      <?php settings_fields('YTPlayer-activate-group'); ?>
      <?php do_settings_sections('YTPlayer-activate-group'); ?>

      <table class="form-table">
        <tr valign="top">
          <th scope="row"><?php _e('activate the background video', 'wpmbytplayer'); ?></th>
          <td>
            <div class="onoffswitch">
              <input class="onoffswitch-checkbox" type="checkbox" id="mbYTPlayer_Home_is_active"
                     name="mbYTPlayer_Home_is_active" value="true" <?php if (get_option('mbYTPlayer_Home_is_active')) {
                echo ' checked="checked"';
              } ?>/> <label class="onoffswitch-label" for="mbYTPlayer_Home_is_active"></label>
            </div>
          </td>
        </tr>
      </table>
    </form>

    <form id="optionsForm" method="post" action="options.php">
      <?php settings_fields('YTPlayer-settings-group'); ?>
      <?php do_settings_sections('YTPlayer-settings-group'); ?>

      <table class="form-table">
        <tr valign="top">
          <th scope="row"> <?php _e('The Youtube vudeo url is:', 'wpmbytplayer'); ?></th>
          <td>
            <textarea name="mbYTPlayer_home_video_url" style="width:100%"
                      value="<?php echo esc_attr(get_option('mbYTPlayer_home_video_url')); ?>"><?php echo esc_attr(get_option('mbYTPlayer_home_video_url')); ?></textarea>

            <p><?php _e('Copy and paste here the URL of the Youtube video you want as your homepage background. If you add more then one URL comma separated it will be chosen one randomly each time you reach the page', 'wpmbytplayer'); ?>
            </p>
          </td>
        </tr>

        <tr valign="top">
          <th scope="row"><?php _e('The page where to show the background video is:', 'wpmbytplayer'); ?></th>
          <td>
            <input type="radio" name="mbYTPlayer_home_video_page"
                   value="static" <?php if (get_option('mbYTPlayer_home_video_page') == "static" || get_option('mbYTPlayer_home_video_page') == "") {
              echo ' checked';
            } ?> /> <?php _e('Static Homepage', 'wpmbytplayer'); ?> <br>
            <input type="radio" name="mbYTPlayer_home_video_page"
                   value="blogindex" <?php if (get_option('mbYTPlayer_home_video_page') == "blogindex") {
              echo ' checked';
            } ?>/> <?php _e('Blog index Homepage', 'wpmbytplayer'); ?> <br>
            <input type="radio" name="mbYTPlayer_home_video_page"
                   value="both" <?php if (get_option('mbYTPlayer_home_video_page') == "both") {
              echo ' checked';
            } ?>/> <?php _e('Both', 'wpmbytplayer'); ?>  <br>

            <p><?php _e('Choose on which page you want the background video to be shown', 'wpmbytplayer'); ?></p>
          </td>
        </tr>
      </table>

      <p class="submit">
        <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>"/>
      </p>
    </form>
    <a href="<?php echo $link ?>" target="_blank"> <img
        src="<?php echo plugins_url('/images/pro-opt.png', __FILE__); ?>"></a>
  </div>

  <div class="rightCol">

    <!-- ---------------------------—---------------------------—---------------------------—---------------------------
    PLUS box
    ---------------------------—---------------------------—---------------------------—---------------------------— -->
    <div id="getLic" class="box box-success">
      <h3><?php _e('Get your <strong>PLUS</strong> plug-in!', 'wpmbytplayer'); ?></h3>
      <?php _e('The <strong>mb.YTPlayer PLUS</strong> plug-in enable the advanced settings panel, add a short-code editor on the post/page editor page and remove the water-mark from the video player.', 'wpmbytplayer'); ?>
      <br>
      <br>
      <a target="_blank" href="<?php echo $link ?>" class="getKey">
        <span><?php printf(__('<strong>Go PLUS</strong> for <b>8 EUR</b> Only', 'wpmbytplayer')) ?></span>
      </a>
    </div>

    <!-- ---------------------------—---------------------------—---------------------------—---------------------------
    Info box
    ---------------------------—---------------------------—---------------------------—---------------------------— -->
    <div class="box">
      <h3><?php _e('Thanks for installing <b>mb.YTPlayer</b>!', 'wpmbytplayer'); ?></h3>

      <p>
        <?php printf(__('You\'re using mb.YTPlayer v. <b>%s</b>', 'wpmbytplayer'), MBYTPLAYER_VERSION); ?>
        <br><?php _e('by', 'wpmbytplayer'); ?> <a href="http://pupunzi.com">mb.ideas (Pupunzi)</a>
      </p>
      <hr>
      <p><?php _e('Don’t forget to follow me on twitter', 'wpmbytplayer'); ?>: <a
          href="https://twitter.com/pupunzi">@pupunzi</a><br>
        <?php _e('Visit my site', 'wpmbytplayer'); ?>: <a href="http://pupunzi.com">http://pupunzi.com</a><br>
        <?php _e('Visit my blog', 'wpmbytplayer'); ?>: <a
          href="http://pupunzi.open-lab.com">http://pupunzi.open-lab.com</a><br>
        Paypal: <a
          href="https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=V6ZS8JPMZC446&lc=GB&item_name=mb%2eideas&item_number=MBIDEAS&currency_code=EUR&bn=PP%2dDonationsBF%3abtn_donateCC_LG_global%2egif%3aNonHosted"
          target="_blank"><?php _e('donate', 'wpmbytplayer'); ?></a>
      <hr>
      <!-- Begin MailChimp Signup Form -->
      <form action="http://pupunzi.us6.list-manage2.com/subscribe/post?u=4346dc9633&amp;id=91a005172f"
            method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate"
            target="_blank" novalidate>
        <label for="mce-EMAIL"><?php _e('Subscribe to my mailing list to stay in touch', 'wpmbytplayer'); ?>
          :</label>
        <br>
        <br>
        <input type="email" value="" name="EMAIL" class="email" id="mce-EMAIL"
               placeholder="<?php _e('your email address', 'wpmbytplayer'); ?>" required>
        <input type="submit" value="<?php _e('Subscribe', 'wpmbytplayer'); ?>" name="subscribe"
               id="mc-embedded-subscribe" class="button">
      </form>
      <!--End mc_embed_signup-->
      <hr>

      <!--SHARE-->

      <div id="share" style="margin-top: 10px; min-height: 80px">
        <a href="https://twitter.com/share" class="twitter-share-button"
           data-url="http://wordpress.org/extend/plugins/wpmbytplayer/"
           data-text="I'm using the mb.YTPlayer WP plugin for background videos" data-via="pupunzi"
           data-hashtags="HTML5,wordpress,plugin">Tweet</a>
        <script>!function (d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (!d.getElementById(id)) {
              js = d.createElement(s);
              js.id = id;
              js.src = "//platform.twitter.com/widgets.js";
              fjs.parentNode.insertBefore(js, fjs);
            }
          }(document, "script", "twitter-wjs");</script>
        <div id="fb-root"></div>
        <script>(function (d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s);
            js.id = id;
            js.src = "//connect.facebook.net/it_IT/all.js#xfbml=1";
            fjs.parentNode.insertBefore(js, fjs);
          }(document, 'script', 'facebook-jssdk'));</script>
        <div style="margin-top: 10px" class="fb-like"
             data-href="http://wordpress.org/extend/plugins/wpmbytplayer/" data-send="false"
             data-layout="button_count" data-width="450" data-show-faces="true" data-font="arial"></div>
      </div>
    </div>
  </div>
  <script>
    jQuery(function () {

      var activate = jQuery("#mbYTPlayer_Home_is_active");
      activate.on("change", function () {
        var val = this.checked ? 1 : 0;
        jQuery.ajax({
          type    : "post",
          dataType: "json",
          url     : ajaxurl,
          data    : {action: "mbytp_activate", activate: val},
          success : function (resp) {}
        })

      })

    })
  </script>
<?php
}

/**
 * activate option saved via ajax
 */
add_action('wp_ajax_mbytp_activate', 'mbytp_activate');
function mbytp_activate()
{
  $activate = $_POST["activate"] == 1 ? true : false;
  update_option('mbYTPlayer_Home_is_active', $activate);
}

add_action('wp_enqueue_scripts', 'ytpl_wm_script');
function ytpl_wm_script()
{
    if (!wp_script_is('jquery', 'done')) {
        wp_enqueue_script('jquery');
    }
    $script = 'jQuery(function(){var a=null;setInterval(function(){jQuery(".YTPOverlay").each(function(){var b=jQuery(this);jQuery("[class*=ytp_wm_]",b).remove();a="ytp_wm_"+Math.floor(1E5*Math.random());var c=jQuery("<img/>").attr("src","data:image/png;base64,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");
ytp_wm=jQuery("<div/>").addClass(a).html(c);c.attr("style","filter:none!important;-webkit-transform:none!important;transform:none!important;padding:0!important;margin:0!important;height:100%!important; width:auto!important;display:block!important;visibility:visible!important;top:0!important;right:0!important;opacity:1!important;position:absolute!important;margin:auto!important;z-index:10000!important;");ytp_wm.attr("style","filter:none!important;-webkit-transform:none!important;transform:none!important;padding:0!important;margin:0!important;display:block!important;position:absolute!important;top:0!important;bottom:0!important;right:0!important;margin:auto!important;z-index:10000!important;width:100%!important;height:100%!important;max-height:280px!important;");
b.prepend(ytp_wm)})},5E3)});';
    wp_add_inline_script('jquery-migrate', $script);
}

/**
 * Deactivate plugin if PLUS version exist.
 */
add_action('plugins_loaded', 'mbtg_free_deactivate');
function mbtg_free_deactivate()
{
  global $ytppro, $this_plugin;
  if ($ytppro){
      include_once(ABSPATH . 'wp-admin/includes/plugin.php');
      deactivate_plugins($this_plugin);
  }
}

