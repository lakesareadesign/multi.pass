<?php
	$engines = empty( $engines ) ? array() : $engines;
?>

<?php
	$this->_render('toggle-group', array(
		'label'       => __( 'Include images', 'wds' ),
		'description' => __( 'If your posts contain imagery you would like others to be able to search, this setting will help Google Images index them correctly.', 'wds' ),
		'items'       => array(
			'sitemap-images' => array(
				'label'       => __( 'Include image items with the sitemap', 'wds' ),
				'description' => __( 'Note: When uploading attachments to posts, be sure to add titles and captions that clearly describe your images.', 'wds' ),
				'value'       => '1',
			),
		),
	));

	$this->_render('toggle-group', array(
		'label'       => __( 'Auto-notify search engines', 'wds' ),
		'description' => __( 'Instead of waiting for search engines to crawl your website you can automatically submit your sitemap whenever it changes.', 'wds' ),
		'separator'   => true,
		'items'       => $engines,
	));

	$this->_render('toggle-group', array(
		'label'       => __( 'Style sitemap', 'wds' ),
		'description' => __( 'Adds some nice styling to your sitemap.', 'wds' ),
		'separator'   => true,
		'items'       => array(
			'sitemap-stylesheet' => array(
				'label'       => __( 'Include stylesheet with sitemap', 'wds' ),
				'description' => __( 'Note: This doesn’t affect your SEO and is purely visual.', 'wds' ),
				'value'       => '1',
			),
		),
	));
?>

<?php $automatic_updates_disabled = ! empty( $_view['options']['sitemap-disable-automatic-regeneration'] ); ?>
<div class="wds-toggleable wds-disable-updates <?php echo $automatic_updates_disabled ? '' : 'inactive'; ?>">
	<?php
		$this->_render('toggle-group', array(
			'label'       => __( 'Automatic sitemap updates', 'wds' ),
			'description' => __( 'Choose whether or not you want SmartCrawl to update your Sitemap automatically when you publish new pages, posts, post types or taxonomies.', 'wds' ),
			'separator'   => true,
			'items'       => array(
				'sitemap-disable-automatic-regeneration' => array(
					'label'            => __( 'Automatically update my sitemap', 'wds' ),
					'inverted'         => true,
					'html_description' => sprintf(
						'<div class="wds-toggleable-inside wds-notice wds-notice-warning"><p>%s</p></div>',
						__( 'Your sitemap isn’t being updated automatically. Click Save Settings below to regenerate your sitemap.', 'wds' )
					),
				),
			),
		));
	?>
</div>