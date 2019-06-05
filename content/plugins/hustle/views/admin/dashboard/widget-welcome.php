<div class="wpmudev-row">
	<div class="wpmudev-col col-12">
		<div id="wph-welcome" class="wpmudev-box wpmudev-box-close" data-nonce="<?php echo esc_attr( wp_create_nonce('hustle_new_welcome_notice') ); ?>">
			<div class="wpmudev-box-head">
				<h2><?php esc_attr_e( "Welcome to Hustle 3.0", Opt_In::TEXT_DOMAIN ); ?></h2>
				<?php $this->render("general/icons/icon-close" ); ?>
			</div>
			<div class="wpmudev-box-body wpmudev-box-hero">
				<div class="wpmudev-box-character" aria-hidden="true"><?php $this->render("general/characters/character-one" ); ?></div>
				<div class="wpmudev-box-content">
					<h2><?php esc_attr_e( "LET'S GET YOU STARTED", Opt_In::TEXT_DOMAIN ); ?></h2>
					<p><?php esc_attr_e( "Create a module from the following to get started on converting your visitors into subscribers, generate more leads and grow your social following like a pro.", Opt_In::TEXT_DOMAIN ); ?></p>
				</div>
			</div>
		</div><?php // .wpmudev-box ?>
	</div><?php // .wpmudev-col ?>
</div><?php // .wpmudev-row ?>
