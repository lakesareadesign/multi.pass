<?php
/**
 * Uptime meta box header on dashboard page.
 *
 * @package Hummingbird
 *
 * @var string $title  Meta box title.
 */

?>
<h3  class="sui-box-title"><?php echo esc_html( $title ); ?></h3>
<?php if ( ! WP_Hummingbird_Utils::is_member() ) : ?>
    <span class="sui-tag sui-tag-pro" style="margin-left: 10px">
        <?php esc_html_e( 'Pro', 'wphb' ); ?>
    </span>
<?php endif; ?>