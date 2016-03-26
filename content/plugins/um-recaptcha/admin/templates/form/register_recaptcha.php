<div class="um-admin-metabox">

	<?php $status = um_get_option('g_recaptcha_status'); ?>
	
	<?php if ( $status ) { ?>
	
	<p><?php _e('Google reCAPTCHA seems to be <strong style="color:#7ACF58">enabled</strong> by default.','um-recaptcha'); ?></p>
	
	<?php } else { ?>
	
	<p><?php _e('Google reCAPTCHA seems to be <strong style="color:#C74A4A">disabled</strong> by default.','um-recaptcha'); ?></p>
	
	<?php } ?>
	
	<p>
		<label><strong><?php _e('reCAPTCHA status on this form','um-recaptcha'); ?></strong></label>
		<span>
			
			<?php $this->ui_on_off('_um_register_g_recaptcha_status', $status, 0, 0, 0, 0, __('On','um-recaptcha'), __('Off','um-recaptcha') ); ?>
				
		</span>
	</p><div class="um-admin-clear"></div>
	
</div>