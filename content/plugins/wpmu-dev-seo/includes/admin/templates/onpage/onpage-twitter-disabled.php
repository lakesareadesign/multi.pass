<?php
$message = esc_html__( 'Twitter Cards are globally disabled.', 'wds' );
if ( smartcrawl_subsite_setting_page_enabled( 'wds_social' ) ) {
	$message = sprintf(
		esc_html__( '%1$s You can enable them %2$s.', 'wds' ),
		$message,
		sprintf(
			'<a href="%s">%s</a>',
			Smartcrawl_Settings_Admin::admin_url( Smartcrawl_Settings::TAB_SOCIAL ),
			esc_html__( 'here', 'wds' )
		)
	);
}

$this->_render( 'notice', array(
	'class'   => 'wds-notice-info',
	'message' => $message,
) );