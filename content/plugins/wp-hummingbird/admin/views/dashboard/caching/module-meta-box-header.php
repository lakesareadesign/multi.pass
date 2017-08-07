<?php
/**
 * Caching meta box header on dashboard page.
 *
 * @package Hummingbird
 *
 * @var bool   $cf_active   CloudFlare status.
 * @var int    $cf_current  Current CloudFlare caching value.
 * @var int    $issues      Number of issues.
 * @var string $title       Module title.
 */

?>
<h3><?php echo esc_html( $title ); ?></h3>
<?php if ( $issues && ! $cf_active ) : ?>
	<div class="wphb-pills"><?php echo intval( $issues ); ?></div>
<?php elseif ( 691200 !== $cf_current && $cf_active ) : ?>
	<div class="wphb-pills">1</div>
<?php endif; ?>