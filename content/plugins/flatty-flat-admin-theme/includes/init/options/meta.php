<?php
/*///////////////////////////////////////////////////////////////////////////WORDPRESS META*/
if (get_option('flatty_wordpress_remove_generator') == true) {
		add_filter('the_generator','flatty_wordpress_disable_version');
		function flatty_wordpress_disable_version() {
		   return '';
		}
		remove_action('wp_head', 'wp_generator');
}
?>
