<?php

/**
 * Controller abstraction class
 *
 * @since 1.0
 */
class WD_Controller extends WD_Component {
	/**
	 * Child class can define this variable if need to use a template
	 * @var bool|string
	 */
	protected $template = false;

	/**
	 * Render the view, if $template provided, this will render inside the template
	 *
	 * @param $path
	 * @param array $args
	 * @param bool|false $output
	 *
	 * @return string
	 */
	public function render( $path, $args = array(), $output = true ) {
		$args['controller'] = $this;
		$base_path          = $this->determine_base_path();;

		$view = new WD_View( $path, $args, false, $base_path );

		if ( $this->template !== false ) {
			$view->parent_template = $this->template;
		}

		$content = $view->render();
		if ( is_wp_error( $content ) ) {
			echo '<div class="wd-error">' . $content->get_error_message() . '</div>';
		} else {
			if ( $output ) {
				echo $content;
			} else {
				return $content;
			}
		}
	}

	/**
	 * @return string
	 */
	private function determine_base_path() {
		$class     = get_class( $this );
		$reflector = new ReflectionClass( $class );
		$path      = $reflector->getFileName();
		$file_name = explode( '-', pathinfo( $path, PATHINFO_FILENAME ) );
		$pools     = explode( DIRECTORY_SEPARATOR, $path );
		$parts     = array();
		$suffix    = array_pop( $file_name );
		//suffix only controller or widget, inherite of class wd-controller
		//usually base path will be parent of controller folder
		foreach ( $pools as $pool ) {
			if ( $pool == $suffix ) {
				break;
			} elseif ( $pool != $suffix ) {
				$parts[] = $pool;
			}
		}
		$parts = implode( DIRECTORY_SEPARATOR, $parts );

		return $parts . DIRECTORY_SEPARATOR;
	}

	/**
	 * Set a flash message
	 *
	 * @param $key
	 * @param $flash
	 */
	public function flash( $key, $flash ) {
		if ( ! is_user_logged_in() ) {
			return;
		}

		$flashes         = get_user_meta( get_current_user_id(), 'wd_flash_data', true );
		$flashes[ $key ] = $flash;
		update_user_meta( get_current_user_id(), 'wd_flash_data', $flashes );
	}

	/**
	 * Check if a flash exists
	 *
	 * @param $key
	 *
	 * @return bool
	 */
	public function has_flash( $key ) {
		if ( ! is_user_logged_in() ) {
			return false;
		}

		$flashes = get_user_meta( get_current_user_id(), 'wd_flash_data', true );

		return isset( $flashes[ $key ] );
	}

	/**
	 * @param $key
	 *
	 * @return bool
	 */
	public function get_flash( $key ) {
		if ( ! is_user_logged_in() ) {
			return;
		}

		$flashes = get_user_meta( get_current_user_id(), 'wd_flash_data', true );

		$flash = isset( $flashes[ $key ] ) ? $flashes[ $key ] : false;
		if ( $flash !== false ) {
			unset( $flashes[ $key ] );
			update_user_meta( get_current_user_id(), 'wd_flash_data', $flashes );
		}

		return $flash;
	}
}