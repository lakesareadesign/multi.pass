<?php

	/***
	***	@Customize filter query
	***/
	add_filter('um_prepare_user_query_args', 'um_profile_completeness_search_filter', 120, 2);
	function um_profile_completeness_search_filter( $query_args, $args ) {
		global $ultimatemember;
		extract( $args );
		
		if ( isset( $has_completed_profile ) && $has_completed_profile == 1 && isset( $has_completed_profile_pct ) && $has_completed_profile_pct > 0 ) {
			$query_args['meta_query'][] = array(
				'key' => '_completed',
				'value' => $has_completed_profile_pct,
				'compare' => '>='
			);
		}
		
		return $query_args;
		
	}
	
	/***
	***	@Admin options for directory filtering
	***/
	add_action('um_admin_extend_directory_options_general', 'um_profile_completeness_admin_directory');
	function um_profile_completeness_admin_directory( $metabox ) {
		global $ultimatemember;
		?>
			
		<p>
			<label class="um-admin-half"><?php _e('Only show members who have completed their profile','um-profile-completeness'); ?></label>
			<span class="um-admin-half">
			
				<?php $metabox->ui_on_off('_um_has_completed_profile', 1, true, 1, 'completeness-percent', 'xxx'); ?>
				
			</span>
		</p><div class="um-admin-clear"></div>
		
		<p class="completeness-percent">
			<label class="um-admin-half"><?php _e('Required completeness (%)','um-profile-completeness'); ?></label>
			<span class="um-admin-half">
				
				<input type="text" name="_um_has_completed_profile_pct" id="_um_has_completed_profile_pct" value="<?php echo $ultimatemember->query->get_meta_value('_um_has_completed_profile_pct', null, 'na' ); ?>" />
				
			</span>
		</p><div class="um-admin-clear"></div>
		
		<?php
		
	}