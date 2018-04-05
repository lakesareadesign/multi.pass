<?php
/**
 * @package WPShapere
 * @author   AcmeeDesign
 * @url     http://acmeedesign.com
 * defining css styles for WordPress admin pages.
 */

$css_styles = '';
$css_styles .= '<style type="text/css">';

//static styles
$css_styles .= 'html.wp-toolbar {
        padding-top: 50px;
}
#wpadminbar {
    height:50px;
    -webkit-box-shadow: 0 2px 2px rgba(0, 0, 0, 0.05), 0 1px 0 rgba(0, 0, 0, 0.05);
    -moz-box-shadow: 0 2px 2px rgba(0, 0, 0, 0.05), 0 1px 0 rgba(0, 0, 0, 0.05);
    box-shadow: 0 2px 2px rgba(0, 0, 0, 0.05), 0 1px 0 rgba(0, 0, 0, 0.05);
}
#wpadminbar .quicklinks {
    border: none !important;
}
#wpadminbar .quicklinks li#wp-admin-bar-my-account.with-avatar>a img {
    width: 36px;
    height: 36px;
    border-radius: 100px;
    -moz-border-radius: 100px;
    -webkit-border-radius: 100px;
    border: none;
}
li#wp-admin-bar-my-account a {
    font-weight: 600;
}
#wpadminbar .quicklinks li a .blavatar, #wpadminbar .quicklinks li a:hover .blavatar { display: none}
#wpadminbar .quicklinks .ab-empty-item, #wpadminbar .quicklinks a, #wpadminbar .shortlink-input {
    height: 32px;
}
#collapse-button {
    margin:10px 21px 20px;
}
ul#wp-admin-bar-root-default, ul.ab-top-menu {}
#wpadminbar .quicklinks>ul>li>a, div.ab-empty-item { padding: 9px !important }
#wpadminbar .quicklinks ul li li div.ab-empty-item {padding-top: 0!important;padding-bottom: 0!important}
#adminmenu, #adminmenuwrap {
  transition: all 0.3s ease-in-out 0s;
  -webkit-transition: all 0.3s ease-in-out 0s;
  -ms-transition: all 0.3s ease-in-out 0s;
  -moz-transition: all 0.3s ease-in-out 0s;
}
.folded #adminmenu, .folded #adminmenu li.menu-top, .folded #adminmenuback, .folded #adminmenuwrap {
    width: 58px;
}
#adminmenu li.wp-has-submenu.wp-not-current-submenu:hover:after {
    top: 14px;
}
#adminmenu .wp-submenu {
  padding: 0;
}
#adminmenu .wp-has-current-submenu ul>li>a, .folded #adminmenu li.menu-top .wp-submenu>li>a, #adminmenu .wp-submenu a {
  padding: 15px 20px;
}
#adminmenu .wp-not-current-submenu li>a, .folded #adminmenu .wp-has-current-submenu li>a {
        padding-left: 20px;
}
#wpbody-content .wrap { margin-top: 20px}
#wp-auth-check-wrap #wp-auth-check {
        width: 450px;
}
.button, .button-primary, .button-secondary { outline: none}
.dashicons, .dashicons-before:before, .wp-menu-image:before {
    display: inline-block;
    width: 20px;
    height: 20px;
    font-size: 20px;
    line-height: 1;
    font-family: dashicons;
    text-decoration: inherit;
    font-weight: 400;
    font-style: normal;
    vertical-align: top;
    text-align: center;
    -webkit-transition: color .1s ease-in 0;
    transition: color .1s ease-in 0;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
  }
.wp-picker-container .wp-color-result.button, .wp-picker-container .wp-color-result.button:hover,
.wp-picker-container .wp-color-result.button:focus {
  border: 1px solid #ccc!important;
}
.icon-picker-container {
  z-index: 999;
}

@media screen and (max-width: 1024px) {
  .tablenav-pages.one-page, .wp-list-table > thead th:not(.column-primary),
  .wp-list-table > tfoot th:not(.column-primary), .wp-list-table tr:not(.inline-edit-row) td:not(.column-primary):not(.check-column) {
    display: none;
  }
}

body.dragging, body.dragging * {
  cursor: move !important;
}
div.manage_admin_menu_sorter {
    width: 700px;
}
div.manage_admin_menu_sorter:after {
        content: "";
        width: 0;
        height: 0;
        display: block;
        clear: both;
}
.manage_admin_menu_sorter ol {
  margin-left: 0;
}
.manage_admin_menu_sorter .menu_title .fa {
  margin-right: 10px;
  opacity: 0.45;
}
ol#menu_sortable_left {
        width: 320px;
        margin-right: 20px
}
ol.sortUls li {
        margin-bottom: 5px;
        display: block;
        cursor: move;
        font-size: 16px;
        line-height:18px;
        position: relative;
        z-index: 6;
}
ol.sortUls li .alter-sort-list {
    background: #f9f9f9;
    border: 1px solid #e7e7e7;
    padding: 14px 15px;
    transition: all 0.3s ease-in-out 0s;
    -webkit-transition: all 0.3s ease-in-out 0s;
    -ms-transition: all 0.3s ease-in-out 0s;
    -moz-transition: all 0.3s ease-in-out 0s;
}
ol.sortUls li .alter-sort-list:hover {
  background: #fff;
}
ol.sortUls li .alter-sort-list .menu-seperator {
  line-height: 1;
  display: inline-block;
  height: 4px;
  width: 94%;
  border-top: 3px solid #e6dbdb;
}
ol.sortUls li.sortable-placeholder {
    border: 1px dashed #dccbcb;
}
ol.sortUls li.sortable-placeholder {
    height: 37px;
    background: none;
    border-left: 3px solid #dccbcb;
    margin: 0 0 0.75rem 0;
    position: relative;
    z-index: 6;
}
.alter-menu-contents ol li .alter-sort-list {
    background: #fff;
}
a.alter-edit-expand {
    display: none;
    position: absolute;
    right: 20px;
    color: #91919E;
    text-decoration: none;
}
a.alter-edit-expand span {
    font-size: 12px;
}
.alter-sort-list:hover > a.alter-edit-expand {
    display: inline-block;
}
form.menu_sort_form {
   clear: both;
}
ol.sortUls li div.menu_edit_content{
    border: 1px solid #e5e5e5;
    border-top: 0;
    z-index: 10;
    -webkit-box-shadow: 0 1px 1px rgba(0,0,0,.04);
    -moz-box-shadow: 0 1px 1px rgba(0,0,0,.04);
    box-shadow: 0 1px 1px rgba(0,0,0,.04);
    padding: 10px;
}
ol.sortUls div.menu_handle{
  padding: 10px 28px;
  position: relative;
  -webkit-box-shadow: 0 1px 1px rgba(0,0,0,.04);
  -moz-box-shadow: 0 1px 1px rgba(0,0,0,.04);
  box-shadow: 0 1px 1px rgba(0,0,0,.04);
}
ol.sortUls li div.menu_edit_content label{
    font-size: 13px;
    font-style: italic;
}
ol.sortUls li a.admin_menu_edit{
    position: absolute;
    right: 7px;
    top: 7px;
    text-decoration: none;
    outline: none;
}
ol.sortUls li .admin_menu_edit:before{
    content: "\f140";
    line-height: 2.1;
    font: 400 20px/1 dashicons;
}
ol.sortUls a.disclose{
    position: absolute;
    left: 5px;
    width: 10px;
    height: 10px;
    display: inline-block;
    outline: none;
    text-decoration: none;
}
ol.sortUls a.plus:before, ol.sortUls a.minus:before{
    line-height: 2.1;
    font: 400 20px/1 dashicons;
}
ol.sortUls a.plus:before{
    content: "\f132";
}
ol.sortUls a.minus:before{
    content: "\f460";
}
ol.sortUls ol {
    margin: 0;
    padding: 10px 0 10px 15px;
}
ol.sortUls ol li {
    background: #fff
}
ol.sortUls li.collapsed > ol {
    display: none;
}

ol.sortUls .alter-menu-contents {
    margin-top: 10px;
    color: #696969;
    position: relative;
    display: none;
}
ol.sortUls .hide-for-roles label {
    display: block;
    padding-top: 10px;
    color: #b5a0a0
}
ol.sortUls .hide-for-roles span {
    padding-right: 5px;
    font-size:0.85em;
}
ol.sortUls .hide-for-roles .hide-for-roles-inputs {
    margin-bottom: 10px;
}
.manage_admin_menu_sorter .select_all, .manage_admin_menu_sorter .select_none {
  display: inline-block;
  margin: 10px 0;
  color: #212121;
  font-size: 0.9em;
}
.manage_admin_menu_sorter .select_all:hover, .manage_admin_menu_sorter .select_none:hover {
  text-decoration: none;
}


div.wps_kb_link {
  padding-top: 10px;
}
div.wps_kb_link a {
  font-size: 12px;
  line-height: 1.2em;
  color: #fff;
  font-weight: 900;
  background: #fa56f9;
  padding: 5px 10px;
  text-decoration: none;
  -webkit-border-radius: 3px;
  border-radius: 3px;
  border-radius: 3px
}

@media only screen and (min-width:782px) and (max-width: 960px) {
  .auto-fold #adminmenu, .auto-fold #adminmenu li.menu-top, .auto-fold #adminmenuback, .auto-fold #adminmenuwrap {
          width: 58px;
  }
  .auto-fold #adminmenu .opensub .wp-submenu, .auto-fold #adminmenu .wp-has-current-submenu .wp-submenu.sub-open, .auto-fold #adminmenu .wp-has-current-submenu a.menu-top:focus+.wp-submenu, .auto-fold #adminmenu .wp-has-current-submenu.opensub .wp-submenu, .auto-fold #adminmenu .wp-submenu.sub-open, .auto-fold #adminmenu a.menu-top:focus+.wp-submenu {
          left: 58px;
  }
  .auto-fold #wpcontent, .auto-fold #wpfooter {
          margin-left: 76px;
  }
}

@media screen and (max-width: 782px){
  ul#wp-admin-bar-root-default, ul.ab-top-menu {
          margin-top: 0;
  }
  .auto-fold #adminmenu, .auto-fold #adminmenuback, .auto-fold #adminmenuwrap {
          width: 190px;
  }
  .auto-fold #adminmenu li.menu-top {
          width: 100%;
  }
  #adminmenu .wp-not-current-submenu .wp-submenu, .folded #adminmenu .wp-has-current-submenu .wp-submenu {
          width: 190px;
  }
  .auto-fold #wpcontent {
          margin-left: 0;
  }
  html.wp-toolbar {
      padding-top: 46px;
  }
  #wpadminbar .quicklinks>ul>li>a {
      padding: 0;
  }
  #wpadminbar .quicklinks>ul>li>a, div.ab-empty-item {
      padding: 0 !important;
  }
  #wpadminbar .quicklinks .ab-empty-item, #wpadminbar .quicklinks a, #wpadminbar .shortlink-input {
          height: 46px;
  }
}

@media screen and (max-width: 600px){
  html.wp-toolbar {
          padding-top: 0;
  }
  div#login {
      width: 90% !important;
  }
}';

$css_styles .= 'html, #wpwrap, #wp-content-editor-tools { background: ' . $this->aof_options['bg_color'] . '; }';
$css_styles .= 'ul#adminmenu a.wp-has-current-submenu:after, ul#adminmenu>li.current>a.current:after { ';
  if(is_rtl()) {
    $css_styles .= 'border-left-color: ' . $this->aof_options['bg_color'];
  }
  else {
    $css_styles .= 'border-right-color: ' . $this->aof_options['bg_color'];
  }
$css_styles .= '}';

/* Headings */
$css_styles .= 'h1 { color: ' . $this->aof_options['h1_color'] . '}';
$css_styles .= 'h2 { color: ' . $this->aof_options['h2_color'] . '}';
$css_styles .= 'h3 { color: ' . $this->aof_options['h3_color'] . '}';
$css_styles .= 'h4 { color: ' . $this->aof_options['h4_color'] . '}';
$css_styles .= 'h5 { color: ' . $this->aof_options['h5_color'] . '}';

/* Admin Bar */
$css_styles .= '#wpadminbar, #wpadminbar .menupop .ab-sub-wrapper, .ab-sub-secondary, #wpadminbar .quicklinks .menupop ul.ab-sub-secondary,
#wpadminbar .quicklinks .menupop ul.ab-sub-secondary .ab-submenu {
  background: ' . $this->aof_options['admin_bar_color'] . '}';
$css_styles .= '#wpadminbar a.ab-item, #wpadminbar>#wp-toolbar span.ab-label, #wpadminbar>#wp-toolbar span.noticon, #wpadminbar .ab-icon:before,
#wpadminbar .ab-item:before {
  color: ' . $this->aof_options['admin_bar_menu_color'] .'}';
$css_styles .= '#wpadminbar .quicklinks .menupop ul li a, #wpadminbar .quicklinks .menupop ul li a strong, #wpadminbar .quicklinks .menupop.hover ul li a,
#wpadminbar.nojs .quicklinks .menupop:hover ul li a {
  color: ' . $this->aof_options['admin_bar_menu_color'] . '; font-size:13px !important }';

if($this->aof_options['design_type'] != 3) {

  $css_styles .= '#wpadminbar .ab-top-menu>li.hover>.ab-item,#wpadminbar.nojq .quicklinks .ab-top-menu>li>.ab-item:focus,
  #wpadminbar:not(.mobile) .ab-top-menu>li:hover>.ab-item,#wpadminbar:not(.mobile) .ab-top-menu>li>.ab-item:focus{
    background: ' . $this->aof_options['admin_bar_menu_bg_hover_color'] . '; color: ' . $this->aof_options['admin_bar_menu_hover_color'] . '}';

}

$css_styles .= '#wpadminbar:not(.mobile)>#wp-toolbar a:focus span.ab-label,#wpadminbar:not(.mobile)>#wp-toolbar li:hover span.ab-label,
#wpadminbar>#wp-toolbar li.hover span.ab-label, #wpadminbar.mobile .quicklinks .hover .ab-icon:before,
#wpadminbar.mobile .quicklinks .hover .ab-item:before, #wpadminbar .quicklinks .menupop .ab-sub-secondary>li .ab-item:focus a,
#wpadminbar .quicklinks .menupop .ab-sub-secondary>li>a:hover {
  color:' . $this->aof_options['admin_bar_menu_hover_color'] .'}';
$css_styles .= '#wpadminbar .quicklinks .ab-sub-wrapper .menupop.hover>a,#wpadminbar .quicklinks .menupop ul li a:focus,
#wpadminbar .quicklinks .menupop ul li a:focus strong,#wpadminbar .quicklinks .menupop ul li a:hover,
#wpadminbar .quicklinks .menupop ul li a:hover strong,#wpadminbar .quicklinks .menupop.hover ul li a:focus,
#wpadminbar .quicklinks .menupop.hover ul li a:hover,#wpadminbar li #adminbarsearch.adminbar-focused:before,
#wpadminbar li .ab-item:focus:before,#wpadminbar li a:focus .ab-icon:before,#wpadminbar li.hover .ab-icon:before,
#wpadminbar li.hover .ab-item:before,#wpadminbar li:hover #adminbarsearch:before,#wpadminbar li:hover .ab-icon:before,
#wpadminbar li:hover .ab-item:before,#wpadminbar.nojs .quicklinks .menupop:hover ul li a:focus,
#wpadminbar.nojs .quicklinks .menupop:hover ul li a:hover, #wpadminbar .quicklinks .ab-sub-wrapper .menupop.hover>a .blavatar,
#wpadminbar .quicklinks li a:focus .blavatar,#wpadminbar .quicklinks li a:hover .blavatar{
  color: ' . $this->aof_options['admin_bar_menu_hover_color'] .'}';
$css_styles .= '#wpadminbar .menupop .ab-sub-wrapper, #wpadminbar .shortlink-input {
  background: ' . $this->aof_options['admin_bar_menu_bg_hover_color'] . '}';

$css_styles .= '#wpadminbar .ab-submenu .ab-item, #wpadminbar .quicklinks .menupop ul.ab-submenu li a,
#wpadminbar .quicklinks .menupop ul.ab-submenu li a.ab-item {
  color: '. $this->aof_options['admin_bar_sbmenu_link_color'] . '}';
$css_styles .= '#wpadminbar .ab-submenu .ab-item:hover, #wpadminbar .quicklinks .menupop ul.ab-submenu li a:hover,
#wpadminbar .quicklinks .menupop ul.ab-submenu li a.ab-item:hover {
  color: ' . $this->aof_options['admin_bar_sbmenu_link_hover_color'] . '}';

/* Site logo and title */
$css_styles .= '.quicklinks li.wpshapere_site_title {';
if($this->aof_options['logo_top_margin'] != 0)
  $css_styles .= 'margin-top:-' . $this->aof_options['logo_top_margin'] . 'px !important;';
if($this->aof_options['logo_bottom_margin'] != 0)
  $css_styles .= 'margin-top:' . $this->aof_options['logo_bottom_margin'] . 'px !important;';
$css_styles .= '}';
$css_styles .= '.quicklinks li.wpshapere_site_title a{outline:none; border:none;}';

if(!empty($this->aof_options['adminbar_external_logo_url']) && filter_var($this->aof_options['adminbar_external_logo_url'], FILTER_VALIDATE_URL)) {
  $adminbar_logo = esc_url( $this->aof_options['adminbar_external_logo_url']);
}
else {
  $adminbar_logo = (is_numeric($this->aof_options['admin_logo'])) ? $this->get_wps_image_url($this->aof_options['admin_logo']) : $this->aof_options['admin_logo'];
}

$logo_v_margins = '4px';
if(isset($this->aof_options['logo_bottom_margin']) && $this->aof_options['logo_bottom_margin'] != 0) {
  $logo_v_margins = $this->aof_options['logo_bottom_margin'] . 'px';
}
elseif(isset($this->aof_options['logo_top_margin']) && $this->aof_options['logo_top_margin'] != 0) {
  $logo_v_margins = '-' . $this->aof_options['logo_top_margin'] . 'px';
}
$logo_l_margins = 'left';
if(isset($this->aof_options['logo_left_margin']) && $this->aof_options['logo_left_margin'] != 0) {
  $logo_l_margins = $this->aof_options['logo_left_margin'] . 'px';
}

$css_styles .= '.quicklinks li.wpshapere_site_title a, .quicklinks li.wpshapere_site_title a:hover, .quicklinks li.wpshapere_site_title a:focus {';
if(!empty($adminbar_logo)){
  $css_styles .= 'background:url(' . $adminbar_logo . ') ' . $logo_l_margins . ' ' . $logo_v_margins . ' no-repeat !important; text-indent:-9999px !important; width: auto;';
}
if($this->aof_options['adminbar_logo_resize'] == 1 && $this->aof_options['adminbar_logo_size_percent'] > 1) {
  $css_styles .= 'background-size:' . $this->aof_options['adminbar_logo_size_percent'] . '%!important;';
}
else $css_styles .= 'background-size:contain!important;';
$css_styles .= '}';

/* Buttons */
$css_styles .= '.wp-core-ui .button,.wp-core-ui .button-secondary{
  color: '. $this->aof_options['sec_button_text_color'] . ';background: '. $this->aof_options['sec_button_color'] . '}';
$css_styles .= '.wp-core-ui .button-secondary:focus, .wp-core-ui .button-secondary:hover, .wp-core-ui .button.focus,
.wp-core-ui .button.hover, .wp-core-ui .button:focus, .wp-core-ui .button:hover {
  color: '. $this->aof_options['sec_button_hover_text_color'] . ';background: '. $this->aof_options['sec_button_hover_color'] . '}';
$css_styles .= '.wp-core-ui .button-primary, .wp-core-ui .button-primary-disabled, .wp-core-ui .button-primary.disabled,
.wp-core-ui .button-primary:disabled, .wp-core-ui .button-primary[disabled] {
  background: ' . $this->aof_options['pry_button_color'] . '!important; color: '. $this->aof_options['pry_button_text_color'] . '!important;text-shadow: none;}';
$css_styles .= '.wp-core-ui .button-primary.focus, .wp-core-ui .button-primary.hover, .wp-core-ui .button-primary:focus,
.wp-core-ui .button-primary:hover, .wp-core-ui .button-primary.active,.wp-core-ui .button-primary.active:focus,
.wp-core-ui .button-primary.active:hover,.wp-core-ui .button-primary:active {
  background: ' . $this->aof_options['pry_button_hover_color'] . '!important;color: ' . $this->aof_options['pry_button_hover_text_color'] . '!important}';

/* Left Menu */
if(isset($this->aof_options['admin_menu_width']) && !empty($this->aof_options['admin_menu_width'])) {
    $admin_menu_width = $this->aof_options['admin_menu_width'];
    $wp_content_margin = $admin_menu_width + 20;

    $css_styles .= '#adminmenu, #adminmenu .wp-submenu, #adminmenuback, #adminmenuwrap {
            width: ' . $admin_menu_width . 'px}';
    $css_styles .= '#wpcontent, #wpfooter {';
      if(is_rtl()) {
        $css_styles .= 'margin-right: '. $wp_content_margin . 'px';
      } else {
        $css_styles .= 'margin-left: '. $wp_content_margin . 'px';
      $css_styles .= '}';
    }
    $css_styles .= '#adminmenu .wp-submenu {';
      if(is_rtl())
        $css_styles .= 'right:' . $admin_menu_width . 'px';
      else $css_styles .= 'left:' . $admin_menu_width . 'px';
    $css_styles .= '}';
    $css_styles .= '.quicklinks li.wpshapere_site_title {
            width:'. $admin_menu_width . 'px !important}';
}
else {
      $css_styles .= '#adminmenu, #adminmenu .wp-submenu, #adminmenuback, #adminmenuwrap {
        width: 200px;
      }
    #wpcontent, #wpfooter {';
      if(is_rtl())
        $css_styles .= 'margin-right:220px';
      else $css_styles .= 'margin-left:220px';
    $css_styles .= '}';

    $css_styles .= '#adminmenu .wp-submenu {';
      if(is_rtl())
        $css_styles .= 'right: 200px';
      else $css_styles .= 'left:200px';
    $css_styles .= '}';

    $css_styles .= '.quicklinks li.wpshapere_site_title {
        width: 200px !important;
    }';
}

$css_styles .= '#adminmenuback, #adminmenuwrap, #adminmenu { background: '. $this->aof_options['nav_wrap_color'] .'}';
$css_styles .= '#adminmenu div.wp-menu-image:before, #adminmenu a, #collapse-menu, #collapse-button div:after {
  color:'. $this->aof_options['nav_text_color'] .'}';
$css_styles .= '#adminmenu li a:focus div.wp-menu-image:before, #adminmenu li.opensub div.wp-menu-image:before,
#adminmenu li:hover div.wp-menu-image:before, #adminmenu .opensub .wp-submenu li.current a,
#adminmenu .wp-submenu li.current, #adminmenu a.wp-has-current-submenu:focus+.wp-submenu li.current a {
  color:'. $this->aof_options['menu_hover_text_color'] .'}';

$css_styles .= '#adminmenu li.menu-top:hover, #adminmenu li.menu-top a:hover, #adminmenu li.opensub>a.menu-top, #adminmenu li>a.menu-top:focus {
  background: '. $this->aof_options['hover_menu_color'] .'; color: '. $this->aof_options['menu_hover_text_color'] .'}';

/* Sub menu */
$css_styles .= '#adminmenu .wp-submenu a, #adminmenu li.menu-top .wp-submenu a {
  color:'. $this->aof_options['sub_nav_text_color'] . '}';

$css_styles .= '#adminmenu .wp-submenu a:focus, #adminmenu .wp-submenu a:hover,
#adminmenu li.menu-top .wp-submenu a:hover {
  background: '. $this->aof_options['sub_nav_hover_color'] .'; color: '. $this->aof_options['sub_nav_hover_text_color'] . '}';

$css_styles .= '#adminmenu .wp-submenu-head, #adminmenu a.menu-top {';
  if(is_rtl())
    $css_styles .= 'padding: 5px 10px 5px 0';
  else $css_styles .= 'padding: 5px 0 5px 10px';
$css_styles .= '}';
$css_styles .= '.folded #wpcontent, .folded #wpfooter {';
  if(is_rtl())
    $css_styles .= 'margin-right: ';
  else $css_styles .= 'margin-left: ';
$css_styles .= '78px;}';

$css_styles .= '.folded #adminmenu .opensub .wp-submenu, .folded #adminmenu .wp-has-current-submenu .wp-submenu.sub-open,
.folded #adminmenu .wp-has-current-submenu a.menu-top:focus+.wp-submenu,
.folded #adminmenu .wp-has-current-submenu.opensub .wp-submenu, .folded #adminmenu .wp-submenu.sub-open,
.folded #adminmenu a.menu-top:focus+.wp-submenu, .no-js.folded #adminmenu .wp-has-submenu:hover .wp-submenu {';
  if(is_rtl())
    $css_styles .= 'right: 58px';
  else $css_styles .= 'left: 58px';
$css_styles .= '}';

$css_styles .= '#adminmenu li.wp-has-current-submenu a.wp-has-current-submenu, #adminmenu li.current a.menu-top,
.folded #adminmenu li.wp-has-current-submenu, .folded #adminmenu li.current.menu-top, #adminmenu .wp-menu-arrow,
#adminmenu .wp-has-current-submenu .wp-submenu .wp-submenu-head, #adminmenu .wp-menu-arrow div {
  background: '. $this->aof_options['active_menu_color'] .'}';

$css_styles .= '#adminmenu li.wp-has-current-submenu > a.menu-top, #adminmenu li.wp-has-current-submenu div.wp-menu-image:before,
#adminmenu li.wp-has-current-submenu:hover > a.menu-top, #adminmenu .current div.wp-menu-image:before, #adminmenu .wp-has-current-submenu div.wp-menu-image:before,
#adminmenu a.current:hover div.wp-menu-image:before, #adminmenu a.wp-has-current-submenu:hover div.wp-menu-image:before,
#adminmenu li.wp-has-current-submenu a:focus div.wp-menu-image:before, #adminmenu li.wp-has-current-submenu.opensub div.wp-menu-image:before,
#adminmenu li.wp-has-current-submenu:hover div.wp-menu-image:before {
  color: '. $this->aof_options['menu_active_text_color'] . '}';

$css_styles .= '#adminmenu .wp-has-current-submenu .wp-submenu, .no-js li.wp-has-current-submenu:hover .wp-submenu,
#adminmenu a.wp-has-current-submenu:focus+.wp-submenu, #adminmenu .wp-has-current-submenu .wp-submenu.sub-open,
#adminmenu .wp-has-current-submenu.opensub .wp-submenu, #adminmenu .wp-not-current-submenu .wp-submenu,
.folded #adminmenu .wp-has-current-submenu .wp-submenu{
  background:'. $this->aof_options['sub_nav_wrap_color'] . '}';

$css_styles .= '#adminmenu .wp-submenu li.current a:focus, #adminmenu li.menu-top .wp-submenu li.current a:hover,
#adminmenu a.wp-has-current-submenu:focus+.wp-submenu li.current a, #adminmenu .opensub .wp-submenu li.current a, #adminmenu .wp-submenu li.current,
#adminmenu li.menu-top .wp-submenu li.current a, #adminmenu li.menu-top .wp-submenu li.current a:focus, #adminmenu li.menu-top .wp-submenu li.current a:hover,
#adminmenu a.wp-has-current-submenu:focus+.wp-submenu li.current a {
  color:'. $this->aof_options['submenu_active_text_color'] . '}';

$css_styles .= '#adminmenu li.wp-has-submenu.wp-not-current-submenu.opensub:hover:after {';
  if(is_rtl())
    $css_styles .= 'border-left-color: ';
  else $css_styles .= 'border-right-color: ';
$css_styles .= $this->aof_options['sub_nav_wrap_color'] .'}';
$css_styles .= '#adminmenu .awaiting-mod, #adminmenu .update-plugins,
#sidemenu li a span.update-plugins, #adminmenu li a.wp-has-current-submenu .update-plugins {
  background-color:'. $this->aof_options['menu_updates_count_bg'] .'; color: '. $this->aof_options['menu_updates_count_text'] . '}';

$css_styles .= '#adminmenu .wp-menu-image img { padding: 6px 0 0 }';

/* Metabox handles */
$css_styles .= '.menu.ui-sortable .menu-item-handle, .meta-box-sortables.ui-sortable .hndle,
.sortUls div.menu_handle, .wp-list-table thead, .menu-item-handle, .widget .widget-top {
  background:'. $this->aof_options['metabox_h3_color'] .';
  border: 1px solid ' . $this->aof_options['metabox_h3_border_color'] .';
  color: '. $this->aof_options['metabox_text_color'] . '}';
$css_styles .= '.postbox .hndle { border: none !important}';
$css_styles .= 'ol.sortUls a.plus:before, ol.sortUls a.minus:before {
  color:'. $this->aof_options['metabox_handle_color'] .'}';
$css_styles .= '.postbox .accordion-section-title:after, .handlediv, .item-edit,
.sidebar-name-arrow, .widget-action, .sortUls a.admin_menu_edit {
  color:'. $this->aof_options['metabox_handle_color'] .'}';
$css_styles .= '.postbox .accordion-section-title:hover:after, .handlediv:hover,
.item-edit:hover, .sidebar-name:hover .sidebar-name-arrow, .widget-action:hover,
.sortUls a.admin_menu_edit:hover {
  color:'. $this->aof_options['metabox_handle_hover_color'] .'}';
$css_styles .= '.wp-list-table thead tr th, .wp-list-table thead tr th a, .wp-list-table thead tr th:hover,
.wp-list-table thead tr th a:hover, span.sorting-indicator:before, span.comment-grey-bubble:before,
.ui-sortable .item-type {
  color:'. $this->aof_options['metabox_text_color'] .'}';

/* Add new buttons */
$css_styles .= '.wrap .add-new-h2, .wrap .add-new-h2:active {
  background-color:'. $this->aof_options['addbtn_bg_color'] .';
  color:'. $this->aof_options['addbtn_text_color'] .'}';
$css_styles .= '.wrap .add-new-h2:hover {
  background-color:'. $this->aof_options['addbtn_hover_bg_color'] .';
  color:'. $this->aof_options['addbtn_hover_text_color'] . '}';

/* Message box */
$css_styles .= 'div.updated, #update-nag, .update-nag {
  border-left: 4px solid '. $this->aof_options['msgbox_border_color'] .';
  background-color:'. $this->aof_options['msg_box_color'] .';
  color:'. $this->aof_options['msgbox_text_color'] .'}';
$css_styles .= 'div.updated #bulk-titles div a:before, .notice-dismiss:before,
.tagchecklist span a:before, .welcome-panel .welcome-panel-close:before {
  background:'. $this->aof_options['msg_box_color'] .';
  color:'. $this->aof_options['msgbox_text_color'] .'}';
$css_styles .= 'div.updated a, #update-nag a, .update-nag a {
  color:'. $this->aof_options['msgbox_link_color'] . '}';
$css_styles .= 'div.updated a:hover, #update-nag a:hover, .update-nag a:hover {
  color:'. $this->aof_options['msgbox_link_hover_color'] . '}';

if($this->aof_options['hide_update_note_plugins'] == 1) {
  $css_styles .= '.plugin-update-tr { display:none}';
}

if($this->aof_options['design_type'] == 1 || $this->aof_options['design_type'] == 3) {
  $css_styles .= '.wp-core-ui .button-primary, #wpadminbar, .postbox,.wp-core-ui .button-primary.focus,
  .wp-core-ui .button-primary.hover, .wp-core-ui .button-primary:focus, .wp-core-ui .button-primary:hover,
  .wp-core-ui .button, .wp-core-ui .button-secondary, .wp-core-ui .button-secondary:focus,
  .wp-core-ui .button-secondary:hover, .wp-core-ui .button.focus, .wp-core-ui .button.hover,
  .wp-core-ui .button:focus, .wp-core-ui .button:hover, #wpadminbar .menupop .ab-sub-wrapper,
  #wpadminbar .shortlink-input, .theme-browser .theme {
  	-webkit-box-shadow: none !important;
  	-moz-box-shadow: none !important;
  	box-shadow: none !important;
  	border: none !important;
    text-shadow: none !important;
  }
  input[type=checkbox], input[type=radio], #update-nag, .update-nag, .wp-list-table, .widefat, input[type=email],
  input[type=number], input[type=password], input[type=search], input[type=tel], input[type=text],
  input[type=url], select, textarea, #adminmenu .wp-submenu, .folded #adminmenu .wp-has-current-submenu .wp-submenu,
  .folded #adminmenu a.wp-has-current-submenu:focus+.wp-submenu, .mce-toolbar .mce-btn-group .mce-btn.mce-listbox,
  .wp-color-result, .widget-top, .widgets-holder-wrap {
  	-webkit-box-shadow: none !important;
  	-moz-box-shadow: none !important;
  	box-shadow: none !important;
  }
  body #dashboard-widgets .postbox form .submit { padding: 10px 0 !important; }';
}

/* Styles for New excite design */

if($this->aof_options['design_type'] == 3) {

  $css_styles .= '#adminmenuwrap{-webkit-box-shadow: 0px 4px 16px 0px rgba(0,0,0,0.3);
-moz-box-shadow: 0px 4px 16px 0px rgba(0,0,0,0.3);
box-shadow: 0px 4px 16px 0px rgba(0,0,0,0.3);}
ul#adminmenu a.wp-has-current-submenu:after, ul#adminmenu>li.current>a.current:after{
  border-right-color:transparent;
}
';

  $css_styles .= '#wpadminbar * .ab-sub-wrapper {
  	transition: all 280ms cubic-bezier(.4,0,.2,1) !important;
  }
  #wp-toolbar > ul > li > .ab-sub-wrapper {
      -webkit-transform: scale(.25,0);
      transform: scale(.25,0);
      -webkit-transition: all 280ms cubic-bezier(.4,0,.2,1);
      transition: all 280ms cubic-bezier(.4,0,.2,1);
      -webkit-transform-origin: 50% 0 !important;
      transform-origin: 50% 0 !important;
      display: block !important;
      opacity: 0 !important;
  }

  #wp-toolbar > ul > li.hover > .ab-sub-wrapper {
      -webkit-transform: scale(1,1);
      transform: scale(1,1);
      opacity: 1 !important;
  }

  #wp-toolbar > ul > li > .ab-sub-wrapper:before {
      position: absolute;
      top: -8px;
      left: 20%;
      content: "";
      display: block;
      border: 6px solid transparent;
      border-bottom-color: transparent;
      border-bottom-color: ' . $this->aof_options['admin_bar_menu_bg_hover_color'] . ';
      transition: all 0.2s ease-in-out;
      -moz-transition: all 0.2s ease-in-out;
      -webkit-transition: all 0.2s ease-in-out;
  }

  #wp-toolbar > ul > li.hover > .ab-sub-wrapper:before {
  	top: -12px;
  }';

  $css_styles .= '#wp-toolbar > ul > li#wp-admin-bar-my-account > .ab-sub-wrapper:before{left:60%}';

  $css_styles .= '#wpadminbar .ab-top-menu>li.hover>.ab-item,#wpadminbar.nojq .quicklinks .ab-top-menu>li>.ab-item:focus,
  #wpadminbar:not(.mobile) .ab-top-menu>li:hover>.ab-item,#wpadminbar:not(.mobile) .ab-top-menu>li>.ab-item:focus{
    background: ' . $this->aof_options['admin_bar_color'] . '; color: ' . $this->aof_options['admin_bar_menu_color'] . '}';

}

if($this->aof_options['design_type'] == 2) {
  $css_styles .= '.wp-core-ui .button,.wp-core-ui .button-secondary {
    border-color: ' . $this->aof_options['sec_button_border_color'] . ';
    -webkit-box-shadow:inset 0 1px 0 ' . $this->aof_options['sec_button_shadow_color'] . ',0 1px 0 rgba(0,0,0,.08);
    box-shadow:inset 0 1px 0 ' . $this->aof_options['sec_button_shadow_color'] . ',0 1px 0 rgba(0,0,0,.08);}';
  $css_styles .= '.wp-core-ui .button-secondary:focus, .wp-core-ui .button-secondary:hover, .wp-core-ui .button.focus,
  .wp-core-ui .button.hover, .wp-core-ui .button:focus, .wp-core-ui .button:hover {
    border-color: ' . $this->aof_options['sec_button_hover_border_color'] . ';
    -webkit-box-shadow:inset 0 1px 0 '. $this->aof_options['sec_button_hover_shadow_color'] . ',0 1px 0 rgba(0,0,0,.08);
    box-shadow:inset 0 1px 0 '. $this->aof_options['sec_button_hover_shadow_color'] .',0 1px 0 rgba(0,0,0,.08);}';
  $css_styles .= '.wp-core-ui .button-primary, .wp-core-ui .button-primary-disabled,
  .wp-core-ui .button-primary.disabled, .wp-core-ui .button-primary:disabled, .wp-core-ui .button-primary[disabled] {
    border-color:'. $this->aof_options['pry_button_border_color'] .'!important;
    -webkit-box-shadow:inset 0 1px 0 '. $this->aof_options['pry_button_shadow_color'] . ',0 1px 0 rgba(0,0,0,.15) !important;
    box-shadow: inset 0 1px 0 '. $this->aof_options['pry_button_shadow_color'] .', 0 1px 0 rgba(0,0,0,.15) !important;}';
  $css_styles .= '.wp-core-ui .button-primary.focus, .wp-core-ui .button-primary.hover,
  .wp-core-ui .button-primary:focus, .wp-core-ui .button-primary:hover, .wp-core-ui .button-primary.active,
  .wp-core-ui .button-primary.active:focus,.wp-core-ui .button-primary.active:hover,.wp-core-ui .button-primary:active {
    border-color:'. $this->aof_options['pry_button_hover_border_color'] .'!important;
    -webkit-box-shadow:inset 0 1px 0 '. $this->aof_options['pry_button_hover_shadow_color'] .',0 1px 0 rgba(0,0,0,.15) !important;
    box-shadow: inset 0 1px 0 '. $this->aof_options['pry_button_hover_shadow_color'] .',0 1px 0 rgba(0,0,0,.15) !important;}';
  $css_styles .= '}';
}

$css_styles .= $this->aof_options['admin_page_custom_css'];
$css_styles .= '</style>';

echo $this->wps_compress_css($css_styles);
