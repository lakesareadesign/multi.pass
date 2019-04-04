<?php
/**
 * Subscriber info widget for Stripe.
 *
 * @package    View
 * @subpackage Stripe
 */

?>

<?php if ( ! empty( $customer->description ) ) : ?>
	<p>
		<a href="<?php echo get_home_url( $blog_id ); ?>">
			<strong><?php echo ucwords( stripslashes( $customer->description ) ); ?></strong>
		</a>
	</p>
<?php endif; ?>

<p><?php printf( esc_html__( 'Email: %s', 'psts' ), '<strong>' . $customer->email . '</strong>' ); ?></p>

<?php if ( ! empty( $card ) ) : ?>
	<p>
		<?php printf( esc_html__( 'Type: %s', 'psts' ), ucfirst( $card->object ) ); ?><br/>
		<?php printf( esc_html__( 'Brand: %s', 'psts' ), $card->brand ); ?><br/>
		<?php printf( esc_html__( 'Country: %s', 'psts' ), $card->country ); ?>
	</p>
<?php endif; ?>