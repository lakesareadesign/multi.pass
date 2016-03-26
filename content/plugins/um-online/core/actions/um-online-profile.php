<?php

	/***
	***	@Show user online status beside name
	***/
	add_action('um_after_profile_name_inline', 'um_online_show_user_status');
	function um_online_show_user_status( $args ) {
		global $um_online;
		
		if ( $um_online->is_online( um_profile_id() ) ) {
			echo '<span class="um-online-status online um-tip-n" title="'.__('online','um-online').'"><i class="um-faicon-circle"></i></span>';
		}
	
	}