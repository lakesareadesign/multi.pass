<?php
//ADD SUB MENU ACTION
add_action( 'admin_menu', 'menu_sub_login' );

//SUB MENU
function menu_sub_login() {
	add_submenu_page (
	'menu_main', //parent
	'Login Settings', 	//titolo pagina
	'Login settings', //titolo menu
	'manage_options', //permessi
	'menu_sub_login', //slug
	'options_main_login'); //funzione
};
?>
