<div class="um-admin-metabox">

	<p>
		<label><strong><?php _e('Show social connect on this form?','um-social-login'); ?></strong></label>
		<span>
			
			<?php $this->ui_on_off('_um_register_show_social', 1 ); ?>
				
		</span>
	</p><div class="um-admin-clear"></div>
	
</div>
<div class="um-admin-metabox">

	<p>
		<label><strong><?php _e('Use this form in the overlay?','um-social-login'); ?></strong></label>
		<span>
			
			<?php $this->ui_on_off('_um_social_login_form', 0 ); ?>
				
		</span>
	</p><div class="um-admin-clear"></div>
	
</div>