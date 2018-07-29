<div id="container" class="wrap wrap-wds wds-page wds-page-autolinks">

	<section id="header">
		<div class="actions">
			<a target="_blank" class="button button-small button-light actions-button"
			   href="https://premium.wpmudev.org/docs/wpmu-dev-plugins/smartcrawl/#chapter-5">
				<i class="wds-icon-academy"></i>
				<?php esc_html_e( 'View Documentation', 'wds' ); ?>
			</a>
		</div>

		<?php $this->_render( 'settings-message-top' ); ?>
		<h1><?php esc_html_e( 'Advanced Tools', 'wds' ); ?></h1>
	</section><!-- end header -->

	<div>
		<div class="cf"></div>
		<div class="vertical-tabs">
			<?php
			$autolinks_disabled_section = array(
				array(
					'section_template' => 'disabled-component-inner',
					'section_args'     => array(
						'content'         => sprintf(
							'%s<br/>%s<br/>%s',
							__( 'Configure SmartCrawl to automatically link certain key words to a page on your blog or even', 'wds' ),
							__( 'a whole new site all together. Internal linking can help boost SEO but giving search engines', 'wds' ),
							__( 'ample ways to index your site.', 'wds' )
						),
						'image'           => 'autolinking-disabled.png',
						'component'       => 'autolinks',
						'premium_feature' => true,
						'button_text'     => __( 'Activate Keyword Linking', 'wds' ),
					),
				),
			);

			$autolinks_sections = array(
				array(
					'section_title'       => __( 'Automatic Links', 'wds' ),
					'section_description' => __( 'SmartCrawl will look for keywords that match posts/pages around your website and automatically link them. Specify what post types you want to include in this tool, and what post types you want those to automatically link to.', 'wds' ),
					'section_template'    => 'advanced-tools/advanced-section-automatic-linking',
					'section_args'        => array(
						'insert' => $insert,
						'linkto' => $linkto,
					),
				),
				array(
					'section_title'       => __( 'Settings', 'wds' ),
					'section_description' => __( 'Control the overall linking engine to work how you want it to.', 'wds' ),
					'section_template'    => 'advanced-tools/advanced-section-automatic-linking-settings',
					'section_args'        => array(
						'additional_settings' => array(
							'allow_empty_tax'                => array(
								'label'       => __( 'Allow autolinks to empty taxonomies', 'wds' ),
								'description' => __( 'Allows autolinking to taxonomies that have no posts assigned to them.', 'wds' ),
							),
							'excludeheading'                 => array(
								'label'       => __( 'Prevent linking in heading tags', 'wds' ),
								'description' => __( 'Excludes headings from autolinking.', 'wds' ),
							),
							'onlysingle'                     => array(
								'label'       => __( 'Process only single posts and pages', 'wds' ),
								'description' => __( 'Process only single posts and pages', 'wds' ),
							),
							'allowfeed'                      => array(
								'label'       => __( 'Process RSS feeds', 'wds' ),
								'description' => __( 'Autolinking will also occur in RSS feeds.', 'wds' ),
							),
							'casesens'                       => array(
								'label'       => __( 'Case sensitive matching', 'wds' ),
								'description' => __( 'Only autolink the exact string match.', 'wds' ),
							),
							'customkey_preventduplicatelink' => array(
								'label'       => __( 'Prevent duplicate links', 'wds' ),
								'description' => __( 'Only link to a specific URL once per page/post.', 'wds' ),
							),
							'target_blank'                   => array(
								'label'       => __( 'Open links in new tab', 'wds' ),
								'description' => __( 'Adds the target=“_blank” tag to links to open a new tab when clicked.', 'wds' ),
							),
							'rel_nofollow'                   => array(
								'label'       => __( 'Nofollow autolinks', 'wds' ),
								'description' => __( 'Adds the nofollow meta tag to autolinks to prevent search engines following those URLs when crawling your website.', 'wds' ),
							),
						),
					),
				),
			);

			$autolinks_network_enabled = smartcrawl_is_allowed_tab( $_view['slug'] );
			$autolinks_locally_enabled = 'settings' === $_view['name'] || Smartcrawl_Settings::get_setting( $_view['name'] );
			$is_member = Smartcrawl_Service::get( Smartcrawl_Service::SERVICE_SITE )->is_member();

			if ( $autolinks_network_enabled ) {

				$autolinks_tab = array(
					'tab_id'        => 'tab_automatic_linking',
					'tab_name'      => __( 'Automatic Linking', 'wds' ),
					'is_active'     => 'tab_automatic_linking' === $active_tab,
					'tab_sections'  => $autolinks_locally_enabled && $is_member ? $autolinks_sections : $autolinks_disabled_section,
					'before_output' => $this->_load( '_forms/autolinks', array(
						'autolinks_network_enabled' => $autolinks_network_enabled,
						'autolinks_locally_enabled' => $autolinks_locally_enabled,
					) ),
					'after_output'  => '</form>',
				);

				if ( ! $autolinks_locally_enabled || ! $is_member ) {
					$autolinks_tab['button_text'] = false;
				}

				$this->_render( 'vertical-tab', $autolinks_tab );
			}
			?>

			<?php
			$this->_render( 'vertical-tab', array(
				'tab_id'        => 'tab_url_redirection',
				'tab_name'      => __( 'URL Redirection', 'wds' ),
				'is_active'     => 'tab_url_redirection' === $active_tab,
				'tab_sections'  => array(
					array(
						'section_description' => __( 'Automatically redirect traffic from one URL to another. Use this tool if you have changed a page’s URL and wish to keep traffic flowing to the new page.', 'wds' ),
						'section_template'    => 'advanced-tools/advanced-section-redirects',
						'section_args'        => array(
							'redirections' => $redirections,
							'types'        => $redirection_types,
						),
					),
				),
				'before_output' => $this->_load( '_forms/redirections' ),
				'after_output'  => '</form>',
			) );
			?>

			<?php
			$this->_render( 'vertical-tab', array(
				'tab_id'        => 'tab_moz',
				'tab_name'      => __( 'Moz', 'wds' ),
				'is_active'     => 'tab_moz' === $active_tab,
				'button_text'   => false,
				'tab_sections'  => array(
					array(
						'section_template' => 'advanced-tools/advanced-section-moz',
						'section_args'     => array(),
					),
				),
				'before_output' => '<form method="post" class="wds-form">',
				'after_output'  => '</form>',
			) );
			?>
		</div>
	</div>
	<?php $this->_render( 'upsell-modal' ); ?>

</div><!-- end wds-page-autolinks -->