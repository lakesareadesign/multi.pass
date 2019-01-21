<?php

$q     = empty( $settings->address ) ? 'United Kingdom' : do_shortcode( $settings->address );
$class = 'fl-map';

if ( ! empty( $settings->height_responsive ) ) {
	$class .= ' fl-map-auto-responsive-disabled';
}

// ACF Google map passes back an iframe so we need to sanitize it.
if ( false !== strpos( $q, 'iframe' ) ) {
	$iframe = preg_replace( '#\s?style=\'.+\'#', '', $q );
} else {
	$iframe = sprintf( '<iframe src="https://www.google.com/maps/embed/v1/place?key=AIzaSyD09zQ9PNDNNy9TadMuzRV_UsPUoWKntt8&q=%s"></iframe>', urlencode( $q ) );
}

?>
<div class="<?php echo $class; ?>">
	<?php echo $iframe; ?>
</div>
