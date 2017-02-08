<?php
//ADD SUB MENU ACTION
add_action( 'admin_menu', 'menu_sub_postspages' );

//SUB MENU
function menu_sub_postspages() {
	add_submenu_page (
	'menu_main', //parent
	__('Posts & Pages', 'flatty-flat-admin-theme' ), 	//titolo pagina
	__('Posts & Pages', 'flatty-flat-admin-theme' ), //titolo menu
	'manage_options', //permessi
	'menu_sub_postspages', //slug
	'options_sub_postspages'); //funzione
};
?>
