<?php

class UM_Reviews_API {

	function __construct() {

		$this->plugin_inactive = false;
		
		add_action('init', array(&$this, 'plugin_check'), 1);
		
		add_action('init', array(&$this, 'init'), 1);
	
		require_once um_reviews_path . 'core/um-reviews-widget.php';
		add_action( 'widgets_init', array(&$this, 'widgets_init' ) );

	}
	
	/***
	***	@Check plugin requirements
	***/
	function plugin_check(){
		
		if ( !class_exists('UM_API') ) {
			
			$this->add_notice( sprintf(__('The <strong>%s</strong> extension requires the Ultimate Member plugin to be activated to work properly. You can download it <a href="https://wordpress.org/plugins/ultimate-member">here</a>','um-reviews'), um_reviews_extension) );
			$this->plugin_inactive = true;
		
		} else if ( !version_compare( ultimatemember_version, um_reviews_requires, '>=' ) ) {
			
			$this->add_notice( sprintf(__('The <strong>%s</strong> extension requires a <a href="https://wordpress.org/plugins/ultimate-member">newer version</a> of Ultimate Member to work properly.','um-reviews'), um_reviews_extension) );
			$this->plugin_inactive = true;
		
		} else if ( !get_option('__ultimatemember_reviews_setup') ) {
			
			$this->add_notice( sprintf(__('The user reviews add-on needs some setup. <a href="%s">Run setup</a>','um-reviews'), add_query_arg('um-setup', 'reviews') ) );
			$this->plugin_inactive = true;
			
		}
		
	}
	
	/***
	***	@Add notice
	***/
	function add_notice( $msg ) {
		
		if ( !is_admin() ) return;
		
		echo '<div class="error"><p>' . $msg . '</p></div>';
		
	}
	
	/***
	***	@Run setup
	***/
	function run_setup() {
		
		$users = get_users( array('fields' => 'ID') );
		foreach( $users as $user_id ) {
			$avg_review = get_user_meta( $user_id, '_reviews_avg', true );
			if ( !$avg_review ) {
				update_user_meta( $user_id, '_reviews_avg', 0.00 );
				update_user_meta( $user_id, '_reviews_total', 0.00 );
			}
		}
		
		update_option('__ultimatemember_reviews_setup', true );
		exit( wp_redirect('edit.php?post_type=um_review') );
		
	}
	
	/***
	***	@Init
	***/
	function init() {
		
		if ( isset( $_REQUEST['um-setup'] ) && $_REQUEST['um-setup'] == 'reviews' && is_admin() && current_user_can('manage_options') ) {
			$this->run_setup();
		}
		
		if ( $this->plugin_inactive ) return;

		// Required classes
		require_once um_reviews_path . 'core/um-reviews-api.php';
		require_once um_reviews_path . 'core/um-reviews-enqueue.php';
		require_once um_reviews_path . 'core/um-reviews-taxonomies.php';
		require_once um_reviews_path . 'core/um-reviews-admin.php';
		require_once um_reviews_path . 'core/um-reviews-cols.php';
		require_once um_reviews_path . 'core/um-reviews-metabox.php';
		require_once um_reviews_path . 'core/um-reviews-shortcode.php';

		$this->enqueue = new UM_Reviews_Enqueue();
		$this->api = new UM_Reviews_API_Core();
		$this->taxonomies = new UM_Reviews_Taxonomies();
		$this->admin = new UM_Reviews_Admin();
		$this->cols = new UM_Reviews_Cols();
		$this->metabox = new UM_Reviews_Metabox();
		$this->shortcode = new UM_Reviews_Shortcode();
		
		// Actions
		require_once um_reviews_path . 'core/actions/um-reviews-tabs.php';
		require_once um_reviews_path . 'core/actions/um-reviews-ajax.php';
		require_once um_reviews_path . 'core/actions/um-reviews-trash.php';
		require_once um_reviews_path . 'core/actions/um-reviews-admin.php';
		require_once um_reviews_path . 'core/actions/um-reviews-controls.php';
		require_once um_reviews_path . 'core/actions/um-reviews-members.php';
		
		// Filters
		require_once um_reviews_path . 'core/filters/um-reviews-tabs.php';
		require_once um_reviews_path . 'core/filters/um-reviews-settings.php';
		require_once um_reviews_path . 'core/filters/um-reviews-permissions.php';
		require_once um_reviews_path . 'core/filters/um-reviews-fields.php';
		require_once um_reviews_path . 'core/filters/um-reviews-search.php';
		
	}
	
	function widgets_init() {
		
		register_widget( 'um_reviews_top_rated' );
		register_widget( 'um_reviews_most_rated' );
		register_widget( 'um_reviews_lowest_rated' );

	}

}

$um_reviews = new UM_Reviews_API();