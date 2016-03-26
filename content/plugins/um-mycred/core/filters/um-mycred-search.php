<?php

add_filter( 'um_modify_sortby_parameter', 'um_mycred_sortby_points', 100, 2 );
function um_mycred_sortby_points( $query_args, $sortby ) {
	if ( $sortby == 'most_mycred_points' || $sortby = 'least_mycred_points' ) {
		$query_args['orderby']  = 'meta_value_num';
		$query_args['order']    = $sortby == 'most_mycred_points' ? 'asc' : 'desc';
		$query_args['meta_key'] = 'mycred_default';
	}
	$query_args['meta_query']['relation'] = 'OR';

	return $query_args;
}
