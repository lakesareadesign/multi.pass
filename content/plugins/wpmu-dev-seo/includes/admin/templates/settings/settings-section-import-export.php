<div class="wds-io">
	<div class="wds-table-fields">
		<div class="label">
			<label class="wds-label"><?php esc_html_e('Export', 'wds'); ?></label>
			<p class="wds-label-description"><?php esc_html_e('Export your full SmartCrawl configuration to use on another site.', 'wds'); ?></p>
		</div>
		<div class="fields wds-io wds-export">
				<?php wp_nonce_field('wds-export', 'wds-settings-action-export'); ?>
				<button name="io-action" value="export" class="button button-dark-o"><?php esc_html_e('Export', 'wds'); ?></button>
		</div>
	</div>

	<div class="wds-table-fields wds-separator-top">
		<div class="label">
			<label class="wds-label"><?php esc_html_e('Import', 'wds'); ?></label>
			<p class="wds-label-description"><?php esc_html_e('Use this tool to import your SmartCrawl settings from another site.', 'wds'); ?></p>
		</div>
		<div class="fields wds-io wds-import">
				<?php wp_nonce_field('wds-import', 'wds-settings-action-import'); ?>
				<div class="wds-styleable-file-input">
					<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo wp_max_upload_size(); ?>" />
					<input id="wds_import_json" type="file" name="wds_import_json" />
					<input type="text" readonly />
					<label for="wds_import_json" class="button button-dark-o"><?php esc_html_e('Select File', 'wds'); ?></label>
				</div>
				<button name="io-action" value="import" class="button button-dark"><?php esc_html_e('Import', 'wds'); ?></button>
		</div>
	</div>
</div>