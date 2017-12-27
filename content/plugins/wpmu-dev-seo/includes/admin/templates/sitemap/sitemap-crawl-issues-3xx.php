<?php
	$type = empty($type) ? '' : $type;
	$report = empty($report) ? null : $report;
	$open = empty($open) ? false : $open;

	$this->_render('sitemap/sitemap-crawl-issues-group', array(
		'type'         => $type,
		'report'       => $report,
		'open'         => $open,
		'title'        => esc_html__('%s URLs have multiple redirections', 'wds'),
		'description'  => esc_html__('Some of your URLs have multiple redirections. In the options menu you can List occurrences to see where these links can be found, and also set up and 301 redirects to a newer version of these pages.', 'wds'),
		'header_items' => array(
			sprintf('<th>%s</th>', esc_html__('URLs resulting in errors', 'wds')),
			sprintf('<th>%s</th>', esc_html__('Error Code', 'wds')),
			sprintf('<th colspan="2">%s</th>', esc_html__('Occurrences', 'wds')),
		)
	));
?>