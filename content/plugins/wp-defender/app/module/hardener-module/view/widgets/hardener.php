<div class="wd-hardener">
	<section class="dev-box">
		<div class="box-title">
			<h3>
				<?php esc_html_e( "Hardening", wp_defender()->domain ) ?>
				<a class="button button-light button-small wd-button-widget float-r"
				   href="<?php echo network_admin_url( 'admin.php?page=wdf-hardener' ) ?>"><?php esc_html_e( "View List", wp_defender()->domain ) ?></a>
			</h3>
		</div>
		<div class="box-content">
			<?php if ( count( $modules ) ): ?>
				<p>
					<?php printf( __( "You have <strong>%s issues</strong> outstanding. Get fixing, %s!", wp_defender()->domain ), number_format_i18n( count( $modules ) ), WD_Utils::get_display_name() ) ?>
				</p>
				<div class="wd-hardener-content">
					<section class="wd-hardener-rules wd-hardener-error">
						<?php
						foreach ( array_slice( $modules, 0, 3 ) as $module ) {
							//$class = new $module;;
							echo $module->display_link_only();
						} ?>
					</section>
				</div>
			<?php else: ?>
				<div class="wd-success wd-left">
					<i class="dev-icon dev-icon-radio_checked"></i>
					<?php esc_html_e( "Your website is well protected against hackers and bots.", wp_defender()->domain ) ?>
				</div>
			<?php endif; ?>
		</div>
	</section>
</div>