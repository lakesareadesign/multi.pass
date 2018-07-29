<?php
/**
 * @var string $for_type
 */
$section_enabled_field_id = empty( $section_enabled_field_id ) ? '' : $section_enabled_field_id;
$section_enabled = empty( $section_enabled ) ? '' : $section_enabled;
$section_title = empty( $section_title ) ? '' : $section_title;
$section_description = empty( $section_description ) ? '' : $section_description;
$option_name = empty( $option_name ) ? '' : $option_name;
$title_field_id = empty( $title_field_id ) ? '' : $title_field_id;
$current_title = empty( $current_title ) ? '' : $current_title;

$description_field_id = empty( $description_field_id ) ? '' : $description_field_id;
$current_description = empty( $current_description ) ? '' : $current_description;

$images_field_id = empty( $images_field_id ) ? '' : $images_field_id;
$current_images = empty( $current_images ) ? array() : $current_images;
$images_available = ! empty( $current_images ) && is_array( $current_images );
$single_image = empty( $single_image ) ? false : true;

$title_placeholder = ( ! empty( $_view['options']["title-{$for_type}"] ) ? $_view['options']["title-{$for_type}"] : '' );
$description_placeholder = ( ! empty( $_view['options']["metadesc-{$for_type}"] ) ? $_view['options']["metadesc-{$for_type}"] : '' );
?>
<div class="wds-toggle-table">
    <span class="toggle wds-toggle">
        <input
	        class="toggle-checkbox"
	        value='1' <?php checked( $section_enabled, true ); ?>
	        id='<?php echo esc_attr( $section_enabled_field_id ); ?>'
	        name='<?php echo esc_attr( $option_name ); ?>[<?php echo esc_attr( $section_enabled_field_id ); ?>]'
	        type='checkbox' autocomplete="off"/>
        <label class="toggle-label" for="<?php echo esc_attr( $section_enabled_field_id ); ?>"></label>
    </span>

	<div class="wds-toggle-description">
		<label class="wds-label" for="<?php echo esc_attr( $section_enabled_field_id ); ?>">
			<?php echo esc_html( $section_title ); ?>
		</label>
		<p class="wds-label-description">
			<?php echo esc_html( $section_description ); ?>
		</p>

		<div class="wds-table-fields-group wds-toggleable-inside-box">

			<div class="wds-table-fields wds-table-fields-stacked">
				<div class="label">
					<label for="<?php echo esc_attr( $title_field_id ); ?>" class="wds-label">
						<?php esc_html_e( 'Title', 'wds' ); ?>
					</label>
				</div>
				<div class="fields wds-allow-macros">
					<input
						id='<?php echo esc_attr( $title_field_id ); ?>'
						name='<?php echo esc_attr( $option_name ); ?>[<?php echo esc_attr( $title_field_id ); ?>]'
						size='' type='text' class='wds-field'
						placeholder="<?php echo esc_attr( $title_placeholder ); ?>"
						value='<?php echo esc_attr( $current_title ); ?>'/>
				</div>
			</div>

			<div class="wds-table-fields wds-table-fields-stacked">
				<div class="label">
					<label for="<?php echo esc_attr( $description_field_id ); ?>" class="wds-label">
						<?php esc_html_e( 'Description', 'wds' ); ?>
					</label>
				</div>
				<div class="fields wds-allow-macros">
                    <textarea
	                    id='<?php echo esc_attr( $description_field_id ); ?>'
	                    name='<?php echo esc_attr( $option_name ); ?>[<?php echo esc_attr( $description_field_id ); ?>]'
	                    placeholder="<?php echo esc_attr( $description_placeholder ); ?>"
	                    type='text' class='wds-field'><?php echo esc_textarea( $current_description ); ?></textarea>
				</div>
			</div>

			<div class="wds-table-fields wds-table-fields-stacked">
				<div class="label">
					<label for="<?php echo esc_attr( $images_field_id ); ?>" class="wds-label">
						<?php if ( $single_image ): ?>
							<?php esc_html_e( 'Default Featured Image', 'wds' ); ?>
						<?php else: ?>
							<?php esc_html_e( 'Default Featured Images', 'wds' ); ?>
						<?php endif; ?>
					</label>
				</div>
				<div
					class="fields og-images <?php echo esc_attr( $images_field_id ); ?>"
					data-singular="<?php echo $single_image ? 'true' : 'false'; ?>"
					data-name='<?php echo esc_attr( $option_name ); ?>[<?php echo esc_attr( $images_field_id ); ?>]'>

					<div class="wds-has-tooltip add-action-wrapper item"
					     data-content="<?php esc_attr_e( 'Add featured image', 'wds' ); ?>"
					     style="<?php echo $single_image && $images_available ? 'display:none;' : ''; ?>">
						<a href="#add" id="<?php echo esc_attr( $images_field_id ); ?>" title="<?php esc_attr_e( 'Add image', 'wds' ); ?>"><i class="wds-icon-plus"></i></a>
					</div>
					<?php foreach ( $current_images as $image ): ?>
						<input
							name='<?php echo esc_attr( $option_name ); ?>[<?php echo esc_attr( $images_field_id ); ?>][]'
							type='text'
							value='<?php echo esc_attr( $image ); ?>'/>
					<?php endforeach; ?>
				</div>
			</div>
			<p class="wds-label-description">
				<?php if ( $single_image ): ?>
					<?php esc_html_e( "This image will be available to use if the post or page being shared doesn't contain an image.", 'wds' ); ?>
				<?php else: ?>
					<?php esc_html_e( "These images will be available to use if the post or page being shared doesn't contain any images.", 'wds' ); ?>
				<?php endif; ?>
			</p>

			<?php wp_enqueue_media(); ?>
			<?php wp_enqueue_style( 'wds-admin-opengraph' ); ?>
		</div>
	</div>
</div>