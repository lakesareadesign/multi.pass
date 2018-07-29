<?php
if ( ! Smartcrawl_Settings::get_setting( 'analysis-seo' ) ) {
	return false;
}

$checks = empty( $checks ) ? array() : $checks;
$error_count = empty( $error_count ) ? 0 : $error_count;
$focus_keywords_available = empty( $focus_keywords_available ) ? false : $focus_keywords_available;
?>

<?php if ( ! $focus_keywords_available ) : ?>
	<div class="wds-seo-analysis wds-no-focus-keywords">
		<div class="wds-notice wds-notice-warning">
			<p><?php esc_html_e( 'You need to add focus keywords to see recommendations for this article.', 'wds' ); ?></p>
		</div>
	</div>
	<?php return; ?>
<?php endif; // phpcs:ignore -- PHPCS misfires here and complains about the return statement above ?>

<div class="wds-seo-analysis wds-report" data-errors="<?php echo esc_attr( $error_count ); ?>">

	<div class="wds-notice <?php echo $error_count > 0 ? 'wds-notice-warning' : 'wds-notice-success'; ?>">
		<p>
			<?php if ( $error_count > 0 ) : ?>
				<?php printf( esc_html__( 'You have %d SEO recommendations. We recommend you satisfy as many improvements as possible to ensure your content gets found.', 'wds' ), intval( $error_count ) ); ?>
			<?php else : ?>
				<?php esc_html_e( 'You have optimized your SEO to the max. Bravo!', 'wds' ); ?>
			<?php endif; ?>
		</p>
	</div>
	<div class="wds-accordion">
		<?php foreach ( $checks as $check_id => $result ) : ?>
			<?php
			$passed = $result['status'];
			$ignored = $result['ignored'];
			$recommendation = $result['recommendation'];
			$more_info = $result['more_info'];
			$status_msg = $result['status_msg'];

			$classes_array = array();
			$classes_array[] = $passed ? 'wds-check-success' : 'wds-check-warning';
			$classes_array[] = $ignored ? 'wds-check-invalid disabled' : '';
			$classes = implode( ' ', $classes_array );
			?>
			<div id="wds-check-<?php echo esc_attr( $check_id ); ?>"
			     class="wds-check-item wds-accordion-section <?php echo esc_attr( $classes ); ?>">
				<div class="wds-accordion-handle">
					<div class="wds-accordion-handle-part">
						<?php echo wp_kses_post( $status_msg ); ?>
					</div>
					<?php if ( $ignored ) : ?>
						<div class="wds-unignore-container wds-accordion-handle-part">
							<button type="button"
							        id="wds-unignore-check-<?php echo esc_attr( $check_id ); ?>"
							        class="wds-unignore wds-button-with-loader wds-button-with-left-loader wds-disabled-during-request button button-small button-dark-o"
							        data-check_id="<?php echo esc_attr( $check_id ); ?>">
								<?php esc_html_e( 'Restore', 'wds' ); ?>
							</button>
						</div>
					<?php endif; ?>
				</div>
				<div class="wds-accordion-content">
					<?php if ( $recommendation ) : ?>
						<div class="wds-recommendation">
							<div class="wds-small-text"><strong><?php esc_html_e( 'Recommendation', 'wds' ); ?></strong>
							</div>
							<p class="wds-small-text"><?php echo wp_kses_post( $recommendation ); ?></p>
						</div>
					<?php endif; ?>

					<?php if ( $more_info ) : ?>
						<div class="wds-more-info">
							<div class="wds-small-text"><strong><?php esc_html_e( 'More Info', 'wds' ); ?></strong>
							</div>
							<p class="wds-small-text"><?php echo wp_kses_post( $more_info ); ?></p>
						</div>
					<?php endif; ?>

					<?php if ( ! $ignored ) : ?>
						<div class="wds-ignore-container">
							<button type="button"
							        id="wds-ignore-check-<?php echo esc_attr( $check_id ); ?>"
							        class="wds-ignore wds-button-with-loader wds-button-with-right-loader wds-disabled-during-request button button-small button-dark-o"
							        data-check_id="<?php echo esc_attr( $check_id ); ?>">
								<?php esc_html_e( 'Ignore', 'wds' ); ?>
							</button>
						</div>
					<?php endif; ?>
				</div>
			</div>
		<?php endforeach; ?>
		<div class="cf"></div>
	</div>
</div>