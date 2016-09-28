<?php
/*///////////////////////////////////////////////////////////////////////////WORDPRESS META*/
if (get_option('flatty_wordpress_remove_generator') == true) {
		function flatty_wordpress_disable_version() {
		   return '';
		}
		add_filter('the_generator','flatty_wordpress_disable_version');

		remove_action('wp_head', 'wp_generator');
}

?>
