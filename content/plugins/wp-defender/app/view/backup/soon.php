<div class="wrap">
	<div class="wpmud">
		<div class="wp-defender">
			<section id="header">
				<h1 class="tl"><?php _e( "Backups", wp_defender()->domain ) ?></h1>
			</section>
			<section class="dev-box backup-section" id="wd-backup-widget">
				<div class="box-title">
					<h3><?php _e( "Backups", wp_defender()->domain ) ?></h3>
				</div>
				<div class="box-content tc">
					<img class="wd-bottom-30" width="200"
					     src="<?php echo wp_defender()->get_plugin_url() ?>assets/img/dev-man-backup.png"/>

					<h2 class="wd-title">
						<?php _e( "Secure Cloud Backups", wp_defender()->domain ) ?>
					</h2>
					<div class="wd-error wd-hide">

					</div>
					<p>
						<?php
						_e( 'WPMU DEV will soon offer automated, full website, cloud hosted, secure backups for all active members. If you ever get hacked you can revert to a previous version via our backups – easy! For now, you can still install Snapshot and backup your website locally which we recommend you do!', wp_defender()->domain )
						?>
					</p>
					<?php if ( is_plugin_active( 'snapshot/snapshot.php' ) ): ?>
						<?php _e( "Great, you have Snapshot installed! Make sure you're running regular backups.", wp_defender()->domain ) ?>
					<?php else: ?>
						<?php
						if ( WD_Utils::is_wpmudev_dashboard_installed() ) {
							?>
							<form method="post" id="wd_install_snapshot">
								<?php wp_nonce_field( 'wd_install_snapshot', 'wd_backup_widget' ) ?>
								<input type="hidden" name="action" value="wd_install_snapshot">
								<button type="submit" class="button wd-button button-cta">
									<?php _e( "Install Snapshot", wp_defender()->domain ) ?>
								</button>
							</form>
							<?php
							$url = network_admin_url( 'admin.php?page=wpmudev-plugins#project-257' );
						} else {
							$url = "https://premium.wpmudev.org/project/snapshot/";
							?>
							<a class="button wd-button button-cta"
							   href="<?php echo $url ?>"><?php _e( "Install Snapshot", wp_defender()->domain ) ?></a>
							<?php
						}
						?>
					<?php endif; ?>
				</div>
			</section>
		</div>
	</div>
</div>