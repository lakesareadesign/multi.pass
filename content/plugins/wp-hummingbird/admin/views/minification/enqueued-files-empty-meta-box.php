<div class="wphb-block-entry">

	<div class="wphb-block-entry-content">

		<img class="wphb-image-icon-content wphb-image-icon-content-top wphb-image-icon-content-center" src="<?php echo wphb_plugin_url() . 'admin/assets/image/icon-minification.png'; ?>" alt="<?php _e('Minification', 'wphb'); ?>">

		<h2 class="title"><?php _e( 'Reduce your page load time!', 'wphb' ); ?></h2>

		<div class="content">
			<p><?php echo sprintf( __( 'Hummingbird\'s Minification engine can combine and minify the files your website outputs when a <br> user visits your website. The less requests your visitors have to make to your server, the <br> better. <strong>Let\'s check to see what we can optimise, %s!</strong>', 'wphb' ), $user ); ?></p>
			<a id="check-files" class="button button-app button-content-cta" href="#check-files-modal" rel="dialog"><?php _e( 'Check files', 'wphb' ); ?></a>

			<dialog class="wphb-modal wphb-progress-modal no-close" id="check-files-modal" title="<?php _e( 'Checking files', 'wphb' ); ?>">
				<div class="wphb-block-test" id="check-files-modal-content">
					<div class="wphb-progress">
						<div class="wphb-progress-bar wphb-progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="100" aria-valuemax="100" style="width:100%;">
							<span class="wphb-progress-bar-text"><?php _e( 'Test in progress...', 'wphb' ); ?></span>
						</div>
					</div><!-- end wphb-progress -->
					<div class="wphb-progress-state">
						<span class="wphb-progress-state-text"><?php _e( 'Check Files is running in the background, you can check back anytime to see progress...', 'wphb' ); ?></span>
					</div><!-- end wphb-progress-state -->
				</div><!-- end wphb-block-test -->
			</dialog><!-- end check-files-modal -->
		</div><!-- end content -->

	</div><!-- end wphb-block-entry-content -->

</div><!-- end wphb-block-entry -->

<?php if ( $checking_files || isset( $_GET['wphb-cache-cleared'] ) ): // Show the progress bar if we are still checking files ?>
	<script>
		jQuery( document).ready( function() {
			var module = WPHB_Admin.getModule( 'minification' );
			jQuery('#check-files').trigger('click');
		});
	</script>
<?php endif; ?>