<div class="wphb-block-entry">

	<div class="wphb-block-entry-content">

		<img class="wphb-image-icon-content wphb-image-icon-content-top wphb-image-icon-content-center" src="<?php echo wphb_plugin_url() . 'admin/assets/image/icon-smush-small.png'; ?>" alt="<?php _e('WP Smush', 'wphb'); ?>">

		<div class="content">
		<?php if ( ! wphb_is_member() ) : ?>
			<p><?php _e( 'Make your site load fast and rank high in search with WP Smush Pro!<br> Install, set and forget for automatic lossless compression.<br> WP Smush Pro is a premium plugin that comes with a WPMU DEV Membership, get one today!', 'wphb' ); ?><br/></p>
			<a target="_blank" href="<?php echo $update_membership_url; ?>" class="button button-app button-content-cta" id="dash-smush-update-membership"><?php _e( 'Update Membership', 'wphb' ); ?></a>
		<?php elseif ( ! $is_installed ) : ?>
			<p><?php _e( 'Make your site load fast and rank high in search with WP Smush Pro - included in your membership!<br> Install, set and forget for automatic lossless compression.', 'wphb' ); ?></p>
			<a href="<?php echo esc_url( wphb_smush_get_install_url() ); ?>" class="button button-app button-content-cta" id="smush-install"><?php _e( 'Install WP Smush Pro', 'wphb' ); ?></a>
		<?php elseif ( $is_installed && ! $is_active ) : ?>
			<p><?php _e( 'WP Smush Pro is installed but not <strong>activated!<strong><br></strong>Activate and set up now</strong> to reduce page load time.', 'wphb' ); ?></p>
			<a href="<?php echo esc_url( $activate_url ); ?>" class="button button-app button-content-cta" id="smush-activate"><?php _e( 'Activate WP Smush Pro', 'wphb' ); ?></a>
		<?php elseif ( $is_installed && $is_active ) : ?>
			<?php if ( $smush_data['bytes'] == 0 || $smush_data['percent'] == 0 ) : ?>
				<p><?php _e( "WP Smush Pro is installed but no images have been smushed yet.<br> Get in there and smush away!", 'wphb' ); ?></p>
				<a href="<?php echo esc_url( admin_url( 'upload.php?page=wp-smush-bulk' ) ); ?>" class="button button-app button-content-cta" id="smush-link"><?php _e( 'Smart Smush', 'wphb' ); ?></a>
			<?php else : ?>
				<p><?php echo sprintf( __( "WP Smush Pro is installed. So far you've saved <strong>%s</strong> of space.<br>That's a total savings of <strong>%s</strong>. Nice one!", 'wphb' ), $smush_data['human'], number_format_i18n( $smush_data['percent'], 2 ) . '%' ); ?></p>
			<?php endif; ?>
		<?php endif; ?>
		</div><!-- end content -->

	</div><!-- end wphb-block-entry-content -->

</div><!-- end wphb-block-entry -->