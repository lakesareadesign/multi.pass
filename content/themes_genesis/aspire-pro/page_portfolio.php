<?php

// Template Name: Portfolio

// Adds Page Title
add_action( 'genesis_before_content', 'genesis_do_post_title' );

//Adds Page Content
add_action( 'genesis_before_loop', 'aspire_do_portfolio_content' );
function aspire_do_portfolio_content() {
    echo '<div class="entry-content entry-portfolio" itemprop="text">' . get_post()->post_content . '</div>';
}
		
// Force layout to full-width-content
add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );

// Adds "portfolio" and "gallery clearfix" classes to every post
add_filter( 'post_class', 'portfolio_post_class' );
function portfolio_post_class( $classes ) {
    $classes[] = 'portfolio';
    $classes[] = 'gallery clearfix';
    return $classes;
}

// Custom Read More link
add_filter( 'excerpt_more', 'portfolio_read_more_link' );
add_filter( 'get_the_content_more_link', 'portfolio_read_more_link' );
add_filter( 'the_content_more_link', 'portfolio_read_more_link' );
	function portfolio_read_more_link() {
		return '<a class="button more-link" href="' . get_permalink() . '" rel="nofollow">Read More</a>';
}

// Remove post info and meta info
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );
remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );

/**
 * Adds Featured Image and links it to the Post
 *
 * This is the default post image which links to the post it represents when clicked.
 *
 * @author Wes Straham
 * @since 1.0.0
 */
add_action( 'genesis_entry_header', 'aspire_portfolio_do_post_image' ); 
function aspire_portfolio_do_post_image() { 
	$img = genesis_get_image( array( 'format' => 'html', 'size' => 'portfolio-thumbnail', 'attr' => array( 'class' => 'alignnone post-image' ) ) ); printf( '<a href="%s" title="%s">%s</a>', get_permalink(), the_title_attribute('echo=0'), $img ); 
}	

// Move title below post image
remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
add_action( 'genesis_entry_content', 'genesis_do_post_title', 9 );

// Remove default content for this Page Template
remove_action( 'genesis_entry_content', 'genesis_do_post_image', 8 );
remove_action( 'genesis_entry_content', 'genesis_do_post_content' );

// Add Content for the Portfolio posts in this Page Template
add_action( 'genesis_entry_content', 'aspire_portfolio_do_post_content' );
function aspire_portfolio_do_post_content() {
    
    if ( genesis_get_option( 'aspire_portfolio_content' ) == 'excerpts' ) {
        the_excerpt();
    
    } else {
        if ( genesis_get_option( 'aspire_portfolio_content_archive_limit' ) )
            the_content_limit( (int)genesis_get_option( 'aspire_portfolio_content_archive_limit' ), __( 'Read More', 'aspire' ) );
        else
            the_content(__( 'Read More', 'aspire' ));
    }
} 

// Outputs clearing div after every 2 posts
add_action( 'genesis_after_entry', 'portfolio_after_post_2' );
function portfolio_after_post_2() {
    
	global $wp_query;
    
    // Assumes 2 posts per row
	$end_row = ( $wp_query->current_post + 1 ) / 2;
        
	if ( ctype_digit( (string) $end_row ) ) {
		echo '<div class="portfolio-clear"></div>';	
	}
}

// Outputs clearing div after every 3 posts
add_action( 'genesis_after_entry', 'portfolio_after_post_3' );
function portfolio_after_post_3() {
    
	global $wp_query;
    
    // Assumes 3 posts per row
	$end_row = ( $wp_query->current_post + 1 ) / 3;
        
	if ( ctype_digit( (string) $end_row ) ) {
		echo '<div class="portfolio-clear-2"></div>';	
	}
}

// Remove standard loop
remove_action( 'genesis_loop', 'genesis_do_loop' );

// Add custom loop
add_action( 'genesis_loop', 'portfolio_loop' );
function portfolio_loop() {
    $paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
    
    $include = genesis_get_option( 'aspire_portfolio_cat' );
    $exclude = genesis_get_option( 'aspire_portfolio_cat_exclude' ) ? explode(',', str_replace(' ', '', genesis_get_option( 'aspire_portfolio_cat_exclude' ))) : '';
        
    $cf = genesis_get_custom_field( 'query_args' ); // Easter Egg
    $args = array( 'cat' => $include, 'category__not_in' => $exclude, 'showposts' => genesis_get_option( 'aspire_portfolio_cat_num' ), 'paged' => $paged);
    $query_args = wp_parse_args($cf, $args);
    
    genesis_custom_loop( $query_args );
}

?> <body <?php body_class('portfolio'); ?>> 

<?php
	
genesis();		