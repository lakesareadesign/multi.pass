<?php
$results = empty( $results ) ? null : $results;
$issue_count = empty( $issue_count ) ? 0 : $issue_count;
$page_url = ! empty( $page_url ) ? $page_url : Smartcrawl_Settings_Admin::admin_url( Smartcrawl_Settings::TAB_CHECKUP );
?>

<?php if ( $issue_count > 0 || ! empty( $results['error'] ) ) : ?>
	<div class="wds-report">
		<?php $this->_render( 'checkup/checkup-checkup-results', array( 'show_upsell_message' => false ) ); ?>
	</div>
<?php else : ?>
	<p><?php esc_html_e( 'A comprehensive report on how optimized your website is for search engines and social media.', 'wds' ); ?></p>
	<?php
	$this->_render( 'notice', array(
		'message' => esc_html__( 'You have no outstanding SEO issues. Awesome work!', 'wds' ),
		'class'   => 'wds-notice-success',
	) );
	?>
<?php endif; ?>

<div class="wds-box-report-details wds-box-footer">
	<a href="<?php echo esc_attr( $page_url ); ?>#tab_checkup"
	   class="button button-small button-dark button-dark-o wds-dash-view-report-button">

		<?php esc_html_e( 'View Report', 'wds' ); ?>
	</a>
	<?php if ( ! empty( $reporting_enabled ) ) : ?>
		<span
			class="wds-box-stat-value wds-box-stat-value-success"><?php esc_html_e( 'Automatic checkups are enabled', 'wds' ); ?></span>
	<?php endif; ?>
</div>