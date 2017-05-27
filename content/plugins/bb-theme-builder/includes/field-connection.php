<div class="fl-field-connections-toggle">
	<i class="fa fa-plus-circle"></i>
</div>
<div class="fl-field-connection<?php  if ( $connection ) { echo ' fl-field-connection-visible';} ?>"<?php if ( $form ) { echo ' data-form="' . $form . '"';} ?>>
	<div class="fl-field-connection-content">
		<div class="fl-field-connection-label"><?php FLThemeBuilderFieldConnections::render_label( $connection ); ?></div>
		<i class="fl-field-connection-edit fa fa-wrench"></i>
		<i class="fl-field-connection-remove fa fa-times"></i>
	</div>
</div>
<input class="fl-field-connection-value" type="hidden" name="connections[][<?php echo $name; ?>]" value='<?php if ( $connection ) { echo json_encode( $connection );} ?>' />
<script> FLThemeBuilderFieldConnections._menus['<?php echo $name; ?>'] = <?php echo json_encode( $menu_data ); ?></script>
