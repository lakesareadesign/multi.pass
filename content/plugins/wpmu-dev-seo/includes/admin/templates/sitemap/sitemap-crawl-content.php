<?php
	/**
	 * @var Smartcrawl_Seo_Service $service
	 */
	$open_type = empty( $open_type ) ? null : $open_type;
	$this->_render('url-crawl-master', array(
		'ready_template'    => 'sitemap/sitemap-crawl-results',
		'ready_args'        => array(
			'open_type' => $open_type,
		),
		'no_data_template'  => 'sitemap/sitemap-no-crawler-data',
		'no_data_args'      => array(),
		'progress_template' => 'sitemap/sitemap-progress-bar',
	));