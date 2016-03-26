<?php

	/***
	***	@hide role
	***/
	add_action( 'um_bbpress_theme_after_reply_author_details', 'um_mycred_bb_norole' );
	function um_mycred_bb_norole() {
		global $um_mycred;
		if ( !um_get_option('mycred_hide_role') ) return; ?>
		
		<style type="text/css">
			div.bbp-author-role {display: none !important}
		</style>
		
		<?php

	}
	
	/***
	***	@show rank
	***/
	add_action( 'um_bbpress_theme_after_reply_author_details', 'um_mycred_bb_rank' );
	function um_mycred_bb_rank() {
		global $um_mycred;
		if ( !um_get_option('mycred_show_bb_rank') ) return;
		if ( !function_exists('mycred_get_users_rank') ) return;
		$reply_author_id = get_post_field( 'post_author', bbp_get_reply_id() );
		$rank = mycred_get_users_rank( $reply_author_id );
		if ( !$rank ) return; ?>
		
		<div class="um-mycred-bb-rank"><?php echo $rank; ?></div>
		
		<?php

	}
	
	/***
	***	@show points
	***/
	add_action( 'um_bbpress_theme_after_reply_author_details', 'um_mycred_bb_points' );
	function um_mycred_bb_points() {
		global $um_mycred;
		if ( !um_get_option('mycred_show_bb_points') ) return;
		$reply_author_id = get_post_field( 'post_author', bbp_get_reply_id() ); ?>
		
		<div class="um-mycred-bb-points"><?php echo $um_mycred->get_points( $reply_author_id ); ?></div>
		
		<?php

	}
	
	/***
	***	@show progress
	***/
	add_action( 'um_bbpress_theme_after_reply_author_details', 'um_mycred_bb_rank_bar' );
	function um_mycred_bb_rank_bar() {
		global $um_mycred;
		if ( !um_get_option('mycred_show_bb_progress') ) return;
		
		if ( !function_exists('mycred_get_users_rank') ) return;
		
		$user_id = get_post_field( 'post_author', bbp_get_reply_id() );
		
		$rank = mycred_get_users_rank( $user_id );
		
		$progress = '<span class="um-mycred-progress um-tip-n" title="'. $rank . ' ' . (int) $um_mycred->get_rank_progress( $user_id ) . '%"><span class="um-mycred-progress-done" style="" data-pct="'.$um_mycred->get_rank_progress( $user_id ).'"></span></span>';
		
		?>
		
		<div class="um-mycred-bb-progress"><?php echo $progress; ?></div>
		
		<?php

	}