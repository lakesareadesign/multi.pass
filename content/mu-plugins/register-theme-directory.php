<?php
/*
Plugin Name: Default theme directory redirect
Plugin URI: http://www.lakesareadesign.com
Description: Points the default WP themes back to the CMS folder.
Version: 1.0
Author: Lakes Area Design
*/

register_theme_directory( ABSPATH . 'wp-content/themes/' );
// Creating additional theme directories
register_theme_directory( ABSPATH . '../content/themes_custom' );
register_theme_directory( ABSPATH . '../content/themes_genesis' );
register_theme_directory( ABSPATH . '../content/themes_woothemes' );

?>