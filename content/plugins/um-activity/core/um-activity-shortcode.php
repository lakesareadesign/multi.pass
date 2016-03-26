<?php

class UM_Activity_Shortcode {

	function __construct() {
	
		add_shortcode('ultimatemember_wall', array(&$this, 'ultimatemember_wall'), 1);
		add_shortcode('ultimatemember_activity', array(&$this, 'ultimatemember_activity'), 1);
		
		add_shortcode('ultimatemember_trending_hashtags', array(&$this, 'ultimatemember_trending_hashtags'), 1);
		
		$this->args = array('');

	}
	
	/***
	***	@load a compatible template
	***/
	function load_template( $tpl, $post_id = 0 ) {
		global $ultimatemember, $um_activity;
		
		if ( isset( $this->args ) && $this->args ) {
			$options = $this->args;
			extract( $this->args );
		} else {
			$options = '';
		}
		
		if ( $post_id ) {
			$post_link = $um_activity->api->get_permalink( $post_id );
		}
		
		$file = um_activity_path . 'templates/' . $tpl . '.php';
		$theme_file = get_stylesheet_directory() . '/ultimate-member/templates/activity/' . $tpl . '.php';

		if ( file_exists( $theme_file ) )
			$file = $theme_file;
			
		if ( file_exists( $file ) )
			include $file;
	}
	
	/***
	***	@Shortcode
	***/
	function ultimatemember_trending_hashtags( $args = array() ) {
		global $ultimatemember, $um_activity;
		
		$defaults = array(
			'trending_days' => absint( um_get_option('activity_trending_days') ),
			'number' => 10,
		);
		
		$args = wp_parse_args( $args, $defaults );
		
		extract( $args );

		ob_start();

		global $wpdb;

		$term_ids = $wpdb->get_col("
			SELECT term_id FROM $wpdb->term_taxonomy
			INNER JOIN $wpdb->term_relationships ON $wpdb->term_taxonomy.term_taxonomy_id=$wpdb->term_relationships.term_taxonomy_id
			INNER JOIN $wpdb->posts ON $wpdb->posts.ID = $wpdb->term_relationships.object_id
			WHERE $wpdb->posts.post_type = 'um_activity' AND $wpdb->term_taxonomy.taxonomy = 'um_hashtag' AND 
			DATE_SUB(CURDATE(), INTERVAL $trending_days DAY) <= $wpdb->posts.post_date");

		if(count($term_ids) > 0){
			
			 $hashtags = get_terms( array('um_hashtag'), array(
				'orderby' => 'count',
				'order'   => 'DESC',
				'number'  => $number,
				'include' => $term_ids,
			 ));

			$file = um_activity_path . 'templates/trending.php';
			$theme_file = get_stylesheet_directory() . '/ultimate-member/templates/activity/trending.php';

			if ( file_exists( $theme_file ) )
				$file = $theme_file;
				
			if ( file_exists( $file ) )
				include $file;

		}

		$output = ob_get_contents();
		ob_end_clean();
		return $output;
	}
	
	/***
	***	@Shortcode
	***/
	function ultimatemember_wall( $args = array() ) {
		global $ultimatemember, $um_activity;
		
		$defaults = array(
			'user_id' => get_current_user_id(),
			'hashtag' => ( isset( $_GET['hashtag'] ) ) ? esc_attr( wp_strip_all_tags( $_GET['hashtag'] ) ) : '',
			'wall_post' =>  ( isset( $_GET['wall_post'] ) ) ? absint( $_GET['wall_post'] ) : '',
			'user_wall' => 1
		);
		$args = wp_parse_args( $args, $defaults );
		extract( $args );
		$this->args = $args;

		ob_start();
		
		if ( $um_activity->api->can_write() && $wall_post == 0 && !$hashtag ) {
			$this->load_template('new');
		}
		
		$per_page = ( $ultimatemember->mobile->isMobile() ) ? um_get_option('activity_posts_num_mob') : um_get_option('activity_posts_num');
		
		echo '<div class="um-activity-wall" data-user_id="'. $user_id . '" data-user_wall="'. $user_wall . '" data-per_page="' . $per_page . '">';
		
		$this->load_template('clone');
		$this->load_template('user-wall');
		
		echo '</div>';
		
		$output = ob_get_contents();
		ob_end_clean();
		return $output;
	}
	
	/***
	***	@Display activity
	***/
	function ultimatemember_activity( $args = array() ) {
		global $ultimatemember, $um_activity;
		
		$defaults = array(
			'user_id' => get_current_user_id(),
			'hashtag' => ( isset( $_GET['hashtag'] ) ) ? esc_attr( wp_strip_all_tags( $_GET['hashtag'] ) ) : '',
			'wall_post' =>  ( isset( $_GET['wall_post'] ) ) ? absint( $_GET['wall_post'] ) : '',
			'template' => 'activity',
			'mode' => 'activity',
			'form_id' => 'um_activity_id',
			'user_wall' => 0
		);
		$args = wp_parse_args( $args, $defaults );
		$this->args = $args;

		if ( isset( $args['use_globals'] ) && $args['use_globals'] == 1 ) {
			$args = array_merge( $args, $ultimatemember->shortcodes->get_css_args( $args ) );
		} else {
			$args = array_merge( $ultimatemember->shortcodes->get_css_args( $args ), $args );
		}
		
		extract( $args, EXTR_SKIP );
		
		ob_start();
		
		$per_page = ( $ultimatemember->mobile->isMobile() ) ? um_get_option('activity_posts_num_mob') : um_get_option('activity_posts_num');
		
		?>
		
		<div class="um <?php echo $ultimatemember->shortcodes->get_class( $mode ); ?> um-<?php echo $form_id; ?>">

			<div class="um-form">
			
				<?php
				if ( isset( $hashtag ) && $hashtag ) {
					$get_hashtag = get_term_by('slug', $hashtag, 'um_hashtag');
					if ( isset( $get_hashtag->name ) ) {
						echo '<div class="um-activity-bigtext">#' . $get_hashtag->name . '</div>';
					}
				}
				
				if ( $um_activity->api->can_write() ) {
					$this->load_template('new');
				}
				?>
	
				<div class="um-activity-wall" data-user_id="<?php echo $user_id; ?>" data-user_wall="<?php echo $user_wall; ?>" data-per_page="<?php echo $per_page; ?>" data-hashtag="<?php echo $hashtag; ?>">
				
					<?php $this->load_template('clone'); ?>
					<?php $this->load_template('user-wall'); ?>
		
				</div>
		
			</div>
			
		</div>

		<?php
		if ( !is_admin() && !defined( 'DOING_AJAX' ) ) {
			$ultimatemember->shortcodes->dynamic_css( $args );
		}
		
		$output = ob_get_contents();
		ob_end_clean();
		return $output;
	}

}