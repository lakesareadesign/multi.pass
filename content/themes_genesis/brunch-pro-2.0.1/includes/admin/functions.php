<?php
/**
 * Admin functions.
 *
 * @package    BrunchPro\Admin\Functions
 * @subpackage Genesis
 * @author     Robert Neu
 * @copyright  Copyright (c) 2016, Shay Bocks
 * @license    GPL-2.0+
 * @link       http://www.shaybocks.com/brunch-pro/
 * @since      1.0.0
 */

defined( 'ABSPATH' ) || exit;

add_action( 'tgmpa_register',        'brunch_pro_register_required_plugins' );
add_action( 'admin_head-post.php',   'brunch_pro_remove_widgeted_editor' );
add_action( 'admin_enqueue_scripts', 'brunch_pro_load_admin_styles' );

/**
 * Register the required plugins for this theme.
 *
 * This function is hooked into tgmpa_init, which is fired within the
 * TGM_Plugin_Activation class constructor.
 *
 * @since  1.0.0
 * @access public
 * @uses   tgmpa()
 * @return void
 */
function brunch_pro_register_required_plugins() {
	$plugins = array(
		array(
			'name'      => 'Genesis eNews Extended',
			'slug'      => 'genesis-enews-extended',
			'required'  => false,
		),
		array(
			'name'      => 'Simple Social Icons',
			'slug'      => 'simple-social-icons',
			'required'  => false,
		),
		array(
			'name'      => 'Simmer',
			'slug'      => 'simmer',
			'required'  => false,
		),
		array(
			'name'      => 'WP Featherlight',
			'slug'      => 'wp-featherlight',
			'required'  => false,
		),
	);
	$config = array(
		'id'           => 'brunch-pro',
		'default_path' => '',
		'menu'         => 'tgmpa-install-plugins',
		'has_notices'  => true,
		'dismissable'  => true,
		'dismiss_msg'  => '',
		'is_automatic' => true,
		'message'      => '',
		'strings'      => array(
			'page_title'                      => __( 'Install Required Plugins', 'brunch-pro' ),
			'menu_title'                      => __( 'Install Plugins', 'brunch-pro' ),
			'installing'                      => __( 'Installing Plugin: %s', 'brunch-pro' ), // %s = plugin name.
			'oops'                            => __( 'Something went wrong with the plugin API.', 'brunch-pro' ),
			'notice_can_install_required'     => _n_noop( 'Brunch Pro requires the following plugin: %1$s.', 'Brunch Pro requires the following plugins: %1$s.', 'brunch-pro' ), // %1$s = plugin name(s).
			'notice_can_install_recommended'  => _n_noop( 'Brunch Pro recommends the following plugin: %1$s.', 'Brunch Pro recommends the following plugins: %1$s.', 'brunch-pro' ), // %1$s = plugin name(s).
			'notice_cannot_install'           => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'brunch-pro' ), // %1$s = plugin name(s).
			'notice_can_activate_required'    => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'brunch-pro' ), // %1$s = plugin name(s).
			'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'brunch-pro' ), // %1$s = plugin name(s).
			'notice_cannot_activate'          => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'brunch-pro' ), // %1$s = plugin name(s).
			'notice_ask_to_update'            => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'brunch-pro' ), // %1$s = plugin name(s).
			'notice_cannot_update'            => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'brunch-pro' ), // %1$s = plugin name(s).
			'install_link'                    => _n_noop( 'Install Plugin Now', 'Install Plugins Now', 'brunch-pro' ),
			'activate_link'                   => _n_noop( 'Activate Plugin Now', 'Activate Plugins now', 'brunch-pro' ),
			'return'                          => __( 'Return to Required Plugins Installer', 'brunch-pro' ),
			'plugin_activated'                => __( 'Plugin activated successfully.', 'brunch-pro' ),
			'complete'                        => __( 'All plugins installed and activated successfully. %s', 'brunch-pro' ), // %s = dashboard link.
			'nag_type'                        => 'updated', // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
		),
	);

	tgmpa( $plugins, $config );
}

/**
 * Enqueue Genesis admin styles.
 *
 * @since  1.0.0
 * @access public
 * @uses   CHILD_THEME_VERSION
 * @return void
 */
function brunch_pro_load_admin_styles() {
	wp_enqueue_style(
		'brunch-pro-admin',
		brunch_pro_get_css_uri( 'admin.css' ),
		array(),
		CHILD_THEME_VERSION
	);
}

/**
 * Perform a check to see whether or not a widgeted page template is being used.
 *
 * @since  1.0.0
 * @access public
 * @param  array $templates a list of widgeted templates to check for.
 * @return bool
 */
function brunch_pro_using_widgeted_template( $templates = array() ) {
	if ( ! isset( $_REQUEST['post'] ) ) {
		return false;
	}

	if ( empty( $templates ) ) {
		$templates[] = 'templates/page-recipes.php';
	}

	foreach ( (array) $templates as $template ) {
		if ( get_page_template_slug( absint( $_REQUEST['post'] ) ) === $template ) {
			return true;
		}
	}

	return false;
}

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
