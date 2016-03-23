<section class="dev-box performance-section" id="wd-humming-widget">
	<div class="box-content tc">
		<img class="wd-no-margin" src="<?php echo wp_defender()->get_plugin_url() ?>assets/img/dev-girl.png"/>

		<p>
			<?php
			_e( "Give your website a performance boost with WP Hummingbird!", wp_defender()->domain )
			?>
		</p>
		<form method="post" id="wd_install_humming">
			<?php wp_nonce_field( 'wd_install_humming', 'wd_humming_widget' ) ?>
			<input type="hidden" name="action" value="wd_install_humming">
			<button type="submit" class="button button-grey block">
				<?php _e( "Install", wp_defender()->domain ) ?>
			</button>
		</form>
	</div>
</section>