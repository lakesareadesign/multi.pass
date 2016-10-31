<section id="wd-blacklist-widget" class="dev-box wd-blacklist-widget">
	<div class="box-title">
		<h3><?php esc_html_e( "Blacklist Monitoring", wp_defender()->domain ) ?></h3>
	</div>
	<div class="box-content">
		<h2 class="wd-title"><?php esc_html_e( "Activating Monitoring", wp_defender()->domain ) ?></h2>
		<p><?php esc_html_e( "Please wait a minute while we enable blacklist monitoring for your site.", wp_defender()->domain ) ?></p>
		<div
			class="wd-progress animate">
					<span
						style="width: 100%"></span>
		</div>
		<span class="current_working"><?php esc_html_e("Checking blacklists...",wp_defender()->domain) ?></span>
	</div>
</section>