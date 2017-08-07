<?php
//ADD SUB MENU ACTION
add_action( 'admin_menu', 'menu_sub_appearance' );

//SUB MENU
function menu_sub_appearance() {
	add_submenu_page (
	'menu_main', //parent
	__('Appearance', 'flatty-flat-admin-theme' ), //titolo pagina
	__('Appearance', 'flatty-flat-admin-theme' ), //titolo menu
	'manage_options', //permessi
	'menu_sub_appearance', //slug
	'options_main_appearance'); //funzione
};
?>
