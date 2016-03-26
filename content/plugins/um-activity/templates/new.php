<div class="um-activity-widget um-activity-new-post">

	<form action="" method="post" class="um-activity-publish">

	<div class="um-activity-head">
		<?php echo ( um_profile_id() == get_current_user_id() ) ? __('Post on your wall','um-activity') : sprintf(__('Post on %s\'s wall','um-activity'), um_user('display_name') ); ?>
	</div>
	
	<div class="um-activity-body">

		<div class="um-activity-textarea">
			<textarea data-photoph="<?php _e('Say something about this photo','um-activity'); ?>" data-ph="<?php _e('What\'s on your mind?','um-activity'); ?>" placeholder="<?php _e('What\'s on your mind?','um-activity'); ?>" class="um-activity-textarea-elem" name="_post_content" id="_post_content"></textarea>
		</div>
		
		<div class="um-activity-preview">
			<span class="um-activity-preview-spn">
				<img src="" alt="" title="" width="" height="" />
				<span class="um-activity-img-remove"><i class="um-icon-close"></i></span>
			</span>
			<input type="hidden" name="_post_img" id="_post_img" value="" />
		</div><div class="um-clear"></div>

	</div>
	
	<div class="um-activity-foot">
	
		<div class="um-activity-left um-activity-insert">
		
			<?php do_action('um_activity_pre_insert_tools'); ?>
			
			<?php if ( !um_user_can('activity_photo_off') ) { ?>
			<a href="#" class="um-activity-insert-photo um-tip-s" title="<?php _e('Add photo','um-activity'); ?>" data-allowed="gif,png,jpeg,jpg" data-size-err="<?php _e('Image is too large','um-activity'); ?>" data-ext-err="<?php _e('Please upload a valid image','um-activity'); ?>"><i class="um-faicon-camera"></i></a>
			<?php } ?>
			
			<?php do_action('um_activity_post_insert_tools'); ?>
			
			<div class="um-clear"></div>
		</div>
		
		<div class="um-activity-right">

			<a href="#" class="um-button um-activity-post um-disabled"><?php _e('Post','um-activity'); ?></a>
		
		</div>
		<div class="um-clear"></div>
	
	</div>
	
	<input type="hidden" name="_wall_id" id="_wall_id" value="<?php echo $user_id; ?>" />
	<input type="hidden" name="_post_id" id="_post_id" value="0" />
	<input type="hidden" name="action" id="action" value="um_activity_publish" />
	
	</form>

</div>