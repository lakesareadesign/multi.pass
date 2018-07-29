<?php
$issue_id = empty( $issue_id ) ? null : $issue_id;
$issue = empty( $issue ) ? null : $issue;
$issue_path = smartcrawl_get_array_value( $issue, 'path' );

if ( ! $issue_id || ! $issue || ! $issue_path ) {
	return;
}

$rmodel = new Smartcrawl_Model_Redirection();
$redirections = $rmodel->get_all_redirections();
$redirection_target = ! empty( $redirections[ $issue_path ] ) ? esc_url( $redirections[ $issue_path ] ) : '';
?>
<dialog class="dev-overlay wds-modal wds-redirect wds-report"
        id="wds-issue-redirect-<?php echo esc_attr( $issue_id ); ?>"
        title="<?php esc_attr_e( 'Redirect URL', 'wds' ); ?>">

	<div class="box-content modal wds-form"
	     data-issue-id="<?php echo esc_attr( $issue_id ); ?>">

		<p>
			<?php
			printf(
				esc_html__( 'Choose where to redirect %s', 'wds' ),
				'<strong>' . esc_html( $issue_path ) . '</strong>'
			);
			?>
		</p>
		<div class="wds-table-fields wds-table-fields-stacked">
			<div class="label">
				<label for="wds-redirect-target-<?php echo esc_attr( $issue_id ); ?>"
				       class="wds-label"><?php esc_html_e( 'New URL', 'wds' ); ?></label>
			</div>
			<div class="fields">
				<input id="wds-redirect-target-<?php echo esc_attr( $issue_id ); ?>"
				       type="url"
				       name="redirect"
				       value="<?php echo esc_attr( $redirection_target ); ?>"
				       class="wds-field"
				       placeholder="<?php esc_attr_e( 'Enter new URL', 'wds' ); ?>"/>
				<p class="wds-field-legend">
					<?php
					$advanced_url = Smartcrawl_Settings_Admin::admin_url( Smartcrawl_Settings::TAB_AUTOLINKS );
					printf(
						esc_html__( 'Formats include relative (E.g. %1$s) or absolute URLs (E.g. %2$s or %3$s). This will set up a 301 (permanent) redirect from one URL to another, you can view all your redirections under %4$s.', 'wds' ),
						sprintf( '<strong>%s</strong>', esc_html__( '/cats', 'wds' ) ),
						sprintf( '<strong>%s</strong>', esc_html__( 'www.website.com/cats', 'wds' ) ),
						sprintf( '<strong>%s</strong>', esc_html__( 'https://website.com/cats', 'wds' ) ),
						sprintf( '<strong><a href="%s">%s</a></strong>', esc_url( $advanced_url ), esc_html__( 'Advanced Tools', 'wds' ) )
					);
					?>
				</p>
			</div>
		</div>
		<div class="wds-box-footer">
			<input type="hidden" name="source" value="<?php echo esc_url( $issue_path ); ?>"/>
			<?php wp_nonce_field( 'wds-redirect', 'wds-redirect' ); ?>
			<button type="button"
			        class="button button-dark-o wds-cancel-button wds-disabled-during-request"><?php esc_html_e( 'Cancel', 'wds' ); ?></button>
			<button type="button"
			        class="button wds-action-button wds-submit-redirect wds-button-with-loader wds-button-with-left-loader wds-disabled-during-request"><?php esc_html_e( 'Add Redirect', 'wds' ); ?></button>
		</div>
	</div>
</dialog>