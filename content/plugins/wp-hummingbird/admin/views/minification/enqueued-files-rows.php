<input type="hidden" name="<?php echo $base_name; ?>[handle]" value="<?php echo $item['handle']; ?>"/>
<div class="wphb-border-row
	<?php echo ( in_array( $item['handle'], $options['block'][ $type ] ) ) ? 'disabled' : ''; ?>"
	 id="wphb-file-<?php echo strtolower( $ext ) . '-' . $item['handle']; ?>"
     data-filter="<?php echo $item['handle'] . ' ' . strtolower( $ext ); ?>"
     data-filter-secondary="<?php echo esc_attr( $filter ); echo 'OTHER' === $ext ? 'other' : ''?>">

	<div class="wphb-minification-file-select">
		<label for="minification-file-<?php echo strtolower( $ext ) . '-' . $item['handle']; ?>" class="screen-reader-text"><?php _e( 'Hello', 'wphb' ); ?></label>
		<input type="checkbox" data-type="<?php echo strtolower( $ext ); ?>" data-handle="<?php echo $item['handle']; ?>" id="minification-file-<?php echo strtolower( $ext ) . '-' . $item['handle']; ?>" name="minification-file[]" class="wphb-minification-file-selector">
	</div>
    <div class="wphb-minification-file-details">
        <span class="wphb-filename-extension wphb-filename-extension-<?php echo strtolower( $ext ); ?>"><?php echo substr( $ext, 0, 3 ); ?></span>
        <div class="wphb-filename-info">
            <span class="wphb-filename-info-name"><?php echo $item['handle']; ?></span>
            <a class="wphb-filename-info-url" target="_blank" href="<?php echo esc_url( $full_src ); ?>"><?php echo $rel_src; ?></a>
	        <?php if ( $row_error ): ?>
                <p class="wphb-label wphb-label-error"><?php printf( __( '<strong>Error:</strong> %s', 'wphb' ), $row_error['error'] ); ?></p>
	        <?php endif; ?>
        </div>
    </div>

    <div class="wphb-minification-exclude">
        <div class="tooltip-box">
            <span class="toggle tooltip-s tooltip-right" tooltip="<?php _e( 'Include/Exclude file', 'wphb' ); ?>">
                <label for="wphb-minification-include-<?php echo strtolower( $ext ) . '-' . $item['handle']; ?>"
                       class="toggle-cross"
                       data-type="<?php echo strtolower( $ext ); ?>"
                       data-handle="<?php echo $item['handle']; ?>">
					<input type="checkbox"
                           <?php disabled( in_array( 'include', $disable_switchers ) ); ?>
                           id="wphb-minification-include-<?php echo strtolower( $ext ) . '-' . $item['handle']; ?>"
                           class="toggle-checkbox toggle-include"
                           name="<?php echo $base_name; ?>[include]"
                           <?php checked( in_array( $item['handle'], $options['block'][ $type ] ), false ); ?>
                           value="1">
                    <i class="<?php echo ( in_array( $item['handle'], $options['block'][ $type ] ) ) ? 'wdv-icon wdv-icon-refresh' : 'dev-icon dev-icon-cross'; ?>"></i>
                </label>
            </span>
        </div>
    </div>

    <div class="wphb-minification-row-details">
        <div class="wphb-minification-configuration">
            <strong><?php _e( 'Configuration', 'wphb' ); ?></strong>
            <div class="tooltip-box">
                <div class="checkbox-group">
	                <?php
	                $tooltip = __( "Compress this file to reduce it’s filesize", 'wphb' );
	                if ( in_array( 'minify', $disable_switchers ) && ! in_array( $item['handle'], $options['block'][ $type ] ) ) {
		                $tooltip = __( "Hummingbird can't compress this file", 'wphb' );
		                $dont_minify = true;
	                } ?>
                    <input type="checkbox" <?php disabled( in_array( 'minify', $disable_switchers ) || in_array( $item['handle'], $options['block'][ $type ] ) ); ?> id="wphb-minification-minify-<?php echo strtolower( $ext ) . '-' . $item['handle']; ?>" class="toggle-checkbox toggle-minify" name="<?php echo $base_name; ?>[minify]" <?php checked( in_array( $item['handle'], $options['dont_minify'][ $type ] ), false ); ?>>
                    <label for="wphb-minification-minify-<?php echo strtolower( $ext ) . '-' . $item['handle']; ?>" class="toggle-label">
                        <span class="toggle tooltip-l" tooltip="<?php echo $tooltip; ?>"></span>
                        <i class="hb-icon-minify"></i>
                        <span><?php _e( 'Minify', 'wphb' ); ?></span>
                    </label>
	                <?php
	                $tooltip = __( 'Combine this file with others if possible', 'wphb' );
	                if ( in_array( 'combine', $disable_switchers ) && ! in_array( $item['handle'], $options['block'][ $type ] ) ) {
		                $tooltip = __( "Hummingbird can't combine this file with others", 'wphb' );
		                $dont_combine = true;
	                } ?>
                    <input type="checkbox" <?php disabled( in_array( 'combine', $disable_switchers ) || in_array( $item['handle'], $options['block'][ $type ] )  ); ?> class="toggle-checkbox toggle-combine" name="<?php echo $base_name; ?>[combine]" id="wphb-minification-combine-<?php echo strtolower( $ext ) . '-' . $item['handle']; ?>" <?php checked( in_array( $item['handle'], $options['combine'][ $type ] ) ); ?>>
                    <label for="wphb-minification-combine-<?php echo strtolower( $ext ) . '-' . $item['handle']; ?>" class="toggle-label">
                        <span class="toggle tooltip-l" tooltip="<?php echo $tooltip; ?>"></span>
                        <i class="hb-icon-minify-combine"></i>
                        <span><?php _e( 'Combine', 'wphb' ); ?></span>
                    </label>
                    <input type="checkbox" <?php disabled( in_array( 'position', $disable_switchers ) || in_array( $item['handle'], $options['block'][ $type ] )  ); ?> class="toggle-checkbox toggle-position-footer" name="<?php echo $base_name; ?>[position]" id="wphb-minification-position-footer-<?php echo strtolower( $ext ) . '-' . $item['handle']; ?>" <?php checked( $position, 'footer' ); ?> value="footer">
                    <label for="wphb-minification-position-footer-<?php echo strtolower( $ext ) . '-' . $item['handle']; ?>" class="toggle-label">
                        <span class="toggle tooltip-l" tooltip="<?php _e( 'Load this file in the footer of the page', 'wphb' ); ?>"></span>
                        <i class="hb-icon-minify-footer"></i>
                        <span><?php _e( 'Footer', 'wphb' ); ?></span>
                    </label>
                </div>
            </div>
        </div><!-- end wphb-minification-configuration -->

        <div class="wphb-minification-file-size">
            <strong><?php _e( 'File size', 'wphb' ); ?></strong>
	        <?php if ( $original_size && $compressed_size ): ?>
                <div>
                    <span class=""><?php echo $original_size; ?>KB</span>
                    <span class="dev-icon dev-icon-caret_down"></span>
                    <span class=""><?php echo $compressed_size; ?>KB</span>
                </div>
                <div class="wphb-scan-progress">
                    <div class="wphb-scan-progress-bar">
                        <span style="width: 80%"></span>
                    </div>
                </div>
	        <?php elseif ( isset( $dont_minify ) && isset( $dont_combine ) && ! in_array( $item['handle'], $options['block'][ $type ] ) ): ?>
                <span class="tooltip tooltip-s" tooltip="<?php _e( 'This file type cannot be minified and will be left alone', 'wphb' ); ?>"><?php _e( 'Ignored', 'wphb' ); ?></span>
            <?php elseif ( in_array( $item['handle'], $options['block'][ $type ] ) ): ?>
                <span class="tooltip tooltip-s" tooltip="<?php _e( 'Excluded from processing', 'wphb' ); ?>"><?php _e( 'Excluded', 'wphb' ); ?></span>
            <?php else: ?>
                <span class="tooltip tooltip-s" tooltip="<?php _e( 'Waiting for a visitor to visit your homepage', 'wphb' ); ?>"><?php _e( 'Pending', 'wphb' ); ?></span>
	        <?php endif; ?>
        </div><!-- end wphb-minification-file-size -->
    </div><!-- end wphb-minification-row-details -->
</div><!-- end wphb-border-row -->