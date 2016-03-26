<?php $key = um_get_option('mailchimp_api'); ?>

<p class="sub"><?php _e('Connection status','um-mailchimp'); ?></p>

<?php if ( !$key ) { ?>

	<p><?php printf(__('<a href="%s"><strong>Please enter your valid API key</strong></a> in settings.','um-mailchimp'), admin_url('admin.php?page=um_options&tab=' . $um_mailchimp->tab_id ) ); ?></p>

<?php } else { $result = $um_mailchimp->api->account();

	if ( isset( $result['error'] ) ) { ?>

		<p><span class="red"><?php echo $result['error']; ?></span> <?php printf(__('<a href="%s"><strong>Please enter your valid API key</strong></a> in settings.','um-mailchimp'), admin_url('admin.php?page=um_options&tab=' . $um_mailchimp->tab_id ) ); ?></p>

	<?php } else { ?>

		<p><?php printf(__('Your site is successfully <strong><span class="ok">linked</span></strong> to <strong>%s</strong> MailChimp account.','um-mailchimp'), $result['username']); ?>
		
		<p class="sub"><?php _e('In queue (updated daily)','um-mailchimp'); ?></p>
		
		<p><?php printf(__('%s new subscriber(s)','um-mailchimp'), $um_mailchimp->api->queue_count('subscribers') ); ?>
		
		<?php if ( $um_mailchimp->api->queue_count('subscribers') > 0 ) { ?>
		<a href="<?php echo add_query_arg('um_adm_action','force_mailchimp_subscribe'); ?>" class="button"><?php _e('Sync Now','um-mailchimp'); ?></a>
		<?php } ?>
		
		</p>
		
		<p><?php printf(__('%s new unsubscriber(s)','um-mailchimp'), $um_mailchimp->api->queue_count('unsubscribers') ); ?>
		
		<?php if ( $um_mailchimp->api->queue_count('unsubscribers') > 0 ) { ?>
		<a href="<?php echo add_query_arg('um_adm_action','force_mailchimp_unsubscribe'); ?>" class="button"><?php _e('Sync Now','um-mailchimp'); ?></a>
		<?php } ?>
		
		</p>

		<p><?php printf(__('%s new profile update(s)','um-mailchimp'), $um_mailchimp->api->queue_count('update') ); ?>
		
		<?php if ( $um_mailchimp->api->queue_count('update') > 0 ) { ?>
		<a href="<?php echo add_query_arg('um_adm_action','force_mailchimp_update'); ?>" class="button"><?php _e('Sync Now','um-mailchimp'); ?></a>
		<?php } ?>
		
		</p>

<?php

	}

}

?>