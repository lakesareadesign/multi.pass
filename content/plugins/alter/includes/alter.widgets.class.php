<?php
/*
 * ALTER
 * @author   AcmeeDesign
 * @url     http://acmeedesign.com
*/

defined('ABSPATH') || die;

if (!class_exists('ALTERWIDGETS')) {

    class ALTERWIDGETS extends ALTER
    {
        public $alterObj;
        public $aof_options;

        function __construct()
        {
            $this->aof_options = parent::alter_get_option_data(ALTER_OPTIONS_SLUG);
            add_action('admin_menu', array($this, 'add_dash_widgets_menu'));
            add_action('wp_dashboard_setup', array($this, 'initialize_dash_widgets'), 999);
            add_action('wp_dashboard_setup', array($this, 'manage_dash_widgets'), 9999);
            add_action('wp_dashboard_setup', array($this, 'create_widgets_meta'), 999);
            add_action('plugins_loaded',array($this, 'save_custom_widgets'));
        }

        public function initialize_dash_widgets() {
            global $wp_meta_boxes;

            $context = array("normal","side","advanced");
            $priority =array("high","low","default","core");

            $alter_widgets_list = $wp_meta_boxes['dashboard'];
            $alter_the_Widgets = array();
            if (!is_array($alter_widgets_list['normal']['core'])) {
                $alter_widgets_list = array('normal'=>array('core'=>array()), 'side'=>array('core'=>array()),'advanced'=>array('core'=>array()));
            }
            foreach ($context as $context_value)
            {
                foreach ($priority as $priority_value)
                {
                    if(isset($alter_widgets_list[$context_value][$priority_value]) && is_array($alter_widgets_list[$context_value][$priority_value]))
                    {
                        foreach ($alter_widgets_list[$context_value][$priority_value] as $key=>$data) {
                            $key = $key . "|".$context_value;
                            $widget_title = preg_replace("/Configure/", "", strip_tags($data['title']));
                            $alter_the_Widgets[] = array($key, $widget_title);
                        }
                    }
                }
            }

            parent::updateOption(ALTER_WIDGETS_LISTS_SLUG, $alter_the_Widgets);

        }

        function manage_dash_widgets() {
            if(!isset($this->aof_options['remove_dash_widgets']))
                return;

            global $wp_meta_boxes;
            $dash_widgets_removal_data = $this->aof_options['remove_dash_widgets'];
            $remove_dash_widgets = (is_serialized($dash_widgets_removal_data)) ? unserialize($dash_widgets_removal_data) : $dash_widgets_removal_data;

            //Removing unwanted widgets
            if(!empty($remove_dash_widgets) && is_array($remove_dash_widgets)) {
                foreach ($remove_dash_widgets as $widget_to_rm) {
                    if($widget_to_rm == "welcome_panel") {
                        remove_action('welcome_panel', 'wp_welcome_panel');
                    }
                    else {
                        $widget_data = explode("|", $widget_to_rm);
                        $widget_id = $widget_data[0];
                        $context = array("high","low","default","core");
                        $priority = array("normal","side","advanced");
                        foreach ($context as $context_value)
                        {
                            foreach ($priority as $priority_value)
                            {
                                if(isset($wp_meta_boxes['dashboard'][$priority_value][$context_value][$widget_id]) && is_array($wp_meta_boxes['dashboard'][$priority_value][$context_value][$widget_id]))
                                {
                                    unset($wp_meta_boxes['dashboard'][$priority_value][$context_value][$widget_id]);
                                }
                            }
                        }
                    }
                }
            }

        }

        function add_dash_widgets_menu() {
            add_submenu_page( ALTER_MENU_SLUG , __('Add Widgets', 'alter'), __('Add Widgets', 'alter'), 'manage_options', 'alter_add_dash_widgets', array($this, 'add_dash_widgets_page') );
        }

        function add_dash_widgets_page() {
                        ?>
                    <div class="wrap alter-wrap">
                        <h2><?php _e('Add Custom Dashboard Widgets', 'alter'); ?></h2>
                        <form name="alter_add_widgets" method="post">
                            <div id="alt-repeater">
                                <div data-repeater-list="add_dash_widgets">
                                    <?php
                                    if(isset($this->aof_options['add_dash_widgets']) && !empty($this->aof_options['add_dash_widgets'])) {
                                    //display saved repeaters
                                    foreach ($this->aof_options['add_dash_widgets'] as $repeater) {
                                        if(empty($repeater['widget_title']) && empty($repeater['widget_rss']) && empty($repeater['widget_content']) )
                                            continue;
                                        ?>
                                    <div data-repeater-item="" class="repeater-item">
                                        <button type="button" class="r-btnRemove button action" data-repeater-delete=""><?php _e('Remove', 'alter'); ?></button>
                                        <div class="field_wrap">
                                            <div class="label">
                                                <label for="widget-text"><strong><?php _e('Widget type', 'alter'); ?></strong></label>
                                            </div>
                                            <div class="field_content">
                                                <select name="add_dash_widgets[0][widget_type]">
                                                    <option value="1" <?php if($repeater['widget_type'] == 1) echo "selected=selected"; ?>><?php _e('Custom content', 'alter'); ?></option>
                                                    <option value="2" <?php if($repeater['widget_type'] == 2) echo "selected=selected"; ?>><?php _e('RSS', 'alter'); ?></option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="field_wrap">
                                            <div class="label">
                                                <label for="widget-position">
                                                    <strong><?php _e('Widget position', 'alter'); ?></strong>
                                                </label>
                                            </div>
                                            <div class="field_content">
                                                <select name="add_dash_widgets[0][widget_position]">
                                                    <option value="1" <?php if($repeater['widget_position'] == 1) echo "selected=selected"; ?>><?php _e('Left', 'alter'); ?></option>
                                                    <option value="2" <?php if($repeater['widget_position'] == 2) echo "selected=selected"; ?>><?php _e('Right', 'alter'); ?></option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="field_wrap">
                                            <div class="label">
                                                <label for="widget-title">
                                                    <strong><?php _e('Widget title', 'alter'); ?></strong>
                                                </label>
                                            </div>
                                            <div class="field_content">
                                                <input type="text" name="add_dash_widgets[0][widget_title]" value="<?php echo esc_attr(stripslashes($repeater['widget_title'])); ?>" />
                                            </div>
                                        </div>
                                        <div class="field_wrap">
                                            <div class="label">
                                                <label for="widget-rss">
                                                    <strong><?php _e('Widget RSS url', 'alter'); ?></strong>
                                                </label>
                                            </div>
                                            <div class="field_content">
                                                <input type="text" name="add_dash_widgets[0][widget_rss]" value="<?php echo esc_attr(stripslashes($repeater['widget_rss'])); ?>" />
                                            </div>
                                        </div>
                                        <div class="field_wrap">
                                            <div class="label">
                                                <label for="widget-content">
                                                    <strong><?php _e('Widget content (Accepts WP shortcodes)', 'alter'); ?></strong>
                                                </label>
                                            </div>
                                            <div class="field_content">
                                                <textarea rows="7" name="add_dash_widgets[0][widget_content]"><?php echo esc_textarea(stripslashes($repeater['widget_content'])); ?></textarea>
                                            </div>
                                        </div>

                                    </div>
                                    <?php
                                    }
                                    }
                                    ?>
                                    <div data-repeater-item="" class="repeater-item">
                                        <button type="button" class="r-btnRemove button action" data-repeater-delete=""><?php _e('Remove', 'alter'); ?></button>
                                        <div class="field_wrap">
                                            <div class="label">
                                                <label for="widget-text"><strong><?php _e('Widget type', 'alter'); ?></strong></label>
                                            </div>
                                            <div class="field_content">
                                                <select name="add_dash_widgets[0][widget_type]">
                                                    <option value="1"><?php _e('Custom content', 'alter'); ?></option>
                                                    <option value="2"><?php _e('RSS', 'alter'); ?></option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="field_wrap">
                                            <div class="label">
                                                <label for="widget-position">
                                                    <strong><?php _e('Widget position', 'alter'); ?></strong>
                                                </label>
                                            </div>
                                            <div class="field_content">
                                                <select name="add_dash_widgets[0][widget_position]">
                                                    <option value="1"><?php _e('Left', 'alter'); ?></option>
                                                    <option value="2"><?php _e('Right', 'alter'); ?></option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="field_wrap">
                                            <div class="label">
                                                <label for="widget-title">
                                                    <strong><?php _e('Widget title', 'alter'); ?></strong>
                                                </label>
                                            </div>
                                            <div class="field_content">
                                                <input type="text" name="add_dash_widgets[0][widget_title]" value="" />
                                            </div>
                                        </div>
                                        <div class="field_wrap">
                                            <div class="label">
                                                <label for="widget-rss">
                                                    <strong><?php _e('Widget RSS url', 'alter'); ?></strong>
                                                </label>
                                            </div>
                                            <div class="field_content">
                                                <input type="text" name="add_dash_widgets[0][widget_rss]" value="" />
                                            </div>
                                        </div>
                                        <div class="field_wrap">
                                            <div class="label">
                                                <label for="widget-content">
                                                    <strong><?php _e('Widget content (Accepts WP shortcodes)', 'alter'); ?></strong>
                                                </label>
                                            </div>
                                            <div class="field_content">
                                                <textarea rows="7" name="add_dash_widgets[0][widget_content]"></textarea>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                                <div class="button-group">
                                    <button type="button" class="button button-primary alt-text-add" data-repeater-create=""><?php _e('Add new widget', 'alter'); ?></button>
                                </div>
                            </div>
                            <input type="hidden" name="alter_add_widgets" value="1" />
                            <input type="submit" name="submit" value="<?php _e('Save Now', 'alter'); ?>" class="save button button-primary button-hero" />
                        </form>
                    </div>
<?php
        }

        function save_custom_widgets() {
            if(isset($_POST['alter_add_widgets'])) {
                $custom_widgets = array();
                if(isset($_POST['add_dash_widgets']) && !empty($_POST['add_dash_widgets'])) {
                    foreach($_POST['add_dash_widgets'] as $dash_widget_data) {
                        if(empty($dash_widget_data['widget_title']) && empty($dash_widget_data['widget_rss']) && empty($dash_widget_data['widget_content']) ) {
                            $custom_widgets['add_dash_widgets'][] = "";
                            continue;
                        }
                        foreach ($dash_widget_data as $data_key => $data_value) {
                          //$widget_data_array[$data_key] = htmlentities($data_value, ENT_COMPAT);
                          $widget_data_array[$data_key] = str_replace('"',"'", $data_value);
                        }
                        $custom_widgets['add_dash_widgets'][] = $widget_data_array;
                    }
                }

                $saved_data = parent::alter_get_option_data(ALTER_OPTIONS_SLUG);
                $data = array_merge($saved_data, $custom_widgets);

                parent::updateOption(ALTER_OPTIONS_SLUG,$data);
                wp_safe_redirect( admin_url( 'admin.php?page=alter_add_dash_widgets&status=updated' ) );
                exit();
            }
        }

        function create_widgets_meta() {
            if(empty($this->aof_options['add_dash_widgets'])) {
                return;
            }

            //Creating new widgets
            $dash_widget_data = array();
            $i = 1;
            foreach($this->aof_options['add_dash_widgets'] as $add_widget) {
              if(is_array($add_widget) && !empty($add_widget)) {
                  $dash_widget_data['type'] = ($add_widget['widget_type'] == 2) ? "rss" : "custom";
                  $dash_widget_data['pos'] = ($add_widget['widget_position'] == 2) ? "side" : "normal";
                  $dash_widget_data['title'] = $add_widget['widget_title'];
                  $dash_widget_data['rss'] = $add_widget['widget_rss'];
                  $dash_widget_data['content'] = do_shortcode($add_widget['widget_content']);
                  if(!empty($dash_widget_data['rss']) || !empty($dash_widget_data['content'])) {
                      add_meta_box('alter_widget_' . $i, $dash_widget_data['title'], array($this, 'output_dash_widget'), 'dashboard', $dash_widget_data['pos'], 'high', $dash_widget_data);
                      $i++;
                  }
              }
            }
        }

        public function output_dash_widget($post, $dash_widget_data)
        {
            if($dash_widget_data['args']['type'] == "rss") {
                    echo '<div class="alter-rss-widget">';
                     wp_widget_rss_output($dash_widget_data['args']['rss'], array(
                              'items' => 5,
                              'show_summary' => 1,
                              'show_author' => 1,
                              'show_date' => 1
                     ));
                     echo "</div>";
            }
            else {
                    echo  $dash_widget_data['args']['content'];
            }
        }

    }

}
new ALTERWIDGETS();
