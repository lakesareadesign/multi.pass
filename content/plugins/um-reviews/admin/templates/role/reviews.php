<?php global $um_reviews; ?>

<div class="um-admin-metabox">

	<div class="">
	
		<p>
			<label class="um-admin-half"><?php _e('Can have user reviews tab?','um-bbpress'); ?> <?php $this->tooltip( __('If this is turned off user reviews will be disabled for this role.','um-reviews') ); ?></label>
			<span class="um-admin-half"><?php $this->ui_on_off( '_um_can_have_reviews_tab', 1 ); ?></span>
		</p><div class="um-admin-clear"></div>
		
		<p>
			<label class="um-admin-half"><?php _e('Can review other members?','um-bbpress'); ?> <?php $this->tooltip( __('Decide If this role can review other members','um-reviews') ); ?></label>
			<span class="um-admin-half"><?php $this->ui_on_off( '_um_can_review', 1, true, 1, 'review-roles', 'xxx'); ?></span>
		</p><div class="um-admin-clear"></div>
		
		<p class="review-roles">
			<label class="um-admin-half"><?php _e('Can review these roles only','um-reviews'); ?> <?php $this->tooltip( __('Which roles that role can review, choose none to allow role to review all member roles', 'um-reviews') ); ?></label>
			<span class="um-admin-half">
		
				<select multiple="multiple" name="_um_can_review_roles[]" id="_um_can_review_roles" class="umaf-selectjs" style="width: 300px">
					<?php foreach($ultimatemember->query->get_roles() as $key => $value) { ?>
					<option value="<?php echo $key; ?>" <?php selected($key, $ultimatemember->query->get_meta_value('_um_can_review_roles', $key) ); ?>><?php echo $value; ?></option>
					<?php } ?>	
				</select>
			
			</span>
		</p><div class="um-admin-clear"></div>
		
		<p>
			<label class="um-admin-half"><?php _e('Automatically publish reviews from this role?','um-bbpress'); ?> <?php $this->tooltip( __('If turned off, reviews from this role will be pending admin review.','um-reviews') ); ?></label>
			<span class="um-admin-half"><?php $this->ui_on_off( '_um_can_publish_review', 1 ); ?></span>
		</p><div class="um-admin-clear"></div>
		
		<p>
			<label class="um-admin-half"><?php _e('Can remove their own reviews?','um-bbpress'); ?> <?php $this->tooltip( __('If this is turned off user reviews will be disabled for this role.','um-reviews') ); ?></label>
			<span class="um-admin-half"><?php $this->ui_on_off( '_um_can_remove_own_review', 1 ); ?></span>
		</p><div class="um-admin-clear"></div>
		
		<p>
			<label class="um-admin-half"><?php _e('Can remove other reviews?','um-bbpress'); ?> <?php $this->tooltip( __('If this is turned off user reviews will be disabled for this role.','um-reviews') ); ?></label>
			<span class="um-admin-half"><?php $this->ui_on_off( '_um_can_remove_review', 0 ); ?></span>
		</p><div class="um-admin-clear"></div>
		
	</div>
	
	<div class="um-admin-clear"></div>
	
</div>