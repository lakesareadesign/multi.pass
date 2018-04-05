<?php
	$message = sprintf(
		esc_html__('Twitter Cards are globally disabled. You can enable them %s.', 'wds'),
		sprintf(
			'<a href="%s">%s</a>',
			Smartcrawl_Settings_Admin::admin_url(Smartcrawl_Settings::TAB_SOCIAL),
			esc_html__('here', 'wds')
		)
	);

	$this->_render('notice', array(
		'class'   => 'wds-notice-info',
		'message' => $message,
	));