<?php
	
	/***
	***	@creates options in Role page
	***/
	add_action('um_admin_custom_role_metaboxes', 'um_messaging_add_role_metabox');
	function um_messaging_add_role_metabox( $action ){
		global $ultimatemember;
		
		$metabox = new UM_Admin_Metabox();
		$metabox->is_loaded = true;

		add_meta_box("um-admin-form-messaging{" . um_messaging_path . "}", __('Private Messages','um-messaging'), array(&$metabox, 'load_metabox_role'), 'um_role', 'normal', 'low');
		
	}
	
	/***
	***	@admin options in directory
	***/
	add_action('um_admin_extend_directory_options_general', 'um_messaging_admin_directory', 100 );
	function um_messaging_admin_directory( $metabox ) {
		global $ultimatemember;
		?>
			
		<p>
			<label class="um-admin-half"><?php _e('Show message button in directory?','um-profile-completeness'); ?></label>
			<span class="um-admin-half">
			
				<?php $metabox->ui_on_off('_um_show_pm_button', 1 ); ?>
				
			</span>
		</p><div class="um-admin-clear"></div>
		
		<?php
		
	}