<?php
	$type = empty( $type ) ? '' : $type;
	$report = empty( $report ) ? null : $report;
	$issue_id = empty( $issue_id ) ? null : $issue_id;

if ( ! $report || ! $type || ! $issue_id ) {
	return;
}

	$issue = $report->get_issue( $issue_id );
	$url = ! empty( $issue['path'] ) ? $issue['path'] : '';
	$path = preg_replace( '/' . preg_quote( home_url(), '/' ) . '/', '', $url );
?>

<tr data-issue-id="<?php echo esc_attr( $issue_id ); ?>">
	<td>
		<a href="<?php echo esc_attr( $url ); ?>">
			<?php echo esc_html( $path ); ?>
		</a>
	</td>
	<td>
		<button class="wds-unignore wds-button-with-loader wds-button-with-left-loader wds-disabled-during-request button button-small button-dark button-dark-o"><?php esc_html_e( 'Restore', 'wds' ); ?></button>
	</td>
</tr>