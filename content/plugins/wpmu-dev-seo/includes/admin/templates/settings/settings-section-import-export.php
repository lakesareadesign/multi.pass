<?php wp_nonce_field( 'wds-io-nonce', '_wds_nonce' ); ?>
<div class="wds-io">
	<div class="wds-table-fields">
		<div class="label">
			<label class="wds-label"><?php esc_html_e( 'Export', 'wds' ); ?></label>
			<p class="wds-label-description"><?php esc_html_e( 'Export your full SmartCrawl configuration to use on another site.', 'wds' ); ?></p>
		</div>
		<div class="fields wds-io wds-export">
			<button name="io-action" value="export"
			        class="button button-dark-o"><?php esc_html_e( 'Export', 'wds' ); ?></button>
		</div>
	</div>

	<div class="wds-table-fields wds-separator-top">
		<div class="label">
			<label class="wds-label"><?php esc_html_e( 'Import', 'wds' ); ?></label>
			<p class="wds-label-description"><?php esc_html_e( 'Use this tool to import your SmartCrawl settings from another site.', 'wds' ); ?></p>
		</div>
		<div class="fields wds-io wds-import">
			<div>
				<label class="wds-label"><?php esc_html_e( 'SmartCrawl', 'wds' ); ?></label>
				<p class="wds-label-description">
					<?php esc_html_e( 'Import your exported SmartCrawl XML settings file.', 'wds' ); ?>
				</p>

				<div class="wds-styleable-file-input">
					<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo esc_attr( wp_max_upload_size() ); ?>"/>
					<input id="wds_import_json" type="file" name="wds_import_json"/>
					<input type="text" readonly/>
					<label for="wds_import_json"
					       class="button button-dark-o"><?php esc_html_e( 'Select File', 'wds' ); ?></label>
				</div>
				<button name="io-action" value="import"
				        class="button button-dark"><?php esc_html_e( 'Import', 'wds' ); ?></button>
			</div>
			<?php if ( is_main_site() ): ?>
				<div class="wds-separator-top">
					<label class="wds-label"><?php esc_html_e( 'Third Party', 'wds' ); ?></label>
					<p class="wds-label-description">
						<?php esc_html_e( 'Automatically import your SEO configuration from other SEO plugins.', 'wds' ); ?>
					</p>
					<div class="wds-third-party-plugins">
						<div class="wds-yoast wds-third-party-plugin">
							<div class="wds-third-party-plugin-name"><?php esc_html_e( 'Yoast SEO', 'wds' ); ?></div>
							<div class="wds-third-party-plugin-button">
								<button
									class="button button-dark button-small"><?php esc_html_e( 'Import', 'wds' ); ?></button>
							</div>
						</div>
						<div class="wds-aioseop wds-third-party-plugin">
							<div
								class="wds-third-party-plugin-name"><?php esc_html_e( 'All In One SEO', 'wds' ); ?></div>
							<div class="wds-third-party-plugin-button">
								<button
									class="button button-dark button-small"><?php esc_html_e( 'Import', 'wds' ); ?></button>
							</div>
						</div>
					</div>
					<p class="wds-label-description">
						<?php esc_html_e( 'Automatically import your SEO configuration from other SEO plugins. Note: This will override all of your current settings. We recommend exporting your current settings first, just in case.', 'wds' ); ?>
					</p>
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>
<?php $this->_render( 'settings/import-status-modal' ); ?>