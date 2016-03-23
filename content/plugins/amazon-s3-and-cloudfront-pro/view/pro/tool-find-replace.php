<div class="redirect-content modal-content upload">
	<span class="close-redirect-content close-redirect-content-button">&times;</span>

	<div class="redirect-header">
		<h2 class="redirect-title"><?php _e( 'What about links in your content?', 'amazon-s3-and-cloudfront' ); ?></h2>
		<p class="redirect-desc upload"><?php _e( 'Your content (posts, pages, etc) has URLs to images and other files on your server. What would you like to do about those URLs?', 'amazon-s3-and-cloudfront' ); ?></p>
		<p class="redirect-desc download"><?php _e( 'Your content (posts, pages, etc) has URLs to images and other files on S3. What would you like to do about those URLs?', 'amazon-s3-and-cloudfront' ); ?></p>
	</div>

	<div class="redirect-options">
		<label class="replace">
			<input type="radio" name="existing-links" value="replace" checked="checked"> <?php _e( 'Find & Replace (recommended)', 'amazon-s3-and-cloudfront' ); ?>
			<p class="upload"><?php _e( 'Run a find & replace on all content, replacing old URLs with the new S3 URLs.', 'amazon-s3-and-cloudfront' ); ?></p>
			<p class="download"><?php _e( 'Run a find & replace on all content, replacing S3 URLs with the local URLs.', 'amazon-s3-and-cloudfront' ); ?></p>
		</label>
		<label class="nothing">
			<input type="radio" name="existing-links" value="nothing"> <?php _e( 'Nothing', 'amazon-s3-and-cloudfront' ); ?>
			<p class="upload"><?php _e( 'Keep serving them from the server.', 'amazon-s3-and-cloudfront' ); ?></p>
			<p class="download"><?php _e( 'Keep serving them from S3.', 'amazon-s3-and-cloudfront' ); ?></p>
		</label>
		<div class="notice notice-warning inline">
			<p><strong><?php _e( 'Broken Images & Links', 'amazon-s3-and-cloudfront' ); ?></strong> &mdash; <?php _e( 'Since you have <em>Remove Files From Server</em> turned on in your
settings, files on your server will be removed as they are uploaded to S3, resulting in broken images and links.', 'amazon-s3-and-cloudfront' ); ?></p>
		</div>
	</div>

	<div class="redirect-controls">
		<span class="as3cf-start-process button upload"><?php _ex( 'Start Upload', 'Start uploading media library', 'amazon-s3-and-cloudfront' ); ?></span>
		<span class="as3cf-start-process button download"><?php _ex( 'Start Download', 'Start downloading media library', 'amazon-s3-and-cloudfront' ); ?></span>
	</div>
</div>