<section class="wds-horizontal-tab">
	<?php
	$tab_id = empty( $tab_id ) ? '' : $tab_id;
	$is_active = empty( $is_active ) ? false : $is_active;
	$content_template = empty( $content_template ) ? '' : $content_template;
	$content_args = empty( $content_args ) ? array() : $content_args;
	?>
	<input
		type="radio"
		name="wds-horizontal-tab"
		autocomplete="off"
		id="<?php echo esc_attr( $tab_id ); ?>"
		value="<?php echo esc_attr( $tab_id ); ?>"
		<?php checked( $is_active ); ?> />

	<div class="wds-horizontal-tab-content <?php echo esc_attr( $tab_id ); ?>">
		<?php $this->_render( $content_template, $content_args ); ?>
	</div>
</section>