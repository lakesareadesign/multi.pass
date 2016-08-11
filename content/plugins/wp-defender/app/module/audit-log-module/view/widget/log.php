<section class="dev-box">
	<div class="box-title">
		<h3><?php _e( "Audit Logging", wp_defender()->domain ) ?>
			<a class="button button-light button-small wd-button-widget float-r"
			   href="<?php echo network_admin_url( 'admin.php?page=wdf-logging' ) ?>"><?php _e( "Configure", wp_defender()->domain ) ?></a>
		</h3>
	</div>
	<div class="box-content tc">
		<?php if ( is_wp_error( $total ) ): ?>
			<div class="wd-error">
				<?php echo $total->get_error_message() ?>
			</div>
		<?php else: ?>
			<div class="wd-well wd-well-small blue">
				<?php printf( __( "There have been %s events logged in the last 24 hours", wp_defender()->domain ), $total ) ?>
			</div>
			<br/>
			<a href="<?php echo network_admin_url( 'admin.php?page=wdf-logging' ) ?>" class="button button-grey block">
				<?php _e( "SEE ALL EVENTS", wp_defender()->domain ) ?>
			</a>
			<div class="wd-clearfix"></div>
			<br/>
			<p>
				<?php printf( __( "Automatic email reports are currently <strong>%s</strong>", wp_defender()->domain ),
					WD_Utils::get_setting( 'audit_log->report_email', false ) == true ? __( "activated", wp_defender()->domain ) : __( "disabled", wp_defender()->domain ) ) ?>
			</p>
		<?php endif; ?>
	</div>
</section>