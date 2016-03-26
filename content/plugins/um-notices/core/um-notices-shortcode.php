<?php

class UM_Notices_Shortcode {

	function __construct() {
	
		add_shortcode('ultimatemember_notice', array(&$this, 'ultimatemember_notice'), 1);

	}
	
	/***
	***	@Shortcode
	***/
	function ultimatemember_notice( $args = array() ) {
		global $um_notices;

		ob_start();

		echo '<div class="um-notices-shortcode">';
		$um_notices->query->show_notice( $args['id'] );
		echo '</div>';
		
		$um_notices->shortcodes[ $args['id'] ] = 1;
		
		$output = ob_get_contents();
		ob_end_clean();
		return $output;
	}

}