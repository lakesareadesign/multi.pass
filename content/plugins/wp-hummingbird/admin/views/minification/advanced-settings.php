<div class="wphb-notice wphb-notice-success hidden" id="wphb-notice-minification-advanced-settings-updated">
	<p><?php _e( 'Settings updated', 'wphb' ); ?></p>
</div>
<div class="toggle-item">

	<div class="toggle-item-group">
		<div class="toggle-item-info">
			<p class="toggle-item-title"><?php _e( 'Super-minify my files', 'wphb' ); ?></p>
			<p class="toggle-item-description"><?php _e( 'Compress your files up to 2x more than regular optimization and reduce your page load speed even further.', 'wphb' ); ?></p>
		</div><!-- end toggle-item-info -->

		<div class="toggle-actions">
			<?php if ( $super_minify ): ?>
				<span class="wphb-label wphb-label-disabled"><?php _e( 'Enabled', 'wphb' ); ?></span>
			<?php else: ?>
				<span class="toggle" tooltip="<?php _e( 'Enable Super-minify my files', 'wphb' ); ?>">
					<input type="checkbox" class="toggle-checkbox" name="super_minify_files" id="super_minify_files" <?php checked( $use_cdn ); ?> <?php disabled( $disabled ); ?>>
					<label for="super_minify_files" class="toggle-label"></label>
				</span>
			<?php endif; ?>
		</div><!-- end toggle-actions -->
	</div><!-- end toggle-item-group -->

</div><!-- end toggle-item -->

<div class="toggle-item bordered space-top">

	<div class="toggle-item-group">
		<div class="toggle-item-info">
			<p class="toggle-item-title"><?php _e( 'Store my files on the WPMU DEV CDN', 'wphb' ); ?></p>
			<p class="toggle-item-description"><?php _e( 'By default we minify your files via our API and then send back to your server. With this setting enabled we will host your files on WPMU DEV\'s secure and hyper fast CDN which will mean less load on your server and a fast visitor experience.', 'wphb' ); ?></p>
		</div><!-- end toggle-item-info -->

		<div class="toggle-actions">
			<span class="toggle" tooltip="<?php _e( 'Enable WPMU DEV CDN', 'wphb' ); ?>">
				<input type="checkbox" class="toggle-checkbox" name="use_cdn" id="use_cdn" <?php checked( $use_cdn ); ?> <?php disabled( $disabled ); ?>>
				<label for="use_cdn" class="toggle-label"></label>
			</span>
		</div><!-- end toggle-actions -->
	</div><!-- end toggle-item-group -->

</div><!-- end toggle-item -->