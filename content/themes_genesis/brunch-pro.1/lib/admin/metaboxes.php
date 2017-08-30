<?php
/**
 * Admin metaboxes.
 *
 * @package   BrunchPro\Functions\Admin
 * @copyright Copyright (c) 2017, Feast Design Co.
 * @license   GPL-2.0+
 * @since     2.2.0
 */

defined( 'WPINC' ) || die;

/**
 * Perform a check to see whether or not a widgeted page template is being used.
 *
 * @since  1.0.0
 * @access public
 * @param  array $templates a list of widgeted templates to check for.
 * @return bool
 */
function brunch_pro_using_widgeted_template( $templates = array() ) {
	if ( ! isset( $_REQUEST['post'] ) ) { // Input var okay.
		return false;
	}

	if ( empty( $templates ) ) {
		$templates[] = 'templates/page-recipes.php';
	}

	foreach ( (array) $templates as $template ) {
		if ( get_page_template_slug( absint( $_REQUEST['post'] ) ) === $template ) { // Input var okay.
			return true;
		}
	}

	return false;
}

add_action( 'admin_head-post.php', 'brunch_pro_remove_widgeted_editor' );
/**
 * Check to make sure a widgeted page template is is selected and then disable
 * the default WordPress editor.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function brunch_pro_remove_widgeted_editor() {
	if ( brunch_pro_using_widgeted_template() ) {
		remove_post_type_support( 'page', 'editor' );
		add_action( 'admin_notices', 'brunch_pro_widgeted_admin_notice' );
	}
}

/**
 * Check to make sure a widgeted page template is is selected and then show a
 * notice about the editor being disabled.
 *
 * @since  1.0.0
 */
function brunch_pro_widgeted_admin_notice() {
	printf( '<div class="updated"><p>%s</p></div>',
		sprintf(
			__( 'The normal editor is disabled because you&#39;re using a widgeted page template. You need to <a href="%s">use widgets</a> to edit this page.', 'brunch-pro' ),
			esc_url( admin_url( '/widgets.php' ) )
		)
	);
}

add_action( 'post_submitbox_misc_actions', 'brunch_pro_admin_meta_box_view' );
/**
 * Output the content of our metabox.
 *
 * @since  1.0.0
 * @access public
 *
 * @param WP_Post $post Post object.
 * @return void
 */
function brunch_pro_admin_meta_box_view( WP_Post $post ) {
	if ( get_page_template_slug( $post->ID ) !== 'page_blog.php' ) {
		return;
	}

	$type = get_post_type_object( $post->post_type );

	if ( ! is_object( $type ) ) {
		return;
	}

	if ( current_user_can( $type->cap->edit_post, $post->ID ) ) {
		$enable = brunch_pro_blog_page_is_grid_enabled( $post->ID );
		require_once BRUNCH_PRO_DIR . 'lib/admin/views/meta-box.php';
	}
}

/**
 * Determine if the request to save data should be allowed to proceed.
 *
 * @since  1.0.0
 * @access protected
 * @param  int $post_id Post ID.
 * @return bool Whether or not this is a valid request to save our data.
 */
function _brunch_pro_admin_meta_validate_request( $post_id ) {
	if ( 'POST' !== $_SERVER['REQUEST_METHOD'] ) { // Input var okay.
		return false;
	}

	$auto = defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE;
	$ajax = defined( 'DOING_AJAX' ) && DOING_AJAX;
	$cron = defined( 'DOING_CRON' ) && DOING_CRON;

	if ( $auto || $ajax || $cron ) {
		return false;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return false;
	}

	$nonce = 'brunch_pro_metabox_nonce';

	if ( ! isset( $_POST[ $nonce ] ) ) { // Input var okay.
		return false;
	}

	if ( ! wp_verify_nonce( sanitize_key( $_POST[ $nonce ] ), 'save_brunch_pro_metabox' ) ) { // Input var okay.
		return false;
	}

	// @link http://make.marketpress.com/multilingualpress/2014/10/how-to-disable-broken-save_post-callbacks/
	if ( is_multisite() && ms_is_switched() ) {
		return false;
	}

	return wp_unslash( $_POST ); // Input var okay.
}

add_action( 'save_post', 'brunch_pro_admin_meta_save' );
/**
 * Callback function for saving our meta box data.
 *
 * @since  1.0.0
 * @access public
 * @param  int $post_id Post ID.
 * @return bool Whether or not data has been saved.
 */
function brunch_pro_admin_meta_save( $post_id ) {
	if ( ! $valid_request = _brunch_pro_admin_meta_validate_request( $post_id ) ) {
		return false;
	}

	$value = empty( $valid_request['_brunch_pro_enable_blog_grid'] ) ? 'no' : 'yes';

	return (bool) update_post_meta( $post_id, '_brunch_pro_enable_blog_grid', $value );
}
