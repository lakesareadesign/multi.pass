<div class="as3cf-setting enable-minify-excludes minify-excludes <?php echo empty( $minify_excludes ) ? 'hide' : ''; // xss ok ?>">
	<textarea name="minify-excludes" rows="5" cols="50" <?php echo $disabled_attr; ?>><?php echo esc_attr( $this->get_setting( 'minify-excludes' ) ); ?></textarea>
	<span class="as3cf-validation-error" style="display: none;">
		<?php _e( 'Invalid character. Only normal file path characters are allowed.', 'amazon-s3-and-cloudfront-assets' ); ?>
	</span>
</div>
