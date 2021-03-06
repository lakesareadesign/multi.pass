<?php
/**
 * Settings page for Stripe.
 *
 * @package    View
 * @subpackage Stripe
 */

// Pro Sites global.
global $psts;

?>
<div class="inside">
	<p class="description">
		<?php esc_html_e( 'Accept Visa, MasterCard, American Express, Discover, JCB, and Diners Club cards directly on your site. You don\'t need a merchant account or gateway. Stripe handles everything, including storing cards, subscriptions, and direct payouts to your bank account. Credit cards go directly to Stripe\'s secure environment, and never hit your servers so you can avoid most PCI requirements.', 'psts' ); ?>
		<a href="https://stripe.com/" target="_blank"><?php _e( 'More Info &raquo;', 'psts' ); ?></a>
	</p>

	<p><?php printf( __( 'To use Stripe you must %1$senter this webook url%2$s (%3$s) in your account.', 'psts' ), '<a href="https://dashboard.stripe.com/account/webhooks" target="_blank">', '</a>', '<strong>' . network_site_url( 'wp-admin/admin-ajax.php?action=psts_stripe_webhook', 'admin' ) . '</strong>' ); ?></p>
	<table class="form-table">
		<tr valign="top">
			<th scope="row"><?php esc_html_e( 'Stripe Mode', 'psts' ); ?></th>
			<td>
				<select name="psts[stripe_ssl]" class="chosen">
					<option value="1" <?php selected( $psts->get_setting( 'stripe_ssl' ), 1 ); ?>><?php esc_html_e( 'Force SSL (Live Site)', 'psts' ); ?></option>
					<option value="0" <?php selected( $psts->get_setting( 'stripe_ssl' ), 0 ); ?>><?php esc_html_e( 'No SSL (Testing)', 'psts' ); ?></option>
				</select>
				<br/>
				<span class="description"><?php esc_html_e( 'When in live mode Stripe recommends you have an SSL certificate setup for your main blog/site where the checkout form will be displayed.', 'psts' ); ?>
					<a href="https://stripe.com/help/ssl" target="_blank"><?php esc_html_e( 'More Info &raquo;', 'psts' ); ?></a>
                </span>
			</td>
		</tr>
		<tr>
			<th scope="row"><?php esc_html_e( 'Stripe API Credentials', 'psts' ); ?></th>
			<td>
				<p>
					<label><?php esc_html_e( 'Secret key', 'psts' ); ?><br/>
						<input value="<?php echo esc_attr( $psts->get_setting( 'stripe_secret_key' ) ); ?>" size="70" name="psts[stripe_secret_key]" type="text"/>
					</label>
				</p>

				<p>
					<label><?php esc_html_e( 'Publishable key', 'psts' ); ?><br/>
						<input value="<?php echo esc_attr( $psts->get_setting( "stripe_publishable_key" ) ); ?>" size="70" name="psts[stripe_publishable_key]" type="text"/>
					</label>
				</p>
				<br/>
				<span class="description"><?php printf( __( 'You must login to Stripe to %1$sget your API credentials%2$s. You can enter your test credentials, then live ones when ready. When switching from test to live API credentials, if you were testing on a site that will be used in live mode, you need to manually clear the associated row from the *_pro_sites_stripe_customers table for the given blogid to prevent errors on checkout or management of the site.', 'psts' ), '<a target="_blank" href="https://dashboard.stripe.com/account/apikeys">', '</a>' ); ?></span>
			</td>
		</tr>
		<tr valign="top">
			<th scope="row" class="psts-help-div psts-stripe-currency"><?php echo esc_html__( 'Stripe Currency', 'psts' ); ?></th>
			<td>
				<p>
					<strong><?php echo $psts->get_setting( 'currency', 'USD' ); ?></strong> &ndash;
					<span class="description"><?php printf( __( '%1$sChange Currency%2$s', 'psts' ), '<a href="' . network_admin_url( 'admin.php?page=psts-settings&tab=payment' ) . '">', '</a>' ); ?></span>
				</p>
				<p class="description"><?php esc_html_e( 'The currency must match the currency of your Stripe account.', 'psts' ); ?></p>
				<p class="description">
					<strong><?php esc_html_e( 'For zero decimal currencies like Japanese Yen, minimum plan cost should be greater than 50 Cents equivalent.', 'psts' ); ?></strong>
				</p>
			</td>
		</tr>
		<tr valign="top">
			<th scope="row" class="psts-help-div psts-stripe-thankyou"><?php echo esc_html__( 'Thank You Message', 'psts' ) . $psts->help_text( esc_html__( 'Displayed on successful checkout. This is also a good place to paste any conversion tracking scripts like from Google Analytics. - HTML allowed', 'psts' ) ); ?></th>
			<td>
				<textarea name="psts[stripe_thankyou]" type="text" rows="4" wrap="soft" id="stripe_thankyou" style="width: 100%"><?php echo esc_textarea( stripslashes( $psts->get_setting( 'stripe_thankyou' ) ) ); ?></textarea>
			</td>
		</tr>
		<tr valign="top">
			<th scope="row"><?php echo esc_html__( 'Enable Debug', 'psts' ); ?></th>
			<td>
				<input name="psts[stripe_debug]" type="checkbox" value="1" <?php checked( $psts->get_setting( 'stripe_debug' ), 1 ); ?>>
				<span class="description"><?php esc_html_e( 'Enable debug to log Stripe errors to your PHP error log.', 'psts' ); ?></span>
			</td>
		</tr>
	</table>
</div>