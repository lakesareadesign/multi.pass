<?php if( wphb_is_htaccess_writable() === true ) : ?>
	<div id="enable-cache-wrap" class="<?php echo $server_type != 'apache' ? 'hidden' : ''; ?>">
		<?php if( wphb_is_htaccess_written('caching') === true ) : ?>
			<a href="<?php echo esc_url( $disable_link ); ?>" class="button button-red-alt"><?php esc_attr_e( 'Disable caching', 'wphb' ); ?></a>
		<?php elseif ( ! $disable_enable_button ) : ?>
			<a href="<?php echo esc_url( $enable_link ); ?>" class="button button-app"><?php esc_attr_e( 'Enable caching', 'wphb' ); ?></a>
		<?php endif; ?>
	</div>
<?php endif; ?>