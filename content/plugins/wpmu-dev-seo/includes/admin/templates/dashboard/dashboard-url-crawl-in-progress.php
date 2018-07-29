<?php
$progress = empty( $progress ) ? 0 : $progress;
?>
<div class="wds-box-refresh-required"></div>
<p class="wds-small-text"><?php esc_html_e( 'SmartCrawl is performing a URL crawl, please wait…', 'wds' ); ?></p>

<?php
$this->_render( 'progress-bar', array(
	'progress' => $progress,
) );
?>