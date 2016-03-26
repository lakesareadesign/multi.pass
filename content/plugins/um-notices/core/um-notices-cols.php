<?php

class UM_Notices_Cols {

	function __construct() {
		
		add_filter('manage_edit-um_notice_columns', array(&$this, 'manage_edit_um_notice_columns') );
		add_action('manage_um_notice_posts_custom_column', array(&$this, 'manage_um_notice_posts_custom_column'), 10, 3);
		
	}
	
	/***
	***	@add columns
	***/
	function manage_edit_um_notice_columns($columns) {
		$metabox = new UM_Admin_Metabox();
		$columns['shortcode'] = __('Shortcode','um-notices');
		$columns['reach'] = __('Reach','um-notices') . $metabox->_tooltip( __('How many people reached this notice? Count users who seen and closed the notice only','um-notices') );
		return $columns;
	}
	
	/***
	***	@show columns
	***/
	function manage_um_notice_posts_custom_column($column_name, $id) {

		switch ($column_name) {
			case 'shortcode':
				echo '[ultimatemember_notice id='. $id .']';
				break;
			case 'reach':
				$count = 0;
				$users = get_post_meta( $id, '_users', true );
				if ( is_array( $users ) )
					$count = count($users);
				
				echo '<span class="um-admin-icontext"><i class="um-icon-stats-bars"></i> ' . $count .'</span>';
		}

	}
	
}