<h3><?php echo esc_html( $title ); ?></h3>
<?php if ( $is_installed && $is_active  ) : ?>
<div class="buttons">
	<a href="<?php echo esc_url( admin_url( 'upload.php?page=wp-smush-bulk' ) ); ?>" class="button button-small button-grey"><?php esc_attr_e( 'Configure', 'wphb' ); ?></a>
</div>
<?php endif; ?>