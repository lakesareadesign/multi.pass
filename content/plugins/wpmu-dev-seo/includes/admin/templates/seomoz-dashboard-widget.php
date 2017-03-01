<table class="wds-data-table">
	<thead>
		<tr>
			<th class="label"><?php _e( 'Metric' , 'wds'); ?></th>
			<th class="result"><?php _e( 'Value' , 'wds'); ?></th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>
				<strong><?php _e( 'Domain mozRank' , 'wds'); ?></strong><br>
				<?php printf( __( 'Measure of the mozRank %s of the domain in the Linkscape index' , 'wds'), '<a href="http://www.opensiteexplorer.org/About#faq_5" target="_blank">(?)</a>' ); ?>
			</td>
			<td>
				<?php _e( '10-point score:' , 'wds'); ?>&nbsp;
				<a href="<?php echo $attribution; ?>" target="_blank"><?php echo ( ! empty( $urlmetrics->fmrp ) ? $urlmetrics->fmrp : ''); ?></a>
				<br>
				<?php _e( 'Raw score:' , 'wds'); ?>&nbsp;
				<a href="<?php echo $attribution; ?>" target="_blank"><?php echo ( ! empty( $urlmetrics->fmrr ) ? $urlmetrics->fmrr : ''); ?></a>
			</td>
		</tr>
		<tr>
			<td>
				<strong><?php _e( 'Domain Authority' , 'wds'); ?></strong>
				<a href="http://apiwiki.seomoz.org/w/page/20902104/Domain-Authority/" target="_blank">(?)</a>
			</td>
			<td><a href="<?php echo $attribution; ?>" target="_blank"><?php echo ( ! empty( $urlmetrics->pda ) ? $urlmetrics->pda : ''); ?></a></td>
		</tr>
		<tr>
			<td>
				<strong><?php _e( 'External Links to Homepage' , 'wds'); ?></strong><br>
				<?php printf( __( 'The number of external (from other subdomains), juice passing links %s to the target URL in the Linkscape index' , 'wds'), '<a href="http://apiwiki.seomoz.org/w/page/13991139/Juice-Passing" target="_blank">(?)</a>' ); ?>
			</td>
			<td><a href="<?php echo $attribution; ?>" target="_blank"><?php echo ( ! empty( $urlmetrics->ueid ) ? $urlmetrics->ueid : ''); ?></a></td>
		</tr>
		<tr>
			<td>
				<strong><?php _e( 'Links to Homepage' , 'wds'); ?></strong><br>
				<?php printf( __( 'The number of internal and external, juice and non-juice passing links %s to the target URL in the Linkscape index' , 'wds'), '<a href="http://apiwiki.seomoz.org/w/page/13991139/Juice-Passing" target="_blank">(?)</a>' ); ?>
			</td>
			<td><a href="<?php echo $attribution; ?>" target="_blank"><?php echo ( ! empty( $urlmetrics->uid ) ? $urlmetrics->uid : ''); ?></a></td>
		</tr>
		<tr>
			<td>
				<strong><?php _e( 'Homepage mozRank' , 'wds'); ?></strong><br>
				<?php printf( __( 'Measure of the mozRank %s of the homepage URL in the Linkscape index' , 'wds'), '<a href="http://www.opensiteexplorer.org/About#faq_5" target="_blank">(?)</a>' ); ?>
			</td>
			<td>
				<?php _e( '10-point score:' , 'wds'); ?>&nbsp;
				<a href="<?php echo $attribution; ?>" target="_blank"><?php echo ( ! empty( $urlmetrics->umrp ) ? $urlmetrics->umrp : ''); ?></a>
				<br>
				<?php _e( 'Raw score:' , 'wds'); ?>&nbsp;
				<a href="<?php echo $attribution; ?>" target="_blank"><?php echo ( ! empty( $urlmetrics->umrr ) ? $urlmetrics->umrr : ''); ?></a>
			</td>
		</tr>
		<tr>
			<td>
				<strong><?php _e( 'Homepage Authority' , 'wds'); ?></strong>
				<a href="http://apiwiki.seomoz.org/Page-Authority" target="_blank">(?)</a>
			</td>
			<td><a href="<?php echo $attribution; ?>" target="_blank"><?php echo ( ! empty( $urlmetrics->upa ) ? $urlmetrics->upa : ''); ?></a></td>
		</tr>
	</tbody>
	<tfoot>
		<tr>
			<th class="label"><?php _e( 'Metric' , 'wds'); ?></th>
			<th class="result"><?php _e( 'Value' , 'wds'); ?></th>
		</tr>
	</tfoot>
</table>
<p class="copy-moz"><?php _e( 'For posts / pages specific metrics refer to the Moz URL metrics module on the Edit Post / Page screen' , 'wds'); ?> <a class="linkscape" href="http://moz.com/" target="_blank"><img class="linkscape-image" src="<?php echo WDS_PLUGIN_URL; ?>images/linkscape-logo.png" title="Moz Linkscape API" /></a></p>