
<table class="widefat">
	<tbody>
		<tr class="alt">
			<th width="30%"><?php esc_html_e( 'Metric' , 'wds' ); ?></th>
			<th>Value</th>
		</tr>
		<tr>
			<th><?php esc_html_e( 'External Links' , 'wds' ); ?></th>
			<td><p><a href="http://www.opensiteexplorer.org/links?site=<?php echo $page; ?>" target="_blank"><?php echo ( ! empty( $urlmetrics->ueid ) ? $urlmetrics->ueid : '' ); ?></a></p></td>
		</tr>
		<tr>
			<th><?php esc_html_e( 'Links' , 'wds' ); ?></th>
			<td><p><a href="http://www.opensiteexplorer.org/links?site=<?php echo $page; ?>" target="_blank"><?php echo ( ! empty( $urlmetrics->uid ) ? $urlmetrics->uid : '' ); ?></a></p></td>
		</tr>
		<tr>
			<th><?php esc_html_e( 'mozRank' , 'wds' ); ?></th>
			<td><p><?php echo '<b>' . __( '10-point score:' , 'wds' ) . '</b> <a href="http://www.opensiteexplorer.org/links?site=' . $page . '" target="_blank">' . ( ! empty( $urlmetrics->umrp ) ? $urlmetrics->umrp : '' ) . '</a><br /><br /><b>' . __( 'Raw score:' , 'wds' ) . '</b> <a href="http://www.opensiteexplorer.org/links?site=' . $page . '" target="_blank">' . ( ! empty( $urlmetrics->umrr ) ? $urlmetrics->umrr : '' ); ?></a></p></td>
		</tr>
		<tr>
			<th><?php esc_html_e( 'Page Authority' , 'wds' ); ?></th>
			<td><p><a href="http://www.opensiteexplorer.org/links?site=<?php echo $page; ?>" target="_blank"><?php echo ( ! empty( $urlmetrics->upa ) ? $urlmetrics->upa : '' ); ?></a></p></td>
		</tr>
	</tbody>
</table>
<p><a href="http://moz.com/" target="_blank"><img src="<?php echo SMARTCRAWL_PLUGIN_URL; ?>images/linkscape-logo.png" title="<?php esc_html_e( 'Moz Linkscape API' , 'wds' ); ?>" /></a></p>
