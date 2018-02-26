<?php
	$post_type = empty( $post_type ) ? '' : $post_type;
	$post_type_object = empty( $post_type_object ) ? '' : $post_type_object;
	$option_name = empty( $_view['option_name'] ) ? '' : $_view['option_name'];
?>

<?php $this->_render( 'onpage/onpage-preview' ); ?>

<div class="wds-table-fields-group">
	<div class="wds-table-fields">
		<div class="label">
			<label for="title-<?php echo $post_type; ?>" class="wds-label"><?php printf( esc_html( __( '%s Title' , 'wds' ) ), esc_html( $post_type_object->labels->singular_name ) ); ?></label>
		</div>
		<div class="fields wds-allow-macros">
			<input id='title-<?php echo $post_type; ?>' name='<?php echo esc_attr( $option_name ); ?>[title-<?php echo $post_type; ?>]' type='text' class='wds-field' value='<?php echo esc_attr( $_view['options'][ 'title-' . $post_type ] ); ?>'>
		</div>
	</div>
</div>

<div class="wds-table-fields-group">
	<div class="wds-table-fields">
		<div class="label">
			<label for="metadesc-<?php echo $post_type; ?>" class="wds-label"><?php printf( esc_html( __( '%s Meta Description' , 'wds' ) ), esc_html( $post_type_object->labels->singular_name ) ); ?></label>
		</div>
		<div class="fields wds-allow-macros">
			<textarea id='metadesc-<?php echo $post_type; ?>' name='<?php echo esc_attr( $option_name ); ?>[metadesc-<?php echo $post_type; ?>]' type='text' class='wds-field'><?php echo esc_textarea( $_view['options'][ 'metadesc-' . $post_type ] ); ?></textarea>
		</div>
	</div>

	<?php
		$this->_render('onpage/onpage-meta-robots', array(
			'items'     => $post_type_robots,
		));
	?>

	<?php
		$this->_render('onpage/onpage-og-master', array(
			'for_type' => $post_type,
		));
	?>
</div>