<?php

class WDS_Metabox {

	public function __construct() {

		// WPSC integration
		add_action('wpsc_edit_product', array($this, 'rebuild_sitemap'));
		add_action('wpsc_rate_product', array($this, 'rebuild_sitemap'));

		add_action('admin_menu', array($this, 'wds_create_meta_box'));

		add_action('save_post', array($this, 'wds_save_postdata'));
		add_filter('attachment_fields_to_save', array($this, 'wds_save_attachment_postdata'));

		//add_filter('manage_page_posts_columns', array(&$this, 'wds_page_title_column_heading'), 10, 1);
		add_filter('manage_pages_columns', array($this, 'wds_page_title_column_heading'), 10, 1);
		//add_filter('manage_post_posts_columns', array(&$this, 'wds_page_title_column_heading'), 10, 1);
		add_filter('manage_posts_columns', array($this, 'wds_page_title_column_heading'), 10, 1);

		add_action('manage_pages_custom_column', array($this, 'wds_page_title_column_content'), 10, 2);
		add_action('manage_posts_custom_column', array($this, 'wds_page_title_column_content'), 10, 2);

		add_action('quick_edit_custom_box', array($this, 'wds_quick_edit_dispatch'), 10, 2);
		add_action('admin_footer-edit.php', array($this, 'wds_quick_edit_javascript'));
		add_action('wp_ajax_wds_get_meta_fields', array($this, 'json_wds_postmeta'));
		add_action('wp_ajax_wds_metabox_update', array($this, 'wds_metabox_live_update'));

		add_action('admin_print_scripts-post.php', array($this, 'js_load_scripts'));
		add_action('admin_print_scripts-post-new.php', array($this, 'js_load_scripts'));

	}

	public function js_load_scripts () {
		wp_enqueue_script('wds_metabox_counter', WDS_PLUGIN_URL . '/js/wds-metabox-counter.js');
		wp_localize_script('wds_metabox_counter', 'l10nWdsCounters', array(
			"title_length" => __("{TOTAL_LEFT} characters left", 'wds'),
			"title_longer" => __("Over {MAX_COUNT} characters ({CURRENT_COUNT})", 'wds'),
			"main_title_longer" => __("Over {MAX_COUNT} characters ({CURRENT_COUNT}) - make sure your SEO title is shorter", 'wds'),

			'title_limit' => WDS_TITLE_LENGTH_CHAR_COUNT_LIMIT,
			'metad_limit' => WDS_METADESC_LENGTH_CHAR_COUNT_LIMIT,
			'main_title_warning' => !(defined('WDS_MAIN_TITLE_LENGTH_WARNING_HIDE') && WDS_MAIN_TITLE_LENGTH_WARNING_HIDE),
		));
		wp_enqueue_script('wds_metabox_onpage', WDS_PLUGIN_URL . '/js/wds-metabox.js');

		WDS_Settings_Admin::register_global_admin_scripts();
		wp_enqueue_script('wds-admin-opengraph');

		wp_enqueue_style('wds-admin-opengraph');
	}


	public function wds_meta_boxes() {
		global $post;

		$ri_value  = (int)wds_get_value('meta-robots-noindex');
		$rf_value  = (int)wds_get_value('meta-robots-nofollow');
		$adv_value = explode(',', wds_get_value('meta-robots-adv'));
		$advanced  = array(
			"noodp"     => __( 'NO ODP (Block Open Directory Project description of the page)' , 'wds'),
			"noydir"    => __( 'NO YDIR (Don\'t display the Yahoo! Directory titles and abstracts)' , 'wds'),
			"noarchive" => __( 'No Archive' , 'wds'),
			"nosnippet" => __( 'No Snippet' , 'wds'),
		);
		$options   = array(
			""    => __( 'Automatic prioritization' , 'wds'),
			"1"   => __( '1 - Highest priority' , 'wds'),
			"0.9" => "0.9",
			"0.8" => "0.8 - " . __( 'High priority (root pages default)' , 'wds'),
			"0.7" => "0.7",
			"0.6" => "0.6 - " . __( 'Secondary priority (subpages default)' , 'wds'),
			"0.5" => "0.5 - " . __( 'Medium priority' , 'wds'),
			"0.4" => "0.4",
			"0.3" => "0.3",
			"0.2" => "0.2",
			"0.1" => "0.1 - " . __( 'Lowest priority' , 'wds'),
		);

		include WDS_PLUGIN_DIR . 'admin/templates/metabox.php';
	}

	public function wds_create_meta_box() {
		$show = user_can_see_seo_metabox();
		if ( function_exists('add_meta_box') ) {
			$metabox_title = is_multisite() ? __( 'SmartCrawl' , 'wds') : 'SmartCrawl'; // Show branding for singular installs.
			foreach (get_post_types() as $posttype) {
				if ($show) add_meta_box( 'wds-wds-meta-box', $metabox_title, array(&$this, 'wds_meta_boxes'), $posttype, 'normal', 'high' );
			}
		}
	}

	public function wds_save_attachment_postdata ($data) {
		if (empty($_POST) || empty($data['post_ID']) || !is_numeric($data['post_ID'])) return $data;
		$this->wds_save_postdata($data['post_ID']);
		return $data;
	}

	public function wds_save_postdata( $post_id ) {
		if ($post_id == null || empty($_POST)) return;

		global $post;
		if (empty($post)) $post = get_post($post_id);

		// Determine posted type
		$post_type_rq = !empty($_POST['post_type']) ? $_POST['post_type'] : false;
		if ('page' === $post_type_rq && !current_user_can('edit_page', $post_id)) return $post_id;
		else if (!current_user_can( 'edit_post', $post_id )) return $post_id;

		if (!empty($_POST['wds-opengraph'])) {
			$input = stripslashes_deep($_POST['wds-opengraph']);

			$result = array();
			if (!empty($input['title'])) $result['title'] = wp_strip_all_tags($input['title']);
			if (!empty($input['description'])) $result['description'] = wp_strip_all_tags($input['description']);
			if (!empty($input['og-images']) && is_array($input['og-images'])) {
				$result['images'] = array();
				foreach ($input['og-images'] as $img) {
					$img = esc_url($img);
					$result['images'][] = $img;
				}
			}

			if (!empty($result)) {
				update_post_meta($post_id, '_wds_opengraph', $result);
			}
			unset($_POST['wds-opengraph']);
		}

		foreach ($_POST as $key=>$value) {
			if (!preg_match('/^wds_/', $key)) continue;

			$id = "_{$key}";
			$data = $value;
			if (is_array($value)) $data = join(',', $value);

			if ($data) update_post_meta($post_id, $id, $data);
			else delete_post_meta($post_id, $id);
		}

		do_action('wds_saved_postdata');
	}

	public function rebuild_sitemap() {
		require_once WDS_PLUGIN_DIR.'/tools/sitemaps.php';

	}

	public function wds_page_title_column_heading( $columns ) {
		return array_merge(
			array_slice( $columns, 0, 2 ),
			array( 'page-title' => __( 'Title Tag' , 'wds') ),
			array_slice($columns, 2, 6),
			array( 'page-meta-robots' => __( 'Robots Meta' , 'wds') )
		);
	}

	public function wds_page_title_column_content( $column_name, $id ) {
		if ( $column_name == 'page-title' ) {
			echo $this->wds_page_title($id);

			// Show any 301 redirects
			$redirect = wds_get_value('redirect', $id);
			if (!empty($redirect)) {
				$href = esc_url($redirect);
				$link = "<a href='{$href}' target='_blank'>{$href}</a>";
				echo '<br /><em>' . sprintf(esc_html(__('Redirects to %s', 'wds')), $link) . '</em>';
			}
		}

		if ( $column_name == 'page-meta-robots' ) {
			$meta_robots_arr = array(
				(wds_get_value( 'meta-robots-noindex', $id ) ? 'noindex' : 'index'),
				(wds_get_value( 'meta-robots-nofollow', $id ) ? 'nofollow' : 'follow')
			);
			$meta_robots = join(',', $meta_robots_arr);
			if ( empty($meta_robots) )
				$meta_robots = 'index,follow';
			echo ucwords( str_replace( ',', ', ', $meta_robots ) );

			// Show additional robots data
			$advanced = array_filter(array_map('trim', explode(',', wds_get_value('meta-robots-adv', $id))));
			if (!empty($advanced) && 'none' !== $advanced) {
				$adv_map = array(
					'noodp' => __('No ODP', 'wds'),
					'noydir' => __('No YDIR', 'wds'),
					'noarchive' => __('No Archive', 'wds'),
					'nosnippet' => __('No Snippet', 'wds'),
				);
				$additional = array();
				foreach ($advanced as $key) {
					if (!empty($adv_map[$key])) $additional[] = $adv_map[$key];
				}
				if (!empty($additional)) echo '<br /><small>' . esc_html(join(', ', $additional)) . '</small>';
			}
		}
	}

	public function wds_page_title( $postid ) {
		$post = get_post($postid);
		$fixed_title = wds_get_value('title', $post->ID);
		if ($fixed_title) {
			return $fixed_title;
		} else {
			global $wds_options;
			if (!empty($wds_options['title-'.$post->post_type]))
				return wds_replace_vars($wds_options['title-'.$post->post_type], (array) $post );
			else
				return '';
		}
	}

	public function wds_quick_edit_dispatch ($column, $type) {
		switch ($column) {
			case "page-title": return $this->_title_qe_box($type);
			case "page-meta-robots": return $this->_robots_qe_box();
		}
	}

	public function wds_quick_edit_javascript () {
		include WDS_PLUGIN_DIR . 'admin/templates/quick-edit-javascript.php';

	}

	public function json_wds_postmeta () {
		$id = (int)$_POST['id'];
		die(json_encode(array(
			"title" => wds_get_value('title', $id),
			"description" => wds_get_value('metadesc', $id),
		)));
	}

	public function wds_metabox_live_update () {
		global $wds_options;

		$id = (int)$_POST['id'];
		$post = get_post( $id );

		$post_data = sanitize_post( $_POST['post'] );

		$description = $title = '';

		/* Merge live post data with currently saved post data */
		$post->post_author = $post_data['post_author'];
		$post->post_title = $post_data['post_title'];
		$post->post_excerpt = $post_data['excerpt'];
		$post->post_content = $post_data['content'];
		$post->post_type = $post_data['post_type'];

		$title = wds_get_seo_title( $post );
		$description = wds_get_seo_desc( $post );

		wp_send_json(array(
			"title" => $title,
			"description" => $description,
		));

		die();
	}

	private function _title_qe_box ($t) {
		global $post;

		include WDS_PLUGIN_DIR . 'admin/templates/quick-edit-title.php';

	}

	private function _robots_qe_box () {
		global $post;

		include WDS_PLUGIN_DIR . 'admin/templates/quick-edit-robots.php';

	}

}

$wds_metabox = new WDS_Metabox();