<?php if ( ! is_null( $error ) ): ?>
	<div class="wd-error">
		<?php echo $error; ?>
	</div>
<?php endif; ?>
<div class="group core-integrity-detail">
	<div class="col span_8_of_12 float-r">
		<section class="dev-box setup-scan">
			<div class="box-title">
				<h3>
					<?php _e( "File Comparison", wp_defender()->domain ) ?>
				</h3>
			</div>
			<div class="box-content">
				<?php
				$orinial = $model->get_file_original_source();
				$yours   = file_get_contents( $model->name );
				if ( ! is_wp_error( $orinial ) ):
					?>
					<?php _e( "Compare your file with the original file in the WordPress repository. Pieces highlighted in red will be removed when you patch the file, and pieces highlighted in green will be added.", wp_defender()->domain ) ?>
					<pre><code><?php echo WD_Utils::text_diff( $yours, $orinial ) ?></code></pre>
					<script type="text/javascript">
						jQuery(function ($) {
							$('pre code').each(function (i, block) {
								hljs.highlightBlock(block);
							});
						})
					</script>
				<?php else: ?>
					<div class="wd-error">
						<?php echo $orinial->get_error_message() ?>
					</div>
				<?php endif; ?>
			</div>
		</section>
	</div>
	<div class="col span_4_of_12 fixed">
		<section class="dev-box setup-scan">
			<div class="box-title">
				<h3>
					<?php _e( "Automate Resolve", wp_defender()->domain ) ?>
				</h3>
			</div>
			<div class="box-content">
				<?php
				global $wp_version;
				$name = $model->get_sub();
				?>
				<p class="tc">
					<?php printf( __( "This will overwrite the file <strong>%s</strong> with the official WordPress <strong>%s</strong> <strong>%s</strong> file.", wp_defender()->domain ), $name, $wp_version, $name ) ?>
				</p>

				<form id="wd_resolve_ci" method="post">
					<input type="hidden" name="action" value="wd_resolve_core_integrity"/>
					<input type="hidden" name="id" value="<?php echo $model->id ?>">
					<?php wp_nonce_field( 'wd_resolve_core_integrity', 'wd_resolve_nonce' ) ?>
					<button type="submit" class="button wd-button block">
						<?php _e( "Download and Patch", wp_defender()->domain ) ?>
					</button>
				</form>
			</div>
		</section>
	</div>
</div>