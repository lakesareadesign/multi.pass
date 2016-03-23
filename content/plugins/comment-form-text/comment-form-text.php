<?php
/*
Plugin Name: Comment Form Text
Plugin URI: http://premium.wpmudev.org/project/comment-form-text
Description: Easily add and manage text, or advertisements, or social elements (i.e. 'Share This' buttons) in the comment form area of every blog
Author: Ivan Shaovchev & Andrew Billits (Incsub)
Version: 1.0.2
Network: true
WDP ID: 11
*/

/*
Copyright 2007-2011 Incsub (http://incsub.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License (Version 2 - GPLv2) as published by
the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

//------------------------------------------------------------------------//
//---Hook-----------------------------------------------------------------//
//------------------------------------------------------------------------//

//------------------------------------------------------------------------//
//---Functions------------------------------------------------------------//
//------------------------------------------------------------------------//

function comment_form_text_output(){
    /* User logged in */
	if ( is_user_logged_in() ) {
	?>

        <!-- Content Goes Here --->

    <?php
	}
    /* User not logged in */
    else {
	?>

        <!-- Content Goes Here --->

    <?php
	}
}

//------------------------------------------------------------------------//
//---Output Functions-----------------------------------------------------//
//------------------------------------------------------------------------//

//------------------------------------------------------------------------//
//---Page Output Functions------------------------------------------------//
//------------------------------------------------------------------------//

//------------------------------------------------------------------------//
//---Support Functions----------------------------------------------------//
//------------------------------------------------------------------------//

/* Update Notifications Notice */
if ( !function_exists( 'wdp_un_check' ) ):
function wdp_un_check() {
    if ( !class_exists('WPMUDEV_Update_Notifications') && current_user_can('edit_users') )
        echo '<div class="error fade"><p>' . __('Please install the latest version of <a href="http://premium.wpmudev.org/project/update-notifications/" title="Download Now &raquo;">our free Update Notifications plugin</a> which helps you stay up-to-date with the most stable, secure versions of WPMU DEV themes and plugins. <a href="http://premium.wpmudev.org/wpmu-dev/update-notifications-plugin-information/">More information &raquo;</a>', 'wpmudev') . '</a></p></div>';	     	  									
}
add_action( 'admin_notices', 'wdp_un_check', 5 );
add_action( 'network_admin_notices', 'wdp_un_check', 5 );
endif;

?>