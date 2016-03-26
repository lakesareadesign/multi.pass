<?php

class UM_Mailchimp_Func {

	function __construct() {

		$this->user_id = get_current_user_id();

		$this->schedules();

	}

	/***
	***	@Schedules
	***/
	function schedules() {

		add_action( 'um_daily_scheduled_events', array( $this, 'mailchimp_subscribe' ) );

		add_action( 'um_daily_scheduled_events', array( $this, 'mailchimp_unsubscribe' ) );

		add_action( 'um_daily_scheduled_events', array( $this, 'mailchimp_update' ) );

	}

	/***
	***	@Update
	***/
	function mailchimp_update( $override = false ) {

		$last_send = $this->get_last_update();
		if( !$override && $last_send && $last_send > strtotime( '-1 day' ) )
			return;

		$array = get_option('_mailchimp_new_update');
		if ( !$array || !is_array($array) ) return;

		$apikey = um_get_option('mailchimp_api');

		if ( !$apikey ) return;
		$api = new UM_MCAPI( $apikey );

		// update user info for specific list
		foreach( $array as $list_id => $data ) {

			if ( !empty( $data ) ) {

			foreach( $data as $user_id => $merge_vars ) {

				um_fetch_user( $user_id );
				$email = um_user('user_email');

				foreach( $merge_vars as $key => $val ) {
					if ( is_array( $val ) ) {
						$merge_vars[$key] = implode(', ', $val );
					}
				}

				$api->call('lists/update-member',  array(
						'id'                => $list_id,
						'email'             => array( 'email' => $email ),
						'merge_vars'        => $merge_vars
					));

				unset( $array[$list_id][$user_id] );
			}

			}

		}

		// reset new update sync
		update_option('_mailchimp_new_update', $array);

		// update last update data
		update_option( 'um_mailchimp_last_update', time() );

	}

	/***
	***	@Subscribe
	***/
	function mailchimp_subscribe( $override = false ) {

		$last_send = $this->get_last_subscribe();
		if( !$override && $last_send && $last_send > strtotime( '-1 day' ) )
			return;

		$array = get_option('_mailchimp_new_subscribers');
		if ( !$array || !is_array($array) ) return;

		$apikey = um_get_option('mailchimp_api');

		if ( !$apikey ) return;
		$api = new UM_MCAPI( $apikey );

		// subscribe each user to the mailing list
		foreach( $array as $list_id => $data ) {

			if ( !empty( $data ) ) {

			foreach( $data as $user_id => $merge_vars ) {

				um_fetch_user( $user_id );
				$email = um_user('user_email');

				foreach( $merge_vars as $key => $val ) {
					if ( is_array( $val ) ) {
						$merge_vars[$key] = implode(', ', $val );
					}
				}

				$api->call('lists/subscribe',  array(
						'id'                => $list_id,
						'email'             => array( 'email' => $email ),
						'merge_vars'        => $merge_vars,
						'double_optin'      => false,
						'update_existing'   => true,
						'replace_interests' => false,
						'send_welcome'      => false,
					));

				unset( $array[$list_id][$user_id] );
			}

			}

		}

		// reset new subscribers sync
		update_option('_mailchimp_new_subscribers', $array);

		// update last subscribe data
		update_option( 'um_mailchimp_last_subscribe', time() );

	}

	/***
	***	@Unsubscribe
	***/
	function mailchimp_unsubscribe( $override = false ) {

		$last_send = $this->get_last_unsubscribe();
		if( !$override && $last_send && $last_send > strtotime( '-1 day' ) )
			return;

		$array = get_option('_mailchimp_new_unsubscribers');
		if ( !$array || !is_array($array) ) return;

		$apikey = um_get_option('mailchimp_api');

		if ( !$apikey ) return;
		$api = new UM_MCAPI( $apikey );

		// unsubscribe each user to the mailing list
		foreach( $array as $list_id => $data ) {

			if ( !empty( $data ) ) {

			foreach( $data as $user_id => $merge_vars ) {

				um_fetch_user( $user_id );
				$email = um_user('user_email');

				$api->call('lists/unsubscribe',  array(
						'id'                => $list_id,
						'email'             => array( 'email'=> $email ),
						'delete_member'     => false,
						'send_goodbye '  	=> true,
						'send_notify' 		=> true,
					));

				unset( $array[$list_id][$user_id] );
			}

			}

		}

		// reset new unsubscribers sync
		update_option('_mailchimp_new_unsubscribers', $array);

		// update last unsubscribe data
		update_option( 'um_mailchimp_last_unsubscribe', time() );

	}

	/***
	***	@Last Update
	***/
	function get_last_update() {
		return get_option( 'um_mailchimp_last_update' );
	}

	/***
	***	@Last Subscribe
	***/
	function get_last_subscribe() {
		return get_option( 'um_mailchimp_last_subscribe' );
	}

	/***
	***	@Last Unsubscribe
	***/
	function get_last_unsubscribe() {
		return get_option( 'um_mailchimp_last_unsubscribe' );
	}

	/***
	***	@update user
	***/
	function update( $list_id, $_merge_vars=null ) {

		$user_id = $this->user_id;
		um_fetch_user( $user_id );

		if ( !um_user('user_email') ) return;

		$merge_vars = array('FNAME'=> um_user('first_name'), 'LNAME' => um_user('last_name') );

		if ( $_merge_vars ) {
			foreach( $_merge_vars as $meta => $var ) {
				if ( $var != '0' ) {
					$merge_vars[ $var ] = um_user( $meta );
				}
			}
		}

		$_new_update = get_option('_mailchimp_new_update');
		if ( !isset( $_new_update[ $list_id ][ $user_id ] ) ) {
			$_new_update[$list_id][$user_id] = $merge_vars;
		}

		update_option( '_mailchimp_new_update', $_new_update );

	}

	/***
	***	@subscribe user
	***/
	function subscribe( $list_id, $_merge_vars=null ) {

		$user_id = $this->user_id;
		um_fetch_user( $user_id );

		if ( !um_user('user_email') ) return;

		$merge_vars = array('FNAME'=> um_user('first_name'), 'LNAME'=> um_user('last_name') );

		if ( $_merge_vars ) {
			foreach( $_merge_vars as $meta => $var ) {
				if ( $var != '0' ) {
					$merge_vars[ $var ] = um_user( $meta );
				}
			}
		}

		$_mylists = get_user_meta( $user_id, '_mylists', true);
		if ( !isset($_mylists[$list_id]) ) {
			$_mylists[$list_id] = 1;
		}
		update_user_meta( $user_id, '_mylists', $_mylists);

		$_new_unsubscribers = get_option('_mailchimp_new_unsubscribers');
		if ( isset( $_new_unsubscribers[ $list_id ][ $user_id ] ) ) {
			unset($_new_unsubscribers[$list_id][$user_id]);
		}

		$_new_subscribers = get_option('_mailchimp_new_subscribers');
		if ( !isset( $_new_subscribers[ $list_id ][ $user_id ] ) ) {
			$_new_subscribers[$list_id][$user_id] = $merge_vars;
		}

		update_option( '_mailchimp_new_subscribers', $_new_subscribers );
		update_option( '_mailchimp_new_unsubscribers', $_new_unsubscribers );

		if ( um_get_option('mailchimp_real_status') ) {
			$this->mailchimp_subscribe( true );
		}

	}

	/***
	***	@unsubscribe user
	***/
	function unsubscribe( $list_id ) {

		$user_id = $this->user_id;
		um_fetch_user( $user_id );

		if ( !um_user('user_email') ) return;

		$_mylists = get_user_meta( $user_id, '_mylists', true);
		if ( isset($_mylists[$list_id]) ) {
			unset($_mylists[$list_id]);
		}
		update_user_meta( $user_id, '_mylists', $_mylists);

		$_new_subscribers = get_option('_mailchimp_new_subscribers');
		if ( isset( $_new_subscribers[ $list_id ][ $user_id ] ) ) {
			unset($_new_subscribers[$list_id][$user_id]);
		}

		$_new_unsubscribers = get_option('_mailchimp_new_unsubscribers');
		if ( !isset( $_new_unsubscribers[ $list_id ][ $user_id ] ) ) {
			$_new_unsubscribers[$list_id][$user_id] = 1;
		}

		update_option( '_mailchimp_new_subscribers', $_new_subscribers );
		update_option( '_mailchimp_new_unsubscribers', $_new_unsubscribers );

		if ( um_get_option('mailchimp_real_status') ) {
			$this->mailchimp_unsubscribe( true );
		}

	}

	/***
	***	@Fetch list
	***/
	function fetch_list( $id ) {
		$setup = get_post( $id );
		if ( !isset( $setup->post_title ) ) return false;
		$list['id'] = get_post_meta( $id, '_um_list', true );
		$list['auto_register'] =  get_post_meta( $id, '_um_reg_status', true );
		$list['description'] = get_post_meta( $id, '_um_desc', true );
		$list['register_desc'] = get_post_meta( $id, '_um_desc_reg', true );
		$list['name']  = $setup->post_title;
		$list['status'] = get_post_meta( $id, '_um_status', true );
		$list['merge_vars'] = get_post_meta( $id, '_um_merge', true );
		return $list;
	}

	/***
	***	@Check if there are active integrations
	***/
	function has_lists( $admin = false ) {
		global $ultimatemember;

		$args = array(
			'post_status'	=> array('publish'),
			'post_type' 	=> 'um_mailchimp',
			'fields'		=> 'ids'
		);
		$args['meta_query'][] = array('relation' => 'AND');
		$args['meta_query'][] = array(
			'key' => '_um_status',
			'value' => '1',
			'compare' => '='
		);

		$lists = new WP_Query( $args );
		if ( $lists->found_posts > 0 ) {
			$array = $lists->posts;

			// frontend-use
			if ( !$admin ) {
				foreach( $array as $k => $post_id ) {
					$roles = get_post_meta($post_id, '_um_roles', true);
					if ( $roles && !in_array( $ultimatemember->query->get_role_by_userid( $this->user_id ), $roles ) ) {
						unset( $array[$k] );
					}
				}
			}

			if ( $array )
				return $array;
			return false;
		}
		return false;
	}

	/***
	***	@get merge vars for a specific list
	***/
	function get_vars( $list_id ) {

		$apikey = um_get_option('mailchimp_api');
		if ( $apikey ) {

			$api = new UM_MCAPI( $apikey );

			$merge_vars = $api->call('lists/merge-vars',  array(
				'id' => array( $list_id )
			));

		}

		if ( isset( $merge_vars['data'][0]['merge_vars'] ) )
			return $merge_vars['data'][0]['merge_vars'];
		return array('');
	}

	/***
	***	@subscribe status
	***/
	function is_subscribed( $list_id ) {

		$user_id = $this->user_id;

		if ( um_get_option('mailchimp_real_status') ) {

			$apikey = um_get_option('mailchimp_api');
			$api = new UM_MCAPI( $apikey );
			$email = um_user('user_email');
			$lists = $api->call('helper/lists-for-email',  array(
				'email'  => array( 'email'=> $email ),
			));
			if ( !$lists || ( isset( $lists['status'] ) && $lists['status'] == 'error' ) ) {
				return false;
			}

			foreach( $lists as $id => $array ) {
				if ( $array['id'] == $list_id ) {
					return true;
				}
			}

		} else {

			$_mylists = get_user_meta( $user_id, '_mylists', true);

			if ( isset($_mylists[$list_id]) ) {
				return true;
			}

		}
		return false;

	}

	/***
	***	@Get list names
	***/
	function get_lists() {
		$res = null;
		$apikey = um_get_option('mailchimp_api');
		if ( $apikey ) {
			$api = new UM_MCAPI( $apikey );
			$lists = $api->call('lists/list');
		}
		if ( isset( $lists['data'] ) ) {
			foreach( $lists['data'] as $key => $list ) {
				$res[ $list['id'] ] = $list['name'];
			}
		}
		if (!$res)
			$res[0] = __('No lists found','um-mailchimp');
		return $res;
	}

	/***
	***	@Get list subscriber count
	***/
	function get_list_member_count( $list_id ) {
		$res = null;
		$apikey = um_get_option('mailchimp_api');
		if ( $apikey ) {
		$api = new UM_MCAPI( $apikey );
		$lists = $api->call('lists/list');
		}
		if ( !isset( $lists ) ) return __('Please setup MailChimp API','um-mailchimp');
		foreach( $lists['data'] as $key => $list ) {
			if ($list['id'] == $list_id)
				return $list['stats']['member_count'];
		}
		return 0;
	}

	/***
	***	@Retrieve connection
	***/
	function account() {

		$apikey = um_get_option('mailchimp_api');
		if ( !$apikey ) return;
		$api = new UM_MCAPI( $apikey );

		$result = $api->call('helper/account-details');

		return $result;

	}

	/***
	***	@Queue count
	***/
	function queue_count( $type ) {
		$count = 0;
		if ( $type == 'subscribers' ) {
			$queue = get_option( '_mailchimp_new_subscribers' );
		} elseif ( $type == 'unsubscribers' ) {
			$queue = get_option( '_mailchimp_new_unsubscribers' );
		} else if ( $type == 'update' ) {
			$queue = get_option( '_mailchimp_new_update' );
		}
		if ( $queue ) {
			foreach( $queue as $list_id => $data ) {
				$count = $count + count($data);
			}
		}
		return $count;
	}

}
