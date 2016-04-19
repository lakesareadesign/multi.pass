<label for="wphb-chart-selector-header" class="screen-reader-text"><?php _e( 'Header chart filter', 'wphb' ); ?></label>
<select name="wphb-chart-selector" class="wphb-chart-selector" id="wphb-chart-selector-header" data-type="header">
	<option value="all"><?php esc_html_e( 'Show all', 'wphb' ); ?></option>
	<option value="core"><?php esc_html_e( 'Core', 'wphb' ); ?></option>

	<?php foreach ( $options as $option ): ?>
		<option value="<?php echo esc_attr( $option ); ?>"><?php echo esc_html( $option ); ?></option>
	<?php endforeach; ?>
</select>

<div id="sankey_multiple_header" style="width: 100%;height:<?php echo $height_header; ?>px;"></div>

<script type="text/javascript">
	jQuery( document ).ready( function() {
		if ( typeof WPHB_Admin !== 'undefined' ) {
			var module = WPHB_Admin.getModule( 'chart' );
			module.draw(<?php echo $data_header; ?>, 'sankey_multiple_header');
		}
	});
</script>