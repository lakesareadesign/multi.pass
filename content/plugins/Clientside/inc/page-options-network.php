<div class="wrap">

	<h2><?php echo $page_info['title']; ?></h2>

	<div class="clientside-page-sidebar clientside-page-sidebar-lower">
		<div class="clientside-widget clientside-widget-empty">
			<input type="submit" class="button-primary clientside-button-action clientside-button-large clientside-button-w100p" data-js-relay=".clientside-options-save-button" value="<?php _e( 'Save Settings' ); ?>">

		</div>
		<div class="clientside-widget clientside-widget-bordered">
			<div class="inside">
				<p>
					Note that these are only network-related options. To manage site specific options, visit the network sites individually.
				</p>
			</div>
		</div>
	</div>

	<?php settings_errors(); ?>

	<form method="post" action="edit.php?action=<?php echo Clientside_Options::$options_slug; ?>" class="clientside-page-content clientside-options-form">

		<input type="hidden" name="<?php echo Clientside_Options::$options_slug; ?>[<?php echo 'options-page-identification'; ?>]" value="<?php echo $page_info['slug']; ?>">

		<?php // Prepare options ?>
		<?php settings_fields( Clientside_Options::$options_slug ); ?>

		<?php // Show this page's option sections & fields ?>
		<?php do_settings_sections( $page_info['slug'] ); ?>

		<p class="submit">
			<input type="submit" name="submit" class="button-primary clientside-options-save-button" value="<?php _e( 'Save Settings' ); ?>">
		</p>

	</form>

</div>