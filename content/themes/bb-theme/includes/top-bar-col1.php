<?php

if ( 'none' != $layout ) {

	if ( '1-col' == $layout ) {
		echo '<div class="col-md-12 text-center clearfix">';
	} else {
		echo '<div class="col-md-6 col-sm-6 text-left clearfix">';
	}

	do_action( 'fl_top_bar_col1_open' );

	if ( 'social' == $col_layout || 'text-social' == $col_layout || 'menu-social' == $col_layout ) {
		self::social_icons( false );
	}
	if ( 'text' == $col_layout || 'text-social' == $col_layout ) {
		echo '<div class="fl-page-bar-text fl-page-bar-text-1">' . do_shortcode( $col_text ) . '</div>';
	}
	if ( 'menu' == $col_layout || 'menu-social' == $col_layout ) {
		wp_nav_menu(array(
			'theme_location' => 'bar',
			'items_wrap' => '<ul id="%1$s" class="fl-page-bar-nav nav navbar-nav %2$s">%3$s</ul>',
			'container' => false,
			'fallback_cb' => 'FLTheme::nav_menu_fallback',
		));
	}

	do_action( 'fl_top_bar_col1_close' );

	echo '</div>';
}
