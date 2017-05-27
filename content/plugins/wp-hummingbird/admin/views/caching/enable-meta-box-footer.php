<?php if( wphb_is_htaccess_writable() === true ) : ?>
	<div id="enable-cache-wrap" class="<?php echo $server_type != 'apache' ? 'hidden' : ''; ?>">
		<?php if( wphb_is_htaccess_written('caching') === true ) : ?>
			<a href="<?php echo esc_url( $disable_link ); ?>" class="button button-ghost"><?php esc_attr_e( 'Disable caching', 'wphb' ); ?></a>
		<?php elseif ( ! $disable_enable_button && ! $cloudflare_enabled ) : ?>
			<a href="<?php echo esc_url( $enable_link ); ?>" class="button"><?php esc_attr_e( 'Enable caching', 'wphb' ); ?></a>
        <?php elseif ( $cloudflare_enabled ) : ?>
            <span class="tooltip-l" tooltip="<?php esc_attr_e('CloudFlare is already controlling your Browser Caching', 'wphb' ); ?>">
                <a href="<?php echo esc_url( $enable_link ); ?>" class="button disabled"><?php esc_attr_e( 'Enable caching', 'wphb' ); ?></a>
            </span>
		<?php endif; ?>
	</div>
<?php endif; ?>