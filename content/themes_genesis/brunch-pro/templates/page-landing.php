<?php
/**
 * Template Name: Landing
 *
 * @package    BrunchPro\Templates
 * @subpackage Genesis
 * @author     Robert Neu
 * @copyright  Copyright (c) 2016, Shay Bocks
 * @license    GPL-2.0+
 * @link       http://www.shaybocks.com/brunch-pro/
 * @since      1.0.0
 */

add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );

remove_action( 'genesis_before', 'brunch_pro_before_header' );

remove_action( 'genesis_header',        'genesis_header_markup_open', 5 );
remove_action( 'genesis_header',        'genesis_do_header' );
remove_action( 'genesis_header',        'genesis_header_markup_close', 15 );
remove_action( 'genesis_after_header',  'genesis_do_nav' );
remove_action( 'genesis_after_header',  'genesis_do_subnav' );
remove_action( 'genesis_before_loop',   'genesis_do_breadcrumbs' );
remove_action( 'genesis_before_footer', 'genesis_footer_widget_areas' );
remove_action( 'genesis_footer',        'genesis_footer_markup_open', 5 );
remove_action( 'genesis_footer',        'genesis_do_footer' );
remove_action( 'genesis_footer',        'genesis_footer_markup_close', 15 );

genesis();
