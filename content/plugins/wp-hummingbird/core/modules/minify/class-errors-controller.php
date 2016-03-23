<?php

/**
 * Manage the errors during minification processing
 */
class WP_Hummingbird_Minification_Errors_Controller {

	/**
	 * Minification errors list
	 *
	 * @var array|bool
	 */
	private $errors;

	public function __construct() {
		$this->errors = $this->get_errors();
	}

	/**
	 * Get all minification errors
	 *
	 * @return array|bool False if there are no errors
	 */
	private function get_errors() {
		$default = array( 'scripts' => array(), 'styles' => array() );

		/**
		 * Filter the minification errors
		 */
		return apply_filters( 'wphb_minification_errors', get_option( 'wphb-minification-errors', $default ) );
	}

	/**
	 * Return a single handle error
	 *
	 * @param string $handle
	 * @param string $type styles|scripts
	 *
	 * @return bool|array
	 */
	public function get_handle_error( $handle, $type ) {
		if ( ! isset( $this->errors[ $type ][ $handle ] ) ) {
			return false;
		}

		$defaults = array(
			'handle' => '',
			'error' => '',
			'disable' => array()
		);
		return wp_parse_args( $this->errors[ $type ][ $handle ], $defaults );
	}

	/**
	 * Clear all errors
	 */
	public static function clear_errors() {
		delete_option( 'wphb-minification-errors' );
	}

	/**
	 * Delete a single handle error
	 *
	 * @param string|array $handles
	 * @param string $type
	 */
	public function clear_handle_error( $handles, $type ) {
		if ( ! is_array( $handles ) ) {
			$handles = array( $handles );
		}

		foreach ( $handles as $handle ) {
			$error = $this->get_handle_error( $handle, $type );
			if ( ! $error ) {
				continue;
			}

			unset( $this->errors[ $type ][ $handle ] );
		}


		update_option( 'wphb-minification-errors', $this->errors );
	}

	/**
	 * Add a minification error for a list of handles
	 *
	 * @param array|string $handles Handles list or single handle
	 * @param string $type scripts|styles
	 * @param string $code Error code
	 * @param string $message Error message
	 * @param array $actions List of actions to take (don't minify, don't combine)
	 * @param array $disable List of switchers to disable in Minification screen (minify, combine)
	 */
	public function add_error( $handles, $type, $code, $message, $actions = array(), $disable = array() ) {
		if ( ! is_array( $handles ) ) {
			$handles = array( $handles );
		}

		$options = wphb_get_settings();

		foreach ( $handles as $handle ) {
			$this->errors[ $type ][ $handle ] = array(
				'code' => $code,
				'error' => $message,
				'disable' => $disable
			);

			if ( ! empty( $actions ) && is_array( $actions ) ) {

				if ( in_array( 'minify', $actions ) ) {
					$options['dont_minify'][ $type ][] = $handle;
				}

				if ( in_array( 'combine', $actions ) ) {
					$options['dont_combine'][ $type ][] = $handle;
				}

			}
		}

		wphb_update_settings( $options );
		update_option( 'wphb-minification-errors', $this->errors );
	}
}