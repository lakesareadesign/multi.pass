<?php
function flatty_styles() {
//START

	//RESET
	wp_register_style('flatty-reset', plugins_url(FLATTY_PLUGIN_URL . 'assets/css/flatty-reset.css'), null, FLATTY_VERSION, 'screen');
	wp_enqueue_style('flatty-reset');

	//LAYOUT
	wp_register_style('flatty-components', plugins_url(FLATTY_PLUGIN_URL . 'assets/css/layout/flatty-layout-components.css'), null, FLATTY_VERSION, 'screen');
	wp_enqueue_style('flatty-components');

	wp_register_style('flatty-buttons', plugins_url(FLATTY_PLUGIN_URL . 'assets/css/layout/flatty-layout-buttons.css'), null, FLATTY_VERSION, 'screen');
	wp_enqueue_style('flatty-buttons');

	wp_register_style('flatty-contextlinks', plugins_url(FLATTY_PLUGIN_URL . 'assets/css/layout/flatty-layout-contextlinks.css'), null, FLATTY_VERSION, 'screen');
	wp_enqueue_style('flatty-contextlinks');

	wp_register_style('flatty-sidebar', plugins_url(FLATTY_PLUGIN_URL . 'assets/css/layout/flatty-layout-sidebar.css'), null, FLATTY_VERSION, 'screen');
	wp_enqueue_style('flatty-sidebar');

	wp_register_style('flatty-topbar', plugins_url(FLATTY_PLUGIN_URL . 'assets/css/layout/flatty-layout-topbar.css'), null, FLATTY_VERSION, 'screen');
	wp_enqueue_style('flatty-topbar');

	wp_register_style('flatty-notice', plugins_url(FLATTY_PLUGIN_URL . 'assets/css/layout/flatty-layout-notice.css'), null, FLATTY_VERSION, 'screen');
	wp_enqueue_style('flatty-notice');

	wp_register_style('flatty-general', plugins_url(FLATTY_PLUGIN_URL . 'assets/css/layout/flatty-layout-general.css'), null, FLATTY_VERSION, 'screen');
	wp_enqueue_style('flatty-general');

	//SUPPORT
	wp_register_style('flatty-woocommerce', plugins_url(FLATTY_PLUGIN_URL . 'assets/css/support/flatty-support-woocommerce.css'), null, FLATTY_VERSION, 'screen');
	wp_enqueue_style('flatty-woocommerce');

	wp_register_style('flatty-brokenlinkchecker', plugins_url(FLATTY_PLUGIN_URL . 'assets/css/support/flatty-support-brokenlinkchecker.css'), null, FLATTY_VERSION, 'screen');
	wp_enqueue_style('flatty-brokenlinkchecker');

	//ADDONS
	wp_register_style('flatty-addons-topbar', plugins_url(FLATTY_PLUGIN_URL . 'assets/css/addons/flatty-addons-topbar.css'), null, FLATTY_VERSION, 'screen');
	wp_enqueue_style('flatty-addons-topbar');

	wp_register_style('flatty-addons-general', plugins_url(FLATTY_PLUGIN_URL . 'assets/css/addons/flatty-addons-general.css'), null, FLATTY_VERSION, 'screen');
	wp_enqueue_style('flatty-addons-general');

	//PAGES
	wp_register_style('flatty-dashboard', plugins_url(FLATTY_PLUGIN_URL . 'assets/css/page/flatty-page-dashboard.css'), null, FLATTY_VERSION, 'screen');
	wp_enqueue_style('flatty-dashboard');

	if (get_option('flatty_post_style') != true) {
		wp_register_style('flatty-article', plugins_url(FLATTY_PLUGIN_URL . 'assets/css/page/flatty-page-article.css'), null, FLATTY_VERSION, 'screen');
		wp_enqueue_style('flatty-article');
	}

	wp_register_style('flatty-plugins', plugins_url(FLATTY_PLUGIN_URL . 'assets/css/page/flatty-page-plugins.css'), null, FLATTY_VERSION, 'screen');
	wp_enqueue_style('flatty-plugins');

	wp_register_style('flatty-themes', plugins_url(FLATTY_PLUGIN_URL . 'assets/css/page/flatty-page-themes.css'), null, FLATTY_VERSION, 'screen');
	wp_enqueue_style('flatty-themes');

	if (get_option('flatty_login_style') === 'light') {
		wp_register_style('flatty-login_light', plugins_url(FLATTY_PLUGIN_URL . 'assets/css/themes/flatty-login_light.css'), null, FLATTY_VERSION, 'screen');
		wp_enqueue_style('flatty-login_light');
	} elseif(get_option('flatty_login_style') === 'dark') {
		wp_register_style('flatty-login_dark', plugins_url(FLATTY_PLUGIN_URL . 'assets/css/themes/flatty-login_dark.css'), null, FLATTY_VERSION, 'screen');
		wp_enqueue_style('flatty-login_dark');
	}

	wp_register_style('flatty-options', plugins_url(FLATTY_PLUGIN_URL . 'assets/css/page/flatty-page-flatty-options.css'), null, FLATTY_VERSION, 'screen');
	wp_enqueue_style('flatty-options');

	//MEDIAQUERIES
	wp_register_style('flatty-mediaqueries', plugins_url(FLATTY_PLUGIN_URL . 'assets/css/flatty-query.css'), null, FLATTY_VERSION, 'screen');
	wp_enqueue_style('flatty-mediaqueries');

	//THEME
	if (get_option('flatty_light_style') == true) {
		wp_register_style('flatty-light', plugins_url(FLATTY_PLUGIN_URL . 'assets/css/themes/light.css'), null, FLATTY_VERSION, 'screen');
		wp_enqueue_style('flatty-light');
	} else {
		wp_register_style('flatty-default', plugins_url(FLATTY_PLUGIN_URL . 'assets/css/themes/default.css'), null, FLATTY_VERSION, 'screen');
		wp_enqueue_style('flatty-default');
	}

	//EXTERNALS
	wp_enqueue_style('flatty-font', '//fonts.googleapis.com/css?family=Source+Sans+Pro:400,300,600,700');
	wp_enqueue_style('flatty-icons', '//maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css');

//END
}

?>
