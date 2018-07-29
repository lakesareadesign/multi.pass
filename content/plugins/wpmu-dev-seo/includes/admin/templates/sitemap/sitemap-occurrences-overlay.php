<?php
$issue_id = empty( $issue_id ) ? null : $issue_id;
$issue = empty( $issue ) ? null : $issue;

if ( ! $issue_id || ! $issue ) {
	return;
}
?>
<dialog class="dev-overlay wds-modal wds-occurrences"
        id="wds-issue-occurrences-<?php echo esc_attr( $issue_id ); ?>"
        title="<?php esc_attr_e( 'List Occurrences', 'wds' ); ?>">

	<div class="box-content">
		<div class="wds-issue-occurrences-list">
			<p>
				<?php
				printf(
					esc_html__( 'We found links to %s in these locations, you might want to remove these links or direct them somewhere else.', 'wds' ),
					'<strong>' . esc_html( $issue['path'] ) . '</strong>'
				);
				?>
			</p>
			<ul class="wds-listing wds-path-occurrences">
				<?php if ( ! empty( $issue['origin'] ) ) : ?>
					<?php foreach ( $issue['origin'] as $origin ) : ?>
						<li>
							<?php $origin = is_array( $origin ) && ! empty( $origin[0] ) ? $origin[0] : $origin; ?>

							<a href="<?php echo is_string( $origin ) ? esc_url( $origin ) : esc_url( $origin[0] ); ?>">
								<?php echo is_string( $origin ) ? esc_html( $origin ) : esc_html( $origin[0] ); ?>
							</a>
						</li>
					<?php endforeach; ?>
				<?php endif; ?>
			</ul>
		</div>
		<div class="wds-box-footer">
			<button type="button"
			        class="wds-cancel-button button button-dark-o"><?php esc_attr_e( 'Cancel', 'wds' ); ?></button>
		</div>
	</div>
</dialog>