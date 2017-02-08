<?php
//ADD SUB MENU ACTION
add_action( 'admin_menu', 'menu_sub_branding' );

//SUB MENU
function menu_sub_branding() {
	add_submenu_page (
	'menu_main', //parent
	__('Branding', 'flatty-flat-admin-theme' ), 	//titolo pagina
	__('Branding', 'flatty-flat-admin-theme' ), //titolo menu
	'manage_options', //permessi
	'menu_sub_branding', //slug
	'options_main_branding'); //funzione
};
?>
