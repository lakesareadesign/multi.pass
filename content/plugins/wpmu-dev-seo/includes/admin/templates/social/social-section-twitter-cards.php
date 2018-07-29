<?php
$options = empty( $options ) ? $_view['options'] : $options;
?>

<div class="wds-table-fields wds-separator-top">
	<div class="label">
		<label class="wds-label"><?php esc_html_e( 'Twitter Cards', 'wds' ); ?></label>
		<p class="wds-label-description"><?php esc_html_e( 'With Twitter Cards, you can attach rich photos, videos and media experiences to Tweets, helping to drive traffic to your website.', 'wds' ); ?></p>
	</div>

	<?php $twitter_card_enabled = $options['twitter-card-enable']; ?>
	<div class="fields wds-toggleable <?php echo $twitter_card_enabled ? '' : 'inactive'; ?>">
		<div class="wds-toggle-table">
			<span class="toggle wds-toggle">
				<input
					class="toggle-checkbox"
					value="1"
					id="twitter-card-enable"
					name="<?php echo esc_attr( $_view['option_name'] ); ?>[twitter-card-enable]"
					autocomplete="off"
					type="checkbox"
					<?php checked( $twitter_card_enabled ); ?>/>
				<label class="toggle-label" for="twitter-card-enable"></label>
			</span>

			<div class="wds-toggle-description">
				<label for="twitter-card-enable"
				       class="wds-label"><?php esc_html_e( 'Enable Twitter Cards', 'wds' ); ?></label>
			</div>
		</div>

		<div class="wds-toggleable-inside wds-conditional">
			<p></p>
			<select name="<?php echo esc_attr( $_view['option_name'] ); ?>[twitter-card-type]"
                    id="twitter-card-type"
			        class="select-container" style="width: 100%">
				<option
					<?php selected( $options['twitter-card-type'], Smartcrawl_Twitter_Printer::CARD_SUMMARY ); ?>
					value="<?php echo esc_attr( Smartcrawl_Twitter_Printer::CARD_SUMMARY ); ?>">
					<?php esc_html_e( 'Summary Card', 'wds' ); ?>
				</option>

				<option
					<?php selected( $options['twitter-card-type'], Smartcrawl_Twitter_Printer::CARD_IMAGE ); ?>
					value="<?php echo esc_attr( Smartcrawl_Twitter_Printer::CARD_IMAGE ); ?>">
					<?php esc_html_e( 'Summary Card with Large Image', 'wds' ); ?>
				</option>
			</select>

			<div class="wds-conditional-inside"
			     data-conditional-val="<?php echo esc_attr( Smartcrawl_Twitter_Printer::CARD_SUMMARY ); ?>">
				<?php
				$this->_render( 'social/social-twitter-embed', array(
					'tweet_url' => 'https://twitter.com/_HassanAkhtar/status/875530001294270464',
				) );
				?>
			</div>
			<div class="wds-conditional-inside"
			     data-conditional-val="<?php echo esc_attr( Smartcrawl_Twitter_Printer::CARD_IMAGE ); ?>">
				<?php
				$this->_render( 'social/social-twitter-embed', array(
					'tweet_url' => 'https://twitter.com/Twitter/status/593828669740584960',
					'large'     => true,
				) );
				?>
			</div>
			<p class="wds-field-legend"><?php esc_html_e( 'A preview of how your Homepage will appear as a Twitter Card.', 'wds' ); ?></p>
		</div>

	</div>
</div>