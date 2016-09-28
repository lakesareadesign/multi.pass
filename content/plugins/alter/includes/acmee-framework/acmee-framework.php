<?php
/*
Plugin Name: Acmee Options Framework
Plugin URI: http://acmeedesign.com
Description: Options framework for Wordpress themes and plugins.
version: 1.0
Author: KannanC
Author URI: http://acmeedesign.com
 */

/*
* AOF Constants
*/
define( 'AOF_VERSION' , '1.0' );    
define( 'AOF_PATH' , dirname(__FILE__) . "/"); 
define( 'AOF_DIR_URI' , plugin_dir_url(__FILE__) );

require_once (AOF_PATH . 'inc/envato.api.class.php' );
require_once ( AOF_PATH . 'inc/aof.gfonts.class.php' );
require_once ( AOF_PATH . 'inc/aof.class.php' );

