<?php
/**
 * @Package: WordPress Plugin
 * @Subpackage: Ultra WordPress Admin Theme
 * @Since: Ultra 1.0
 * @WordPress Version: 4.0 or above
 * This file is part of Ultra WordPress Admin Theme Plugin.
 */
?>
<?php

function ultra_admintopbar(){
    global $ultraadmin;
       $ultraadmin = ultraadmin_network($ultraadmin);       

    if(isset($ultraadmin['enable-topbar']) && $ultraadmin['enable-topbar'] != "1" && $ultraadmin['enable-topbar'] == "0" && !$ultraadmin['enable-topbar']){
        echo "<style type='text/css'>#wpadminbar{display: none !important;} html.wp-toolbar{padding-top:0px !important;} </style>";
    }
}



function ultra_wptopbar(){
    global $ultraadmin;
       $ultraadmin = ultraadmin_network($ultraadmin);       

    if(isset($ultraadmin['enable-topbar-wp']) && $ultraadmin['enable-topbar-wp'] != "1" && $ultraadmin['enable-topbar-wp'] == "0" && !$ultraadmin['enable-topbar-wp']){
        remove_action('wp_footer', 'wp_admin_bar_render', 9);
        add_filter('show_admin_bar', '__return_false');
    }

}



function ultra_admintopbar_style(){
    global $ultraadmin;
       $ultraadmin = ultraadmin_network($ultraadmin);       

       $logomargintop = "-40px";

    if(isset($ultraadmin['enable-topbar']) && $ultraadmin['enable-topbar'] != "1" && $ultraadmin['enable-topbar'] == "0" && !$ultraadmin['enable-topbar']){
        $logomargintop = "0px";
    }



    if(isset($ultraadmin['topbar-style']) && $ultraadmin['topbar-style'] != "style1"){
        return " #adminmenuback{z-index: 99998 !important;} 
        #adminmenuwrap{margin-top: ".$logomargintop." !important;z-index: 99999 !important;} 
        .folded #wpadminbar{padding-left: 46px !important;} 
        #wpadminbar{padding-left: 230px !important;z-index: 9999 !important;}
        .menu-hidden #wpadminbar{padding-left: 0px !important;}         
        .menu-expanded #wpadminbar{padding-left: 230px !important;}         
        .menu-collapsed #wpadminbar{padding-left: 46px !important;} 
        
        .rtl #adminmenuback{z-index: 99998 !important;} 
        .rtl #adminmenuwrap{margin-top: ".$logomargintop." !important;z-index: 99999 !important;} 
        .rtl.folded #wpadminbar{padding-right: 46px !important;padding-left: 0px!important;} 
        .rtl #wpadminbar{padding-right: 230px !important;padding-left: 0px !important;z-index: 9999 !important;}
        .rtl.menu-hidden #wpadminbar{padding-left: 0px !important;padding-right: 0px !important;}         
        .rtl.menu-expanded #wpadminbar{padding-right: 230px !important;padding-left: 0px !important;}         
        .rtl.menu-collapsed #wpadminbar{padding-right: 46px !important;padding-left: 0px !important;}
        ";
    }
}



function ultra_admintopbar_links(){
        global $ultraadmin;
       $ultraadmin = ultraadmin_network($ultraadmin);       

        //print_r($ultraadmin);
          
        $str = "";

        $element = 'enable-topbar-links-wp';
        if(isset($ultraadmin[$element]) && $ultraadmin[$element] != "1" && $ultraadmin[$element] == "0" && !$ultraadmin[$element]){
            $str .= "#wp-admin-bar-wp-logo{display:none;}";
        }
        
        $element = 'enable-topbar-links-site';
        if(isset($ultraadmin[$element]) && $ultraadmin[$element] != "1" && $ultraadmin[$element] == "0" && !$ultraadmin[$element]){
            $str .= "#wp-admin-bar-site-name{display:none;}";
        }

        $element = 'enable-topbar-links-comments';
        if(isset($ultraadmin[$element]) && $ultraadmin[$element] != "1" && $ultraadmin[$element] == "0" && !$ultraadmin[$element]){
            $str .= "#wp-admin-bar-comments{display:none;}";
        }

        $element = 'enable-topbar-links-new';
        if(isset($ultraadmin[$element]) && $ultraadmin[$element] != "1" && $ultraadmin[$element] == "0" && !$ultraadmin[$element]){
            $str .= "#wp-admin-bar-new-content{display:none;}";
        }

        $element = 'enable-topbar-links-ultraadmin';
        if(isset($ultraadmin[$element]) && $ultraadmin[$element] != "1" && $ultraadmin[$element] == "0" && !$ultraadmin[$element]){
            $str .= "#wp-admin-bar-_ultraoptions{display:none;}";
        }

        $element = 'enable-topbar-myaccount';
        if(isset($ultraadmin[$element]) && $ultraadmin[$element] != "1" && $ultraadmin[$element] == "0" && !$ultraadmin[$element]){
            $str .= "#wp-admin-bar-my-account{display:none;}";
        }

       echo "<style type='text/css'>".$str."</style>";
}





function ultra_topbar_logout_link() {
       global $ultraadmin;
       $ultraadmin = ultraadmin_network($ultraadmin);       

       $element = 'enable-topbar-directlogout';
       
       if(isset($ultraadmin[$element]) && trim($ultraadmin[$element]) != ""){
   
            if($ultraadmin[$element] == "1"){

                global $wp_admin_bar;
                $wp_admin_bar->add_menu( array(
                    'id'    => 'wp-custom-logout',
                    'title' => 'Logout',
                    'parent'=> 'top-secondary',
                    'href'  => wp_logout_url()
                ) );

       }
   }

}



function ultra_topbar_menuids(){

    global $wp_admin_bar;
    global $ultraadmin;
       $ultraadmin = ultraadmin_network($ultraadmin);       

        $element = 'enable-topbar-links-wp';
        if(isset($ultraadmin[$element]) && $ultraadmin[$element] != "1" && $ultraadmin[$element] == "0" && !$ultraadmin[$element]){
            $wp_admin_bar->remove_menu('wp-logo');
        }

        $element = 'enable-topbar-links-site';
        if(isset($ultraadmin[$element]) && $ultraadmin[$element] != "1" && $ultraadmin[$element] == "0" && !$ultraadmin[$element]){
            $wp_admin_bar->remove_menu('site-name');            
        }

        $element = 'enable-topbar-links-comments';
        if(isset($ultraadmin[$element]) && $ultraadmin[$element] != "1" && $ultraadmin[$element] == "0" && !$ultraadmin[$element]){
            $wp_admin_bar->remove_menu('comments');
        }

        $element = 'enable-topbar-links-new';
        if(isset($ultraadmin[$element]) && $ultraadmin[$element] != "1" && $ultraadmin[$element] == "0" && !$ultraadmin[$element]){
            $wp_admin_bar->remove_menu('new-content');
        }

        $element = 'enable-topbar-links-ultraadmin';
        if(isset($ultraadmin[$element]) && $ultraadmin[$element] != "1" && $ultraadmin[$element] == "0" && !$ultraadmin[$element]){
            $wp_admin_bar->remove_menu('_ultraoptions');
        }

        $element = 'enable-topbar-myaccount';
        if(isset($ultraadmin[$element]) && $ultraadmin[$element] != "1" && $ultraadmin[$element] == "0" && !$ultraadmin[$element]){
            $wp_admin_bar->remove_menu('my-account');
        }


        $element = 'topbar-removeids';
        if(isset($ultraadmin[$element]) && trim($ultraadmin[$element]) != ""){
            $exp = explode(",",$ultraadmin[$element]);
            $exp = array_unique(array_filter($exp));

            foreach($exp as $nodeid){
                if(trim($nodeid) != ""){
                    $wp_admin_bar->remove_menu($nodeid);
                }
            }
        }


}





function ultra_topbar_account_menu( $wp_admin_bar ) {

    global $ultraadmin;
       $ultraadmin = ultraadmin_network($ultraadmin);       
        $greet = 'Howdy';

        $element = 'myaccount_greet';
        if(isset($ultraadmin[$element]) && trim($ultraadmin[$element]) != "Howdy"){

            $greet = $ultraadmin[$element];
            if($greet != ""){ $greet .= ', '; }

            $user_id = get_current_user_id();
            $current_user = wp_get_current_user();
            $profile_url = get_edit_profile_url( $user_id );

            if ( 0 != $user_id ) {
            
                /* Add the "My Account" menu */
                $avatar = get_avatar( $user_id, 28 );
                $howdy = $greet.''.sprintf( __('%1$s'), $current_user->display_name );
                $class = empty( $avatar ) ? '' : 'with-avatar';

                $wp_admin_bar->add_menu( array(
                'id' => 'my-account',
                'parent' => 'top-secondary',
                'title' => $howdy . $avatar,
                'href' => $profile_url,
                'meta' => array(
                'class' => $class,
                ),
                ) );

            }
        }
}
?>