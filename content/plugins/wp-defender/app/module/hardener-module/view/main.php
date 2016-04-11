<div class="dev-box">
	<div class="box-title">
		<h3><?php _e( "Issues", wp_defender()->domain ) ?></h3>
	</div>
	<div class="box-content">
		<div class="hardener-error-container <?php echo count( $issues ) == 0 ? 'wd-hide' : null ?>">
			<h3 class="tc hardener-title"><?php _e( "Action Needed", wp_defender()->domain ) ?></h3>

			<p class="tc wd-no-padding">
				<?php _e( "Vulnerabilities leave you easy to attack. It’s highly recommend you address these <strong>immediately</strong>.", wp_defender()->domain ) ?>
			</p>
			<section class="wd-hardener-rules wd-hardener-error">
				<?php foreach ( $issues as $module ): ?>
					<?php
					$module->display();
					?>
				<?php endforeach; ?>
			</section>
			<br/>
		</div>
		<h3 class="tc hardener-title">
			<?php
			if ( count( $issues ) == 0 ) {
				_e( "All Issues Resolved", wp_defender()->domain );
			} else {
				_e( "Resolved", wp_defender()->domain );
			} ?>
		</h3>

		<p class="tc wd-no-padding">
			<?php printf( __( "Nice one, %s! These security loopholes are all tightened up.", wp_defender()->domain ), WD_Utils::get_display_name() ) ?>
		</p>
		<section class="wd-hardener-rules wd-hardener-success">
			<?php foreach ( $resolved as $module ): ?>
				<?php
				$module->display();
				?>
			<?php endforeach; ?>
		</section>
		<?php
		if ( count( $ignored ) > 0 ) :?>
			<h3 class="tc hardener-title">
				<?php _e( "Ignored", wp_defender()->domain ); ?>
			</h3>
			<p class="tc wd-no-padding">
				<?php _e( " You’ve chosen to ignore these tweaks. You can restore them at any time", wp_defender()->domain ) ?>
			</p>
			<section class="wd-hardener-rules wd-hardener-ignored">
				<?php foreach ( $ignored as $module ): ?>
					<?php
					echo $module->ignore_html();
					?>
				<?php endforeach; ?>
			</section>
		<?php endif; ?>
	</div>
</div>