<?php
	$smartcrawl_options = empty( $_view['options'] ) ? array() : $_view['options'];
	$option_name = empty( $_view['option_name'] ) ? '' : $_view['option_name'];
	$section_title = empty( $section_title ) ? '' : $section_title;
	$section_description = empty( $section_description ) ? '' : $section_description;
	$section_template = empty( $section_template ) ? '' : $section_template;
	$section_args = empty( $section_args ) ? array() : $section_args;
	$section_type = empty( $section_type ) ? '' : $section_type;

	$section_enabled_option = empty( $section_enabled_option ) ? '' : $section_enabled_option;
	$section_enabled = ! empty( $smartcrawl_options[ $section_enabled_option ] );
	$section_enabled_option_name = $option_name . '[' . $section_enabled_option . ']';
	$show_accordion = empty( $show_accordion ) ? false : $show_accordion;
	$accordion_section_open = empty( $accordion_section_open ) ? false : $accordion_section_open;
?>

<?php if ( $show_accordion ) :  ?>
	<div class="wds-accordion-section <?php echo $accordion_section_open ? esc_attr( 'open' ) : ''; ?>">
<?php endif; ?>

<?php if ( $section_title ) :  ?>
	<h2 class="tab-sub-title <?php echo $show_accordion ? esc_attr( 'wds-accordion-handle' ) : ''; ?>">
		<?php echo esc_html( $section_title ); ?>

		<?php if ( $section_enabled_option ) :  ?>
			<span class="toggle">
				<input
					type="checkbox"
					class="toggle-checkbox"
					value='yes'
					name="<?php echo esc_attr( $section_enabled_option_name ); ?>"
					id="<?php echo esc_attr( $section_enabled_option_name ); ?>"
					<?php checked( $section_enabled ); ?> />
				<label class="toggle-label" for="<?php echo esc_attr( $section_enabled_option_name ); ?>"></label>
			</span>
			<span class="wds-archive-disabled-label"><?php _e( 'Disabled', 'wds' ); ?></span>
		<?php endif; ?>
	</h2>
<?php endif; ?>

<div class="wds-content-tabs-inner <?php echo $show_accordion ? esc_attr( 'wds-accordion-content' ) : ''; ?>" data-type="<?php echo esc_attr( $section_type ); ?>">
	<?php if ( $section_description ) :  ?>
		<p class="wds-content-tabs-description"><?php echo esc_html( $section_description ); ?></p>
	<?php endif; ?>

	<?php $this->_render( $section_template, $section_args ); ?>
</div>

<?php if ( $show_accordion ) :  ?>
	</div>
<?php endif; ?>