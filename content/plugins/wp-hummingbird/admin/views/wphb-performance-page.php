<?php if ( $this->has_meta_boxes( 'summary' ) ) : ?>
    <div class="row">
        <?php $this->do_meta_boxes( 'summary' ); ?>
    </div>
<?php endif; ?>

<div class="row">
    <?php $last_test = wphb_performance_get_last_report();
    if ( $last_test ) :
        if ( ! isset( $_REQUEST['view'] ) ) $_REQUEST['view'] = 'improvements';

	    $class = '';
	    if ( isset( $last_test->data ) ) {
		    switch ( $last_test->data->score_class ) {
			    case 'aplus':
			    case 'a':
			    case 'b':
				    $class = 'green';
				    break;
			    case 'c':
			    case 'd':
				    $class = 'yellow';
				    break;
			    case 'e':
			    case 'f':
				    $class = 'red';
				    break;
		    }
        } ?>
        <div class="col-fifth">
            <ul class="wphb-tabs hide-on-mobile">
                <li class="wphb-tab <?php echo ( 'improvements' === $_REQUEST['view'] ) ? 'current' : null ?>">
                    <a href="<?php echo network_admin_url( 'admin.php?page=wphb-performance&view=improvements' ) ?>">
		                <?php _e( 'Improvements', 'wphb' ); ?>
                    </a>
                    <?php if ( ! $this->has_error ) : ?>
                        <span class="wphb-button-label wphb-button-label-<?php echo $class; ?>"><?php echo $this->recommendations; ?></span>
                    <?php else: ?>
                        <i class="hb-wpmudev-icon-warning"></i>
                    <?php endif; ?>
                </li>
                <li class="wphb-tab <?php echo ( 'reporting' === $_REQUEST['view'] ) ? 'current' : null ?>">
                    <a href="<?php echo network_admin_url( 'admin.php?page=wphb-performance&view=reporting' ) ?>">
		                <?php _e( 'Reporting', 'wphb' ); ?>
                    </a>
                </li>
            </ul>

            <div class="mline hide-on-large">
                <div class="select-container mobile-nav">
                    <span class="dropdown-handle"><i class="wdv-icon wdv-icon-reorder"></i></span>
                    <select class="mobile-nav wdev-styled" style="display: none;">
                        <option value="#improvements" <?php selected( $_REQUEST['view'], 'improvements' ); ?>><?php _e( 'Improvements', 'wphb' ); ?></option>
                        <option value="#reporting" <?php selected( $_REQUEST['view'], 'reporting' ); ?>><?php _e( 'Reporting', 'wphb' ); ?></option>
                    </select>
                    <div class="select-list-container">
                        <div class="list-value">
					        <?php if ( 'improvements' === $_REQUEST['view'] ) {
						        _e( 'Improvements', 'wphb' );
					        } elseif ( 'reporting' === $_REQUEST['view'] ) {
						        _e( 'Reporting', 'wphb' );
					        } ?>
                        </div>
                        <ul class="list-results wphb-tabs">
                            <li class="wphb-tab <?php echo ( 'improvements' === $_REQUEST['view'] ) ? 'current' : null ?>">
                                <a href="<?php echo network_admin_url( 'admin.php?page=wphb-performance&view=improvements' ) ?>" data-tab="#improvements"><?php _e( 'Improvements', 'wphb' ); ?></a>
                            </li>
                            <li class="wphb-tab <?php echo ( 'reporting' === $_REQUEST['view'] ) ? 'current' : null ?>">
                                <a href="<?php echo network_admin_url( 'admin.php?page=wphb-performance&view=reporting' ) ?>" data-tab="#reporting"><?php _e( 'Reporting', 'wphb' ); ?></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div><!-- end mline -->
        </div><!-- end col-sixth -->

        <div class="col-four-fifths">
        <?php
            if ( 'improvements' === $_REQUEST['view'] ) {
	            $this->do_meta_boxes( 'main' );
            } elseif ( 'reporting' === $_REQUEST['view'] ) {
	            $this->do_meta_boxes( 'reports' );
            }
        ?>
        </div>
    <?php else : ?>
	    <?php $this->do_meta_boxes( 'main' ); ?>
    <?php endif; ?>
</div><!-- end row -->

<script>
	jQuery(document).ready( function() {
        WPHB_Admin.getModule( 'performance' );
	});
</script>