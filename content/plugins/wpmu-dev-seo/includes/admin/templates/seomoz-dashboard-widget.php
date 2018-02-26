<table class="wds-list-table wds-moz-table">
	<thead>
		<tr>
			<th class="label"><?php _e( 'Metric' , 'wds' ); ?></th>
			<th class="result"><?php _e( 'Value' , 'wds' ); ?></th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>
				<strong><?php _e( 'Domain mozRank' , 'wds' ); ?></strong><br>
				<?php printf( __( 'Measure of the mozRank %s of the domain in the Linkscape index' , 'wds' ), '<a href="https://moz.com/learn/seo/mozrank" target="_blank">(?)</a>' ); ?>
			</td>
			<td>
				<?php _e( '10-point score:' , 'wds' ); ?>&nbsp;
				<a href="<?php echo esc_attr( $attribution ); ?>" target="_blank"><?php echo ( ! empty( $urlmetrics->fmrp ) ? esc_html( $urlmetrics->fmrp ) : ''); ?></a>
				<br>
				<?php _e( 'Raw score:' , 'wds' ); ?>&nbsp;
				<a href="<?php echo esc_attr( $attribution ); ?>" target="_blank"><?php echo ( ! empty( $urlmetrics->fmrr ) ? esc_html( $urlmetrics->fmrr ) : ''); ?></a>
			</td>
		</tr>
		<tr>
			<td>
				<strong><?php _e( 'Domain Authority' , 'wds' ); ?></strong>
				<a href="https://moz.com/learn/seo/domain-authority" target="_blank">(?)</a>
			</td>
			<td><a href="<?php echo esc_attr( $attribution ); ?>" target="_blank"><?php echo ( ! empty( $urlmetrics->pda ) ? esc_html( $urlmetrics->pda ) : ''); ?></a></td>
		</tr>
		<tr>
			<td>
				<strong><?php _e( 'External Links to Homepage' , 'wds' ); ?></strong><br>
				<?php printf( __( 'The number of external (from other subdomains), juice passing links %s to the target URL in the Linkscape index' , 'wds' ), '<a href="https://moz.com/learn/seo/external-link" target="_blank">(?)</a>' ); ?>
			</td>
			<td><a href="<?php echo esc_attr( $attribution ); ?>" target="_blank"><?php echo ( ! empty( $urlmetrics->ueid ) ? esc_html( $urlmetrics->ueid ) : ''); ?></a></td>
		</tr>
		<tr>
			<td>
				<strong><?php _e( 'Links to Homepage' , 'wds' ); ?></strong><br>
				<?php printf( __( 'The number of internal and external, juice and non-juice passing links %s to the target URL in the Linkscape index' , 'wds' ), '<a href="https://moz.com/learn/seo/internal-link" target="_blank">(?)</a>' ); ?>
			</td>
			<td><a href="<?php echo esc_attr( $attribution ); ?>" target="_blank"><?php echo ( ! empty( $urlmetrics->uid ) ? esc_html( $urlmetrics->uid ) : ''); ?></a></td>
		</tr>
		<tr>
			<td>
				<strong><?php _e( 'Homepage mozRank' , 'wds' ); ?></strong><br>
				<?php printf( __( 'Measure of the mozRank %s of the homepage URL in the Linkscape index' , 'wds' ), '<a href="https://moz.com/learn/seo/mozrank" target="_blank">(?)</a>' ); ?>
			</td>
			<td>
				<?php _e( '10-point score:' , 'wds' ); ?>&nbsp;
				<a href="<?php echo esc_attr( $attribution ); ?>" target="_blank"><?php echo ( ! empty( $urlmetrics->umrp ) ? esc_html( $urlmetrics->umrp ) : ''); ?></a>
				<br>
				<?php _e( 'Raw score:' , 'wds' ); ?>&nbsp;
				<a href="<?php echo esc_attr( $attribution ); ?>" target="_blank"><?php echo ( ! empty( $urlmetrics->umrr ) ? esc_html( $urlmetrics->umrr ) : ''); ?></a>
			</td>
		</tr>
		<tr>
			<td>
				<strong><?php _e( 'Homepage Authority' , 'wds' ); ?></strong>
				<a href="https://moz.com/learn/seo/page-authority" target="_blank">(?)</a>
			</td>
			<td><a href="<?php echo esc_attr( $attribution ); ?>" target="_blank"><?php echo ( ! empty( $urlmetrics->upa ) ? esc_html( $urlmetrics->upa ) : ''); ?></a></td>
		</tr>
	</tbody>
	<tfoot>
		<tr>
			<th class="label"><?php _e( 'Metric' , 'wds' ); ?></th>
			<th class="result"><?php _e( 'Value' , 'wds' ); ?></th>
		</tr>
	</tfoot>
</table>
<p class="copy-moz"><?php _e( 'For posts / pages specific metrics refer to the Moz URL metrics module on the Edit Post / Page screen' , 'wds' ); ?> <a class="linkscape" href="http://moz.com/" target="_blank"><img class="linkscape-image" src="<?php echo SMARTCRAWL_PLUGIN_URL; ?>images/linkscape-logo.png" title="Moz Linkscape API" /></a></p>