<?php
/*
if (get_option('flatty_subscribe_notice') == false) {
	function signNewsletter() { ?>
		
		<div class="notice notice-info is-dismissible flatty-subscribe">
			<p><?php _e('Don\'t forget to subscribe to <strong>Flatty\'s</strong> updates newsletter!', 'flatty'); ?></p>
		</div>
		
	<?php }
	add_action('admin_notices', 'signNewsletter');
};
*/

require_once( dirname( __FILE__ ) . '/options/meta.php' );
require_once( dirname( __FILE__ ) . '/options/login.php' );
require_once( dirname( __FILE__ ) . '/options/dashboard.php' );
require_once( dirname( __FILE__ ) . '/options/appearance.php' );
require_once( dirname( __FILE__ ) . '/options/business_card.php' );
require_once( dirname( __FILE__ ) . '/options/postspages.php' );

?>
