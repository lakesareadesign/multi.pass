<?php
	$option_name = empty($_view['option_name']) ? '' : $_view['option_name'];
	$meta_robots_search = empty($meta_robots_search) ? array() : $meta_robots_search;
?>

<?php $this->_render('onpage/onpage-preview'); ?>

<div class="wds-table-fields-group">
	<div class="wds-table-fields">
		<div class="label">
			<label for="title-search" class="wds-label"><?php esc_html_e( 'Search Page Title' , 'wds' ); ?></label>
		</div>
		<div class="fields wds-allow-macros">
			<input id='title-search' name='<?php echo esc_attr($option_name); ?>[title-search]' type='text' class='wds-field' value='<?php echo esc_attr($_view['options']['title-search']); ?>'>
		</div>
	</div>
</div>

<div class="wds-table-fields-group">
	<div class="wds-table-fields">
		<div class="label">
			<label for="metadesc-search" class="wds-label"><?php esc_html_e( 'Search Page Meta Description' , 'wds' ); ?></label>
		</div>
		<div class="fields wds-allow-macros">
			<textarea id='metadesc-search' name='<?php echo esc_attr($option_name); ?>[metadesc-search]' type='text' class='wds-field'><?php echo esc_textarea($_view['options']['metadesc-search']); ?></textarea>
		</div>
	</div>
</div>

<?php
	$this->_render('onpage/onpage-og-master', array(
		'for_type' => 'search',
	));
?>

<?php
	$this->_render('onpage/onpage-meta-robots', array(
		'items'     => $meta_robots_search
	));
?>