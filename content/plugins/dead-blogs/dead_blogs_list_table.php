<?php

if (!class_exists('WP_List_Table'))
    require_once(ABSPATH.'wp-admin/includes/class-wp-list-table.php');

class Dead_Blogs_List_Table extends WP_List_Table
{
    public $last_query;
    public $last_query_result;

    function __construct ()
    {
        //global $status, $page;

        parent::__construct(array(
            'singular'  => 'site',
            'plural'    => 'sites',
            'ajax'      => false
        ));
    }

    ////////////////////////////////////////////////////////////////////////////////
    // Config //////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////

    function get_columns ()
    {
        return array(
            'cb'          => '<input type="checkbox" />',
            'blogname'    => (is_subdomain_install()) ? __( 'Domain' ) : __( 'Path' ),
            'lastupdated' => __( 'Last Updated' ),
            //'registered'  => _x( 'Registered', 'site' ),
            'other'       => __('Misc'),
        );
    }

    function get_hidden_columns ()
    {
        return array();
    }

    function get_sortable_columns ()
    {
        //return array();
        return array(
            'blogname'    => array('blogname', false),
            'lastupdated' => array('lastupdated', false),
            //'registered'  => array('blog_id', false)
        );
    }

    ////////////////////////////////////////////////////////////////////////////////
    // Prepare /////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////

    function prepare_items ()
    {
        global $wpdb;

        // paging is DISABLED (which means the total number of blogs to show up is UNBOUNDED)
        // the queries are going to be a PITA because WP splits up the DB with each site having its own set of tables
        // this gives me no opportunity to do a large JOIN (unless i specify every blog's table separately), so it will have to be a separate query for each blog
        // probably could get around this with a temporary table, but that means getting EVERYTHING into the temp table first, then LIMITing it, and then discarding the temp table... might as well list everything?

        // set up headers
            $this->_column_headers = array($this->get_columns(), $this->get_hidden_columns(), $this->get_sortable_columns());

        // db query
            $query = "SELECT * FROM {$wpdb->blogs} WHERE site_id='{$wpdb->siteid}' AND blog_id!=1";

            // filter by last_updated
            if (isset($_REQUEST['last_updated']))
            {
                if ($_REQUEST['last_updated'] == '1month')
                {
                    $query .= " AND last_updated < (NOW() - INTERVAL 1 MONTH)";
                }
                elseif ($_REQUEST['last_updated'] == '3month')
                {
                    $query .= " AND last_updated < (NOW() - INTERVAL 3 MONTH)";
                }
                elseif ($_REQUEST['last_updated'] == '6month')
                {
                    $query .= " AND last_updated < (NOW() - INTERVAL 6 MONTH)";
                }
                elseif ($_REQUEST['last_updated'] == '1year')
                {
                    $query .= " AND last_updated < (NOW() - INTERVAL 1 YEAR)";
                }
            }

            // sorting
            $order_by = isset($_REQUEST['orderby']) ? $_REQUEST['orderby'] : '';

            if ($order_by == 'registered')
            {
                $query .= ' ORDER BY registered ';
            }
            elseif ($order_by == 'lastupdated')
            {
                $query .= ' ORDER BY last_updated ';
            }
            elseif ($order_by == 'blogname')
            {
                if (is_subdomain_install())
                    $query .= ' ORDER BY domain ';
                else
                    $query .= ' ORDER BY path ';
            }
            elseif ($order_by == 'blog_id')
            {
                $query .= ' ORDER BY blog_id ';
            }
            else
            {
                $order_by = null;
            }

            if (isset($order_by))
            {
                $order = (isset($_REQUEST['order']) && 'DESC' == strtoupper($_REQUEST['order'])) ? "DESC" : "ASC";
                $query .= $order;
            }

            // paging
            //$pagenum = $this->get_pagenum();
            //$per_page = $this->get_items_per_page('sites_network_per_page') or 10;

            //$total_items = $wpdb->get_var( str_replace( 'SELECT *', 'SELECT COUNT( blog_id )', $query ) );
            //$query .= " LIMIT ".intval(($pagenum - 1) * $per_page).", ".intval($per_page);

            // go
            $this->items = $wpdb->get_results($query, ARRAY_A);

            $this->last_query[]         = $query;
            $this->last_query_result[]  = count($this->items).' Row(s)';

        // paging
            //$this->set_pagination_args(array(
            //    'total_items'   => $total_items,
            //    'per_page'      => $per_page,
            //    'total_pages'   => ceil($total_items / $per_page),
            //));

        // individual blog queries
            // maximum number of posts

                if (isset($_REQUEST['maxnumposts']) && $_REQUEST['maxnumposts'] > 0) // i assume this checks for int-ness
                {
                    $new_items = array();

                    foreach ($this->items as &$item)
                    {
                        $query = "SELECT count(ID) FROM {$wpdb->base_prefix}{$item['blog_id']}_posts WHERE post_type='post' AND post_status='publish'";

                        $post_count = $wpdb->get_var($query);

                        $this->last_query[]         = $query;
                        $this->last_query_result[]  = $post_count.' Post(s)';
                        $item['numposts']           = $post_count;

                        if ($post_count <= $_REQUEST['maxnumposts'])
                            $new_items[] = $item;
                    }

                    $this->items = $new_items;
                }

            // maximum number of pages
                if (isset($_REQUEST['maxnumpages']) && $_REQUEST['maxnumpages'] > 0) // i assume this checks for int-ness
                {
                    $new_items = array();

                    foreach ($this->items as &$item)
                    {
                        $query = "SELECT count(ID) FROM {$wpdb->base_prefix}{$item['blog_id']}_posts WHERE post_type='page'";

                        $page_count = $wpdb->get_var($query);

                        $this->last_query[]         = $query;
                        $this->last_query_result[]  = $page_count.' Page(s)';
                        $item['numpages']           = $page_count;

                        if ($page_count <= $_REQUEST['maxnumpages'])
                            $new_items[] = $item;
                    }

                    $this->items = $new_items;
                }

            // still has default theme
                if (isset($_REQUEST['default_theme']) && $_REQUEST['default_theme'])
                {
                    $default_themes = array('twentyten', 'twentyeleven');
                    if (defined(WP_DEFAULT_THEME))
                        $default_themes[] = WP_DEFAULT_THEME;

                    $new_items = array();

                    foreach ($this->items as &$item)
                    {
                        $query = "SELECT option_value FROM {$wpdb->base_prefix}{$item['blog_id']}_options WHERE option_name='template'";

                        $template = $wpdb->get_var($query);

                        $this->last_query[]         = $query;
                        $this->last_query_result[]  = 'Theme is '.$template;
                        $item['theme']              = $template;

                        if (in_array($template, $default_themes))
                            $new_items[] = $item;
                    }

                    $this->items = $new_items;
                }
    }

    function get_bulk_actions ()
    {
        $actions = array();

        if (current_user_can('delete_sites'))
            $actions['delete'] = __('Delete');

        $actions['spam']    = _x('Mark as Spam', 'site');
        $actions['notspam'] = _x('Not Spam', 'site');
        $actions['mail']   = __('Send Email');

        return $actions;
    }

    function get_num_results ()
    {
        return count($this->items);
    }

    ////////////////////////////////////////////////////////////////////////////////
    // Display /////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////

    function column_default ($item, $column_name)
    {
        return $column_name;
    }

    function column_cb ($item)
    {
        return sprintf('<input type="checkbox" name="%1$s[]" value="%2$s" />', 'allblogs', $item['blog_id']);
    }

    function column_blogname ($site)
    {
        // find site "title"
        $blogname = is_subdomain_install() ? str_replace('.'.$current_site->domain, '', $site['domain']) : $site['path'];

        // actions
            // declared here to maintain action order
            $actions = array(
                'edit'          => null,
                'backend'       => null,
                'activate'      => null,
                'deactivate'    => null,
                'archive'       => null,
                'unarchive'     => null,
                'spam'          => null,
                'unspam'        => null,
                'delete'        => null,
                'visit'         => null,
                'mail'         => null,
            );

            // edit
            $actions['edit'] = '<span class="edit"><a href="' . esc_url( network_admin_url( 'site-info.php?id=' . $site['blog_id'] ) ) . '">' . __( 'Edit' ) . '</a></span>';

            // site dashboard
            $actions['backend'] = "<span class='backend'><a href='" . esc_url( get_admin_url( $site['blog_id'] ) ) . "' class='edit'>" . __( 'Dashboard' ) . '</a></span>';

            // activate/deactivate
            if ( get_blog_status( $site['blog_id'], 'deleted' ) == '1' )
                $actions['activate'] = '<span class="activate"><a href="' . esc_url( wp_nonce_url( network_admin_url( 'sites.php?page=dead-blogs&amp;action=confirm&amp;action2=activateblog&amp;id=' . $site['blog_id'] . '&amp;msg=' . urlencode( sprintf( __( 'You are about to activate the site %s' ), $blogname ) ) ), 'confirm' ) ) . '">' . __( 'Activate' ) . '</a></span>';
            else
                $actions['deactivate'] = '<span class="activate"><a href="' . esc_url( wp_nonce_url( network_admin_url( 'sites.php?page=dead-blogs&amp;action=confirm&amp;action2=deactivateblog&amp;id=' . $site['blog_id'] . '&amp;msg=' . urlencode( sprintf( __( 'You are about to deactivate the site %s' ), $blogname ) ) ), 'confirm') ) . '">' . __( 'Deactivate' ) . '</a></span>';

            // archive/unarchive
            if ( get_blog_status( $site['blog_id'], 'archived' ) == '1' )
                $actions['unarchive'] = '<span class="archive"><a href="' . esc_url( wp_nonce_url( network_admin_url( 'sites.php?page=dead-blogs&amp;action=confirm&amp;action2=unarchiveblog&amp;id=' .  $site['blog_id'] . '&amp;msg=' . urlencode( sprintf( __( 'You are about to unarchive the site %s.' ), $blogname ) ) ), 'confirm') ) . '">' . __( 'Unarchive' ) . '</a></span>';
            else
                $actions['archive'] = '<span class="archive"><a href="' . esc_url( wp_nonce_url( network_admin_url( 'sites.php?page=dead-blogs&amp;action=confirm&amp;action2=archiveblog&amp;id=' . $site['blog_id'] . '&amp;msg=' . urlencode( sprintf( __( 'You are about to archive the site %s.' ), $blogname ) ) ), 'confirm') ) . '">' . _x( 'Archive', 'verb; site' ) . '</a></span>';

            // spam/unspam
            if ( get_blog_status( $site['blog_id'], 'spam' ) == '1' )
                $actions['unspam'] = '<span class="spam"><a href="' . esc_url( wp_nonce_url( network_admin_url( 'sites.php?page=dead-blogs&amp;action=confirm&amp;action2=unspamblog&amp;id=' . $site['blog_id'] . '&amp;msg=' . urlencode( sprintf( __( 'You are about to unspam the site %s.' ), $blogname ) ) ), 'confirm') ) . '">' . _x( 'Not Spam', 'site' ) . '</a></span>';
            else
                $actions['spam'] = '<span class="spam"><a href="' . esc_url( wp_nonce_url( network_admin_url( 'sites.php?page=dead-blogs&amp;action=confirm&amp;action2=spamblog&amp;id=' . $site['blog_id'] . '&amp;msg=' . urlencode( sprintf( __( 'You are about to mark the site %s as spam.' ), $blogname ) ) ), 'confirm') ) . '">' . _x( 'Spam', 'site' ) . '</a></span>';

            // delete
            if ( current_user_can( 'delete_site', $site['blog_id'] ) )
                $actions['delete'] = '<span class="delete"><a href="' . esc_url( wp_nonce_url( network_admin_url( 'sites.php?page=dead-blogs&amp;action=confirm&amp;action2=deleteblog&amp;id=' . $site['blog_id'] . '&amp;msg=' . urlencode( sprintf( __( 'You are about to delete the site %s.' ), $blogname ) ) ), 'confirm') ) . '">' . __( 'Delete' ) . '</a></span>';

            // visit
            $actions['visit'] = "<span class='view'><a href='" . esc_url( get_home_url( $site['blog_id'] ) ) . "' rel='permalink'>" . __( 'Visit' ) . '</a></span>';

            // mail admin
            $actions['mail'] = "<span class='mail'><a href='" . esc_url( network_admin_url( 'sites.php?page=dead-blogs&mode=mail&id=' . $site['blog_id'] ) ) . "'>" . __( 'Send Email' ) . '</a></span>';

        // filter actions (not really sure what's going on here)
        $actions = apply_filters('manage_sites_action_links', array_filter($actions), $site['blog_id'], $blogname);

        // and construct result
        $result = sprintf('<a href="%1$s">%2$s</a>', esc_url(network_admin_url('site-info.php?id='.$site['blog_id'])), $blogname);

        $result .= $this->row_actions($actions);

        return $result;
    }

    function column_lastupdated ($site)
    {
        return ($site['last_updated'] == '0000-00-00 00:00:00') ? __( 'Never' ) : mysql2date('Y/m/d', $site['last_updated']);
    }

    function column_registered ($site)
    {
        return ($site['registered'] == '0000-00-00 00:00:00') ? '&#x2014;' : mysql2date('Y/m/d', $site['registered']);
    }

    function column_other ($site)
    {
        $result = '<table class="smalltable">';

        // users
        $blogusers = get_users(array('blog_id' => $site['blog_id']));

        $result .= "<tr><th>Users</th><td>";
        $result .= '<div class="toggle_handle">';
        $result .= count($blogusers);
        $result .= '<div class="toggle_content">';
        foreach ($blogusers as $user_object)
        {
            $result .= '<a href="'.esc_url(network_admin_url('user-edit.php?user_id='.$user_object->ID)).'">'.esc_html($user_object->user_login).'</a><br />';
        }
        $result .= '</div></div>';
        $result .= "</td></tr>";

        // number of posts
        if (isset($site['numposts']))
        {
            $result .= "<tr><th>Number of Posts</th><td>{$site['numposts']}</td></tr>";
        }

        // number of pages
        if (isset($site['numpages']))
        {
            $result .= "<tr><th>Number of Pages</th><td>{$site['numpages']}</td></tr>";
        }

        // theme being used
        if (isset($site['theme']))
        {
            $result .= "<tr><th>Theme</th><td>{$site['theme']}</td></tr>";
        }

        $result .= '</table>';

        return $result;
    }
}

?>
