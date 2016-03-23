<?php
//if uninstall not called from WordPress exit
if ( !defined( 'WP_UNINSTALL_PLUGIN' ) )
	exit();

include_once( 'helpers/wp-hummingbird-helpers-core.php' );

wphb_uninstall();