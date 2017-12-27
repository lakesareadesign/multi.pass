<?php $option_name = empty($_view['option_name']) ? '' : $_view['option_name']; ?>

<?php $this->_render('onpage/onpage-preview'); ?>

<div class="wds-table-fields-group">
	<div class="wds-table-fields">
		<div class="label">
			<label for="title-404" class="wds-label"><?php esc_html_e( '404 Page Title' , 'wds' ); ?></label>
		</div>
		<div class="fields wds-allow-macros">
			<input id='title-404' name='<?php echo esc_attr($option_name); ?>[title-404]' type='text' class='wds-field' value='<?php echo esc_attr($_view['options']['title-404']); ?>'>
		</div>
	</div>
</div>

<div class="wds-table-fields-group">
	<div class="wds-table-fields">
		<div class="label">
			<label for="metadesc-404" class="wds-label"><?php esc_html_e( '404 Page Description' , 'wds' ); ?></label>
		</div>
		<div class="fields wds-allow-macros">
			<textarea id='metadesc-404' name='<?php echo esc_attr($option_name); ?>[metadesc-404]' type='text' class='wds-field'><?php echo esc_textarea($_view['options']['metadesc-404']); ?></textarea>
		</div>
	</div>
</div>