<?php
/**
 * @Package: WordPress Plugin
 * @Subpackage: Ultra WordPress Admin Theme
 * @Since: Ultra 1.0
 * @WordPress Version: 4.0 or above
 * This file is part of Ultra WordPress Admin Theme Plugin.
 */
?>
<?php

/*---------------------------------------------
  Typography
 ---------------------------------------------*/

/* -------------------- Fonts -------------------- */
$ultra_fonts = ultra_css_fonts();

$ultrastr = " h1,h2,h3,h4,h5,h6, "
			.".postbox .hndle, .stuffbox .hndle, "
			."#delete-action, "
			."#dashboard-widgets #dashboard_activity h4, "
			.".welcome-panel h2, .welcome-panel .about-description,"
			."#titlediv #title,"
			.".widefat tfoot tr th, .widefat thead tr th, th.manage-column a, th.sortable a,"
			.".form-wrap label,"
			.".theme-browser .theme .theme-name, .theme-browser .theme .more-details, "
			.".no-plugin-results , .no-plugin-results a,"
			.".form-table th, #ws_menu_editor .ws_item_title,"
			."#ws_menu_editor .ws_edit_field, .settings_page_menu_editor .ui-dialog-title";
echo $ultrastr."{".$ultra_fonts['head_font_css']."}";


$ultrastr = " body, p, "
		   ."#activity-widget #the-comment-list .comment-item h4,"
		   ."#wpadminbar, .ws_edit_field-colors .ws_color_scheme_display, "
		   ."#ws_menu_editor .ws_main_container .ws_edit_field input, #ws_menu_editor .ws_main_container .ws_edit_field select, #ws_menu_editor .ws_main_container .ws_edit_field textarea";
echo $ultrastr."{".$ultra_fonts['body_font_css']."}";

$ultrastr = " #adminmenu .wp-submenu-head, #adminmenu a.menu-top, "
			."#adminmenu .wp-has-current-submenu ul>li>a, .folded #adminmenu li.menu-top .wp-submenu>li>a, "
			."#adminmenu .wp-not-current-submenu li>a, .folded #adminmenu .wp-has-current-submenu li>a,"
			."#collapse-menu";
echo $ultrastr."{".$ultra_fonts['menu_font_css']."}";


$ultrastr = " .wp-core-ui .button, .wp-core-ui .button-secondary,"
			.".wp-core-ui .button-primary,"
			.".upload-plugin .install-help, .upload-theme .install-help,"
			.".wordfenceWrap input[type='button'], .wordfenceWrap input[type='submit']";
echo $ultrastr."{".$ultra_fonts['button_font_css']."}";











/*---------------------------------------------
  Layout & Typography Section
 ---------------------------------------------*/

echo " \n/* -- Page BG -- */\n";
echo ultra_css_background("html, #ws_menu_editor .ws_editbox", "page-bg", "1.0") . "\n";


echo " \n/* -- Heading -- */\n";
$ultrastr = " h1,h2,h3,h4,h5,h6, .wrap h2, .wrap h1 , .welcome-panel .about-description";
echo ultra_css_color($ultrastr, "heading-color", "1.0") . "\n";


echo " \n/* -- body text -- */\n";
$ultrastr = " body, p,"
			."#dashboard_right_now li a:before, #dashboard_right_now li span:before, .welcome-panel .welcome-icon:before,"
			."#misc-publishing-actions label[for=post_status]:before, #post-body #visibility:before, #post-body .misc-pub-revisions:before, .curtime #timestamp:before, span.wp-media-buttons-icon:before,"
			.".misc-pub-section, input[type=radio]:checked+label:before, .view-switch>a:before,"
			.".no-plugin-results , .no-plugin-results a,"
			.".upload-plugin .install-help, .upload-theme .install-help,"
			.".form-wrap p, p.description,"
			."#screen-meta-links a, .contextual-help-tabs .active a";
echo ultra_css_color($ultrastr, "body-text-color", "1.0") . "\n";


echo " \n/* -- link color -- */\n";
echo ultra_link_color("a, .no-plugin-results a", "link-color") . "\n";
 

/*---------------------------------------------
  Logo
 ---------------------------------------------*/

//echo ultra_logo();

/*---------------------------------------------
  Primary Color - Pick theme
 ---------------------------------------------*/

echo " \n/* -- primary -- */\n";

$primary_color_str = ".nav-tab, .nav-tab-active, .nav-tab-active:hover , .nav-tab:hover, input[type=checkbox]:checked:before,"
					."a.post-format-icon:hover:before, a.post-state-format:hover:before,"
					.".view-switch a.current:before,"
					.".theme-browser .theme.add-new-theme:focus span:after, .theme-browser .theme.add-new-theme:hover span:after,"
					.".theme-browser .theme.add-new-theme span:after,"
					.".nav-tab-active, .nav-tab-active:hover,"
					.".filter-links .current,"
					.".filter-links li>a:focus, .filter-links li>a:hover, .show-filters .filter-links a.current:focus, .show-filters .filter-links a.current:hover,"
					.".upload-plugin .wp-upload-form .button,"
					.".upload-plugin .wp-upload-form .button:disabled";
echo ultra_css_color($primary_color_str, "primary-color", "1.0") . "\n";



$primary_bgcolor_str = ".highlight, .highlight a, input[type=radio]:checked:before,"
					  ."#edit-slug-box .edit-slug.button, #edit-slug-box #view-post-btn .button,"
					  .".post-com-count:hover:after, .post-com-count:hover span,"
					  .".tablenav .tablenav-pages a:focus, .tablenav .tablenav-pages a:hover,"
					  .".media-item .bar,"
					  .".theme-browser .theme .more-details,"
					  .".theme-browser .theme.add-new-theme:focus:after, .theme-browser .theme.add-new-theme:hover:after,"
					  .".widgets-chooser li.widgets-chooser-selected,"
					  .".plugin-card .plugin-card-bottom,"
					  .".pace .pace-progress, #ws_menu_editor a.ws_button:hover,"
					  ."#ws_menu_editor .ws_main_container .ws_container";
echo ultra_css_bgcolor($primary_bgcolor_str, "primary-color", "1.0") . "\n";

$primary_border_str = "input[type=checkbox]:focus, input[type=color]:focus, input[type=date]:focus, input[type=datetime-local]:focus, input[type=datetime]:focus, input[type=email]:focus, input[type=month]:focus, input[type=number]:focus, input[type=password]:focus, input[type=radio]:focus, input[type=search]:focus, input[type=tel]:focus, input[type=text]:focus, input[type=time]:focus, input[type=url]:focus, input[type=week]:focus, select:focus, textarea:focus,"
					 ."input[type=checkbox]:hover, input[type=color]:hover, input[type=date]:hover, input[type=datetime-local]:hover, input[type=datetime]:hover, input[type=email]:hover, input[type=month]:hover, input[type=number]:hover, input[type=password]:hover, input[type=radio]:hover, input[type=search]:hover, input[type=tel]:hover, input[type=text]:hover, input[type=time]:hover, input[type=url]:hover, input[type=week]:hover, select:hover, textarea:hover,"
					 ."#titlediv #title:focus, #titlediv #title:hover,"
					 .".attachment-preview .thumbnail:hover,"
					 .".media-frame.mode-grid .attachment.details:focus .attachment-preview,"
					 .".media-frame.mode-grid .attachment:focus .attachment-preview,"
					 .".media-frame.mode-grid .selected.attachment:focus .attachment-preview,"
					 .".drag-drop.drag-over #drag-drop-area,"
					 .".theme-browser .theme:focus,"
					 ."#available-widgets .widget-top:hover, #widgets-left .widget-in-question .widget-top, #widgets-left .widget-top:hover, .widgets-chooser ul, div#widgets-right .widget-top:hover,"
					 .".widget-inside, .widget.open .widget-top, div#widgets-right .widgets-holder-wrap.widget-hover,"
					 .".filter-links .current,"
					 .".plugin-card:hover,"
					 .".contextual-help-tabs .active";
echo ultra_css_border_color($primary_border_str, "primary-color", "1.0","all") . "\n";
echo ".has-dfw .quicktags-toolbar{border-color:".$ultraadmin['primary-color']." !important;}";


$primary_border_bottom = "div.mce-toolbar-grp>div, .plugin-install-php .wp-filter, #ws_menu_editor .ws_main_container .ws_toolbar";
echo ultra_css_border_color($primary_border_bottom, "primary-color", "1.0","bottom") . "\n";

$primary_border_top = ".post-com-count:hover:after";
echo ultra_css_border_color($primary_border_top, "primary-color", "1.0","top") . "\n";

$primary_border_left = ".plugins .active th.check-column";
echo ultra_css_border_color($primary_border_left, "primary-color", "1.0","left") . "\n";


echo "#wp-fullscreen-buttons .mce-btn:focus, #wp-fullscreen-buttons .mce-btn:hover, .mce-toolbar .mce-btn-group .mce-btn:focus, .mce-toolbar .mce-btn-group .mce-btn:hover, .qt-fullscreen:focus, .qt-fullscreen:hover,"
	.".wrap .add-new-h2:hover, .wrap .page-title-action:hover { "
	."background: ".$ultraadmin['primary-color']." !important;"
	."border-color: ".$ultraadmin['primary-color']." !important;"
	."color: ".$ultraadmin['button-text-color']." !important;"
	."}";

echo ".wrap .add-new-h2, .wrap .page-title-action{"
	."background: ".$ultraadmin['button-secondary-bg']." !important"
	."color: ".$ultraadmin['button-text-color']." !important;"
	."}";


echo ".toplevel_page__ultraoptions #redux-header{border-color:".$ultraadmin['primary-color']." !important;background-color:".$ultraadmin['primary-color']." !important;}";






/*----------Media library - bug fix ------------*/
echo "

.media-progress-bar div{
	background-color: ".$ultraadmin['primary-color'].";
}

.media-modal-content .attachment.details {
	-webkit-box-shadow: inset 0 0 0 3px #fff,inset 0 0 0 7px ".$ultraadmin['primary-color'].";
	box-shadow: inset 0 0 0 3px #fff,inset 0 0 0 7px ".$ultraadmin['primary-color'].";
	-moz-box-shadow: inset 0 0 0 3px #fff,inset 0 0 0 7px ".$ultraadmin['primary-color'].";
	-ms-box-shadow: inset 0 0 0 3px #fff,inset 0 0 0 7px ".$ultraadmin['primary-color'].";
	-o-box-shadow: inset 0 0 0 3px #fff,inset 0 0 0 7px ".$ultraadmin['primary-color'].";
}

.media-modal-content .attachments .attachment:focus{
	-webkit-box-shadow: inset 0 0 0 3px #fff,inset 0 0 0 7px ".$ultraadmin['primary-color'].";
	box-shadow: inset 0 0 0 3px #fff,inset 0 0 0 7px ".$ultraadmin['primary-color'].";
	-ms-box-shadow: inset 0 0 0 3px #fff,inset 0 0 0 7px ".$ultraadmin['primary-color'].";
	-moz-box-shadow: inset 0 0 0 3px #fff,inset 0 0 0 7px ".$ultraadmin['primary-color'].";
	-o-box-shadow: inset 0 0 0 3px #fff,inset 0 0 0 7px ".$ultraadmin['primary-color'].";
}

.wp-core-ui .attachment.details .check, .wp-core-ui .attachment.selected .check:focus, .wp-core-ui .media-frame.mode-grid .attachment.selected .check,
.attachment.details .check, .attachment.selected .check:focus, .media-frame.mode-grid .attachment.selected .check {
	background-color: ".$ultraadmin['primary-color'].";
	-webkit-box-shadow: 0 0 0 1px #fff,0 0 0 2px ".$ultraadmin['primary-color'].";
	box-shadow: 0 0 0 1px #fff,0 0 0 2px ".$ultraadmin['primary-color'].";
	-moz-box-shadow: 0 0 0 1px #fff,0 0 0 2px ".$ultraadmin['primary-color'].";
	-ms-box-shadow: 0 0 0 1px #fff,0 0 0 2px ".$ultraadmin['primary-color'].";
	-o-box-shadow: 0 0 0 1px #fff,0 0 0 2px ".$ultraadmin['primary-color'].";
}";




/*------------------ RTL ----------------------*/

echo ".rtl .folded #adminmenu li.menu-top .wp-submenu>li>a:hover, 
.rtl #adminmenu .wp-submenu a:focus, 
.rtl #adminmenu .wp-submenu a:hover, 
.rtl #adminmenu .wp-submenu li.current a, 
.rtl #adminmenu .wp-submenu li.current a:hover,
.rtl .folded #adminmenu li.menu-top .wp-submenu>li>a:hover, 
.rtl #adminmenu .wp-submenu a:focus, 
.rtl #adminmenu .wp-submenu a:hover, 
.rtl #adminmenu .wp-submenu li.current a, 
.rtl #adminmenu .wp-submenu li.current a:hover,
.rtl .plugins .active th.check-column,
.rtl #wpadminbar .quicklinks .menupop.hover ul li a:hover,
.rtl .contextual-help-tabs .active
{
	border-right-color: ".$ultraadmin['primary-color'].";
}



";


echo " #ws_menu_editor.ws_is_actor_view .ws_is_hidden_for_actor{background-color: ".$ultraadmin['primary-color']." !important;}";
echo " #ws_menu_editor.ws_is_actor_view .ws_is_hidden_for_actor.ws_active{background-color: ".$ultraadmin['box-head-bg']['background-color']." !important;}";










/*---------------------------------------------
  Menu Section
 ---------------------------------------------*/

echo " \n/* -- Menu BG -- */\n";
$ultrastr = " #adminmenu, #adminmenu .wp-submenu, #adminmenuback, #adminmenuwrap,"
		   ."#adminmenu .wp-has-current-submenu .wp-submenu, #adminmenu .wp-has-current-submenu .wp-submenu.sub-open, #adminmenu .wp-has-current-submenu.opensub .wp-submenu, #adminmenu a.wp-has-current-submenu:focus+.wp-submenu, .no-js li.wp-has-current-submenu:hover .wp-submenu";
echo ultra_css_background($ultrastr, "menu-bg", "1.0") . "\n";

echo " \n/* -- Menu Text color -- */\n";
$ultrastr = " #adminmenu a, #adminmenu li.menu-top:hover, "
			."#adminmenu li.opensub>a.menu-top, #adminmenu li>a.menu-top:focus, "
			."#adminmenu div.wp-menu-image:before, #ws_menu_editor .ws_item_title, "
			."#adminmenu li a:focus div.wp-menu-image:before, #adminmenu li.opensub div.wp-menu-image:before";
echo ultra_css_color($ultrastr, "menu-color", "1.0") . "\n";


$ultrastr = " #adminmenu li:hover div.wp-menu-image:before, #adminmenu a:hover, #adminmenu li.menu-top>a:focus,  #adminmenu li.menu-top:hover, #adminmenu li.opensub>a.menu-top, #adminmenu li>a.menu-top:focus, "
			."#adminmenu .wp-has-current-submenu .wp-submenu .wp-submenu-head, #adminmenu .wp-menu-arrow, #adminmenu .wp-menu-arrow div, #adminmenu li.current a.menu-top, #adminmenu li.wp-has-current-submenu a.wp-has-current-submenu, .folded #adminmenu li.current.menu-top, .folded #adminmenu li.wp-has-current-submenu";
echo ultra_css_color($ultrastr, "menu-hover-color", "1.0") . "\n";



echo " \n/* -- Menu primary bg -- */\n";
$ultrastr = " #adminmenu li.menu-top:hover, #adminmenu li.opensub>a.menu-top, #adminmenu li>a.menu-top:focus, "
			."#adminmenu .wp-has-current-submenu .wp-submenu .wp-submenu-head, #adminmenu .wp-menu-arrow, #adminmenu .wp-menu-arrow div, #adminmenu li.current a.menu-top, #adminmenu li.wp-has-current-submenu a.wp-has-current-submenu, .folded #adminmenu li.current.menu-top, .folded #adminmenu li.wp-has-current-submenu ";
echo ultra_css_bgcolor($ultrastr, "menu-primary-bg", "1.0") . "\n";


echo " \n/* -- SubMenu -- */\n";
$ultrastr = " .folded #adminmenu li.menu-top .wp-submenu>li>a:hover, #adminmenu .wp-submenu a:focus, #adminmenu .wp-submenu a:hover, #adminmenu .wp-submenu li.current a, #adminmenu .wp-submenu li.current a:hover";
echo ultra_css_bgcolor($ultrastr, "menu-secondary-bg", "1.0") . "\n";
echo ultra_css_color($ultrastr, "submenu-color", "1.0") . "\n";
echo ultra_css_border_color($ultrastr, "menu-primary-bg", "", "left") . "\n";

$ultrastr = " #adminmenu .opensub .wp-submenu li.current a, #adminmenu .wp-submenu li.current, #adminmenu .wp-submenu li.current a, #adminmenu .wp-submenu li.current a:focus, #adminmenu .wp-submenu li.current a:hover, #adminmenu a.wp-has-current-submenu:focus+.wp-submenu li.current a,"
			."#adminmenu .wp-submenu a";
echo ultra_css_color($ultrastr, "submenu-color", "1.0") . "\n";


echo " \n/* -- Floating SubMenu -- */\n";
$ultrastr = " #adminmenu .wp-not-current-submenu li>a:hover, .folded #adminmenu .wp-has-current-submenu li>a:hover";
echo ultra_css_color($ultrastr, "submenu-color", "1.0") . "\n";
echo ultra_css_bgcolor($ultrastr, "menu-secondary-bg", "1.0") . "\n";
echo ultra_css_border_color($ultrastr, "menu-primary-bg", "", "left") . "\n";


echo " \n/* -- Floating SubMenu arrow -- */\n";
$ultrastr = " #adminmenu li.wp-has-submenu.wp-not-current-submenu.opensub:hover:after";
echo ultra_css_border_color($ultrastr, $ultraadmin['menu-bg']['background-color'],"","right","string");


echo " \n/* -- Collapsed Submenu - Menu Text color -- */\n";
echo ultra_css_color(".folded #adminmenu .wp-submenu .wp-submenu-head", "menu-color", "1.0") . "\n";


echo " \n/* -- Collapsed Submenu - SubMenu Text color -- */\n";
$ultrastr = " #collapse-menu, #collapse-menu:hover, #collapse-menu:hover #collapse-button div:after, #collapse-button div:after";
echo ultra_css_color($ultrastr, "submenu-color", "1.0") . "\n";


echo " \n/* -- Collapsed SubMenu -- */\n";
$ultrastr = " .folded #adminmenu li.menu-top .wp-submenu>li>a.current";
echo ultra_css_border_color($ultrastr, "menu-primary-bg", "", "left") . "\n";



echo " \n/* -- Logo BG -- */\n";
$ultrastr = " #adminmenuwrap:before, .folded #adminmenuwrap:before";
echo ultra_css_bgcolor($ultrastr, "logo-bg", "1.0") . "\n";










/*---------------------------------------------
  Boxes Section
 ---------------------------------------------*/

echo " \n/* -- Box BG -- */\n";
$ultrastr = " .welcome-panel, .postbox, "
			."#screen-meta, #contextual-help-link-wrap, #screen-options-link-wrap, #ws_menu_editor .ws_main_container";
echo ultra_css_background($ultrastr, "box-bg", "1.0") . "\n";


echo " \n/* -- Box Head -- */\n";
$ultrastr = " .postbox .hndle, .stuffbox .hndle, .welcome-panel h2, .settings_page_menu_editor .ui-dialog-titlebar";
echo ultra_css_background($ultrastr, "box-head-bg", "1.0") . "\n";
echo ultra_css_color($ultrastr, "box-head-color", "1.0") . "\n";

$ultrastr = " #ws_menu_editor .ws_main_container .ws_container.ws_active";
echo ultra_css_background($ultrastr, "box-head-bg", "1.0") . "\n";
$ultrastr = " #ws_menu_editor .ws_item_title";
echo ultra_css_color($ultrastr, "box-head-color", "1.0") . "\n";



echo " \n/* -- Data Tables Head -- */\n";
$ultrastr = " table.widefat thead tr, table.widefat tfoot tr";
echo ultra_css_background($ultrastr, "box-head-bg", "1.0") . "\n";

$ultrastr = " table.widefat thead tr, table.widefat tfoot tr,"
		   ."th .comment-grey-bubble:before, th .sorting-indicator:before, .widefat tfoot tr th, .widefat thead tr th, th.manage-column a, th.sortable a:active, th.sortable a:focus, th.sortable a:hover";
echo ultra_css_color($ultrastr, "box-head-color", "1.0") . "\n";


echo " \n/* --Admin Panel -> Menu section accordion title -- */\n";
$ultrastr = " .js .control-section .accordion-section-title:focus, .js .control-section .accordion-section-title:hover, .js .control-section.open .accordion-section-title, .js .control-section:hover .accordion-section-title";
echo ultra_css_background($ultrastr, "box-head-bg", "1.0") . "\n";
echo ultra_css_color($ultrastr, "box-head-color", "1.0") . "\n";


echo " \n/* --Plugin Upload -- */\n";
$ultrastr = " .upload-plugin .wp-upload-form, .upload-theme .wp-upload-form";
echo ultra_css_background($ultrastr, "box-head-bg", "1.0") . "\n";
echo ultra_css_color($ultrastr, "box-head-color", "1.0") . "\n";


echo " \n/* --Tools -> Importer -- */\n";
$ultrastr = " .importers tr:hover td";
echo ultra_css_background($ultrastr, "box-head-bg", "1.0") . "\n";
echo ultra_css_color($ultrastr, "box-head-color", "1.0") . "\n";
$ultrastr = " .importers tr:hover td a";
echo ultra_css_color($ultrastr, "box-head-color", "1.0") . "\n";



echo " \n/* -- Box Head toggle arrow - Using opacity-- */\n";
$ultrastr = " .js .meta-box-sortables .postbox .handlediv:before, .js .sidebar-name .sidebar-name-arrow:before, "
			.".welcome-panel .welcome-panel-close, #welcome-panel.welcome-panel .welcome-panel-close:before,"
			.".accordion-section-title:after, .handlediv, .item-edit, .sidebar-name-arrow, .widget-action,"
			.".accordion-section-title:focus:after, .accordion-section-title:hover:after, "
			."#ws_menu_editor a.ws_edit_link:before";
echo ultra_css_color($ultrastr, "box-head-color", "0.7") . "\n";
    
echo " \n/* -- Box Head toggle arrow - Using opacity-- !important */\n";
echo "#bulk-titles div a:before, #welcome-panel.welcome-panel .welcome-panel-close:before, .tagchecklist span a:before{color: ".ultra_colorcode($ultraadmin['box-head-color'],"0.7","!important")."} ";
echo ".accordion-section-title:focus:after, .accordion-section-title:hover:after{border-color: ".ultra_colorcode($ultraadmin['box-head-color'],"0.7"," transparent")."}";










/*---------------------------------------------
  Form Section
 ---------------------------------------------*/

echo " \n/* -- Form element -- */\n";
$ultrastr = " input[type=checkbox], input[type=color], input[type=date], input[type=datetime-local], input[type=datetime], input[type=email], input[type=month], input[type=number], input[type=password], input[type=radio], input[type=search], input[type=tel], input[type=text], input[type=time], input[type=url], input[type=week], select, textarea";
echo ultra_css_bgcolor($ultrastr, "form-bg", "1.0") . "\n";
echo ultra_css_border_color($ultrastr, "form-border-color", "", "all") . "\n";
echo ultra_css_color($ultrastr, "form-text-color", "1.0") . "\n";


echo " \n/* -- Post Title -- */\n";
$ultrastr = " #titlediv #title";
echo ultra_css_border_color($ultrastr, "form-border-color", "", "all") . "\n";














/*---------------------------------------------
  Button Section
 ---------------------------------------------*/

echo " \n/* -- Button text color -- */\n";
$ultrastr = " .wp-core-ui .button, .wp-core-ui .button-secondary, "
		   .".wp-media-buttons .add_media span.wp-media-buttons-icon:before, "
 		   .".wp-core-ui .button-secondary:focus, .wp-core-ui .button-secondary:hover, .wp-core-ui .button.focus, .wp-core-ui .button.hover, .wp-core-ui .button:focus, .wp-core-ui .button:hover,"
 		   .".wp-core-ui .button-primary,"
 		   .".wp-core-ui .button-primary.focus, .wp-core-ui .button-primary.hover, .wp-core-ui .button-primary:focus, .wp-core-ui .button-primary:hover,"
 		   ."#wp-fullscreen-buttons .mce-btn:focus .mce-ico, #wp-fullscreen-buttons .mce-btn:hover .mce-ico, .mce-toolbar .mce-btn-group .mce-btn:focus .mce-ico, .mce-toolbar .mce-btn-group .mce-btn:hover .mce-ico, .qt-fullscreen:focus .mce-ico, .qt-fullscreen:hover .mce-ico,"
 		   .".media-frame a.button, .media-frame a.button:hover,"
 		   .".wordfenceWrap input[type='button'], .wordfenceWrap input[type='submit'], .wordfenceWrap input[type='button']:hover, .wordfenceWrap input[type='submit']:hover, .wordfenceWrap input[type='button']:focus, .wordfenceWrap input[type='submit']:focus";
echo ultra_css_color($ultrastr, "button-text-color", "1.0") . "\n";


echo " \n/* -- Button secondary bg color -- */\n";
$ultrastr = " .wp-core-ui .button, .wp-core-ui .button-secondary, .wordfenceWrap input[type='button'], .wordfenceWrap input[type='submit']";
echo ultra_css_bgcolor($ultrastr, "button-secondary-bg", "1.0") . "\n";


echo " \n/* -- Button secondary hover bg color -- */\n";
$ultrastr = " .wp-core-ui .button-secondary:focus, .wp-core-ui .button-secondary:hover, .wp-core-ui .button.focus, .wp-core-ui .button.hover, .wp-core-ui .button:focus, .wp-core-ui .button:hover,"
		   ."#edit-slug-box .edit-slug.button:hover, #edit-slug-box #view-post-btn .button:hover";
echo ultra_css_bgcolor($ultrastr, "button-secondary-hover-bg", "1.0") . "\n";


echo " \n/* -- Button primary bg color -- */\n";
$ultrastr = " .wp-core-ui .button-primary,"
		   .".row-actions span a:hover,"
		   .".plugin-card .install-now.button, .plugin-card .button,"
		   .".wordfenceWrap input[type='button'], .wordfenceWrap input[type='submit']";
echo ultra_css_bgcolor($ultrastr, "button-primary-bg", "1.0") . "\n";


echo " \n/* -- Button primary hover bg color -- */\n";
$ultrastr = " .wp-core-ui .button-primary.focus, .wp-core-ui .button-primary.hover, .wp-core-ui .button-primary:focus, .wp-core-ui .button-primary:hover,"
		   ."#adminmenu .awaiting-mod, #adminmenu .update-plugins, #sidemenu li a span.update-plugins,"
		   .".wordfenceWrap input[type='button']:hover, .wordfenceWrap input[type='submit']:hover, .wordfenceWrap input[type='button']:focus, .wordfenceWrap input[type='submit']:focus";
echo ultra_css_bgcolor($ultrastr, "button-primary-hover-bg", "1.0") . "\n";


//echo " \n/* -- Data Row action buttons text color-- !important */\n";
//echo ".row-actions span a:hover {color: ".ultra_colorcode($ultraadmin['button-text-color'],"1.0","!important")."}";


echo " \n/* ---- disabled button - !important ----- */\n";
$ultrastr = " .wp-core-ui .button-primary-disabled, .wp-core-ui .button-primary.disabled, .wp-core-ui .button-primary:disabled, .wp-core-ui .button-primary[disabled]";
echo $ultrastr." {color: ".ultra_colorcode($ultraadmin['button-text-color'],"1.0","!important")."}";
echo $ultrastr." {background-color: ".ultra_colorcode($ultraadmin['button-primary-bg'],"1.0","!important")."}";











/*----------------------------------
 Admin Top bar
-----------------------------------*/

echo " \n/* -- Top bar BG - like menu bg-- */\n";
$ultrastr = " #wpadminbar";
echo ultra_css_background($ultrastr, "topbar-menu-bg", "1.0") . "\n";


$ultrastr = " #wpadminbar .ab-top-menu>li.hover>.ab-item, #wpadminbar .ab-top-menu>li:hover>.ab-item, #wpadminbar .ab-top-menu>li>.ab-item:focus, #wpadminbar.nojq .quicklinks .ab-top-menu>li>.ab-item:focus,"
			."#wpadminbar .menupop .ab-sub-wrapper, #wpadminbar .shortlink-input,"
			."#wp-admin-bar-my-account .ab-sub-wrapper .ab-submenu li,"
			."#wpadminbar .quicklinks .menupop.hover ul li .ab-item,"
			."#wpadminbar .quicklinks .ab-empty-item:hover, #wpadminbar .quicklinks a:hover, #wpadminbar .shortlink-input:hover";
echo ultra_css_bgcolor($ultrastr, "topbar-submenu-bg", "1.0") . "\n";



$ultrastr = " #wpadminbar #wp-admin-bar-user-info:hover a,"
			."#wpadminbar .quicklinks .menupop.hover ul li a:hover"
			."";
echo ultra_css_bgcolor($ultrastr, "topbar-submenu-hover-bg", "1.0") . "\n";


$ultrastr = " #wpadminbar .ab-top-menu>li.hover>.ab-item, #wpadminbar .ab-top-menu>li:hover>.ab-item, #wpadminbar .ab-top-menu>li>.ab-item:focus, #wpadminbar.nojq .quicklinks .ab-top-menu>li>.ab-item:focus, "
			."#wpadminbar .ab-submenu .ab-item, #wpadminbar .quicklinks .menupop ul li a, #wpadminbar .quicklinks .menupop ul li a strong, #wpadminbar .quicklinks .menupop.hover ul li a, #wpadminbar.nojs .quicklinks .menupop:hover ul li a,"
			."#wpadminbar .quicklinks .ab-empty-item, #wpadminbar .quicklinks a, #wpadminbar .shortlink-input,"
			."#wpadminbar .quicklinks .menupop ul li a:focus, #wpadminbar .quicklinks .menupop ul li a:focus strong, #wpadminbar .quicklinks .menupop ul li a:hover, #wpadminbar .quicklinks .menupop ul li a:hover strong, #wpadminbar .quicklinks .menupop.hover ul li a:focus, #wpadminbar .quicklinks .menupop.hover ul li a:hover, #wpadminbar li .ab-item:focus:before, #wpadminbar li a:focus .ab-icon:before, #wpadminbar li.hover .ab-icon:before, #wpadminbar li.hover .ab-item:before, #wpadminbar li:hover #adminbarsearch:before, #wpadminbar li:hover .ab-icon:before, #wpadminbar li:hover .ab-item:before, #wpadminbar.nojs .quicklinks .menupop:hover ul li a:focus, #wpadminbar.nojs .quicklinks .menupop:hover ul li a:hover,"
			."#wpadminbar>#wp-toolbar a:focus span.ab-label, #wpadminbar>#wp-toolbar li.hover span.ab-label, #wpadminbar>#wp-toolbar li:hover span.ab-label";
echo ultra_css_color($ultrastr, "topbar-submenu-color", "1.0") . "\n";


$ultrastr = " #wpadminbar .quicklinks .menupop.hover ul li a:hover";
echo ultra_css_border_color($ultrastr, "primary-color", "", "left") . "\n";

$ultrastr = " #wpadminbar a.ab-item, #wpadminbar>#wp-toolbar span.ab-label, #wpadminbar>#wp-toolbar span.noticon,"
			."#wpadminbar #adminbarsearch:before, #wpadminbar .ab-icon:before, #wpadminbar .ab-item:before, "
			."#wpadminbar .ab-top-menu>li.hover>.ab-item, #wpadminbar.nojq .quicklinks .ab-top-menu>li>.ab-item:focus, #wpadminbar:not(.mobile) .ab-top-menu>li:hover>.ab-item, #wpadminbar:not(.mobile) .ab-top-menu>li>.ab-item:focus, "
			."#wpadminbar:not(.mobile)>#wp-toolbar a:focus span.ab-label, #wpadminbar:not(.mobile)>#wp-toolbar li:hover span.ab-label, #wpadminbar>#wp-toolbar li.hover span.ab-label, #wpadminbar .ab-top-menu:hover .ab-item:before, #wpadminbar .ab-item:hover .ab-icon:before ";
echo ultra_css_color($ultrastr, "topbar-menu-color", "1.0") . "\n";

echo " \n/* -- Top bar Style -- */\n";
echo ultra_admintopbar_style();


?>




