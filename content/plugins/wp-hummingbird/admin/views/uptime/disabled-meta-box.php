<div class="wphb-block-entry">

	<div class="wphb-block-entry-content">

		<img class="wphb-image-icon-content wphb-image-icon-content-top wphb-image-icon-content-center" src="<?php echo wphb_plugin_url() . 'admin/assets/image/icon-uptime.png'; ?>" alt="<?php _e('Uptime', 'wphb'); ?>">

		<h2 class="title"><?php _e( 'Monitor your website', 'wphb' ); ?></h2>

		<div class="content">
			<p><?php echo sprintf( __( 'We can monitor your website\'s response time and let you know when you experience downtime. It\'s included with your WPMU DEV Membership and all <br> you have to do is flick a switch. What are you waiting for, %s?', 'wphb' ), $user); ?></p>
			<a href="<?php echo esc_url( $activate_url ); ?>" class="button button-cta-green button-content-cta" id="activate-uptime"><?php _e( 'Activate Uptime Monitoring', 'wphb' ); ?></a>
		</div><!-- end content -->

	</div><!-- end wphb-block-entry-content -->

</div><!-- end wphb-block-entry -->