<div class='wrap'>

	<?php $this->_render('settings-message-top'); ?>

	<h1><?php esc_html_e( 'SmartCrawl Wizard: Moz' , 'wds' ); ?></h1>

	<?php
	$wds_options = WDS_Settings::get_options();
	if ( ! wds_is_allowed_tab( $_view['slug'] ) ) {
		printf( __( "Your network admin prevented access to '%s', please move onto next step.", 'wds' ), __( 'Moz' , 'wds' ) );
	} else if ( 'settings' === $_view['name'] || ( ! empty( $wds_options[ $_view['name'] ] ) ) ) {

		<?php // echo $additional; ?>

	<?php

	} else {
		printf( __( "You've chosen not to set up '%s', please move onto next step.", 'wds' ), __( 'Moz' , 'wds' ) );
	}

	?>
</div>