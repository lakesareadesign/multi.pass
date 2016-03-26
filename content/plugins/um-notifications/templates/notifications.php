<div class="um-notification-header">
	<div class="um-notification-left"><?php _e('Notifications','um-notifications'); ?></div>
	<div class="um-notification-right">
		<a href="<?php echo $ultimatemember->account->tab_link( 'webnotifications' ); ?>" class="um-notification-i-settings"><i class="um-faicon-cog"></i></a>
		<a href="#" class="um-notification-i-close"><i class="um-icon-android-close"></i></a>
	</div>
	<div class="um-clear"></div>
</div>

<div class="um-notification-ajax">

	<?php foreach( $notifications as $notification ) { if ( !isset( $notification->id ) ) continue; ?>

	<div class="um-notification <?php echo $notification->type; ?> <?php echo $notification->status; ?>" data-notification_id="<?php echo $notification->id; ?>" data-notification_uri="<?php echo $notification->url; ?>">

		<?php echo '<img src="'. $notification->photo .'" data-default="'. um_get_default_avatar_uri() .'" alt="" class="um-notification-photo" />'; ?>

		<?php echo $notification->content; ?>

		<span class="b2"><?php echo $um_notifications->api->get_icon( $notification->type ); ?><?php echo $um_notifications->api->nice_time( $notification->time ); ?></span>

		<span class="um-notification-hide"><a href="#"><i class="um-icon-android-close"></i></a></span>

	</div>

	<?php } ?>

</div>

<div class="um-notifications-none" style="display:none">
	<i class="um-icon-ios-bell"></i>
	<?php _e('No new notifications','um-notifications'); ?>
</div>

<div class="um-notification-more">
	<a href="<?php echo um_get_core_page('notifications'); ?>"><?php _e('See all notifications','um-notifications'); ?></a>
</div>
