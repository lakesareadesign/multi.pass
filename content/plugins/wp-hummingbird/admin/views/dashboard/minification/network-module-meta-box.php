<div class="wphb-block-entry">

	<div class="wphb-block-entry-content">

		<img class="wphb-image-icon-content wphb-image-icon-content-top wphb-image-icon-content-center" src="<?php echo wphb_plugin_url() . 'admin/assets/image/icon-minification-small.png'; ?>" alt="<?php _e('Minification', 'wphb'); ?>">

		<div class="content">
			<p><?php _e( 'Minification can be a bit daunting to configure for beginners, and has the potential to break the frontend of a site. You can choose here who can configure Minification options on subsites in your Multisite install.', 'wphb' ); ?></p>

			<div class="wphb-notice wphb-notice-success hidden" id="wphb-notice-minification-settings-updated">
				<p><?php _e( 'Minification settings updated', 'wphb' ); ?></p>
			</div>

			<?php if ( isset( $_GET['minify-instructions'] ) ): ?>
				<div class="wphb-notice wphb-notice-warning">
					<p><?php _e( 'Please, activate minification first. A new menu will appear in every site on your Network.', 'wphb' ); ?></p>
				</div>
			<?php endif; ?>

			<label for="wphb-activate-minification"><span class="screen-reader-text"><?php _e( 'Select users that can minify in this network', 'wphb' ); ?></span></label>
			<select name="wphb-activate-minification" id="wphb-activate-minification">
				<option value="false" <?php selected( wphb_get_setting( 'minify' ), false ); ?>><?php _e( 'Deactivate completely', 'wphb' ); ?></option>
				<option value="true" <?php selected( wphb_get_setting( 'minify' ), true ); ?>><?php _e( 'Blog Admins can minify', 'wphb' ); ?></option>
				<option value="super-admins" <?php selected( wphb_get_setting( 'minify' ), 'super-admins' ); ?>><?php _e( 'Only Super Admins can minify', 'wphb' ); ?></option>
			</select>
			<div class="toggle-item space-top-small">
				<div class="toggle-item-group">
					<label for="use_cdn"><?php _e( 'Store my files on the WPMU DEV CDN', 'wphb' ); ?></label>
					<div class="toggle-actions">
						<span class="toggle" tooltip="<?php _e( 'Enable WPMU DEV CDN', 'wphb' ); ?>">
							<input type="checkbox" class="toggle-checkbox" name="use_cdn" id="use_cdn" <?php checked( $use_cdn ); ?> <?php disabled( $use_cdn_disabled ); ?>>
							<label for="use_cdn" class="toggle-label"></label>
						</span>
					</div><!-- end toggle-actions -->
				</div>
			</div>


		</div><!-- end content -->



	</div><!-- end wphb-block-entry-content -->

</div><!-- end wphb-block-entry -->