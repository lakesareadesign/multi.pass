<?php

/**
 * Register the required plugins for this theme.
 */
add_action( 'tgmpa_register', 'elegance_register_required_plugins' );
function elegance_register_required_plugins() {

	$plugins = array(

		array(
			'name' 				=> 'Widget Importer & Exporter',
			'slug' 				=> 'widget-importer-exporter',
			'required' 			=> false,
			'force_activation'	=> false
		),

		array(
			'name' 				=> 'Genesis eNews Extended',
			'slug' 				=> 'genesis-enews-extended',
			'required' 			=> false,
			'force_activation'	=> false
		),

		array(
			'name' 				=> 'Wordpress Importer',
			'slug' 				=> 'wordpress-importer',
			'required' 			=> false,
			'force_activation'	=> false
		),

		array(
			'name' 				=> 'Responsive WordPress Slider - Soliloquy Lite',
			'slug' 				=> 'soliloquy-lite',
			'required' 			=> false,
			'force_activation'	=> false
		),
		array(
			'name' 				=> 'Simple Social Icons',
			'slug' 				=> 'simple-social-icons',
			'required' 			=> false,
			'force_activation'	=> false
		),
		array(
			'name' 				=> 'Instagram Feed',
			'slug' 				=> 'instagram-feed',
			'required' 			=> false,
			'force_activation'	=> false
		),
		
		array(
			'name' 				=> 'Genesis Portfolio Pro',
			'slug' 				=> 'genesis-portfolio-pro',
			'required' 			=> false,
			'force_activation'	=> false
		),
		
		array(
			'name' 				=> 'Regenerate Thumbnails',
			'slug' 				=> 'regenerate-thumbnails',
			'required' 			=> false,
			'force_activation'	=> false
		),
		
		array(
			'name' 				=> 'Testimonial Rotator',
			'slug' 				=> 'testimonial-rotator',
			'required' 			=> false,
			'force_activation'	=> false
		)

	);

	/**
	 * Array of configuration settings. Amend each line as needed.
	 * If you want the default strings to be available under your own theme domain,
	 * leave the strings uncommented.
	 * Some of the strings are added into a sprintf, so see the comments at the
	 * end of each line for what each argument will be.
	 */
	$config = array(
		'id'           					  => 'elegance',                 // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' 					  => '',                      // Default absolute path to pre-packaged plugins.
		'menu'         					  => 'tgmpa-install-plugins', // Menu slug.
		'has_notices'  					  => true,                    // Show admin notices or not.
		'dismissable'  					  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  					  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' 					  => false,                   // Automatically activate plugins after installation or not.
		'message'      					  => '',                      // Message to output right before the plugins table.
		'strings'      					  => array(
		'page_title'                      => __( 'Install Required Plugins', 'elegance' ),
		'menu_title'                      => __( 'Install Plugins', 'elegance' ),
		'installing'                      => __( 'Installing Plugin: %s', 'elegance' ), // %s = plugin name.
		'oops'                            => __( 'Something went wrong with the plugin API.', 'elegance' ),
		'notice_can_install_required'     => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.', 'elegance' ), // %1$s = plugin name(s).
		'notice_can_install_recommended'  => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.', 'elegance' ), // %1$s = plugin name(s).
		'notice_cannot_install'           => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'elegance' ), // %1$s = plugin name(s).
		'notice_can_activate_required'    => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'elegance' ), // %1$s = plugin name(s).
		'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'elegance' ), // %1$s = plugin name(s).
		'notice_cannot_activate'          => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'elegance' ), // %1$s = plugin name(s).
		'notice_ask_to_update'            => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'elegance' ), // %1$s = plugin name(s).
		'notice_cannot_update'            => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'elegance' ), // %1$s = plugin name(s).
		'install_link'                    => _n_noop( 'Begin installing plugin', 'Begin installing plugins', 'elegance' ),
		'activate_link'                   => _n_noop( 'Begin activating plugin', 'Begin activating plugins', 'elegance' ),
		'return'                          => __( 'Return to Required Plugins Installer', 'elegance' ),
		'plugin_activated'                => __( 'Plugin activated successfully.', 'elegance' ),
		'complete'                        => __( 'All plugins installed and activated successfully. %s', 'elegance' ), // %s = dashboard link.
		'nag_type'                        => 'updated' // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
	));

	tgmpa( $plugins, $config );

}