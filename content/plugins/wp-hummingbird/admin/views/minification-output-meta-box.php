<select name="wphb-chart-selector" id="wphb-chart-selector">
	<option value="all"><?php esc_html_e( 'Show all', 'wphb' ); ?></option>
	<option value="core"><?php esc_html_e( 'Core', 'wphb' ); ?></option>

	<?php foreach ( $options as $option ): ?>
		<option value="<?php echo esc_attr( $option ); ?>"><?php echo esc_html( $option ); ?></option>
	<?php endforeach; ?>
</select>

<div id="sankey_multiple" style="width: 100%;height:<?php echo $height; ?>px;"></div>

<script type="text/javascript">
	jQuery( document ).ready( function() {
		if ( typeof WPHB_Admin !== 'undefined' ) {
			var module = WPHB_Admin.getModule( 'chart' );
			module.draw(<?php echo $data; ?>);
		}
	});


</script>