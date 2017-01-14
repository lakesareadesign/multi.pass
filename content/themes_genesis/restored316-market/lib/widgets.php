<?php

/**
 * This file adds all the widget spaces to the Market theme.
 *
 * @package      Market
 * @link         http://restored316designs.com/themes
 * @author       Lauren Gaige // Restored 316 LLC
 * @copyright    Copyright (c) 2015, Restored 316 LLC, Released 05/03/2016
 * @license      GPL-2.0+
 */

//* Register widget areas
genesis_register_sidebar( array(
	'id'            => 'home-slider-overlay',
	'name'          => __( 'Home Slider Overlay', 'market' ),
	'description'   => __( 'This widget area appears on top of the slider on homepage', 'market' ),
) );
genesis_register_sidebar( array(
	'id'          => 'front-page-1',
	'name'        => __( 'Front Page 1', 'market' ),
	'description' => __( 'This is the 1st section on the front page.', 'market' ),
) );
genesis_register_sidebar( array(
	'id'          => 'front-page-2',
	'name'        => __( 'Front Page 2', 'market' ),
	'description' => __( 'This is the 2nd section on the front page.', 'market' ),
) );
genesis_register_sidebar( array(
	'id'          => 'front-page-3',
	'name'        => __( 'Front Page 3', 'market' ),
	'description' => __( 'This is the 3rd section on the front page.', 'market' ),
) );
genesis_register_sidebar( array(
	'id'          => 'front-page-4',
	'name'        => __( 'Front Page 4', 'market' ),
	'description' => __( 'This is the 4th section on the front page.', 'market' ),
) );
genesis_register_sidebar( array(
	'id'          => 'front-page-5',
	'name'        => __( 'Front Page 5', 'market' ),
	'description' => __( 'This is the 5th section on the front page.', 'market' ),
) );
genesis_register_sidebar( array(
	'id'            => 'widget-above-content',
	'name'          => __( 'Widget Above Content', 'market' ),
	'description'   => __( 'This widget area appears on the home page and at the top of all other pages', 'market' ),
) );
genesis_register_sidebar( array(
	'id'            => 'widget-below-footer',
	'name'          => __( 'Widget Below Footer', 'market' ),
	'description'   => __( 'This widget area appears below the footer.', 'market' ),
) );
genesis_register_sidebar( array(
	'id'            => 'category-index',
	'name'          => __( 'Category Index', 'market' ),
	'description'   => __( 'This widget area that appears on the Category Index page', 'market' ),
) );
genesis_register_sidebar( array(
	'id'          	=> 'above-blog-slider',
	'name'        	=> __( 'Above Blog Slider', 'market' ),
	'description' 	=> __( 'This is the above blog slider section of the home or blog page.', 'market' ),
) );
genesis_register_sidebar( array(
	'id'          	=> 'nav-social-menu',
	'name'        	=> __( 'Nav Social Menu', 'market' ),
	'description' 	=> __( 'This is the nav social menu section.', 'market' ),
) );