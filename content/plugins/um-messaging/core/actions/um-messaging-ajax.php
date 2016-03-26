<?php

	/***
	***	@unblock a user
	***/
	add_action('wp_ajax_nopriv_um_messaging_unblock_user', 'um_messaging_unblock_user');
	add_action('wp_ajax_um_messaging_unblock_user', 'um_messaging_unblock_user');
	function um_messaging_unblock_user(){
		global $ultimatemember, $um_messaging, $wpdb;
		$output = '';
		if ( !isset( $_POST['user_id'] ) || !is_numeric( $_POST['user_id'] ) || !is_user_logged_in() ) die();

		$blocked = (array) get_user_meta( get_current_user_id(), '_pm_blocked', true );
		if ( !in_array( $_POST['user_id'] , $blocked ) ) die();
		
		$blocked = array_diff($blocked, array( $_POST['user_id'] ) );
		update_user_meta( get_current_user_id(), '_pm_blocked', $blocked );
		
		$output['success'] = 1;
		$output=json_encode($output);
		if(is_array($output)){print_r($output);}else{echo $output;}die;
	}

	/***
	***	@block a user
	***/
	add_action('wp_ajax_nopriv_um_messaging_block_user', 'um_messaging_block_user');
	add_action('wp_ajax_um_messaging_block_user', 'um_messaging_block_user');
	function um_messaging_block_user(){
		global $ultimatemember, $um_messaging, $wpdb;
		$output = '';
		if ( !isset( $_POST['other_user'] ) || !is_numeric( $_POST['other_user'] ) || !is_user_logged_in() ) die();

		$blocked = (array) get_user_meta( get_current_user_id(), '_pm_blocked', true );
		$blocked[] = $_POST['other_user'];
		update_user_meta( get_current_user_id(), '_pm_blocked', $blocked );
		
		$output['success'] = 1;
		$output=json_encode($output);
		if(is_array($output)){print_r($output);}else{echo $output;}die;
	}
	
	/***
	***	@delete a conversation
	***/
	add_action('wp_ajax_nopriv_um_messaging_delete_conversation', 'um_messaging_delete_conversation');
	add_action('wp_ajax_um_messaging_delete_conversation', 'um_messaging_delete_conversation');
	function um_messaging_delete_conversation(){
		global $ultimatemember, $um_messaging, $wpdb;
		$output = '';

		if ( !isset( $_POST['conversation_id'] ) || !is_numeric( $_POST['conversation_id'] ) || !is_user_logged_in() ) die();
		if ( !isset( $_POST['other_user'] ) || !is_numeric( $_POST['other_user'] ) || !is_user_logged_in() ) die();

		$table = $wpdb->prefix . "um_conversations";
		$current_user = get_current_user_id();
		$other_user = sanitize_text_field( $_POST['other_user'] );
		$conversation = $wpdb->get_results("SELECT conversation_id FROM {$table} WHERE ( user_a=$current_user AND user_b=$other_user ) OR ( user_b=$current_user && user_a=$other_user ) LIMIT 1");
		
		if ( !isset( $conversation[0]->conversation_id ) )
			die(0);
		
		
		$um_messaging->api->hide_conversation( get_current_user_id(), $conversation[0]->conversation_id ); 
		$output['success'] = 1;
		
		$output=json_encode($output);
		if(is_array($output)){print_r($output);}else{echo $output;}die;
	}
	
	/***
	***	@Remove a message
	***/
	add_action('wp_ajax_nopriv_um_messaging_remove', 'um_messaging_remove');
	add_action('wp_ajax_um_messaging_remove', 'um_messaging_remove');
	function um_messaging_remove(){
		global $ultimatemember, $um_messaging;
		$output = '';
		if ( !isset( $_POST['message_id'] ) || !is_numeric( $_POST['message_id'] ) || !is_user_logged_in() ) die();
		if ( !isset( $_POST['conversation_id'] ) || !is_numeric( $_POST['conversation_id'] ) || !is_user_logged_in() ) die();
		
		$um_messaging->api->remove_message( $_POST['message_id'], $_POST['conversation_id'] );
		
		$output=json_encode($output);
		if(is_array($output)){print_r($output);}else{echo $output;}die;
	}
	
	/***
	***	@Send a message
	***/
	add_action('wp_ajax_nopriv_um_messaging_send', 'um_messaging_send');
	add_action('wp_ajax_um_messaging_send', 'um_messaging_send');
	function um_messaging_send(){
		global $ultimatemember, $um_messaging;
		
		if ( !isset( $_POST['message_to'] ) || !is_numeric( $_POST['message_to'] ) || !is_user_logged_in() ) die();
		if ( !isset( $_POST['content'] ) || trim( $_POST['content'] ) == '' ) die();
		
		// Create conversation and add message
		$conversation_id = $um_messaging->api->create_conversation( $_POST['message_to'], get_current_user_id() );
		$output['messages'] = $um_messaging->api->get_conversation( $_POST['message_to'], get_current_user_id(), $conversation_id );
		
		if ( $um_messaging->api->limit_reached() ) {
			$output['limit_hit'] = 1;
		} else {
			$output['limit_hit'] = 0;
		}
		
		$output=json_encode($output);
		if(is_array($output)){print_r($output);}else{echo $output;}die;
	}
	
	/***
	***	@Login Modal
	***/
	add_action('wp_ajax_nopriv_um_messaging_login_modal', 'um_messaging_login_modal');
	add_action('wp_ajax_um_messaging_login_modal', 'um_messaging_login_modal');
	function um_messaging_login_modal(){
		global $ultimatemember, $um_messaging;
		
		if ( is_user_logged_in() ) die();
		
		$message_to = absint( $_POST['message_to'] );
		
		um_fetch_user( $message_to );
		
		ob_start(); ?>
		
		<div class="um-message-modal">
		
			<div class="um-message-header um-popup-header">
				<div class="um-message-header-left"><?php printf(__('%s Please login to message <strong>%s</strong>','um-messaging'), get_avatar( $message_to, 40 ), um_user('display_name') ); ?></div>
				<div class="um-message-header-right">
					<a href="#" class="um-message-hide"><i class="um-icon-android-close"></i></a>
				</div>
			</div>
		
			<div class="um-message-body um-popup-autogrow2 um-message-autoheight">
			
				<?php echo do_shortcode( '[ultimatemember form_id=' . $ultimatemember->shortcodes->core_login_form() . ']' ); ?>
				
			</div>
			
		</div>
		
		<?php
		$output = ob_get_contents();
		ob_end_clean();
		die($output);
	}
	
	/***
	***	@Coming from send message button
	***/
	add_action('wp_ajax_nopriv_um_messaging_start', 'um_messaging_start');
	add_action('wp_ajax_um_messaging_start', 'um_messaging_start');
	function um_messaging_start(){
		global $ultimatemember, $um_messaging;
		
		if ( !isset( $_POST['message_to'] ) || !is_numeric( $_POST['message_to'] ) || !is_user_logged_in() ) die();
		
		ob_start(); ?>
		
		<div class="um-message-modal">

			<?php $um_messaging->api->conversation_template( $_POST['message_to'], get_current_user_id() ); ?>
		
		</div>
		
		<?php
		$output = ob_get_contents();
		ob_end_clean();
		die($output);
	}
	
	/***
	***	@auto refresh of chat messages
	***/
	add_action('wp_ajax_nopriv_um_messaging_update', 'um_messaging_update');
	add_action('wp_ajax_um_messaging_update', 'um_messaging_update');
	function um_messaging_update(){
		global $ultimatemember, $um_messaging, $wpdb;
		
		if ( !isset( $_POST['message_to'] ) || !is_numeric( $_POST['message_to'] ) || !is_user_logged_in() ) die();
		
		$conversation_id = absint( $_POST['conversation_id'] );
		$table_name1 = $wpdb->prefix . "um_conversations";
		$table_name2 = $wpdb->prefix . "um_messages";
		$results = $wpdb->get_results("SELECT last_updated FROM {$table_name1} WHERE conversation_id=$conversation_id LIMIT 1");
		if ( !$results[0]->last_updated ) die;
		
		if ( $results[0]->last_updated > $_POST['last_updated'] ) {
			
			$lastu = $_POST['last_updated'];
			
			// get new messages
			$messages = $wpdb->get_results("SELECT * FROM {$table_name2} WHERE conversation_id=$conversation_id AND time > '{$lastu}' ORDER BY time ASC LIMIT 1");
			$response = null;
			foreach( $messages as $message ) {

				if ( $message->status == 0 ) {
					$status = 'unread';
				} else {
					$status = 'read';
				}
			
				if ( $message->author == get_current_user_id() ) {
					$class = 'right_m';
					$remove_msg = '<a href="#" class="um-message-item-remove um-message-item-show-on-hover um-tip-s" title="'. __('Remove','um-messaging').'"></a>';
				} else {
					$class = 'left_m';
					$remove_msg = '';
				}
				
				$response .= '<div class="um-message-item ' . $class . ' ' . $status . '" data-message_id="'.$message->message_id.'" data-conversation_id="'.$message->conversation_id.'">';

				$response .= '<div class="um-message-item-content">' . $um_messaging->api->chatize( $message->content ) . '</div><div class="um-clear"></div>';
				
				$response .= '<div class="um-message-item-metadata">' . $um_messaging->api->beautiful_time( $message->time, $class ) . '</div><div class="um-clear"></div>';
				
				$response .= $remove_msg;
				
				$response .= '</div><div class="um-clear"></div>';
				
				$output['message_id'] = $message->message_id;
				$output['last_updated'] = $message->time;
				$output['response'] = $response;

			}

		} else {
			
			//$output['response'] = 'nothing new';
			
		}

		$output=json_encode($output);
		if(is_array($output)){print_r($output);}else{echo $output;}die;
	}