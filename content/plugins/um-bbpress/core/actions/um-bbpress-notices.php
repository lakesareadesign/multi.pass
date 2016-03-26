<?php
	
	/***
	***	@If user can not post
	***/
	add_action('bbp_template_before_forums_loop', 'um_bbpress_cant_post_notice', 99);
	add_action('bbp_template_before_topics_loop', 'um_bbpress_cant_post_notice', 99);
	function um_bbpress_cant_post_notice() {
		global $ultimatemember, $um_bbpress;
		
		$user_id = get_current_user_id();

		if( !$user_id ) return;

		$role = get_user_meta( $user_id, 'role', true );
		
		$role_data = $ultimatemember->query->role_data( $role ); 
			
		if ( !$um_bbpress->can_do_topic() ) {  ?>

			<div class="um-clear"></div>
			<div class="um-bbpress-warning"><?php echo $role_data['lock_notice']; ?></div>

		<?php } else if ( !um_user_can('can_create_topics') ) { ?>

			<div class="um-clear"></div>
			<div class="um-bbpress-warning"><?php echo $role_data['lock_notice2']; ?></div>

		<?php
		}
		
	}