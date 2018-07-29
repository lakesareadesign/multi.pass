<?php
$smartcrawl_options = Smartcrawl_Settings::get_options();
$access_id = empty( $smartcrawl_options['access-id'] ) ? '' : $smartcrawl_options['access-id'];
$secret_key = empty( $smartcrawl_options['secret-key'] ) ? '' : $smartcrawl_options['secret-key'];
?>

<?php if ( empty( $access_id ) || empty( $secret_key ) ) : ?>
	<div class="wds-disabled-component">
		<p>
			<img
				src="<?php echo esc_attr( SMARTCRAWL_PLUGIN_URL ); ?>/images/<?php echo esc_attr( 'moz-disabled.png' ); ?>"
				alt="<?php esc_attr_e( 'MOZ Disabled', 'wds' ); ?>" class="wds-disabled-image"/>
		</p>
		<p><?php esc_html_e( 'Moz provides reports that tell you how your site stacks up against the competition with all of the important SEO measurement tools - ranking, links, and much more.', 'wds' ); ?></p>
	</div>
	<div class="wds-moz-api-credentials">
		<p>
			<?php
			printf(
				esc_html__( 'Connect your Moz account. You can get the API credentials %s.', 'wds' ),
				sprintf( '<a href="https://moz.com/products/api" target="_blank">%s</a>', esc_html__( 'here', 'wds' ) )
			);
			?>
		</p>
		<form method="POST" class="wds-form">
			<div class="row">
				<div class="col-half wds-table-fields wds-table-fields-stacked">
					<div class="label">
						<label class="wds-label"
						       for="wds-moz-access-id"><?php esc_html_e( 'Access ID', 'wds' ); ?></label>
					</div>
					<div class="fields">
						<input
							type="text"
							id="wds-moz-access-id"
							name="wds-moz-access-id"
							placeholder="<?php esc_attr_e( 'Enter your Moz Access ID', 'wds' ); ?>"
							value="<?php echo esc_attr( $access_id ); ?>"/>
					</div>
				</div>

				<div class="col-half wds-table-fields wds-table-fields-stacked">
					<div class="label">
						<label class="wds-label"
						       for="wds-moz-secret-key"><?php esc_html_e( 'Secret Key', 'wds' ); ?></label>
					</div>
					<div class="fields">
						<input
							type="text"
							id="wds-moz-secret-key"
							name="wds-moz-secret-key"
							placeholder="<?php esc_attr_e( 'Enter your Moz Secret Key', 'wds' ); ?>"
							value="<?php echo esc_attr( $secret_key ); ?>"/>
					</div>
				</div>
				<?php wp_nonce_field( 'wds-settings-nonce', '_wds_nonce' ); ?>
			</div>
			<input name='submit' type='submit' class='button' value='<?php esc_attr_e( 'Connect', 'wds' ); ?>'/>
		</form>
	</div>
<?php else : ?>
	<p class="wds-content-tabs-description">
		<?php esc_html_e( 'Here’s how your site stacks up against the competition as defined by Moz. You can also see individual stats per post in the post editor under the Moz module.', 'wds' ); ?>
	</p>
	<button type="submit" class="button button-small button-dark button-dark-o" name="reset-moz-credentials"
	        value="1"><?php esc_html_e( 'Reset API Credentials', 'wds' ); ?></button>
	<?php wp_nonce_field( 'wds-autolinks-nonce', '_wds_nonce' ); ?>
	<?php Smartcrawl_Seomoz_Dashboard_Widget::widget(); ?>
<?php endif; ?>