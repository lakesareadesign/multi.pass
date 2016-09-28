<?php
// ADD SETTINGS TO PLUGIN PAGE
add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'flatty_action_links' );

function flatty_action_links( $links ) {
   $links[] = '<a href="'. esc_url( get_admin_url(null, 'admin.php?page=flatty_-_ui_admin_theme') ) .'"><i class="fa fa-wrench"></i> Settings</a>';
   return $links;
}
?>
