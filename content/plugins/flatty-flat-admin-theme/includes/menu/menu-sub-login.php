<?php
//ADD SUB MENU ACTION
add_action( 'admin_menu', 'menu_sub_login' );

//SUB MENU
function menu_sub_login() {
	add_submenu_page (
	'menu_main', //parent
	__('Login', 'flatty-flat-admin-theme' ), 	//titolo pagina
	__('Login', 'flatty-flat-admin-theme' ), //titolo menu
	'manage_options', //permessi
	'menu_sub_login', //slug
	'options_main_login'); //funzione
};
?>
