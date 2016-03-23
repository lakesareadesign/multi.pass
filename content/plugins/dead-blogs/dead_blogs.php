<?php
/*
Plugin Name: Dead Blogs
Plugin URI: http://www.columbia.edu
Description: A plugin for managing "dead" blogs.
Version: 1.0.5
Author: Geoffrey Schwartz
Author URI: http://www.geoffreyalanschwartz.com/
License: GPL2

    Copyright 2012  Geofffrey Schwartz  (email : laughingbovine@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

//error_reporting(E_ALL);
//ini_set("display_errors", 1);

//define('DEAD_BLOGS_PLUGIN_DIRECTORY', ABSPATH.'wp-content/plugins/cu-dead-blogs/');

add_action('network_admin_menu', 'dead_blogs_register_pages');

add_action('admin_init', 'dead_blogs_input');

function dead_blogs_register_pages ()
{
    add_submenu_page('sites.php', 'Manage Dead Blogs', 'Dead', 'manage_sites', 'dead-blogs', 'dead_blogs_output');
}

function dead_blogs_input ()
{
    global $dead_blogs_current_page;

    // make sure we're on one of our pages
    if (!preg_match('|/wp-admin/network/sites.php\?.*page=dead-blogs|', $_SERVER['REQUEST_URI']))
        return;

    // only works for multisite installs
    if (!is_multisite())
        wp_die(__('Must be used on a multisite install.'));

    // only for network admins
    if (!current_user_can('manage_sites'))
        wp_die(__('You do not have sufficient permissions to access this page.'));

    // determine mode
    if (!isset($_REQUEST['mode']))
        $dead_blogs_current_page = 'main';
    else
        $dead_blogs_current_page = $_REQUEST['mode'];

    // call appropriate input function
    if ($dead_blogs_current_page == 'main')
    {
        require_once('dead_blogs_interface_main.php');
        dead_blogs_interface_main_input();
    }
    elseif ($dead_blogs_current_page == 'mail')
    {
        require_once('dead_blogs_interface_mail.php');
        dead_blogs_interface_mail_input();
    }
}

function dead_blogs_output ()
{
    global $dead_blogs_current_page;

    // only works for multisite installs
    if (!is_multisite())
        wp_die(__('Must be used on a multisite install.'));

    // only for network admins
    if (!current_user_can('manage_sites'))
        wp_die(__('You do not have sufficient permissions to access this page.'));

    // call appropriate output function
    if ($dead_blogs_current_page == 'main')
    {
        require_once('dead_blogs_interface_main.php');
        dead_blogs_interface_main_output();
    }
    elseif ($dead_blogs_current_page == 'mail')
    {
        require_once('dead_blogs_interface_mail.php');
        dead_blogs_interface_mail_output();
    }
}

?>
