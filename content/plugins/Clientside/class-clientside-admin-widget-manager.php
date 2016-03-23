<?php
/*
 * Clientside Admin Widget Manager class
 * Contains method to build the Admin Widget Manager tool and perform the role-based hiding of widgets
 */

class Clientside_Admin_Widget_Manager {

	// Return (array) list of admin widget slugs for a specified page, optionally with a prefix
	static function get_widget_slugs( $page_slug = 'dashboard', $prefix = 'admin-widget-manager-' ) {

		$widgets = self::get_widget_info( $page_slug );
		$widget_slugs = array();

		foreach ( $widgets as $widget_slug => $widget_info ) {
			$widget_slugs[] = $prefix . $widget_slug;
		}

		return $widget_slugs;

	}

	// Return (string) page name to display as option section title
	static function get_page_name( $page_slug = 'dashboard' ) {

		$page_names = array(
			'dashboard' => __( 'Dashboard Widgets', 'clientside' ),
			'post-edit-screen' => __( 'Post/Page Edit Screen Widgets', 'clientside' )
		);

		// Return
		return isset( $page_names[ $page_slug ] ) ? $page_names[ $page_slug ] : '';

	}

	// Return (array) all manageble admin widgets' info
	static function get_widget_info( $page = '' ) {

		$widgets = array(
			'dashboard' => array(
				'dashboard_browser_nag' => array(
					'page' => 'dashboard',
					'horizontal_position' => 'normal',
					'field' => array(
						'name' => 'admin-widget-manager-dashboard_browser_nag',
						'title' => _x( 'Browser Upgrade Warning', 'Admin widget title', 'clientside' ),
						'type' => 'checkbox',
						'default' => 1,
						'role-based' => true
					)
				),
				'dashboard_primary' => array(
					'page' => 'dashboard',
					'horizontal_position' => 'side',
					'field' => array(
						'name' => 'admin-widget-manager-dashboard_primary',
						'title' => _x( 'WordPress News', 'Admin widget title', 'clientside' ),
						'type' => 'checkbox',
						'default' => 1,
						'role-based' => true
					)
				),
				'dashboard_activity' => array(
					'page' => 'dashboard',
					'horizontal_position' => 'normal',
					'field' => array(
						'name' => 'admin-widget-manager-dashboard_activity',
						'title' => _x( 'Activity', 'Admin widget title', 'clientside' ),
						'type' => 'checkbox',
						'default' => 1,
						'role-based' => true
					)
				),
				'dashboard_right_now' => array(
					'page' => 'dashboard',
					'horizontal_position' => 'normal',
					'field' => array(
						'name' => 'admin-widget-manager-dashboard_right_now',
						'title' => _x( 'At a Glance', 'Admin widget title', 'clientside' ),
						'type' => 'checkbox',
						'role-based' => true,
						'disabled-for' => array(
							'subscriber'
						),
						'default' => array(
							'clientside-default' => 1,
							'subscriber' => 0
						)
					)
				),
				'dashboard_quick_press' => array(
					'page' => 'dashboard',
					'horizontal_position' => 'side',
					'field' => array(
						'name' => 'admin-widget-manager-dashboard_quick_press',
						'title' => _x( 'Quick Draft', 'Admin widget title', 'clientside' ),
						'type' => 'checkbox',
						'role-based' => true,
						'disabled-for' => array(
							'subscriber'
						),
						'default' => array(
							'clientside-default' => 1,
							'subscriber' => 0
						)
					)
				),
				'welcome_panel' => array(
					'page' => 'dashboard',
					'field' => array(
						'name' => 'admin-widget-manager-welcome_panel',
						'title' => _x( 'Welcome to WordPress', 'Admin widget title', 'clientside' ),
						'type' => 'checkbox',
						'role-based' => true,
						'disabled-for' => array(
							'editor',
							'author',
							'contributor',
							'subscriber'
						),
						'default' => array(
							'clientside-default' => 1,
							'editor' => 0,
							'author' => 0,
							'contributor' => 0,
							'subscriber' => 0
						)
					)
				),
				'clientside-dashboard-widget-status' => array(
					'page' => 'dashboard',
					'horizontal_position' => 'normal',
					'field' => array(
						'name' => 'admin-widget-manager-clientside-dashboard-widget-status',
						'title' => _x( 'Clientside Site and Server Status', 'Admin widget title', 'clientside' ),
						'type' => 'checkbox',
						'role-based' => true,
						'disabled-for' => array(
							'editor',
							'author',
							'contributor',
							'subscriber'
						),
						'default' => array(
							'clientside-default' => 1,
							'editor' => 0,
							'author' => 0,
							'contributor' => 0,
							'subscriber' => 0
						)
					)
				)
			),
			'post-edit-screen' => array(
				'permalink' => array(
					'page' => array( 'post', 'page' ),
					'field' => array(
						'name' => 'admin-widget-manager-permalink',
						'title' => _x( 'Permalink control', 'Admin widget title', 'clientside' ),
						'help' => _x( 'This is not technically a page widget, but close enough to include here.', 'Option description', 'clientside' ),
						'type' => 'checkbox',
						'role-based' => true,
						'disabled-for' => array(
							'subscriber'
						),
						'default' => array(
							'clientside-default' => 1,
							'subscriber' => 0
						)
					)
				),
				'media-button' => array(
					'page' => array( 'post', 'page' ),
					'field' => array(
						'name' => 'admin-widget-manager-media-button',
						'title' => _x( 'Media button', 'Admin widget title', 'clientside' ),
						'help' => _x( 'This is not technically a page widget, but close enough to include here.', 'Option description', 'clientside' ),
						'type' => 'checkbox',
						'role-based' => true,
						'disabled-for' => array(
							'subscriber'
						),
						'default' => array(
							'clientside-default' => 1,
							'subscriber' => 0
						)
					)
				),
				'postexcerpt' => array(
					'page' => array( 'post', 'page' ),
					'horizontal_position' => 'normal',
					'field' => array(
						'name' => 'admin-widget-manager-postexcerpt',
						'title' => _x( 'Excerpt', 'Admin widget title', 'clientside' ),
						'type' => 'checkbox',
						'role-based' => true,
						'disabled-for' => array(
							'subscriber'
						),
						'default' => array(
							'clientside-default' => 1,
							'subscriber' => 0
						)
					)
				),
				'trackbacksdiv' => array(
					'page' => array( 'post', 'page' ),
					'horizontal_position' => 'normal',
					'field' => array(
						'name' => 'admin-widget-manager-trackbacksdiv',
						'title' => _x( 'Send Trackbacks', 'Admin widget title', 'clientside' ),
						'type' => 'checkbox',
						'role-based' => true,
						'disabled-for' => array(
							'subscriber'
						),
						'default' => array(
							'clientside-default' => 1,
							'subscriber' => 0
						)
					)
				),
				'postcustom' => array(
					'page' => array( 'post', 'page' ),
					'horizontal_position' => 'normal',
					'field' => array(
						'name' => 'admin-widget-manager-postcustom',
						'title' => _x( 'Custom Fields', 'Admin widget title', 'clientside' ),
						'type' => 'checkbox',
						'role-based' => true,
						'disabled-for' => array(
							'subscriber'
						),
						'default' => array(
							'clientside-default' => 1,
							'subscriber' => 0
						)
					)
				),
				'commentstatusdiv' => array(
					'page' => array( 'post', 'page' ),
					'horizontal_position' => 'normal',
					'field' => array(
						'name' => 'admin-widget-manager-commentstatusdiv',
						'title' => _x( 'Discussion', 'Admin widget title', 'clientside' ),
						'type' => 'checkbox',
						'role-based' => true,
						'disabled-for' => array(
							'subscriber'
						),
						'default' => array(
							'clientside-default' => 1,
							'subscriber' => 0
						)
					)
				),
				'commentsdiv' => array(
					'page' => array( 'post', 'page' ),
					'horizontal_position' => 'normal',
					'field' => array(
						'name' => 'admin-widget-manager-commentsdiv',
						'title' => _x( 'Comments', 'Admin widget title', 'clientside' ),
						'type' => 'checkbox',
						'role-based' => true,
						'disabled-for' => array(
							'editor',
							'author',
							'contributor',
							'subscriber'
						),
						'default' => array(
							'clientside-default' => 1,
							'editor' => 0,
							'author' => 0,
							'contributor' => 0,
							'subscriber' => 0
						)
					)
				),
				'revisionsdiv' => array(
					'page' => 'post',
					'horizontal_position' => 'normal',
					'field' => array(
						'name' => 'admin-widget-manager-revisionsdiv',
						'title' => _x( 'Revisions', 'Admin widget title', 'clientside' ),
						'type' => 'checkbox',
						'role-based' => true,
						'disabled-for' => array(
							'subscriber'
						),
						'default' => array(
							'clientside-default' => 1,
							'subscriber' => 0
						)
					)
				),
				'authordiv' => array(
					'page' => array( 'post', 'page' ),
					'horizontal_position' => 'normal',
					'field' => array(
						'name' => 'admin-widget-manager-authordiv',
						'title' => _x( 'Author', 'Admin widget title', 'clientside' ),
						'type' => 'checkbox',
						'role-based' => true,
						'disabled-for' => array(
							'author',
							'contributor',
							'subscriber'
						),
						'default' => array(
							'clientside-default' => 1,
							'author' => 0,
							'contributor' => 0,
							'subscriber' => 0
						)
					)
				),
				'slugdiv' => array(
					'page' => array( 'post', 'page' ),
					'horizontal_position' => 'normal',
					'field' => array(
						'name' => 'admin-widget-manager-slugdiv',
						'title' => _x( 'Slug', 'Admin widget title', 'clientside' ),
						'type' => 'checkbox',
						'role-based' => true,
						'disabled-for' => array(
							'subscriber'
						),
						'default' => array(
							'clientside-default' => 1,
							'subscriber' => 0
						)
					)
				),
				'formatdiv' => array(
					'page' => 'post',
					'horizontal_position' => 'side',
					'field' => array(
						'name' => 'admin-widget-manager-formatdiv',
						'title' => _x( '(Post) Format', 'Admin widget title', 'clientside' ),
						'type' => 'checkbox',
						'role-based' => true,
						'disabled-for' => array(
							'subscriber'
						),
						'default' => array(
							'clientside-default' => 1,
							'subscriber' => 0
						)
					)
				),
				'categorydiv' => array(
					'page' => 'post',
					'horizontal_position' => 'side',
					'field' => array(
						'name' => 'admin-widget-manager-categorydiv',
						'title' => _x( 'Categories', 'Admin widget title', 'clientside' ),
						'type' => 'checkbox',
						'role-based' => true,
						'disabled-for' => array(
							'subscriber'
						),
						'default' => array(
							'clientside-default' => 1,
							'subscriber' => 0
						)
					)
				),
				'tagsdiv-post_tag' => array(
					'page' => 'post',
					'horizontal_position' => 'side',
					'field' => array(
						'name' => 'admin-widget-manager-tagsdiv-post_tag',
						'title' => _x( 'Tags', 'Admin widget title', 'clientside' ),
						'type' => 'checkbox',
						'role-based' => true,
						'disabled-for' => array(
							'subscriber'
						),
						'default' => array(
							'clientside-default' => 1,
							'subscriber' => 0
						)
					)
				),
				'postimagediv' => array(
					'page' => array( 'post', 'page' ),
					'horizontal_position' => 'side',
					'field' => array(
						'name' => 'admin-widget-manager-postimagediv',
						'title' => _x( 'Featured Image', 'Admin widget title', 'clientside' ),
						'type' => 'checkbox',
						'role-based' => true,
						'disabled-for' => array(
							'contributor',
							'subscriber'
						),
						'default' => array(
							'clientside-default' => 1,
							'contributor' => 0,
							'subscriber' => 0
						)
					)
				),
				'pageparentdiv' => array(
					'page' => 'page',
					'horizontal_position' => 'side',
					'field' => array(
						'name' => 'admin-widget-manager-pageparentdiv',
						'title' => _x( 'Page Attributes', 'Admin widget title', 'clientside' ),
						'type' => 'checkbox',
						'role-based' => true,
						'disabled-for' => array(
							'author',
							'contributor',
							'subscriber'
						),
						'default' => array(
							'clientside-default' => 1,
							'author' => 0,
							'contributor' => 0,
							'subscriber' => 0
						)
					)
				)
			)
		);

		// Return
		if ( $page ) {
			return isset( $widgets[ $page ] ) ? $widgets[ $page ] : array();
		}
		return $widgets;

	}

	static function remove_page_widgets( $page = 'dashboard' ) {

		$widgets = self::get_widget_info( $page );

		foreach ( $widgets as $widget_slug => $widget_info ) {

			// Alternative process
			if ( in_array( $widget_slug, array( 'permalink', 'media-button' ) ) ) {
				continue;
			}

			// Remove widget if role-based option is set to false
			if ( ! Clientside_Options::get_saved_option( 'admin-widget-manager-' . $widget_slug ) ) {
				if ( is_array( $widget_info['page'] ) ) {
					foreach ( $widget_info['page'] as $page ) {
						remove_meta_box( $widget_slug, $page, $widget_info['horizontal_position'] );
					}
				}
				else {

					// Welcome panel
					if ( $widget_slug == 'welcome_panel' ) {
						remove_action( 'welcome_panel', 'wp_welcome_panel' );
					}

					// Any other widget
					else {
						remove_meta_box( $widget_slug, $widget_info['page'], $widget_info['horizontal_position'] );
					}

				}
			}

		}

	}

	// Apply the removal of dashboard widgets if applicable to this role / page
	static function action_remove_dashboard_widgets() {
		self::remove_page_widgets( 'dashboard' );
	}

	// Apply the removal of post edit screen widgets if applicable to this role / page
	static function action_remove_post_edit_screen_widgets() {
		self::remove_page_widgets( 'post-edit-screen' );
	}

}
?>