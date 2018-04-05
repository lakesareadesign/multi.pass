<?php
	$option_name = empty( $_view['option_name'] ) ? '' : $_view['option_name'];
	$meta_robots_date = empty( $meta_robots_date ) ? array() : $meta_robots_date;
?>

<?php $this->_render( 'onpage/onpage-preview' ); ?>

<div class="wds-table-fields-group">
	<div class="wds-table-fields">
		<div class="label">
			<label for="title-date" class="wds-label"><?php esc_html_e( 'Date Archives Title' , 'wds' ); ?></label>
		</div>
		<div class="fields wds-allow-macros">
			<input id='title-date' name='<?php echo esc_attr( $option_name ); ?>[title-date]' type='text' class='wds-field' value='<?php echo esc_attr( $_view['options']['title-date'] ); ?>'>
		</div>
	</div>
</div>

<div class="wds-table-fields-group">
	<div class="wds-table-fields">
		<div class="label">
			<label for="metadesc-date" class="wds-label"><?php _e( 'Date Archives Meta Description' , 'wds' ); ?></label>
		</div>
		<div class="fields wds-allow-macros">
			<textarea id='metadesc-date' name='<?php echo esc_attr( $option_name ); ?>[metadesc-date]' type='text' class='wds-field'><?php echo esc_textarea( $_view['options']['metadesc-date'] ); ?></textarea>
		</div>
	</div>
</div>

<?php
	$this->_render('onpage/onpage-og-twitter', array(
		'for_type' => 'date',
	));
?>

<?php
	$this->_render('onpage/onpage-meta-robots', array(
		'items'     => $meta_robots_date,
	));
?>