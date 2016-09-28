<?php
//ADD SUB MENU ACTION
add_action( 'admin_menu', 'menu_sub_dashboard' );

//SUB MENU
function menu_sub_dashboard() {
	add_submenu_page (
	'menu_main', //parent
	'Dashboard Settings', 	//titolo pagina
	'Dashboard settings', //titolo menu
	'manage_options', //permessi
	'menu_sub_dashboard', //slug
	'options_main_dashboard'); //funzione
};
?>
