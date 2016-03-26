<?php global $um_profile_completeness; 

$remaining_progress = 100 - (int) get_post_meta( get_the_ID(), '_um_allocated_progress', true );

?>

<div class="um-admin-metabox">

	<p>
		<label><?php _e('Enable profile completeness','um-profile-completeness'); ?> <?php $this->tooltip( __('Turn on / off profile completeness features for this role','um-profile-completeness'), 'e'); ?></label>
		<span>
			
			<?php $this->ui_on_off('_um_profilec', 0, true, 1, 'profilecomplete-opts', 'xxx'); ?>
				
		</span>
	</p><div class="um-admin-clear"></div>
	
	<div class="profilecomplete-opts">

		<p><label for="_um_profilec_pct"><?php _e('Percentage (%) required for completion','um-profile-completeness'); ?> <?php $this->tooltip( __('Consider the profile complete when the user completes (%) by filling profile information.','um-profile-completeness'), 'e'); ?></label>
			<input type="text" value="<?php echo $ultimatemember->query->get_meta_value('_um_profilec_pct', null, 100 ); ?>" name="_um_profilec_pct" id="_um_profilec_pct" />
		</p>
		
		<div class="profilec-setup" data-post_id="<?php echo get_the_ID(); ?>">
			
			<h3><?php _e('Setup Fields','um-profile-completeness'); ?></h3>
			
			<div><?php _e('Remaining progress:','um-profile-completeness'); ?> <strong><span class="profilec-ajax"><?php echo $remaining_progress; ?></span>%</strong></div>
			
			<div class="profilec-data">
			
				<?php
				
				$meta = get_post_custom( get_the_ID() );
				foreach( $meta as $k => $v ) {
					if ( strstr( $k, '_um_progress_') ) {
						$v = $v[0];
						$k = str_replace( '_um_progress_', '', $k);
						echo "<p data-key='$k'><span class='profilec-key alignleft'>$k</span><span class='profilec-progress alignright'><strong><ins>$v</ins>%</strong> <span class='profilec-edit'><i class='um-faicon-pencil'></i></span></span></p><div class='clear'></div>";
					}
				}
				
				?>
				
				<div class="profilec-inline" data-post_id="<?php echo get_the_ID(); ?>">
					
					<p><label><?php _e('Edit allocated progress (%)','um-profile-completeness'); ?></label>
					<input type="text" name="progress_valuei" id="progress_valuei" value=""/>
					<input type="hidden" name="progress_fieldi" id="progress_fieldi" value=""/></p>
					
					<p><a href="#" class="profilec-update button-primary"><?php _e('Update','um-profile-completeness'); ?></a> <a href="#" class="profilec-remove button"><?php _e('Remove','um-profile-completeness'); ?></a><span class="spinner" style="display:none;"></span></p>
					
				</div>
				
			</div>
			
			<?php if ( $remaining_progress > 0 ) { ?>
			<p><a href="#" class="profilec-add button"><?php _e('Add field','um-profile-completeness'); ?></a><span class="spinner" style="display:none;"></span></p>
			<?php } ?>

		</div>
		
		<div class="profilec-field" data-post_id="<?php echo get_the_ID(); ?>">
		
		</div>
		
		<p><label for="_um_profilec_upgrade_role"><?php _e('Upgrade to role automatically when profile is 100% complete:','um-profile-completeness'); ?></label>
			<select name="_um_profilec_upgrade_role" id="_um_profilec_upgrade_role" class="umaf-selectjs" style="width: 100%">
				
				<?php foreach($ultimatemember->query->get_roles( $add_default = __('Do not upgrade','um-profile-completeness') ) as $key => $value) { ?>
				
				<option value="<?php echo $key; ?>" <?php selected($key, $ultimatemember->query->get_meta_value('_um_profilec_upgrade_role', null, 'na' ) ); ?>><?php echo $value; ?></option>
				
				<?php } ?>
				
			</select>
		</p>
		
		<p>
			<label><?php _e('Require profile to be complete to browse the site?','um-profile-completeness'); ?> <?php $this->tooltip( __('Prevent user from browsing site If their profile completion is below the completion threshold set up above?','um-profile-completeness'), 'e'); ?></label>
			<span>
				
				<?php $this->ui_on_off('_um_profilec_prevent_browse', 0); ?>
					
			</span>
		</p><div class="um-admin-clear"></div>
		
		<p>
			<label><?php _e('Require profile to be complete to browse user profiles?','um-profile-completeness'); ?> <?php $this->tooltip( __('Prevent user from browsing other profiles If their profile completion is below the completion threshold set up above?','um-profile-completeness'), 'e'); ?></label>
			<span>
				
				<?php $this->ui_on_off('_um_profilec_prevent_profileview', 0); ?>
					
			</span>
		</p><div class="um-admin-clear"></div>
		
		<p>
			<label><?php _e('Require profile to be complete to leave a comment?','um-profile-completeness'); ?> <?php $this->tooltip( __('Prevent user from leaving comments If their profile completion is below the completion threshold set up above?','um-profile-completeness'), 'e'); ?></label>
			<span>
				
				<?php $this->ui_on_off('_um_profilec_prevent_comment', 0); ?>
					
			</span>
		</p><div class="um-admin-clear"></div>
		
		<p>
			<label><?php _e('Require profile to be complete to create new bbPress topics/replies?','um-profile-completeness'); ?> <?php $this->tooltip( __('Prevent user from adding participating in forum If their profile completion is below the completion threshold set up above?','um-profile-completeness'), 'e'); ?></label>
			<span>
				
				<?php $this->ui_on_off('_um_profilec_prevent_bb', 0); ?>
					
			</span>
		</p><div class="um-admin-clear"></div>
	
	</div>
	
	<div class="um-admin-clear"></div>
	
</div>