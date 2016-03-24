<?php

class Ytvw_YouTubeVideo_Widget extends WP_Widget {

	private $_allowed_title_tags = array(
		'h3',
		'h4',
		'h5',
		'h6',
		'div',
	);

	public static function serve () {
		add_action('widgets_init', create_function('', 'register_widget("' . __CLASS__ . '");'));
	}

	function Ytvw_YouTubeVideo_Widget () { $this->__construct(); }

	function __construct () {
		add_action('admin_print_scripts-widgets.php', array($this, 'load_admin_scripts'));
		add_action('wp_ajax_ytvw_select_channel_videos', array($this, 'json_load_channel_data'));
		add_action('wp_ajax_ytvw_save_video_selection', array($this, 'json_save_video_selection'));

		$widget_ops = array('classname' => __CLASS__, 'description' => __('Shows a YouTube video', 'ytvw'));
		parent::WP_Widget(__CLASS__, 'YouTube Video', $widget_ops);
	}

	function load_admin_scripts () {
		add_thickbox();
		wp_enqueue_script('ytvw-widget_admin', YTVW_PLUGIN_URL . '/js/widget_admin.js', array('jquery'), '1.1');
		wp_localize_script('ytvw-widget_admin', 'ytvw_l10n', array(
			'select_videos' => __('Select videos', 'ytvw'),
			'please_wait' => __('Please, wait', 'ytvw'),
			'save_selection' => __('Save Selection', 'ytvw'),
		));
	}

	function form ($instance) {
		$title = apply_filters('widget_title', $instance['title']);
		$channel = esc_attr($instance['channel']);
		$channel_link = esc_attr($instance['channel_link']);
		$video_title = esc_attr($instance['video_title']);
		$player_overlay = esc_attr($instance['player_overlay']);
		$channel_link_text = esc_attr($instance['channel_link_text']);
		$show = esc_attr($instance['show']);
		$video_title_tag = esc_attr($instance['video_title_tag']);
		$player_width = esc_attr($instance['player_width']);
		$player_height = esc_attr($instance['player_height']);
		$no_legacy = !empty($instance['no_legacy']) ? (int)$instance['no_legacy'] : false;
		$html = '';

		$show = $show ? $show : 'show_all';

		$player_width = $player_width ? $player_width : 560;
		$player_height = $player_height ? $player_height : 315;

		$key = "ytvw-{$channel}";
		$stored = get_option($key);
		$stored = is_array($stored) ? $stored : array();

		$html .= '<p>';
		$html .= '<label for="' . $this->get_field_id('title') . '">' . __('Title:', 'ytvw') . '</label>';
		$html .= '<input type="text" name="' . $this->get_field_name('title') . '" id="' . $this->get_field_id('title') . '" class="widefat" value="' . $title . '"/>';
		$html .= '</p>';

		$html .= '<p>';
		$html .= '<label for="' . $this->get_field_id('channel') . '">' . __('Username or Channel:', 'ytvw') . '</label>';
		$html .= '<input type="text" name="' . $this->get_field_name('channel') . '" id="' . $this->get_field_id('channel') . '" class="widefat" data-channel="' . $channel . '" value="' . $channel . '"/>';
		if (class_exists('SimpleXMLElement')) {
			$html .= '<br />';
			$html .= '<input type="checkbox" name="' . $this->get_field_name('no_legacy') . '" id="' . $this->get_field_id('no_legacy') . '" ' . ($no_legacy ? 'checked="checked"' : '') . ' value="1" />';
			$html .= '&nbsp;<label for="' . $this->get_field_id('no_legacy') . '">' . __('This is a Google+ connected channel', 'ytvw') . '</label>';
		}
		$html .= '</p>';

		if ($channel) {
			$html .= '<div class="ytvw-admin-videos-list">';
			$html .= '<h4>' . __('Show these Videos from the channel:', 'ytvw') . '</h4>';
			if (!empty($stored)) {
				$html .= '<ul>';
				foreach ($stored as $item) {
					$html .= '<li>' .
						"<a href='{$item['link']}' target='_blank'>{$item['title']}</a>" .
					'</li>';
				}
				$html .= '</ul>';
			}
			$html .= '<a href="#select-videos" class="ytvw-admin-videos-select button">' . __('Select videos to show', 'ytvw') . '</a>';
			$html .= '</div> <!-- class="ytvw-admin-videos-list" -->';

			$html .= '<p>';
			$html .= '<label for="' . $this->get_field_id('show_all') . '">' . __('Show:', 'ytvw') . '</label><br />';
			$html .= '<input type="radio" name="' . $this->get_field_name('show') . '" id="' . $this->get_field_id('show_all') . '" value="show_all" ' . ('show_all' == $show ? 'checked="checked"' : '') . ' />&nbsp;' .
				'<label for="' . $this->get_field_id('show_all') . '">' . __('Show all selected videos', 'ytvw') . '</label><br />'
			;
			$html .= '<input type="radio" name="' . $this->get_field_name('show') . '" id="' . $this->get_field_id('show_random') . '" value="show_random" ' . ('show_random' == $show ? 'checked="checked"' : '') . ' />&nbsp;' .
				'<label for="' . $this->get_field_id('show_random') . '">' . __('Show random video from selection', 'ytvw') . '</label><br />'
			;
			$html .= '<input type="radio" name="' . $this->get_field_name('show') . '" id="' . $this->get_field_id('show_related') . '" value="show_related" ' . ('show_related' == $show ? 'checked="checked"' : '') . ' />&nbsp;' .
				'<label for="' . $this->get_field_id('show_related') . '">' . __('Show related video from selection, fall back to random', 'ytvw') . '</label><br />'
			;
			$html .= '</p>';

			$html .= '<p>';
			$html .= '<label for="' . $this->get_field_id('video_title_tag') . '">' . __('Video title tag:', 'ytvw') . '</label> ';
			$html .= '<select name="' . $this->get_field_name('video_title_tag') . '">';
			foreach ($this->_allowed_title_tags as $sep) {
				$html .= '<option value="' . esc_attr($sep) . '" ' . selected($sep, $video_title_tag, false) . '>' . $sep . '</option>';
			}
			$html .= '</select>';
			$html .= '</p>';

			$html .= '<p>';
			$html .= '<label for="' . $this->get_field_id('player_width') . '">' .
				__('Embedded player size') . '<br />' .
				__('Width:') . '&nbsp;' .
				'<input type="text" size="2" maxlength="4" name="' . $this->get_field_name('player_width') . '" id="' . $this->get_field_id('player_width') . '" value="' . (int)$player_width . '" />' .
			'</label>';
			$html .= '<label for="' . $this->get_field_id('player_height') . '">' .
				__('Height:') . '&nbsp;' .
				'<input type="text" size="2" maxlength="4" name="' . $this->get_field_name('player_height') . '" id="' . $this->get_field_id('player_height') . '" value="' . (int)$player_height . '" />' .
			'</label>';
			$html .= '</p>';

			$html .= '<p>';
			$html .= '<input type="checkbox" name="' . $this->get_field_name('player_overlay') . '" id="' . $this->get_field_id('player_overlay') . '" value="1" ' . ($player_overlay ? 'checked="checked"' : '') . ' />' .
				'&nbsp;<label for="' . $this->get_field_id('player_overlay') . '">' . __('Show player in an overlay popup', 'ytvw') . '</label><br />'
			;
			$html .= '<input type="checkbox" name="' . $this->get_field_name('video_title') . '" id="' . $this->get_field_id('video_title') . '" value="1" ' . ($video_title ? 'checked="checked"' : '') . ' />' .
				'&nbsp;<label for="' . $this->get_field_id('video_title') . '">' . __('Show Video title', 'ytvw') . '</label><br />'
			;
			$html .= '<input type="checkbox" name="' . $this->get_field_name('channel_link') . '" id="' . $this->get_field_id('channel_link') . '" value="1" ' . ($channel_link ? 'checked="checked"' : '') . ' />' .
				'&nbsp;<label for="' . $this->get_field_id('channel_link') . '">' . __('Show Channel link', 'ytvw') . '</label><br />'
			;
			$html .= '' .
				'<label for="' . $this->get_field_id('channel_link_text') . '">' . __('Channel link text:', 'ytvw') . '</label><br />' .
				'<input type="text" class="widefat" name="' . $this->get_field_name('channel_link_text') . '" id="' . $this->get_field_id('channel_link_text') . '" value="' . $channel_link_text . '" />' .
			'';
			$html .= '</p>';
		} else {
			$html .= '<div class="updated below-h2"><p><em>' . __('Please, enter the channel and save settings before continuing', 'ytvw') . '</em></p></div>';
		}

		echo $html;
	}

	function update ($new_instance, $old_instance) {
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['channel'] = strip_tags($new_instance['channel']);
		$instance['show'] = strip_tags($new_instance['show']);
		$instance['channel_link'] = strip_tags($new_instance['channel_link']);
		$instance['video_title'] = strip_tags($new_instance['video_title']);
		$instance['player_overlay'] = strip_tags($new_instance['player_overlay']);
		$instance['channel_link_text'] = strip_tags($new_instance['channel_link_text']);
		$instance['no_legacy'] = strip_tags(@$new_instance['no_legacy']);
		$instance['video_title_tag'] = strip_tags(@$new_instance['video_title_tag']);
		$instance['player_width'] = strip_tags(@$new_instance['player_width']);
		$instance['player_height'] = strip_tags(@$new_instance['player_height']);

		return $instance;
	}

	function widget ($args, $instance) {
		extract($args);
		$show = esc_attr($instance['show']);
		$show = $show ? $show : 'show_all';
		$channel = esc_attr($instance['channel']);
		$channel_link = esc_attr($instance['channel_link']);
		$video_title = esc_attr($instance['video_title']);
		$player_overlay = esc_attr($instance['player_overlay']);
		$channel_link_text = esc_html($instance['channel_link_text']);
		$title = apply_filters('widget_title', $instance['title']);
		$no_legacy = !empty($instance['no_legacy']) ? (int)$instance['no_legacy'] : false;

		$key = "ytvw-{$channel}";
		$stored = get_option($key);
		$stored = is_array($stored) ? $stored : array();
		if (empty($stored)) return false;
		$output = $this->_dispatch_rendering($show, $stored, $instance);

		echo $before_widget;
		if ($title) echo $before_title . $title . $after_title;
		echo $output;
		if ($channel_link) {
			$user = $no_legacy ? 'channel' : 'user';
			$text = $channel_link_text ? $channel_link_text : __('View more', 'ytvw');
			echo "<p><a href='http://www.youtube.com/{$user}/{$channel}' target='_blank'>{$text}</a></p>";
		}
		echo $after_widget;

	}

	private function _dispatch_rendering ($show, $stored, $data) {
		switch ($show) {
			case "show_all": return $this->_render_all($stored, $data);
			case "show_random": return $this->_render_random($stored, $data);
			case "show_related": return $this->_render_related($stored, $data);
		}
	}

	private function _render_all ($stored, $data) {
		$out = '';
		$video_title = !empty($data['video_title']) ? esc_attr($data['video_title']) : false;
		foreach ($stored as $item) {
			$title = $video_title
				? $item['title']
				: false
			;
			$data['video_title'] = $title;
			$out .= "<li>" .
				$this->_render_video($item['video'], $data) .
			'</li>';
		}
		return "<ul>{$out}</ul>";
	}

	private function _render_random ($stored, $data) {
		$video_title = !empty($data['video_title']) ? esc_attr($data['video_title']) : false;
		shuffle($stored);
		$item = reset($stored);
		$title = $video_title
			? $item['title']
			: false
		;
		$data['video_title'] = $title;
		return $this->_render_video($item['video'], $data);
	}

	private function _render_related ($stored, $data) {
		global $post;
		if (empty($post->ID)) return $this->_render_random($stored, $data);

		$raw_tags = wp_get_post_tags($post->ID);
		$tags = !empty($raw_tags) ? wp_list_pluck($raw_tags, 'name') : array();
		if (empty($tags)) return $this->_render_random($stored, $data);

		$results = array();
		$video_title = !empty($data['video_title']) ? esc_attr($data['video_title']) : false;
		foreach ($stored as $item) {
			foreach ($tags as $tag) {
				$tmp = array();
				$matches = preg_match_all('/\b' . preg_quote($tag, '/') . '\b/i', $item['description'], $tmp);
				if ($matches) $results[$matches] = $item['video'];
			}
		}
		if (empty($results)) return $this->_render_random($stored, $data);
		$video = end($results);
		$title = $video_title
			? $stored[$video]['title']
			: false
		;
		$data['video_title'] = $title;
		return $this->_render_video($video, $data);
	}

	private function _render_video ($video, $data) {
		$player_overlay = !empty($data['player_overlay']) ? esc_attr($data['player_overlay']) : false;
		return $player_overlay
			? $this->_render_video_overlay($video, $data)
			: $this->_render_video_embed($video, $data)
		;
	}

	private function _render_video_overlay ($video, $data) {
		$video_title = !empty($data['video_title']) ? esc_attr($data['video_title']) : false;
		$title_tag = !empty($data['video_title_tag']) && in_array($data['video_title_tag'], $this->_allowed_title_tags) ? $data['video_title_tag'] : 'h3';
		$title = $video_title
			? "<{$title_tag}>{$video_title}</{$title_tag}>"
			: ''
		;
		$video_link = YTVW_PROTOCOL . 'www.youtube.com/watch/?v=' . $video;

		wp_enqueue_script('ytwv-widget_public', YTVW_PLUGIN_URL . '/js/widget_public.js', array('jquery'));
		wp_enqueue_style('ytwv-widget_public', YTVW_PLUGIN_URL . '/css/widget_public.css');

		return $title .
			"<a href='{$video_link}' class='ytvw-watch_video' style='display:block; width:99%' data-video='{$video}' target='_blank'>" .
				'<div class="ytvw-video_overlay" style="display:none"></div>' .
				"<img style='max-width:99%' src='http://img.youtube.com/vi/{$video}/hqdefault.jpg' />" .
				'<div class="ytvw-video-play_overlay" style="display:none"><img src="' . YTVW_PLUGIN_URL . '/css/play.png" /></div>' .
			"</a>"
		;
	}

	private function _render_video_embed ($video, $data) {
		$video_title = !empty($data['video_title']) ? esc_attr($data['video_title']) : false;
		$title_tag = !empty($data['video_title_tag']) && in_array($data['video_title_tag'], $this->_allowed_title_tags) ? $data['video_title_tag'] : 'h3';
		$title = $video_title
			? "<{$title_tag}>{$video_title}</{$title_tag}>"
			: ''
		;
		$player_width = esc_attr($data['player_width']);
		$player_width = $player_width ? $player_width : 560;

		$player_height = esc_attr($data['player_height']);
		$player_height = $player_height ? $player_height : 315;

		return $title . '<iframe width="' . $player_width . '" height="' . $player_height . '" src="' . YTVW_PROTOCOL . 'www.youtube.com/embed/' . $video . '" frameborder="0" allowfullscreen></iframe>';
	}

/* ----- Helpers ----- */

	function json_load_channel_data () {
		$method = '_get_legacy_channel_data';
		$no_legacy = !empty($_POST['no_legacy']) ? (int)$_POST['no_legacy'] : false;
		if (class_exists('SimpleXMLElement') && $no_legacy) {
			$method = '_get_channel_data';
		}
		die(json_encode(
			$this->$method()
		));
	}

	function _get_channel_data () {
		$channel = !empty($_POST['channel']) ? rawurlencode($_POST['channel']) : false;
		$response = array();
		if (!$channel) return $response;

		$key = "ytvw-{$channel}";
		$stored = get_option($key);
		$stored = is_array($stored) ? $stored : array();

		$url = "https://gdata.youtube.com/feeds/api/users/{$channel}/uploads";
		$req = wp_remote_get($url, array(
			'sslverify' => false,
		));
		if (200 != wp_remote_retrieve_response_code($req)) return $response;
		$body = wp_remote_retrieve_body($req);
		$feed = new SimpleXMLElement($body);

		if (!$feed || empty($feed->entry)) return $response;
		$namespaces = $feed->getNamespaces(true);

		foreach ($feed->entry as $item) {

			$media = $item->children($namespaces['media']);
			$thumb = $media->group->thumbnail->attributes();
			$image = $thumb['url'];
			$duration = $thumb['time'];

			//if (empty($item->content)) continue;  // breaks if no description is given
			if (empty($item->title)) continue;
			if (empty($item->published)) continue;

			$link = false;
			foreach ($item->link as $raw) {
				$attr = $raw->attributes();
				if ('alternate' != $attr['rel']) continue;
				$link = $attr['href'] . '';
				break;
			}
			if (!$link) continue;
			$video_params = array();
			$video_query = parse_url($link, PHP_URL_QUERY);
			parse_str($video_query, $video_params);
			if (empty($video_params['v'])) continue;


			$title = strip_tags($item->title);
			$description = strip_tags($item->content);
			$pubdate = strtotime(strip_tags($item->published));
			$raw_description = nl2br($item->content) . '<br /><img src="' . $image . '" /><br /><strong>' . $duration . '</strong>';

			$response[] = array(
				'link' => $link,
				'video' => $video_params['v'],
				'title' => $title,
				'description' => $description,
				'raw_description' => $raw_description,
				'pubdate' => $pubdate,
				'checked' => in_array($video_params['v'], array_keys($stored)),
			);
		}
		return $response;
	}

	function _get_legacy_channel_data () {
		$channel = !empty($_POST['channel']) ? rawurlencode($_POST['channel']) : false;
		$response = array();
		if (!$channel) return $response;

		$key = "ytvw-{$channel}";
		$stored = get_option($key);
		$stored = is_array($stored) ? $stored : array();

		$url = "http://www.youtube.com/rss/user/{$channel}/videos.rss";
		if (!function_exists('fetch_rss')) require_once(ABSPATH . WPINC . '/rss.php');
		$feed = fetch_rss($url);
		if (!$feed || empty($feed->items)) return $response;

		foreach ($feed->items as $item) {

			if (empty($item['link'])) continue;
			//if (empty($item['description'])) continue;
			if (empty($item['title'])) continue;
			if (empty($item['pubdate'])) continue;

			$video_params = array();
			$video_query = parse_url($item['link'], PHP_URL_QUERY);
			parse_str($video_query, $video_params);
			if (empty($video_params['v'])) continue;

			$title = strip_tags($item['title']);
			$description = strip_tags($item['description']);
			$pubdate = strtotime(strip_tags($item['pubdate']));

			$response[] = array(
				'link' => $item['link'],
				'video' => $video_params['v'],
				'title' => $title,
				'description' => $description,
				'raw_description' => $item['description'],
				'pubdate' => $pubdate,
				'checked' => in_array($video_params['v'], array_keys($stored)),
			);
		}
		return $response;
	}

	function json_save_video_selection () {
		$videos = !empty($_POST['videos']) ? stripslashes_deep($_POST['videos']) : false;
		$channel = !empty($_POST['channel']) ? stripslashes_deep($_POST['channel']) : false;
		if (!$videos) die(json_encode('no!'));
		if (!$channel) die(json_encode('no!'));

		$storage = array();
		foreach ($videos as $video) {
			$item = json_decode(urldecode($video), true);
			$storage[$item['video']] = $item;
		}
		$key = "ytvw-{$channel}";
		$status = update_option($key, $storage);
		die(json_encode($status));
	}
}