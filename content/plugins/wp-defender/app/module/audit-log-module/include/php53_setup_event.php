<?php
/**
 * Author: Hoang Ngo
 * for PHP 5.3 and more
 */
function wd_get_callable_event( $key, $hook, $class ) {
	$func = function () use ( $key, $hook, $class ) {
		//this is argurements of the hook
		$args = func_get_args();
		//this is hook data, defined in each events class
		$class->build_log_data( $key, $args, $hook );
	};

	return $func;
}