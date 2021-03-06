<?php
/**
 * Subscription info widget for Stripe.
 *
 * @package    View
 * @subpackage Stripe
 */
?>

<ul>
	<?php if ( $is_cancelled ) : ?>
		<li><strong><?php esc_html_e( 'The subscription has been cancelled in Stripe', 'psts' ); ?></strong></li>
		<li><?php printf( esc_html__( 'They should continue to have access until %s.', 'psts' ), ProSites_Gateway_Stripe::format_date( $expire ) ); ?></li>
	<?php endif; ?>
	<li><?php printf( __( 'Stripe Customer : %s', 'psts' ), '<strong><a href="https://dashboard.stripe.com/customers/' . $customer->id . '" target="_blank">' . $customer->id . '</a></strong>' ); ?></li>
	<?php if ( ! empty( $customer_data->subscription_id ) ) : ?>
		<li><?php printf( __( 'Stripe Subscription : %s', 'psts' ), '<strong><a href="https://dashboard.stripe.com/subscriptions/' . $customer_data->subscription_id . '" target="_blank">' . $customer_data->subscription_id . '</a></strong>' ); ?></li>
	<?php endif; ?>

	<?php if ( ! empty( $expire ) ) : ?>
		<li><?php printf( __( 'Payment Method: %1$s Card ending %2$s. Expires on %3$s', 'psts' ), '<strong>' . $card->brand . '</strong>', '<strong>' . $card->last4 . '</strong>', '<strong>' . $card->exp_month . '/' . $card->exp_year . '</strong>' ); ?></li>
	<?php endif; ?>

	<?php if ( $last_invoice ) : // Show payment details if invoice found. ?>
		<li><?php printf( esc_html__( 'Last Payment Date: %s', 'psts' ), '<strong>' . ProSites_Gateway_Stripe::format_date( $last_invoice->date ) . '</strong>' ); ?></li>
		<li><?php printf( esc_html__( 'Last Payment Amount: %s', 'psts' ), $psts->format_currency( ProSites_Gateway_Stripe::get_currency(), ProSites_Gateway_Stripe::format_price( $last_invoice->total, false ) ) ); ?></li>
	<?php endif; ?>
	<?php if ( isset( $last_invoice->next_payment_attempt ) ) : // If payment is peding show next payment date. ?>
		<li><?php sprintf( __( 'Next Payment Date: %s', 'psts' ), '<strong>' . $last_invoice->next_payment_attempt . '</strong>' ); ?></li>
	<?php endif; ?>
</ul>
<small>* (<?php esc_html_e( 'This does not include the initial payment at signup, or payments before the last payment method/plan change.', 'psts' ); ?>)</small>