<div class="wphb-block-entry">

	<div class="wphb-block-entry-content">

		<img class="wphb-image-icon-content wphb-image-icon-content-top wphb-image-icon-content-center" src="<?php echo wphb_plugin_url() . 'admin/assets/image/icon-performance.png'; ?>" alt="<?php _e('Performance', 'wphb'); ?>">

		<h2 class="title"><?php _e( "Let's see what we can improve!", 'wphb' ); ?></h2>

		<div class="content">
			<p><?php _e( 'For us to know what to improve we need to scan your website. All testing is done in the background via our <br> secure servers. Once complete, we\'ll give you a list of things to improve, and how to do it.', 'wphb' ); ?></p>
			<a href="#run-performance-test-modal" class="button button-app button-content-app" id="run-performance-test" rel="dialog"><?php _e( 'Scan my website', 'wphb' ); ?></a>

			<dialog class="wphb-modal wphb-progress-modal no-close" id="run-performance-test-modal" title="<?php _e( 'Scanning your website for performance improvements', 'wphb' ); ?>">
				<div class="wphb-block-test" id="run-performance-test-modal-modal-content">
					<div class="wphb-progress">
						<div class="wphb-progress-bar wphb-progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="100" aria-valuemax="100" style="width:100%;">
							<span class="wphb-progress-bar-text"><?php _e( 'Analyzing your site...', 'wphb' ); ?></span>
						</div>
					</div><!-- end wphb-progress -->
					<div class="wphb-progress-state">
						<span class="wphb-progress-state-text"><?php _e( 'This test is running in the background, you can check back anytime to see progress...', 'wphb' ); ?></span>
					</div><!-- end wphb-progress-state -->
				</div><!-- end wphb-block-test -->
			</dialog><!-- end run-performance-test-modal-modal -->

		</div><!-- end content -->

	</div><!-- end wphb-block-entry-content -->

</div><!-- end wphb-block-entry -->

<?php if ( $doing_report ): // Show the progress bar if we are still checking files ?>
	<script>
		jQuery( document).ready( function() {
			var module = WPHB_Admin.getModule( 'performance' );
			jQuery('#run-performance-test').trigger('click');
		});
	</script>
<?php endif; ?>