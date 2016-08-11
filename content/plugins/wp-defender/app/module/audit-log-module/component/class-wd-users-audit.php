<?php

/**
 * Author: Hoang Ngo
 */
class WD_Users_Audit extends WD_Event_Abstract {
	const ACTION_LOGIN = 'login', ACTION_LOGOUT = 'logout', ACTION_REGISTERED = 'registered', ACTION_LOST_PASS = 'lost_password',
		ACTION_RESET_PASS = 'reset_password';

	const CONTEXT_SESSION = 'session', CONTEXT_USERS = 'users', CONTEXT_PROFILE = 'profile';
	private $type = 'user';

	public function get_hooks() {
		return array(
			'wp_login_failed'      => array(
				'args'        => array( 'username' ),
				'text'        => sprintf( __( "User login fail. Username: %s", wp_defender()->domain ), '{{username}}' ),
				'level'       => self::LOG_LEVEL_FATAL,
				'event_type'  => $this->type,
				'context'     => self::CONTEXT_SESSION,
				'action_type' => self::ACTION_LOGIN,
			),
			'wp_login'             => array(
				'args'        => array( 'userlogin', 'user' ),
				'text'        => sprintf( __( "User login success: %s", wp_defender()->domain ), '{{userlogin}}' ),
				'level'       => self::LOG_LEVEL_INFO,
				'event_type'  => $this->type,
				'context'     => self::CONTEXT_SESSION,
				'action_type' => self::ACTION_LOGIN,
			),
			'wp_logout'            => array(
				'args'        => array(),
				'text'        => sprintf( __( "User logout success: %s", wp_defender()->domain ), '{{username}}' ),
				'level'       => self::LOG_LEVEL_INFO,
				'event_type'  => $this->type,
				'action_type' => self::ACTION_LOGOUT,
				'context'     => self::CONTEXT_SESSION,
				'custom_args' => array(
					//in this state, current user should be the one who log out
					'username' => WD_Utils::get_user_name( get_current_user_id() )
				)
			),
			'user_register'        => array(
				'args'         => array( 'user_id' ),
				'text'         => is_admin() ? sprintf( __( "%s added a new user: Username: %s, Role: %s", wp_defender()->domain ), '{{wp_user}}', '{{username}}', '{{user_role}}' )
					: sprintf( __( "A new user registered: Username: %s, Role: %s", wp_defender()->domain ), '{{username}}', '{{user_role}}' ),
				'level'        => self::LOG_LEVEL_INFO,
				'event_type'   => $this->type,
				'context'      => self::CONTEXT_USERS,
				'action_type'  => self::ACTION_REGISTERED,
				'program_args' => array(
					'username'  => array(
						'callable'        => 'get_user_by',
						'params'          => array(
							'id',
							'{{user_id}}'
						),
						'result_property' => 'user_login'
					),
					'user_role' => array(
						'callable' => array( 'WD_Utils', 'get_user_role' ),
						'params'   => array(
							'{{user_id}}'
						),
					)
				)
			),
			'deleted_user'         => array(
				'args'        => array( 'user_id' ),
				'text'        => sprintf( __( "%s deleted an user: ID: %s", wp_defender()->domain ), '{{wp_user}}', '{{user_id}}' ),
				'level'       => self::LOG_LEVEL_INFO,
				'context'     => self::CONTEXT_USERS,
				'action_type' => WD_Audit_API::ACTION_DELETED,
				'event_type'  => $this->type,
			),
			'profile_update'       => array(
				'args'        => array( 'user_id', 'old_user_data' ),
				'level'       => self::LOG_LEVEL_INFO,
				'action_type' => WD_Audit_API::ACTION_UPDATED,
				'event_type'  => $this->type,
				'context'     => self::CONTEXT_PROFILE,
				'callback'    => array( 'WD_Users_Audit', 'profile_update_callback' ),
			),
			'retrieve_password'    => array(
				'args'        => array( 'username' ),
				'text'        => sprintf( __( "Password requested to reset for user: %s", wp_defender()->domain ), '{{username}}' ),
				'level'       => self::LOG_LEVEL_INFO,
				'action_type' => self::ACTION_LOST_PASS,
				'event_type'  => $this->type,
				'context'     => self::CONTEXT_PROFILE,
			),
			'after_password_reset' => array(
				'args'        => array( 'user' ),
				'text'        => sprintf( __( "Password reset for user: %s", wp_defender()->domain ), '{{user_login}}' ),
				'level'       => self::LOG_LEVEL_INFO,
				'event_type'  => $this->type,
				'action_type' => self::ACTION_RESET_PASS,
				'context'     => self::CONTEXT_PROFILE,
				'custom_args' => array(
					'user_login' => '{{user->user_login}}'
				)
			),
			'set_user_role'        => array(
				'args'         => array( 'user_ID', 'new_role', 'old_role' ),
				'text'         => sprintf( __( '%s changed user %s\'s role from %s to %s', wp_defender()->domain ), '{{wp_user}}', '{{username}}', '{{from_role}}', '{{new_role}}' ),
				'level'        => self::LOG_LEVEL_INFO,
				'action_type'  => WD_Audit_API::ACTION_UPDATED,
				'event_type'   => $this->type,
				'context'      => self::CONTEXT_PROFILE,
				'custom_args'  => array(
					'from_role' => '{{old_role->0}}',
				),
				'program_args' => array(
					'username' => array(
						'callable'        => 'get_user_by',
						'params'          => array(
							'id',
							'{{user_ID}}'
						),
						'result_property' => 'user_login'
					),
				),
				'false_when'   => array(
					array(
						'{{old_role}}',
						array(),
						'=='
					),
				),
			),
			'updated_user_meta'    => array(
				'args'         => array( 'meta_id', 'object_id', 'meta_key', 'meta_value' ),
				'text'         => sprintf( __( "%s changed user %s meta %s", wp_defender()->domain ), '{{wp_user}}', '{{username}}', '{{meta_key}}' ),
				'action_type'  => WD_Audit_API::ACTION_UPDATED,
				'context'      => self::CONTEXT_PROFILE,
				'program_args' => array(
					'username' => array(
						'callable'        => 'get_user_by',
						'params'          => array(
							'id',
							'{{object_id}}'
						),
						'result_property' => 'user_login'
					)
				),
				'event_type'   => $this->type,
			)
		);
	}

	public static function profile_update_callback() {
		$args         = func_get_args();
		$user_id      = $args[1]['user_id'];
		$old_data     = $args[1]['old_user_data'];
		$current_user = get_user_by( 'id', $user_id );
		$current_arr  = $current_user->to_array();
		$old_arr      = $old_data->to_array();

		if ( count( array_diff( $old_arr, $current_arr ) ) == 0 ) {
			return false;
		}

		if ( get_current_user_id() == $user_id ) {
			return sprintf( __( "User %s updated his/her profile", wp_defender()->domain ), $current_user->user_nicename );
		} else {
			return sprintf( __( "%s updated user %s's profile information", wp_defender()->domain ), WD_Utils::get_user_name( get_current_user_id() ), $current_user->user_nicename );
		}
	}

	public function dictionary() {
		return array(
			self::ACTION_LOST_PASS  => __( "lost password", wp_defender()->domain ),
			self::ACTION_REGISTERED => __( "registered", wp_defender()->domain ),
			self::ACTION_LOGIN      => __( "login", wp_defender()->domain ),
			self::ACTION_LOGOUT     => __( "logout", wp_defender()->domain ),
			self::ACTION_RESET_PASS => __( "password reset", wp_defender()->domain ),
		);
	}
}