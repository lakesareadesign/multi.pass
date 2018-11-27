<dialog class="auto-show wds-modal wds-onboard-dialog" id="wds-onboarding"
        data-title="<?php esc_attr_e( 'Quick setup', 'wds' ); ?>">
	<div class="intro">
		<p>
			<?php esc_html_e( "Welcome to SmartCrawl, the hottest SEO plugin for WordPress! Let's quickly set up the basics for you, then you can fine tune each setting as you go - our recommendations are on by default.", 'wds' ); ?>
		</p>
	</div>

	<?php $service = Smartcrawl_Service::get( Smartcrawl_Service::SERVICE_SITE ); ?>

	<div class="wds-separator-top wds-onboarding-item">
		<?php if ( $service->is_member() ) : ?>
			<?php
			$this->_render( 'toggle-item', array(
				'field_name'       => 'checkup-enable',
				'item_label'       => esc_html__( 'Automatic SEO Checkups & Reporting', 'wds' ),
				'item_description' => esc_html__( 'Schedule daily, weekly or monthly comprehensive checkups of your homepage SEO and have the results emailed to your inbox', 'wds' ),
				'attributes'       => array(
					'data-processing' => esc_attr__( 'Activating Automatic SEO Checkups & Reporting', 'wds' ),
					'checked'         => true,
				),
			) );
			?>
		<?php else : ?>
			<?php
			$this->_render( 'toggle-item', array(
				'field_name'       => 'checkup-run',
				'item_label'       => esc_html__( 'Run a full SEO Checkup', 'wds' ),
				'item_description' => esc_html__( 'Get a comprehensive checkup of your homepage and have the results emailed to your inbox.', 'wds' ),
				'attributes'       => array(
					'data-processing' => esc_attr__( 'Running a full SEO Checkup', 'wds' ),
					'checked'         => true,
				),
			) );
			?>
		<?php endif; ?>
	</div>

	<div class="wds-separator-top wds-onboarding-item">
		<?php
		$this->_render( 'toggle-item', array(
			'field_name'       => 'analysis-enable',
			'item_label'       => esc_html__( 'SEO & Readability Analysis', 'wds' ),
			'item_description' => esc_html__( 'Have your pages and posts analyzed for SEO and readability improvements to improve your search ranking', 'wds' ),
			'attributes'       => array(
				'data-processing' => esc_attr__( 'Activating SEO & Readability Analysis', 'wds' ),
				'checked'         => true,
			),
		) );
		?>
	</div>

	<div class="wds-separator-top wds-onboarding-item">
		<?php
		$this->_render( 'toggle-item', array(
			'field_name'       => 'opengraph-enable',
			'item_label'       => esc_html__( 'OpenGraph', 'wds' ),
			'item_description' => esc_html__( 'OpenGraph support enhances how your content appears when shared on social networks such as Facebook', 'wds' ),
			'attributes'       => array(
				'data-processing' => esc_attr__( 'Activating OpenGraph', 'wds' ),
				'checked'         => true,
			),
		) );
		?>
	</div>

	<div class="wds-separator-top wds-onboarding-item">
		<?php
		$this->_render( 'toggle-item', array(
			'field_name'       => 'sitemaps-enable',
			'item_label'       => esc_html__( 'Sitemaps', 'wds' ),
			'item_description' => esc_html__( 'Sitemaps expose your site content to search engines and allow them to discover it more easily.', 'wds' ),
			'attributes'       => array(
				'data-processing' => esc_attr__( 'Activating Sitemaps', 'wds' ),
				'checked'         => true,
			),
		) );
		?>
	</div>

	<div class="wds-separator-top wds-onboarding-item">
		<?php
		$this->_render( 'toggle-item', array(
			'field_name'       => 'twitter-enable',
			'item_label'       => esc_html__( 'Twitter Cards', 'wds' ),
			'item_description' => esc_html__( 'With Twitter Cards, you can attach rich photos, videos and media experiences to Tweets, helping drive traffic to your site.', 'wds' ),
			'attributes'       => array(
				'data-processing' => esc_attr__( 'Activating Twitter Cards', 'wds' ),
				'checked'         => true,
			),
		) );
		?>
	</div>

	<div class="wds-separator-top">
		<div class="wds-notice wds-notice-info">
			<p class="wds-small-text">
				<?php esc_html_e( 'These services will be configured with recommended settings.', 'wds' ); ?>
				<?php esc_html_e( 'You can change these at any time.', 'wds' ); ?>
			</p>
		</div>
	</div>

	<div class="action wds-box-footer">
		<button class="button button-dark button-dark-o onboard-skip" type="button">
			<?php esc_html_e( 'Skip', 'wds' ); ?>
		</button>

		<button type="button" class="button wds-onboarding-setup">
			<?php esc_html_e( 'Get started', 'wds' ); ?>
		</button>
	</div>
</dialog>