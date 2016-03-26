<div class="um-admin-metabox">

	<?php if ( isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit' ) { ?>
	
	<p>
		<label class="um-admin-half"><?php _e('Connected to Mailing List ID','um-mailchimp'); ?></label>
		<span class="um-admin-half"><?php echo $ultimatemember->query->get_meta_value('_um_list'); ?></span>
	</p><div class="um-admin-clear"></div>
	
	<?php } else { ?>
	
	<?php $lists = $um_mailchimp->api->get_lists(); ?>
	
	<p>
		<label class="um-admin-half"><?php _e('Choose a list','um-mailchimp'); ?> <?php $metabox->tooltip( __('Choose a list from your MailChimp account','um-mailchimp') ); ?></label>
		<span class="um-admin-half">
			
			<select name="_um_list" id="_um_list" class="umaf-selectjs" style="width: 300px">
				<?php foreach( $lists as $key => $value ) { ?>
				<option value="<?php echo $key; ?>" <?php selected($key, $ultimatemember->query->get_meta_value('_um_list', $key ) ); ?>><?php echo $value; ?></option>
				<?php } ?>
			</select>
				
		</span>
	</p><div class="um-admin-clear"></div>
	
	<?php } ?>
	
	<p>
		<label class="um-admin-half"><?php _e('Enable this MailChimp list','um-mailchimp'); ?> <?php $metabox->tooltip( __('Turn on or off this list globally. If enabled the list will be available in user account page.','um-mailchimp') ); ?></label>
		<span class="um-admin-half">
			
			<?php $metabox->ui_on_off('_um_status', 1); ?>
				
		</span>
	</p><div class="um-admin-clear"></div>
	
	<p>
		<label class="um-admin-half"><?php _e('List Description in Account Page','um-mailchimp'); ?> <?php $metabox->tooltip( __('This text will be displayed in Account > Notifications to encourage user to sign or know what this list is about','um-mailchimp') ); ?></label>
		<span class="um-admin-half">
			
			<input type="text" name="_um_desc" id="_um_desc" value="<?php echo $ultimatemember->query->get_meta_value('_um_desc', null, 'na'); ?>" />
			
		</span>
	</p><div class="um-admin-clear"></div>
		
	<p>
		<label class="um-admin-half"><?php _e('List Description in Registration','um-mailchimp'); ?> <?php $metabox->tooltip( __('This text will be displayed in register form if you enable this mailing list to be available during signup','um-mailchimp') ); ?></label>
		<span class="um-admin-half">
			
			<input type="text" name="_um_desc_reg" id="_um_desc_reg" value="<?php echo $ultimatemember->query->get_meta_value('_um_desc_reg', null, 'na'); ?>" />
			
		</span>
	</p><div class="um-admin-clear"></div>
	
	<p>
		<label class="um-admin-half"><?php _e('Automatically add new users to this list','um-mailchimp'); ?> <?php $metabox->tooltip( __('If turned on users will automatically be subscribed to this when they register. When turned on this list will not show on register form even if you add MailChimp field to register form.','um-mailchimp') ); ?></label>
		<span class="um-admin-half">
			
			<?php $metabox->ui_on_off('_um_reg_status', 0); ?>
				
		</span>
	</p><div class="um-admin-clear"></div>
	
	<p>
		<label class="um-admin-half"><?php _e('Which roles can subscribe to this list','um-mailchimp'); ?> <?php $metabox->tooltip( __('Select which roles can subscribe to this list. Users who cannot subscribe to this list will not see this list on their account page.','um-mailchimp') ); ?></label>
		<span class="um-admin-half">
			
			<select multiple="multiple" name="_um_roles[]" id="_um_roles" class="umaf-selectjs" style="width: 300px">
				<?php foreach($ultimatemember->query->get_roles() as $key => $value) { ?>
				<option value="<?php echo $key; ?>" <?php selected($key, $ultimatemember->query->get_meta_value('_um_roles', $key) ); ?>><?php echo $value; ?></option>
				<?php } ?>	
			</select>
				
		</span>
	</p><div class="um-admin-clear"></div>

</div>