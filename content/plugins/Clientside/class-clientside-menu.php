<?php
/*
 * Clientside Menu class
 * Contains methods to manipulate the admin sidebar menu
 */

class Clientside_Menu {

	// Add admin pages & menu items
	static function action_add_menu_entries() {

		// Clientside pages
		foreach ( Clientside_Pages::get_pages() as $page_info ) {

			if ( $page_info['network'] ) {
				continue;
			}

			if ( ! $page_info['in-menu'] ) {
				$page_info['parent'] = null;
			}

			add_submenu_page(
				$page_info['parent'],
				$page_info['title'],
				( $page_info['menu-title'] ? $page_info['menu-title'] : $page_info['title'] ),
				Clientside_User::get_admin_cap(),
				$page_info['slug'],
				$page_info['callback']
			);

		}

		// Add custom sidebar menu collapse button to the bottom
		add_menu_page(
			'Clientside menu collapse button',
			__( 'Collapse menu' ),
			'read',
			'clientside-menu-collapse',
			'__return_false',
			'dashicons-menu',
			999
		);

		// Add custom Logo image or View Site button to the top
		add_menu_page(
			'Clientside View Site button',
			( ( Clientside_Options::get_saved_option( 'logo-image' ) && ! Clientside_Options::get_saved_option( 'hide-menu-logo' ) ) ? '<img class="clientside-menu-logo" src="' . Clientside_Options::get_saved_option( 'logo-image' ) . '" title="' . get_bloginfo( 'name' ) . '">' : _x( 'View Site', 'Text on the menu button', 'clientside' ) ),
			'read',
			'clientside-view-site',
			'__return_false',
			'dashicons-admin-home',
			0
		);

		// Convert certain keywords to external links
		global $menu;
		foreach ( $menu as $menuitem_key => $menuitem ) {
			// Collapse menu button
			if ( isset( $menuitem[2] ) && $menuitem[2] == 'clientside-menu-collapse' ) {
				$menu[ $menuitem_key ][2] = '#';
			}
			// View Site button
			if ( isset( $menuitem[2] ) && $menuitem[2] == 'clientside-view-site' ) {
				$menu[ $menuitem_key ][2] = home_url();
			}
		}

	}

	// Add network admin pages & menu items
	static function action_add_network_menu_entries() {

		// Clientside pages
		foreach ( Clientside_Pages::get_pages() as $page_info ) {
			if ( ! $page_info['network'] ) {
				continue;
			}

			if ( ! $page_info['in-menu'] ) {
				$page_info['parent'] = null;
			}

			add_submenu_page(
				$page_info['parent'],
				$page_info['title'],
				( $page_info['menu-title'] ? $page_info['menu-title'] : $page_info['title'] ),
				Clientside_User::get_admin_cap(),
				$page_info['slug'],
				$page_info['callback']
			);

		}

	}

	// Highlight the proper menu item for tabbed Clientside pages
	static function filter_admin_menu_active_states( $parent_file ) {

		global $submenu_file;
		$current_screen = get_current_screen();

		// Highlight the default Clientside menu item for each hidden options page
		foreach ( Clientside_Pages::get_pages() as $page_info ) {
			if ( $page_info['in-menu'] ) {
				continue;
			}
			if ( is_numeric( strpos( $current_screen->base, $page_info['slug'] ) ) ) {
				$parent_file = $page_info['parent'];
				$submenu_file = 'clientside-options-general';
				return $parent_file;
			}
		}

		// Return
		return $parent_file;

	}

	// Remove Updates page from the admin menu
	static function action_remove_update_menu() {
		remove_submenu_page( 'index.php', 'update-core.php' );
	}

	// Add numbers to certain menu items
	static function action_add_numbers() {

		// Only if admin theming is enabled
		if ( ! Clientside_Options::get_saved_option( 'enable-admin-theme' ) ) {
			return;
		}

		global $menu;

		// Each main menu item
		foreach ( $menu as $item_key => $item ) {

			if ( ! isset( $item[2] ) ) {
				continue;
			}

			$item_slug = $item[2];
			$item_title = $item[0];

			// Only continue if it doesn't already have a number
			// Except if that number is 0 (comments awaiting moderation)
			if ( is_numeric( strpos( $item_title, '<' ) ) && ! is_numeric( strpos( $item_title, 'count-0' ) ) ) {
				continue;
			}

			// Post types: Get number of published posts
			if ( is_numeric( strpos( $item_slug, 'edit.php' ) ) ) {
				$post_type = explode( 'post_type=', $item_slug );
				$post_type = isset( $post_type[1] ) ? $post_type[1] : 'post';
				$post_count = wp_count_posts( $post_type );
				$post_count = $post_count->publish;
			}

			// Media: Get total file count
			else if ( $item_slug == 'upload.php' ) {
				$post_count = get_children(
					array(
						'post_parent' => null,
						'post_type' => 'attachment',
						'fields' => 'ids'
					)
				);
				$post_count = count( $post_count );
			}

			// Comments: Get total number of comments
			else if ( $item_slug == 'edit-comments.php' ) {
				$post_count = wp_count_comments();
				$post_count = $post_count->total_comments;
			}

			// Users: Get number of users
			else if ( $item_slug == 'users.php' ) {
				$post_count = count_users();
				$post_count = $post_count['total_users'];
			}

			// Plugins: Get number of plugins
			else if ( $item_slug == 'plugins.php' ) {
				$post_count = get_plugins();
				$post_count = count( $post_count );
			}

			else {
				continue;
			}

			// Format & display
			$post_count_display = $post_count > 999 ? '999+' : $post_count;
			$menu[ $item_key ][0] .= '<span class="clientside-menu-number" title="' . esc_attr( $post_count . ' ' . $item_title ) . '">' . $post_count_display . '</span>';

		}

	}

}
?>
