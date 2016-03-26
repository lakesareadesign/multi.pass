<?php

class UM_User_Tags_API {
	
	public $filters = array();
	
	function __construct() {

		$this->plugin_inactive = false;
		
		add_action('init', array(&$this, 'plugin_check'), 1);
		
		add_action('init', array(&$this, 'register_taxonomy'), -1);
		add_action('init', array(&$this, 'init'), 1);

		require_once um_user_tags_path . 'core/um-user-tags-widget.php';
		add_action( 'widgets_init', array(&$this, 'widgets_init' ) );
		
	}
	
	/***
	***	@Check plugin requirements
	***/
	function plugin_check(){
		
		if ( !class_exists('UM_API') ) {
			
			$this->add_notice( sprintf(__('The <strong>%s</strong> extension requires the Ultimate Member plugin to be activated to work properly. You can download it <a href="https://wordpress.org/plugins/ultimate-member">here</a>','um-user-tags'), um_user_tags_extension) );
			$this->plugin_inactive = true;
		
		} else if ( !version_compare( ultimatemember_version, um_user_tags_requires, '>=' ) ) {
			
			$this->add_notice( sprintf(__('The <strong>%s</strong> extension requires a <a href="https://wordpress.org/plugins/ultimate-member">newer version</a> of Ultimate Member to work properly.','um-user-tags'), um_user_tags_extension) );
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
	***	@Early setup of taxonomy
	***/
	function register_taxonomy() {
		require_once um_user_tags_path . 'core/um-user-tags-taxonomies.php';
		$this->taxonomies = new UM_User_Tags_Taxonomies();
	}

	/***
	***	@Init
	***/
	function init() {

		if ( $this->plugin_inactive ) return;
		
		require_once um_user_tags_path . 'core/um-user-tags-admin.php';
		require_once um_user_tags_path . 'core/um-user-tags-enqueue.php';
		require_once um_user_tags_path . 'core/um-user-tags-shortcode.php';
	
		$this->admin = new UM_User_Tags_Admin();
		$this->enqueue = new UM_User_Tags_Enqueue();
		$this->shortcode = new UM_User_Tags_Shortcode();
		
		require_once um_user_tags_path . 'core/actions/um-user-tags-fields.php';
		require_once um_user_tags_path . 'core/actions/um-user-tags-profile.php';
		require_once um_user_tags_path . 'core/actions/um-user-tags-admin.php';
		
		require_once um_user_tags_path . 'core/filters/um-user-tags-fields.php';
		require_once um_user_tags_path . 'core/filters/um-user-tags-settings.php';

	}
	
	/***
	***	@Get user tags by metakey
	***/
	function get_tags( $user_id, $metakey ) {
		
		$tags = get_user_meta( $user_id, $metakey, true );
		
		if ( !$tags )
			return;
		
		$limit = um_get_option('user_tags_max_num');
		
		$value = '';
		$value .= '<span class="um-user-tags">';
		
		$i = 0;
		$remaining = 0;
		
		$link = um_get_core_page('members');
		
		foreach( $tags as $tag ) {
			$i++;
			
			$term = get_term_by('slug', $tag, 'um_user_tag');
			
			$class = 'um-user-tag um-tag-'. $term->slug;
			if ( $term->description ) {
				$class .= ' um-user-tag-desc';
			}
			
			if ( $limit > 0 && $i > $limit ) {
				$class .= ' um-user-hidden-tag';
				$remaining++;
			}
			
			if ( um_get_option('members_page') ) {
				$link = add_query_arg( $metakey, $term->slug, $link );
				$value .= '<span class="'. $class . '" title="'. $term->description . '"><a href="' . $link . '">' . $term->name . '</a></span>';
			} else {
				$value .= '<span class="'. $class . '" title="'. $term->description . '">' . $term->name . '</span>';
			}

		}
		
			if ( $remaining > 0 ) {
				$value .= '<span class="um-user-tag um-user-tag-more"><a href="#">' . sprintf(__('%s more','um-user-tags'), $remaining) . '</a></span>';
			}
		
		$value .= '</span><div class="um-clear"></div>';
		
		return $value;
	}
	
	function widgets_init() {
		register_widget( 'um_user_tags' );
	}
	
}

$um_user_tags = new UM_User_Tags_API();