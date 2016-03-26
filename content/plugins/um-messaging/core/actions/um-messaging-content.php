<?php

	/***
	***	@footer css
	***/
	add_action('wp_footer', 'um_messaging_wp_footer_styles', 99999999999999);
	function um_messaging_wp_footer_styles() {
		global $um_messaging;
	?>
		<style type="text/css">
		
		<?php
		
		$color_hex = um_get_option('pm_active_color');
		$color_rgb = $um_messaging->api->hex_to_rgb( $color_hex );
		
		?>
		
		.um-message-item-content a {color: <?php echo $color_hex; ?>; text-decoration: underline !important}
		.um-message-item-content a:hover {color: rgba(<?php echo $color_rgb; ?>, 0.9)}
		
		.um-message-item.left_m .um-message-item-content a {color: #fff}

		.um-message-send, .um-message-send.disabled:hover { background-color: <?php echo $color_hex; ?> }
		.um-message-send:hover { background-color: rgba(<?php echo $color_rgb; ?>, 0.9) }

		.um-message-item.left_m .um-message-item-content { background-color: rgba(<?php echo $color_rgb; ?>, 0.8);}

		.um-message-footer {
			background: rgba(<?php echo $color_rgb; ?>, 0.03);
			border-top: 1px solid rgba(<?php echo $color_rgb; ?>, 0.2);
		}
		
		.um-message-textarea textarea, div.um div.um-form .um-message-textarea textarea {border: 2px solid rgba(<?php echo $color_rgb; ?>, 0.3) !important}
		.um-message-textarea textarea:focus,  div.um div.um-form .um-message-textarea textarea:focus {border: 2px solid rgba(<?php echo $color_rgb; ?>, 0.6) !important}
		
		.um-message-emolist {
			border: 1px solid rgba(<?php echo $color_rgb; ?>, 0.25);
		}
		
		.um-message-conv-item.active {
			color: <?php echo $color_hex; ?>;
		}
		
		.um-message-conv-view {
			border-left: 1px solid rgba(<?php echo $color_rgb; ?>, 0.2);
		}

		</style>
		
		<?php
	}
	
	/***
	***	@default tab
	***/
	add_action('um_profile_content_messages_default', 'um_profile_content_messages_default');
	function um_profile_content_messages_default( $args ) {
		echo do_shortcode('[ultimatemember_messages]');
	}
	
	/***
	***	@show online/offline status
	***/
	add_action('um_messaging_conversation_list_name', 'um_messaging_show_online_dot');
	function um_messaging_show_online_dot() {
		if ( !class_exists('UM_Online_API'))return;
		global $um_online;
		
		if ( $um_online->is_online( um_user('ID') ) ) {
			echo '<span class="um-online-status online"><i class="um-faicon-circle"></i></span>';
		} else {
			echo '<span class="um-online-status offline"><i class="um-faicon-circle"></i></span>';
		}
	}