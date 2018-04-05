<?php
    $post = empty($post) ? null : $post;
	$main_title = empty($main_title) ? '' : $main_title;
	$main_description = empty($main_description) ? '' : $main_description;
	$field_name = empty($field_name) ? '' : $field_name;
	$disabled = empty($disabled) ? false : true;
	$current_title = empty($current_title) ? '' : $current_title;
	$title_placeholder = empty($title_placeholder) ? '' : $title_placeholder;
	$current_description = empty($current_description) ? '' : $current_description;
	$description_placeholder = empty($description_placeholder) ? '' : $description_placeholder;
	$images = empty($images) ? array() : $images;
	$images_available = !empty($images) && is_array($images);
	$single_image = empty($single_image) ? false : true;
?>
<div class="wds-table-fields-group wds-separator-top">
    <div class="wds-table-fields">
        <div class="label">
            <label class="wds-label"><?php echo esc_html($main_title); ?></label>
            <p class="wds-label-description"><?php echo esc_html($main_description); ?></p>
        </div>
        <div class="fields">
            <div class="wds-toggleable inverted <?php echo $disabled ? 'inactive' : ''; ?>">
				<?php
					$this->_render('toggle-item', array(
						'inverted'   => true,
						'field_name' => $field_name . '[disabled]',
						'checked'    => checked($disabled, true, false),
						'item_label' => esc_html__('Enable for this post', 'wds'),
					));
				?>
                <div class="wds-toggleable-inside wds-toggleable-inside-box wds-table-fields-group <?php echo esc_attr($field_name); ?>-meta">
                    <div class="wds-table-fields wds-table-fields-stacked">
                        <div class="label">
                            <label for="<?php echo esc_attr($field_name); ?>-title" class="wds-label"><?php esc_html_e('Title', 'wds'); ?></label>
                        </div>
                        <div class="fields">
                            <input type="text"
                                   id="<?php echo esc_attr($field_name); ?>-title"
                                   name="<?php echo esc_attr($field_name); ?>[title]"
                                   placeholder="<?php echo esc_attr(smartcrawl_replace_vars($title_placeholder, $post)); ?>"
                                   value="<?php echo esc_attr($current_title); ?>"/>
                        </div>
                    </div>

                    <div class="wds-table-fields wds-table-fields-stacked">
                        <div class="label">
                            <label for="<?php echo esc_attr($field_name); ?>-description" class="wds-label">
                                <?php esc_html_e('Description', 'wds'); ?>
                            </label>
                        </div>
                        <div class="fields">
										<textarea name="<?php echo esc_attr($field_name); ?>[description]"
                                                  placeholder="<?php echo esc_attr(smartcrawl_replace_vars($description_placeholder, $post)); ?>"
                                                  id="<?php echo esc_attr($field_name); ?>-description"><?php echo esc_textarea($current_description); ?></textarea>
                        </div>
                    </div>

                    <div class="wds-table-fields wds-table-fields-stacked">
                        <div class="label">
                            <label for="<?php echo esc_attr($field_name); ?>-images" class="wds-label">
								<?php echo $single_image ? esc_html__('Featured Image', 'wds') : esc_html__('Featured Images', 'wds'); ?>
							</label>
                        </div>
                        <div class="fields og-images"
							 data-singular="<?php echo $single_image ? 'true' : 'false'; ?>"
                             data-name="<?php echo esc_attr($field_name); ?>[images]">
							<div class="add-action-wrapper item" style="<?php echo $single_image && $images_available ? 'display:none;' : ''; ?>">
                                <a href="#add" title="<?php esc_attr_e('Add image', 'wds'); ?>">
                                    <i class="wds-icon-plus"></i>
                                </a>
                            </div>
							<?php if ($images_available) : ?>
								<?php foreach ($images as $img) : ?>
                                    <input type="text" class="widefat"
                                           name="<?php echo esc_attr($field_name); ?>[images][]"
                                           value="<?php echo esc_attr($img); ?>"/>
								<?php endforeach; ?>
							<?php endif; ?>
                        </div>
                    </div>

                    <p class="wds-label-description">
						<?php if($single_image): ?>
							<?php esc_html_e('This image will be used as the featured image when the post is shared.', 'wds'); ?>
						<?php else: ?>
							<?php esc_html_e('Each of these images will be available to use as the featured image when the post is shared.', 'wds'); ?>
						<?php endif; ?>
					</p>
                </div>
            </div>
        </div>
    </div>
</div>