<div class="wrap">
	<h2>Blog &amp; User</h2>

	<form action="settings.php" method="post">

	<?php settings_fields('bau'); ?>
	<?php do_settings_sections('bau_options_page'); ?>
	<p class="submit">
		<input name="Submit" type="submit" class="button-primary" value="<?php esc_attr_e('Save Changes'); ?>" />
	</p>
	</form>

</div>