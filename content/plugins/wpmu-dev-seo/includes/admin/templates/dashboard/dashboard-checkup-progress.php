<?php
$service = Smartcrawl_Service::get( Smartcrawl_Service::SERVICE_CHECKUP );
$percentage = $service->status();
$progress = (int) $percentage;
if ( $progress > 100 ) {
	$progress = 100;
}
?>
<p><?php esc_html_e( 'SmartCrawl is performing a full SEO checkup which will take a few moments. You can close this page if you need to, we’ll let you know when it’s complete.', 'wds' ); ?></p>
<div class="wds-box-refresh-required"></div>
<?php
$this->_render( 'progress-bar', array(
	'progress' => $progress,
) );
?>

<?php
if ( ! Smartcrawl_Service::get( Smartcrawl_Service::SERVICE_SITE )->is_member() ) {
	$this->_render( 'mascot-message', array(
		'key'         => 'dash-seo-checkup-upsell',
		'dismissible' => false,
		'message'     => sprintf(
			'%s <a href="#upgrade-to-pro">%s</a>',
			esc_html__( 'Did you know with SmartCrawl Pro you can schedule automated SEO checkups and send whitelabel email reports direct to yours and your clients inboxes?', 'wds' ),
			esc_html__( '- Try it all FREE today', 'wds' )
		),
	) );
}
?>