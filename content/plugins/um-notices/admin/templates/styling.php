<div class="um-admin-metabox">

	<p><strong><?php _e('If you do not provide custom styling here, defaults will be used.','um-notices'); ?></strong></p>
	
	<p>
		<label class="um-admin-half"><?php _e('Notice Minimum Width','um-notices'); ?> <?php $metabox->tooltip( __('Set a minimum width for notice wrapper','um-notices') ); ?></label>
		<span class="um-admin-half">
			
			<input type="text" name="_um_min_width" id="_um_min_width" value="<?php echo $ultimatemember->query->get_meta_value('_um_min_width', null, 'na'); ?>" />
			
		</span>
	</p><div class="um-admin-clear"></div>
	
	<p>
		<label class="um-admin-half"><?php _e('Notice background color','um-notices'); ?></label>
		<span class="um-admin-half">
			
			<input type="text" value="<?php echo $ultimatemember->query->get_meta_value('_um_bgcolor', null, 'na'); ?>" class="um-admin-colorpicker" name="_um_bgcolor" id="_um_bgcolor" />

		</span>
	</p><div class="um-admin-clear"></div>
	
	<p>
		<label class="um-admin-half"><?php _e('Notice text color','um-notices'); ?></label>
		<span class="um-admin-half">
			
			<input type="text" value="<?php echo $ultimatemember->query->get_meta_value('_um_textcolor', null, 'na'); ?>" class="um-admin-colorpicker" name="_um_textcolor" id="_um_textcolor" />

		</span>
	</p><div class="um-admin-clear"></div>
	
	<p>
		<label class="um-admin-half"><?php _e('Notice font size','um-notices'); ?></label>
		<span class="um-admin-half">
			
			<input type="text" name="_um_fontsize" id="_um_fontsize" value="<?php echo $ultimatemember->query->get_meta_value('_um_fontsize', null, 'na'); ?>" />
			
		</span>
	</p><div class="um-admin-clear"></div>
	
	<p>
		<label class="um-admin-half"><?php _e('Notice Icon','um-notices'); ?> <?php $metabox->tooltip( __('You can optionally add an icon to this notice','um-notices') ); ?></label>
		<span class="um-admin-half">

			<a href="#" class="button" data-modal="UM_fonticons" data-modal-size="normal" data-dynamic-content="um_admin_fonticon_selector" data-arg1="" data-arg2="" data-back=""><?php _e('Choose Icon','um-notices'); ?></a>

			<span class="um-admin-icon-value">
				<?php if ( get_post_meta( get_the_ID(), '_um_icon', true ) ) { ?>
				<i class="<?php echo get_post_meta( get_the_ID(), '_um_icon', true ); ?>"></i>
				<?php } else { ?>
				<?php _e('No Icon','um-notices'); ?>
				<?php } ?>
			</span>

			<input type="hidden" name="_um_icon" id="_um_icon" value="<?php echo ( get_post_meta( get_the_ID(), '_um_icon', true ) ) ? get_post_meta( get_the_ID(), '_um_icon', true ) : ''; ?>" />

			<?php if ( get_post_meta( get_the_ID(), '_um_icon', true ) ) { ?>
			<span class="um-admin-icon-clear show"><i class="um-icon-android-cancel"></i></span>
			<?php } else { ?>
			<span class="um-admin-icon-clear"><i class="um-icon-android-cancel"></i></span>
			<?php } ?>

		</span>
	</p><div class="um-admin-clear"></div>
	
	<p>
		<label class="um-admin-half"><?php _e('Notice Icon color','um-notices'); ?></label>
		<span class="um-admin-half">
			
			<input type="text" value="<?php echo $ultimatemember->query->get_meta_value('_um_iconcolor', null, 'na'); ?>" class="um-admin-colorpicker" name="_um_iconcolor" id="_um_iconcolor" />

		</span>
	</p><div class="um-admin-clear"></div>
	
	<p>
		<label class="um-admin-half"><?php _e('Notice Close Icon color','um-notices'); ?></label>
		<span class="um-admin-half">
			
			<input type="text" value="<?php echo $ultimatemember->query->get_meta_value('_um_closeiconcolor', null, 'na'); ?>" class="um-admin-colorpicker" name="_um_closeiconcolor" id="_um_closeiconcolor" />

		</span>
	</p><div class="um-admin-clear"></div>
	
	<p>
		<label class="um-admin-half"><?php _e('Border','um-notices'); ?> <?php $metabox->tooltip( __('Enter border css here','um-notices') ); ?></label>
		<span class="um-admin-half">
			
			<input type="text" name="_um_border" id="_um_border" value="<?php echo $ultimatemember->query->get_meta_value('_um_border', null, 'na'); ?>" />
			
		</span>
	</p><div class="um-admin-clear"></div>
	
	<p>
		<label class="um-admin-half"><?php _e('Border Radius','um-notices'); ?> <?php $metabox->tooltip( __('Enter border radius here. e.g. 3px','um-notices') ); ?></label>
		<span class="um-admin-half">
			
			<input type="text" name="_um_border_radius" id="_um_border_radius" value="<?php echo $ultimatemember->query->get_meta_value('_um_border_radius', null, 'na'); ?>" />
			
		</span>
	</p><div class="um-admin-clear"></div>
	
	<p>
		<label class="um-admin-half"><?php _e('Box Shadow','um-notices'); ?> <?php $metabox->tooltip( __('Change this If you want to apply a box-shadow to the notice box','um-notices') ); ?></label>
		<span class="um-admin-half">
			
			<input type="text" name="_um_boxshadow" id="_um_boxshadow" value="<?php echo $ultimatemember->query->get_meta_value('_um_boxshadow', null, 'na'); ?>" />
			
		</span>
	</p><div class="um-admin-clear"></div>

</div>