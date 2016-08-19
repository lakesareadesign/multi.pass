<div class="wphb-block-entry">

	<div class="wphb-block-entry-content">

		<img class="wphb-image-icon-content wphb-image-icon-content-top wphb-image-icon-content-center" src="<?php echo wphb_plugin_url() . 'admin/assets/image/icon-uptime-small.png'; ?>" alt="<?php _e('Uptime Monitoring', 'wphb'); ?>">

		<div class="content">

			<p><?php echo sprintf( __( "We can monitor your website's response time and let you know when you experience downtime. It’s included with your WPMU DEV Membership and all you have to do is flick a switch. What are you waiting for, %s?", 'wphb' ), $current_user); ?></p>
			<a class="button button button-cta-green button-content-cta" href="<?php echo esc_url( $enable_url ); ?>" id="enable-uptime"><?php _e( 'Enable Uptime Monitoring', 'wphb' ); ?></a><br>
		</div><!-- end content -->

	</div><!-- end wphb-block-entry-content -->

</div><!-- end wphb-block-entry -->