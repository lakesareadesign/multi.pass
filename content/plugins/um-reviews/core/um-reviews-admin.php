<?php

class UM_Reviews_Admin {

	function __construct() {
	
		$this->slug = 'ultimatemember';
		$this->pagehook = 'toplevel_page_ultimatemember';
		
		add_action('um_extend_admin_menu',  array(&$this, 'um_extend_admin_menu'), 5);
		
		add_action('admin_enqueue_scripts',  array(&$this, 'admin_enqueue_scripts'), 10);
		
		add_filter('views_edit-um_review', array(&$this, 'views_um_review') );
		add_filter('parse_query', array(&$this, 'parse_query') );
		
	}
	
	function parse_query($q) {
		global $pagenow;

		if ($pagenow == 'edit.php' && isset($_GET['post_type']) && $_GET['post_type']=='um_review' ) {

			if ( isset( $_REQUEST['status'] ) && !empty( $_REQUEST['status'] ) ) {
				
				if ( $_REQUEST['status'] == 'flagged' ) {
				$q->set( 'meta_key', '_flagged' );
				$q->set( 'meta_value', 1 );
				$q->set( 'meta_compare', '=' );
				}
				
				if ( $_REQUEST['status'] == 'approved' ) {
				$q->set( 'meta_key', '_status' );
				$q->set( 'meta_value', 1 );
				$q->set( 'meta_compare', '=' );
				}
				
				if ( $_REQUEST['status'] == 'pending' ) {
				$q->set( 'meta_key', '_status' );
				$q->set( 'meta_value', 0 );
				$q->set( 'meta_compare', '=' );
				}
			
			}
			
		}
		
		return $q;
		
	}
	
	/***
	***	@filters
	***/
	function views_um_review( $views ) {
		global $ultimatemember, $query;

		if ( isset( $views['trash'] ) )
			$trash['trash'] = $views['trash'];
		
		$views = array();

		$array['all'] = __('All','um-reviews');
		$array['approved'] = __('Approved','um-reviews');
		$array['flagged'] = __('Flagged','um-reviews');
		$array['pending'] = __('Pending','um-reviews');

		foreach( $array as $view => $name ) {
			if ( isset( $_REQUEST['status'] ) && $_REQUEST['status'] == $view ) {
				$class = 'current';
			} else {
				$class = '';
			}
			$views[ $view ] = '<a href="?post_type=um_review&status='.$view.'" class="'.$class.'">' . $name . '</a>';
		}
		
		if ( isset( $trash['trash'] ) )
			$views['trash'] = $trash['trash'];

		return $views;
	}

	/***
	***	@extends the admin menu
	***/
	function um_extend_admin_menu() {

		add_submenu_page( $this->slug, __('User Reviews','um-reviews'), __('User Reviews','um-reviews'), 'manage_options', 'edit.php?post_type=um_review', '', '' );
		
	}
	
	/***
	***	@admin styles
	***/
	function admin_enqueue_scripts() {
		
		$screen = get_current_screen();
		
		if ( !isset( $screen->id ) ) return;
		if ( !strstr( $screen->id, 'um_review' ) ) return;

		wp_register_style('um_admin_reviews', um_reviews_url . 'admin/assets/css/um-admin-reviews.css' );
		wp_enqueue_style('um_admin_reviews');
		
		wp_register_script('um_admin_reviews', um_reviews_url . 'admin/assets/js/um-admin-reviews.js', '', '', true );
		wp_enqueue_script('um_admin_reviews');
		
	}

}