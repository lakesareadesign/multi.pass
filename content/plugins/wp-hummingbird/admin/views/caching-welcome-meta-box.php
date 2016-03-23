<div class="wphb-block-entry">

	<div class="wphb-block-entry-content">

		<img class="wphb-image-icon-content wphb-image-icon-content-top wphb-image-icon-content-center" src="<?php echo wphb_plugin_url() . 'admin/assets/image/icon-caching.png'; ?>" alt="<?php _e('Caching', 'wphb'); ?>">

		<h2 class="title"><?php echo sprintf( __( "No cache? That's like no recycling, %s", 'wphb' ), $user); ?></h2>

		<div class="content">
			<p><?php _e( "Hummingbird has detected that you aren't currently caching your static resources. This means that repeat<br> visitors have to download everything every time they visit. Turn on caching to make sure they only<br> have to download stuff once - they'll love your for it!", 'wphb' ); ?></p>
			<button class="button button-cta button-content-cta" id="enable-caching"><?php _e( 'Enable caching', 'wphb' ); ?></button>
		</div><!-- end content -->

	</div><!-- end wphb-block-entry-content -->

</div><!-- end wphb-block-entry -->