<?php

class UM_Followers_Main_API {

	function __construct() {

		global $wpdb;
		$this->table_name = $wpdb->prefix . "um_followers";

	}

	/***
	***	@Checks if user enabled email notification
	***/
	function enabled_email( $user_id ) {
		$_enable_new_follow = true;
		if ( get_user_meta( $user_id, '_enable_new_follow', true ) == 'yes' ) {
			$_enable_new_follow = 1;
		} else if ( get_user_meta( $user_id, '_enable_new_follow', true ) == 'no' ) {
			$_enable_new_follow = 0;
		}
		return $_enable_new_follow;
	}

	/***
	***	@Show the followers list URL
	***/
	function followers_link( $user_id ) {
		$nav_link = um_user_profile_url();
		$nav_link = add_query_arg('profiletab', 'followers', $nav_link );
		return $nav_link;
	}

	/***
	***	@Show the following list URL
	***/
	function following_link( $user_id ) {
		$nav_link = um_user_profile_url();
		$nav_link = add_query_arg('profiletab', 'following', $nav_link );
		return $nav_link;
	}

	/***
	***	@Show the follow button for two users
	***/
	function follow_button( $user_id1, $user_id2 ) {
		global $ultimatemember;
		$res = '';
		if ( !is_user_logged_in() ) {
			$redirect = um_get_core_page('register');
			$redirect = add_query_arg('redirect_to', $ultimatemember->permalinks->get_current_url(), $redirect );
			$res = '<a href="' . $redirect . '" class="um-login-to-follow-btn um-button um-alt">'. __('Follow','um-followers'). '</a>';
			return $res;
		}

		if ( $this->can_follow( $user_id1, $user_id2 ) ) {

		if ( !$this->followed( $user_id1, $user_id2 ) ) {
			$res = '<a href="#" class="um-follow-btn um-button um-alt" data-user_id1="'.$user_id1.'" data-user_id2="'.$user_id2.'">'. __('Follow','um-followers'). '</a>';
		} else {
			$res = '<a href="#" class="um-unfollow-btn um-button" data-user_id1="'.$user_id1.'" data-user_id2="'.$user_id2.'" data-following="'.__('Following','um-followers').'"  data-unfollow="'.__('Unfollow','um-followers').'">'. __('Following','um-followers'). '</a>';
		}

		}
		return $res;
	}

	/***
	***	@If user can follow
	***/
	function can_follow( $user_id1, $user_id2 ) {
		global $ultimatemember;
		if ( !is_user_logged_in() )
			return true;

		$role = get_user_meta( $user_id2, 'role', true );
		$role_data = $ultimatemember->query->role_data( $role );
		$role_data = apply_filters('um_user_permissions_filter', $role_data, $user_id2);

		if ( !$role_data['can_follow'] )
			return false;

		if ( $role_data['can_follow'] && isset($role_data['can_follow_roles']) && !in_array( get_user_meta( $user_id1, 'role', true ), unserialize( $role_data['can_follow_roles'] ) ) )
			return false;

		if ( $user_id1 != $user_id2 && is_user_logged_in() )
			return true;

		return false;
	}

	/***
	***	@Get the count of followers
	***/
	function count_followers_plain( $user_id = 0 ) {
		global $wpdb;
		$count = $wpdb->get_var(
			"SELECT COUNT(*) FROM {$this->table_name} WHERE user_id1=$user_id AND user_id2 IN (SELECT ID FROM {$wpdb->users})"
		);
		return $count;
	}

	/***
	***	@Get the count of followers in nice format
	***/
	function count_followers( $user_id = 0 ) {
		$count = $this->count_followers_plain ( $user_id );
		return '<span class="um-ajax-count-followers">' . number_format( $count ) . '</span>';
	}

	/***
	***	@Get the count of following
	***/
	function count_following_plain( $user_id = 0 ) {
		global $wpdb;
		$count = $wpdb->get_var(
			"SELECT COUNT(*) FROM {$this->table_name} WHERE user_id2=$user_id AND user_id1 IN (SELECT ID FROM {$wpdb->users})"
		);
		return $count;
	}

	/***
	***	@Get the count of following in nice format
	***/
	function count_following( $user_id = 0 ) {
		$count = $this->count_following_plain ( $user_id );
		return '<span class="um-ajax-count-following">' . number_format( $count ) . '</span>';
	}

	/***
	***	@Add a follow action
	***/
	function add( $user_id1, $user_id2 ) {
		global $wpdb;

		// if already followed do not add
		if ( $this->followed( $user_id1, $user_id2 ) )
			return false;

		$wpdb->insert(
			$this->table_name,
			array(
				'time' => current_time( 'mysql' ),
				'user_id1' => $user_id1,
				'user_id2' => $user_id2
			)
		);
	}

	/***
	***	@Removes a follow connection
	***/
	function remove( $user_id1, $user_id2 ) {
		global $wpdb;

		// If user is not followed do not do anything
		if ( !$this->followed( $user_id1, $user_id2 ) )
			return false;

		$wpdb->delete( $this->table_name, array( 'user_id1' => $user_id1, 'user_id2' => $user_id2 ) );
	}

	/***
	***	@Checks if user is follower of another user
	***/
	function followed( $user_id1, $user_id2 ) {
		global $wpdb;

		$results = $wpdb->get_results(
			"SELECT user_id1 FROM {$this->table_name} WHERE user_id1=$user_id1 AND user_id2='$user_id2' AND user_id1 IN (SELECT ID FROM {$wpdb->users}) AND user_id2 IN (SELECT ID FROM {$wpdb->users}) LIMIT 1"
		);

		if ( $results && isset( $results[0] ) )
			return true;

		return false;
	}

	/***
	***	@Get followers as array
	***/
	function followers( $user_id1 ) {
		global $wpdb;
		$results = $wpdb->get_results("SELECT user_id2 FROM {$this->table_name} WHERE user_id1=$user_id1 AND user_id2 IN (SELECT ID FROM {$wpdb->users}) ORDER BY time DESC", ARRAY_A );
		if ( $results )
			return $results;
		return false;
	}

	/***
	***	@Get following as array
	***/
	function following( $user_id2 ) {
		global $wpdb;
		$results = $wpdb->get_results("SELECT user_id1 FROM {$this->table_name} WHERE user_id2=$user_id2 AND user_id1 IN (SELECT ID FROM {$wpdb->users}) ORDER BY time DESC", ARRAY_A );
		if ( $results )
			return $results;
		return false;
	}

}
