<?php
///////////////REMOVE HELP CONTEXT MENU
if (get_option('flatty_remove_help_menu') == true) {
	add_action('admin_head', 'flatty_remove_help_menu');
	function flatty_remove_help_menu(){
		echo '<style> #contextual-help-link-wrap {display:none;}</style>';
	}
}

///////////////REMOVE METABOXES
function remove_meta_boxes() {
	if (get_option('flatty_wordpress_posts_remove_format') == true) {
		remove_meta_box( 'formatdiv', 'post', 'normal' );
	}
	if (get_option('flatty_wordpress_posts_remove_trackbacks') == true) {
		remove_meta_box( 'trackbacksdiv', 'post', 'normal' );
	}
	if (get_option('flatty_wordpress_posts_remove_commentsstatus') == true) {
		remove_meta_box( 'commentstatusdiv', 'post', 'normal' );
	}
	if (get_option('flatty_wordpress_posts_remove_commentslist') == true) {
		remove_meta_box( 'commentsdiv', 'post', 'normal' );
	}
	if (get_option('flatty_wordpress_posts_remove_customfields') == true) {
		remove_meta_box( 'postcustom', 'post', 'normal' );
	}
	if (get_option('flatty_wordpress_posts_remove_revisions') == true) {
		remove_meta_box( 'revisionsdiv', 'post', 'normal' );
	}
	if (get_option('flatty_wordpress_posts_remove_author') == true) {
		remove_meta_box( 'authordiv', 'post', 'normal' );
	}
	if (get_option('flatty_wordpress_posts_remove_slug') == true) {
		remove_meta_box( 'slugdiv', 'post', 'normal' );
	}
	if (get_option('flatty_wordpress_pages_remove_format') == true) {
		remove_meta_box( 'formatdiv', 'page', 'normal' );
	}
	if (get_option('flatty_wordpress_pages_remove_trackbacks') == true) {
		remove_meta_box( 'trackbacksdiv', 'page', 'normal' );
	}
	if (get_option('flatty_wordpress_pages_remove_commentsstatus') == true) {
		remove_meta_box( 'commentstatusdiv', 'page', 'normal' );
	}
	if (get_option('flatty_wordpress_pages_remove_commentslist') == true) {
		remove_meta_box( 'commentsdiv', 'page', 'normal' );
	}
	if (get_option('flatty_wordpress_pages_remove_customfields') == true) {
		remove_meta_box( 'postcustom', 'page', 'normal' );
	}
	if (get_option('flatty_wordpress_pages_remove_revisions') == true) {
		remove_meta_box( 'revisionsdiv', 'page', 'normal' );
	}
	if (get_option('flatty_wordpress_pages_remove_author') == true) {
		remove_meta_box( 'authordiv', 'page', 'normal' );
	}
	if (get_option('flatty_wordpress_pages_remove_slug') == true) {
		remove_meta_box( 'slugdiv', 'page', 'normal' );
	}
}

add_action( 'admin_menu', 'remove_meta_boxes' );
?>
