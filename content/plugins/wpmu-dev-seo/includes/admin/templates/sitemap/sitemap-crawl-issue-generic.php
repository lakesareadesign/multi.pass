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
		<?php
		if ( isset( $issue['response'] ) && $issue['response'] ) {
			echo $issue['response'];
		}
		?>
	</td>
	<td>
		<span class="wds-issues wds-issues-warning">
			<span><?php echo count( $issue['origin'] ); ?></span>
		</span>
	</td>
	<td>
		<?php
			$this->_render('links-dropdown', array(
				'label' => esc_html__( 'Options', 'wds' ),
				'links' => array(
					'#ignore'     => esc_html__( 'Ignore', 'wds' ),
					'#occurences' => esc_html__( 'List Occurrences', 'wds' ),
					'#redirect'   => esc_html__( 'Redirect', 'wds' ),
				),
			));
		?>
		<?php
			$this->_render('sitemap/sitemap-occurrences-overlay', array(
				'issue_id' => $issue_id,
				'issue'    => $issue,
			));
		?>
		<?php
			$this->_render('sitemap/sitemap-redirect-overlay', array(
				'issue_id' => $issue_id,
				'issue'    => $issue,
			));
		?>
	</td>
</tr>