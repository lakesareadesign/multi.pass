<?php defined( 'ABSPATH' ) or exit; ?>

<div class="notice notice-<?php echo esc_attr( $data['class'] ); ?> is-dismissible">
	<p><?php echo sanitize_text_field( $data['text'] ); ?></p>
</div>
