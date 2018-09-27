<?php


class Hustle_Settings_Admin_Ajax {
	private $_hustle;

	private $_admin;

	public function __construct( Opt_In $hustle, Hustle_Settings_Admin $admin ) {
		$this->_hustle = $hustle;
		$this->_admin = $admin;

		add_action("wp_ajax_hustle_toggle_module_for_user", array( $this, "toggle_module_for_user" ));
		add_action("wp_ajax_hustle_save_global_email_settings", array( $this, "save_global_email_settings" ));
		add_action("wp_ajax_hustle_toggle_unsubscribe_messages_settings", array( $this, "toggle_unsubscription_custom_messages" ));
		add_action("wp_ajax_hustle_save_unsubscribe_messages_settings", array( $this, "save_unsubscription_messages" ));
		add_action("wp_ajax_hustle_save_unsubscribe_email_settings", array( $this, "save_unsubscription_email" ));
		add_action("wp_ajax_hustle_toggle_unsubscribe_email_settings", array( $this, "toggle_unsubscription_custom_email" ));
		// These two actions doesn't seem to be used anymore.
		add_action("wp_ajax_hustle_get_providers_edit_modal_content", array( $this, "get_providers_edit_modal_content" ));
		add_action("wp_ajax_hustle_save_providers_edit_modal", array( $this, "save_providers_edit_modal" ));
		// Not sure about this one. Double check.
		add_action("wp_ajax_hustle_shortcode_render", array( $this, "shortcode_render" ));
	}

	public function toggle_module_for_user(){
		Opt_In_Utils::validate_ajax_call("hustle_modules_toggle");

		$id = filter_input( INPUT_POST, 'id', FILTER_VALIDATE_INT );
		$user_type = filter_input( INPUT_POST, 'user_type', FILTER_SANITIZE_STRING );

		$module = Hustle_Module_Model::instance()->get( $id );

		$result = $module->toggle_activity_for_user( $user_type );

		if( is_wp_error( $result ) )
			wp_send_json_error( $result->get_error_messages() );

		wp_send_json_success( sprintf( __("Successfully toggled for user type %s", Opt_In::TEXT_DOMAIN), $user_type ) );
	}

	/**
	 * Toggles if the customized unsubscription messages are enabled.
	 *
	 * @since 3.0.5
	 */
	public function toggle_unsubscription_custom_messages() {
		Opt_In_Utils::validate_ajax_call("hustle_save_unsubscribe_messages_settings");
		$enabled = filter_input( INPUT_POST, 'enabled', FILTER_SANITIZE_STRING );

		$saved = get_option( 'hustle_global_unsubscription_settings', array() );

		if ( isset( $saved['messages'] ) && ! empty( $saved['messages'] ) ) {
			$saved['messages']['enabled'] = 'false' === $enabled ? '0' : '1';
			update_option( 'hustle_global_unsubscription_settings', $saved );
		}
		wp_send_json_success();
	}

	/**
	 * Saves the global messages to show along the unsubscription process.
	 *
	 * @since 3.0.5
	 */
	public function save_unsubscription_messages() {
		Opt_In_Utils::validate_ajax_call("hustle_save_unsubscribe_messages_settings");
		parse_str( $_POST['data'], $data ); // WPCS: CSRF ok.
		if ( get_magic_quotes_gpc() ) {
			$data = stripslashes_deep( $data );
		}
		$sanitized_data = Opt_In_Utils::validate_and_sanitize_fields( $data );

		$data_to_save = array(
			'enabled' => $sanitized_data['enabled'],
			'get_lists_button_text' => $sanitized_data['get_lists_button_text'],
			'submit_button_text' => $sanitized_data['submit_button_text'],
			'invalid_email'=> $sanitized_data['invalid_email'],
			'email_not_found' => $sanitized_data['email_not_found'],
			'invalid_data' => $sanitized_data['invalid_data'],
			'email_submitted' => $sanitized_data['email_submitted'],
			'successful_unsubscription' => $sanitized_data['successful_unsubscription'],
			'email_not_processed' => $sanitized_data['email_not_processed'],
		);

		$saved = get_option( 'hustle_global_unsubscription_settings', array() );
		$saved['messages'] = $data_to_save;

		update_option( 'hustle_global_unsubscription_settings', $saved );
		wp_send_json_success();
	}

	/**
	 * Toggles if the customized unsubscription email is enabled.
	 *
	 * @since 3.0.5
	 */
	public function toggle_unsubscription_custom_email() {
		Opt_In_Utils::validate_ajax_call("hustle_save_unsubscribe_email_settings");
		$enabled = filter_input( INPUT_POST, 'enabled', FILTER_SANITIZE_STRING );

		$saved = get_option( 'hustle_global_unsubscription_settings', array() );

		if ( isset( $saved['email'] ) && ! empty( $saved['email'] ) ) {
			$saved['email']['enabled'] = 'false' === $enabled ? '0' : '1';
			update_option( 'hustle_global_unsubscription_settings', $saved );
		}

		wp_send_json_success();
	}

	/**
	 * Saves the global settings for subject and body for the unsubscription email.
	 *
	 * @since 3.0.5
	 */
	public function save_unsubscription_email() {
		Opt_In_Utils::validate_ajax_call("hustle_save_unsubscribe_email_settings");
		parse_str( $_POST['data'], $data ); // WPCS: CSRF ok.
		if ( get_magic_quotes_gpc() ) {
			$data = stripslashes_deep( $data );
		}
		$enabled = filter_var( $data['enabled'], FILTER_SANITIZE_STRING );
		$email_subject = filter_var( $data['email_subject'], FILTER_SANITIZE_STRING );
		$email_body = wp_json_encode( $data['email_message'] );

		$data_to_save = array(
			'enabled' => $enabled,
			'email_subject' => $email_subject,
			'email_body' => $email_body,
		);

		$saved = get_option( 'hustle_global_unsubscription_settings', array() );
		$saved['email'] = $data_to_save;

		update_option( 'hustle_global_unsubscription_settings', $saved );
		wp_send_json_success();
	}

	/**
	 * Saves the global email sender name and email address.
	 *
	 * @since 3.0.5
	 */
	public function save_global_email_settings() {
		Opt_In_Utils::validate_ajax_call("hustle_save_global_email_settings");
		parse_str( $_POST['data'], $data ); // WPCS: CSRF ok.

		$name = filter_var( $data['name'], FILTER_SANITIZE_STRING );
		$email = filter_var( $data['email'], FILTER_SANITIZE_EMAIL );
		$email_settings = array(
			'sender_email_name' => $name,
			'sender_email_address' => $email,
		);

		update_option( 'hustle_global_email_settings', $email_settings );

		wp_send_json_success();
	}

	public function get_providers_edit_modal_content(){
		Opt_In_Utils::validate_ajax_call("hustle_edit_providers");

		$id = filter_input( INPUT_GET, 'id', FILTER_VALIDATE_INT );
		$source = filter_input( INPUT_GET, 'source', FILTER_SANITIZE_STRING );

		if( !$id || !$source )
			wp_send_json_error(__("Invalid Request", Opt_In::TEXT_DOMAIN));


		if( "optin" === $source ){
			$module = Hustle_Module_Model::instance()->get( $id );

			$html = $this->_hustle->render("admin/settings/providers-edit-modal-content", array(
				"providers" => $this->_hustle->get_providers(),
				// "selected_provider" => $module->optin_provider,
				"optin" => $module
			), true);

			wp_send_json_success( array(
				"html" => $html,
				"provider_options_nonce" => wp_create_nonce("change_provider_name")
			) );
		}


	}

	public function save_providers_edit_modal(){
		Opt_In_Utils::validate_ajax_call("hustle-edit-service-save");

//		var_dump($_POST);die;
		$id = filter_input( INPUT_POST, 'id', FILTER_VALIDATE_INT );
		$source = filter_input( INPUT_POST, 'source', FILTER_SANITIZE_STRING );

		if( !$id || !$source )
			wp_send_json_error(__("Invalid Request", Opt_In::TEXT_DOMAIN));


		if( "optin" === $source ){
			$module = Hustle_Module_Model::instance()->get( $id );

			$html = $this->_hustle->render("admin/settings/providers-edit-modal-content", array(
				"providers" => $this->_hustle->get_providers(),
				// "selected_provider" => $module->optin_provider,
				"optin" => $module
			), true);

			wp_send_json_success( array(
				"html" => $html,
				"provider_options_nonce" => wp_create_nonce("change_provider_name")
			) );
		}
	}

	public function shortcode_render() {
		Opt_In_Utils::validate_ajax_call("hustle_shortcode_render");

		$content = filter_input( INPUT_POST, 'content' );
		$rendered_content = apply_filters( 'the_content', $content );

		wp_send_json_success( array(
			"content" => $rendered_content
		));
	}
}