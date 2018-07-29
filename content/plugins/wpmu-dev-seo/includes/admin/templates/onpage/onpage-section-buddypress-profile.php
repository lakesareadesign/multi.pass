<?php $option_name = empty( $_view['option_name'] ) ? '' : $_view['option_name']; ?>

<?php $this->_render( 'onpage/onpage-preview' ); ?>

<div class="wds-table-fields-group">
	<div class="wds-table-fields">
		<div class="label">
			<label for="title-bp_profile"
			       class="wds-label"><?php esc_html_e( 'BuddyPress Profile Title', 'wds' ); ?></label>
		</div>
		<div class="fields wds-allow-macros">
			<input id='title-bp_profile' name='<?php echo esc_attr( $option_name ); ?>[title-bp_profile]' size=''
			       type='text' class='wds-field'
			       value='<?php echo esc_attr( $_view['options']['title-bp_profile'] ); ?>'>
		</div>
	</div>
</div>

<div class="wds-table-fields-group">
	<div class="wds-table-fields">
		<div class="label">
			<label for="metadesc-bp_profile"
			       class="wds-label"><?php esc_html_e( 'BuddyPress Profile Meta Description', 'wds' ); ?></label>
		</div>
		<div class="fields wds-allow-macros">
			<textarea id='metadesc-bp_profile' name='<?php echo esc_attr( $option_name ); ?>[metadesc-bp_profile]'
			          type='text'
			          class='wds-field'><?php echo esc_textarea( $_view['options']['metadesc-bp_profile'] ); ?></textarea>
		</div>
	</div>
</div>