<h3><?php echo esc_html( $title ); ?></h3>
<div class="buttons buttons-large">
	<span class="spinner left"></span>
	<div class="toggle-group toggle-group-with-buttons">
		<div class="tooltip-box">
			<span class="toggle" tooltip="<?php _e( 'Disable Minification', 'wphb' ); ?>">
				<input type="checkbox" id="wphb-disable-minification" class="toggle-checkbox" name="wphb-disable-minification" checked>
				<label for="wphb-disable-minification" class="toggle-label"></label>
			</span>
		</div>
	</div>
	<button type="submit" class="button button-grey" name="clear-cache"><?php esc_attr_e( 'Re-Check Files', 'wphb' ); ?></button>
	<button type="submit" class="button" name="submit"><?php esc_attr_e( 'Save', 'wphb' ); ?></button>
</div>