<?php

class UM_Friends_Main_API {

	function __construct() {

		global $wpdb;
		$this->table_name = $wpdb->prefix . "um_friends";

	}

	/***
	***	@Checks if user enabled email notification
	***/
	function enabled_email( $user_id ) {
		$_enable_new_friend = true;
		if ( get_user_meta( $user_id, '_enable_new_friend', true ) == 'yes' ) {
			$_enable_new_friend = 1;
		} else if ( get_user_meta( $user_id, '_enable_new_friend', true ) == 'no' ) {
			$_enable_new_friend = 0;
		}
		return $_enable_new_friend;
	}

	/***
	***	@Show the friends list URL
	***/
	function friends_link( $user_id ) {
		$nav_link = um_user_profile_url();
		$nav_link = add_query_arg('profiletab', 'friends', $nav_link );
		return $nav_link;
	}
	
	function menu_ui( $position, $element, $trigger, $items ) {
		
		$output = '<div class="um-dropdown" data-element="' . $element . '" data-position="' . $position . '" data-trigger="' . $trigger . '">
			<div class="um-dropdown-b">
				<div class="um-dropdown-arr"><i class=""></i></div>
				<ul>';
				
				foreach( $items as $k => $v ) {
					
				$output .= '<li>' . $v . '</li>';
					
				}
		$output .= '</ul>
			</div>
		</div>';
		
		return $output;
	}

	/***
	***	@Show the friend button for two users
	***/
	function friend_button( $user_id1, $user_id2, $twobtn = false ) {
		global $ultimatemember;
		$res = '';
		if ( !is_user_logged_in() ) {
			$redirect = um_get_core_page('register');
			$redirect = add_query_arg('redirect_to', $ultimatemember->permalinks->get_current_url(), $redirect );
			$res = '<a href="' . $redirect . '" class="um-login-to-friend-btn um-button um-alt">'. __('Add Friend','um-friends'). '</a>';
			return $res;
		}

		if ( $this->can_friend( $user_id1, $user_id2 ) ) {

		if ( ! $this->is_friend( $user_id1, $user_id2 ) ) {

			if ( $pending = $this->is_friend_pending( $user_id1, $user_id2 ) ) {

				if ( $pending == $user_id2 ) { // User should respond
					
					if ( $twobtn == false ) {
						
						$res = '<div class="um-friend-respond-zone">
							<a href="#" class="um-friend-respond-btn um-button um-alt" data-user_id1="'.$user_id1.'" data-user_id2="'.$user_id2.'">'. __('Respond to Friend Request','um-friends'). '</a>';

						$items = array(
							'confirm' 	=> '<a href="#" class="um-friend-accept-btn" data-user_id1="'.$user_id1.'" data-user_id2="'.$user_id2.'">'. __('Confirm','um-friends'). '</a>',
							'delete' 	=> '<a href="#" class="um-friend-reject-btn" data-user_id1="'.$user_id1.'" data-user_id2="'.$user_id2.'">'. __('Delete Request','um-friends'). '</a>',
							'cancel' 	=> '<a href="#" class="um-dropdown-hide">'.__('Cancel','ultimatemember').'</a>',
						);

						$res .= $this->menu_ui( 'bc', '.um-friend-respond-zone', 'click', $items );
						$res .= '</div>';
					
					} else {
						$res = '<a href="#" class="um-friend-accept-btn um-button" data-user_id1="'.$user_id1.'" data-user_id2="'.$user_id2.'">'. __('Confirm','um-friends'). '</a>';
						$res .= '&nbsp;&nbsp;<a href="#" class="um-friend-reject-btn um-button um-alt" data-user_id1="'.$user_id1.'" data-user_id2="'.$user_id2.'">'. __('Delete Request','um-friends'). '</a>';
					}
					
				} else {
					$res = '<a href="#" class="um-friend-pending-btn um-button um-alt" data-cancel-friend-request="' . __('Cancel Friend Request','um-friends') . '" data-pending-friend-request="' . __('Friend Request Sent','um-friends') . '" data-user_id1="'.$user_id1.'" data-user_id2="'.$user_id2.'">'. __('Friend Request Sent','um-friends'). '</a>';
				}
				
			} else {
				$res = '<a href="#" class="um-friend-btn um-button um-alt" data-user_id1="'.$user_id1.'" data-user_id2="'.$user_id2.'">'. __('Add Friend','um-friends'). '</a>';
			}
		} else {
			
			$res = '<a href="#" class="um-unfriend-btn um-button um-alt" data-user_id1="'.$user_id1.'" data-user_id2="'.$user_id2.'" data-friends="'.__('Friends','um-friends').'"  data-unfriend="'.__('Unfriend','um-friends').'">'. __('Friends','um-friends'). '</a>';
		
		}

		}
		return $res;
	}

	/***
	***	@If user can friend
	***/
	function can_friend( $user_id1, $user_id2 ) {
		global $ultimatemember;
		if ( !is_user_logged_in() )
			return true;

		$role = get_user_meta( $user_id2, 'role', true );
		$role_data = $ultimatemember->query->role_data( $role );
		$role_data = apply_filters('um_user_permissions_filter', $role_data, $user_id2);

		if ( !$role_data['can_friend'] )
			return false;

		if ( $role_data['can_friend'] && isset($role_data['can_friend_roles']) && !in_array( get_user_meta( $user_id1, 'role', true ), unserialize( $role_data['can_friend_roles'] ) ) )
			return false;

		if ( $user_id1 != $user_id2 && is_user_logged_in() )
			return true;

		return false;
	}

	/***
	***	@Get the count of friends
	***/
	function count_friends_plain( $user_id = 0 ) {
		global $wpdb;
		$count = $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) FROM {$this->table_name} WHERE status = 1 AND ( user_id1= %d OR user_id2 = %d )", $user_id, $user_id ) );
		return $count;
	}
	
	/***
	***	@Get the count of received requests
	***/
	function count_friend_requests_received( $user_id = 0 ) {
		global $wpdb;
		$count = $wpdb->get_var(
			"SELECT COUNT(*) FROM {$this->table_name} WHERE status=0 AND user_id1=$user_id"
		);
		return absint( $count );
	}

	/***
	***	@Get the count of sent requests
	***/
	function count_friend_requests_sent( $user_id = 0 ) {
		global $wpdb;
		$count = $wpdb->get_var(
			$wpdb->prepare( "SELECT COUNT(*) FROM {$this->table_name} WHERE status=0 AND user_id2= %s", $user_id )
		);
		return absint( $count );
	}

	/***
	***	@Get the count of friends in nice format
	***/
	function count_friends( $user_id = 0, $html = true ) {
		$count = $this->count_friends_plain ( $user_id );
		if ( $html )
			return '<span class="um-ajax-count-friends">' . number_format( $count ) . '</span>';
		return number_format( $count );
	}

	/***
	***	@Add a friend action
	***/
	function add( $user_id1, $user_id2 ) {
		global $wpdb;

		// if already friends do not add
		if ( $this->is_friend( $user_id1, $user_id2 ) )
			return false;

		$wpdb->insert(
			$this->table_name,
			array(
				'time' => current_time( 'mysql' ),
				'user_id1' => $user_id1,
				'user_id2' => $user_id2,
				'status' => 0
			)
		);
	}
	
	/***
	***	@Approve friend
	***/
	function approve( $user_id1, $user_id2 ) {
		global $wpdb;

		// if already friends do not add
		if ( $this->is_friend( $user_id1, $user_id2 ) )
			return false;

		$wpdb->update( $this->table_name, array( 'status' => 1 ), array( 'user_id1' => $user_id2, 'user_id2' => $user_id1 ) );
	}

	/***
	***	@Removes a friend connection
	***/
	function remove( $user_id1, $user_id2 ) {
		global $wpdb;

		$table_name = $this->table_name;
		
		$wpdb->query("DELETE FROM {$table_name} WHERE ( user_id1 = $user_id2 AND user_id2 = $user_id1  ) OR ( user_id1 = $user_id1 AND user_id2 = $user_id2 )" );
	}
	
	/***
	***	@cancel a pending friend connection
	***/
	function cancel( $user_id1, $user_id2 ) {
		global $wpdb;

		// Not applicable to pending requests
		if ( $this->is_friend( $user_id1, $user_id2 ) )
			return false;

		$table_name = $this->table_name;
		
		$wpdb->query("DELETE FROM $table_name WHERE status=0 AND ( user_id1=$user_id2 AND user_id2='$user_id1' ) OR ( user_id1=$user_id1 AND user_id2='$user_id2' )" );
	}

	/***
	***	@Checks if user is friend of another user
	***/
	function is_friend( $user_id1, $user_id2 ) {
		global $wpdb;

		$results = $wpdb->get_results("SELECT user_id1 FROM {$this->table_name} WHERE status = 1 AND ( ( user_id1=$user_id2 AND user_id2=$user_id1 ) OR ( user_id1=$user_id1 AND user_id2=$user_id2 ) ) LIMIT 1");

		if ( $results && isset( $results[0] ) )
			return true;

		return false;
	}
	
	/***
	***	@Checks if user is pending friend of another user
	***/
	function is_friend_pending( $user_id1, $user_id2 ) {
		global $wpdb;
		
		$results = $wpdb->get_results(
			"SELECT user_id1 FROM {$this->table_name} WHERE status=0 AND ( user_id1=$user_id2 AND user_id2='$user_id1' ) OR ( user_id1=$user_id1 AND user_id2='$user_id2' ) LIMIT 1"
		);

		if ( $results && isset( $results[0] ) )
			return $results[0]->user_id1;

		return false;
	}

	/***
	***	@Get friends as array
	***/
	function friends( $user_id1 ) {
		global $wpdb;
		$results = $wpdb->get_results("SELECT user_id1, user_id2 FROM {$this->table_name} WHERE status=1 AND ( user_id1= $user_id1 OR user_id2 = $user_id1 ) ORDER BY time DESC", ARRAY_A );
		if ( $results )
			return $results;
		return false;
	}
	
	/***
	***	@Get friend requests as array
	***/
	function friend_reqs( $user_id1 ) {
		global $wpdb;
		$results = $wpdb->get_results("SELECT user_id2 FROM {$this->table_name} WHERE status=0 AND user_id1=$user_id1 ORDER BY time DESC", ARRAY_A );
		if ( $results )
			return $results;
		return false;
	}
	
	/***
	***	@Get friend requests as array
	***/
	function friend_reqs_sent( $user_id1 ) {
		global $wpdb;
		$results = $wpdb->get_results("SELECT user_id1 FROM {$this->table_name} WHERE status=0 AND user_id2=$user_id1 ORDER BY time DESC", ARRAY_A );
		if ( $results )
			return $results;
		return false;
	}

}
