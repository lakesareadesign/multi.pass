<?php

class UM_Notifications_Shortcode {

	function __construct() {
	
		add_shortcode('ultimatemember_notifications', array(&$this, 'ultimatemember_notifications'), 1);
		add_shortcode('ultimatemember_notification_count', array(&$this, 'ultimatemember_notification_count'), 1);
		
		add_filter( 'wp_title', array(&$this,'wp_title'), 10, 2 );
		
	}
	
	/***
	***	@custom title for page
	***/
	function wp_title( $title, $sep=null ) {
		global $um_notifications, $ultimatemember, $post;
		if ( isset( $post->ID ) && $post->ID == $ultimatemember->permalinks->core['notifications'] ) {
			$unread = $um_notifications->api->get_notifications( 0, 'unread', true );
			if ( $unread ){
				$title = "($unread) $title";
			}
		}
		return $title;
	}

	/***
	***	@Shortcode
	***/
	function ultimatemember_notifications( $args = array() ) {
		global $ultimatemember, $um_notifications;
		
		if ( !is_user_logged_in() )
			exit( wp_redirect( home_url() ) );

		$has_notifications = $um_notifications->api->get_notifications( 1 );
		if ( !$has_notifications ) {

			$template = 'no-notifications';
		
		} else {
			
			$notifications = $um_notifications->api->get_notifications( 50 );
			$template = 'notifications';
		
		}
		
		ob_start();
		
		echo '<div class="um-notification-shortcode">';

		include_once um_notifications_path . 'templates/'. $template . '.php';
		
		echo '</div>';

		$output = ob_get_contents();
		ob_end_clean();
		return $output;
	}
	
	/***
	***	@Shortcode
	***/
	function ultimatemember_notification_count( $args = array() ) {
		global $ultimatemember, $um_notifications;
		$count = $um_notifications->api->unread_count( get_current_user_id() );
		return (int)$count;
	}

}