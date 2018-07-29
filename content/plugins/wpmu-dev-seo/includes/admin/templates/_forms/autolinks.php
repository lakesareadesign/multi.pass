<?php
$autolinks_enabled = $autolinks_network_enabled && $autolinks_locally_enabled;
$form_action = $autolinks_enabled ? $_view['action_url'] : '';
?>
<form action='<?php echo esc_attr( $form_action ); ?>' method='post' class="wds-form">
	<?php if ( $autolinks_enabled ) : ?>
		<?php settings_fields( $_view['option_name'] ); ?>

		<input type="hidden"
		       name='<?php echo esc_attr( $_view['option_name'] ); ?>[<?php echo esc_attr( $_view['slug'] ); ?>-setup]'
		       value="1">
	<?php endif; ?>