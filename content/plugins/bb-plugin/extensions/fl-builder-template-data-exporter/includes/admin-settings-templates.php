<h4><?php _e( 'Enable Template Data Exporter', 'fl-builder' ); ?></h4>
<p><?php _e( 'Enable the template data exporter under Tools > Template Exporter to export a special data file that can be used to include templates within themes and plugins.', 'fl-builder' ); ?></p>
<p>
	<label>
		<input type="checkbox" name="fl-template-data-exporter" value="1" <?php checked( self::is_enabled(), 1 ); ?> />
		<span><?php _e( 'Enable Template Data Exporter', 'fl-builder' ); ?></span>
	</label>
</p>