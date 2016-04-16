<?php

if($layout != 'none') {

	if($layout == '1-col') {
		echo '<div class="col-md-12 text-center clearfix">';
	}
	else {
		echo '<div class="col-md-6 col-sm-6 text-left clearfix">';
	}
	
	do_action( 'fl_footer_col1_open' );

	if($col_layout == 'text' || $col_layout == 'social-text') {
		if(empty($col_text)) {
			get_template_part('includes/copyright');
		}
		else {
			echo '<div class="fl-page-footer-text fl-page-footer-text-1">' . do_shortcode( $col_text ) . '</div>';
		}
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
	
	do_action( 'fl_footer_col1_close' );

	echo '</div>';
}