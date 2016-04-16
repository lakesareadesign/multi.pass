<?php
/*
{
    Module: photocrati-comments,
    Depends: { photocrati-ajax, photocrati-datamapper }
}
*/
class M_Photocrati_Comments extends C_Base_Module
{
    protected $_interrupt_comment_post_redirection = FALSE;

    // not all parts of WP should 'see' our comments
    public static $_filter_comments = TRUE;

    function define($context=FALSE)
    {
        parent::define(
            'photocrati-comments',
            'Comments',
            'AJAX operations for retrieving and creating comments on arbitrary items',
            '0.15',
            'http://www.photocrati.com',
            'Photocrati Media',
            'http://www.photocrati.com',
            $context
        );
    }

    function get_type_list()
    {
        return array(
            'A_Comment_Factory' => 'adapter.comment_factory.php',
            'A_Comment_Controller' => 'adapter.comment_controller.php',
            'C_Comment_Mapper' => 'class.comment_mapper.php',
            'C_Comment_Container' => 'class.comment_container.php'
        );
    }

    function _register_hooks()
    {
        add_action('init',                  array($this, 'register_post_type'));
        add_action('pre_comment_on_post',   array($this, 'pre_comment_on_post'));
        add_action('admin_enqueue_scripts', array($this, 'admin_enqueue_scripts'));

        add_filter('comment_post_redirect', array($this, 'comment_post_redirect'), NULL, 2);
        add_filter('post_type_link',        array($this, 'set_custom_post_link'),  NULL, 2);
        add_filter('get_edit_post_link',    array($this, 'set_custom_post_link'),  NULL, 2);

        if (!is_admin())
            add_filter('the_comments', array($this, 'the_comments'));

        add_filter('the_title',           array($this, 'the_title'),           NULL, 2);
        add_filter('comment_class',       array($this, 'comment_class'),       NULL, 5);
        add_filter('comment_row_actions', array($this, 'comment_row_actions'), NULL, 2);
    }

    function comment_row_actions($actions, $comment)
    {
        if (get_comment_meta($comment->comment_ID, 'generated_by', TRUE) != 'photocrati-comments')
            return $actions;

        $actions['nextgen_source'] = sprintf(
            __("<a href='%s' target='_blank'>View in lightbox</a>", 'nextgen-gallery-pro'),
            get_comment_meta($comment->comment_ID, 'ngg_origin_url', TRUE)
        );

        return $actions;
    }

    function admin_enqueue_scripts($hook)
    {
        if ($hook != 'edit-comments.php')
            return;

        wp_enqueue_style(
            'nextgen-pro-comments',
            C_Router::get_instance()->get_static_url(
                $this->module_id . '#admin.css'
            )
        );
    }

    function comment_class($classes, $class, $comment_id, $comment, $post_id)
    {
        if (get_comment_meta($comment->comment_ID, 'generated_by', TRUE) != 'photocrati-comments')
            return $classes;

        $classes[] = 'nextgen-comment';

        return $classes;
    }

    function the_title($title, $id = NULL)
    {
        $post = get_post();
        if (!$post || !isset($post->post_type) || $post->post_type != 'photocrati-comments')
            return $title;

        $image_id = intval(str_replace('nextgen-comment-link-image-', '', $post->post_name));
        $image = C_Image_Mapper::get_instance()->find($image_id);
        $gallery = C_Gallery_Mapper::get_instance()->find($image->galleryid);
        return sprintf(
            __("Image in gallery '%s'", 'nextgen-gallery-pro'),
            $gallery->title
        );
    }

    function set_custom_post_link($post_link, $post)
    {
        if (is_int($post))
            $post = get_post($post);

        if ($post->post_type != 'photocrati-comments')
            return $post_link;

        $image_id = intval(str_replace('nextgen-comment-link-image-', '', $post->post_name));
        if (($image = C_Image_Mapper::get_instance()->find($image_id)))
            $post_link = wp_nonce_url('admin.php?page=nggallery-manage-gallery&mode=edit&gid=' . $image->galleryid);

        return $post_link;
    }

    function _register_adapters()
    {
        $this->get_registry()->add_adapter('I_Component_Factory', 'A_Comment_Factory');
        if (!is_admin())
            $this->get_registry()->add_adapter('I_Ajax_Controller', 'A_Comment_Controller');
    }

    function _register_utilities()
    {
        $this->get_registry()->add_utility('I_Comment_Mapper', 'C_Comment_Mapper');
    }

    function register_post_type()
    {
        register_post_type(
            'photocrati-comments',
            array(
                'label' => __('Comment', 'nextgen-gallery-pro'),
                'labels' => array(
                    'name'          => __('Comment', 'nextgen-gallery-pro'),
                    'singular_name' => __('Comment', 'nextgen-gallery-pro'),
                    'view_item'     => __('View Gallery', 'nextgen-gallery-pro')
                ),
                'public'            => FALSE,
                'show_in_menu'      => FALSE,
                'show_in_admin_bar' => FALSE,
                'supports' => array(
                    'comments' => TRUE,
                    'title'    => FALSE,
                    'editor'   => FALSE,
                ),
                'rewrite'   => FALSE,
                'query_var' => FALSE
            )
        );
    }

    function pre_comment_on_post($post_id)
    {
        $post = get_post($post_id);
        if ($post->post_type == 'photocrati-comments' && !defined('DOING_AJAX' ))
        {
            // start a new output buffer just in case any plugins or themes throw any warnings, errors, or any other
            // unwanted texts from forcing themselves into our json response
            ob_start();
            $this->_interrupt_comment_post_redirection = TRUE;
            define('DOING_AJAX', TRUE);
        }
    }

    /**
     * The last action wp-comments-post.php before redirecting is to call the set_comment_post_redirect filter. To
     * prevent the WP 302 HTTP response we output our own json here and end execution. This should ONLY be done if
     * the pre_comment_on_post action (see above) has determined the comment belongs to one of our wrapper posts!
     *
     * @param $location
     * @throws E_Clean_Exit
     */
    function comment_post_redirect($location, $comment)
    {
        if ($this->_interrupt_comment_post_redirection)
        {
            // use this to track which comments we created
            add_comment_meta($comment->comment_ID, 'generated_by', 'photocrati-comments');

            if (isset($_REQUEST['ngg_comment_origin_url']) && !empty($_REQUEST['ngg_comment_origin_url']))
                add_comment_meta($comment->comment_ID, 'ngg_origin_url', $_REQUEST['ngg_comment_origin_url']);

            if (isset($_REQUEST['nextgen_generated_comment']) && $_REQUEST['nextgen_generated_comment'] == 'true')
            {
                while (ob_get_level() > 0 ) {
                    ob_end_clean();
                }
                echo json_encode(array('success' => TRUE));
                throw new E_Clean_Exit();
            }
        }

        return $location;
    }

    /**
     * Applies a filter to recent comments that prevents comments generated by this module from appearing in
     * the "Recent Comments" widget provided by Wordpress
     *
     * @param array $comments
     * @return array $comments
     */
    function the_comments($comments = array())
    {
        // Unfortunately Wordpress' has poor ability to filter comments based on their metadata when calling
        // get_comments(). Because of this we must filter comments we have generated *after* allowing them to
        // be retrieved.
        if (self::$_filter_comments)
        {
            foreach ($comments as $ndx => $comment) {
                $meta = get_comment_meta($comment->comment_ID);
                if (!empty($meta['generated_by']) && $meta['generated_by'][0] == 'photocrati-comments')
                    unset($comments[$ndx]);
            }
        }

        return $comments;
    }
}

new M_Photocrati_Comments;
