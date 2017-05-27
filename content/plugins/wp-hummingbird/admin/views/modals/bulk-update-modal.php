<dialog class="wphb-modal small wphb-progress-modal" id="bulk-update-modal" title="<?php _e( 'Bulk update', 'wphb' ); ?>">
	<div class="wphb-dialog-content">
		<p><?php _e( 'Choose what bulk update actions you wish to apply.', 'wphb' ); ?></p>

		<script type="text/javascript">
            jQuery('label[for^="filter-"]').on('click', function() {
                jQuery(this).toggleClass('toggle-label-background');
            });

            jQuery('.save-batch').on('click', function() {
                var filesCollection = WPHB_Admin.minification.rowsCollection;

                var modal = jQuery( '#bulk-update-modal' );
                // Get the selected batch status
                var minify = modal.find( 'input.filter-minify' ).prop( 'checked' ),
                    combine = modal.find( 'input.filter-combine').prop('checked'),
                    footer = modal.find( 'input.filter-position-footer' ).prop( 'checked' ),
                    selectedFiles = filesCollection.getSelectedItems();

                for ( i in selectedFiles ) {
                    selectedFiles[i].change( 'minify', minify );
                    selectedFiles[i].change( 'combine', combine );
                    selectedFiles[i].change( 'footer', footer );
                }

                // Unset all the values in bulk update checkboxes
                modal.find('input.filter-minify').prop('checked', false);
                modal.find('input.filter-combine').prop('checked', false);
                modal.find('input.filter-position-footer').prop('checked', false);
            });
		</script>

		<div class="tooltip-box">
                <span class="checkbox-group">
                    <input type="checkbox" class="toggle-checkbox filter-toggles filter-minify" name="filter-minify" id="filter-minify">
                    <label for="filter-minify" class="toggle-label">
                        <span class="toggle tooltip-l tooltip-left" tooltip="<?php _e( "Compress this file to reduce it’s filesize", 'wphb' ); ?>"></span>
                        <i class="hb-icon-minify"></i>
                        <span><?php _e( 'Minify', 'wphb' ); ?></span>
                    </label>

                    <input type="checkbox" class="toggle-checkbox filter-toggles filter-combine" name="filter-combine" id="filter-combine">
                    <label for="filter-combine" class="toggle-label">
                        <span class="toggle tooltip-l" tooltip="<?php _e( 'Combine this file with others if possible', 'wphb' ); ?>"></span>
                        <i class="hb-icon-minify-combine"></i>
                        <span><?php _e( 'Combine', 'wphb' ); ?></span>
                    </label>

                    <input type="checkbox" class="toggle-checkbox filter-toggles filter-position-footer" name="filter-position" id="filter-position-footer">
                    <label for="filter-position-footer" class="toggle-label">
                        <span class="toggle tooltip-l tooltip-right" tooltip="<?php _e( 'Load this file in the footer of the page', 'wphb' ); ?>"></span>
                        <i class="hb-icon-minify-footer"></i>
                        <span><?php _e( 'Footer', 'wphb' ); ?></span>
                    </label>
                </span>
		</div><!-- end tooltip-box -->

		<div class="wphb-progress-state">
			<span class="wphb-progress-state-text"><?php _e( 'Hummingbird will set this configuration for all chosen files. You will still need to set the changes live by clicking Save Changes on the next screen.', 'wphb' ); ?></span>
		</div><!-- end wphb-progress-state -->

	</div><!-- end wphb-dialog-content -->

	<div class="wphb-dialog-footer">
		<div class="alignleft">
			<div class="close button button-ghost button-large"><?php _e( 'Cancel', 'wphb' ); ?></div>
		</div>
		<div class="alignright">
			<div class="close button button-large save-batch"><?php _e( 'Apply', 'wphb' ); ?></div>
		</div>
	</div>
</dialog><!-- end check-files-modal -->