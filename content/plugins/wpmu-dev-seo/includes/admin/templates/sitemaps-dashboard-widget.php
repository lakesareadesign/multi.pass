<div style='width:45%;float:left'>
	<div>
		<?php
		printf(
			esc_html__( 'Your sitemap contains %s.', 'wds' ),
			sprintf(
				'<a href="%1$s" target="_blank"><b>%2$d</b> %3$s</a>',
				esc_url( $sitemap_url ),
				(int) smartcrawl_get_array_value( $opts, 'items' ),
				esc_html__( 'items' )
			)
		);
		?>
	</div>
	<br/><?php echo esc_html( $datetime ); ?>
	<p><a href='#update_sitemap' id='wds_update_now'><?php echo esc_html( $update_sitemap ); ?></a></p>
</div>

<div style='width:45%;float:right'>
	<?php if ( $engines ) { ?>
		<ul>
			<?php
			foreach ( $engines as $key => $engine ) {
				$service = ucfirst( $key );
				$edate = ! empty( $engine['time'] ) ? date( get_option( 'date_format' ), $engine['time'] ) : false;
				$etime = ! empty( $engine['time'] ) ? date( get_option( 'time_format' ), $engine['time'] ) : false;
				$edatetime = ( $edate && $etime ) ? sprintf( __( 'Last notified on %1$s, at %2$s.', 'wds' ), $date, $time ) : __( 'Not notified', 'wds' );
				?>
				<li><b><?php echo esc_html( $service ); ?>:</b> <?php echo esc_html( $edatetime ); ?></li>
			<?php } ?>

		</ul>

	<?php } else { ?>
		<div><?php esc_html_e( "Search engines haven't been recently updated.", 'wds' ); ?></div>
	<?php } ?>

	<?php if ( $se_notifications_enabled ): ?>
		<p><a href='#update_search_engines' id='wds_update_engines'><?php echo esc_html( $update_engines ); ?></a></p>
	<?php else: ?>
		<p><?php esc_html_e( 'Search engine notifications are disabled. You can enable them in the sitemap settings.', 'wds' ); ?></p>
	<?php endif; ?>
</div>
<div style='clear:both'></div>

<script type="text/javascript">
	;
	(function ($) {
		$(function () {
			$("#wds_update_now").click(function () {
				var me = $(this);
				me.html("<?php echo esc_js( $working ); ?>");

				$.post(ajaxurl, {"action": "wds_update_sitemap"}, function () {
					me.html("<?php echo esc_js( $done_msg ); ?>");
					window.location.reload();
				});

				return false;
			});

			$("#wds_update_engines").click(function () {
				var me = $(this);
				me.html("<?php echo esc_js( $working ); ?>");

				$.post(ajaxurl, {"action": "wds_update_engines"}, function () {
					me.html("<?php echo esc_js( $done_msg ); ?>");
					window.location.reload();
				});

				return false;
			});
		});
	})(jQuery);
</script>