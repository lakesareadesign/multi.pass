<?php
//ADD SUB MENU ACTION
add_action( 'admin_menu', 'menu_sub_business_card' );

//SUB MENU
function menu_sub_business_card() {
	add_submenu_page (
	'menu_main', //parent
	__('Business Card', 'flatty-flat-admin-theme' ), 	//titolo pagina
	__('Business Card', 'flatty-flat-admin-theme' ), //titolo menu
	'manage_options', //permessi
	'menu_sub_business_card', //slug
	'options_sub_business_card'); //funzione
};
?>
