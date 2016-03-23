<?php

//* Add JS to allow elements to be faux anchors
add_action( 'wp_footer', 'whitespace_script_clickable' );
function whitespace_script_clickable() {

	echo '<script type="text/javascript">jQuery(document).ready(function($){$(".content .entry").click(function(){window.location = $(this).find(".entry-title a").attr("href");});});</script>';

}

//* Relocate entry image
remove_action( 'genesis_entry_content', 'genesis_do_post_image', 8 );
add_action( 'genesis_entry_header', 'genesis_do_post_image', 1 );

//* Run the default Genesis loop
genesis();
