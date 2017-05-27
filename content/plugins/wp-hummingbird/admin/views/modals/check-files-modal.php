<dialog class="wphb-modal small wphb-progress-modal no-close" id="check-files-modal" title="<?php _e( 'Checking files', 'wphb' ); ?>">
	<script>
        function cancelScan() {
            jQuery.ajax({
                type: 'POST',
                url: ajaxurl,
                data: {
                    'action': 'minification_cancel_check',
                },
                success: function () {
                    window.location.reload(true);
                }
            });
        }
	</script>
	<div class="title-action">
		<input type="button" class="button button-ghost" id="cancel-minification-check" value="<?php _e( 'Cancel', 'wphb' ); ?>" onclick="cancelScan()">
	</div>
	<div class="wphb-dialog-content">
		<p><?php _e( 'Hummingbird will combine your files as best it can, however, depending on your settings, combining all your files might not be possible. What you see here is the best output Hummingbird can muster!', 'wphb' ); ?></p>
		<?php $progress = get_option( 'wphb-minification-check-files-progress' ); ?>

		<div class="wphb-block-test" id="check-files-modal-content">
			<div class="wphb-scan-progress">
				<div class="wphb-scan-progress-text">
					<img src="<?php echo wphb_plugin_url() . 'admin/assets/image/loading.gif'; ?>">
					<span><?php echo $progress; ?>%</span>
				</div><!-- end wphb-scan-progress-text -->
				<div class="wphb-scan-progress-bar">
					<span style="width: <?php echo $progress; ?>%"></span>
				</div><!-- end wphb-scan-progress-bar -->
			</div><!-- end wphb-scan-progress -->
		</div><!-- end wphb-block-test -->

		<div class="wphb-progress-state">
			<span class="wphb-progress-state-text"><?php _e( 'Check Files is running in the background, you can check back anytime to see progress...', 'wphb' ); ?></span>
		</div><!-- end wphb-progress-state -->

		<div class="wphb-notice wphb-notice-warning wphb-notice-box">
			<p><?php _e( 'Note: Moving files between the header and footer of your page can break your website. We recommend tweaking and checking each file as you go and if a setting causes errors then revert the setting here.', 'wphb' ); ?></p>
		</div>

		<img class="wphb-image wphb-image-center wphb-modal-image-bottom"
		     src="<?php echo wphb_plugin_url() . 'admin/assets/image/graphic-hb-minify-summary.png'; ?>"
		     srcset="<?php echo wphb_plugin_url() . 'admin/assets/image/graphic-hb-minify-summary@2x.png'; ?> 2x"
		     alt="<?php esc_attr_e( 'Reduce your page load time!', 'wphb' ); ?>">
	</div><!-- end wphb-dialog-content -->
</dialog><!-- end check-files-modal -->