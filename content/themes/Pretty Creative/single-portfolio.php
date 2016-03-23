<?php
//* The custom portfolio post type single post template
 
//* Force full width content layout
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

//* Remove the post meta function
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );

//* Remove the post info function
remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );

//* Remove author box
remove_action( 'genesis_after_entry', 'genesis_do_author_box_single', 8 );

//* Remove the comments template
remove_action( 'genesis_after_entry', 'genesis_get_comments_template' );

//* Remove the ad widget
remove_action( 'genesis_before_loop', 'adspace_before_loop' );

//* Remove the footer widgets
remove_action( 'genesis_before_footer', 'genesis_footer_widget_areas' );

genesis();
