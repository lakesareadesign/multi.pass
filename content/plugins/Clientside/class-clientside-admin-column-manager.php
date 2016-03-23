<?php
/*
 * Clientside Admin Column Manager class
 * Contains method to build the Admin Column Manager tool and perform the role-based hiding of columns
 */

class Clientside_Admin_Column_Manager {

	// Return (array) list of admin column slugs for a specified page, optionally with a prefix
	static function get_column_slugs( $page_slug = 'posts', $prefix = 'admin-column-manager-posts-' ) {

		$columns = self::get_column_info( $page_slug );
		$column_slugs = array();

		foreach ( $columns as $column_slug => $column_info ) {
			$column_slugs[] = $prefix . $column_slug;
		}

		return $column_slugs;

	}

	// Return (string) page name to display as option section title
	static function get_page_name( $page_slug = 'posts' ) {

		$page_names = array(
			'posts' => __( 'Posts' ),
			'pages' => __( 'Pages' ),
			'media' => __( 'Media' ),
			'users' => __( 'Users' )
		);

		// Return
		return isset( $page_names[ $page_slug ] ) ? $page_names[ $page_slug ] : '';

	}

	// Return (array) all manageble admin columns' info
	static function get_column_info( $page = '' ) {

		$columns = array(
			'posts' => array(
				'author' => array(
					'field' => array(
						'name' => 'admin-column-manager-posts-author',
						'title' => _x( 'Author', 'Admin column title', 'clientside' ),
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
				'categories' => array(
					'field' => array(
						'name' => 'admin-column-manager-posts-categories',
						'title' => _x( 'Categories', 'Admin column title', 'clientside' ),
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
				'tags' => array(
					'field' => array(
						'name' => 'admin-column-manager-posts-tags',
						'title' => _x( 'Tags', 'Admin column title', 'clientside' ),
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
				'comments' => array(
					'field' => array(
						'name' => 'admin-column-manager-posts-comments',
						'title' => _x( 'Comments', 'Admin column title', 'clientside' ),
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
				'date' => array(
					'field' => array(
						'name' => 'admin-column-manager-posts-date',
						'title' => _x( 'Date', 'Admin column title', 'clientside' ),
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
				)
			),
			'pages' => array(
				'author' => array(
					'field' => array(
						'name' => 'admin-column-manager-pages-author',
						'title' => _x( 'Author', 'Admin column title', 'clientside' ),
						'type' => 'checkbox',
						'role-based' => true,
						'disabled-for' => array(
							'subscriber',
							'contributor',
							'author'
						),
						'default' => array(
							'clientside-default' => 1,
							'subscriber' => 0,
							'contributor' => 0,
							'author' => 0
						)
					)
				),
				'comments' => array(
					'field' => array(
						'name' => 'admin-column-manager-pages-comments',
						'title' => _x( 'Comments', 'Admin column title', 'clientside' ),
						'type' => 'checkbox',
						'role-based' => true,
						'disabled-for' => array(
							'subscriber',
							'contributor',
							'author'
						),
						'default' => array(
							'clientside-default' => 1,
							'subscriber' => 0,
							'contributor' => 0,
							'author' => 0
						)
					)
				),
				'date' => array(
					'field' => array(
						'name' => 'admin-column-manager-pages-date',
						'title' => _x( 'Date', 'Admin column title', 'clientside' ),
						'type' => 'checkbox',
						'role-based' => true,
						'disabled-for' => array(
							'subscriber',
							'contributor',
							'author'
						),
						'default' => array(
							'clientside-default' => 1,
							'subscriber' => 0,
							'contributor' => 0,
							'author' => 0
						)
					)
				)
			),
			'media' => array(
				'icon' => array(
					'field' => array(
						'name' => 'admin-column-manager-media-icon',
						'title' => _x( 'File icon / thumbnail preview', 'Admin column title', 'clientside' ),
						'type' => 'checkbox',
						'role-based' => true,
						'disabled-for' => array(
							'subscriber',
							'contributor'
						),
						'default' => array(
							'clientside-default' => 1,
							'subscriber' => 0,
							'contributor' => 0
						)
					)
				),
				'author' => array(
					'field' => array(
						'name' => 'admin-column-manager-media-author',
						'title' => _x( 'Author', 'Admin column title', 'clientside' ),
						'type' => 'checkbox',
						'role-based' => true,
						'disabled-for' => array(
							'subscriber',
							'contributor'
						),
						'default' => array(
							'clientside-default' => 1,
							'subscriber' => 0,
							'contributor' => 0
						)
					)
				),
				'parent' => array(
					'field' => array(
						'name' => 'admin-column-manager-media-parent',
						'title' => _x( 'Uploaded to', 'Admin column title', 'clientside' ),
						'type' => 'checkbox',
						'role-based' => true,
						'disabled-for' => array(
							'subscriber',
							'contributor'
						),
						'default' => array(
							'clientside-default' => 1,
							'subscriber' => 0,
							'contributor' => 0
						)
					)
				),
				'comments' => array(
					'field' => array(
						'name' => 'admin-column-manager-media-comments',
						'title' => _x( 'Comments', 'Admin column title', 'clientside' ),
						'type' => 'checkbox',
						'role-based' => true,
						'disabled-for' => array(
							'subscriber',
							'contributor'
						),
						'default' => array(
							'clientside-default' => 1,
							'subscriber' => 0,
							'contributor' => 0
						)
					)
				),
				'date' => array(
					'field' => array(
						'name' => 'admin-column-manager-media-date',
						'title' => _x( 'Date', 'Admin column title', 'clientside' ),
						'type' => 'checkbox',
						'role-based' => true,
						'disabled-for' => array(
							'subscriber',
							'contributor'
						),
						'default' => array(
							'clientside-default' => 1,
							'subscriber' => 0,
							'contributor' => 0
						)
					)
				)
			),
			'users' => array(
				'username' => array(
					'field' => array(
						'name' => 'admin-column-manager-users-username',
						'help' => __( 'The user\'s username and avatar', 'clientside' ),
						'title' => __( 'Username' ),
						'type' => 'checkbox',
						'role-based' => true,
						'disabled-for' => array(
							'subscriber',
							'contributor',
							'author',
							'editor'
						),
						'default' => array(
							'clientside-default' => 1,
							'subscriber' => 0,
							'contributor' => 0,
							'author' => 0,
							'editor' => 0
						)
					)
				),
				'name' => array(
					'field' => array(
						'name' => 'admin-column-manager-users-name',
						'title' => _x( 'Name', 'Admin column title', 'clientside' ),
						'help' => __( 'The user\'s full name', 'clientside' ),
						'type' => 'checkbox',
						'role-based' => true,
						'disabled-for' => array(
							'subscriber',
							'contributor',
							'author',
							'editor'
						),
						'default' => array(
							'clientside-default' => 1,
							'subscriber' => 0,
							'contributor' => 0,
							'author' => 0,
							'editor' => 0
						)
					)
				),
				'email' => array(
					'field' => array(
						'name' => 'admin-column-manager-users-email',
						'title' => _x( 'E-mail', 'Admin column title', 'clientside' ),
						'type' => 'checkbox',
						'role-based' => true,
						'disabled-for' => array(
							'subscriber',
							'contributor',
							'author',
							'editor'
						),
						'default' => array(
							'clientside-default' => 1,
							'subscriber' => 0,
							'contributor' => 0,
							'author' => 0,
							'editor' => 0
						)
					)
				),
				'role' => array(
					'field' => array(
						'name' => 'admin-column-manager-users-role',
						'title' => _x( 'Role', 'Admin column title', 'clientside' ),
						'type' => 'checkbox',
						'role-based' => true,
						'disabled-for' => array(
							'subscriber',
							'contributor',
							'author',
							'editor'
						),
						'default' => array(
							'clientside-default' => 1,
							'subscriber' => 0,
							'contributor' => 0,
							'author' => 0,
							'editor' => 0
						)
					)
				),
				'posts' => array(
					'field' => array(
						'name' => 'admin-column-manager-users-posts',
						'title' => _x( 'Posts', 'Admin column title', 'clientside' ),
						'help' => __( 'The user\'s post count', 'clientside' ),
						'type' => 'checkbox',
						'role-based' => true,
						'disabled-for' => array(
							'subscriber',
							'contributor',
							'author',
							'editor'
						),
						'default' => array(
							'clientside-default' => 1,
							'subscriber' => 0,
							'contributor' => 0,
							'author' => 0,
							'editor' => 0
						)
					)
				)
			)
		);

		// Return
		if ( $page ) {
			return isset( $columns[ $page ] ) ? $columns[ $page ] : array();
		}
		return $columns;

	}

	static function remove_page_columns( $page = 'posts', $original_columns = array() ) {

		$columns = self::get_column_info( $page );

		foreach ( $columns as $column_slug => $column_info ) {

			// Only if the to be removed column is in the current column set
			if ( ! isset( $original_columns[ $column_slug ] ) ) {
				continue;
			}

			// Remove column if role-based option is set to false
			if ( ! Clientside_Options::get_saved_option( 'admin-column-manager-' . $page . '-' . $column_slug ) ) {
				unset( $original_columns[ $column_slug ] );
			}

		}

		// Return
		return $original_columns;

	}

	// Apply the removal of post list columns if applicable to this role / page
	static function filter_remove_posts_columns( $columns ) {
		return self::remove_page_columns( 'posts', $columns );
	}

	// Apply the removal of page list columns if applicable to this role / page
	static function filter_remove_pages_columns( $columns ) {
		return self::remove_page_columns( 'pages', $columns );
	}

	// Apply the removal of user list columns if applicable to this role / page
	static function filter_remove_users_columns( $columns ) {
		return self::remove_page_columns( 'users', $columns );
	}

	// Apply the removal of media list columns if applicable to this role / page
	static function filter_remove_media_columns( $columns ) {
		return self::remove_page_columns( 'media', $columns );
	}

}
?>