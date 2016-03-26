<?php global $um_activity; ?>

<div class="um-admin-metabox">

	<div class="">
	
		<p>
			<label class="um-admin-half"><?php _e('Turn off social wall for this user?','um-activity'); ?></label>
			<span class="um-admin-half"><?php $this->ui_on_off( '_um_activity_wall_off', 0 ); ?></span>
		</p><div class="um-admin-clear"></div>
		
		<p>
			<label class="um-admin-half"><?php _e('Do not allow this role to write posts?','um-activity'); ?></label>
			<span class="um-admin-half"><?php $this->ui_on_off( '_um_activity_posts_off', 0 ); ?></span>
		</p><div class="um-admin-clear"></div>
		
		<p>
			<label class="um-admin-half"><?php _e('Turn off uploading photos?','um-activity'); ?></label>
			<span class="um-admin-half"><?php $this->ui_on_off( '_um_activity_photo_off', 0 ); ?></span>
		</p><div class="um-admin-clear"></div>
		
		<p>
			<label class="um-admin-half"><?php _e('Do not allow this role to write comments?','um-activity'); ?></label>
			<span class="um-admin-half"><?php $this->ui_on_off( '_um_activity_comments_off', 0 ); ?></span>
		</p><div class="um-admin-clear"></div>
		
	</div>
	
	<div class="um-admin-clear"></div>
	
</div>