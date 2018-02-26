<?php
	$page_url = Smartcrawl_Settings_Admin::admin_url( Smartcrawl_Settings::TAB_ONPAGE );
	$public_post_types = get_post_types( array( 'public' => true ) );
	$show_on_front = get_option( 'show_on_front' );
	$options = $_view['options'];
	$option_name = Smartcrawl_Settings::TAB_SETTINGS . '_options';
	$onpage_enabled = smartcrawl_get_array_value( $options, 'onpage' );
?>
<section id="<?php echo Smartcrawl_Settings_Dashboard::BOX_ONPAGE; ?>" class="dev-box">
	<div class="box-title">
		<?php if ( $onpage_enabled ) :  ?>
			<div class="buttons buttons-icon">
				<a href="<?php echo esc_attr( $page_url ); ?>">
					<i class="wds-icon-arrow-right-carats"></i>
				</a>
			</div>
		<?php endif; ?>
		<h3>
			<i class="wds-icon-pencil"></i> <?php esc_html_e( 'Titles & Meta', 'wds' ); ?>
		</h3>
	</div>

	<div class="box-content">
		<p><?php esc_html_e( 'Control how your website’s pages, posts and custom post types appear in search engines like Google and Bing.', 'wds' ); ?></p>

		<?php if ( $onpage_enabled ) :  ?>
			<div class="wds-separator-top">
				<span class="wds-small-text"><strong><?php esc_html_e( 'Homepage', 'wds' ); ?></strong></span>
				<span class="wds-box-stat-value"><?php $show_on_front == 'page' ? esc_html_e( 'A Static Page', 'wds' ) : esc_html_e( 'Latest Posts', 'wds' ); ?></span>
			</div>

			<div class="wds-separator-top">
				<span class="wds-small-text"><strong><?php esc_html_e( 'Public post types', 'wds' ); ?></strong></span>
				<span class="wds-box-stat-value"><?php echo esc_html( count( $public_post_types ) ); ?></span>
			</div>

			<div class="wds-box-footer">
				<a href="<?php echo esc_attr( $page_url ); ?>"
				   class="button button-small button-dark button-dark-o wds-dash-configure-button">

					<?php esc_html_e( 'Configure', 'wds' ); ?>
				</a>
			</div>
		<?php else : ?>
			<button type="button"
					data-option-id="<?php echo esc_attr( $option_name ); ?>"
					data-flag="<?php echo esc_attr( 'onpage' ); ?>"
					class="wds-activate-component button button-small wds-button-with-loader wds-button-with-right-loader wds-disabled-during-request">

				<?php esc_html_e( 'Activate', 'wds' ); ?>
			</button>
		<?php endif; ?>
	</div>
</section>