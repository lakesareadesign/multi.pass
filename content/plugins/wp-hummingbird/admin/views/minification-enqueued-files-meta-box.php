<div class="wphb-table-wrapper complex">

	<div id="wphb-minification-filter" class="wphb-block-content-grey">
		<div class="wphb-minification-filter-block" id="wphb-minification-filter-block-search">
			<h3 class="wphb-block-title"><?php _e( 'Filter', 'wphb' ); ?></h3>
			<p class="wphb-block-subtitle"><?php _e( 'Filter plugin or theme, or search by name or extension (js/css/other).', 'wphb' ); ?></p>

			<div class="wphb-filters-data">

				<div class="wphb-minification-filter-field wphb-minification-filter-field-select">
					<label for="wphb-secondary-filter" class="screen-reader-text"><?php _e( 'Filter plugin or theme.', 'wphb' ); ?></label>
					<select name="wphb-secondary-filter" id="wphb-secondary-filter">
						<option value=""><?php esc_html_e( 'All', 'wphb' ); ?></option>
						<?php foreach ( $selector_filter as $secondary_filter ): ?>
							<option value="<?php echo esc_attr( $secondary_filter ); ?>"><?php echo esc_html( $secondary_filter ); ?></option>
						<?php endforeach; ?>
					</select>
				</div>

				<div class="wphb-minification-filter-field wphb-minification-filter-field-search">
					<label for="wphb-s" class="screen-reader-text"><?php _e( 'Search files', 'wphb' ); ?></label>
					<input type="text" id="wphb-s" name="s" placeholder="<?php esc_attr_e( 'Search files', 'wphb' ); ?>" autocomplete="off">
				</div>

			</div>

		</div>

		<div class="wphb-minification-filter-block" id="wphb-minification-filter-block-bulk">
			<h3 class="wphb-block-title"><?php _e( 'Bulk Update', 'wphb' ); ?></h3>
			<p class="wphb-block-subtitle"><?php _e( 'Update all files in the list below with these settings.', 'wphb' ); ?></p>

			<div class="wphb-filters-data">

				<div class="wphb-minification-filter-field wphb-minification-filter-field-actions">

					<div class="wphb-minification-filter-field-item">
						<p class="wphb-filter-field-title"><?php _e( 'Include', 'wphb' ); ?></p>
						<span class="toggle" tooltip="<?php _e( 'Include/Exclude file', 'wphb' ); ?>">
							<input type="checkbox" class="toggle-checkbox filter-toggles" data-toggles="include" name="filter-include" id="filter-include" <?php checked( true ); ?>>
							<label for="filter-include" class="toggle-label"></label>
						</span>
					</div>

					<div class="wphb-minification-filter-field-item">
						<p class="wphb-filter-field-title"><?php _e( 'Minify', 'wphb' ); ?></p>
						<span class="toggle" tooltip="<?php _e( 'Reduce file size', 'wphb' ); ?>">
							<input type="checkbox" class="toggle-checkbox filter-toggles" data-toggles="minify" name="filter-minify" id="filter-minify" <?php checked( true ); ?>>
							<label for="filter-minify" class="toggle-label"></label>
						</span>
					</div>

					<div class="wphb-minification-filter-field-item">
						<p class="wphb-filter-field-title"><?php _e( 'Combine', 'wphb' ); ?></p>
						<span class="toggle" tooltip="<?php _e( 'Merge with other files', 'wphb' ); ?>">
							<input type="checkbox" class="toggle-checkbox filter-toggles" data-toggles="combine" name="filter-combine" id="filter-combine" <?php checked( true ); ?>>
							<label for="filter-combine" class="toggle-label"></label>
						</span>
					</div>
				</div>

				<div class="wphb-minification-filter-field wphb-minification-filter-field-position">
					<p class="wphb-filter-field-title"><?php _e( 'Position', 'wphb' ); ?></p>
					<div class="tooltip-box">
						<span class="radio-group with-icon">
							<input type="radio" id="filter-position-footer" data-toggles="footer" name="filter-position" value="footer" <?php checked( false ); ?> />
							<label for="filter-position-footer">
								<span tooltip="<?php _e( 'Footer', 'wphb' ); ?>"></span>
								<i class="dev-icon dev-icon-pos_footer"></i>
							</label>
							<input type="radio" id="filter-position-header" data-toggles="header" name="filter-position" value="header" <?php checked( false ); ?> />
							<label for="filter-position-header">
								<span tooltip="<?php _e( 'Header', 'wphb' ); ?>"></span>
								<i class="dev-icon dev-icon-pos_header"></i>
							</label>
							<input type="radio" id="filter-position-default" data-toggles="default" name="filter-position" value="" <?php checked( true ); ?> />
							<label for="filter-position-default">
								<span tooltip="<?php _e( 'Original', 'wphb' ); ?>"></span>
								<i class="dev-icon dev-icon-pos_middle"></i>
							</label>
						</span>
					</div>
				</div>

			</div>
		</div>

	</div>

	<table class="list-table hover-effect wphb-table wphb-enqueued-files">
		<thead>
			<tr>
				<th><?php _e( 'File Details', 'wphb' ); ?></th>
				<th><?php _e( 'Include', 'wphb' ); ?></th>
				<th><?php _e( 'Minify', 'wphb' ); ?></th>
				<th><?php _e( 'Combine', 'wphb' ); ?></th>
				<th><?php _e( 'Position', 'wphb' ); ?></th>
				<th><?php _e( 'Size Reduction', 'wphb' ); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php echo $styles_rows; ?>
			<?php echo $scripts_rows; ?>
		</tbody>
	</table>
</div>

<?php wp_nonce_field( 'wphb-enqueued-files' ); ?>