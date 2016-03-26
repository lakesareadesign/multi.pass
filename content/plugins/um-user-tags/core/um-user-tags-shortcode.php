<?php

class UM_User_Tags_Shortcode {

	function __construct() {
	
		add_shortcode('ultimatemember_tags', array(&$this, 'ultimatemember_tags'), 1);

	}

	/***
	***	@Shortcode
	***/
	function ultimatemember_tags( $args = array() ) {
		global $ultimatemember, $um_online;

		$defaults = array(
			'term_id' 		=> 0,
			'number' 		=> 0,
			'orderby'		=> 'count',
			'order'		    => 'desc'
		);
		$args = wp_parse_args( $args, $defaults );
		extract( $args );
		
		if ( !$term_id )
			return;

		ob_start();
		
		if ( $orderby != 'count' )
			$order = 'asc';
		
		$terms = get_terms( 'um_user_tag', array(
				'hide_empty' => 0,
				'orderby' => 'count',
				'order' => 'desc',
				'parent' => $term_id,
				'number' => $number,
				'orderby' => $orderby,
				'order' => $order
		) );
		
		if ( !$terms ) {
			echo __('There are no tags to display.','um-user-tags');
		}
		
		if ( $terms ) {
		
			$members_page = um_get_option('members_page');
			
			$tags = get_option('um_user_tags_filters');
			if ( !$tags ) {
				$members_page = 0;
			} else {
				if ( isset( $tags[$term_id] ) ) {
					$members_page = 1;
				} else {
					$members_page = 0;
				}
			}
			
			if ( $members_page == 1 ) {
				$link = um_get_core_page('members');
			}
			
			echo '<div class="um-user-tags-wdgt">';
			foreach( $terms as $term ) {
				if ( $members_page ) {
					$link = add_query_arg( $tags[$term_id], $term->slug, $link );
					echo '<div class="um-user-tags-wdgt-item"><a href="' . $link . '" class="tag">' . $term->name . '</a><span class="count">' . $term->count . '</span></div>';
				} else {
					echo '<div class="um-user-tags-wdgt-item"><span class="tag">' . $term->name . '</span><span class="count">' . $term->count . '</span></div>';
				}
			}
			echo '</div>';
		}
		
		$output = ob_get_contents();
		ob_end_clean();
		return $output;
	}

}