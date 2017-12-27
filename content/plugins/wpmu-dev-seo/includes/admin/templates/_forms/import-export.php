<form method='post' enctype="multipart/form-data" class="wds-form">
<?php settings_fields( $_view['option_name'] ); ?>

<input type="hidden" name='<?php echo esc_attr($_view['option_name']); ?>[<?php echo esc_attr($_view['slug']); ?>-setup]' value="1"/>