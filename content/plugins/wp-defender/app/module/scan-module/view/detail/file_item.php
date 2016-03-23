<div class="group suspicious-detail">
	<div class="col span_10_of_12">
		<section class="dev-box">
			<div class="box-title">
				<h3>
					<?php printf( __( "View Source %s", wp_defender()->domain ), $model->get_sub() ) ?>
				</h3>
			</div>
			<div class="box-content">
				<?php
				$content = file_get_contents( $model->name );
				$content = str_replace( ';', ';' . PHP_EOL, $content );
				$content = preg_replace( "/\n+/", "\n", $content );
				//we will need to wrap the code offset with a custom tag, so we can display toolip and styling
				$content = esc_html( $content );
				if ( isset( $model->detail['log'] ) ) {
					foreach ( $model->detail['log'] as $issue ) {
						$code = substr( $content, $issue['offset'][0], $issue['offset'][1] - $issue['offset'][0] );
						//we add a custom tag here
						$tooltips = $issue['offset'][0] . '-' . ( $issue['offset'][1] );
						$tag      = '<span class="wd-highlight" tooltip="' . esc_attr( $tooltips ) . '">' . $code . '</span>';
						//putback
						$content = str_replace( $code, $tag, $content );
					}
				}
				?>
				<pre><code><?php echo $content ?></code></pre>
				<script type="text/javascript">
					jQuery(function ($) {
						$('pre code').each(function (i, block) {
							hljs.highlightBlock(block);
						});
					})
				</script>
			</div>
		</section>
	</div>
	<div class="col span_2_of_12 fixed">
		<section class="dev-box setup-scan">
			<div class="box-title">
				<h3>
					<?php _e( "Navigate", wp_defender()->domain ) ?>
				</h3>
			</div>
			<div class="box-content">
				<div class="wd-button-group">
					<button tooltip="<?php esc_attr_e( "Previous", wp_defender()->domain ) ?>"
					        type="button"
					        class="button button-light button-small wd-prev">
						<i class="wdv-icon wdv-icon-fw wdv-icon-chevron-up"></i>
					</button>
					<button tooltip="<?php esc_attr_e( "Next", wp_defender()->domain ) ?>"
					        type="button" class="button button-light button-small wd-next">
						<i class="wdv-icon wdv-icon-fw wdv-icon-chevron-down"></i>
					</button>
				</div>
			</div>
		</section>
	</div>
</div>
<script type="text/javascript">
	jQuery(function ($) {
		var current = null;
		$('.wd-next').click(function () {
			if (current == null) {
				current = $('.wd-highlight').first();
			} else {
				var next = current.next('.wd-highlight').first();
				if (next != undefined) {
					current = next;
				}
			}

			if (current.is('span')) {
				$('html, body').animate({
					scrollTop: current.offset().top - 150
				}, 1000);
			}
		})
		$('.wd-prev').click(function () {
			if (current == null) {
				return;
			}

			var prev = current.prev('.wd-highlight');
			if (prev != undefined) {
				current = prev;
			}

			if (current.is('span')) {
				$('html, body').animate({
					scrollTop: current.offset().top - 150
				}, 1000);
			}
		})
	})
</script>