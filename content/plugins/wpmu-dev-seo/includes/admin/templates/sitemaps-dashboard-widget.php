
<div style='width:45%;float:left'>
	<div><?php printf( __( 'Your sitemap contains <a href="%s" target="_blank"><b>%d</b> items</a>.', 'wds' ), $sitemap_url, (int) @$opts['items'] ); ?></div>
	<br /><?php echo $datetime; ?>
	<p><a href='#update_sitemap' id='wds_update_now'><?php echo $update_sitemap; ?></a></p>
</div>

<div style='width:45%;float:right'>
	<?php if ($engines) { ?>
			<ul>
			<?php
				foreach ($engines as $key => $engine) {
					$service = ucfirst($key);
					$edate = @$engine['time'] ? date(get_option('date_format'), $engine['time']) : false;
					$etime = @$engine['time'] ? date(get_option('time_format'), $engine['time']) : false;
					$edatetime = ($edate && $etime) ? sprintf(__('Last notified on %s, at %s.', 'wds'), $date, $time) : __("Not notified", 'wds');
			?>
				<li><b><?php echo $service; ?>:</b> <?php echo $edatetime; ?></li>
			<?php } ?>

			</ul>

		<?php } else { ?>
			<?php _e("<div>Search engines haven't been recently updated</div>", 'wds'); ?>
		<?php } ?>

	<p><a href='#update_search_engines' id='wds_update_engines'><?php echo $update_engines; ?></a></p>
</div>
<div style='clear:both'></div>

<script type="text/javascript">
	;(function ($) {
		$(function () {
			$( "#wds_update_now" ).click(function () {
				var me = $( this );
				me.html( "<?php echo esc_js($working); ?>" );

				$.post(ajaxurl, { "action": "wds_update_sitemap" }, function () {
					me.html( "<?php echo esc_js($done_msg); ?>" );
					window.location.reload();
				});

				return false;
			});

			$("#wds_update_engines").click(function () {
				var me = $( this );
				me.html( "<?php echo esc_js($working); ?>" );

				$.post( ajaxurl, { "action": "wds_update_engines" }, function () {
					me.html( "<?php echo esc_js($done_msg); ?>" );
					window.location.reload();
				} );

				return false;
			});
		});
	})(jQuery);
</script>