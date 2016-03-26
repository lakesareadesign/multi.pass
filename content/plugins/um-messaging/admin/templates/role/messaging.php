<?php global $um_messaging; ?>

<div class="um-admin-metabox">

	<div class="">
	
		<p>
			<label class="um-admin-half"><?php _e('Enable Messaging feature?','um-messaging'); ?> <?php $this->tooltip( __('Enable or disable messaging feature for this role','um-messaging') ); ?></label>
			<span class="um-admin-half"><?php $this->ui_on_off( '_um_enable_messaging', 1 ); ?></span>
		</p><div class="um-admin-clear"></div>
		
		<p>
			<label class="um-admin-half"><?php _e('Can start conversations?','um-messaging'); ?> <?php $this->tooltip( __('Can this role start conversation with other users?','um-messaging') ); ?></label>
			<span class="um-admin-half"><?php $this->ui_on_off( '_um_can_start_pm', 1 ); ?></span>
		</p><div class="um-admin-clear"></div>
		
		<p>
			<label class="um-admin-half"><?php _e('Can read private messages?','um-messaging'); ?> <?php $this->tooltip( __('Can this role read private messages from other users?','um-messaging') ); ?></label>
			<span class="um-admin-half"><?php $this->ui_on_off( '_um_can_read_pm', 1 ); ?></span>
		</p><div class="um-admin-clear"></div>
		
		<p>
			<label class="um-admin-half"><?php _e('Can read and reply private messages?','um-messaging'); ?> <?php $this->tooltip( __('Turn this off to disable reply ability for this role','um-messaging') ); ?></label>
			<span class="um-admin-half"><?php $this->ui_on_off( '_um_can_reply_pm', 1 ); ?></span>
		</p><div class="um-admin-clear"></div>
		
		<p>
			<label class="um-admin-half"><?php _e('Maximum number of messages they can send','ultimatemember'); ?></label>
			<span class="um-admin-half">
			
				<input type="text" name="_um_pm_max_messages" id="_um_pm_max_messages" value="<?php echo $ultimatemember->query->get_meta_value('_um_pm_max_messages', null, 0); ?>" class="small" style="display:inline" /> <?php _e('per','um-messaging'); ?> <input type="text" name="_um_pm_max_messages_tf" id="_um_pm_max_messages_tf" value="<?php echo $ultimatemember->query->get_meta_value('_um_pm_max_messages_tf', null, 0); ?>" class="small" style="display:inline" /> <?php _e('Days','um-messaging'); ?>
			
			</span>
		</p><div class="um-admin-clear"></div>
		
	</div>
	
	<div class="um-admin-clear"></div>
	
</div>