<?php
//ADD SUB MENU ACTION
add_action( 'admin_menu', 'menu_sub_theme' );

//SUB MENU
function menu_sub_theme() {
	add_submenu_page (
	'menu_main', //parent
	'Theme Settings', 	//titolo pagina
	'Theme settings', //titolo menu
	'manage_options', //permessi
	'menu_sub_theme', //slug
	'options_main_theme'); //funzione
};
?>
