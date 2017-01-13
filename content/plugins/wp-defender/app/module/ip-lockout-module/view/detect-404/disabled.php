<div class="dev-box">
    <div class="box-title">
        <h3><?php esc_html_e( "404 DETECTION", wp_defender()->domain ) ?></h3>
    </div>
    <div class="box-content tc">
        <img src="<?php echo wp_defender()->get_plugin_url() ?>app/module/ip-lockout-module/assets/img/ip-lockout-disabled.svg"
             class="intro"/>
        <p class="intro">
			<?php esc_html_e( "With 404 detection enabled, Defender will keep an eye out for IP addresses that repeatedly request pages on your website that don’t exist and then temporarily block them from accessing your site.", wp_defender()->domain ) ?>
        </p>
        <form method="post">
			<?php wp_nonce_field( 'save_lockout_settings', '_wdnonce' ) ?>
            <input type="hidden" name="scenario" value="detect_404"/>
            <input type="hidden" name="detect_404" value="1"/>
            <button type="submit" class="button button-primary">
				<?php esc_html_e( "Enable", wp_defender()->domain ) ?>
            </button>
        </form>
    </div>
</div>