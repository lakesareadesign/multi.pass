<div class="um-admin-metabox">
	
	<p>
		<label class="um-admin-half"><?php _e('Show on specific URLs only','um-notices'); ?></label>
		<span class="um-admin-half">
			
			<?php $metabox->ui_on_off('_um_show_in_urls', 0, true, 1, 'notice-urls', 'notice-urls-hide'); ?>

		</span>
	</p><div class="um-admin-clear"></div>
	
	<p class="notice-urls">
		<label class="um-admin-half"><?php _e('Enter allowed URLs one per line','um-notices'); ?></label>
		<span class="um-admin-half">
			
			<textarea name="_um_allowed_urls" id="_um_allowed_urls"><?php echo $ultimatemember->query->get_meta_value('_um_allowed_urls', null, 'na' ); ?></textarea>
				
		</span>
	</p><div class="um-admin-clear"></div>
	
	<p class="notice-urls-hide">
		<label class="um-admin-half"><?php _e('Show on Homepage','um-notices'); ?></label>
		<span class="um-admin-half">
			
			<?php $metabox->ui_on_off('_um_show_in_home', 1); ?>

		</span>
	</p><div class="um-admin-clear"></div>
	
	<p class="notice-urls-hide">
		<label class="um-admin-half"><?php _e('Show on Posts','um-notices'); ?></label>
		<span class="um-admin-half">
			
			<?php $metabox->ui_on_off('_um_show_in_posts', 1); ?>

		</span>
	</p><div class="um-admin-clear"></div>
	
	<p class="notice-urls-hide">
		<label class="um-admin-half"><?php _e('Show on Pages','um-notices'); ?></label>
		<span class="um-admin-half">
			
			<?php $metabox->ui_on_off('_um_show_in_pages', 1); ?>

		</span>
	</p><div class="um-admin-clear"></div>
	
	<p class="notice-urls-hide">
		<label class="um-admin-half"><?php _e('Show on Custom Post Types','um-notices'); ?></label>
		<span class="um-admin-half">
			
			<?php $metabox->ui_on_off('_um_show_in_types', 1); ?>

		</span>
	</p><div class="um-admin-clear"></div>
	
</div>