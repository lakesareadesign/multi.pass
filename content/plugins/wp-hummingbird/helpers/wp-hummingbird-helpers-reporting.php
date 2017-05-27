<?php
/**
 * @param $arr
 * @param $keys
 * @param null $default
 *
 * @return null
 */
function wphb_getValue( $arr, $keys, $default = null ) {
	if ( is_string( $keys ) ) {
		$keys = explode( '.', $keys );
	}

	$curr = $arr;
	foreach ( $keys as $key ) {
		if ( isset( $curr[ $key ] ) ) {
			$curr = $curr[ $key ];
		} else {
			return $default;
		}
	}

	return $curr;
}

/**
 * @param $key
 * @param null $default
 *
 * @return null
 */
function wphb_retrieve_post( $key, $default = null ) {
	return wphb_getValue( $_POST, $key, $default );
}

/**
 * @param $timestamp
 *
 * @return false|int
 */
function wphb_local_to_utc( $timestring ) {
	$tz = get_option( 'timezone_string' );
	if ( ! $tz ) {
		$gmt_offset = get_option( 'gmt_offset' );
		if ( $gmt_offset == 0 ) {
			return strtotime( $timestring );
		}
		$tz = wphb_get_timezone_string( $gmt_offset );
	}

	if ( ! $tz ) {
		$tz = 'UTC';
	}
	$timezone = new DateTimeZone( $tz );
	$time     = new DateTime( $timestring, $timezone );

	return $time->getTimestamp();
}

/**
 * @param $timezone
 *
 * @return false|string
 */
function wphb_get_timezone_string( $timezone ) {
	$timezone = explode( '.', $timezone );
	if ( isset( $timezone[1] ) ) {
		$timezone[1] = 30;
	} else {
		$timezone[1] = '00';
	}
	$offset = implode( ':', $timezone );
	list( $hours, $minutes ) = explode( ':', $offset );
	$seconds = $hours * 60 * 60 + $minutes * 60;
	$tz      = timezone_name_from_abbr( '', $seconds, 1 );
	if ( $tz === false ) {
		$tz = timezone_name_from_abbr( '', $seconds, 0 );
	}

	return $tz;
}

/**
 * Get avatar URL.
 *
 * @param $get_avatar string User email.
 * @return mixed
 * @since 1.4.5
 */
function wphb_get_avatar_url( $get_avatar ) {
	preg_match( "/src='(.*?)'/i", $get_avatar, $matches );

	return $matches[1];
}

/**
 * Get display name
 *
 * @param $id int User ID.
 * @return null|string
 * @since 1.4.5
 */
function wphb_get_display_name( $id ) {
	$user = get_user_by( 'id', $id );
	if ( ! is_object( $user ) ) {
		return null;
	}
	if ( ! empty( $user->user_nicename ) ) {
		return $user->user_nicename;
	} else {
		return $user->user_firstname . ' ' . $user->user_lastname;
	}
}