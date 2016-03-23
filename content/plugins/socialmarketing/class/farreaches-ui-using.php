<?php
abstract class FarReaches_Ui_Using extends FarReaches_Base {
    /**
     * @var FarReaches_Ui_Handling
     */
    protected $farReaches_Ui_Handling;

    /**
     * @param FarReaches_Util $farReaches_Util
     * @param FarReaches_Communication $farReaches_Communication
     * @param FarReaches_Ui_Handling $farReaches_Ui_Handling
     */
    protected function __construct(FarReaches_Util $farReaches_Util, FarReaches_Communication $farReaches_Communication, FarReaches_Ui_Handling $farReaches_Ui_Handling) {
        parent::__construct($farReaches_Util, $farReaches_Communication);
        $this->farReaches_Ui_Handling = $farReaches_Ui_Handling;
    }
    /**
     * @param $template
     * @param bool $replaced_dom_element_selector
     * @param array $data_map
     */
    protected function generate_jsrender_template($template, $replaced_dom_element_selector = true, $data_map = null, $wrap = true) {
        $this->farReaches_Ui_Handling->generate_jsrender_template($template, $replaced_dom_element_selector, $data_map, $wrap);
    }
    protected function add_js_config($key, $data) {
        $this->farReaches_Ui_Handling->add_js_config($key, $data);
    }
    protected function register_script( $handle, $src, $deps = array(), $ver = false, $in_footer = false ) {
        $this->farReaches_Ui_Handling->register_script($handle, $src, $deps, $ver, $in_footer);
    }
}
