<tr class="wphb-minification-row" data-filter="<?php echo $item['handle'] . ' ' . strtolower( $ext ); ?>" data-filter-secondary="<?php echo esc_attr( $filter ); ?>">
	<td class="wphb-minification-td-filename">
		<span class="wphb-filename-extension wphb-filename-extension-<?php echo strtolower( $ext ); ?>"><?php echo $ext; ?></span>
		<div class="wphb-filename-info">
			<span class="wphb-filename-info-name"><?php echo $item['handle']; ?></span>
			<a class="wphb-filename-info-url" target="_blank" href="<?php echo esc_url( $full_src ); ?>"><?php echo $rel_src; ?></a>
		</div>
		<?php if ( $row_error ): ?>
			<p class="wphb-label wphb-label-error"><?php printf( __( '<strong>Error:</strong> %s', 'wphb' ), $row_error['error'] ); ?></p>
		<?php endif; ?>
	</td>
	<td class="wphb-minification-td-include wphb-table-td-has-tooltip">
		<div class="tooltip-box">
			<span class="toggle" tooltip="<?php _e( 'Include/Exclude file', 'wphb' ); ?>">
				<input type="checkbox" <?php disabled( in_array( 'include', $disable_switchers ) ); ?> id="wphb-minification-include-<?php echo strtolower( $ext ) . '-' . $item['handle']; ?>" class="toggle-checkbox toggle-include" name="<?php echo $base_name; ?>[include]" <?php checked( in_array( $item['handle'], $options['block'][ $type ] ), false ); ?>>
				<label for="wphb-minification-include-<?php echo strtolower( $ext ) . '-' . $item['handle']; ?>" class="toggle-label"></label>
			</span>
		</div>
	</td>
	<td class="wphb-minification-td-minify wphb-table-td-has-tooltip">
		<div class="tooltip-box">
			<span class="toggle" tooltip="<?php _e( 'Reduce file size', 'wphb' ); ?>">
				<input type="checkbox" <?php disabled( in_array( 'minify', $disable_switchers ) ); ?> id="wphb-minification-minify-<?php echo strtolower( $ext ) . '-' . $item['handle']; ?>" class="toggle-checkbox toggle-minify" name="<?php echo $base_name; ?>[minify]" <?php checked( in_array( $item['handle'], $options['dont_minify'][ $type ] ), false ); ?>>
				<label for="wphb-minification-minify-<?php echo strtolower( $ext ) . '-' . $item['handle']; ?>" class="toggle-label"></label>
			</span>
		</div>
	</td>
	<td class="wphb-minification-td-combine wphb-table-td-has-tooltip">
		<div class="tooltip-box">
			<span class="toggle" tooltip="<?php _e( 'Merge with other files', 'wphb' ); ?>">
				<input type="checkbox" <?php disabled( in_array( 'combine', $disable_switchers ) ); ?> id="wphb-minification-combine-<?php echo strtolower( $ext ) . '-' . $item['handle']; ?>" class="toggle-checkbox toggle-combine" name="<?php echo $base_name; ?>[combine]" <?php checked( in_array( $item['handle'], $options['dont_combine'][ $type ] ), false ); ?>>
				<label for="wphb-minification-combine-<?php echo strtolower( $ext ) . '-' . $item['handle']; ?>" class="toggle-label"></label>
			</span>
		</div>
	</td>
	<td class="wphb-minification-td-position wphb-table-td-has-tooltip">
		<div class="tooltip-box">
			<span class="radio-group with-icon">
				<input type="radio" class="toggle-position-footer" id="wphb-minification-position-footer-<?php echo strtolower( $ext ) . '-' . $item['handle']; ?>" name="<?php echo $base_name; ?>[position]" value="footer" <?php checked( $position, 'footer' ); ?> />
				<label for="wphb-minification-position-footer-<?php echo strtolower( $ext ) . '-' . $item['handle']; ?>">
					<span tooltip="<?php _e( 'Footer', 'wphb' ); ?>"></span>
					<i class="dev-icon dev-icon-pos_footer"></i>
				</label>
				<input type="radio" class="toggle-position-header" id="wphb-minification-position-header-<?php echo strtolower( $ext ) . '-' . $item['handle']; ?>" name="<?php echo $base_name; ?>[position]" value="header" <?php checked( $position, 'header' ); ?> />
				<label for="wphb-minification-position-header-<?php echo strtolower( $ext ) . '-' . $item['handle']; ?>">
					<span tooltip="<?php _e( 'Header', 'wphb' ); ?>"></span>
					<i class="dev-icon dev-icon-pos_header"></i>
				</label>
				<input type="radio" class="toggle-position-default" id="wphb-minification-position-default-<?php echo strtolower( $ext ) . '-' . $item['handle']; ?>" name="<?php echo $base_name; ?>[position]" value="" <?php checked( empty( $position ) ); ?> />
				<label for="wphb-minification-position-default-<?php echo strtolower( $ext ) . '-' . $item['handle']; ?>">
					<span tooltip="<?php _e( 'Original', 'wphb' ); ?>"></span>
					<i class="dev-icon dev-icon-pos_middle"></i>
				</label>
			</span>
		</div>
	</td>
	<td class="wphb-minification-td-size-reduction">
		<?php if ( $original_size && $compressed_size ): ?>
			<div class="wphb-pills-group">
				<span class="wphb-pills with-arrow right grey"><?php echo $original_size; ?>KB</span><span class="wphb-pills"><?php echo $compressed_size; ?>KB</span>
			</div>
		<?php else: ?>
			<span class="wphb-pills">
				<?php _e( 'No info', 'wphb' ); ?>
			</span>
		<?php endif; ?>
	</td>
</tr>