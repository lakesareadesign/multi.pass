<?php global $um_friends; ?>

<div class="um-admin-metabox">

	<div class="">

		<p>
			<label class="um-admin-half"><?php _e('Can friend others?','um-friends'); ?> <?php $this->tooltip( __('Can this role friend other members or not.','um-friends') ); ?></label>
			<span class="um-admin-half"><?php $this->ui_on_off( '_um_can_friend', 1, true, 1, 'friend-roles', 'xxx'); ?></span>
		</p><div class="um-admin-clear"></div>
		
		<p class="friend-roles">
			<label class="um-admin-half"><?php _e('Can friend these user roles only','um-friends'); ?></label>
			<span class="um-admin-half">
		
				<select multiple="multiple" name="_um_can_friend_roles[]" id="_um_can_friend_roles" class="umaf-selectjs" style="width: 300px">
					<?php foreach($ultimatemember->query->get_roles() as $key => $value) { ?>
					<option value="<?php echo $key; ?>" <?php selected($key, $ultimatemember->query->get_meta_value('_um_can_friend_roles', $key) ); ?>><?php echo $value; ?></option>
					<?php } ?>	
				</select>
			
			</span>
		</p><div class="um-admin-clear"></div>
		
	</div>

	<div class="um-admin-clear"></div>

</div>