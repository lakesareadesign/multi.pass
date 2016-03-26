<div class="um-admin-metabox">

	<h4><?php _e('Provider Settings','um-social-login'); ?></h4>
	
	<?php foreach( $um_social_login->networks as $provider => $array ) { ?>
	<p>
		<label class="um-admin-half"><?php printf(__('Enable <b>%s</b>','um-social-login'), $array['name']); ?></label>
		<span class="um-admin-half">
			
			<?php $metabox->ui_on_off('_um_enable_' . $provider, 1); ?>
				
		</span>
	</p><div class="um-admin-clear"></div>
	<?php } ?>
	
	<h4><?php _e('General Settings','um-social-login'); ?></h4>
	
	<p>
		<label class="um-admin-half"><?php _e('Show for logged-in users?','um-social-login'); ?></label>
		<span class="um-admin-half">
			
			<?php $metabox->ui_on_off('_um_show_for_members', 1); ?>
				
		</span>
	</p><div class="um-admin-clear"></div>
	
	<h4><?php _e('Button Appearance','um-social-login'); ?></h4>
	
	<p>
		<label class="um-admin-half"><?php _e('Show icon in the social login button?','um-social-login'); ?></label>
		<span class="um-admin-half">
			
			<?php $metabox->ui_on_off('_um_show_icons', 1); ?>
				
		</span>
	</p><div class="um-admin-clear"></div>
	
	<p>
		<label class="um-admin-half"><?php _e('Show label in the social login button?','um-social-login'); ?></label>
		<span class="um-admin-half">
			
			<?php $metabox->ui_on_off('_um_show_labels', 1); ?>
				
		</span>
	</p><div class="um-admin-clear"></div>
		
	<p>
		<label class="um-admin-half"><?php _e('Font Size','um-social-login'); ?></label>
		<span class="um-admin-half">
				
			<input type="text" name="_um_fontsize" id="_um_fontsize" value="<?php echo $ultimatemember->query->get_meta_value('_um_fontsize', null, 'na' ); ?>" class="small" placeholder="15px" />
				
		</span>
	</p><div class="um-admin-clear"></div>
	
	<p>
		<label class="um-admin-half"><?php _e('Icon Size','um-social-login'); ?></label>
		<span class="um-admin-half">
				
			<input type="text" name="_um_iconsize" id="_um_iconsize" value="<?php echo $ultimatemember->query->get_meta_value('_um_iconsize', null, 'na' ); ?>" class="small" placeholder="18px" />
				
		</span>
	</p><div class="um-admin-clear"></div>
	
	<p>
		<label class="um-admin-half"><?php _e('Button Style','um-social-login'); ?></label>
		<span class="um-admin-half">
			
			<select name="_um_button_style" id="_um_button_style" class="umaf-selectjs" style="width: 300px">
				<option value="default" <?php selected('default', $ultimatemember->query->get_meta_value('_um_button_style') ); ?>><?php _e('One button per line','um-social-login'); ?></option>
				<option value="responsive" <?php selected('responsive', $ultimatemember->query->get_meta_value('_um_button_style') ); ?>><?php _e('Responsive','um-social-login'); ?></option>
				<option value="floated" <?php selected('floated', $ultimatemember->query->get_meta_value('_um_button_style') ); ?>><?php _e('Floated','um-social-login'); ?></option>
			</select>
				
		</span>
	</p><div class="um-admin-clear"></div>
	
	<p>
		<label class="um-admin-half"><?php _e('Button Min Width','um-social-login'); ?></label>
		<span class="um-admin-half">
				
			<input type="text" name="_um_button_min_width" id="_um_button_min_width" value="<?php echo $ultimatemember->query->get_meta_value('_um_button_min_width', null, 'na' ); ?>" placeholder="e.g. 205px" />
				
		</span>
	</p><div class="um-admin-clear"></div>
	
	<p>
		<label class="um-admin-half"><?php _e('Button Padding','um-social-login'); ?></label>
		<span class="um-admin-half">
				
			<input type="text" name="_um_button_padding" id="_um_button_padding" value="<?php echo $ultimatemember->query->get_meta_value('_um_button_padding', null, 'na' ); ?>" placeholder="16px 20px" />
				
		</span>
	</p><div class="um-admin-clear"></div>
	
	<h4><?php _e('Container Appearance','um-social-login'); ?></h4>
	
	<p>
		<label class="um-admin-half"><?php _e('Container Max Width (Apply to responsive button style only)','um-social-login'); ?></label>
		<span class="um-admin-half">
				
			<input type="text" name="_um_container_max_width" id="_um_container_max_width" value="<?php echo $ultimatemember->query->get_meta_value('_um_container_max_width', null, '600px' ); ?>" placeholder="600px" />
				
		</span>
	</p><div class="um-admin-clear"></div>
	
	<p>
		<label class="um-admin-half"><?php _e('Container Margin','um-social-login'); ?></label>
		<span class="um-admin-half">
				
			<input type="text" name="_um_margin" id="_um_margin" value="<?php echo $ultimatemember->query->get_meta_value('_um_margin', null, 'na' ); ?>" placeholder="0px 0px 0px 0px" />
				
		</span>
	</p><div class="um-admin-clear"></div>
	
	<p>
		<label class="um-admin-half"><?php _e('Container Padding','um-social-login'); ?></label>
		<span class="um-admin-half">
				
			<input type="text" name="_um_padding" id="_um_padding" value="<?php echo $ultimatemember->query->get_meta_value('_um_padding', null, 'na' ); ?>" placeholder="0px 0px 0px 0px" />
				
		</span>
	</p><div class="um-admin-clear"></div>
	
</div>