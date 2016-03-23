<?php

function dead_blogs_interface_main_input ()
{
    global $current_site, $dead_blogs_status_message, $dead_blogs_current_page;

    // Taken from /wp-admin/network/sites.php
    // handles all actions/bulk actions (like "delete blog(s)")
    // sets $dead_blogs_status_message, a status message
    ////////////////////////////////////////////////////////////////////////////////

    if ($_REQUEST['action'] == 'mail')
    {
        check_admin_referer('bulk-sites');
        $dead_blogs_current_page = 'mail';
        return;
    }

    $id = isset( $_REQUEST['id'] ) ? intval( $_REQUEST['id'] ) : 0;

    if ( isset( $_GET['action'] ) ) {
        do_action( 'wpmuadminedit' , '' );

        switch ( $_GET['action'] ) {
            case 'updateblog':
                // No longer used.
            break;

            case 'allblogs':
                if ( ( isset( $_POST['action'] ) || isset( $_POST['action2'] ) ) && isset( $_POST['allblogs'] ) ) {
                    check_admin_referer( 'bulk-sites' );

                    if ( ! current_user_can( 'manage_sites' ) )
                        wp_die( __( 'You do not have permission to access this page.' ) );

                    if ( $_GET['action'] != -1 || $_POST['action2'] != -1 )
                        $doaction = $_POST['action'] != -1 ? $_POST['action'] : $_POST['action2'];

                    $blogfunction = '';

                    ?>
                    <!--
                    <?php

                    echo wp_get_referer(), "\n\n";

                    foreach ( (array) $_POST['allblogs'] as $key => $val ) {
                        if ( $val != '0' && $val != $current_site->blog_id ) {
                            switch ( $doaction ) {
                                case 'delete':
                                    if ( ! current_user_can( 'delete_site', $val ) )
                                        wp_die( __( 'You are not allowed to delete the site.' ) );
                                    $blogfunction = 'all_delete';
                                    wpmu_delete_blog( $val, true );
                                break;

                                case 'spam':
                                    $blogfunction = 'all_spam';
                                    update_blog_status( $val, 'spam', '1' );
                                    set_time_limit( 60 );
                                break;

                                case 'notspam':
                                    $blogfunction = 'all_notspam';
                                    update_blog_status( $val, 'spam', '0' );
                                    set_time_limit( 60 );
                                break;
                            }
                        } else {
                            wp_die( __( 'You are not allowed to change the current site.' ) );
                        }
                    }
                    ?>
                    -->
                    <?php

                    wp_safe_redirect( add_query_arg( array( 'updated' => 'true', 'action' => $blogfunction ), wp_get_referer() ) );
                } else {
                    wp_redirect( network_admin_url( 'sites.php?page=dead-blogs' ) );
                }

                exit();
            break;

            case 'deleteblog':
                check_admin_referer('deleteblog');
                if ( ! ( current_user_can( 'manage_sites' ) && current_user_can( 'delete_sites' ) ) )
                    wp_die( __( 'You do not have permission to access this page.' ) );
                if ( $id != '0' && $id != $current_site->blog_id && current_user_can( 'delete_site', $id ) ) {
                    wpmu_delete_blog( $id, true );
                    wp_safe_redirect( add_query_arg( array( 'updated' => 'true', 'action' => 'delete' ), wp_get_referer() ) );
                } else {
                    wp_safe_redirect( add_query_arg( array( 'updated' => 'true', 'action' => 'not_deleted' ), wp_get_referer() ) );
                }
                exit();
            break;

            case 'archiveblog':
                check_admin_referer( 'archiveblog' );
                if ( ! current_user_can( 'manage_sites' ) )
                    wp_die( __( 'You do not have permission to access this page.' ) );

                update_blog_status( $id, 'archived', '1' );
                wp_safe_redirect( add_query_arg( array( 'updated' => 'true', 'action' => 'archive' ), wp_get_referer() ) );
                exit();
            break;

            case 'unarchiveblog':
                check_admin_referer( 'unarchiveblog' );
                if ( ! current_user_can( 'manage_sites' ) )
                    wp_die( __( 'You do not have permission to access this page.' ) );

                update_blog_status( $id, 'archived', '0' );
                wp_safe_redirect( add_query_arg( array( 'updated' => 'true', 'action' => 'unarchive' ), wp_get_referer() ) );
                exit();
            break;

            case 'activateblog':
                check_admin_referer( 'activateblog' );
                if ( ! current_user_can( 'manage_sites' ) )
                    wp_die( __( 'You do not have permission to access this page.' ) );

                update_blog_status( $id, 'deleted', '0' );
                do_action( 'activate_blog', $id );
                wp_safe_redirect( add_query_arg( array( 'updated' => 'true', 'action' => 'activate' ), wp_get_referer() ) );
                exit();
            break;

            case 'deactivateblog':
                check_admin_referer( 'deactivateblog' );
                if ( ! current_user_can( 'manage_sites' ) )
                    wp_die( __( 'You do not have permission to access this page.' ) );

                do_action( 'deactivate_blog', $id );
                update_blog_status( $id, 'deleted', '1' );
                wp_safe_redirect( add_query_arg( array( 'updated' => 'true', 'action' => 'deactivate' ), wp_get_referer() ) );
                exit();
            break;

            case 'unspamblog':
                check_admin_referer( 'unspamblog' );
                if ( ! current_user_can( 'manage_sites' ) )
                    wp_die( __( 'You do not have permission to access this page.' ) );

                update_blog_status( $id, 'spam', '0' );
                wp_safe_redirect( add_query_arg( array( 'updated' => 'true', 'action' => 'unspam' ), wp_get_referer() ) );
                exit();
            break;

            case 'spamblog':
                check_admin_referer( 'spamblog' );
                if ( ! current_user_can( 'manage_sites' ) )
                    wp_die( __( 'You do not have permission to access this page.' ) );

                update_blog_status( $id, 'spam', '1' );
                wp_safe_redirect( add_query_arg( array( 'updated' => 'true', 'action' => 'spam' ), wp_get_referer() ) );
                exit();
            break;

            case 'unmatureblog':
                check_admin_referer( 'unmatureblog' );
                if ( ! current_user_can( 'manage_sites' ) )
                    wp_die( __( 'You do not have permission to access this page.' ) );

                update_blog_status( $id, 'mature', '0' );
                wp_safe_redirect( add_query_arg( array( 'updated' => 'true', 'action' => 'unmature' ), wp_get_referer() ) );
                exit();
            break;

            case 'matureblog':
                check_admin_referer( 'matureblog' );
                if ( ! current_user_can( 'manage_sites' ) )
                    wp_die( __( 'You do not have permission to access this page.' ) );

                update_blog_status( $id, 'mature', '1' );
                wp_safe_redirect( add_query_arg( array( 'updated' => 'true', 'action' => 'mature' ), wp_get_referer() ) );
                exit();
            break;

            // Common
            case 'confirm':
                check_admin_referer( 'confirm' );
                if ( !headers_sent() ) {
                    nocache_headers();
                    header( 'Content-Type: text/html; charset=utf-8' );
                }
                if ( $current_site->blog_id == $id )
                    wp_die( __( 'You are not allowed to change the current site.' ) );
                ?>
                <!DOCTYPE html>
                <html xmlns="http://www.w3.org/1999/xhtml" <?php if ( function_exists( 'language_attributes' ) ) language_attributes(); ?>>
                    <head>
                        <title><?php _e( 'WordPress &rsaquo; Confirm your action' ); ?></title>

                        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                        <?php
                        wp_admin_css( 'install', true );
                        wp_admin_css( 'ie', true );
                        ?>
                    </head>
                    <body>
                        <h1 id="logo"><img alt="WordPress" src="<?php echo esc_attr( admin_url( 'images/wordpress-logo.png' ) ); ?>" /></h1>
                        <form action="sites.php?page=dead-blogs&amp;action=<?php echo esc_attr( $_GET['action2'] ) ?>" method="post">
                            <input type="hidden" name="action" value="<?php echo esc_attr( $_GET['action2'] ) ?>" />
                            <input type="hidden" name="id" value="<?php echo esc_attr( $id ); ?>" />
                            <input type="hidden" name="_wp_http_referer" value="<?php echo esc_attr( wp_get_referer() ); ?>" />
                            <?php wp_nonce_field( $_GET['action2'], '_wpnonce', false ); ?>
                            <p><?php echo esc_html( stripslashes( $_GET['msg'] ) ); ?></p>
                            <input class="button" type="submit" value="<?php echo __('Confirm')?>"/>
                            <?php /*submit_button( __('Confirm'), 'button' ); // this is causing the page to crash for some reason*/ ?>
                        </form>
                    </body>
                </html>
                <?php
                exit();
            break;
        }
    }

    $msg = '';
    if ( isset( $_REQUEST['updated'] ) && $_REQUEST['updated'] == 'true' && ! empty( $_REQUEST['action'] ) ) {
        switch ( $_REQUEST['action'] ) {
            case 'all_notspam':
                $msg = __( 'Sites removed from spam.' );
            break;
            case 'all_spam':
                $msg = __( 'Sites marked as spam.' );
            break;
            case 'all_delete':
                $msg = __( 'Sites deleted.' );
            break;
            case 'delete':
                $msg = __( 'Site deleted.' );
            break;
            case 'not_deleted':
                $msg = __( 'You do not have permission to delete that site.' );
            break;
            case 'archive':
                $msg = __( 'Site archived.' );
            break;
            case 'unarchive':
                $msg = __( 'Site unarchived.' );
            break;
            case 'activate':
                $msg = __( 'Site activated.' );
            break;
            case 'deactivate':
                $msg = __( 'Site deactivated.' );
            break;
            case 'unspam':
                $msg = __( 'Site removed from spam.' );
            break;
            case 'spam':
                $msg = __( 'Site marked as spam.' );
            break;
            default:
                $msg = apply_filters( 'network_sites_updated_message_' . $_REQUEST['action'] , __( 'Settings saved.' ) );
            break;
        }
        if ( $msg )
            $dead_blogs_status_message = '<div class="updated" id="message"><p>' . $msg . '</p></div>';
    }

    ////////////////////////////////////////////////////////////////////////////////
}

function dead_blogs_interface_main_output ()
{
    global $dead_blogs_status_message;

    # initialize this so the initial query won't be so bad
    $_REQUEST['last_updated'] = $_REQUEST['last_updated'] || '1year';

    require_once('dead_blogs_utils.php');
    $u = new Dead_Blogs_Utils;

    require_once('dead_blogs_list_table.php');
    $lt = new Dead_Blogs_List_Table;
    $lt->prepare_items();

?>

<link rel="stylesheet" type="text/css" href="<?php echo plugin_dir_url(__FILE__) ?>/dead_blogs.css"/>
<script type="text/javascript">
jQuery(window).load(function () {
    jQuery('.toggle_handle').click(function () {
        jQuery(this).find('.toggle_content').toggle();
    });
});
</script>

<div class="wrap">
<?php screen_icon('ms-admin'); ?>
<h2><?php _e('Dead Blogs')?></h2>

<?php echo $dead_blogs_status_message; ?>

<h3>Beware: These queries can take a while. Please consider filtering by 'Last Updated' to reduce the number of queries.</h3>


<form action="sites.php" method="get">
<input type="hidden" name="page" value="dead-blogs"/>
<table id="dead-blogs-filter">
    <tr>
        <td>Last Updated</td>
        <td>
            <?php echo  $u->input_select('last_updated', array(
                    'null'      => '-- Ignore --',
                    '1month'    => 'More Than 1 Month Ago',
                    '3month'    => 'More Than 3 Months Ago',
                    '6month'    => 'More Than 6 Months Ago',
                    '1year'     => 'More Than 1 Year Ago',
                ));
            ?>
        </td>
    </tr>
    <tr>
        <td>Number of Posts (at most)</td>
        <td><?php echo  $u->input_text('maxnumposts'); ?></td>
        
    </tr>
    <tr>
        <td>Number of Pages (at most)</td>
        <td><?php echo  $u->input_text('maxnumpages'); ?></td>
    </tr>
    <tr>
        <td>Still has Default Theme</td>
        <td><?php echo  $u->input_checkbox('default_theme'); ?></td>
    </tr>
    <tr>
        <th>Results</th>
        <td><?php echo  $lt->get_num_results(); ?></td>
    </tr>
    <tr>
        <td colspan="2">
            <input type="submit" value="Refresh"/>
        </td>
    </tr>
</table>
</form>

<form id="form-site-list" action="sites.php?page=dead-blogs&amp;action=allblogs" method="post">
    <input type="hidden" name="page" value="dead-blogs"/>
    <?php $lt->display(); ?>
</form>
</div>

<?php
}
?>
