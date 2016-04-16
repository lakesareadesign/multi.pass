<?php
class A_Comment_Controller extends Mixin
{
    public function fix_locale()
    {
        global $sitepress;
        return $sitepress->get_locale($this->object->param('lang'));
    }
    public function get_comments_action()
    {
        if ($lang = $this->object->param('lang', NULL, FALSE)) {
            if (class_exists('SitePress')) {
                global $sitepress;
                global $locale;
                $locale = $sitepress->get_locale($lang);
                $sitepress->switch_lang($lang);
                remove_filter('locale', array($sitepress, 'locale'));
                add_filter('locale', array($this, 'fix_locale'), -10);
                load_textdomain('default', WP_LANG_DIR . DIRECTORY_SEPARATOR . $locale . '.mo');
            }
        }
        ob_start();
        $mapper = C_Comment_Mapper::get_instance();
        $response = array('responses' => array());
        add_filter('comments_template', array(&$this, 'comments_template'));
        $ids = explode(',', $this->object->param('id'));
        $page = $this->object->param('page', NULL, 0);
        $type = $this->object->param('type');
        foreach ($ids as $id) {
            $post = $mapper->find_or_create($type, $id, $this->object->param('from'));
            $comments_data = $post->get_comments_data($page);
            $response['responses'][$id] = $comments_data;
        }
        ob_end_clean();
        return $response;
    }
    public function comments_template($template)
    {
        $fs = C_Fs::get_instance();
        if (strpos($template, 'ngg_comments') !== FALSE) {
            $template = $fs->find_abspath('photocrati-comments#templates/comments.php');
        }
        return $template;
    }
}
class A_Comment_Factory extends Mixin
{
    public function comment_container($properties = array(), $mapper = FALSE, $context = FALSE)
    {
        return new C_Comment_Container($properties, $mapper, $context);
    }
}
class C_Comment_Container extends C_DataMapper_Model
{
    public function define($properties = array(), $mapper = FALSE, $context = FALSE)
    {
        parent::define($mapper, $properties, $context);
        $this->add_mixin('Mixin_Comment_Container_Validation');
        $this->add_mixin('Mixin_Wordpress_Comment_Container');
    }
    public function initialize($properties = array(), $mapper = FALSE, $context = FALSE)
    {
        if (!$mapper) {
            $mapper = $this->get_registry()->get_utility($this->_mapper_interface);
        }
        parent::initialize($mapper, $properties);
    }
}
class Mixin_Comment_Container_Validation extends Mixin
{
    public function validation()
    {
        $this->object->validates_presence_of('name');
        $this->object->validates_uniqueness_of('name');
        return $this->object->is_valid();
    }
}
class Mixin_Wordpress_Comment_Container extends Mixin
{
    public function get_comments_data($page = 0)
    {
        add_action('pre_get_posts', array(&$this, 'set_comment_data_query_args'), PHP_INT_MAX, 1);
        $retval = array();
        $retval['container_id'] = $this->object->{$this->object->id_field};
        ob_start();
        $args = array('post_type' => 'photocrati-comments', 'p' => $retval['container_id'], 'cpage' => (int) $page);
        // filtering must be disabled for this to function
        M_Photocrati_Comments::$_filter_comments = FALSE;
        query_posts($args);
        while (have_posts()) {
            the_post();
            comments_template('ngg_comments');
        }
        $retval['rendered_view'] = ob_get_contents();
        // restore to our previous state
        wp_reset_query();
        M_Photocrati_Comments::$_filter_comments = TRUE;
        ob_end_clean();
        remove_action('pre_get_posts', array(&$this, 'set_comment_data_query_args'), PHP_INT_MAX, 1);
        return $retval;
    }
    /**
     * Prevent other plugins from adding a filter that negates our ability to do basic database searches
     *
     * @param $query
     */
    public function set_comment_data_query_args($query)
    {
        $query->query_vars['suppress_filters'] = TRUE;
    }
}
class C_Comment_Mapper extends C_CustomPost_DataMapper_Driver
{
    public static $_instances = array();
    public function define($object_name, $context = FALSE)
    {
        parent::define('photocrati-comments', array($context, 'photocrati-comments'));
        $this->add_mixin('Mixin_Comment_Mapper');
        $this->implement('I_Comment_Mapper');
        $this->set_model_factory_method('comment_container');
    }
    public function initialize()
    {
        parent::initialize('photocrati-comments');
    }
    public static function get_instance($context = False)
    {
        if (!isset(self::$_instances[$context])) {
            self::$_instances[$context] = new C_Comment_Mapper($context);
        }
        return self::$_instances[$context];
    }
}
class Mixin_Comment_Mapper extends Mixin
{
    public function find_by_post_title($name, $model = FALSE)
    {
        $retval = NULL;
        $this->object->select();
        $this->object->where(array('post_title = %s', $name));
        $results = $this->object->run_query(FALSE, $model);
        if ($results) {
            $retval = $results[0];
        }
        return $retval;
    }
    public function find_or_create($type, $id, $referer = FALSE)
    {
        $name = $this->object->get_stub($type, $id);
        $post = $this->object->find_by_post_title($name, TRUE);
        if (!$post) {
            $post = new stdClass();
            $post->name = $name;
            $post->post_title = $name;
            $post->comment_status = 'open';
            $post->post_status = 'publish';
            $post->post_type = 'comments';
            $post->post_excerpt = $referer;
            $this->object->save($post);
            $post = $this->object->find_by_post_title($name, TRUE);
        }
        return $post;
    }
    public function get_stub($type, $id)
    {
        return sprintf(__('NextGEN Comment Link - %s - %s', 'nextgen-gallery-pro'), $type, $id);
    }
}