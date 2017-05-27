<div class="wphb-block-entry">
	<div class="wphb-block-entry-content wphb-block-content-center">

		<img class="wphb-image wphb-image-center wphb-image-icon-content-top"
		     src="<?php echo wphb_plugin_url() . 'admin/assets/image/hb-graphic-reports-disabled@1x.png'; ?>"
		     srcset="<?php echo wphb_plugin_url() . 'admin/assets/image/hb-graphic-reports-disabled@2x.png'; ?> 2x"
		     alt="<?php esc_attr_e( 'Reduce your page load time!', 'wphb' ); ?>">

		<div class="content">
			<p><?php echo sprintf( __( "Hummingbird's Minification engine can combine and minify the files your website outputs when a <br> user visits your website. The less requests your visitors have to make to your server, the <br> better. Let's check to see what we can optimise, %s!", 'wphb' ), $user ); ?></p>
			<a id="check-files" class="button button-large" href="#check-files-modal" rel="dialog"><?php _e( 'Activate Minification', 'wphb' ); ?></a>
		</div><!-- end content -->

	</div><!-- end wphb-block-entry-content -->

</div><!-- end wphb-block-entry -->

<script>
    jQuery('#enable-cdn').on('click', function(e) {
        e.preventDefault();
        var args = {};
        args.class = 'wphb-modal small wphb-progress-modal no-close';
        WDP.showOverlay('#enable-cdn-modal', args );
    })
</script>

<?php
    wphb_check_files_modal();
    wphb_enable_cdn_modal();

    if ( $checking_files || isset( $_GET['wphb-cache-cleared'] ) ): // Show the progress bar if we are still checking files ?>
	<script>
		jQuery(document).ready( function() {
			var module = WPHB_Admin.getModule( 'minification' );
			jQuery('#check-files').trigger('click');
		});
	</script>
<?php endif; ?>