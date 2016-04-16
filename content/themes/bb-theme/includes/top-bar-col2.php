<?php

if($layout == '2-cols') {

	echo '<div class="col-md-6 col-sm-6 text-right clearfix">';
	
	do_action( 'fl_top_bar_col2_open' );

	if($col_layout == 'text' || $col_layout == 'text-social') {
		echo '<div class="fl-page-bar-text fl-page-bar-text-2">' . do_shortcode( $col_text ) . '</div>';
	}
	if($col_layout == 'menu' || $col_layout == 'menu-social') {
		wp_nav_menu(array(
			'theme_location' => 'bar',
			'items_wrap' => '<ul id="%1$s" class="fl-page-bar-nav nav navbar-nav %2$s">%3$s</ul>',
			'container' => false,
			'fallback_cb' => 'FLTheme::nav_menu_fallback'
		));
	}
	if($col_layout == 'social' || $col_layout == 'text-social' || $col_layout == 'menu-social') {
		self::social_icons(false);
	}
	
	do_action( 'fl_top_bar_col2_close' );

	echo '</div>';
}