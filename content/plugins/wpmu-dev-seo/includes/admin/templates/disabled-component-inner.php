<?php
$content = empty( $content ) ? '' : $content;
$image = empty( $image ) ? '' : $image;
$component = empty( $component ) ? '' : $component;
$button_text = empty( $button_text ) ? '' : $button_text;
$is_member = Smartcrawl_Service::get( Smartcrawl_Service::SERVICE_SITE )->is_member();
$premium_feature = empty( $premium_feature ) ? false : $premium_feature;
$notice = empty( $notice ) ? '' : $notice;
$button_url = empty( $button_url ) ? '' : $button_url;
?>
<div class="wds-disabled-component">
	<p>
		<img src="<?php echo esc_attr( SMARTCRAWL_PLUGIN_URL ); ?>/images/<?php echo esc_attr( $image ); ?>"
		     alt="<?php esc_attr_e( 'Disabled', 'wds' ); ?>" class="wds-disabled-image"/>
	</p>
	<p><?php echo wp_kses_post( $content ); ?></p>

	<?php if ( $notice ) : ?>
		<div class="wds-notice wds-notice-warning">
			<p><?php echo esc_html( $notice ); ?></p>
		</div>
	<?php endif; ?>

	<?php if ( $component ) : ?>
		<input type="hidden" name="wds-activate-component" value="<?php echo esc_attr( $component ); ?>"/>
		<?php wp_nonce_field( 'wds-settings-nonce', '_wds_nonce' ); ?>
	<?php endif; ?>

	<?php if ( $premium_feature && ! $is_member ) : ?>
		<button class="wds-upgrade-button button-green"><?php esc_html_e( 'Upgrade to Pro', 'wds' ); ?></button>
	<?php else : ?>
		<?php if ( $button_url ) : ?>
			<a class="button" href="<?php echo esc_attr( $button_url ); ?>"><?php echo esc_html( $button_text ); ?></a>
		<?php else : ?>
			<input name="submit" class="button" value="<?php echo esc_attr( $button_text ); ?>" type="submit"/>
		<?php endif; ?>
	<?php endif; ?>
</div>