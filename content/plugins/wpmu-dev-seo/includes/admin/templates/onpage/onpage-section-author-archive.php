<?php
$option_name = empty( $_view['option_name'] ) ? '' : $_view['option_name'];
$meta_robots_author = empty( $meta_robots_author ) ? '' : $meta_robots_author;
?>

<?php $this->_render( 'onpage/onpage-preview' ); ?>

<div class="wds-table-fields-group">
	<div class="wds-table-fields">
		<div class="label">
			<label for="title-author" class="wds-label"><?php esc_html_e( 'Author Archive Title', 'wds' ); ?></label>
		</div>
		<div class="fields wds-allow-macros">
			<input id='title-author' name='<?php echo esc_attr( $option_name ); ?>[title-author]' type='text'
			       class='wds-field' value='<?php echo esc_attr( $_view['options']['title-author'] ); ?>'>
		</div>
	</div>
</div>

<div class="wds-table-fields-group">
	<div class="wds-table-fields">
		<div class="label">
			<label for="metadesc-author"
			       class="wds-label"><?php esc_html_e( 'Author Archive Meta Description', 'wds' ); ?></label>
		</div>
		<div class="fields wds-allow-macros">
			<textarea id='metadesc-author' name='<?php echo esc_attr( $option_name ); ?>[metadesc-author]' type='text'
			          class='wds-field'><?php echo esc_textarea( $_view['options']['metadesc-author'] ); ?></textarea>
		</div>
	</div>
</div>

<?php
$this->_render( 'onpage/onpage-og-twitter', array(
	'for_type' => 'author',
) );
?>

<?php
$this->_render( 'onpage/onpage-meta-robots', array(
	'items' => $meta_robots_author,
) );
?>