<?php

class UM_Reviews_Shortcode {

	function __construct() {
	
		add_shortcode('ultimatemember_top_rated', array(&$this, 'ultimatemember_top_rated'), 1);
		add_shortcode('ultimatemember_most_rated', array(&$this, 'ultimatemember_most_rated'), 1);
		add_shortcode('ultimatemember_lowest_rated', array(&$this, 'ultimatemember_lowest_rated'), 1);
		
	}
	
	/***
	***	@Shortcode
	***/
	function ultimatemember_most_rated( $args = array() ) {
		global $um_reviews;
		
		$defaults = array(
			'roles' => 0,
			'number' => 5
		);
		$args = wp_parse_args( $args, $defaults );
		extract( $args );

		ob_start();
		
		$query_args = array(
			'fields' => 'ID',
			'number' => $number,
			'meta_key' => '_reviews_total',
			'orderby' => 'meta_value',
			'order' => 'desc'
		);

		if ( isset( $roles ) && $roles != 'all' ) {
			$query_args['meta_query'][] = array(
				'key' => 'role',
				'value' => $roles,
				'compare' => '='
			);
		}

		$users = new WP_User_Query( $query_args );

		?>
		
		<ul class="um-reviews-widget top-rated">
		
			<?php foreach( $users->results as $user_id ) {
				
				um_fetch_user( $user_id );

				$count = $um_reviews->api->get_reviews_count( $user_id ); ?>
			
			<li>
			
				<div class="um-reviews-widget-pic">
					<a href="<?php echo um_user_profile_url(); ?>"><?php echo get_avatar( $user_id, 40 ); ?></a>
				</div>
				
				<div class="um-reviews-widget-user">
				
					<div class="um-reviews-widget-name"><a href="<?php echo um_user_profile_url(); ?>"><?php echo um_user('display_name'); ?></a></div>
					
					<div class="um-reviews-widget-rating"><span class="um-reviews-avg" data-number="5" data-score="<?php echo $um_reviews->api->get_rating( $user_id ); ?>"></span></div>

					<?php if ( $count == 1 ) { ?>
					<div class="um-reviews-widget-avg"><?php printf(__('%s average based on %s review','um-reviews'), $um_reviews->api->get_avg_rating( $user_id ), $count ); ?></div>
					<?php } else { ?>
					<div class="um-reviews-widget-avg"><?php printf(__('%s average based on %s reviews','um-reviews'), $um_reviews->api->get_avg_rating( $user_id ), $count ); ?></div>
					<?php } ?>
			
				</div><div class="um-clear"></div>
				
			</li>
			
			<?php } ?>
			
		</ul>
		
		<?php
		
		$output = ob_get_contents();
		ob_end_clean();
		return $output;
	}
	
	/***
	***	@Shortcode
	***/
	function ultimatemember_top_rated( $args = array() ) {
		global $um_reviews;
		
		$defaults = array(
			'roles' => 0,
			'number' => 5
		);
		$args = wp_parse_args( $args, $defaults );
		extract( $args );

		ob_start();
		
		$query_args = array(
			'fields' => 'ID',
			'number' => $number,
			'meta_key' => '_reviews_avg',
			'orderby' => 'meta_value',
			'order' => 'desc'
		);
		
		if ( isset( $roles ) && $roles != 'all' ) {
			$query_args['meta_query'][] = array(
				'key' => 'role',
				'value' => $roles,
				'compare' => '='
			);
		}

		$users = new WP_User_Query( $query_args );

		?>
		
		<ul class="um-reviews-widget top-rated">
		
			<?php foreach( $users->results as $user_id ) {
				
				um_fetch_user( $user_id );

				$count = $um_reviews->api->get_reviews_count( $user_id ); ?>
			
			<li>
			
				<div class="um-reviews-widget-pic">
					<a href="<?php echo um_user_profile_url(); ?>"><?php echo get_avatar( $user_id, 40 ); ?></a>
				</div>
				
				<div class="um-reviews-widget-user">
				
					<div class="um-reviews-widget-name"><a href="<?php echo um_user_profile_url(); ?>"><?php echo um_user('display_name'); ?></a></div>
					
					<div class="um-reviews-widget-rating"><span class="um-reviews-avg" data-number="5" data-score="<?php echo $um_reviews->api->get_rating( $user_id ); ?>"></span></div>

					<?php if ( $count == 1 ) { ?>
					<div class="um-reviews-widget-avg"><?php printf(__('%s average based on %s review','um-reviews'), $um_reviews->api->get_avg_rating( $user_id ), $count ); ?></div>
					<?php } else { ?>
					<div class="um-reviews-widget-avg"><?php printf(__('%s average based on %s reviews','um-reviews'), $um_reviews->api->get_avg_rating( $user_id ), $count ); ?></div>
					<?php } ?>
			
				</div><div class="um-clear"></div>
				
			</li>
			
			<?php } ?>
			
		</ul>
		
		<?php
		
		$output = ob_get_contents();
		ob_end_clean();
		return $output;
	}
	
	/***
	***	@Shortcode
	***/
	function ultimatemember_lowest_rated( $args = array() ) {
		global $um_reviews;
		
		$defaults = array(
			'roles' => 0,
			'number' => 5
		);
		$args = wp_parse_args( $args, $defaults );
		extract( $args );
		
		ob_start();
		
		$query_args = array(
			'fields' => 'ID',
			'number' => $number,
			'meta_key' => '_reviews_avg',
			'orderby' => 'meta_value',
			'order' => 'asc'
		);
		
		if ( isset( $roles ) && $roles != 'all' ) {
			$query_args['meta_query'][] = array(
				'key' => 'role',
				'value' => $roles,
				'compare' => '='
			);
		}

		$users = new WP_User_Query( $query_args );

		?>
		
		<ul class="um-reviews-widget top-rated">
		
			<?php foreach( $users->results as $user_id ) {
				
				um_fetch_user( $user_id );

				$count = $um_reviews->api->get_reviews_count( $user_id ); ?>
			
			<li>
			
				<div class="um-reviews-widget-pic">
					<a href="<?php echo um_user_profile_url(); ?>"><?php echo get_avatar( $user_id, 40 ); ?></a>
				</div>
				
				<div class="um-reviews-widget-user">
				
					<div class="um-reviews-widget-name"><a href="<?php echo um_user_profile_url(); ?>"><?php echo um_user('display_name'); ?></a></div>
					
					<div class="um-reviews-widget-rating"><span class="um-reviews-avg" data-number="5" data-score="<?php echo $um_reviews->api->get_rating( $user_id ); ?>"></span></div>

					<?php if ( $count == 1 ) { ?>
					<div class="um-reviews-widget-avg"><?php printf(__('%s average based on %s review','um-reviews'), $um_reviews->api->get_avg_rating( $user_id ), $count ); ?></div>
					<?php } else { ?>
					<div class="um-reviews-widget-avg"><?php printf(__('%s average based on %s reviews','um-reviews'), $um_reviews->api->get_avg_rating( $user_id ), $count ); ?></div>
					<?php } ?>
			
				</div><div class="um-clear"></div>
				
			</li>
			
			<?php } ?>
			
		</ul>
		
		<?php
		
		$output = ob_get_contents();
		ob_end_clean();
		return $output;
	}

}