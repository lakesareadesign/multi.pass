<?php
/**
 * Admin metaboxes.
 *
 * @package   FoodiePro\Functions\Admin
 * @copyright Copyright (c) 2018, Feast Design Co.
 * @license   GPL-2.0+
 * @since     3.1.0
 */

defined( 'WPINC' ) || die;

/**
 * Perform a check to see whether or not a widgeted page template is being used.
 *
 * @since  1.0.0
 * @param  array $templates an array of widgeted templates to check for.
 * @return bool
 */
function foodie_pro_using_widgeted_template( $templates = array() ) {
	if ( ! isset( $_REQUEST['post'] ) ) {
		return false;
	}

	$post = wp_unslash( $_REQUEST['post'] );

	if ( empty( $templates ) ) {
		$templates[] = 'recipes.php';
	}

	foreach ( (array) $templates as $template ) {
		if ( get_page_template_slug( $post ) === $template ) {
			return true;
		}
	}

	return false;
}

add_action( 'admin_init', 'foodie_pro_remove_widgeted_editor' );
/**
 * Check to make sure a widgeted page template is is selected and then disable
 * the default WordPress editor.
 *
 * @since  1.0.0
 * @return void
 */
function foodie_pro_remove_widgeted_editor() {
	if ( foodie_pro_using_widgeted_template() ) {
		remove_post_type_support( 'page', 'editor' );
		add_action( 'admin_notices', 'foodie_pro_widgeted_admin_notice' );
	}
}

/**
 * Check to make sure a widgeted page template is is selected and then show a
 * notice about the editor being disabled.
 *
 * @since  1.0.0
 * @return void
 */
function foodie_pro_widgeted_admin_notice() {
	printf( '<div class="updated"><p>%s</p></div>',
		__( 'The normal editor is disabled because you\'re using a widgeted page template. You need to <a href="widgets.php">use widgets</a> to edit this page.', 'foodiepro' )
	);
}
