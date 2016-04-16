<?php

if($layout == '2-cols') {

	echo '<div class="col-md-6 col-sm-6 text-right clearfix">';
	
	do_action( 'fl_footer_col2_open' );

	if($col_layout == 'text' || $col_layout == 'social-text') {
		echo '<div class="fl-page-footer-text fl-page-footer-text-2">' . do_shortcode( $col_text ) . '</div>';
	}
	if($col_layout == 'social' || $col_layout == 'social-text') {
		self::social_icons();
	}
	if($col_layout == 'menu') {
		wp_nav_menu(array(
			'theme_location' => 'footer',
			'items_wrap' => '<ul id="%1$s" class="fl-page-footer-nav nav navbar-nav %2$s">%3$s</ul>',
			'container' => false,
			'fallback_cb' => 'FLTheme::nav_menu_fallback'
		));
	}
	
	do_action( 'fl_footer_col2_close' );

	echo '</div>';
}