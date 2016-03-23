<?php
/*
Plugin Name: Youtube Videos
Plugin URI: http://www.wovenland.com
Description: Shows the latest Youtube video of a specified user.
Version: 1.3
Author: David Hechler
Author URI: http://www.wovenland.com
*/
function add_video_wmode_transparent($html, $url, $attr) {
   if (strpos($html, "<embed src=" ) !== false) {
    	$html = str_replace('</param><embed', '</param><param name="wmode" value="opaque"></param><embed wmode="opaque" ', $html);
   		return $html;
   } else {
        return $html;
   }
}
add_filter('embed_oembed_html', 'add_video_wmode_transparent', 10, 3);

function fetch_my_youtube_vids(){
  $youtubefeed = simplexml_load_file("http://gdata.youtube.com/feeds/api/users/" . get_option('myyt_username') . "/uploads?orderby=updated");
  	if(!empty($youtubefeed)){
    $i = 0;
   foreach($youtubefeed->entry as $video){
     	$content = '<table width="120px" cellpadding="2px" cellspacing="2px">';
echo '<div class="media-video">';
$code = $video->link->attributes()->href;
if(get_option('myyt_hd')){
$code = str_replace('&feature=youtube_gdata', '&hd=1', $code);
} else {
$code = str_replace('&feature=youtube_gdata', '', $code);
}
$width = get_option('myyt_width');
$height = get_option('myyt_height');
if(isset($width) && isset($height)){
$embed_code = wp_oembed_get($code, array('width'=>$width, 'height'=>$height, 'hd'=>1));
} else { 
$embed_code = wp_oembed_get($code, array('width'=>400, 'height'=>225, 'hd'=>1));
}
echo($embed_code);
echo '</div>';
$i++;
if ($i == get_option('myyt_display_many')){
break;
}
$content .= "</td></tr>\n";
} 
}else{
		$content .= "<tr>\n";
		$content .= "<td>YouTube Feed not found! Please try again later</td>\n";
		$content .= "</tr>\n";
	}
	$content .= '</table>';
	return $content; // Displays the YouTube video feed.
}
/* Add [youtube_videos] to your post or page to display your videos. */
if(function_exists('fetch_my_youtube_vids')){
	/* Only works if plugin is active. */
	add_shortcode('youtube_videos', 'fetch_my_youtube_vids');
}

/* Runs when plugin is activated */
register_activation_hook(__FILE__,'my_youtube_vids_install'); 

/* Runs on plugin deactivation*/
register_deactivation_hook( __FILE__, 'my_youtube_vids_remove' );

function my_youtube_vids_install(){
	/* Creates new database field */
	add_option("myyt_display_many", '1', '', 'yes');
	add_option("myyt_display_thumb", 'yes', '', 'yes');
	add_option("myyt_display_dateadded", 'yes', '', 'yes');
	add_option("myyt_enable_hd", 'no', '', 'yes');
}

function my_youtube_vids_remove(){
	/* Deletes the database field */
	delete_option('myyt_username');
	delete_option('myyt_display_many');
	delete_option('myyt_display_thumb');
	delete_option('myyt_display_dateadded');
	delete_option('myyt_enable_hd');
}

if(is_admin()){
	function my_youtube_vids_menu(){
		add_options_page('YouTube Videos', 'YouTube Videos', 'manage_options', __FILE__, 'my_youtube_vids_settings');
	}
	add_action('admin_menu', 'my_youtube_vids_menu');
}

function my_youtube_vids_settings(){
	$myyt_username = get_option('myyt_username');
	$myyt_width = get_option('myyt_width');
	$myyt_height = get_option('myyt_height');
	$display_many_yt = get_option('myyt_display_many');
	$thumbnail = get_option('myyt_display_thumb');
	$dateuploaded = get_option('myyt_display_dateadded');
	$myyt_orderby = get_option('myyt_orderby');
	$myyt_hd = get_option('myyt_hd');
?>
<div class="wrap">
<div id="icon-options-general" class="icon32"><br></div>
<h2>My YouTube Videos</h2>
<form method="post" action="options.php">
<?php wp_nonce_field('update-options'); ?>
<table class="form-table">
<tr valign="top">
<th scope="row">Username</th>
	<td><input type="text" name="myyt_username" value="<?php echo $myyt_username; ?>" /></td>
</tr> 
<tr valign="top">
<th scope="row">Display How Many?</th>
<td>
<select name="myyt_display_many" size="1">
<?php
for($show=1; $show<=20; $show++){
	echo '<option value="'.$show.'"';
	if($display_many_yt == $show){ echo ' selected="selected"'; }
	echo '>'.$show.'</option>';
}
?>
</select>
</td>
</tr> 
<tr valign="top">
<th scope="row">Video Width</th>
	<td><input type="text" name="myyt_width" value="<?php echo $myyt_width; ?>" /></td>
</tr> 
<tr valign="top">
<th scope="row">Video Height</th>
	<td><input type="text" name="myyt_height" value="<?php echo $myyt_height; ?>" /></td>
</tr> 
<tr valign="top">
<th scope="row">HD (if available. This is an experimental option. May not work.)</th>
	<td><input type="checkbox" name="myyt_hd" value="1" <?php if($myyt_hd){ echo 'checked="checked"'; } ?> /></td>
</tr> 
</tr> 
</table>
<input type="hidden" name="action" value="update" />
<input type="hidden" name="page_options" value="myyt_username, myyt_display_many, myyt_width, myyt_height, myyt_hd, myyt_display_thumb, myyt_display_dateadded, myyt_orderby, myyt_enable_hd" />
<p class="submit"><input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" /></p>
</form>
<h3>Preview</h3>
<?php echo fetch_my_youtube_vids(); ?>
</div>
<?php
}

/* Widget Area */
      add_action("widgets_init", array('Youtube_videos', 'register'));
register_activation_hook( __FILE__, array('Youtube_videos', 'activate'));
register_deactivation_hook( __FILE__, array('Youtube_videos', 'deactivate'));
        add_shortcode("youtube_videos", "widget");

class Youtube_videos {
  function activate(){
    $data = array( 'num_videos' => 1 ,'youtube_video_width' => 220 ,'youtube_video_height' => 156 ,'widget_title' => 'Youtube Videos');
    if ( !get_option('Youtube_videos')){
      add_option('Youtube_videos' , $data);
    } else {
      update_option('Youtube_videos' , $data);
    }
  }
  function deactivate(){
    delete_option('Youtube_videos');
  }
 function control(){
  $data = get_option('Youtube_videos');
  ?>
  <p><label>Title: <br /><input name="Youtube_videos_option5"
type="text" value="<?php echo $data['widget_title']; ?>" /></label></p>
  <p><label>Videos to display: <br /><input name="Youtube_videos_option2"
type="text" value="<?php echo $data['num_videos']; ?>" /></label></p>
<p><label>Video Width: <br /><input name="Youtube_videos_option3"
type="text" value="<?php echo $data['youtube_video_width']; ?>" /></label></p>
<p><label>Video Height: <br /><input name="Youtube_videos_option4"
type="text" value="<?php echo $data['youtube_video_height']; ?>" /></label></p>
  <?php
   if (isset($_POST['Youtube_videos_option2'])){
    $data['username'] = attribute_escape($_POST['Youtube_videos_option1']);
    $data['num_videos'] = attribute_escape($_POST['Youtube_videos_option2']);
    $data['youtube_video_width'] = attribute_escape($_POST['Youtube_videos_option3']);
    $data['youtube_video_height'] = attribute_escape($_POST['Youtube_videos_option4']);
    $data['widget_title'] = attribute_escape($_POST['Youtube_videos_option5']);
    update_option('Youtube_videos' , $data);
  }
}

  function widget($args, $content=null){
  $data = get_option('Youtube_videos');
    if (get_option('myyt_username')){

    $youtubefeed = simplexml_load_file("http://gdata.youtube.com/feeds/api/users/" . get_option('myyt_username') . "/uploads?orderby=updated");
    echo $args['before_widget'];
    if (isset($data['widget_title'])){
    echo $args['before_title'] . $data['widget_title'] . $args['after_title'];
    } else {
    }
    $i = 0;
    
   foreach($youtubefeed->entry as $video){
echo '<div class="media-video">';
$code = $video->link->attributes()->href;
$code = str_replace('&feature=youtube_gdata', '', $code);
$embed_code = wp_oembed_get($code, array('width'=>$data['youtube_video_width'], 'height'=>$data['youtube_video_height'], 'allowfullscreen'=>'false'));
echo($embed_code);
echo '</div>';
$i++;
if ($i == $data['num_videos']){
break;
}
}
} else {
echo 'There is no username set. Please set a Youtube user in the backend.';
}

    echo $args['after_widget'];
  }
  
  function register(){
    register_sidebar_widget('Youtube Videos', array('Youtube_videos', 'widget'));
    register_widget_control('Youtube Videos', array('Youtube_videos', 'control'));
  }
}

?>
