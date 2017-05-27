<h3><?php echo esc_html( $title ); ?></h3>
<?php if ( $issues && ! $cf_active ) : ?>
	<div class="wphb-pills"><?php echo intval( $issues ); ?></div>
<?php elseif ( $cf_current !== 691200 && $cf_active ) : ?>
    <div class="wphb-pills">1</div>
<?php endif; ?>