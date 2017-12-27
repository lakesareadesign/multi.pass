<div class="wds-toggleable inactive wds-edit-meta-toggleable">
	<label>
		<a class="button button-dark button-small"><?php esc_html_e('Edit Meta', 'wds'); ?></a>
		<input type="checkbox" class="toggle-checkbox"/>
	</label>

	<div class="wds-toggleable-inside wds-toggleable-inside-box">
		<div class="wds-table-fields wds-table-fields-stacked">
			<?php
				$title_placeholder = wds_get_seo_title();
				if (!$title_placeholder) $title_placeholder = '';

				$desc_placeholder = wds_get_seo_desc();
				if (!$desc_placeholder) $desc_placeholder = '';
			?>

			<?php if (apply_filters('wds-metabox-visible_parts-title_area', true)): ?>
				<div class="label">
					<label class="wds-label" for="wds_title">
						<?php esc_html_e('SEO Title', 'wds'); ?>
						<span><?php esc_html_e('- Include your focus keywords. 50-70 characters recommended.', 'wds'); ?></span>
					</label>
				</div>
				<div class="fields">
					<input type='text'
                           id='wds_title'
                           placeholder='<?php echo esc_html($title_placeholder); ?>'
                           name='wds_title'
                           value='<?php echo esc_html(wds_get_value('title')); ?>'
                           class='wds wds-meta-field'/>
				</div>
			<?php endif; ?>

			<?php if (apply_filters('wds-metabox-visible_parts-description_area', true)): ?>
				<div class="label">
					<label class="wds-label" for="wds_metadesc">
						<?php esc_html_e('Description', 'wds'); ?>
						<span><?php esc_html_e('- Recommended minimum of 135 characters, maximum 160.', 'wds'); ?></span>
					</label>
				</div>
				<div class="fields">
					<textarea rows='2'
                              name='wds_metadesc'
                              placeholder='<?php echo esc_html($desc_placeholder); ?>'
                              id='wds_metadesc'
                              class='wds wds-meta-field'><?php echo esc_html(wds_get_value('metadesc')); ?></textarea>
				</div>
			<?php endif; ?>

			<?php if (apply_filters('wds-metabox-visible_parts-keywords_area', true)): ?>
				<div class="label">
					<label class="wds-label" for="wds_keywords">
						<?php esc_html_e('Keywords', 'wds'); ?>
						<span><?php esc_html_e('- Try to avoid stop words like ‘and’ and ‘the’ which search engines ignore.', 'wds'); ?></span>
					</label>
				</div>
				<div class="fields">
					<input type='text'
                           id='wds_keywords'
                           name='wds_keywords'
                           value='<?php echo esc_html(wds_get_value('keywords')); ?>'
                           class='wds'/>
				</div>

				<div class="wds-extra-keyword-options">
					<div class="label">
						<label class="wds-label" for="wds_news_keywords">
							<?php esc_html_e('News Keywords', 'wds'); ?>
							<span><?php esc_html_e('- Try to avoid stop words like ‘and’ and ‘the’ which search engines ignore.', 'wds'); ?></span>
						</label>
					</div>
					<div class="fields">
						<input type='text'
                               id='wds_news_keywords'
                               name='wds_news_keywords'
                               value='<?php echo esc_attr(wds_get_value('news_keywords')); ?>'
                               class='wds' />
					</div>

					<div class="wds-tags-as-keyword">
						<?php
							$this->_render('toggle-item', array(
								'field_name'       => 'wds_tags_to_keywords',
								'checked'          => wds_get_value('tags_to_keywords') ? 'checked="checked"' : '',
								'item_label'       => esc_html__('Tags As Keywords'),
								'item_description' => esc_html__('If you enable using tags, post tags will be merged in with any other keywords you enter in the text box.'),
							));
						?>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>