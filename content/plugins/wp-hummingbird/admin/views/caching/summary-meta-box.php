<div class="wphb-table-wrapper">

	<?php if ( $external_problem ): ?>
		<div class="wphb-caching-error wphb-notice wphb-notice-error">
			<strong><?php _e( 'Browser Caching is not working properly:', 'wphb' ); ?></strong>
			<ul>
				<li>- <?php _e( 'Your server may not have the "expires" module enabled (mod_expires for Apache, ngx_http_headers_module for NGINX)', 'wphb' ); ?></li>
				<li>- <?php _e( 'Another plugin may be interfering with the configuration', 'wphb' ); ?></li>
			</ul>
			<p><?php printf( __( 'If re-checking and restarting does not resolve, please check with your host or <a href="%s" target="_blank">open a support ticket with us</a>.', 'wphb' ), wphb_support_link() ); ?></p>
		</div>
	<?php endif; ?>

	<table class="list-table hover-effect wphb-table stack caching-table">
		<thead>
			<tr class="wphb-caching-summary-item-heading">
				<th class="wphb-caching-summary-heading wphb-caching-summary-heading-type"><?php _e( 'File Type', 'wphb' ); ?></th>
				<th class="wphb-caching-summary-heading wphb-caching-summary-heading-expiry"><?php _e( 'Recommended', 'wphb' ); ?></th>
				<th class="wphb-caching-summary-heading wphb-caching-summary-heading-status"><?php _e( 'Current', 'wphb' ); ?></th>
				<th class="wphb-caching-summary-heading wphb-caching-summary-heading-set-expiry"><?php _e( 'Set Expiry', 'wphb' ); ?></th>
			</tr><!-- end wphb-caching-summary-item-heading -->
		</thead>

		<tbody>
			<?php foreach ( $human_results as $type => $result ): ?>

				<?php if ( $result ) {
					if ( $recommended[ $type ]['value'] <= $results[ $type ] ) {
						$resultStatus = $result;
						$resultStatusColor = 'green';
						$tooltipText = __('Caching is enabled', 'wphb');
					} else {
						$resultStatus = $result;
						$resultStatusColor = 'red';
						$tooltipText = __('Caching is enabled but you aren\'t using our recommended value', 'wphb');
					}

				} else {
					$resultStatus = __( 'Disabled', 'wphb' );
					$resultStatusColor = 'red';
					$tooltipText = __('Caching is disabled', 'wphb');
				}
				?>

				<tr class="wphb-caching-summary-item">
					<td th-data="<?php _e( 'File Type', 'wphb' ); ?>" class="wphb-caching-summary-item-type"><?php echo $type; ?></td><!-- end wphb-dashboard-modules-item-type -->
					<td th-data="<?php _e( 'Recommended', 'wphb' ); ?>" class="wphb-caching-summary-item-expiry has-button-label">
						<span class="wphb-button-label wphb-button-label-small wphb-button-label-light" tooltip="<?php echo sprintf( __('The recommended value for this file type is at least %s. The longer the better!', 'wphb'), $recommended[ $type ]['label'] ); ?>"><?php echo $recommended[ $type ]['label']; ?></span>
					</td><!-- end wphb-caching-summary-item-expiry -->
					<td th-data="<?php _e( 'Current', 'wphb' ); ?>" class="wphb-caching-summary-item-status has-button-label">
						<span class="wphb-button-label wphb-button-label-small wphb-button-label-<?php echo $resultStatusColor; ?>" tooltip="<?php echo $tooltipText; ?>"><?php echo $resultStatus; ?></span>
					</td><!-- end wphb-caching-summary-itemm-status -->
					<td th-data="<?php _e( 'Set Expiry', 'wphb' ); ?>" class="wphb-caching-summary-item-set-expiry has-select">
						<?php wphb_get_caching_frequencies_dropdown( array( 'name' => 'wphb-caching-summary-set-expiry-select-css', 'class' => 'wphb-expiry-select', 'selected' => $expires[ $type ], 'data-type' => $type ) ); ?>
					</td><!-- end wphb-caching-summary-item-set-expiry -->
				</tr><!-- wphb-caching-summary-item -->
			<?php endforeach; ?>
		</tbody>
	</table>

	<?php if ( $cf_active ): ?>
		<div class="wphb-caching-cloudflare-box">
			<p><?php _e( 'Since you have CloudFlare enabled, the setting belowwill override caching expiry for all file types', 'wphb' ); ?></p>
			<table class="list-table hover-effect wphb-table stack caching-table">
				<thead>
				<tr class="wphb-caching-summary-item-heading">
					<th class="wphb-caching-summary-heading wphb-caching-summary-heading-expiry"><?php _e( 'File Type', 'wphb' ); ?></th>
					<th class="wphb-caching-summary-heading wphb-caching-summary-heading-expiry"><?php _e( 'Recommended', 'wphb' ); ?></th>
					<th class="wphb-caching-summary-heading wphb-caching-summary-heading-status"><?php _e( 'Current', 'wphb' ); ?></th>
					<th class="wphb-caching-summary-heading wphb-caching-summary-heading-set-expiry"><?php _e( 'Set Expiry', 'wphb' ); ?></th>
				</tr><!-- end wphb-caching-summary-item-heading -->
				</thead>
				<tbody>
				<tr class="wphb-caching-summary-item">
					<td th-data="<?php _e( 'File Type', 'wphb' ); ?>" class="wphb-caching-summary-item-type"><?php _e( 'All files', 'wphb' ); ?></td>
					<td th-data="<?php _e( 'Recommended', 'wphb' ); ?>" class="wphb-caching-summary-item-expiry has-button-label">
						<span class="wphb-button-label wphb-button-label-small wphb-button-label-light" tooltip="<?php esc_attr_e('The recommended value for CloudFlare settings is at least 8 days.', 'wphb' ); ?>"><?php _e( '8 days', 'wphb' ); ?></span>
					</td><!-- end wphb-caching-summary-item-expiry -->
					<td th-data="<?php _e( 'Current', 'wphb' ); ?>" class="wphb-caching-summary-item-status has-button-label">
						<span class="wphb-button-label wphb-button-label-small wphb-button-label-<?php echo $cf_current == 691200 ? 'green' : 'red'; ?>" tooltip="<?php echo esc_html( $cf_tooltip ); ?>"><?php echo $cf_current_human; ?></span>
					</td><!-- end wphb-caching-summary-itemm-status -->
					<td th-data="<?php _e( 'Set Expiry', 'wphb' ); ?>" class="wphb-caching-summary-item-set-expiry has-select">
						<?php wphb_get_caching_cloudflare_frequencies_dropdown( array( 'name' => 'wphb-caching-cloudflare-summary-set-expiry', 'class' => 'wphb-expiry-select', 'selected' => $cf_current ) ); ?>
					</td><!-- end wphb-caching-summary-item-set-expiry -->
				</tr><!-- wphb-caching-summary-item -->
				</tbody>
			</table>
		</div>
		<script>
			jQuery(document).ready( function() {
				if ( window.WPHB_Admin ) {
					window.WPHB_Admin.getModule( 'cloudflare' );
				}
			});

		</script>
	<?php endif; ?>
</div>