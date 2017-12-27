<?php
	$post = empty($post) ? null : $post;
	$robots_noindex_value = empty($robots_noindex_value) ? false : $robots_noindex_value;
	$robots_nofollow_value = empty($robots_nofollow_value) ? false : $robots_nofollow_value;
	$advanced_value = empty($advanced_value) ? array() : $advanced_value;
	$advanced_options = empty($advanced_options) ? array() : $advanced_options;
	$sitemap_priority_options = empty($sitemap_priority_options) ? array() : $sitemap_priority_options;
	$all_options = WDS_Settings::get_options();
	$og_setting_enabled = (bool)wds_get_array_value($all_options, 'og-enable');
	$og_post_type_enabled = (bool)wds_get_array_value($all_options, 'og-active-' . get_post_type($post));
	$twitter_setting_enabled = (bool)wds_get_array_value($all_options, 'twitter-card-enable');
	$show_social_tab = ($og_setting_enabled && $og_post_type_enabled) || $twitter_setting_enabled;

	$tabs['wds_seo'] = esc_html__('SEO', 'wds') . '<span class="wds-issues"><span></span></span>';
	$tabs['wds_readability'] = esc_html__('Readability', 'wds') . '<span class="wds-issues"><span></span></span>';
	if ($show_social_tab) {
		$tabs['wds_social'] = esc_html__('Social', 'wds');
	}
	$tabs['wds_advanced'] = esc_html__('Advanced', 'wds');

	if (!WDS_Settings::get_setting('analysis-readability')) unset($tabs['wds_readability']);
?>
<div class="wpmud wds-metabox">
	<div id="container" class="wds-horizontal-tabs">
		<?php
			$this->_render('metabox/horizontal-tab-nav', array('tabs' => $tabs));
		?>
		<?php
			$this->_render('metabox/horizontal-tab', array(
				'tab_id'           => 'wds_seo',
				'is_active'        => true,
				'content_template' => 'metabox/metabox-tab-seo',
				'content_args'     => array(
					'post' => $post
				)
			));
		?>

		<?php
		if (WDS_Settings::get_setting('analysis-readability')) {
			$this->_render('metabox/horizontal-tab', array(
				'tab_id'           => 'wds_readability',
				'content_template' => 'metabox/metabox-tab-readability',
				'content_args'     => array(
					'post' => $post
				)
			));
		}
		?>

		<?php
			if ($show_social_tab) {
				$this->_render('metabox/horizontal-tab', array(
					'tab_id'           => 'wds_social',
					'content_template' => 'metabox/metabox-tab-social',
					'content_args'     => array(
						'post'                    => $post,
						'og_setting_enabled'      => $og_setting_enabled,
						'og_post_type_enabled'    => $og_post_type_enabled,
						'twitter_setting_enabled' => $twitter_setting_enabled
					)
				));
			}
		?>

		<?php
			$this->_render('metabox/horizontal-tab', array(
				'tab_id'           => 'wds_advanced',
				'content_template' => 'metabox/metabox-tab-advanced',
				'content_args'     => array(
					'robots_noindex_value'     => $robots_noindex_value,
					'robots_nofollow_value'    => $robots_nofollow_value,
					'advanced_value'           => $advanced_value,
					'advanced_options'         => $advanced_options,
					'sitemap_priority_options' => $sitemap_priority_options
				)
			));
		?>
	</div>
</div>