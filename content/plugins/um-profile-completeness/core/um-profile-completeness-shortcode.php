<?php

class UM_Profile_Completeness_Shortcode {

	function __construct() {
	
		add_shortcode('ultimatemember_profile_completeness', array(&$this, 'ultimatemember_profile_completeness'), 1);
		add_shortcode('ultimatemember_profile_progress_bar', array(&$this, 'ultimatemember_profile_progress_bar'), 1);
		
	}
	
	/***
	***	@Bar only widget
	***/
	function ultimatemember_profile_progress_bar( $args = array() ) {
		global $ultimatemember, $um_profile_completeness;
		
		$defaults = array(
			'user_id' => get_current_user_id(),
			'who' => 'loggedin',
		);
		$args = wp_parse_args( $args, $defaults );
		extract( $args );

		if ( !$user_id || $who == 'loggedin' ) {
			$user_id = get_current_user_id();
		}
		
		if ( um_profile_id() && $user_id != um_profile_id() )
			return;
		
		$result = $um_profile_completeness->shortcode->profile_progress( $user_id );
		if ( !$result || $result['progress'] >= 100 ) return;
		
		return $result['bar'];
	}
	
	/***
	***	@Completeness widget
	***/
	function ultimatemember_profile_completeness( $args = array() ) {
		global $ultimatemember, $um_profile_completeness;

		if ( !is_user_logged_in() ) return;
		$result = $um_profile_completeness->shortcode->profile_progress( get_current_user_id() );
		if ( !$result || $result['progress'] >= 100 ) return;
		
		$defaults = array(

		);
		$args = wp_parse_args( $args, $defaults );
		extract( $args );
		
		if ( is_array($result['steps']) )
			$result['steps'] = $this->reorder( $result['steps'] );
		
		ob_start();
		include_once um_profile_completeness_path . 'templates/widget.php';
		$output = ob_get_contents();
		ob_end_clean();
		return $output;
	}

	/***
	***	@re-order profile completion steps
	***/
	function reorder( $steps ) {
		if ( isset( $steps['profile_photo'] ) ) {
			$value = $steps['profile_photo'];
			unset( $steps['profile_photo'] );
			$steps['profile_photo'] = $value;
		}
		if ( isset( $steps['cover_photo'] ) ) {
			$value = $steps['cover_photo'];
			unset( $steps['cover_photo'] );
			$steps['cover_photo'] = $value;
		}
		return $steps;
	}
	
	/***
	***	@Get progress result
	***/
	function profile_progress( $user_id ) {
		global $ultimatemember, $um_profile_completeness;
		
		$get_progress = $um_profile_completeness->get_progress( $user_id );
		
		if ( $get_progress == -1 )
			return false;
		
		$output['bar'] = '<span class="um-completeness-bar um-tip-n" title="'. sprintf(__('%s Complete','um-profile-completeness'), $get_progress['progress'] . '%' ) . '">';

		if ( $get_progress['progress'] == 100 ) {
			$radius = '999px !important';
		} else {
			$radius = '999px 0 0 999px';
		}
		
		$output['bar'] .= '<span class="um-completeness-done" style="width: ' . $get_progress['progress'] . '%;border-radius: '. $radius . '"></span>';
		
		for( $i = 0; $i <= 9; $i++ ) {	
			$left = $i * 10;
			$output['bar'] .= '<span class="um-completeness-i" style="left: '.$left.'%;"></span>';
		}
		
		$output['bar'] .= '</span>';
		
		$output['progress'] = $get_progress['progress'];
		$output['steps'] = $get_progress['steps'];
		$output['completed']  = ( isset( $get_progress['completed'] ) ) ? $get_progress['completed'] : '';
		$output['req_progress'] = $get_progress['req_progress'];
		$output['prevent_browse'] = $get_progress['prevent_browse'];
		$output['prevent_profileview'] = $get_progress['prevent_profileview'];
		$output['prevent_comment'] = $get_progress['prevent_comment'];
		$output['prevent_bb'] = $get_progress['prevent_bb'];
		
		return $output;
	}
	
}