<dialog id="wphb-quick-setup-modal" class="small wphb-modal wphb-quick-setup-modal no-close" title="<?php _e( 'Quick Setup', 'wphb' ); ?>">
	<script>
        function skipSetup() {
            jQuery.ajax({
                type: 'POST',
                url: ajaxurl,
                data: {
                    'action': 'dashboard_skip_setup',
                },
                success: function () {
                    window.location.reload(true);
                }
            });
        }

        function runPerformanceTest() {
            // Show quick setup modal
            var args = {};
            args.class = "wphb-modal small wphb-progress-modal no-close";
            // Show quick setup modal
            WDP.showOverlay("#run-performance-test-modal", args);

            // Run performance test
            var module = WPHB_Admin.getModule('performance');
            module.performanceTest("<?php echo wphb_get_admin_menu_url( '' ); ?>");
        }
	</script>
	<div class="title-action">
		<input type="button" class="button button-ghost" id="skip-quick-setup" value="<?php _e( 'Skip', 'wphb' ); ?>" onclick="skipSetup()">
	</div>
    <div class="wphb-dialog-content">
        <p><?php _e( 'Welcome to Hummingbird, the hottest Performance plugin for WordPress! We recommend running a quick performance test before you start tweaking things. Alternatively you can skip this step if you’d prefer to start customizing.', 'wphb' ); ?></p>
            <div class="wphb-block-test" id="check-files-modal-content">
                <p><?php _e( 'This is only a performance test. Once you know what to fix you can get started in the next steps.', 'wphb' ); ?></p>
                <input type="button" class="button button-large" value="<?php _e( 'Test my website', 'wphb' ); ?>" onclick="runPerformanceTest()">
            </div>
        <img class="wphb-image wphb-image-center wphb-modal-image-bottom"
             src="<?php echo wphb_plugin_url() . 'admin/assets/image/hummingbird-modal-quicksetup.png'; ?>"
             srcset="<?php echo wphb_plugin_url() . 'admin/assets/image/hummingbird-modal-quicksetup@2x.png'; ?> 2x"
             alt="<?php esc_attr_e( 'Reduce your page load time!', 'wphb' ); ?>">
    </div>
</dialog><!-- end wphb-upgrade-membership-modal -->