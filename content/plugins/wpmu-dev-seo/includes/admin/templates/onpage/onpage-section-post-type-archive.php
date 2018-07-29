<?php
$option_name = empty( $_view['option_name'] ) ? '' : $_view['option_name'];
$archive_post_type = empty( $archive_post_type ) ? '' : $archive_post_type;
$archive_post_type_label = empty( $archive_post_type_label ) ? '' : $archive_post_type_label;
$archive_post_type_robots = empty( $archive_post_type_robots ) ? '' : $archive_post_type_robots;

$title_key = 'title-' . $archive_post_type;
$title_value = smartcrawl_get_array_value( $_view['options'], $title_key );

$metadesc_key = 'metadesc-' . $archive_post_type;
$metadesc_value = smartcrawl_get_array_value( $_view['options'], $metadesc_key );
?>

<?php $this->_render( 'onpage/onpage-preview' ); ?>

<div class="wds-table-fields-group">
	<div class="wds-table-fields">
		<div class="label">
			<label for="<?php echo esc_attr( $title_key ); ?>" class="wds-label">
				<?php echo esc_html( $archive_post_type_label ) . esc_html__( ' Archive Title', 'wds' ); ?>
			</label>
		</div>
		<div class="fields wds-allow-macros">
			<input id='<?php echo esc_attr( $title_key ); ?>'
			       name='<?php echo esc_attr( $option_name ); ?>[<?php echo esc_attr( $title_key ); ?>]'
			       type='text' class='wds-field'
			       value='<?php echo esc_attr( $title_value ); ?>'>
		</div>
	</div>
</div>

<div class="wds-table-fields-group">
	<div class="wds-table-fields">
		<div class="label">
			<label for="<?php echo esc_attr( $metadesc_key ); ?>" class="wds-label">
				<?php echo esc_html( $archive_post_type_label ) . esc_html__( ' Archive Meta Description', 'wds' ); ?>
			</label>
		</div>
		<div class="fields wds-allow-macros">
			<textarea id='<?php echo esc_attr( $metadesc_key ); ?>'
			          name='<?php echo esc_attr( $option_name ); ?>[<?php echo esc_attr( $metadesc_key ); ?>]'
			          type='text' class='wds-field'><?php echo esc_textarea( $metadesc_value ); ?></textarea>
		</div>
	</div>
</div>

<?php
$this->_render( 'onpage/onpage-og-twitter', array(
	'for_type' => $archive_post_type,
) );
?>

<?php
$this->_render( 'onpage/onpage-meta-robots', array(
	'items' => $archive_post_type_robots,
) );
?>