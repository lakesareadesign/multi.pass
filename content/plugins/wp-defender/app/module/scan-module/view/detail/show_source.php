<?php if ( ! is_null( $error ) ): ?>
	<div class="wd-error">
		<?php echo $error; ?>
	</div>
<?php endif; ?>
<div class="group core-integrity-detail">
	<section class="dev-box setup-scan">
		<div class="box-title">
			<h3>
				<?php _e( "View Source", wp_defender()->domain ) ?>
			</h3>
		</div>
		<div class="box-content">
			<?php
			$source = $model->get_file_source();
			?>
			<?php _e( "Compare your file with the original file in the WordPress repository. Pieces highlighted in red will be removed when you patch the file, and pieces highlighted in green will be added.", wp_defender()->domain ) ?>
			<pre><code><?php echo $source ?></code></pre>
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