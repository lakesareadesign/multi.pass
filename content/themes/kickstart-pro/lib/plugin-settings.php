<?php
/**
 * Kickstart Pro
 *
 * @author  Lean Themes
 * @license GPL-2.0+
 * @link    http://demo.leanthemes.co/kickstart/
 */

/**
 * Genesis Title Toggle
 *
 */

add_action( 'init', 'kickstart_title_toggle_post_formats' );
/**
 * Make Genesis Title Toggle work with a theme that uses Post Formats
 *
 * @link http://wordpress.org/support/topic/plugin-genesis-title-toggle-title-toggle-title-remains
 */
function kickstart_title_toggle_post_formats() {
	// Only run if Genesis Title Toggle is installed
	if( !class_exists( 'BE_Title_Toggle' ) ) {
		return;
	}
	$toggle = new BE_Title_Toggle;
	add_action( 'genesis_before_entry', array( $toggle, 'title_toggle' ), 20 );
}

/**
 * Testimonials by WooThemes
 *
 */

add_filter( 'woothemes_testimonials_item_template', 'kickstart_testimonials_item_template', 10, 2 );
/**
 * Change the order of Testimonials by WooThemes widget output
 *
 */
function kickstart_testimonials_item_template( $tpl, $args ){
	// Only run if Testimonials by WooThemes is installed
	if( !class_exists( 'Woothemes_Testimonials' ) ) {
		return;
	}

	return '<div id="quote-%%ID%%" class="%%CLASS%%" itemprop="review" itemscope itemtype="http://schema.org/Review">%%AVATAR%%<blockquote class="testimonials-text" itemprop="reviewBody">%%TEXT%%</blockquote>%%AUTHOR%%</div>';
}

add_filter( 'woothemes_testimonials_content', 'kickstart_testimonials_content' );
/**
 * Show tags, break paragraphs in Testimonials by WooThemes widget output
 *
 */
function kickstart_testimonials_content( $content ){

	// Only run if Testimonials by WooThemes is installed
	if( !class_exists( 'Woothemes_Testimonials' ) ) {
		return;
	}

	$content = apply_filters( 'the_content', get_the_content() );
	$content = str_replace( ']]>', ']]&gt;', $content );

    return $content;
}
