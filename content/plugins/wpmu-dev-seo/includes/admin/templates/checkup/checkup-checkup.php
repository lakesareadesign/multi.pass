<?php
$service = Smartcrawl_Service::get( Smartcrawl_Service::SERVICE_CHECKUP );
?>

<div class="wds-report">
	<?php
	if ( $service->in_progress() ) {
		$this->_render( 'checkup/checkup-checkup-running' );
	} else {
		$this->_render( 'checkup/checkup-checkup-results' );
	}
	?>
</div>