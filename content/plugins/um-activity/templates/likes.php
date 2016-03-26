<div class="um-activity-modal-head um-popup-header">
	<?php _e('People who like this','um-activity'); ?>
	<a href="#" class="um-activity-modal-hide"><i class="um-icon-close"></i></a>
</div>

<div class="um-activity-modal-body um-popup-autogrow2">

	<?php foreach( $users as $user ) {
		um_fetch_user( $user ); ?>

	<div class="um-activity-modal-item">
		<div class="um-activity-modal-user">
			<div class="um-activity-modal-pic"><a href="<?php echo um_user_profile_url(); ?>"><?php echo get_avatar( $user, 40 ); ?></a></div>
			<div class="um-activity-modal-info">
				<div class="um-activity-modal-name"><a href="<?php echo um_user_profile_url(); ?>"><?php echo um_user('display_name'); ?></a></div>
				<?php do_action('um_activity_likes_below_name', $item_id ); ?>
			</div>
		</div>
		<div class="um-activity-modal-hook">
			<?php do_action('um_activity_likes_beside_name', $item_id ); ?>
		</div><div class="um-clear"></div>
	</div>

	<?php } ?>

</div>

<div class="um-popup-footer" style="height:30px">

</div>