<?php

class UM_Notifications_Enqueue {

	function __construct() {
	
		add_action('wp_enqueue_scripts',  array(&$this, 'wp_enqueue_scripts'), 9999);
		add_action('wp_footer',  array(&$this, 'wp_footer'), 9999999999999);
		
	}

	function wp_footer() { 
	
		if ( !is_user_logged_in() ) return;
		
	?>
		
		<script type="text/javascript">
		jQuery(document).ready(function() {

			<?php if ( um_get_option('realtime_notify') == 1 ) { ?>
			setInterval( LoadNotifications, <?php echo 1000 * um_get_option('realtime_notify_timer'); ?> );
			<?php } ?>

		});
		</script>
	
	<?php }
	
	function wp_enqueue_scripts(){
		
		if ( !is_user_logged_in() ) return;

		wp_register_style('um_notifications', um_notifications_url . 'assets/css/um-notifications.css' );
		wp_enqueue_style('um_notifications');
		
		wp_register_script('um_notifications', um_notifications_url . 'assets/js/um-notifications.js', '', '', true );
		wp_enqueue_script('um_notifications');
		
	}
	
}