<?php
/*
 * ALTER
 * @author   AcmeeDesign
 * @url     http://acmeedesign.com
*/

defined('ABSPATH') || die;

if (!class_exists('ALTERADMINBAR')) {

    class ALTERADMINBAR extends ALTER
    {
        
        public $aof_options;
                
        function __construct() 
        {
            $this->aof_options = parent::alter_get_option_data(ALTER_OPTIONS_SLUG);
            add_action('admin_menu', array($this, 'add_adminbar_menu'));
            add_action( 'admin_bar_menu', array($this, 'alter_save_adminbar_nodes'), 999 );
        }
        
        function add_adminbar_menu() {
            add_submenu_page( 'alter-options', __('Manage Adminbar', 'alter'), __('Manage Adminbar', 'alter'), 'manage_options', 'alter_manage_adminbar', array($this, 'alter_manage_adminbar_page') );
        }
        
        function alter_manage_adminbar_page() {
            ?>
        <div class="wrap alter-wrap">
            <h2><?php _e('Manage Adminbar Elements', 'alter'); ?></h2>
            <?php
            global $wp_admin_bar; 
            //echo '<pre>'; print_r($wp_admin_bar); echo '</pre>';
            if ( !is_object( $wp_admin_bar ) )
                return;

            ?>
        </div>
<?php
        }
        
        function alter_save_adminbar_nodes() 
        {
            global $wp_admin_bar;   
            if ( !is_object( $wp_admin_bar ) )
                return;

            // Clean the AdminBar
            $nodes = $wp_admin_bar->get_nodes();
            $adminbar_nodes = array();
            //echo '<pre>'; print_r($nodes); echo '</pre>';
            foreach( $nodes as $node )
            {
                //echo $node->id . "<br />";
                // 'top-secondary' is used for the User Actions right side menu
                if( !$node->parent || 'top-secondary' == $node->parent )
                {
                   // $wp_admin_bar->remove_menu( $node->id );
                    $adminbar_nodes[] = $node->id ;
                }           
            }
            // end Clean
        }
    
    }
    
}

new ALTERADMINBAR();