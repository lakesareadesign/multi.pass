<?php

class UM_myCRED_API {

	function __construct() {

		$this->plugin_inactive = false;

		add_action('init', array(&$this, 'plugin_check'), 1);

		add_action('init', array(&$this, 'init'), 1);

	}

	/***
	***	@Check plugin requirements
	***/
	function plugin_check(){

		if ( !class_exists('UM_API') ) {

			$this->add_notice( sprintf(__('The <strong>%s</strong> extension requires the Ultimate Member plugin to be activated to work properly. You can download it <a href="https://wordpress.org/plugins/ultimate-member">here</a>','um-mycred'), um_mycred_extension) );
			$this->plugin_inactive = true;

		} else if( !defined('myCRED_VERSION') ) {

			$this->add_notice( sprintf(__('Sorry. You must activate the <strong>myCRED</strong> plugin to use the %s.','um-mycred'), um_mycred_extension ) );
			$this->plugin_inactive = true;

		} else if ( !version_compare( ultimatemember_version, um_mycred_extension, '>=' ) ) {

			$this->add_notice( sprintf(__('The <strong>%s</strong> extension requires a <a href="https://wordpress.org/plugins/ultimate-member">newer version</a> of Ultimate Member to work properly.','um-mycred'), um_mycred_extension) );
			$this->plugin_inactive = true;

		}

	}

	/***
	***	@Add notice
	***/
	function add_notice( $msg ) {

		if ( !is_admin() ) return;

		echo '<div class="error"><p>' . $msg . '</p></div>';

	}

	/***
	***	@Init
	***/
	function init() {

		if ( $this->plugin_inactive ) return;

		// Required classes
		require_once um_mycred_path . 'core/um-mycred-enqueue.php';

		$this->enqueue = new UM_myCRED_Enqueue();

		// Actions
		require_once um_mycred_path . 'core/actions/um-mycred-account.php';
		require_once um_mycred_path . 'core/actions/um-mycred-award.php';
		require_once um_mycred_path . 'core/actions/um-mycred-deduct.php';
		require_once um_mycred_path . 'core/actions/um-mycred-bbpress.php';
		require_once um_mycred_path . 'core/actions/um-mycred-tabs.php';
		require_once um_mycred_path . 'core/actions/um-mycred-admin.php';

		// Filters
		require_once um_mycred_path . 'core/filters/um-mycred-fields.php';
		require_once um_mycred_path . 'core/filters/um-mycred-settings.php';
		require_once um_mycred_path . 'core/filters/um-mycred-tabs.php';
		require_once um_mycred_path . 'core/filters/um-mycred-account.php';
		require_once um_mycred_path . 'core/filters/um-mycred-search.php';

	}

	/***
	***	@Show badges all
	***/
	function show_badges_all() {
		if ( function_exists( 'mycred_get_users_badges' ) ) :
			$size = um_get_option('mycred_badge_size');
			return do_shortcode('[mycred_badges title=0 requires=0 show=main width='.$size.' height='.$size.']');
		endif;
		return '';
	}

	/***
	***	@Show badges of user
	***/
	function show_badges( $user_id ) {
		if ( function_exists( 'mycred_get_users_badges' ) ) :

			$size = um_get_option('mycred_badge_size');
			$output = '';

			$badges = mycred_get_users_badges( $user_id );
			if ( ! empty( $badges ) ) {
				$output .= '<span class="um-badges">';
				foreach ( $badges as $badge_id => $data ) {

					$badge = get_post( $badge_id );
					if ( !isset( $badge->post_status ) || $badge->post_status != 'publish' ) continue;

					$img = get_post_meta( $badge_id, 'main_image', true );
					if ( !$img ) {
						$img = get_post_meta( $badge_id, 'default_image', true );
					}

					$output .= '<span class="the-badge">';
					$output .= '<img src="' . $img . '" width="'.$size.'" height="'.$size.'" class="mycred-badge earned um-tip-n" alt="' . get_the_title( $badge_id ) . '" title="' . get_the_title( $badge_id ) . '" />';
					$output .= '</span>';
				}
				$output .= '</span>';
			}

			return $output;

		endif;
		return '';
	}

	/***
	***	@Get points
	***/
	function get_points( $user_id, $value = null ) {
		if ( !$value ) {
			$value = get_user_meta( $user_id, 'mycred_default', true );
		}
		if ( $value > 0 ) {
			$value = number_format_i18n( $value, um_get_option('mycred_decimals') );
		} else {
			$value = (int)0;
		}
		$value = sprintf(__('%s points','um-mycred'), $value );
		return $value;
	}

	/***
	***	@Get points clean
	***/
	function get_points_clean( $user_id, $value = null ) {
		if ( !$value ) {
			$value = get_user_meta( $user_id, 'mycred_default', true );
		}
		return $value;
	}

	/***
	***	@transfer points
	***/
	function transfer( $from, $to, $amount ) {

		do_action('um_mycred_credit_balance_transfer', $to, $amount, $from );

		mycred_add( 'um-transfer-credit', $to, $amount, '%plural% received!' );
		mycred_subtract( 'um-transfer-charge', $from, $amount, '%plural% sent!' );

		delete_option( "um_cache_userdata_{$to}" );
		delete_option( "um_cache_userdata_{$from}" );
	}

	/***
	***	@add points
	***/
	function add( $user_id, $add ) {
		$mycred = um_get_option($add);
		if ( !$mycred ) return;

		// imply limits
		if ( um_get_option( $add . '_limit' ) ) {
			$a_limit = get_user_meta( $user_id, '_mycred_awarded_lmt', true);
			if ( !isset( $a_limit[ $add ] ) ) {
				$a_limit[ $add ] = 1;
			} else {
				if ( $a_limit[$add] >= um_get_option( $add . '_limit' ) ) {
					return;
				}
				$a_limit[ $add ] = $a_limit[ $add ] + 1;
			}
			update_user_meta( $user_id, '_mycred_awarded_lmt', $a_limit);
		}

		$action = $add;
		$add = um_get_option( $add . '_points');

		do_action('um_mycred_credit_balance_user', $user_id, $add, $action );

		mycred_add( $action, $user_id, $add, 'Earned %plural% via Ultimate Member (' . $action . ')' );
		delete_option( "um_cache_userdata_{$user_id}" );

	}

	/***
	***	@add points (hold)
	***/
	function add_pending( $user_id, $add ) {
		$mycred = um_get_option($add);
		if ( !$mycred ) return;

		// imply limits
		if ( um_get_option( $add . '_limit' ) ) {
			$a_limit = get_user_meta( $user_id, '_mycred_awarded_lmt', true);
			if ( !isset( $a_limit[ $add ] ) ) {
				$a_limit[ $add ] = 1;
			} else {
				if ( $a_limit[$add] >= um_get_option( $add . '_limit' ) ) {
					return '';
				}
				$a_limit[ $add ] = $a_limit[ $add ] + 1;
			}
			update_user_meta( $user_id, '_mycred_awarded_lmt', $a_limit);
		}

		$add = um_get_option( $add . '_points');
		return $add;
	}

	/***
	***	@deduct points
	***/
	function deduct( $user_id, $deduct ) {
		$mycred = um_get_option($deduct);
		if ( !$mycred ) return;

		// imply limits
		if ( um_get_option( $deduct . '_limit' ) ) {
			$a_limit = get_user_meta( $user_id, '_mycred_deducted_lmt', true);
			if ( !isset( $a_limit[ $deduct ] ) ) {
				$a_limit[ $deduct ] = 1;
			} else {
				if ( $a_limit[$deduct] >= um_get_option( $deduct . '_limit' ) ) {
					return;
				}
				$a_limit[ $deduct ] = $a_limit[ $deduct ] + 1;
			}
			update_user_meta( $user_id, '_mycred_deducted_lmt', $a_limit);
		}

		$action = $deduct;
		$deduct = um_get_option( $deduct . '_points');

		mycred_subtract( $action, $user_id, $deduct, 'Lost %plural% via Ultimate Member (' . $action . ')' );
		delete_option( "um_cache_userdata_{$user_id}" );

	}

	/***
	***	@Get user progress
	***/
	function get_rank_progress( $user_id ) {

		$mycred = mycred();

		$key = $mycred->get_cred_id();

		$users_balance = $mycred->get_users_cred( $user_id, $key );
		$users_rank = (int) mycred_get_users_rank( $user_id, 'ID' );
		$max = get_post_meta( $users_rank, 'mycred_rank_max', true );
		if ( !$users_balance || !$max ) return 0;
		$progress = number_format( ( ( $users_balance / $max ) * 100 ), 1 );

		if ( $progress < number_format( 100, 1 ) ) {

		} else {
			$progress = number_format( 100, 1 );
		}

		return $progress;

	}

}

$um_mycred = new UM_myCRED_API();
