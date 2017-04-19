<div class="wrap">
    <div class="wp-defender">
        <div class="wdf-scanning">
            <div class="dev-box">
                <div class="box-title">
                    <h3><?php _e( "GET STARTED", wp_defender()->domain ) ?></h3>
                </div>
                <div class="box-content tc">
                    <img src="<?php echo wp_defender()->getPluginUrl() ?>assets/img/scan-man.svg" class="mline">
                    <div class="line max-600">
						<?php _e( "Defender watches and protects your login area for attackers trying to randomly guess
                        login details for your site and locks them out after a set number of failed attempts.", wp_defender()->domain ) ?>
                    </div>
                    <form id="start-a-scan" method="post" class="scan-frm">
						<?php
						wp_nonce_field( 'startAScan' );
						?>
                        <input type="hidden" name="action" value="startAScan"/>
                        <button type="submit" class="button"><?php _e( "RUN SCAN", wp_defender()->domain ) ?></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>