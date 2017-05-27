<?php if ( $this->has_meta_boxes( 'box-enqueued-files-empty' ) ) : ?>
    <div class="row">
        <?php $this->do_meta_boxes( 'box-enqueued-files-empty' ); ?>
    </div>
<?php endif; ?>

<div class="row">
	<?php $this->do_meta_boxes( 'summary' ); ?>
</div>

<?php if ( ! $this->has_meta_boxes( 'box-enqueued-files-empty' ) ) :
    if ( ! isset( $_REQUEST['view'] ) ) $_REQUEST['view'] = 'files'; ?>
    <div class="row">
        <div class="col-fifth">
            <ul class="wphb-tabs hide-on-mobile">
                <li class="wphb-tab <?php echo ( 'files' === $_REQUEST['view'] ) ? 'current' : null ?>">
                    <a href="<?php echo network_admin_url( 'admin.php?page=wphb-minification&view=files' ) ?>">
                        <?php _e( 'Files', 'wphb' ); ?>
                    </a>
                    <span class="wphb-button-label wphb-button-label-light"><?php echo wphb_minification_files_count(); ?></span>
                </li>
                <?php if ( ! is_multisite() ) : ?>
                    <li class="wphb-tab <?php echo ( 'settings' === $_REQUEST['view'] ) ? 'current' : null ?>">
                        <a href="<?php echo network_admin_url( 'admin.php?page=wphb-minification&view=settings' ) ?>">
                            <?php _e( 'Settings', 'wphb' ); ?>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>

            <div class="mline hide-on-large">
                <div class="select-container mobile-nav">
                    <span class="dropdown-handle"><i class="wdv-icon wdv-icon-reorder"></i></span>
                    <select class="mobile-nav wdev-styled" style="display: none;">
                        <option value="#files" <?php selected( $_REQUEST['view'], 'files' ); ?>><?php _e( 'Files', 'wphb' ); ?></option>
                        <option value="#settings" <?php selected( $_REQUEST['view'], 'settings' ); ?>><?php _e( 'Settings', 'wphb' ); ?></option>
                    </select>
                    <div class="select-list-container">
                        <div class="list-value">
                            <?php if ( 'files' === $_REQUEST['view'] ) {
	                            _e( 'Files', 'wphb' );
                            } elseif ( 'settings' === $_REQUEST['view'] ) {
	                            _e( 'Settings', 'wphb' );
                            } ?>
                        </div>
                        <ul class="list-results wphb-tabs">
                            <li class="wphb-tab <?php echo ( 'files' === $_REQUEST['view'] ) ? 'current' : null ?>">
                                <a href="<?php echo network_admin_url( 'admin.php?page=wphb-minification&view=files' ) ?>"><?php _e( 'Files', 'wphb' ); ?></a>
                            </li>
                            <li class="wphb-tab <?php echo ( 'settings' === $_REQUEST['view'] ) ? 'current' : null ?>">
                                <a href="<?php echo network_admin_url( 'admin.php?page=wphb-minification&view=settings' ) ?>"><?php _e( 'Settings', 'wphb' ); ?></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div><!-- end mline -->
        </div><!-- end col-sixth -->

        <div class="col-four-fifths">
            <form action="" method="post" id="wphb-minification-form">
                <?php if ( 'files' === $_REQUEST['view'] ) : ?>
                    <div class="minification-main-screen">
                        <?php $this->do_meta_boxes( 'main' ); ?>

                        <?php if ( $this->has_meta_boxes( 'main-2' ) ): ?>
                            <div class="wphb-notice wphb-notice-box no-top-space">
                                <p><?php _e( 'Hummingbird will combine your files as best it can, however, depending on your settings, combining all your files might not be possible. What you see here is the best output Hummingbird can muster!', 'wphb' ); ?></p>
                            </div>
                            <?php $this->do_meta_boxes( 'main-2' ); ?>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

	            <?php if ( 'settings' === $_REQUEST['view'] ) : ?>
                    <div class="minification-settings-screen">
                        <?php $this->do_meta_boxes( 'settings' ); ?>
                    </div>
	            <?php endif; ?>
            </form>
        </div><!-- end col-five-sixths -->

    </div><!-- end row -->
<?php endif; ?>

<?php
wphb_membership_modal();
?>

<script>
    jQuery(document).ready( function() {
        var module = WPHB_Admin.getModule( 'minification' );
		<?php if ( isset( $_GET['run'] ) ): ?>
        module.$checkFilesButton.trigger( 'click' );
		<?php endif; ?>
    });
</script>