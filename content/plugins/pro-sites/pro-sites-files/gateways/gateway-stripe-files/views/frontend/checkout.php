<?php
/**
 * Settings page for Stripe.
 *
 * @package    View
 * @subpackage Stripe
 */

// Globals.
global $psts, $current_site, $current_user;
?>

<?php if ( $error_messages ) : ?>
	<div id="psts-processcard-error">
		<div class="psts-error">
			<?php echo $error_messages; ?>
		</div>
	</div>
<?php endif; ?>

<form action="<?php echo $psts->checkout_url( $bid, $domain ); ?>" method="post" id="psts-stripe-checkout">
	<input type="hidden" name="level" value="<?php echo $level; ?>"/>
	<input type="hidden" name="period" value="<?php echo $period; ?>"/>
	<input type="hidden" name="tax-type" value="none"/>
	<input type="hidden" name="tax-country" value="none"/>
	<input type="hidden" name="tax-evidence" value=""/>

	<?php if ( $new_blog ) : ?>
		<input type="hidden" name="new_blog" value="1"/>
	<?php endif; ?>

	<?php if ( $bid ) : ?>
		<input type="hidden" name="bid" value="<?php echo $bid; ?>"/>
	<?php endif; ?>

	<?php if ( $activation_key ) : ?>
		<input type="hidden" name="activation" value="<?php echo $activation_key; ?>"/>

		<?php if ( $user_name ) : ?>
			<input type="hidden" name="blog_username" value="<?php echo $user_name; ?>"/>
			<input type="hidden" name="blog_email" value="<?php echo $user_email; ?>"/>
			<input type="hidden" name="blog_name" value="<?php echo $blogname; ?>"/>
			<input type="hidden" name="blog_title" value="<?php echo $blog_title; ?>"/>
		<?php endif; ?>
	<?php endif; ?>

	<!-- Checkout page flag. -->
	<input type="hidden" name="psts_stripe_checkout" value="1" />

	<?php if ( ! empty( $card->last4 ) ) : ?>
		<h3><?php esc_html_e( 'Checkout Using Existing Credit Card', 'psts' ); ?></h3>
		<p><?php esc_attr_e( 'You already have a credit card on your Stripe account.', 'psts' ); ?></p>
		<table>
			<tr>
				<td><?php esc_html_e( 'Existing Card:', 'psts' ); ?></td>
				<td><?php printf( __( '%1$s ending in %2$s', 'psts' ), $card->brand, $card->last4 ); ?></td>
			</tr>
			<tr>
				<td align="right"><?php esc_html_e( 'WordPress Password:', 'psts' ); ?></td>
				<td>
					<input name="wp_password" size="15" type="password" title="<?php esc_attr_e( 'Enter the WordPress password that you login with.', 'psts' ); ?>"/>
				</td>
			</tr>
			<tr>
				<td align="right"><?php esc_html_e( 'Use Existing Card:', 'psts' ); ?></td>
				<td>
					<button type="button" id="psts-existing-submit"><?php esc_html_e( 'Submit Payment', 'psts' ); ?></button>
				</td>
			</tr>
		</table>
	<?php endif; ?>
	<h3><?php esc_html_e( 'Checkout With a Credit Card', 'psts' ); ?></h3>
	<p><?php esc_attr_e( 'Checkout using your credit card within a secure Stripe payment form.', 'psts' ); ?></p>
	<table id="psts-cc-table-existing">
		<tr>
			<td align="right"><?php esc_html_e( 'Set as default card:', 'psts' ); ?></td>
			<td>
				<input name="default_card" type="checkbox" value="1" <?php checked( empty( $card ) ); ?> />
			</td>
		</tr>
		<tr>
			<td><?php esc_html_e( 'Use a credit card:', 'psts' ); ?></td>
			<td>
				<script src="https://checkout.stripe.com/checkout.js" class="stripe-button"
				        data-key="<?php echo $public_key; ?>"
				        data-name="<?php echo $current_site->site_name; ?>"
				        data-image="<?php echo get_site_icon_url( 512, '', 1 ); ?>"
				        data-locale="<?php echo get_locale(); ?>"
				        data-email="<?php echo $email; ?>"
				        data-label="<?php esc_html_e( 'Submit Payment', 'psts' ); ?>">
				</script>
			</td>
		</tr>
		</tr>
	</table>

</form>