<dialog id="wphb-upgrade-membership-modal" class="small <?php if ('hummingbird_page_wphb-uptime' === get_current_screen()->id ) echo 'no-close'; ?> wphb-modal" title="<?php _e( 'Upgrade Membership', 'wphb' ); ?>">
	<div class="wphb-dialog-content dialog-upgrade">

        <p><?php _e( "Here's what you'll get by upgrading to Hummingbird Pro.", 'wphb' ); ?></p>

		<ul class="listing wphb-listing">
            <li>
                <strong><?php _e( 'Automation', 'wphb' ); ?></strong>
                <p><?php _e( 'Schedule Hummingbird to run regular performance tests daily, weekly or monthly and get email reports delivered straight to your inbox.', 'wphb' ); ?></p>
            </li>
            <li>
                <strong><?php _e( 'Enhanced Minify Compression', 'wphb' ); ?></strong>
                <p><?php _e( 'Compress your minified files up to 2x more than regular optimization and reuce your page load speed even further.', 'wphb' ); ?></p>
            </li>
            <li>
                <strong><?php _e( 'WPMU DEV CDN', 'wphb' ); ?></strong>
                <p><?php _e( "By default we minify your files via our API and send them back to your server. Pro users can host their files on WPMU DEV’s secure and hyper fast CDN, which will mean less load on your server and a fast visitor experience.", 'wphb' ); ?></p>
            </li>
            <li>
                <strong><?php _e( 'Smush Pro', 'wphb' ); ?></strong>
                <p><?php _e( "A membership for Hummingbird Pro also gets you the award winning Smush Pro with unlimited advanced lossy compression that’ll give image heavy websites a speed boost.", 'wphb' ); ?></p>
            </li>
		</ul>

        <p class="wphb-block-content-center"><?php _e( 'Get all of this, plus heaps more as part of a WPMU DEV membership.', 'wphb' ); ?></p>

        <div class="wphb-block-content-center">
            <a target="_blank" href="<?php echo wphb_plugin_page_link(); ?>" class="button button-content-cta button-large"><?php _e( 'Upgrade Membership', 'wphb' ); ?></a>
        </div>

		<div class="wphb-modal-image wphb-modal-image-bottom dev-man">
			<img class="wphb-image wphb-image-center"
                 src="<?php echo wphb_plugin_url() . 'admin/assets/image/dev-team.png'; ?>"
                 srcset="<?php echo wphb_plugin_url() . 'admin/assets/image/dev-team@2x.png'; ?> 2x"
                 alt="<?php _e('Hummingbird','wphb'); ?>">
		</div>

	</div>
</dialog><!-- end wphb-upgrade-membership-modal -->