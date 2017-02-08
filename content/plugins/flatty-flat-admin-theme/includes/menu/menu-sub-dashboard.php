<?php
//ADD SUB MENU ACTION
add_action( 'admin_menu', 'menu_sub_dashboard' );

//SUB MENU
function menu_sub_dashboard() {
	add_submenu_page (
	'menu_main', //parent
	__('Dashboard', 'flatty-flat-admin-theme' ), 	//titolo pagina
	__('Dashboard', 'flatty-flat-admin-theme' ), //titolo menu
	'manage_options', //permessi
	'menu_sub_dashboard', //slug
	'options_main_dashboard'); //funzione
};
?>
