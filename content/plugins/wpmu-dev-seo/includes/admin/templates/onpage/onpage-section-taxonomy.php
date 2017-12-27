<?php
	$taxonomy = empty($taxonomy) ? new stdClass() : $taxonomy;
	$option_name = empty($_view['option_name']) ? '' : $_view['option_name'];
	$meta_robots = empty($meta_robots) ? array() : $meta_robots;
?>

<?php $this->_render('onpage/onpage-preview'); ?>

<div class="wds-table-fields-group">
	<div class="wds-table-fields">
		<div class="label">
			<label for="title-<?php echo $taxonomy->name; ?>" class="wds-label"><?php printf( esc_html(__( '%s Title' , 'wds')), esc_html(ucfirst( $taxonomy->label )) ); ?></label>
		</div>
		<div class="fields wds-allow-macros">
			<input id='title-<?php echo $taxonomy->name; ?>' name='<?php echo esc_attr($option_name); ?>[title-<?php echo $taxonomy->name; ?>]' type='text' class='wds-field' value='<?php echo esc_attr($_view['options']['title-' . $taxonomy->name]); ?>'>
		</div>
	</div>
</div>

<div class="wds-table-fields-group">
	<div class="wds-table-fields">
		<div class="label">
			<label for="metadesc-<?php echo $taxonomy->name; ?>" class="wds-label"><?php printf( esc_html(__( '%s Meta Description' , 'wds')), esc_html(ucfirst( $taxonomy->label )) ); ?></label>
		</div>
		<div class="fields wds-allow-macros">
			<textarea id='metadesc-<?php echo $taxonomy->name; ?>' name='<?php echo esc_attr($option_name); ?>[metadesc-<?php echo $taxonomy->name; ?>]' type='text' class='wds-field'><?php echo esc_textarea($_view['options']['metadesc-' . $taxonomy->name]); ?></textarea>
		</div>
	</div>
</div>

<?php
	$this->_render('onpage/onpage-og-master', array(
		'for_type' => $taxonomy->name,
	));
?>

<?php
	$this->_render('onpage/onpage-meta-robots', array(
		'items'     => $meta_robots
	));
?>