<dialog class="wphb-modal small wphb-progress-modal no-close" id="run-performance-test-modal" title="<?php _e( 'Test in progress', 'wphb' ); ?>">
    <div class="wphb-dialog-content">
        <p><?php _e( 'Hummingbird is running a test to measure your website performance, please wait.', 'wphb' ); ?></p>
		<?php $progress = get_option( 'wphb-minification-check-files-progress' ); ?>

        <div class="wphb-block-test" id="run-performance-test-modal-modal-content">
            <div class="wphb-scan-progress">
                <div class="wphb-scan-progress-text">
                    <img src="<?php echo wphb_plugin_url() . 'admin/assets/image/loading.gif'; ?>">
                    <span>0%</span>
                </div><!-- end wphb-scan-progress-text -->
                <div class="wphb-scan-progress-bar">
                    <span style="width: 0%"></span>
                </div><!-- end wphb-scan-progress-bar -->
            </div><!-- end wphb-scan-progress -->
        </div><!-- end wphb-block-test -->

        <div class="wphb-progress-state">
            <span class="wphb-progress-state-text"><?php _e( 'Performance test in progress...', 'wphb' ); ?></span>
        </div><!-- end wphb-progress-state -->

        <img class="wphb-image wphb-image-center wphb-modal-image-bottom"
             src="<?php echo wphb_plugin_url() . 'admin/assets/image/hummingbird-modal-quicksetup.png'; ?>"
             srcset="<?php echo wphb_plugin_url() . 'admin/assets/image/hummingbird-modal-quicksetup@2x.png'; ?> 2x"
             alt="<?php esc_attr_e( 'Reduce your page load time!', 'wphb' ); ?>">
    </div><!-- end wphb-dialog-content -->
</dialog><!-- end run-performance-test-modal-modal -->