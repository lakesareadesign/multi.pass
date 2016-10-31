<?php

/**
 * View class, only need to call via WD_Controller object
 *
 */
class WD_View extends WD_Component {
	/**
	 * @var string
	 */
	private $base_path = '';
	/**
	 * This is the path to view file, can be exact path, if not exact, this will lookup from app/view folder
	 *
	 * @var string
	 * @since 1.0
	 */
	private $file_path = '';

	/**
	 * @var array
	 * @since 1.0
	 */
	private $data = array();

	/**
	 * @var bool
	 * @since 1.0
	 */
	private $output = true;

	/**
	 * if provided, will load this view inside parent.
	 * parent template will require to have a code <?php echo $id ?> whic $id is the position. Default is $content
	 * @var bool
	 */
	protected $parent_template = false;

	/**
	 * Only require when using template
	 * @var string
	 */
	private $position = 'contents';

	/**
	 * @param $file_path
	 * @param array $data
	 * @param bool|true $output
	 * @param string $position
	 * @param string $base_path
	 */
	public function __construct( $file_path, $data = array(), $output = true, $base_path = null, $position = 'contents' ) {
		$this->file_path = $file_path;
		$this->data      = $data;
		$this->output    = $output;
		$this->position  = $position;
		$this->base_path = $base_path;
	}

	/**
	 * @param $output
	 *
	 * @return $this
	 * @since 1.0
	 */
	public function set_output( $output ) {
		$this->output = $output;

		return $this;
	}

	/**
	 * @param $key mixed
	 * @param string $value
	 *
	 * @return $this
	 * @since 1.0
	 */
	public function with( $key, $value = '' ) {
		if ( is_array( $key ) ) {
			foreach ( $key as $k => $v ) {
				$this->data[ $k ] = apply_filters( 'wd_view_param_' . $k, $v, $this );
			}
		} else {
			$this->data[ $key ] = apply_filters( 'wd_view_param_' . $key, $value, $this );
		}

		return $this;
	}

	/**
	 * @param string $path
	 * @param array $data
	 *
	 * @return string
	 * @since 1.0
	 */
	public function render( $path = '', $data = array() ) {
		if ( ! empty( $path ) ) {
			$this->file_path = $path;
		}

		if ( is_array( $data ) && count( $data ) ) {
			$this->with( $data );
		}
		//we need to check does the path exists
		$tmp = $this->file_exists( $this->file_path );
		if ( $tmp instanceof WP_Error ) {
			return $tmp;
		}

		$this->data      = apply_filters( 'wd_view_data', $this->data, $this );
		$this->file_path = apply_filters( 'wd_view_path', $tmp, $this );
		ob_start();
		extract( $this->data );
		include $this->file_path;
		$variable = $this->position;
		$final    = $contents = ob_get_clean();

		if ( $this->parent_template !== false ) {
			$tmp = $this->file_exists( $this->parent_template );
			if ( $tmp instanceof WP_Error ) {
				return $tmp;
			}

			ob_start();
			include $tmp;
			$final = ob_get_clean();
			$final = str_replace( "{{{$variable}}}", $contents, $final );
		}

		$final = apply_filters( 'wd_view_output', $final, $this );

		if ( $this->output ) {
			echo $final;
		} else {
			return $final;
		}
	}

	/**
	 * This will verify if the view file exist, and return physical path of the view
	 *
	 * @param $path
	 *
	 * @return string|WP_Error
	 */
	private function file_exists( $path ) {
		if ( ! file_exists( $path ) ) {
			$base_path = '';
			if ( empty( $this->base_path ) ) {
				$base_path = wp_defender()->get_plugin_path() . 'app/view/';
			} else {
				$base_path = $this->base_path . 'view/';
			}
			$path = $base_path . $path . '.php';
			if ( ! file_exists( $path ) ) {
				return new WP_Error( 'not_exists', esc_html__( "The view " . $path . " doesn't exists", wp_defender()->domain ) );
			}
		}

		return $path;
	}

	/**
	 * @param $path
	 * @param array $data
	 * @param bool|true $output
	 * @param string $position
	 *
	 * @return string
	 */
	public static function make( $path, $data = array(), $output = true, $position = 'content' ) {
		$view = new WD_View( $path, $data, $output, $position );
		if ( $output ) {
			$view->render();
		} else {
			return $view->render();
		}
	}
}