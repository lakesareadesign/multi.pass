<div id="container" class="wrap wrap-wds wds-page wds-page-autolinks">
	<section id="header">
		<?php $this->_render( 'settings-message-top' ); ?>
		<div class="actions">
			<a href="#show-supported-macros-modal" rel="dialog" class="button button-small button-light actions-button"><?php esc_html_e( 'Browse Macros', 'wds' ); ?></a>
		</div>
		<h1><?php esc_html_e( 'Title & Meta' , 'wds' ); ?></h1>
	</section><!-- end header -->

	<dialog class="wds-modal" id="show-supported-macros-modal" title="<?php esc_html_e( 'Supported Macros', 'wds' ); ?>">
		<div id="wds-show-supported-macros">
			<table class="wds-data-table wds-data-table-inverse-large">
				<thead>
					<tr>
						<th class="label"><?php esc_html_e( 'Title' , 'wds' ); ?></th>
						<th class="result"><?php esc_html_e( 'Gets Replaced By' , 'wds' ); ?></th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th class="label"><?php esc_html_e( 'Title' , 'wds' ); ?></th>
						<th class="result"><?php esc_html_e( 'Gets Replaced By' , 'wds' ); ?></th>
					</tr>
				</tfoot>
				<tbody>

					<?php foreach ( $macros as $macro => $label ) { ?>
						<tr>
							<td class="data data-small"><?php echo esc_html( $macro ); ?></td>
							<td class="data data-small"><?php echo esc_html( $label ); ?></td>
						</tr>
					<?php } ?>

				</tbody>
			</table>
		</div>
	</dialog><!-- end run-seo-analysis-modal -->

<?php
	$smartcrawl_options = Smartcrawl_Settings::get_options();
if ( ! smartcrawl_is_allowed_tab( $_view['slug'] ) ) {
	printf( __( "Your network admin prevented access to '%s', please move onto next step.", 'wds' ), __( 'Title & Meta' , 'wds' ) );
} elseif ( 'settings' === $_view['name'] || ( ! empty( $smartcrawl_options[ $_view['name'] ] ) ) ) {

?>
<form action='<?php echo esc_attr( $_view['action_url'] ); ?>' method='post' class="wds-form">
<?php settings_fields( $_view['option_name'] ); ?>

<input type="hidden" name='<?php echo esc_attr( $_view['option_name'] ); ?>[<?php echo esc_attr( $_view['slug'] ); ?>-setup]' value="1">

<div class="vertical-tabs" id="page-title-meta-tabs">
	<?php
		/*
		 * Homepage tab
		 */
		$this->_render('vertical-tab', array(
			'tab_id'       => 'tab_homepage',
			'tab_name'     => __( 'Homepage', 'wds' ),
			'is_active'    => $active_tab == 'tab_homepage',
			'tab_sections' => array(
				array(
					'section_description' => __( 'Customize your homepage title, description and meta.', 'wds' ),
					'section_type'        => 'homepage',
					'section_template'    => 'onpage/onpage-section-homepage',
					'section_args'        => array(
						'homepage_title'                => $homepage_title,
						'homepage_description'          => $homepage_description,
						'show_homepage_options'         => $show_homepage_options,
						'meta_robots_main_blog_archive' => $meta_robots_main_blog_archive,
					),
				),
			),
		));

		/*
		 * Post types tab
		 */
		$post_type_sections = array();
		foreach ( get_post_types( array( 'public' => true ) ) as $post_type ) {
			if ( in_array( $post_type, array( 'revision', 'nav_menu_item' ) ) ) {
				continue;
			}

			$post_type_object = get_post_type_object( $post_type );

			$post_type_sections[] = array(
				'section_title'       => $post_type_object->labels->name,
				'section_description' => __( sprintf( 'Customize your %s title, description and meta.', $post_type_object->labels->singular_name ), 'wds' ),
				'section_type'        => $post_type,
				'section_template'    => 'onpage/onpage-section-post-type',
				'section_args'        => array(
					'post_type'        => $post_type,
					'post_type_object' => $post_type_object,
					'post_type_robots' => ( ! empty( $post_robots[ $post_type ] ) ? $post_robots[ $post_type ] : array()),
				),
			);
		}

		$this->_render('vertical-tab', array(
			'tab_id'       => 'tab_post_types',
			'tab_name'     => __( 'Post Types', 'wds' ),
			'is_active'    => $active_tab == 'tab_post_types',
			'tab_sections' => $post_type_sections,
		));

		/*
		 * Other taxonomies
		 */
		$taxonomy_sections = array();
		$taxonomies = array_merge(
			array( 'post_tag', 'category' ),
			get_taxonomies( array( '_builtin' => false ) )
		);
	foreach ( $taxonomies as $taxonomy_name ) {
		$taxonomy = get_taxonomy( $taxonomy_name );
		$meta_robots_taxonomy_name = 'meta_robots_' . str_replace( '-', '_', $taxonomy->name );
		$taxonomy_sections[] = array(
		'section_title'       => $taxonomy->label,
		'section_description' => sprintf( __( 'Customize the title, description and meta of %s.', 'wds' ), $taxonomy->label ),
		'section_type'        => $taxonomy->name,
		'section_template'    => 'onpage/onpage-section-taxonomy',
		'section_args'        => array(
		'taxonomy'    => $taxonomy,
		'meta_robots' => $$meta_robots_taxonomy_name,
		),
		);
	}

		$this->_render('vertical-tab', array(
			'tab_id'       => 'tab_taxonomies',
			'tab_name'     => __( 'Taxonomies', 'wds' ),
			'is_active'    => $active_tab == 'tab_taxonomies',
			'tab_sections' => $taxonomy_sections,
		));

		/*
		 * Archives
		 */
		$this->_render('vertical-tab', array(
			'tab_id'       => 'tab_archives',
			'tab_name'     => __( 'Archives', 'wds' ),
			'is_active'    => $active_tab == 'tab_archives',
			'tab_sections' => array(
				// Author archive
				array(
					'section_title'          => __( 'Author Archive', 'wds' ),
					'section_description'    => __( 'If you are the only author of your website content Google may see your author archives as duplicate content to your Blog Homepage. If this is the case we recommend disabling author archives.', 'wds' ),
					'section_type'           => 'author-archive',
					'section_template'       => 'onpage/onpage-section-author-archive',
					'section_enabled_option' => 'enable-author-archive',
					'section_args'           => array(
						'meta_robots_author' => $meta_robots_author,
					),
				),
				// Date archive
				array(
					'section_title'          => __( 'Date Archive', 'wds' ),
					'section_description'    => __( 'Google may see your date archives as duplicate content to your Blog Homepage. For this reason we recommend disabling date archives.', 'wds' ),
					'section_type'           => 'date-archive',
					'section_template'       => 'onpage/onpage-section-date-archive',
					'section_enabled_option' => 'enable-date-archive',
					'section_args'           => array(
						'meta_robots_date' => $meta_robots_date,
					),
				),
				// Search page
				array(
					'section_title'       => __( 'Search Page', 'wds' ),
					'section_description' => __( 'Customize your search page title, description and meta.', 'wds' ),
					'section_type'        => 'search-page',
					'section_template'    => 'onpage/onpage-section-search',
					'section_args'        => array(
						'meta_robots_search' => $meta_robots_search,
					),
				),
				// 404 page
				array(
					'section_title'       => __( '404 Page', 'wds' ),
					'section_description' => __( 'Customize your 404 page title, description and meta.', 'wds' ),
					'section_type'        => '404-page',
					'section_template'    => 'onpage/onpage-section-404',
					'section_args'        => array(),
				),
			),
		));

		$buddypress_sections = array();

		if ( function_exists( 'groups_get_groups' ) && (is_network_admin() || is_main_site()) ) {
			$buddypress_sections[] = array(
				'section_title'       => __( 'BuddyPress Groups', 'wds' ),
				'section_description' => __( 'Customize your BuddyPress group title, description and meta options.', 'wds' ),
				'section_type'        => 'bp-group',
				'section_template'    => 'onpage/onpage-section-buddypress-groups',
				'section_args'        => array(),
			);
		}

		if ( defined( 'BP_VERSION' ) && (is_network_admin() || is_main_site()) ) {
			$buddypress_sections[] = array(
				'section_title'       => __( 'BuddyPress Profile', 'wds' ),
				'section_description' => __( 'Customize your BuddyPress profile title, description and meta options.', 'wds' ),
				'section_type'        => 'bp-profile',
				'section_template'    => 'onpage/onpage-section-buddypress-profile',
				'section_args'        => array(),
			);
		}

		if ( $buddypress_sections ) {
			$this->_render('vertical-tab', array(
				'tab_id'       => 'tab_buddypress',
				'tab_name'     => __( 'BuddyPress', 'wds' ),
				'is_active'    => $active_tab == 'tab_buddypress',
				'tab_sections' => $buddypress_sections,
			));
		}
		?>

		<?php
		$this->_render('onpage/onpage-marketpress-tabs', array(
			'active_tab' => $active_tab,
			'wds_options' => $smartcrawl_options,
		));
		?>

		<?php
		$this->_render('vertical-tab', array(
			'tab_id'       => 'tab_settings',
			'tab_name'     => __( 'Settings', 'wds' ),
			'is_active'    => $active_tab == 'tab_settings',
			'tab_sections' => array(
				array(
					'section_type'        => '',
					'section_template'    => 'onpage/onpage-section-settings',
					'section_args'        => array(
						'separators' => $separators,
					),
				),
			),
		));
		?>

		</div><!-- end page-title-meta-tabs -->

	</form>

	<?php // echo $additional; ?>

<?php

} else {
	printf( __( "You've chosen not to set up '%s', please move onto next step.", 'wds' ), __( 'Title & Meta' , 'wds' ) );
}

?>

</div><!-- end wds-page-onpage -->