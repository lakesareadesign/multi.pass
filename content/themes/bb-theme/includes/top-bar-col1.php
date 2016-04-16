<?php

if($layout != 'none') {
	
	if($layout == '1-col') {
		echo '<div class="col-md-12 text-center clearfix">';
	}
	else {
		echo '<div class="col-md-6 col-sm-6 text-left clearfix">';
	}
	
	do_action( 'fl_top_bar_col1_open' );

	if($col_layout == 'social' || $col_layout == 'text-social' || $col_layout == 'menu-social') {
		self::social_icons(false);
	}
	if($col_layout == 'text' || $col_layout == 'text-social') {
		echo '<div class="fl-page-bar-text fl-page-bar-text-1">' . do_shortcode( $col_text ) . '</div>';
	}
	if($col_layout == 'menu' || $col_layout == 'menu-social') {
		wp_nav_menu(array(
			'theme_location' => 'bar',
			'items_wrap' => '<ul id="%1$s" class="fl-page-bar-nav nav navbar-nav %2$s">%3$s</ul>',
			'container' => false,
			'fallback_cb' => 'FLTheme::nav_menu_fallback'
		));
	}
	
	do_action( 'fl_top_bar_col1_close' );

	echo '</div>';
}