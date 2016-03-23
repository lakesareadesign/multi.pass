<?php

//* Register widget areas
genesis_register_sidebar( array(
	'id'          	=> 'home-top-slider',
	'name'        	=> __( 'Home - Top Slider', 'glam' ),
	'description' 	=> __( 'This is the top section of the home page.', 'glam' ),
) );
genesis_register_sidebar( array(
	'id'          	=> 'home-flexible',
	'name'        	=> __( 'Home - Flexible', 'glam' ),
	'description' 	=> __( 'This is the bottom section of the home page.', 'glam' ),
) );
genesis_register_sidebar( array(
	'id'          	=> 'category-index',
	'name'        	=> __( 'Category Index', 'glam' ),
	'description' 	=> __( 'This is the category index for the category index page template.', 'glam' ),
) );
genesis_register_sidebar( array(
	'id'          	=> 'nav-social-menu',
	'name'        	=> __( 'Nav Social Menu', 'glam' ),
	'description' 	=> __( 'This is the nav social menu section.', 'glam' ),
) );
genesis_register_sidebar( array(
	'id' 			=> 'between-posts-area',
	'name' 			=> __( 'Between Posts Area', 'glam' ),
	'description' 	=> __( 'This widget area is shows after every fourth blog post to display an ad.', 'glam' ),
) );
genesis_register_sidebar( array(
	'id'			=> 'cta-widget',
	'name'			=> __( 'CTA Widget', 'glam' ),
	'description'	=> __( 'This is the widget area above the header', 'glam' ),
) );

