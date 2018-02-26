<div id="container" class="wrap wrap-wds wds-page wds-page-autolinks">

	<section id="header">
		<?php $this->_render( 'settings-message-top' ); ?>
		<h1><?php esc_html_e( 'Social' , 'wds' ); ?></h1>
	</section><!-- end header -->

	<form action='<?php echo esc_attr( $_view['action_url'] ); ?>' method='post' class="wds-form">
		<?php settings_fields( $_view['option_name'] ); ?>

		<div class="vertical-tabs">
			<?php
				$this->_render('vertical-tab', array(
					'tab_id'       => 'tab_accounts',
					'tab_name'     => __( 'Accounts', 'wds' ),
					'is_active'    => $active_tab == 'tab_accounts',
					'tab_sections' => array(
						array(
							'section_description' => __( 'Let search engines know whether you’re an organization or a person, then add all your social profiles so search engines know which social profiles to attribute your web content to.', 'wds' ),
							'section_template'    => 'social/social-section-accounts',
							'section_args'        => array(
								'options' => $options,
							),
						),
					),
				));
			?>

			<?php
				$this->_render('vertical-tab', array(
					'tab_id'       => 'tab_open_graph',
					'tab_name'     => __( 'OpenGraph', 'wds' ),
					'is_active'    => $active_tab == 'tab_open_graph',
					'tab_sections' => array(
						array(
							'section_description' => __( 'Add meta data to your pages to make them look great when shared platforms such as Facebook and other popular social networks.', 'wds' ),
							'section_template'    => 'social/social-section-open-graph',
							'section_args'        => array(
								'options' => $options,
							),
						),
					),
				));
			?>

			<?php
				$this->_render('vertical-tab', array(
					'tab_id'       => 'tab_twitter_cards',
					'tab_name'     => __( 'Twitter Cards', 'wds' ),
					'is_active'    => $active_tab == 'tab_twitter_cards',
					'tab_sections' => array(
						array(
							'section_description' => __( 'Add meta data to your pages to make them look great when shared on Twitter.', 'wds' ),
							'section_template'    => 'social/social-section-twitter-cards',
							'section_args'        => array(
								'options' => $options,
							),
						),
					),
				));
			?>

			<?php
				$this->_render('vertical-tab', array(
					'tab_id'       => 'tab_pinterest_verification',
					'tab_name'     => __( 'Pinterest Verification', 'wds' ),
					'is_active'    => $active_tab == 'tab_pinterest_verification',
					'tab_sections' => array(
						array(
							'section_description' => __( 'Verify your website with Pinterest to attribute your website when your website content is pinned to the platform.', 'wds' ),
							'section_template'    => 'social/social-section-pinterest-verification',
							'section_args'        => array(
								'options' => $options,
							),
						),
					),
				));
			?>
		</div>
	</form>
</div>