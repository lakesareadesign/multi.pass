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

			<label for="wphb-activate-minification"></label>
			<select name="wphb-activate-minification" id="wphb-activate-minification">
				<option value="false" <?php selected( wphb_get_setting( 'minify' ), false ); ?>><?php _e( 'Deactivate completely', 'wphb' ); ?></option>
				<option value="true" <?php selected( wphb_get_setting( 'minify' ), true ); ?>><?php _e( 'Blog Admins can minify', 'wphb' ); ?></option>
				<option value="super-admins" <?php selected( wphb_get_setting( 'minify' ), 'super-admins' ); ?>><?php _e( 'Only Super Admins can minify', 'wphb' ); ?></option>
			</select>
		</div><!-- end content -->



	</div><!-- end wphb-block-entry-content -->

</div><!-- end wphb-block-entry -->