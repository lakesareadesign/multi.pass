<?php

class UM_Messaging_Shortcode {

	function __construct() {
	
		add_shortcode('ultimatemember_messages', array(&$this, 'ultimatemember_messages'), 1);
		add_shortcode('ultimatemember_message_button', array(&$this, 'ultimatemember_message_button'), 1);
		add_shortcode('ultimatemember_message_count', array(&$this, 'ultimatemember_message_count'), 1);
		
	}
	
	/***
	***	@shortcode
	***/
	function ultimatemember_message_count( $args = array() ) {
		global $ultimatemember, $um_messaging;
		
		$defaults = array(
			'user_id' => get_current_user_id()
		);
		$args = wp_parse_args( $args, $defaults );
		extract( $args );
		
		if ( is_user_logged_in() ) {
			$count = $um_messaging->api->get_unread_count( $user_id );
			return (int)$count;
		}
	}
	
	/***
	***	@shortcode
	***/
	function ultimatemember_message_button( $args = array() ) {
		global $ultimatemember, $um_messaging;
		
		$defaults = array(
			'user_id' => 0
		);
		$args = wp_parse_args( $args, $defaults );
		extract( $args );
		
		if ( !is_user_logged_in() ) {
			$redirect = um_get_core_page('register');
			$redirect = add_query_arg('redirect_to', $ultimatemember->permalinks->get_current_url(), $redirect );
			$btn = '<a href="' . $redirect . '" class="um-login-to-msg-btn um-message-btn um-button" data-message_to="'.$user_id.'">'. __('Message','um-messaging'). '</a>';
			return $btn;
		} else if ( $user_id != get_current_user_id() ) {
		
			if ( $um_messaging->api->can_message( $user_id ) ) {
				$btn = '<a href="#" class="um-message-btn um-button" data-message_to="'.$user_id.'"><span>'. __('Message','um-messaging'). '</span></a>';
				return $btn;
			}
			
		}
	}
	
	/***
	***	@shortcode
	***/
	function ultimatemember_messages( $args = array() ) {
		global $ultimatemember, $um_messaging;

		$defaults = array(
			'user_id' => get_current_user_id()
		);
		$args = wp_parse_args( $args, $defaults );
		extract( $args );

		ob_start();
		
		$conversations = $um_messaging->api->get_conversations( $user_id );

		if ( isset( $_GET['conversation_id'] ) ) {
			if ( esc_attr( absint( $_GET['conversation_id'] ) ) ) {
				foreach( $conversations as $conversation ) {
					if ( $conversation->conversation_id == $_GET['conversation_id'] )
						$current_conversation = esc_attr( absint( $_GET['conversation_id'] ) );
						continue;
				}
			}
		}

		include_once um_messaging_path . 'templates/conversations.php';
		
		$output = ob_get_contents();
		ob_end_clean();
		return $output;
	}

}