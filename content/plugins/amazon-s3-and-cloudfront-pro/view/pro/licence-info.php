<div class="licence-info support support-section">
	<h3><?php _e( 'Email Support', 'amazon-s3-and-cloudfront' ); ?></h3>

	<div class="support-content">
		<?php if ( ! empty( $licence ) ) : ?>
			<p><?php _e( 'Fetching support form for your license, please wait...', 'amazon-s3-and-cloudfront' ); ?></p>
		<?php else : ?>
			<p>
				<?php _e( 'We couldn\'t find your license information.', 'amazon-s3-and-cloudfront' ); ?>
				<?php _e( 'Please enter a valid license key.', 'amazon-s3-and-cloudfront' ); ?>
			</p>
			<p><?php _e( 'Once entered, you can view your support details.', 'amazon-s3-and-cloudfront' ); ?></p>
		<?php endif; ?>
	</div>
</div>