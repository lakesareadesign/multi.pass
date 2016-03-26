<?php

class UM_Followers_Shortcode {

	function __construct() {
	
		add_shortcode('ultimatemember_followers', array(&$this, 'ultimatemember_followers'), 1);
		add_shortcode('ultimatemember_following', array(&$this, 'ultimatemember_following'), 1);
		
		add_shortcode('ultimatemember_followers_bar', array(&$this, 'ultimatemember_followers_bar'), 1);

	}
	
	/***
	***	@shortcode
	***/
	function ultimatemember_followers_bar( $args = array() ) {
		global $ultimatemember, $um_followers;

		$defaults = array(
			'user_id' => get_current_user_id()
		);
		$args = wp_parse_args( $args, $defaults );
		extract( $args );

		ob_start();
		
		?>
		
		<div class="um-followers-bar">
		
			<div class="um-followers-rc">
				<a href="<?php echo $um_followers->api->followers_link( $user_id ); ?>" class="<?php if ( isset( $_REQUEST['profiletab'] ) && $_REQUEST['profiletab'] == 'followers' ) { echo 'current'; } ?>"><?php _e('followers','um-followers'); ?><?php echo $um_followers->api->count_followers( $user_id ); ?></a>
			</div>
			
			<div class="um-followers-rc">
				<a href="<?php echo $um_followers->api->following_link( $user_id ); ?>" class="<?php if ( isset( $_REQUEST['profiletab'] ) && $_REQUEST['profiletab'] == 'following' ) { echo 'current'; } ?>"><?php _e('following','um-followers'); ?><?php echo $um_followers->api->count_following( $user_id ); ?></a>
			</div>
			
			<?php if ( $um_followers->api->can_follow( $user_id, get_current_user_id() ) ) { ?>
			<div class="um-followers-btn">
				<?php echo $um_followers->api->follow_button( $user_id, get_current_user_id() ); ?>
				<?php do_action('um_after_follow_button_profile', $user_id ); ?>
			</div>
			<?php } ?>
			
		</div>
		
		<?php
		
		$output = ob_get_contents();
		ob_end_clean();
		return $output;
	}

	/***
	***	@shortcode
	***/
	function ultimatemember_followers( $args = array() ) {
		global $ultimatemember, $um_followers;

		$defaults = array(
			'user_id' 		=> ( um_is_core_page('user') ) ? um_profile_id() : get_current_user_id(),
			'style' 		=> 'default',
			'max'			=> 11
		);
		$args = wp_parse_args( $args, $defaults );
		extract( $args );

		ob_start();
		
		if ( $style == 'avatars' ) {
			$tpl = 'followers-mini';
		} else {
			$tpl = 'followers';
		}
		
		$file       = um_followers_path . 'templates/'.$tpl.'.php';
		$theme_file = get_stylesheet_directory() . '/ultimate-member/templates/'.$tpl.'.php';
		
		if( file_exists( $theme_file ) ) {
			$file = $theme_file;
		}

		if( file_exists( $file ) ) {
			$followers = $um_followers->api->followers( $user_id );
			include_once $file;
		}

		$output = ob_get_contents();
		ob_end_clean();
		return $output;
	}
	
	/***
	***	@shortcode
	***/
	function ultimatemember_following( $args = array() ) {
		global $ultimatemember, $um_followers;

		$defaults = array(
			'user_id' 		=> ( um_is_core_page('user') ) ? um_profile_id() : get_current_user_id(),
			'style' 		=> 'default',
			'max'			=> 11
		);
		$args = wp_parse_args( $args, $defaults );
		extract( $args );

		ob_start();
		
		if ( $style == 'avatars' ) {
			$tpl = 'following-mini';
		} else {
			$tpl = 'following';
		}
		
		$file       = um_followers_path . 'templates/'.$tpl.'.php';
		$theme_file = get_stylesheet_directory() . '/ultimate-member/templates/'.$tpl.'.php';
		
		if( file_exists( $theme_file ) ) {
			$file = $theme_file;
		}

		if( file_exists( $file ) ) {
			$following = $um_followers->api->following( $user_id );
			include_once $file;
		}

		$output = ob_get_contents();
		ob_end_clean();
		return $output;
	}

}