<?php

class UM_Notices_Query {

	function __construct() {
		
		add_action('wp_footer', array(&$this, 'show_notice'), 9999);

	}

	/***
	***	@Display notices in footer
	***/
	function show_notice( $force_id = null ) {
		global $um_notices;
		
		$this->get_notices( $force_id );
		
		if ( !isset( $this->notice_id ) || $this->notice_id <= 0 ) return;
		
		$notice_id = $this->notice_id;
		
		$post = get_post( $notice_id );
		$meta = get_post_custom( $notice_id );
		
		$style = '';
		
		if ( isset( $meta['_um_border'][0] ) && !empty( $meta['_um_border'][0] ) ) {
			$style .= ' border: '.$meta['_um_border'][0].';border-bottom: none !important;';
		}
		
		if ( isset( $meta['_um_border_radius'][0] ) && !empty( $meta['_um_border_radius'][0] ) ) {
			$style .= ' border-radius: '.$meta['_um_border_radius'][0] . ' ' . $meta['_um_border_radius'][0] . ' 0px 0px;';
		}
		
		if ( isset( $meta['_um_boxshadow'][0] ) && !empty( $meta['_um_boxshadow'][0] ) ) {
			$style .= ' box-shadow: '.$meta['_um_boxshadow'][0].';';
		}

		if ( isset( $meta['_um_bgcolor'][0] ) && !empty( $meta['_um_bgcolor'][0] ) ) {
			$style .= ' background: '.$meta['_um_bgcolor'][0].';';
		}
		
		if ( isset( $meta['_um_textcolor'][0] ) && !empty( $meta['_um_textcolor'][0] ) ) {
			$style .= ' color: '.$meta['_um_textcolor'][0].';';
		}
		
		if ( isset( $meta['_um_fontsize'][0] ) && !empty( $meta['_um_fontsize'][0] ) ) {
			$style .= ' font-size: '.$meta['_um_fontsize'][0].';';
		}
		
		if ( isset( $meta['_um_closeiconcolor'][0] ) && !empty( $meta['_um_closeiconcolor'][0] ) ) {
			$close_color = ' color: '.$meta['_um_closeiconcolor'][0].';';
		} elseif ( isset( $meta['_um_textcolor'][0] ) && !empty( $meta['_um_textcolor'][0] ) ) {
			$close_color = ' color: '.$meta['_um_textcolor'][0].';';
		} else {
			$close_color = '';
		}
		
		if ( isset( $meta['_um_iconcolor'][0] ) && !empty( $meta['_um_iconcolor'][0] ) ) {
			$icon_color = ' color: '.$meta['_um_iconcolor'][0].';';
		} else if ( isset( $meta['_um_textcolor'][0] ) && !empty( $meta['_um_textcolor'][0] ) ) {
			$icon_color = ' color: '.$meta['_um_textcolor'][0].';';
		} else {
			$icon_color = '';
		}
		
		?>

			<div class="um-notices-wrap <?php if ( $force_id ) { echo 'yes-shortcode'; } else { echo 'no-shortcode'; } ?> um-notices-<?php echo um_get_option('notice_pos'); ?>" style="<?php echo $style; ?>" data-notice_id="<?php echo $notice_id; ?>" data-user_id="<?php echo ( is_user_logged_in() ) ? get_current_user_id() : 0; ?>">
				
				<div class="um-notices-box <?php if ( isset( $meta['_um_icon'][0] ) && !empty( $meta['_um_icon'][0] ) ) { ?> has-icon <?php } ?>">
					
					<a href="#" class="um-notices-close" style="<?php echo $close_color; ?>"><i class="um-icon-android-close"></i></a>
					
					<?php if ( isset( $meta['_um_icon'][0] ) && !empty( $meta['_um_icon'][0] ) ) { ?>
					<i class="<?php echo $meta['_um_icon'][0]; ?>" style="<?php echo $icon_color; ?>"></i>
					<?php } ?>
					
					<?php echo wpautop( $post->post_content ); ?>
					
					<?php if ( $meta['_um_cta'][0] ) {

						$cta_bg = ( $meta['_um_cta_bg'][0] ) ? $meta['_um_cta_bg'][0] : '#666';
						$cta_color = ( $meta['_um_cta_clr'][0] ) ? $meta['_um_cta_clr'][0] : '#fff';
						
					?>
					
					<div class="um-notices-cta">
						<a href="<?php echo $meta['_um_cta_url'][0]; ?>" style="background:<?php echo $cta_bg;?>;color:<?php echo $cta_color;?>;"><?php echo $meta['_um_cta_text'][0]; ?></a>
					</div>
					
					<?php } ?>
					
				</div>
				
			</div>
			
			<style type="text/css">
			
				<?php if ( isset( $meta['_um_textcolor'][0] ) && !empty( $meta['_um_textcolor'][0] ) ) { ?>
				.um-notices-wrap p {
					color: <?php echo $meta['_um_textcolor'][0]; ?> !important;
				}
				<?php } ?>
				
				.um-notices-wrap p a {
					<?php if ( isset( $meta['_um_textcolor'][0] ) && !empty( $meta['_um_textcolor'][0] ) ) { ?>
					color: <?php echo $meta['_um_textcolor'][0]; ?> !important;
					text-decoration: underline !important;
					<?php } ?>
				}
				
				<?php if ( isset( $meta['_um_min_width'][0] ) && !empty( $meta['_um_min_width'][0] ) ) { ?>
				.um-notices-wrap.no-shortcode {
					min-width: <?php echo $meta['_um_min_width'][0]; ?>;
				}
				<?php } ?>
				
			</style>

		<?php wp_reset_query();
	}
	
	/***
	***	@Get user notices
	***/
	function get_notices( $force_id ) {
		global $ultimatemember, $um_notices;
		
		$args = array(
			'post_status'		=> array('publish'),
			'post_type' 		=> 'um_notice',
			'posts_per_page'	=> -1,
			'fields'			=> 'ids',
		);
		
		if ( $force_id ) {
			$args['post__in'] = array( $force_id );
		}
		
		$notices = new WP_Query( $args );
		$notices_count = $notices->found_posts;
		if ( $notices_count <= 0 ) return;
		
		$user_notices = $notices->posts;
		foreach( $user_notices as $k => $notice_id ) {
			
			$post = get_post( $notice_id );
			$meta = get_post_custom( $notice_id );
			
			if ( !$force_id ) {

				if ( isset( $um_notices->shortcodes[ $notice_id ] ) )
					unset( $user_notices[$k] );

				if ( isset( $meta['_um_show_in_footer'][0] ) && $meta['_um_show_in_footer'][0] == 0 )
					unset( $user_notices[$k] );

				if ( isset( $meta['_um_show_in_urls'][0] ) && $meta['_um_show_in_urls'][0] == 1 ) {
					
					$urls = array_map("rtrim", explode("\n", $meta['_um_allowed_urls'][0] ));
					
					$current_url = $ultimatemember->permalinks->get_current_url( true );
					$current_url = untrailingslashit( $current_url );
					$current_url_slash = trailingslashit( $current_url );
					
					if ( um_is_core_page('user') && strstr( $current_url, untrailingslashit( um_get_core_page('user') ) ) ) {
						
					} else if ( in_array( $current_url, $urls ) || in_array( $current_url_slash, $urls ) ) {
						
					} else {
						unset( $user_notices[$k] );
					}

				} else {

					if ( isset( $meta['_um_show_in_home'][0] ) && $meta['_um_show_in_home'][0] == 0 && ( is_home() || is_front_page() ) )
						unset( $user_notices[$k] );
					
					if ( isset( $meta['_um_show_in_pages'][0] ) && $meta['_um_show_in_pages'][0] == 0 && get_post_type() == 'page' )
						unset( $user_notices[$k] );
					
					if ( isset( $meta['_um_show_in_posts'][0] ) && $meta['_um_show_in_posts'][0] == 0 && get_post_type() == 'post' )
						unset( $user_notices[$k] );
					
					if ( isset( $meta['_um_show_in_types'][0] ) && $meta['_um_show_in_types'][0] == 0 && !in_array( get_post_type(), array('post','page') ) )
						unset( $user_notices[$k] );
					
				}
				
			}
			
			if ( isset( $meta['_um_only_users'][0] ) && !empty( $meta['_um_only_users'][0] ) ) {
				
				if ( !is_user_logged_in() ) {
					unset( $user_notices[$k] );
				} else {
					
					global $current_user;
					$users = explode(',',  $meta['_um_only_users'][0] );
					foreach( $users as $user ) {
						$users[] = trim($user);
					}
					if (!in_array( $current_user->user_login, $users ) ) {
						unset( $user_notices[$k] );
					}
					
				}
			}
			
			if ( $this->user_saw_this_notice( $notice_id ) )
				unset( $user_notices[$k] );
			
			if ( $meta['_um_show_loggedout'][0] == 1 && $meta['_um_show_loggedin'][0] == 0 && is_user_logged_in() )
				unset( $user_notices[$k] );
			
			if ( $meta['_um_show_loggedout'][0] == 0 && $meta['_um_show_loggedin'][0] == 1 && !is_user_logged_in() )
				unset( $user_notices[$k] );
			
			if ( $meta['_um_show_loggedout'][0] == 0 && $meta['_um_show_loggedin'][0] == 0 ) // do not show_notice
				unset( $user_notices[$k] );
			
			if ( is_user_logged_in() ) {
				
				$role = get_user_meta( get_current_user_id(), 'role', true );
				if ( isset( $meta['_um_roles'][0] ) && is_serialized( $meta['_um_roles'][0] ) ) {
					$roles = unserialize( $meta['_um_roles'][0] );
					if ( $roles && !in_array( $role, $roles ) ) {
						unset( $user_notices[$k] );
					}
				}
			
				if ( !empty( $meta['_um_custom_field'][0] ) ) {
					
					if ( $meta['_um_custom_field'][0] == 'other' ) {
						$key = $meta['_um_custom_key'][0];
					} else {
						$key = $meta['_um_custom_field'][0];
					}
					
					if ( get_user_meta( get_current_user_id(), $key, true ) ) {
						unset( $user_notices[$k] );
					}
					
					if ( $key == 'profile_photo' ) {
						if ( get_user_meta( get_current_user_id(), 'synced_profile_photo', true ) ) {
							unset( $user_notices[$k] );
						}
					}

				}
				
				// EDD Integration
				if ( class_exists( 'Easy_Digital_Downloads' ) ) {
					
					if ( isset( $meta['_um_edd_users'][0] ) && $meta['_um_edd_users'][0] == 2 ) { // made purchases
						
						$user = edd_get_purchase_stats_by_user( get_current_user_id() );
						if ( $meta['_um_edd_users_amount'][0] > 0 && $user['total_spent'] < $meta['_um_edd_users_amount'][0] ) {
							unset( $user_notices[$k] );
						}
						
						if ( !edd_has_purchases( get_current_user_id() ) ) {
							unset( $user_notices[$k] );
						}
						
					} else if ( isset( $meta['_um_edd_users'][0] ) && $meta['_um_edd_users'][0] == 1 ) { // did not make purchases
						if ( edd_has_purchases( get_current_user_id() ) ) {
							unset( $user_notices[$k] );
						}
					}
					
				}
				
			}

		}

		if ( $user_notices && !empty( $user_notices ) ) {
			reset($user_notices);
			$first_key = key($user_notices);
			$this->notice_id = $user_notices[$first_key];
		} else {
			$this->notice_id = 0;
		}
		
	}
	
	/***
	***	@Boolean if user saw this notice
	***/
	function user_saw_this_notice( $notice_id ) {
		if ( is_user_logged_in() ) {
			$users = get_post_meta( $notice_id, '_users', true );
			if ( $users && is_array( $users ) && in_array( get_current_user_id(), $users ) ) {
				return true;
			}
		} else if ( isset( $_COOKIE['um_notice_seen_'.$notice_id] ) ) {
			return true;
		}
		return false;
	}

}