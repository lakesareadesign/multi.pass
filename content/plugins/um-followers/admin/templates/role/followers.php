<?php global $um_followers; ?>

<div class="um-admin-metabox">

	<div class="">

		<p>
			<label class="um-admin-half"><?php _e('Can follow others?','um-followers'); ?> <?php $this->tooltip( __('Can this role follow other members or not.','um-followers') ); ?></label>
			<span class="um-admin-half"><?php $this->ui_on_off( '_um_can_follow', 1, true, 1, 'follow-roles', 'xxx'); ?></span>
		</p><div class="um-admin-clear"></div>
		
		<p class="follow-roles">
			<label class="um-admin-half"><?php _e('Can follow these user roles only','um-followers'); ?></label>
			<span class="um-admin-half">
		
				<select multiple="multiple" name="_um_can_follow_roles[]" id="_um_can_follow_roles" class="umaf-selectjs" style="width: 300px">
					<?php foreach($ultimatemember->query->get_roles() as $key => $value) { ?>
					<option value="<?php echo $key; ?>" <?php selected($key, $ultimatemember->query->get_meta_value('_um_can_follow_roles', $key) ); ?>><?php echo $value; ?></option>
					<?php } ?>	
				</select>
			
			</span>
		</p><div class="um-admin-clear"></div>
		
	</div>

	<div class="um-admin-clear"></div>

</div>