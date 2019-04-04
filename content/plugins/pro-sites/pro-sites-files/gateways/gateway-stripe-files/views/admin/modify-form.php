<?php
/**
 * Subscription modify form for Stripe.
 *
 * @package    View
 * @subpackage Stripe
 */

?>

<?php if ( ! empty( $last_invoice->total ) ) : // Continue if last payment found. ?>

	<?php if ( ! $cancelled ) : // Only for active subscriptions. ?>

		<h4><?php esc_html_e( 'Cancelations:', 'psts' ); ?></h4>
		<label>
			<input type="radio" name="stripe_mod_action" value="cancel"/>
			<?php esc_html_e( 'Cancel subscription only', 'psts' ); ?>
			<small>(<?php printf( esc_html__( 'Their access will expire on %s', 'psts' ), $expiry_date ); ?>)</small>
		</label><br/>
		<label>
			<input type="radio" name="stripe_mod_action" value="cancel_refund"/>
			<?php printf( esc_html__( 'Cancel subscription and refund the full amount (%s) of last payment', 'psts' ), $psts->format_currency( false, $last_payment ) ); ?>
			<small>(<?php printf( __( 'Their access will expire on %s', 'psts' ), $expiry_date ); ?>)</small>
		</label><br/>

	<?php endif; ?>

	<h4><?php esc_html_e( 'Refunds:', 'psts' ); ?></h4>
	<label>
		<input type="radio" name="stripe_mod_action" value="refund"/>
		<?php printf( __( 'Refund the full amount (%s) of last payment', 'psts' ), $psts->format_currency( false, $last_payment ) ); ?>
		<small>(<?php _e( 'Their subscription and access will continue', 'psts' ); ?>)</small>
	</label><br/>
	<label>
		<input type="radio" name="stripe_mod_action" value="partial_refund"/>
		<?php printf( __( 'Refund a partial %s amount of last payment', 'psts' ), $psts->format_currency() . '<input type="text" name="refund_amount" size="4" value="' . $last_payment . '" />' ); ?>
		<small>(<?php _e( 'Their subscription and access will continue', 'psts' ); ?>)</small>
	</label><br/>

<?php endif; ?>