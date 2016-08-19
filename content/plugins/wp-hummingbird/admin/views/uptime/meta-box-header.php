<h3><?php echo esc_html( $title ); ?></h3>
<?php if ( ! empty( $manage_link ) ): ?>
	<div class="buttons">
		<a href="<?php echo esc_url( $manage_link ); ?>" class="button button-small button-grey" target="_blank"><?php esc_attr_e( 'My Websites Uptime', 'wphb' ); ?></a>
	</div>
<?php endif; ?>