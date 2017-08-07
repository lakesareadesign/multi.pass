<?php
function flatty_scripts() {
//START

    //JS
    wp_register_script('flatty-main-js', plugins_url(FLATTY_PLUGIN_URL . 'assets/js/flatty-main.js'), null, FLATTY_VERSION);
    wp_enqueue_script('flatty-main-js'); 
//END
}
?>
