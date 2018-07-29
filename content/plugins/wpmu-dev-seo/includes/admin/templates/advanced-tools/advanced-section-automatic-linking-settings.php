<?php
/**
 * Automatic links settings template
 *
 * @package wpmu-dev-seo
 */

$additional_settings = empty( $additional_settings ) ? array() : $additional_settings;
$option_name = empty( $_view['option_name'] ) ? '' : $_view['option_name'];
?>

<div class="wds-table-fields wds-separator-top">
	<div class="label">
		<label class="wds-label"><?php esc_html_e( 'Min lengths', 'wds' ); ?></label>
		<p class="wds-label-description"><?php esc_html_e( 'Define the shortest title and taxonomy length to autolink. Smaller titles will be ignored.', 'wds' ); ?></p>
	</div>

	<div class="fields">
		<div class="row">
			<div class="wds-table-fields wds-table-fields-stacked col-half">
				<div class="label">
					<label for="cpt_char_limit" class="wds-label"><?php esc_html_e( 'Posts & pages', 'wds' ); ?></label>
				</div>
				<div class="fields wds-allow-macros">
					<input id='cpt_char_limit' name='<?php echo esc_attr( $option_name ); ?>[cpt_char_limit]'
					       type='text' class='wds-field'
					       value='<?php echo esc_attr( $_view['options']['cpt_char_limit'] ); ?>'>
				</div>
			</div>

			<div class="wds-table-fields wds-table-fields-stacked col-half">
				<div class="label">
					<label for="tax_char_limit"
					       class="wds-label"><?php esc_html_e( 'Archives & taxonomies', 'wds' ); ?></label>
				</div>
				<div class="fields wds-allow-macros">
					<input id='tax_char_limit' name='<?php echo esc_attr( $option_name ); ?>[tax_char_limit]'
					       type='text' class='wds-field'
					       value='<?php echo esc_attr( $_view['options']['tax_char_limit'] ); ?>'>
				</div>
			</div>
		</div>
		<p class="wds-label-description"><?php esc_html_e( 'We recommend a minimum of 10 chars for each type.', 'wds' ); ?></p>
	</div>
</div>

<div class="wds-table-fields wds-separator-top">
	<div class="label">
		<label class="wds-label"><?php esc_html_e( 'Max limits', 'wds' ); ?></label>
		<p class="wds-label-description"><?php esc_html_e( 'Set the max amount of links you want to appear per post.', 'wds' ); ?></p>
	</div>

	<div class="fields">
		<div class="row">
			<div class="wds-table-fields wds-table-fields-stacked col-half">
				<div class="label">
					<label for="link_limit" class="wds-label"><?php esc_html_e( 'Per post total', 'wds' ); ?></label>
				</div>
				<div class="fields wds-allow-macros">
					<input id='link_limit' name='<?php echo esc_attr( $option_name ); ?>[link_limit]' type='text'
					       class='wds-field' value='<?php echo esc_attr( $_view['options']['link_limit'] ); ?>'>
				</div>
			</div>

			<div class="wds-table-fields wds-table-fields-stacked col-half">
				<div class="label">
					<label for="single_link_limit"
					       class="wds-label"><?php esc_html_e( 'Per keyword group', 'wds' ); ?></label>
				</div>
				<div class="fields wds-allow-macros">
					<input id='single_link_limit' name='<?php echo esc_attr( $option_name ); ?>[single_link_limit]'
					       type='text' class='wds-field'
					       value='<?php echo esc_attr( $_view['options']['single_link_limit'] ); ?>'>
				</div>
			</div>
		</div>
		<p class="wds-label-description"><?php esc_html_e( 'Use 0 to allow unlimited automatic links.', 'wds' ); ?></p>
	</div>
</div>

<?php
$this->_render( 'toggle-group', array(
	'label'       => __( 'Optional Settings', 'wds' ),
	'description' => __( 'Configure extra settings for absolute control over autolinking.', 'wds' ),
	'items'       => $additional_settings,
	'separator'   => true,
) );
?>