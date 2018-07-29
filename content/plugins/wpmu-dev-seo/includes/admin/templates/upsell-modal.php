<dialog id="wds-upsell-modal"
        class="dev-overlay wds-modal wds-upsell-modal"
        title="<?php esc_attr_e( 'Upgrade To Pro', 'wds' ); ?>">

	<div class="box-content modal">
		<p><?php esc_html_e( 'Here’s what you’ll get by uprading to SmartCrawl Pro', 'wds' ); ?></p>

		<ul class="wds-upgrade-benefits-list">
			<li>
				<span class="wds-strong-text"><?php esc_attr_e( 'Automatic SEO Checkups & Reporting', 'wds' ); ?></span>
				<p class="wds-small-text"><?php esc_attr_e( 'Schedule daily, weekly or monthly comprehensive checkups of your homepage SEO and have the results emailed to your inbox.', 'wds' ); ?></p>
			</li>
			<li>
				<span class="wds-strong-text"><?php esc_attr_e( 'Schedule Sitemap Crawls', 'wds' ); ?></span>
				<p class="wds-small-text"><?php esc_attr_e( 'Set SmartCrawl to automatically check your website for broken URLs daily, weekly or monthly and send you an email with any issues she encounters.', 'wds' ); ?></p>
			</li>
			<li>
				<span class="wds-strong-text"><?php esc_attr_e( 'Automatic Linking', 'wds' ); ?></span>
				<p class="wds-small-text"><?php esc_attr_e( 'Configure SmartCrawl to automatically link certain key words to a page on your blog or even a whole new site all together.', 'wds' ); ?></p>
			</li>
			<li>
				<span class="wds-strong-text"><?php esc_attr_e( 'Smush Pro', 'wds' ); ?></span>
				<p class="wds-small-text"><?php esc_attr_e( 'A membership for Hummingbird Pro also gets you the award winning Smush Pro with unlimited advanced lossy compression that’ll give image heavy websites a speed boost.', 'wds' ); ?></p>
			</li>
		</ul>

		<p style="text-align: center">
			<?php esc_html_e( 'Get all of this, plus heaps more as a part of a WPMU DEV membership.', 'wds' ); ?>
		</p>

		<p style="text-align: center">
			<button class="wds-navigate-to-pro button-green"
			        data-target="<?php echo esc_url( 'https://premium.wpmudev.org/project/smartcrawl-wordpress-seo/?campaign=wds_modal_upgrade&source=smartcrawl&medium=plugin' ); ?>">

				<?php esc_html_e( 'Upgrade to Pro', 'wds' ); ?>
			</button>
		</p>

	</div>

</dialog>