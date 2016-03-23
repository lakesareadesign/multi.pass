<?php
/*
 * Clientside Options class
 * Contains default option values, deals with retrieving and saving Clientside options
 */

class Clientside_Options {

	static $options_slug = 'clientside_options';
	static $saved_options = array();
	static $saved_options_with_user_metas = array();
	static $saved_network_options = array();
	static $saved_network_options_with_user_metas = array();

	// Return (array) the properties of all option sections
	static function get_options_sections( $section_slug = '' ) {

		$options_sections = array(

			'clientside-section-general' => array(
				'slug' => 'clientside-section-general',
				'title' => _x( 'General plugin options and extra functionality', 'Option section name', 'clientside' ),
				'page' => 'clientside-options-general',
				'options' => array(
					'admin-dashboard-title',
					'logo-image',
					'hide-login-logo',
					'hide-menu-logo',
					'disable-login-errors',
					'remove-version-header',
					'hide-updates',
					'disable-file-editor',
					'disable-cli-error-handling',
					'enable-notification-center',
					'enable-plugin-support',
					'menu-hover-expand'
				)
			),
			'clientside-section-theme' => array(
				'slug' => 'clientside-section-theme',
				'title' => _x( 'Admin Theme Options', 'Option section name', 'clientside' ),
				'page' => 'clientside-options-general',
				'options' => array(
					'enable-admin-theme',
					'enable-login-theme',
					'enable-site-toolbar-theme',
					'enable-editor-styling',
					'enable-separators'
				)
			),
			'clientside-section-post-listing' => array(
				'slug' => 'clientside-section-post-listing',
				'title' => _x( 'Post Listing Options', 'Option section name', 'clientside' ),
				'page' => 'clientside-options-general',
				'options' => array(
					'paging-posts',
					'hide-post-list-date-filter',
					'hide-post-list-category-filter',
					'hide-top-paging',
					'hide-top-bulk',
					'hide-post-search',
					'hide-view-switch',
					'hide-media-bulk-select',
					'hide-user-role-changer'
				)
			),
			'clientside-section-toolbar' => array(
				'slug' => 'clientside-section-toolbar',
				'title' => _x( 'Toolbar Options', 'Option section name', 'clientside' ),
				'page' => 'clientside-options-general',
				'options' => array(
					'hide-front-admin-toolbar',
					'hide-screen-options',
					'hide-help',
					'hide-toolbar-new',
					'hide-toolbar-comments',
					'hide-toolbar-updates',
					'hide-toolbar-search'
				)
			),

			// Network options
			'clientside-section-network' => array(
				'slug' => 'clientside-section-network',
				'title' => _x( 'Network options', 'Option section name', 'clientside' ),
				'page' => 'clientside-options-network',
				'options' => array(
					'network-admins-only'
				)
			),

			// Admin Menu Editor tool
			'clientside-admin-menu-editor' => array(
				'slug' => 'clientside-admin-menu-editor',
				'title' => __( 'Admin Menu Editor', 'clientside' ),
				'page' => 'clientside-admin-menu-editor',
				'options' => array(
					'admin-menu'
				)
			)

		);

		// Admin Widget Manager tool
		foreach ( Clientside_Admin_Widget_Manager::get_widget_info() as $page_slug => $widgets ) {
			$options_sections[ 'clientside-admin-widgets-' . $page_slug ] = array(
				'slug' => 'clientside-admin-widgets-' . $page_slug,
				'title' => Clientside_Admin_Widget_Manager::get_page_name( $page_slug ),
				'page' => 'clientside-admin-widget-manager',
				'options' => Clientside_Admin_Widget_Manager::get_widget_slugs( $page_slug, 'admin-widget-manager-' )
			);
		}

		// Admin Column Manager tool
		foreach ( Clientside_Admin_Column_Manager::get_column_info() as $page_slug => $columns ) {
			$options_sections[ 'clientside-admin-columns-' . $page_slug ] = array(
				'slug' => 'clientside-admin-columns-' . $page_slug,
				'title' => Clientside_Admin_Column_Manager::get_page_name( $page_slug ),
				'page' => 'clientside-admin-column-manager',
				'options' => Clientside_Admin_Column_Manager::get_column_slugs( $page_slug, 'admin-column-manager-' . $page_slug . '-' )
			);
		}

		// Return
		if ( $section_slug && isset( $options_sections[ $section_slug ] ) ) {
			return $options_sections[ $section_slug ];
		}
		return $options_sections;

	}

	// Return (array) the properties of one or more Clientside plugin options
	static function get_option_info( $option_slug = '' ) {

		$options = array();

		// Default page properties
		$default_args = array(
			'secondary-title' => '',
			'type' => 'text',
			'help' => '',
			'options' => array(),
			'role-based' => false,
			'disabled-for' => array(),
			'default' => null,
			'user-meta' => ''
		);

		$options['admin-dashboard-title'] = array_merge(
			$default_args,
			array(
				'name' => 'admin-dashboard-title',
				'title' => _x( 'Admin Dashboard button text', 'Option title', 'clientside' ),
				'help' => _x( 'Text on the Admin Dashboard button when viewing the site.', 'Option description', 'clientside' ),
				'default' => _x( 'Admin Dashboard', 'Toolbar button text', 'clientside' )
			)
		);

		$options['enable-admin-theme'] = array_merge(
			$default_args,
			array(
				'name' => 'enable-admin-theme',
				'title' => _x( 'Enable Clientside admin theming', 'Option title', 'clientside' ),
				'type' => 'checkbox',
				'default' => 1,
				'help' => _x( 'Disabling this option will prevent all style related changes for the specific user role.', 'Option description', 'clientside' ),
				'role-based' => true
			)
		);

		$options['enable-plugin-support'] = array_merge(
			$default_args,
			array(
				'name' => 'enable-plugin-support',
				'title' => _x( 'Additional plugin support', 'Option title', 'clientside' ),
				'secondary-title' => __( 'Enable', 'clientside' ),
				'type' => 'checkbox',
				'default' => 1,
				'help' => sprintf( _x( 'Useful when using any of the <a href="%s" target="_blank">affected external plugins</a>. Disabling this option can slightly improve performance because less CSS will be loaded.', 'Option description', 'clientside' ), 'http://frique.me/clientside#documentation' )
			)
		);

		$options['menu-hover-expand'] = array_merge(
			$default_args,
			array(
				'name' => 'menu-hover-expand',
				'title' => _x( 'Expand Submenus on Hover', 'Option title', 'clientside' ),
				'secondary-title' => __( 'Enable', 'clientside' ),
				'type' => 'checkbox',
				'default' => 0,
				'help' => _x( 'This replaces the default behavior of clicking a menu item to expand its submenu.', 'Option description', 'clientside' )
			)
		);

		$options['enable-editor-styling'] = array_merge(
			$default_args,
			array(
				'name' => 'enable-editor-styling',
				'title' => _x( 'Text editor styling', 'Option title', 'clientside' ),
				'secondary-title' => __( 'Enable', 'clientside' ),
				'type' => 'checkbox',
				'default' => 1,
				'help' => _x( 'Some themes might make the editor styling match the site\'s typography. Enabling this option will overwrite that styling.', 'Option description', 'clientside' )
			)
		);

		$options['enable-separators'] = array_merge(
			$default_args,
			array(
				'name' => 'enable-separators',
				'title' => _x( 'Menu separators', 'Option title', 'clientside' ),
				'secondary-title' => __( 'Enable', 'clientside' ),
				'type' => 'checkbox',
				'default' => 0,
				'help' => _x( 'Menu separators are hidden by default. This option enables them.', 'Option description', 'clientside' )
			)
		);

		$options['hide-updates'] = array_merge(
			$default_args,
			array(
				'name' => 'hide-updates',
				'title' => _x( 'Hide update information (WP core, plugins, themes)', 'Option title', 'clientside' ),
				'help' => _x( 'The affected user role won\'t be confronted with update information. This will also speed up certain page load times.', 'Option description', 'clientside' ),
				'type' => 'checkbox',
				'default' => array(
					'clientside-default' => 0,
					'super' => 0,
					'administrator' => 0,
					'editor' => 0,
					'author' => 1,
					'contributor' => 1,
					'subscriber' => 1
				),
				'role-based' => true
			)
		);

		$options['hide-front-admin-toolbar'] = array_merge(
			$default_args,
			array(
				'name' => 'hide-front-admin-toolbar',
				'title' => _x( 'Hide the admin toolbar when viewing the site', 'Option title', 'clientside' ),
				'help' => _x( 'Note that this overwrites the native user-based setting when checked.', 'Option description', 'clientside' ),
				'type' => 'checkbox',
				'default' => 0,
				'role-based' => true
			)
		);

		$options['hide-screen-options'] = array_merge(
			$default_args,
			array(
				'name' => 'hide-screen-options',
				'title' => _x( 'Hide the Screen Options button', 'Option title', 'clientside' ),
				'help' => _x( 'This will make the affected users unable to manage the page\'s widgets and other page customizations.', 'Option description', 'clientside' ),
				'type' => 'checkbox',
				'default' => 0,
				'role-based' => true
			)
		);

		$options['hide-help'] = array_merge(
			$default_args,
			array(
				'name' => 'hide-help',
				'title' => _x( 'Hide the Help button', 'Option title', 'clientside' ),
				'type' => 'checkbox',
				'default' => 0,
				'role-based' => true
			)
		);

		$options['hide-user-role-changer'] = array_merge(
			$default_args,
			array(
				'name' => 'hide-user-role-changer',
				'title' => _x( 'Hide User Role Changer', 'Option title', 'clientside' ),
				'help' => _x( 'Hides the role changing dropdown above user-listings.', 'Option description', 'clientside' ),
				'type' => 'checkbox',
				'default' => 0
			)
		);

		$options['hide-post-list-date-filter'] = array_merge(
			$default_args,
			array(
				'name' => 'hide-post-list-date-filter',
				'title' => _x( 'Hide Date Filter', 'Option title', 'clientside' ),
				'help' => _x( 'Hides the post-listing date filter dropdown (for all post types).', 'Option description', 'clientside' ),
				'type' => 'checkbox',
				'default' => array(
					'clientside-default' => 0,
					'super' => 0,
					'administrator' => 0,
					'editor' => 0,
					'author' => 1,
					'contributor' => 1,
					'subscriber' => 1
				),
				'role-based' => true
			)
		);

		$options['hide-post-list-category-filter'] = array_merge(
			$default_args,
			array(
				'name' => 'hide-post-list-category-filter',
				'title' => _x( 'Hide Category Filter', 'Option title', 'clientside' ),
				'help' => _x( 'Hides the post-listing category filter dropdown (for all post types).', 'Option description', 'clientside' ),
				'type' => 'checkbox',
				'default' => array(
					'clientside-default' => 0,
					'super' => 0,
					'administrator' => 0,
					'editor' => 0,
					'author' => 1,
					'contributor' => 1,
					'subscriber' => 1
				),
				'role-based' => true
			)
		);

		$options['hide-top-paging'] = array_merge(
			$default_args,
			array(
				'name' => 'hide-top-paging',
				'title' => _x( 'Hide Top Pager', 'Option title', 'clientside' ),
				'help' => _x( 'Hides the paging navigation above post-listings (for all post types). The bottom one remains.', 'Option description', 'clientside' ),
				'type' => 'checkbox',
				'default' => 0,
				'role-based' => true
			)
		);

		$options['hide-top-bulk'] = array_merge(
			$default_args,
			array(
				'name' => 'hide-top-bulk',
				'title' => _x( 'Hide Top Bulk Actions', 'Option title', 'clientside' ),
				'help' => _x( 'Hides the Bulk Actions dropdown above post-listings (for all post types). The bottom one remains.', 'Option description', 'clientside' ),
				'type' => 'checkbox',
				'default' => 0,
				'role-based' => true
			)
		);

		$options['hide-post-search'] = array_merge(
			$default_args,
			array(
				'name' => 'hide-post-search',
				'title' => _x( 'Hide Post Search', 'Option title', 'clientside' ),
				'help' => _x( 'Hides the search form above post-listings (for all post types).', 'Option description', 'clientside' ),
				'type' => 'checkbox',
				'default' => 0,
				'role-based' => true
			)
		);

		$options['hide-view-switch'] = array_merge(
			$default_args,
			array(
				'name' => 'hide-view-switch',
				'title' => _x( 'Hide View Switch', 'Option title', 'clientside' ),
				'help' => _x( 'Hides the view switcher above the media page.', 'Option description', 'clientside' ),
				'type' => 'checkbox',
				'default' => 0,
				'role-based' => true
			)
		);

		$options['hide-media-bulk-select'] = array_merge(
			$default_args,
			array(
				'name' => 'hide-media-bulk-select',
				'title' => _x( 'Hide Media Bulk Select', 'Option title', 'clientside' ),
				'help' => _x( 'Hides the Bulk Select button above the media page that allows for deletion of multiple files.', 'Option description', 'clientside' ),
				'type' => 'checkbox',
				'default' => 0,
				'role-based' => true
			)
		);

		$options['enable-notification-center'] = array_merge(
			$default_args,
			array(
				'name' => 'enable-notification-center',
				'title' => _x( 'Notification Center', 'Option title', 'clientside' ),
				'secondary-title' => __( 'Enable', 'clientside' ),
				'help' => _x( 'The Clientside Notification Center puts notifications away into a toolbar item instead of showing them directly on the page.', 'Option description', 'clientside' ),
				'type' => 'checkbox',
				'default' => 1
			)
		);

		$options['hide-toolbar-new'] = array_merge(
			$default_args,
			array(
				'name' => 'hide-toolbar-new',
				'title' => _x( 'Hide the "New" dropdown list in the toolbar.', 'Option title', 'clientside' ),
				'type' => 'checkbox',
				'default' => 0,
				'role-based' => true
			)
		);

		$options['hide-toolbar-comments'] = array_merge(
			$default_args,
			array(
				'name' => 'hide-toolbar-comments',
				'title' => _x( 'Hide the "Comments" button in the toolbar.', 'Option title', 'clientside' ),
				'type' => 'checkbox',
				'default' => 1,
				'role-based' => true
			)
		);

		$options['hide-toolbar-updates'] = array_merge(
			$default_args,
			array(
				'name' => 'hide-toolbar-updates',
				'title' => _x( 'Hide the "Updates" button in the toolbar.', 'Option title', 'clientside' ),
				'type' => 'checkbox',
				'default' => 1,
				'role-based' => true
			)
		);

		$options['hide-toolbar-search'] = array_merge(
			$default_args,
			array(
				'name' => 'hide-toolbar-search',
				'title' => _x( 'Hide the Search functionality in the toolbar when viewing the site.', 'Option title', 'clientside' ),
				'type' => 'checkbox',
				'default' => 1,
				'role-based' => true
			)
		);

		$options['disable-login-errors'] = array_merge(
			$default_args,
			array(
				'name' => 'disable-login-errors',
				'title' => _x( 'Login error hinting', 'Option title', 'clientside' ),
				'secondary-title' => __( 'Disable', 'clientside' ),
				'help' => _x( 'Prevent WP from showing login errors. This can add to security.', 'Option description', 'clientside' ),
				'type' => 'checkbox',
				'default' => 0
			)
		);

		$options['remove-version-header'] = array_merge(
			$default_args,
			array(
				'name' => 'remove-version-header',
				'title' => _x( 'WordPress version meta tag', 'Option title', 'clientside' ),
				'secondary-title' => __( 'Remove', 'clientside' ),
				'help' => _x( 'Prevent WP from printing the WP version in the site header. This can add to security.', 'Option description', 'clientside' ),
				'type' => 'checkbox',
				'default' => 0
			)
		);

		$options['enable-login-theme'] = array_merge(
			$default_args,
			array(
				'name' => 'enable-login-theme',
				'title' => _x( 'Themed login/register page', 'Option title', 'clientside' ),
				'secondary-title' => __( 'Enable', 'clientside' ),
				'help' => _x( 'Also apply theming to the login/register pages.', 'Option description', 'clientside' ),
				'type' => 'checkbox',
				'default' => 1
			)
		);

		$options['enable-site-toolbar-theme'] = array_merge(
			$default_args,
			array(
				'name' => 'enable-site-toolbar-theme',
				'title' => _x( 'Themed Site Toolbar', 'Option title', 'clientside' ),
				'secondary-title' => __( 'Enable', 'clientside' ),
				'help' => _x( 'Disable if the active site theme is breaking the toolbar positioning.', 'Option description', 'clientside' ),
				'type' => 'checkbox',
				'default' => 1
			)
		);

		$options['logo-image'] = array_merge(
			$default_args,
			array(
				'name' => 'logo-image',
				'title' => _x( 'Logo image', 'Option title', 'clientside' ),
				'help' => _x( 'Will appear on the login page and above the admin menu (optional). Leave empty to use the default WordPress logo.', 'Option description', 'clientside' ),
				'type' => 'image',
				'default' => ''
			)
		);

		$options['hide-menu-logo'] = array_merge(
			$default_args,
			array(
				'name' => 'hide-menu-logo',
				'title' => _x( 'Hide the logo above the menu', 'Option title', 'clientside' ),
				'help' => _x( 'Applies if a custom logo is uploaded. The "View Site" button will appear instead.', 'Option description', 'clientside' ),
				'type' => 'checkbox',
				'default' => 0,
				'role-based' => true
			)
		);

		$options['hide-login-logo'] = array_merge(
			$default_args,
			array(
				'name' => 'hide-login-logo',
				'title' => _x( 'Hide the login logo', 'Option title', 'clientside' ),
				'secondary-title' => __( 'Hide', 'clientside' ),
				'help' => _x( 'Completely hides the logo on the login page, wether it\'s a custom uploaded logo or the default.', 'Option description', 'clientside' ),
				'type' => 'checkbox',
				'default' => 0
			)
		);

		$options['paging-posts'] = array_merge(
			$default_args,
			array(
				'name' => 'paging-posts',
				'title' => _x( 'Posts per page', 'Option title', 'clientside' ),
				'help' => _x( 'This changes the number of posts per page for all post types and all users and even overwrites the manual preference managed via Screen Options. Leave empty to use the default behaviour.', 'Option description', 'clientside' ),
				'type' => 'number',
				'default' => ''
			)
		);

		$options['disable-file-editor'] = array_merge(
			$default_args,
			array(
				'name' => 'disable-file-editor',
				'title' => _x( 'Theme/plugin file editor', 'Option title', 'clientside' ),
				'secondary-title' => __( 'Disable', 'clientside' ),
				'help' => _x( 'Prevent access to the theme/plugin file editing pages. Note that this will only work if the "DISALLOW_FILE_EDIT" constant isn\'t already defined (generally via wp-config.php).', 'Option description', 'clientside' ),
				'type' => 'checkbox',
				'default' => 0
			)
		);

		$options['disable-cli-error-handling'] = array_merge(
			$default_args,
			array(
				'name' => 'disable-cli-error-handling',
				'title' => _x( 'Custom error handler', 'Option title', 'clientside' ),
				'secondary-title' => __( 'Disable', 'clientside' ),
				'help' => _x( 'Clientside prevents PHP from printing errors before the document HTML and outputs them to the notification area instead. This feature can be disabled here if this causes problems with your own error logging solutions.', 'Option description', 'clientside' ),
				'type' => 'checkbox',
				'default' => 0
			)
		);

		$options['network-admins-only'] = array_merge(
			$default_args,
			array(
				'name' => 'network-admins-only',
				'title' => _x( 'Network Admins Only', 'Option title', 'clientside' ),
				'secondary-title' => __( 'Make Clientside only manageable by Network/Super Admins', 'clientside' ),
				'help' => _x( 'Plugin Options, Clientside Tools and the entry in the plugin list on all network sites will be hidden to anyone except Network Admins.', 'Option description', 'clientside' ),
				'type' => 'checkbox',
				'default' => 0
			)
		);

		// Admin Menu Editor tool
		$options['admin-menu'] = array_merge(
			$default_args,
			array(
				'name' => 'admin-menu',
				'title' => _x( 'Admin Menu', 'Option title', 'clientside' ),
				'type' => 'textarea',
				'default' => ''
			)
		);

		// Admin Widget Manager tool
		foreach ( Clientside_Admin_Widget_Manager::get_widget_info() as $page_slug => $widgets ) {

			foreach ( $widgets as $widget_slug => $widget_info ) {
				$options[ $widget_info['field']['name'] ] = array_merge(
					$default_args,
					$widget_info['field']
				);
			}

		}

		// Admin Column Manager tool
		foreach ( Clientside_Admin_Column_Manager::get_column_info() as $page_slug => $columns ) {

			foreach ( $columns as $column_slug => $column_info ) {
				$options[ $column_info['field']['name'] ] = array_merge(
					$default_args,
					$column_info['field']
				);
			}

		}

		// Return requested option
		if ( $option_slug ) {
			if ( ! isset( $options[ $option_slug ] ) ) {
				return null;
			}
			return $options[ $option_slug ];
		}

		// Return all option info
		return $options;

	}

	// Register settings and fields
	static function action_register_settings_and_fields() {

		// Options.php entries
		register_setting(
			self::$options_slug,
			self::$options_slug,
			array( __CLASS__, 'callback_option_validation' )
		);

		// Sections
		foreach ( self::get_options_sections() as $options_section ) {

			// Register the section
			add_settings_section(
				$options_section['slug'],
				$options_section['title'],
				'__return_false',
				$options_section['page']
			);

			// Register the section's option fields
			foreach ( $options_section['options'] as $option_slug ) {

				// Abort if option doesn't exist
				$option = self::get_option_info( $option_slug );
				if ( is_null( $option ) ) {
					continue;
				}

				// Arguments to pass to the callback
				$args = array(
					'field' => $option
				);
				if ( ! $option['role-based'] ) {
					$args['label_for'] = 'clientside-formfield-' . $option['name'];
				}

				// Register the field
				add_settings_field(
					$option['name'],
					$option['title'],
					array( __CLASS__, 'display_form_field' ),
					$options_section['page'],
					$options_section['slug'],
					$args
				);

			}

		}

	}

	// Return saved options from cache or the database
	static function get_saved_options( $include_user_meta = false, $network = false ) {

		// If not already cached
		if (
			// Network options
			( $network && ( empty( self::$saved_network_options ) || empty( self::$saved_network_options_with_user_metas ) ) )
			||
			// Site options
			( empty( self::$saved_options ) || empty( self::$saved_options_with_user_metas ) )
		) {

			// Validate network param
			if ( $network && ( ! is_multisite() || get_current_blog_id() == 1 ) ) {
				$network = false;
			}

			// Load all defaults to name => value array
			$default_options = array();
			foreach ( self::get_option_info() as $option ) {
				if ( $option['role-based'] ) {
					$default_options[ $option['name'] ] = is_array( $option['default'] ) ? $option['default'] : array( 'clientside-default' => $option['default'] );
				}
				else {
					$default_options[ $option['name'] ] = $option['default'];
				}
			}

			// Get saved options from the database
			$saved_options = $network ? get_blog_option( 1, self::$options_slug, array() ) : get_option( self::$options_slug, array() );

			// Merge defaults with saved options & save to cache
			$saved_options = $saved_options_with_user_metas = array_replace_recursive( $default_options, $saved_options );

			// Save user meta manipulated options separately
			foreach ( self::get_option_info() as $option ) {
				if ( $option['user-meta'] ) {
					$meta_value = get_user_meta( get_current_user_id(), $option['user-meta'], true );
					if ( ! empty( $meta_value ) ) {
						$saved_options_with_user_metas[ $option['name'] ] = $meta_value;
					}
				}
			}

			// Keep them for later
			if ( $network ) {
				self::$saved_network_options = $saved_options;
				self::$saved_network_options_with_user_metas = $saved_options_with_user_metas;
			}
			else {
				self::$saved_options = $saved_options;
				self::$saved_options_with_user_metas = $saved_options_with_user_metas;
			}

		}

		// Return
		if ( $network ) {
			return $include_user_meta ? self::$saved_network_options_with_user_metas : self::$saved_network_options;
		}
		return $include_user_meta ? self::$saved_options_with_user_metas : self::$saved_options;

	}

	// Return saved option value or the default
	static function get_saved_option( $option_slug = '', $user_role = '', $include_user_meta = true, $network = false ) {

		$option_info = self::get_option_info( $option_slug );

		// Incompatible arguments
		if ( ! $option_slug || is_null( $option_info ) ) {
			return null;
		}

		// Prepare saved options
		$options = self::get_saved_options( $include_user_meta, $network );

		// Return role-based value
		if ( $option_info['role-based'] ) {

			// Get user role
			if ( ! $user_role ) {
				$user_role = Clientside_User::get_user_role();
				$user_role = is_null( $user_role ) ? '' : $user_role;
			}

			// Return role-based value if it exists, or the default for new roles
			return isset( $options[ $option_slug ][ $user_role ] ) ? $options[ $option_slug ][ $user_role ] : $options[ $option_slug ]['clientside-default'];

		}

		// Return
		return $options[ $option_slug ];

	}

	// Shortcut to get a network option
	static function get_saved_network_option( $option_slug = '' ) {
		return self::get_saved_option( $option_slug, '', true, true );
	}

	// Validate each option value when saving
	static function callback_option_validation( $new_options ) {

		// Set submitted page's unchecked checkboxes to false
		foreach ( self::get_options_sections() as $options_section ) {
			if ( $options_section['page'] == $new_options['options-page-identification'] ) {
				foreach ( $options_section['options'] as $option_slug) {

					// Skip this field if it isn't a checkbox
					$original_option = self::get_option_info( $option_slug );
					if ( $original_option['type'] != 'checkbox' ) {
						continue;
					}

					// Role based option
					if ( $original_option['role-based'] ) {
						foreach ( Clientside_User::get_all_roles() as $role ) {
							// Ignore network admin value when current user is not a network admin
							if ( $role['slug'] == 'super' && ! is_super_admin() ) {
								continue;
							}
							// All other: set missing values to unchecked
							if ( ! isset( $new_options[ $original_option['name'] ][ $role['slug'] ] ) ) {
								$new_options[ $original_option['name'] ][ $role['slug'] ] = 0;
							}
						}
					}

					// Single option
					else if ( ! isset( $new_options[ $original_option['name'] ] ) ) {
						$new_options[ $original_option['name'] ] = 0;
					}

				}
			}
		}

		// Merge new options with existing options
		$saved_options = self::get_saved_options();
		$new_options = array_replace_recursive( $saved_options, $new_options );

		// Revert submitted page's options to defaults, if requested
		if ( isset( $new_options['clientside-revert-page'] ) ) {
			foreach ( self::get_options_sections() as $options_section ) {
				if ( $options_section['page'] == $new_options['options-page-identification'] ) {
					// Unset each option in this section
					foreach ( $options_section['options'] as $option_slug) {
						unset( $new_options[ $option_slug ] );
					}
				}
			}
		}
		unset( $new_options['clientside-revert-page'] );

		// Remove non-existing / legacy options
		foreach ( $new_options as $option_slug => $option_value ) {
			if ( ! isset( $saved_options[ $option_slug ] ) ) {
				unset( $new_options[ $option_slug ] );
			}
		}

		// Return safe set of options
		return $new_options;

	}

	// Handle the saving of Network options
	static function action_network_option_save() {

		if ( ! isset( $_POST[ self::$options_slug ] ) ) {
			return;
		}

		// Funnel submitted options through validation
		$options = self::callback_option_validation( $_POST[ self::$options_slug ] );

		// Save to main site's options
		update_option( self::$options_slug, $options );

		// Redirect back to options page
		$page_info = Clientside_Pages::get_pages( 'clientside-options-network' );
		wp_redirect( network_admin_url( $page_info['parent'] . '?page=' . $page_info['slug'] . '&updated=1' ) );
		die();

	}

	

	// Print an option field
	static function display_form_field( $args = array() ) {

		// Invalid arguments
		if ( ! isset( $args['field'] ) || ! $args['field'] ) {
			return false;
		}

		// Prepare data to pass to the field
		$field = $args['field'];
		$value = $field['role-based'] ? null : self::get_saved_option( $field['name'], '', false );
		$name = self::$options_slug . '[' . $field['name'] . ']';

		// Print the input field of the correct type
		call_user_func( array( __CLASS__, 'display_form_field_type_' . $field['type'] ), $field, $value, $name );

		// Print optional help text
		if ( $field['help'] ) {
			echo '<p class="description">' . $field['help'] . '</p>';
		}

	}

	// Print a text field for options pages
	static function display_form_field_type_text( $field, $value, $name ) {
		?>
		<input id="<?php echo 'clientside-formfield-' . $field['name']; ?>" type="text" class="widefat" name="<?php echo esc_attr( $name ); ?>" value="<?php echo $value; ?>">
		<?php
	}

	// Print a number input field for options pages
	static function display_form_field_type_number( $field, $value, $name ) {
		?>
		<input id="<?php echo 'clientside-formfield-' . $field['name']; ?>" type="number" step="1" min="1" max="999" name="<?php echo esc_attr( $name ); ?>" value="<?php echo $value; ?>">
		<?php
	}

	// Print a textarea field for options pages
	static function display_form_field_type_textarea( $field, $value, $name ) {
		?>
		<textarea id="<?php echo 'clientside-formfield-' . $field['name']; ?>" class="widefat" rows="8" name="<?php echo esc_attr( $name ); ?>"><?php echo $value; ?></textarea>
		<?php
	}

	// Print a checkbox field for options pages
	static function display_form_field_type_checkbox( $field, $value, $name ) {

		// Multi user role option
		if ( $field['role-based'] ) {
			?>
			<fieldset>
				<table class="clientside-user-role-table">
					<tr>
						<?php foreach ( Clientside_User::get_all_roles() as $role ) { ?>
							<?php $value = self::get_saved_option( $field['name'], $role['slug'] ); ?>
							<?php $disabled = ( in_array( $role['slug'], $field['disabled-for'] ) || $role['slug'] == 'super' && ! is_super_admin() ); ?>
							<td>
								<label for="<?php echo esc_attr( 'clientside-formfield-' . $role['slug'] . '-' . $field['name'] ); ?>" class="<?php echo $disabled ? 'form-label-disabled' : ''; ?>">
									<input id="<?php echo esc_attr( 'clientside-formfield-' . $role['slug'] . '-' . $field['name'] ); ?>" type="checkbox" name="<?php echo esc_attr( $name . '[' . $role['slug'] . ']' ); ?>" value="1" <?php checked( $value ); ?> <?php disabled( $disabled ); ?>>
									<?php echo $role['name']; ?>
								</label>
							</td>
						<?php } ?>
					</tr>
				</table>
			</fieldset>
			<?php
		}

		// Single
		else {
			?>
			<fieldset>
				<label for="<?php echo esc_attr( 'clientside-formfield-' . $field['name'] ); ?>">
					<input id="<?php echo esc_attr( 'clientside-formfield-' . $field['name'] ); ?>" type="checkbox" name="<?php echo esc_attr( $name ); ?>" value="1" <?php checked( $value ); ?>>
					<?php if ( $field['secondary-title'] ) { ?>
						<?php echo $field['secondary-title']; ?>
					<?php } ?>
				</label>
			</fieldset>
			<?php
		}

	}

	// Print a radio field for options pages
	static function display_form_field_type_radio( $field, $value, $name ) {

		?>
		<fieldset>
			<?php foreach ( $field['options'] as $option_value => $option_title ) { ?>
				<label for="<?php echo esc_attr( 'clientside-formfield-' . $field['name'] . '-' . $option_value ); ?>">
					<input id="<?php echo esc_attr( 'clientside-formfield-' . $field['name'] . '-' . $option_value ); ?>" type="radio" name="<?php echo esc_attr( $name ); ?>" value="<?php echo $option_value; ?>" <?php checked( $option_value, $value ); ?>>
					<?php echo $option_title; ?>
				</label><br>
			<?php } ?>
		</fieldset>
		<?php

	}

	// Print an image selection field tied to the media manager
	static function display_form_field_type_image( $field, $value, $name ) {
		?>
		<div class="clientside-form-image-preview <?php if ( ! $value ) { echo '-empty'; } ?>" id="<?php echo 'clientside-formfield-' . $field['name']; ?>-preview">
			<img class="clientside-form-image-preview-image clientside-media-select-button" id="<?php echo 'clientside-formfield-' . $field['name']; ?>-preview-image" src="<?php echo $value; ?>">
		</div>
		<input class="clientside-form-image-input" id="<?php echo 'clientside-formfield-' . $field['name']; ?>" type="text" name="<?php echo esc_attr( $name ); ?>" value="<?php echo $value; ?>"><br>
		<a href="#" class="button button-primary clientside-media-select-button" id="<?php echo 'clientside-formfield-' . $field['name']; ?>-upload-button"><?php _ex( 'Upload', 'Upload button text', 'clientside' ); ?></a>
		<div class="clear"></div>
		<?php
	}

}

?>
