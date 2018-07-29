<?php
if ( ! smartcrawl_subsite_setting_page_enabled( 'wds_social' ) ) {
	return;
}

$options = $_view['options'];
$og_enabled = smartcrawl_get_array_value( $options, 'og-enable' );
$twitter_card_enabled = smartcrawl_get_array_value( $options, 'twitter-card-enable' );
$twitter_card_type = smartcrawl_get_array_value( $options, 'twitter-card-type' );
$twitter_card_status_text = Smartcrawl_Twitter_Printer::CARD_IMAGE === $twitter_card_type ? esc_html__( 'Summary Card with Large Image', 'wds' ) : esc_html__( 'Summary Card', 'wds' );
$pinterest_verification_status = smartcrawl_get_array_value( $options, 'pinterest-verification-status' );
$pinterest_tag = smartcrawl_get_array_value( $options, 'pinterest-verify' );

$social_page_url = Smartcrawl_Settings_Admin::admin_url( Smartcrawl_Settings::TAB_SOCIAL );
$social_option_name = Smartcrawl_Settings::TAB_SOCIAL . '_options';
$settings_option_name = Smartcrawl_Settings::TAB_SETTINGS . '_options';
$social_enabled = smartcrawl_get_array_value( $options, 'social' );
?>
<section id="<?php echo esc_attr( Smartcrawl_Settings_Dashboard::BOX_SOCIAL ); ?>" class="dev-box">
	<div class="box-title">
		<?php if ( $social_enabled ) : ?>
			<div class="buttons buttons-icon">
				<a href="<?php echo esc_attr( $social_page_url ); ?>" class="wds-settings-link">
					<i class="wds-icon-arrow-right-carats"></i>
				</a>
			</div>
		<?php endif; ?>
		<h3>
			<i class="wds-icon-social-twitter"></i> <?php esc_html_e( 'Social', 'wds' ); ?>
		</h3>
	</div>

	<div class="box-content">
		<p><?php esc_html_e( 'Control and optimize how your website appears when shared on social platforms like Facebook and Twitter.', 'wds' ); ?></p>

		<?php if ( $social_enabled ) : ?>
			<div class="wds-separator-top">
				<span class="wds-small-text"><strong><?php esc_html_e( 'OpenGraph', 'wds' ); ?></strong></span>
				<?php if ( ! $og_enabled ) : ?>
					<p class="wds-small-text">
						<?php esc_html_e( 'Add meta data to your pages to make them look great when shared platforms such as Facebook and other popular social networks.', 'wds' ); ?>
					</p>
					<button
						type="button"
						data-option-id="<?php echo esc_attr( $social_option_name ); ?>"
						data-flag="<?php echo 'og-enable'; ?>"
						class="wds-activate-component button button-small wds-button-with-loader wds-button-with-right-loader wds-disabled-during-request">

						<?php esc_html_e( 'Activate', 'wds' ); ?>
					</button>
				<?php else : ?>
					<span
						class="wds-box-stat-value wds-box-stat-value-success"><?php esc_html_e( 'Active', 'wds' ); ?></span>
				<?php endif; ?>
			</div>

			<div class="wds-separator-top">
				<span class="wds-small-text"><strong><?php esc_html_e( 'Twitter Cards', 'wds' ); ?></strong></span>
				<?php if ( ! $twitter_card_enabled ) : ?>
					<p class="wds-small-text">
						<?php esc_attr_e( 'With Twitter Cards, you can attach rich photos, videos and media experiences to Tweets, helping to drive traffic to your website.', 'wds' ); ?>
					</p>
					<button type="button"
					        data-option-id="<?php echo esc_attr( $social_option_name ); ?>"
					        data-flag="<?php echo 'twitter-card-enable'; ?>"
					        class="wds-activate-component button button-small wds-button-with-loader wds-button-with-right-loader wds-disabled-during-request">

						<?php esc_html_e( 'Activate', 'wds' ); ?>
					</button>
				<?php else : ?>
					<span class="wds-box-stat-value wds-box-stat-value-success">
						<?php echo esc_html( $twitter_card_status_text ); ?>
					</span>
				<?php endif; ?>
			</div>

			<div class="wds-separator-top">
				<span class="wds-small-text">
					<strong><?php esc_html_e( 'Pinterest Verification', 'wds' ); ?></strong>
				</span>
				<?php if ( ! $pinterest_tag || 'fail' === $pinterest_verification_status ) : ?>
					<p class="wds-small-text">
						<?php esc_html_e( 'Verify your website with Pinterest to attribute your website when your website content is pinned to the platform.', 'wds' ); ?>
					</p>
					<a href="<?php echo esc_attr( $social_page_url ); ?>#tab_pinterest_verification"
					   class="button button-small">

						<?php esc_html_e( 'Connect', 'wds' ); ?>
					</a>
				<?php else : ?>
					<span
						class="wds-box-stat-value wds-box-stat-value-success"><?php esc_html_e( 'Verification tag added' ); ?></span>
				<?php endif; ?>
			</div>

			<div class="wds-box-footer">
				<a href="<?php echo esc_attr( $social_page_url ); ?>"
				   class="button button-small button-dark button-dark-o wds-dash-configure-button">

					<?php esc_html_e( 'Configure', 'wds' ); ?>
				</a>
			</div>
		<?php else : ?>
			<button type="button"
			        data-option-id="<?php echo esc_attr( $settings_option_name ); ?>"
			        data-flag="<?php echo esc_attr( 'social' ); ?>"
			        class="wds-activate-component button button-small wds-button-with-loader wds-button-with-right-loader wds-disabled-during-request">

				<?php esc_html_e( 'Activate', 'wds' ); ?>
			</button>
		<?php endif; ?>
	</div>
</section>