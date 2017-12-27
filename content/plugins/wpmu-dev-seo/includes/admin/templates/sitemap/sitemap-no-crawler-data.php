<?php
	$action_url = esc_url(add_query_arg('run-checkup', 'yes')) . '#tab_url_crawler';

	$this->_render('disabled-component-inner', array(
		'content'         => sprintf(
			'%s<br/>%s',
			__("Have SmartCrawl check for broken URLs, 404s, multiple redirections and other harmful", 'wds'),
			__("issues that can reduce your ability to rank in search engines.", 'wds')
		),
		'image'           => 'url-crawler-disabled.png',
		'button_text'     => __('Begin Crawl', 'wds'),
		'button_url'      => $action_url,
		'premium_feature' => true
	));
?>