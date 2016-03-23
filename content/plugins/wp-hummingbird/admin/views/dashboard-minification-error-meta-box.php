<div class="row">
	<div class="wphb-notice wphb-notice-error wphb-notice-box can-close">
		<span class="wphb-icon wphb-icon-left"><i class="wdv-icon wdv-icon-fw wdv-icon-warning-sign"></i></span>
		<?php printf( __( 'Unable to create cache directory. Minification will not work, you need to create the folder manually %s', 'wphb' ), '<code>' . wphb_get_cache_dir() . '</code>' ); ?>
		<a target="_blank" href="<?php echo esc_url( wphb_support_link() ); ?>" class="button button-light button-notice button-notice-error"><?php _e( 'Support', 'wpb' ); ?></a>
	</div>
</div>