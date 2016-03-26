<div class="um-admin-metabox">

	<p>
		<label class="um-admin-half"><?php _e('Allow this notice to appear in footer','um-notices'); ?> <?php $metabox->tooltip( __('If turned off, this notice can only appear using shortcode method','um-notices') ); ?></label>
		<span class="um-admin-half">
			
			<?php $metabox->ui_on_off('_um_show_in_footer', 1); ?>

		</span>
	</p><div class="um-admin-clear"></div>
	
	<p>
		<label class="um-admin-half"><?php _e('Display this notice to logged out users','um-notices'); ?></label>
		<span class="um-admin-half">
			
			<?php $metabox->ui_on_off('_um_show_loggedout', 0); ?>

		</span>
	</p><div class="um-admin-clear"></div>
	
	<p>
		<label class="um-admin-half"><?php _e('Display this notice to logged in users','um-notices'); ?></label>
		<span class="um-admin-half">
			
			<?php $metabox->ui_on_off('_um_show_loggedin', 1, true, 1, 'logged-in-notice', 'xxx'); ?>

		</span>
	</p><div class="um-admin-clear"></div>
	
	<p class="logged-in-notice">
		<label class="um-admin-half"><?php _e('Which user roles can see this notice','um-notices'); ?> <?php $metabox->tooltip( __('Leave blank to show to all user roles','um-notices') ); ?></label>
		<span class="um-admin-half">
			
			<select multiple="multiple" name="_um_roles[]" id="_um_roles" class="umaf-selectjs" style="width: 300px">
				<?php foreach($ultimatemember->query->get_roles() as $key => $value) { ?>
				<option value="<?php echo $key; ?>" <?php selected($key, $ultimatemember->query->get_meta_value('_um_roles', $key) ); ?>><?php echo $value; ?></option>
				<?php } ?>	
			</select>
				
		</span>
	</p><div class="um-admin-clear"></div>
	
	<p class="logged-in-notice">
		<label class="um-admin-half"><?php _e('Show If the user did not','um-notices'); ?></label>
		<span class="um-admin-half">
			
			<select name="_um_custom_field" id="_um_custom_field" class="umaf-selectjs um-adm-conditional" style="width: 300px" data-cond1='other' data-cond1-show='custom-field'>
				<option value="0" <?php selected(0, $ultimatemember->query->get_meta_value('_um_custom_field') ); ?>>&mdash;</option>
				<option value="profile_photo" <?php selected('profile_photo', $ultimatemember->query->get_meta_value('_um_custom_field') ); ?>><?php _e('Upload profile photo','um-notices'); ?></option>
				<option value="cover_photo" <?php selected('cover_photo', $ultimatemember->query->get_meta_value('_um_custom_field') ); ?>><?php _e('Upload cover photo','um-notices'); ?></option>
				<option value="other" <?php selected('other', $ultimatemember->query->get_meta_value('_um_custom_field') ); ?>><?php _e('Other','um-notices'); ?></option>
			</select>
				
		</span>
	</p><div class="um-admin-clear"></div>
	
	<p class="custom-field">
		<label class="um-admin-half"><?php _e('Show If the user did not fill that metakey','um-notices'); ?></label>
		<span class="um-admin-half">
			
			<input type="text" value="<?php echo $ultimatemember->query->get_meta_value('_um_custom_key', null, 'na'); ?>" name="_um_custom_key" id="_um_custom_key" />

		</span>
	</p><div class="um-admin-clear"></div>
	
	<p>
		<label class="um-admin-half"><?php _e('Show only to certain user(s)','um-notices'); ?> <?php $metabox->tooltip( __('A comma seperated list of user IDs or usernames to show this notice for','um-notices') ); ?></label>
		<span class="um-admin-half">
			
			<input type="text" value="<?php echo $ultimatemember->query->get_meta_value('_um_only_users', null, 'na'); ?>" name="_um_only_users" id="_um_only_users" />

		</span>
	</p><div class="um-admin-clear"></div>
	
	<?php if ( class_exists( 'Easy_Digital_Downloads' ) ) { ?>
	
	<h4><?php _e('Easy Digital Downloads Integration','um-notices'); ?></h4>
	
	<p>
		<label class="um-admin-half"><?php _e('Show to shop users','um-notices'); ?></label>
		<span class="um-admin-half">
			
			<select name="_um_edd_users" id="_um_edd_users" class="umaf-selectjs um-adm-conditional" style="width: 300px" data-cond1='2' data-cond1-show='purchased-edd'>
				<option value="0" <?php selected(0, $ultimatemember->query->get_meta_value('_um_edd_users') ); ?>><?php _e('All','um-notices'); ?></option>
				<option value="1" <?php selected(1, $ultimatemember->query->get_meta_value('_um_edd_users') ); ?>><?php _e('Users who did not purchase anything','um-notices'); ?></option>
				<option value="2" <?php selected(2, $ultimatemember->query->get_meta_value('_um_edd_users') ); ?>><?php _e('Users who made purchases','um-notices'); ?></option>
			</select>

		</span>
	</p><div class="um-admin-clear"></div>
	
	<p class="purchased-edd">
		<label class="um-admin-half"><?php _e('Spent at least (on purchases)','um-notices'); ?></label>
		<span class="um-admin-half">
			
			<input type="text" value="<?php echo $ultimatemember->query->get_meta_value('_um_edd_users_amount', null, 'na'); ?>" name="_um_edd_users_amount" id="_um_edd_users_amount" />

		</span>
	</p><div class="um-admin-clear"></div>
	
	<?php } ?>
	
</div>