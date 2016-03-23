<dialog id="wphb-upgrade-membership-modal" class="small no-close wphb-modal" title="<?php _e( 'Upgrade Membership', 'wphb' ); ?>">
	<div class="wphb-dialog-content dialog-upgrade">

		<p><?php echo $text; ?></p>

		<ul class="listing bold wphb-listing">
			<li><?php _e( 'Access to 140+ plugins & Upfront themes', 'wphb' ); ?></li>
			<li><?php _e( 'Access to security, backups, SEO and performance services', 'wphb' ); ?></li>
			<li><?php _e( '24/7 expert WordPress support', 'wphb' ); ?></li>
		</ul>

		<a target="_blank" href="<?php echo wphb_update_membership_link(); ?>" class="block button button-big button-app"><?php _e( 'Upgrade Membership', 'wphb' ); ?></a>

		<?php
			$dashDownloadLink = '#';
			$dashLoginLink = '#';
		?>
		<p><?php echo sprintf( __('Already a member? You need to <a href="%s">download</a> the WPMU DEV Dashboard plugin & <a href="%s">login</a>!', 'wphb'), $dashDownloadLink, $dashLoginLink ); ?></p>

		<div class="wphb-modal-image wphb-modal-image-bottom dev-man">
			<img class="wphb-image wphb-image-center" src="<?php echo wphb_plugin_url() . 'admin/assets/image/hummingbird-small.png'; ?>" alt="<?php _e('Hummingbird','wphb'); ?>">
		</div>

	</div>
</dialog><!-- end wphb-upgrade-membership-modal -->