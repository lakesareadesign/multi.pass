<?php
/**
 * Analysis (SEO and Readability) wiring hub.
 *
 * @package wpmu-dev-seo
 */

if ( ! class_exists( 'Smartcrawl_Model_Analysis' ) ) { require_once( SMARTCRAWL_PLUGIN_DIR . '/core/class_wds_model_analysis.php' ); }
if ( ! class_exists( 'Smartcrawl_Renderable' ) ) { require_once( SMARTCRAWL_PLUGIN_DIR . '/core/class_wds_renderable.php' ); }

/**
 * Analysis controller
 *
 * At the same time, some rendering duties.
 */
class Smartcrawl_Controller_Analysis extends Smartcrawl_Renderable {

	const DATA_ANALYSIS = 'analysis';
	const DATA_READABILITY = 'readability';

	/**
	 * Singleton instance
	 *
	 * @var Smartcrawl_Controller_Analysis
	 */
	private static $_instance;

	/**
	 * Currently running state flag
	 *
	 * @var bool
	 */
	private $_is_running = false;

	/**
	 * Constructor
	 */
	private function __construct() {}

	/**
	 * Boot controller listeners
	 *
	 * Do it only once, if they're already up do nothing
	 *
	 * @return bool Status
	 */
	public static function serve() {
		$me = self::get();
		if ( $me->is_running() ) { return false; }

		return $me->_add_hooks();
	}

	/**
	 * Stop and remove action listeners
	 *
	 * @return bool
	 */
	public static function stop() {
		$me = self::get();
		if ( ! $me->is_running() ) { return false; }

		return $me->_remove_hooks();
	}

	/**
	 * Obtain instance without booting up
	 *
	 * @return Smartcrawl_Controller_Analysis instance
	 */
	public static function get() {
		if ( empty( self::$_instance ) ) { self::$_instance = new self; }
		return self::$_instance;
	}

	/**
	 * Bind listening actions
	 *
	 * @return bool
	 */
	private function _add_hooks() {
		// Run fresh analysis on each post save.
		add_action( 'save_post', array( $this, 'analyze_post' ) );

		// Fetch analysis data via AJAX POST request.
		add_action( 'wp_ajax_wds-analysis-get-data', array( $this, 'json_get_post_analysis_data' ) );
		add_action( 'wp_ajax_wds-analysis-get-markup', array( $this, 'json_get_post_analysis_markup' ) );
		add_action( 'wp_ajax_wds-analysis-recheck', array( $this, 'json_get_post_analysis_recheck' ) );
		add_action( 'wp_ajax_wds-analysis-get-editor-analysis', array( $this, 'json_get_post_editor_analysis' ) );

		add_action( 'wp_ajax_wds-analysis-ignore-check', array( $this, 'json_set_ignore_check' ) );
		add_action( 'wp_ajax_wds-analysis-unignore-check', array( $this, 'json_unset_ignore_check' ) );

		// Set up CPT columns filtering.
		add_action( 'admin_init', array( $this, 'set_up_post_columns' ) );

		add_action( 'parse_query', array( $this, 'apply_analysis_post_list_filter' ) );

		add_action( 'post_submitbox_misc_actions', array( $this, 'add_postbox_fields' ) );
		add_action( 'wds-editor-metabox-seo-analysis', array( $this, 'add_seo_analysis_metabox_content' ) );
		add_action( 'wds-editor-metabox-readability-analysis', array( $this, 'add_readability_analysis_metabox_content' ) );

		add_action( 'admin_enqueue_scripts', array( $this, 'inject_script_dependencies' ) );

		return $this->_is_running = true;
	}

	/**
	 * Applies filtering by analysis threshold
	 *
	 * Used on post list table pages
	 *
	 * @param object $query Query to augment.
	 *
	 * @return bool
	 */
	public function apply_analysis_post_list_filter( $query ) {
		if (
			! isset( $_GET['wds_analysis_threshold'] )
			&&
			! isset( $_GET['wds_readability_threshold'] )
		) { return false; }
		if ( ! is_admin() ) { return false; }
		if ( ! function_exists( 'get_current_screen' ) ) { return false; }

		$screen = get_current_screen();
		if ( ! is_object( $screen ) || empty( $screen->base ) ) { return false; }
		if ( 'edit' !== $screen->base ) { return false; }

		$pt = ! empty( $screen->post_type ) ? $screen->post_type : false;
		if ( $query->get( 'post_type' ) !== $pt ) { return false; }

		$meta_queries = $query->get( 'meta_query', array() );

		// Set SEO analysis threshold meta query.
		if ( isset( $_GET['wds_analysis_threshold'] ) ) {
			$raw = ! empty( $_GET['wds_analysis_threshold'] ) && is_numeric( $_GET['wds_analysis_threshold'] )
				? (int) $_GET['wds_analysis_threshold'] . ''
				: '69'
			;
			if ( empty( $raw ) ) { return false; }

			$rx = '';
			foreach ( str_split( $raw ) as $char ) {
				$rx .= ! empty( $char )
					? '[0-' . (int) $char . ']?'
					: '0?'
				;
			}
			$rx = substr( $rx, 0, strlen( $rx ) -1 ); // Strip last question mark.
			$meta_queries[] = array(
				'key' => Smartcrawl_Model_Analysis::META_KEY_ANALYSIS,
				'value' => '[[:punct:]]percentage[[:punct:]];i:' . $rx . ';',
				'compare' => 'REGEXP',
			);
		}

		// Set readability meta query.
		if ( isset( $_GET['wds_readability_threshold'] ) ) {
			// Filter by just readable/not readable.
			$readable = ! empty( $_GET['wds_readability_threshold'] ) ? 1 : 0;
			$meta_queries[] = array(
				'key' => Smartcrawl_Model_Analysis::META_KEY_READABILITY,
				'value' => '[[:punct:]]is_readable[[:punct:]];b:' . (int) $readable . ';',
				'compare' => 'REGEXP',
			);
		}

		if ( ! empty( $meta_queries ) ) { $query->set( 'meta_query', $meta_queries ); }

		return true;
	}

	/**
	 * Enqueues admin scripts
	 *
	 * @param string $hook Page hook.
	 *
	 * @return bool Status
	 */
	public function inject_script_dependencies( $hook ) {
		if ( 'edit.php' !== $hook ) { return false; }
		Smartcrawl_Settings_Admin::register_global_admin_scripts();
		$version = Smartcrawl_Loader::get_version();

		wp_enqueue_script(
			'wds-admin-analysis-postlist',
			SMARTCRAWL_PLUGIN_URL . 'js/wds-admin-analysis-postlist.js',
			array( 'jquery', 'wds-admin', 'wds-qtip2-script' ),
			$version
		);

		wp_enqueue_style(
			'wds-admin-analysis-postlist-styling',
			SMARTCRAWL_PLUGIN_URL . 'css/wds-admin-analysis-postlist.css',
			array( 'wds-qtip2-style' ),
			$version
		);

		return true;
	}

	/**
	 * Sets up column filtering actions
	 *
	 * @return void
	 */
	public function set_up_post_columns() {
		// Set up column filtering.
		$types = get_post_types(array(
			'public' => true,
			'show_ui' => true,
		));
		foreach ( $types as $type ) {
			add_filter( "manage_{$type}_posts_columns", array( $this, 'add_analysis_columns' ) );
			add_action( "manage_{$type}_posts_custom_column", array( $this, 'add_analysis_column_data' ), 10, 2 );
		}
	}

	/**
	 * Injects postbox publish editor content
	 *
	 * @param WP_Post $post Post instance.
	 *
	 * @return void
	 */
	public function add_postbox_fields( $post ) {
		if ( ! class_exists( 'Smartcrawl_Checks' ) ) {
			require_once( SMARTCRAWL_PLUGIN_DIR . '/core/class_wds_checks.php' );
		}

		$model = new Smartcrawl_Model_Analysis( $post->ID );
		if ( in_array( get_post_status( $post ), array( 'draft', 'auto-draft' ) ) ) {
			$result = Smartcrawl_Checks::apply( $post->ID );
			$checks = $result->get_applied_checks();
			$focus_keywords_available = isset( $checks['focus']['status'] ) ? $checks['focus']['status'] : false;
			$has_errors = false;
			foreach ( $checks as $title => $chk ) {
				if ( empty( $chk['status'] ) && empty( $chk['ignored'] ) ) {
					$has_errors = true;
					break;
				}
			}
		} else {
			$focus_keywords = smartcrawl_get_value( 'focus-keywords' );
			$focus_keywords_available = ! empty( $focus_keywords );
			$seo_data = $model->get_post_data( Smartcrawl_Model_Analysis::DATA_ANALYSIS );
			$has_errors = ! empty( $seo_data['errors'] );
		}

		if ( ! $focus_keywords_available ) {
			$seo_class = 'wds-status-invalid';
			$seo_text = __( 'No Focus Keyword', 'wds' );
		} elseif ( $has_errors ) {
			$seo_class = 'wds-status-warning';
			$seo_text = __( 'Needs Improvement', 'wds' );
		} else {
			$seo_class = 'wds-status-success';
			$seo_text = __( 'Good', 'wds' );
		}

		$readability_data = $model->get_post_data( Smartcrawl_Model_Analysis::DATA_READABILITY );
		$readability_score = smartcrawl_get_array_value( $readability_data, 'score' );
		$readability_score = intval( ceil( $readability_score ) );
		$readability_ignored = Smartcrawl_Checks::is_readability_ignored( $post->ID );
		$readability_state = $model->get_kincaid_readability_state( $readability_score, $readability_ignored );
		$readability_class = sprintf(
			'wds-status-%s',
			$readability_state
		);
		$readability_text = $model->get_readability_level();

		?>
		<div class="wds-post-box-fields">
			<?php if ( Smartcrawl_Settings::get_setting( 'analysis-seo' ) ) :  ?>
				<div class="misc-pub-section seo-analysis <?php echo $seo_class; ?>">
					<i class="wds-icon-magnifying-glass-search"></i>
					<?php _e( 'SEO:', 'wds' ) ?> <b><?php echo $seo_text; ?></b>
				</div>
			<?php endif; ?>

			<?php if ( Smartcrawl_Settings::get_setting( 'analysis-readability' ) ) :  ?>
				<div class="misc-pub-section readability-analysis <?php echo $readability_class; ?>">
					<i class="wds-icon-monitor"></i>
					<?php _e( 'Readability:', 'wds' ); ?> <b><?php echo $readability_text; ?></b>
				</div>
			<?php endif; ?>
		</div>
		<?php
	}

	/**
	 * Injects SEO analysis metabox content
	 *
	 * @param WP_Post $post Post instance.
	 *
	 * @return bool
	 */
	public function add_seo_analysis_metabox_content( $post ) {
		if ( ! Smartcrawl_Settings::get_setting( 'analysis-seo' ) ) { return false; }

		if ( ! class_exists( 'Smartcrawl_Checks' ) ) { require_once( SMARTCRAWL_PLUGIN_DIR . '/core/class_wds_checks.php' ); }
		$result = Smartcrawl_Checks::apply( $post->ID );
		$checks = $result->get_applied_checks();
		$focus_keywords_available = isset( $checks['focus']['status'] ) ? $checks['focus']['status'] : false;

		$this->_render('metabox/analysis-seo_analysis', array(
			'checks'                   => $checks,
			'error_count'              => count( $result->get_errors() ),
			'focus_keywords_available' => $focus_keywords_available,
		));

		return true;
	}

	/**
	 * Injects readability analysis metabox content
	 *
	 * @param WP_Post $post Post instance.
	 *
	 * @return bool
	 */
	public function add_readability_analysis_metabox_content( $post ) {
		if ( ! Smartcrawl_Settings::get_setting( 'analysis-readability' ) ) { return false; }

		if ( ! class_exists( 'Smartcrawl_Checks' ) ) { require_once( SMARTCRAWL_PLUGIN_DIR . '/core/class_wds_checks.php' ); }

		$this->maybe_analyze_post( $post->ID );

		$model = new Smartcrawl_Model_Analysis( $post->ID );
		$readability_data = $model->get_post_data( Smartcrawl_Model_Analysis::DATA_READABILITY );
		$readability_ignored = Smartcrawl_Checks::is_readability_ignored( $post->ID );

		$this->_render('metabox/analysis-readability', array(
			'model'               => $model,
			'readability_data'    => $readability_data,
			'readability_ignored' => $readability_ignored,
		));

		return true;
	}

	/**
	 * Injects custom columns for analysis
	 *
	 * @param array $columns Columns hash.
	 *
	 * @return array
	 */
	public function add_analysis_columns( $columns ) {
		if ( Smartcrawl_Settings::get_setting( 'analysis-seo' ) ) {
			$columns['seo'] = __( 'SEO', 'wds' );
		}
		if ( Smartcrawl_Settings::get_setting( 'analysis-readability' ) ) {
			$columns['readability'] = __( 'Readability', 'wds' );
		}

		return $columns;
	}

	/**
	 * Adds custom columns analysis data
	 *
	 * @param string $cid Column ID.
	 * @param int    $post_id Post ID.
	 *
	 * @return bool
	 */
	public function add_analysis_column_data( $cid, $post_id ) {
		if ( ! in_array( $cid, array( 'seo', 'readability' ) ) ) { return false; }

		$result = $this->get_post_analysis_result_markup( $post_id );

		if ( 'seo' === $cid ) {
			echo $result['seo'];
		}

		if ( 'readability' === $cid ) {
			echo $result['readability'];
		}

		return true;
	}

	/**
	 * Unbinds listening actions
	 *
	 * @return bool
	 */
	private function _remove_hooks() {
		remove_action( 'save_post', array( $this, 'analyze_post' ) );
		remove_action( 'wp_ajax_wds-analysis-get-data', array( $this, 'json_get_post_analysis_data' ) );
		remove_action( 'wp_ajax_wds-analysis-get-markup', array( $this, 'json_get_post_analysis_markup' ) );
		remove_action( 'wp_ajax_wds-analysis-recheck', array( $this, 'json_get_post_analysis_recheck' ) );
		remove_action( 'wp_ajax_wds-analysis-get-editor-analysis', array( $this, 'json_get_post_editor_analysis' ) );
		remove_action( 'wp_ajax_wds-analysis-ignore-check', array( $this, 'json_set_ignore_check' ) );
		remove_action( 'wp_ajax_wds-analysis-unignore-check', array( $this, 'json_unset_ignore_check' ) );
		remove_action( 'admin_init', array( $this, 'set_up_post_columns' ) );
		remove_action( 'admin_enqueue_scripts', array( $this, 'inject_script_dependencies' ) );
		remove_action( 'post_submitbox_misc_actions', array( $this, 'add_postbox_fields' ) );
		remove_action( 'wds-editor-metabox-seo-analysis', array( $this, 'add_seo_analysis_metabox_content' ) );
		remove_action( 'wds-editor-metabox-readability-analysis', array( $this, 'add_readability_analysis_metabox_content' ) );

		return ! ($this->_is_running = false);
	}

	/**
	 * Check if we already have the actions bound
	 *
	 * @return bool Status
	 */
	public function is_running() {
		return $this->_is_running;
	}

	/**
	 * Gets post analysis results markup for posts column
	 *
	 * @param int $post_id ID of the post.
	 *
	 * @return array List of column markups
	 */
	public function get_post_analysis_result_markup( $post_id ) {
		$model = new Smartcrawl_Model_Analysis( $post_id );
		$result = array(
			'seo' => '',
			'readability' => '',
		);
		$na = '<div class="wds-analysis wds-status-invalid"><span>' . esc_html( __( 'N/A', 'wds' ) ) . '</span></div>';

		if ( ! $model->has_post_data( Smartcrawl_Model_Analysis::DATA_ANALYSIS ) ) {
			$result['seo'] = $na;
		} else {
			$data = $model->get_post_data( Smartcrawl_Model_Analysis::DATA_ANALYSIS );
			if ( empty( $data['errors'] ) ) {
				$result['seo'] = '<div class="wds-analysis wds-status-success"><span>' .
					esc_html( __( 'Good', 'wds' ) ) .
				'</span></div>';
			} else {
				$percentage = ! empty( $data['percentage'] )
					? esc_html( (int) $data['percentage'] . '%' )
					: __( 'Errors:', 'wds' );
				$result['seo'] = '<div class="wds-analysis wds-status-warning" title="' . esc_attr( $percentage ) . ' "><span>' . $percentage . '</span></div>';

				$result['seo'] .= '<div class="wds-analysis-details">';
				foreach ( $data['errors'] as $key => $error ) {
					$key = esc_attr( $key );
					$result['seo'] .= "<div class='wds-error {$key}'>" . esc_html( $error ) . '</div>';
				}
				$result['seo'] .= '</div>';
			}
		}

		if ( ! $model->has_post_data( Smartcrawl_Model_Analysis::DATA_READABILITY ) ) {
			$result['readability'] = $na;
		} else {
			if ( ! class_exists( 'Smartcrawl_String' ) ) { require_once( SMARTCRAWL_PLUGIN_DIR . '/core/class_wds_string.php' ); }
			if ( ! class_exists( 'Smartcrawl_Checks' ) ) { require_once( SMARTCRAWL_PLUGIN_DIR . '/core/class_wds_checks.php' ); }

			$data = $model->get_post_data( Smartcrawl_Model_Analysis::DATA_READABILITY );
			$readability_score = intval( ceil( smartcrawl_get_array_value( $data, 'score' ) ) );
			$readability_ignored = Smartcrawl_Checks::is_readability_ignored( $post_id );
			$readability_state = $model->get_kincaid_readability_state( $readability_score, $readability_ignored );
			$readability_class = sprintf(
				'wds-status-%s',
				$readability_state
			);
			$label = $model->get_readability_level();
			$result['readability'] = '<div class="wds-analysis ' . $readability_class . '" title="' . $readability_score . '"></div>';
			$result['readability'] .= '<div class="wds-analysis-details">' . esc_html( $label ) . '</div>';
		}

		return $result;
	}

	/**
	 * Handles check ignoring front-end requests
	 *
	 * @return bool
	 */
	public function json_set_ignore_check() {
		$data = stripslashes_deep( $_POST );
		if ( empty( $data['post_id'] ) || ! is_numeric( $data['post_id'] ) ) { return wp_send_json_error(); }
		if ( empty( $data['check_id'] ) ) { return wp_send_json_error(); }

		if ( ! class_exists( 'Smartcrawl_Checks' ) ) { require_once( SMARTCRAWL_PLUGIN_DIR . '/core/class_wds_checks.php' ); }
		Smartcrawl_Checks::add_ignored_check( (int) $data['post_id'], sanitize_text_field( $data['check_id'] ) );

		$model = new Smartcrawl_Model_Analysis( (int) $data['post_id'] );
		$model->clear_cached_data();

		return wp_send_json_success();
	}

	/**
	 * Handles check de-ignoring front-end requests
	 *
	 * @return bool
	 */
	public function json_unset_ignore_check() {
		$data = stripslashes_deep( $_POST );
		if ( empty( $data['post_id'] ) || ! is_numeric( $data['post_id'] ) ) { return wp_send_json_error(); }
		if ( empty( $data['check_id'] ) ) { return wp_send_json_error(); }

		if ( ! class_exists( 'Smartcrawl_Checks' ) ) { require_once( SMARTCRAWL_PLUGIN_DIR . '/core/class_wds_checks.php' ); }
		Smartcrawl_Checks::remove_ignored_check( (int) $data['post_id'], sanitize_text_field( $data['check_id'] ) );

		$model = new Smartcrawl_Model_Analysis( (int) $data['post_id'] );
		$model->clear_cached_data();

		return wp_send_json_success();
	}

	/**
	 * Sends postbox editor JSON response with detailed post analysis
	 *
	 * @return void
	 */
	public function json_get_post_editor_analysis() {
		$data = stripslashes_deep( $_POST );
		if ( empty( $data['post_id'] ) || ! is_numeric( $data['post_id'] ) ) {
			wp_send_json_error();
			return;
		}

		/**
		 * Since this code might be running as a result of an auto-save, we might have to use the latest post revision
		 * for updated content. The SEO analysis will be run on the latest content and the checks will be rendered directly.
		 */
		$post = smartcrawl_get_post_or_latest_revision( (int) $data['post_id'] );
		$out = array();
		ob_start();
		$this->add_seo_analysis_metabox_content( $post );
		$out['seo'] = ob_get_clean();

		/**
		 * As opposed to SEO analysis which renders checks directly, the readability analysis is stored as post meta first
		 * and then that post meta is used for rendering the report. Post meta is only stored against the parent post and
		 * not individual revisions. Therefore there is no point using a revision for readability.
		 */
		ob_start();
		$post = get_post( (int) $data['post_id'] );
		$this->add_readability_analysis_metabox_content( $post );
		$out['readability'] = ob_get_clean();

		/**
		 * Like the readability report postbox fields use post meta.
		 */
		ob_start();
		$this->add_postbox_fields( $post );
		$out['postbox_fields'] = ob_get_clean();

		wp_send_json_success( $out );
	}

	/**
	 * Sends JSON response with post analysis data
	 *
	 * As a side-effect, updates the analysis if needed
	 *
	 * @return bool
	 */
	public function json_get_post_analysis_data() {
		$data = stripslashes_deep( $_POST );
		if ( empty( $data['post_id'] ) || ! is_numeric( $data['post_id'] ) ) { return wp_send_json_error(); }

		$this->maybe_analyze_post( (int) $data['post_id'] );
		$model = new Smartcrawl_Model_Analysis( (int) $data['post_id'] );

		return wp_send_json_success(array(
			'analysis' => $model->get_post_data( Smartcrawl_Model_Analysis::DATA_ANALYSIS ),
			'readability' => $model->get_post_data( Smartcrawl_Model_Analysis::DATA_READABILITY ),
			'readability_threshold' => $model->get_readability_threshold(),
			'readable' => $model->is_readable(),
		));
	}

	/**
	 * Sends JSON response with post analysis markup
	 *
	 * As a side-effect, updates the analysis if needed
	 *
	 * @return bool
	 */
	public function json_get_post_analysis_markup() {
		$data = stripslashes_deep( $_POST );
		if ( empty( $data['post_id'] ) || ! is_numeric( $data['post_id'] ) ) { return wp_send_json_error(); }

		$this->maybe_analyze_post( (int) $data['post_id'] );
		$result = $this->get_post_analysis_result_markup( (int) $data['post_id'] );

		return wp_send_json_success( $result );
	}

	/**
	 * Force analysis recheck and respond with column markup data
	 *
	 * @return bool
	 */
	public function json_get_post_analysis_recheck() {
		$data = stripslashes_deep( $_POST );
		if ( empty( $data['post_id'] ) || ! is_numeric( $data['post_id'] ) ) { return wp_send_json_error(); }

		$this->analyze_post( (int) $data['post_id'] );
		$result = $this->get_post_analysis_result_markup( (int) $data['post_id'] );

		return wp_send_json_success( $result );
	}

	/**
	 * Update post analysis data
	 *
	 * Forcefully updates the post analysis data,
	 * no questions asked
	 *
	 * @param int $post_id Post ID.
	 *
	 * @return bool Status
	 */
	public function analyze_post( $post_id ) {
		if ( empty( $post_id ) || ! is_numeric( $post_id ) ) { return false; }

		if ( ! current_user_can( 'edit_post', $post_id ) ) { return false; }

		$model = new Smartcrawl_Model_Analysis( $post_id );
		$model->update_analysis_data();
		$model->update_readability_data();

		return true;
	}

	/**
	 * Update post analysis data only if there's no such data
	 *
	 * @param int $post_id Post ID.
	 *
	 * @return bool Whether we updated the analysis data or not
	 */
	public function maybe_analyze_post( $post_id ) {
		$analyzed = false;
		if ( empty( $post_id ) || ! is_numeric( $post_id ) ) { return $analyzed; }

		$model = new Smartcrawl_Model_Analysis( $post_id );

		if ( ! $model->has_post_data( Smartcrawl_Model_Analysis::DATA_ANALYSIS ) ) {
			if ( current_user_can( 'edit_post', $post_id ) ) { $model->update_analysis_data(); }
			$analyzed = true;
		}

		if ( ! $model->has_post_data( Smartcrawl_Model_Analysis::DATA_READABILITY ) ) {
			if ( current_user_can( 'edit_post', $post_id ) ) { $model->update_readability_data(); }
			$analyzed = true;
		}

		return $analyzed;
	}

	/**
	 * View defaults implementation.
	 */
	protected function _get_view_defaults() {
		return array();
	}
}