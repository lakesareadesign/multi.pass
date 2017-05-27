<h3><?php echo esc_html( $title ); ?></h3>
<?php if ( $cf_active ): ?>
    <div class="buttons">
        <a href="<?php echo esc_url( $deactivate_url ); ?>" class="button button-ghost"><?php esc_attr_e( 'Deactivate', 'wphb' ); ?></a>
    </div>
<?php endif; ?>