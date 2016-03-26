<?php

class UM_Activity_Cols {

	function __construct() {
		
		add_filter('manage_edit-um_activity_columns', array(&$this, 'manage_edit_um_activity_columns') );
		add_action('manage_um_activity_posts_custom_column', array(&$this, 'manage_um_activity_posts_custom_column'), 10, 3);
		
	}
	
	/***
	***	@Custom columns
	***/
	function manage_edit_um_activity_columns($columns) {
	
		$admin = new UM_Admin_Metabox();
		
		unset( $columns['title'] );
		unset( $columns['tags'] );
		unset( $columns['date'] );

		$columns['a_author'] = __('Author','um-activity');
		$columns['a_content'] = __('Content','um-activity');
		$columns['a_hashtags'] = __('Hashtags','um-activity');
		$columns['a_likes'] = __('Likes','um-activity');
		$columns['a_comments'] = __('Comments','um-activity');
		$columns['a_action'] = __('Action','um-activity');
		
		return $columns;
		
	}
	
	/***
	***	@Display cusom columns
	***/
	function manage_um_activity_posts_custom_column($column_name, $id) {
		global $wpdb, $ultimatemember, $um_activity;
		
		switch ($column_name) {

			case 'a_hashtags':
				$hashtags = wp_get_post_terms( $id, 'um_hashtag', $args = array('orderby' => 'count', 'order' => 'desc', 'fields' => 'all') );
				$res = '';
				if ( $hashtags ) {
					foreach( $hashtags as $hashtag ) {
						$res .= '<a target="_blank" href="' .add_query_arg( 'hashtag', $hashtag->slug, um_get_core_page('activity') ) . '">#' . $hashtag->name . '</a> ('.$hashtag->count.')&nbsp;&nbsp;';
					}
				}
				echo $res;
				break;
				
			case 'a_author':
				um_fetch_user( $um_activity->api->get_author( $id ) );
				echo '<a href="'. um_user_profile_url() . '" target="_blank" title="'. um_user('display_name') .'" class="authorimg">' . get_avatar( um_user('ID'), 30 ) . '</a>';
				break;
				
			case 'a_content':
			
				$link = get_post_meta( get_the_ID(), '_shared_link', true );
				
				echo '<a href="' . get_edit_post_link( $id ) . '" class="um-admin-tipsy-s" title="'.__('Edit','um-activity').'"><strong>'. $um_activity->api->get_post_time( $id ) . '</strong></a> - <a href="' . $um_activity->api->get_permalink( $id ) . '" target="_blank">' .__('Permalink','um-activity').'</a>';
				echo '<div class="um-admin-activity-c">' . $um_activity->api->get_content() . '</div>';
				echo '<div class="um-admin-activity-ph">' .  $um_activity->api->get_photo( get_the_ID(), 'backend' ) .'</div>';
				echo '<div class="um-admin-activity-if">' .  $um_activity->api->get_video( get_the_ID(), array( 'width' => 300 ) ) .'</div>';
				if ( $link ) {
					echo '<div class="um-activity-bodyinner-txt"> ' . $link . '</div>';
				}
				
				if ( $um_activity->api->reported( $id ) ) {
					$clear_report = add_query_arg( 'um_adm_action', 'wall_report' );
					$clear_report = add_query_arg( 'post_id', $id, $clear_report );
					echo '<div class="um-admin-activity-reported">' . sprintf(__('This post is flagged by community. <a href="%s">Clear report</a>','um-activity'), $clear_report ) . '</div>';
				}
				
				break;
				
			case 'a_likes':
				echo $um_activity->api->get_likes_number( $id );
				break;
				
			case 'a_comments':
				echo $um_activity->api->get_comments_number( $id );
				break;

			case 'a_action':
				echo $um_activity->api->get_action( $id );
				if ( $um_activity->api->get_wall( $id ) && $um_activity->api->get_author( $id ) != $um_activity->api->get_wall( $id ) ) {
					um_fetch_user( $um_activity->api->get_wall( $id ) );
					echo '<div class="um-admin-activity-resp"><i class="um-icon-forward"></i><a href="'. um_user_profile_url(). '" target="_blank">' . get_avatar(  um_user('ID'), 30 )  . um_user('display_name') . '</a></div>';
				}
				break;
				
		}
		
	}
	
}