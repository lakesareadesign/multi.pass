<?php

class UM_Mailchimp_Notices {

	function __construct() {

		add_action('admin_notices', array(&$this, 'admin_notices'), 1);

	}
	
	/***
	***	@show main notices
	***/
	function admin_notices(){
		global $um_mailchimp;
		
		$hide_notice = get_option('um_hide_mailchimp_notice');
		
		if ( $hide_notice ) return;
		
		$hide_link = add_query_arg( 'um_adm_action', 'um_hide_mailchimp_notice' );
		$key = um_get_option('mailchimp_api');
		
		if ( !$key ) {
			
			echo '<div class="updated um-admin-notice"><p>';
		
			echo sprintf(__( 'You must add your <strong>MailChimp API</strong> key before connecting your newsletter lists. <a href="%s">Hide this notice</a>','um-mailchimp'), $hide_link);
			
			echo '</p>';
			
			echo '<p><a href="' . admin_url('admin.php?page=um_options&tab=' . $um_mailchimp->tab_id ) . '" class="button button-primary">' . __( 'Setup MailChimp API', 'um-mailchimp' ) . '</a></p></div>';
		
		}
	}

}