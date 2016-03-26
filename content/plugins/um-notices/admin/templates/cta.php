<div class="um-admin-metabox">

	<p>
		<label class="um-admin-half"><?php _e('Enable Call to Action button','um-notices'); ?></label>
		<span class="um-admin-half">
			
			<?php $metabox->ui_on_off('_um_cta', 0, true, 1, 'cta-opts', 'xxx'); ?>

		</span>
	</p><div class="um-admin-clear"></div>
	
	<p class="cta-opts">
		<label class="um-admin-half"><?php _e('Button Text','um-notices'); ?></label>
		<span class="um-admin-half">
			
			<input type="text" name="_um_cta_text" id="_um_cta_text" value="<?php echo $ultimatemember->query->get_meta_value('_um_cta_text', null, 'na'); ?>" />
			
		</span>
	</p><div class="um-admin-clear"></div>
	
	<p class="cta-opts">
		<label class="um-admin-half"><?php _e('Button URL','um-notices'); ?></label>
		<span class="um-admin-half">
			
			<input type="text" name="_um_cta_url" id="_um_cta_url" value="<?php echo $ultimatemember->query->get_meta_value('_um_cta_url', null, 'http://'); ?>" />
			
		</span>
	</p><div class="um-admin-clear"></div>
	
	<p class="cta-opts">
		<label class="um-admin-half"><?php _e('Button Background Color','um-notices'); ?></label>
		<span class="um-admin-half">
			
			<input type="text" value="<?php echo $ultimatemember->query->get_meta_value('_um_cta_bg', null, 'na'); ?>" class="um-admin-colorpicker" name="_um_cta_bg" id="_um_cta_bg" />

		</span>
	</p><div class="um-admin-clear"></div>

	<p class="cta-opts">
		<label class="um-admin-half"><?php _e('Button Text Color','um-notices'); ?></label>
		<span class="um-admin-half">
			
			<input type="text" value="<?php echo $ultimatemember->query->get_meta_value('_um_cta_clr', null, 'na'); ?>" class="um-admin-colorpicker" name="_um_cta_clr" id="_um_cta_clr" />

		</span>
	</p><div class="um-admin-clear"></div>
	
</div>