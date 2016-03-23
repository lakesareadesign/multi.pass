<div class="wphb-table-wrapper complex">
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