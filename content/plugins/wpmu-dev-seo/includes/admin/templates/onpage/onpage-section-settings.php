<?php $separators = empty($separators) ? array() : $separators; ?>
<div class="wds-table-fields-group">
	<div class="wds-table-fields">
		<div class="label">
			<label for="separator" class="wds-label"><?php esc_html_e( 'Separator' , 'wds' ); ?></label>
			<p class="wds-label-description">
				<?php _e('The separator refers to the break between variables which you can use by referencing the %%sep%% tag. You can choose a preset one or bake your own.', 'wds'); ?>
			</p>
		</div>
		<div class="fields">
			<div class="wds-preset-separators">
				<?php foreach($separators as $key => $separator): ?>
					<input
						type="radio"
						name="<?php echo esc_attr($_view['option_name']); ?>[preset-separator]"
						id="separator-<?php echo esc_attr($key); ?>"
						value="<?php echo esc_attr($key); ?>"
						autocomplete="off"
						<?php echo $_view['options']['preset-separator'] == $key ? 'checked="checked"' : ''; ?> />
					<label class="separator-selector" for="separator-<?php echo esc_attr($key); ?>">
							<?php echo esc_html($separator); ?>
					</label>
				<?php endforeach; ?>
			</div>
			<p class="wds-custom-separator-message"><?php _e('Or, choose your own custom separator.', 'wds') ?></p>
			<input
				id='separator'
				placeholder="<?php _e('Enter custom separator', 'wds'); ?>"
				name='<?php echo esc_attr($_view['option_name']); ?>[separator]'
				type='text'
				class='wds-field'
				value='<?php echo esc_attr($_view['options']['separator']); ?>' />
		</div>
	</div>
</div>