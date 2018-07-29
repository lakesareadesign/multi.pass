<form action='<?php echo esc_attr( $_view['action_url'] ); ?>' method='post' class="wds-form">
	<?php settings_fields( $_view['option_name'] ); ?>

	<input type="hidden"
	       name='<?php echo esc_attr( $_view['option_name'] ); ?>[<?php echo esc_attr( $_view['slug'] ); ?>-setup]'
	       value="1"/>