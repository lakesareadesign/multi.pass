<?php

namespace DeliciousBrains\WP_Offload_S3\Pro;

abstract class Tool {

	/**
	 * @var \Amazon_S3_And_CloudFront_Pro
	 */
	protected $as3cf;

	/**
	 * @var string
	 */
	protected $prefix = 'wpos3';

	/**
	 * @var string
	 */
	protected $tab = 'media';

	/**
	 * @var string
	 */
	protected $type = 'tool';

	/**
	 * @var string
	 */
	protected $view = 'sidebar-block';

	/**
	 * @var int
	 */
	protected $priority = 0;

	/**
	 * @var string
	 */
	protected $tool_key;

	/**
	 * @var string
	 */
	protected $tool_slug;

	/**
	 * AS3CF_Tool constructor.
	 *
	 * @param \Amazon_S3_And_CloudFront_Pro $as3cf
	 */
	public function __construct( $as3cf ) {
		$this->as3cf     = $as3cf;
		$this->tool_slug = str_replace( array( ' ', '_' ), '-', $this->tool_key );
	}

	/**
	 * Initialize the tool.
	 */
	public function init() {
		// Load sidebar block
		add_action( 'as3cfpro_sidebar', array( $this, 'render_sidebar_block' ), $this->priority );
	}

	/**
	 * Priority
	 *
	 * @param int $priority
	 *
	 * @return $this
	 */
	public function priority( $priority ) {
		$this->priority = $priority;

		return $this;
	}

	/**
	 * Get tools key.
	 *
	 * @return string
	 */
	public function get_tool_key() {
		return $this->tool_key;
	}

	/**
	 * Get tab.
	 *
	 * @return string
	 */
	public function get_tab() {
		return $this->tab;
	}

	/**
	 * Render sidebar block.
	 */
	public function render_sidebar_block() {
		if ( ! $this->should_render() ) {
			return;
		}

		$args = $this->get_sidebar_block_args();

		if ( false !== $args ) {
			$args['id']       = $this->tool_key;
			$args['tab']      = $this->tab;
			$args['priority'] = $this->priority;
			$args['slug']     = $this->tool_slug;
			$args['type']     = $this->type;

			$this->as3cf->render_view( 'pre-sidebar-block', $args );
			$this->as3cf->render_view( $this->view, $args );
			$this->as3cf->render_view( 'post-sidebar-block', $args );
		}
	}

	/**
	 * Get sidebar block.
	 *
	 * @return string
	 */
	public function get_sidebar_block() {
		ob_start();
		$this->render_sidebar_block();
		$block = ob_get_contents();
		ob_end_clean();

		return $block;
	}

	/**
	 * Should we render the sidebar block?
	 *
	 * @return bool
	 */
	public function should_render() {
		return true;
	}

	/**
	 * Get the sidebar block args.
	 *
	 * @return false|array
	 */
	protected function get_sidebar_block_args() {
		return false;
	}

	/**
	 * Are we currently processing?
	 *
	 * @return bool
	 */
	protected function is_processing() {
		return false;
	}

	/**
	 * Get status.
	 *
	 * @return array
	 */
	public function get_status() {
		return array(
			'is_processing' => $this->is_processing(),
		);
	}

}