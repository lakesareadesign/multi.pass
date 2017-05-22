<?php
/**
 * Slush Pro.
 *
 * This file adds the single portfolio template to the Slush Pro Theme.
 *
 * @package Slush_Pro
 * @author  ZigzagPress
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/slush/
 */

// Adds single portfolio navigation.
add_action( 'genesis_after_header', 'zp_portfolio_single_nav' );
function zp_portfolio_single_nav() {

	global $post;
	$output = '';

	$output .= '<div class="single_portfolio_nav">';

	$prev_post = get_previous_post();
	if ( !empty( $prev_post ) ) {
		$output .= '<div class="single_nav_prev"><a href="' . get_permalink( $prev_post->ID ) . '" class="btn btn-lg btn-default">Previous Post</a></div>';
	}

	$next_post = get_next_post();
	if ( !empty( $next_post )){
		$output .= '<div class="single_nav_next inline"><a href="' . get_permalink( $next_post->ID ) . '" class="btn btn-lg btn-default">Next Post</a></div>';
	}
	$output .= '</div>';

	echo $output;

}

// Removes default sidebar and the sidebar created by Genesis Simple Sidebars.
add_action( 'get_header', 'zp_portfolio_sidebar' );
function zp_portfolio_sidebar() {

	if ( is_singular( 'portfolio' ) ) {
		remove_action( 'genesis_sidebar', 'genesis_do_sidebar' );
		remove_action( 'genesis_sidebar', 'ss_do_sidebar' );
		remove_action( 'genesis_sidebar_alt', 'ss_do_sidebar_alt' );
		add_action( 'genesis_sidebar', 'zp_get_portfolio_sidebar' );
	}

}

// Adds portfolio sidebar.
function zp_get_portfolio_sidebar() {

	genesis_structural_wrap( 'sidebar' );
	do_action( 'genesis_before_sidebar_widget_area' );
	dynamic_sidebar( 'portfolio-sidebar' );
	do_action( 'genesis_after_sidebar_widget_area' );
	genesis_structural_wrap( 'sidebar', 'close' );

}

// Adds Related Portfolio.
add_action( 'genesis_after_content', 'zp_display_related_portfolio' );
function zp_display_related_portfolio() {

	$items = genesis_get_option( 'zp_related_items', ZP_SETTINGS_FIELD );
	$columns = genesis_get_option( 'zp_related_columns', ZP_SETTINGS_FIELD );
	
	if ( genesis_get_option( 'zp_enable_related', ZP_SETTINGS_FIELD ) ) {
		echo '<div class="zp_related_container"><div class="container"><div class="row">' . zp_related_portfolio( $items, $columns ) . '</div></div></div>';
	}

}

// Removes the default Genesis loop.
remove_action( 	'genesis_loop', 'genesis_do_loop'  );

// Adds the portfolio loop.
add_action( 'genesis_loop', 'zp_single_portfolio_page'  );
function zp_single_portfolio_page() {

	global $post;

	$output = '';

	// Retrieves post meta values.
	$button_label = get_post_meta( $post->ID, 'button_label', true );
	$button_link = get_post_meta( $post->ID, 'button_link', true );

	$output .= '<div class="col-md-12 col-sm-12 col-xs-12 pull-left single_portfolio_main">';
	$output .= '<article ' . genesis_attr( 'entry' ) . '>';

	if ( have_posts() ) : while ( have_posts() ) : the_post();

		$image = get_the_post_thumbnail( $post->ID  , 'full', array( 'class'=> 'img-responsive', 'alt' => get_the_title(), 'title' => get_the_title() ) );
		$image_url = wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) );

		// Gets the type of link.
		$link_type = get_post_meta( $post->ID, 'portfolio_link', true );

		// Gets video link.
		$video_link = get_post_meta( $post->ID, 'single_video_link', true );

		// Gets portfolio attached images ids.
		$portfolio_images = get_post_meta( $post->ID, 'portfolio_images', true );

		// Gets portfolio image display type.
		$display_type = get_post_meta( $post->ID, 'display_type', true );

		$output .= '<div ' . genesis_attr( 'entry-content' ) . '>';

		// If lightbox.
		if ( $link_type == 'lightbox' ) {
			$output .= '<div class="single_portfolio_container single_portfolio_image gallery-image"><a href="' . $image_url . '" ><span class="portfolio_icon_class"><i class="fa fa-search"></i></span>' . $image . '</a></div>';
		} elseif ( $link_type == 'external_link' ) {
		// If external link.
			$external_link = get_post_meta( $post->ID, 'zp_external_link', true );
			$output .= '<div class="single_portfolio_container single_portfolio_image"><a href="' . $external_link . '" target="_blank" ><span class="portfolio_icon_class portfolio_icon_link"><i class="fa fa-link"></i></span>' . $image . '</a></div>';
		} else {
		// If single page or empty.
			if ( $video_link ) {
				$output .= '<div class="single_portfolio_container single_portfolio_video fitvids"><iframe src="' . zp_return_desired_link( $video_link ) . '" width="710" height="400" ></iframe></div>';
			} elseif ( $portfolio_images ) {
				$output .= '<div class="single_portfolio_container single_portfolio_slide">';
				$output .= zp_gallery( $post->ID, 'full', 'portfolio_images', true );
				$output .= '</div>';
			} else {
				$output .= '<div class="single_portfolio_container single_portfolio_image gallery-image"><a href="' . $image_url . '"><span class="portfolio_icon_class"><i class="fa fa-search"></i></span>' . $image . '</a></div>';
			}
		}

		// Adds title.
		$output .= '<div class="single_portfolio_title col-md-12 col-sm-12 col-xs-12 col-sm-12 col-xs-12">';
		$output .= '<h1>' . get_the_title() . '</h1>';
		$output .= '</div>';

		// Adds content.
		if( get_the_content() ) {
			$output .= '<div class="single_portfolio_container single_portfolio_content">';
			$output .= '<div class="widget single_portfolio_section single_portfolio_meta col-md-12 col-sm-12 col-xs-12 col-sm-12 col-xs-12">';
			$output .= apply_filters( 'the_content', get_the_content() );
			$output .= '</div>';
		}

		// Adds like span.
		$like_counter = ( get_post_meta( $post->ID, 'zp_like' ,true ) > 0 ) ? get_post_meta( $post->ID, 'zp_like' ,true ): 0;
		$like = '<span class="zp_like_holder ' . $post->ID . '"><i class="fa fa-heart ' . $post->ID . '"></i><em class="like_counter">(' . $like_counter . ')</em></span>';

		if( $button_link ) {
			$output .= '<div class="widget single_portfolio_section single_portfolio_button col-md-12 col-sm-12 col-xs-12"><a class="btn btn-default " href="' . $button_link . '">' . $button_label . '</a>' . $like . '</div>';
		}

		$output .= '</div>';

	endwhile; endif;
	$output .= '</article>';

	// Adds related portfolio.
	$output .= '<div class="single_portfolio_related">';
	$output .= zp_related_portfolio( -1, 2 );
	$output .= '</div>';

	$output .= '</div>';
	echo $output;

}

// Runs the Genesis loop.
genesis();
