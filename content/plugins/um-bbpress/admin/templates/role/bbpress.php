<?php global $um_bbpress; ?>

<div class="um-admin-metabox">

	<div class="">
	
		<p>
			<label class="um-admin-half"><?php _e('Can have forums tab?','um-bbpress'); ?> <?php $this->tooltip( __('If you turn this off, this role will not have a forums tab active in their profile.','um-bbpress') ); ?></label>
			<span class="um-admin-half"><?php $this->ui_on_off( '_um_can_have_forums_tab', 1 ); ?></span>
		</p><div class="um-admin-clear"></div>
		
		<p>
			<label class="um-admin-half"><?php _e('Can create new topics?','um-bbpress'); ?> <?php $this->tooltip( __('Generally, decide If this role can create new topics in the forums or not.','um-bbpress') ); ?></label>
			<span class="um-admin-half"><?php $this->ui_on_off( '_um_can_create_topics', 1, true, 1, 'xxx', '_um_can_create_topics' ); ?></span>
		</p><div class="um-admin-clear"></div>
		
		<p class="_um_can_create_topics">
			<label class="um-admin-half" for="_um_lock_notice2"><?php _e('Custom message to show if you force locking new topic','um-press'); ?></label>
			<span class="um-admin-half">
			
				<textarea name="_um_lock_notice2" id="_um_lock_notice2"><?php echo $ultimatemember->query->get_meta_value('_um_lock_notice2', null, 'na' ); ?></textarea>
				
			</span>
		</p><div class="um-admin-clear"></div>
		
		<p>
			<label class="um-admin-half"><?php _e('Can create new replies?','um-bbpress'); ?> <?php $this->tooltip( __('Generally, decide If this role can create new replies in the forums or not.','um-bbpress') ); ?></label>
			<span class="um-admin-half"><?php $this->ui_on_off( '_um_can_create_replies', 1 ); ?></span>
		</p><div class="um-admin-clear"></div>
		
		<p>
			<label class="um-admin-half"><?php _e('Disable new topics during these weekdays','um-bbpress'); ?> <?php $this->tooltip( __('Choose week days to disable this role from creating new topics on those days','um-bbpress') ); ?></label>
			<span class="um-admin-half">
				<select multiple="multiple" name="_um_lock_days[]" id="_um_lock_days" class="umaf-selectjs" style="width: 300px">
					<?php foreach($um_bbpress->get_weekdays() as $i => $day) { ?>
					<option value="<?php echo $i; ?>" <?php selected($i, $ultimatemember->query->get_meta_value('_um_lock_days', $i) ); ?>><?php echo $day; ?></option>
					<?php } ?>	
				</select>
			</span>
			
		</p><div class="um-admin-clear"></div>
		
		<p>
			<label class="um-admin-half" for="_um_lock_notice"><?php _e('Custom message to show to user if user cannot post in the above selected days','um-press'); ?></label>
			<span class="um-admin-half">
			
				<textarea name="_um_lock_notice" id="_um_lock_notice"><?php echo $ultimatemember->query->get_meta_value('_um_lock_notice', null, 'na' ); ?></textarea>
				
			</span>
		</p><div class="um-admin-clear"></div>
		
	</div>
	
	<div class="um-admin-clear"></div>
	
</div>