<section class="row sub-header">
	<div class="wphb-block-section">
		<p><?php _e( 'Minifying, combining and positioning files can have a huge impact on how long it takes your website to load for visitors.', 'wphb' ); ?></p>
	</div>

	<?php if ( $instructions ): ?>
		<div class="wphb-block-section">
			<div class="row">
				<div class="col-third">
					<div class="wphb-block-section-content wphb-steps">
						<div class="wphb-step wphb-step-1">
							<div class="wphb-step-number">
								<div class="wphb-step-number-inner">1</div>
							</div>
							<div class="wphb-step-content">
								<p class="title"><?php _e( 'Select files', 'wphb' ); ?></p>
								<p><?php _e( 'Select what files you want to include or leave out. The less your visitors have to load, the better. Be sure to test your site when removing files.', 'wphb' ); ?></p>
							</div><!-- end wphb-step-content -->
						</div><!-- end wphb-step-1 -->
					</div><!-- end wphb-steps -->
				</div>
				<div class="col-third">
					<div class="wphb-block-section-content wphb-steps">
						<div class="wphb-step wphb-step-2">
							<div class="wphb-step-number">
								<div class="wphb-step-number-inner">2</div>
							</div>
							<div class="wphb-step-content">
								<p class="title"><?php _e( 'Minify and/or combine files', 'wphb' ); ?></p>
								<p><?php _e( 'Choose whether you want to minify (reduce size) and/or combine into single files. The less requests to the server and the more you can minify, the better.', 'wphb' ); ?></p>
							</div><!-- end wphb-step-content -->
						</div><!-- end wphb-step-2 -->
					</div><!-- end wphb-steps -->
				</div>
				<div class="col-third">
					<div class="wphb-block-section-content wphb-steps">
						<div class="wphb-step wphb-step-3">
							<div class="wphb-step-number">
								<div class="wphb-step-number-inner">3</div>
							</div>
							<div class="wphb-step-content">
								<p class="title"><?php _e( 'Choose position', 'wphb' ); ?></p>
								<p><?php _e( 'Choose whether to load the files in the header or footer of the page, or leave them in their original position. The more you load in the header of the page, the slower your website will load.', 'wphb' ); ?></p>
							</div><!-- end wphb-step-content -->
						</div><!-- end wphb-step-3 -->
					</div><!-- end wphb-steps -->
				</div>
			</div>
		</div><!--  end wphb-block-section -->
	<?php endif; ?>
</section><!-- end sub-header -->

<div class="row">
	<?php $this->do_meta_boxes( 'box-enqueued-files-empty' ); ?>
</div>

<div class="row">
	<?php $user = get_current_user_info(); ?>
	<div class="wphb-notice wphb-notice-box no-top-space">
		<p><?php echo sprintf( __( '%s, moving files between the header and footer of your page can break your website. We recommend tweaking and checking each file as you go and if a setting causes errors then revert the setting here.', 'wphb' ), $user); ?></p>
	</div>
	<form action="" method="post">
		<?php $this->do_meta_boxes( 'main' ); ?>
	</form>
</div>

<script>
	jQuery(document).ready( function() {
		var module = WPHB_Admin.getModule( 'minification' );
		<?php if ( isset( $_GET['run'] ) ): ?>
			module.$checkFilesButton.trigger( 'click' );
		<?php endif; ?>
	});
</script>