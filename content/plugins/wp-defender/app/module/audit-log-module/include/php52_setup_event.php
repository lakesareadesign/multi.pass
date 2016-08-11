<?php
/**
 * Author: Hoang Ngo
 * For 5.2
 */

function wd_get_callable_event( $key, $hook, $class ) {
	$func_args = $hook['args'];
	foreach ( $func_args as &$val ) {
		$val = '$' . $val;
	}
	$func_args = implode( ',', $func_args );
	$func      = create_function( $func_args, '$key = "' . $key . '";
				$args = func_get_args(); $hook = ' . var_export( $hook, true ) . ';
				$class_name = "' . get_class( $class ) . '";
				$class = new $class_name();
				$class->build_log_data( $key, $args, $hook );
				' );

	return $func;
}