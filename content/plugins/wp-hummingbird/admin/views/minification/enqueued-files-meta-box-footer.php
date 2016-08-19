<div class="buttons alignleft">
	<input type="submit" class="button button-grey" name="clear-cache" value="<?php esc_attr_e( 'Re-Check Files', 'wphb' ); ?>"/>
</div>
<div class="buttons alignright">
	<button type="submit" class="button button-grey wphb-discard" <?php disabled( true ); ?>><?php echo esc_html( 'Discard Changes', 'wphb' ); ?></button>
	<input type="submit" class="button button-app" name="submit" value="<?php esc_attr_e( 'Save Changes', 'wphb' ); ?>"/>
</div>
<div class="clear"></div>