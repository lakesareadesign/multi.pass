<?php
$selected_bucket        = $this->get_setting( 'bucket' );
$selected_bucket_prefix = $this->get_object_prefix( 'enable-script-object-prefix' );

$prefix = $this->get_plugin_prefix_slug();
?>
<div id="tab-assets" data-prefix="<?php echo $prefix; ?>" class="aws-content as3cf-tab<?php echo ( $selected_bucket ) ? ' as3cf-has-bucket' : ''; // xss ok ?>">
	<?php
	do_action( 'as3cf_pre_tab_render', 'assets' );
	$this->render_bucket_permission_errors(); ?>

	<div class="as3cf-main-settings">
		<form method="post">
			<input type="hidden" name="action" value="save" />
			<input type="hidden" name="plugin" value="<?php echo $this->get_plugin_slug(); ?>" />
			<?php wp_nonce_field( $this->get_settings_nonce_key() ) ?>

			<table class="form-table">
				<?php
				$doc_link = $this->more_info_link( 'https://deliciousbrains.com/wp-offload-s3/doc/font-cors/' );

				$after_bucket_content = '<p class="web-font-notice">' . __( 'Having issues with web fonts not loading?', 'as3cf-assets' ) . ' ' . $doc_link . '</p>';
				$this->render_view( 'bucket-setting',
					array(
						'prefix'                 => $prefix,
						'selected_bucket'        => $selected_bucket,
						'selected_bucket_prefix' => $selected_bucket_prefix,
						'tr_class'               => 'as3cf-border-bottom',
						'after_bucket_content'   => $after_bucket_content,
					)
				);
				?>
				<tr class="as3cf-setting-title">
					<td colspan="2"><h3><?php _e( 'Enable/Disable the addon', 'as3cf-assets' ); ?></h3></td>
				</tr>
				<?php $args = $this->get_setting_args( 'enable-addon' ); ?>
				<tr class="as3cf-border-bottom <?php echo $args['tr_class']; ?>">
					<td>
						<?php $this->render_view( 'checkbox', $args ); ?>
					</td>
					<td>
						<?php echo $args['setting_msg']; ?>
						<h4><?php _e( 'Copy & Serve', 'as3cf-assets' ) ?></h4>

						<p class="enable-addon-desc">
							<?php _e( 'Copy assets to S3 and rewrite URLs for enqueued CSS & JS scripts.', 'as3cf-assets' ); ?>
							<?php echo $this->assets_more_info_link( 'copy-and-serve' ); ?>
						</p>
					</td>
				</tr>
				<tr class="as3cf-setting-title">
					<td colspan="2"><h3><?php _e( 'Scanning', 'as3cf-assets' ); ?></h3></td>
				</tr>
				<?php $args = $this->get_setting_args( 'enable-cron' ); ?>
				<tr>
					<td>
						<?php $this->render_view( 'checkbox', $args ); ?>
					</td>
					<td class="<?php echo $args['tr_class']; ?>">
						<?php echo $args['setting_msg']; ?>
						<h4><?php _e( 'Automatic Scanning', 'as3cf-assets' ) ?></h4>

						<p class="object-prefix-desc">
							<?php printf( __( 'Files will be scanned every %d minutes, new and changed files will be uploaded to S3 and missing files will be removed.', 'as3cf-assets' ), $this->scanning_cron_interval_in_minutes ); ?>
							<?php echo $this->assets_more_info_link( 'automatic-scanning' ); ?>
						</p>
					</td>
				</tr>
				<?php $args = $this->get_setting_args( 'file-extensions' ); ?>
				<tr class="as3cf-border-bottom <?php echo $args['tr_class']; ?>">
					<td></td>
					<td>
						<?php echo $args['setting_msg']; ?>
						<h4><?php _e( 'File Extensions', 'as3cf-assets' ) ?></h4>
						<p>
							<?php _e( 'Comma separated list of file extensions to scan for and upload to S3.', 'as3cf-assets' ); ?>
							<?php echo $this->assets_more_info_link( 'file-extensions' ); ?>
						</p>
						<p class="as3cf-setting">
							<input type="text" class="file-extensions" name="file-extensions" value="<?php echo esc_attr( $this->get_setting( 'file-extensions' ) ); ?>" <?php echo $args['disabled_attr']; ?>/>
						</p>
					</td>
				</tr>
				<tr class="as3cf-setting-title">
					<td colspan="2"><h3><?php _e( 'File URLs', 'as3cf-assets' ); ?></h3></td>
				</tr>
				<?php $this->render_view( 'domain-setting' ); ?>
				<?php
				$args          = $this->get_setting_args( 'enable-script-object-prefix' );
				$args['class'] = 'sub-toggle';
				?>
				<tr class="<?php echo $args['tr_class']; ?>">
					<td>
						<?php $this->render_view( 'checkbox', $args ); ?>
					</td>
					<td>
						<?php echo $args['setting_msg']; ?>
						<h4><?php _e( 'Path', 'as3cf-assets' ) ?></h4>

						<p class="object-prefix-desc">
							<?php _e( "Useful if you're using a bucket for other things.", 'as3cf-assets' ); ?>
							<?php echo $this->assets_more_info_link( 'path' ); ?>
						</p>
						<?php $args = $this->get_setting_args( 'object-prefix' ); ?>
						<p class="as3cf-setting enable-script-object-prefix <?php echo ( $this->get_setting( 'enable-script-object-prefix' ) ) ? '' : 'hide'; // xss ok ?>">
							<input type="text" name="object-prefix" value="<?php echo esc_attr( $this->get_setting( 'object-prefix' ) ); ?>" size="30" <?php echo $args['disabled_attr']; ?>/>
						</p>
					</td>
				</tr>
				<?php $args = $this->get_setting_args( 'force-https' ); ?>
				<tr class="as3cf-border-bottom <?php echo $args['tr_class']; ?>">
					<td>
						<?php $this->render_view( 'checkbox', $args ); ?>
					</td>
					<td>
						<?php echo $args['setting_msg']; ?>
						<h4><?php _e( 'Force HTTPS', 'as3cf-assets' ) ?></h4>

						<p class="object-prefix-desc">
							<?php _e( "By default we use HTTPS when the request is HTTPS and regular HTTP when the request is HTTP, but you may want to force the use of HTTPS always, regardless of the request.", 'as3cf-assets' ); ?>
							<?php echo $this->assets_more_info_link( 'force-https' ); ?>
						</p>
					</td>
				</tr>
				<tr class="as3cf-setting-title">
					<td colspan="2"><h3><?php _e( 'Advanced Options', 'as3cf-assets' ); ?></h3></td>
				</tr>
				<?php
				$minify        = $this->get_setting( 'enable-minify' );
				$args          = $this->get_setting_args( 'enable-minify' );
				$args['class'] = 'sub-toggle';
				?>
				<tr class="<?php echo $args['tr_class']; ?>">
					<td>
						<?php $this->render_view( 'checkbox', $args ); ?>
					</td>
					<td>
						<?php echo $args['setting_msg']; ?>
						<h4><?php _e( 'Minify', 'as3cf-assets' ) ?></h4>

						<p class="enable-minify-desc">
							<?php _e( 'Reduce CSS and JS file size by removing unnecessary data.', 'as3cf-assets' ); ?>
							<?php echo $this->assets_more_info_link( 'minify' ); ?>
						</p>
					</td>
				</tr>
				<?php
				$minify_excludes = $this->get_setting( 'enable-minify-excludes' );
				$args            = $this->get_setting_args( 'enable-minify-excludes' );
				$args['class']   = 'sub-toggle';
				?>
				<tr class="as3cf-setting <?php echo $args['tr_class']; echo empty( $minify ) ? ' hide' : ''; // xss ok ?> enable-minify">
					<td>
						<?php $this->render_view( 'checkbox', $args ); ?>
					</td>
					<td>
						<?php echo $args['setting_msg']; ?>
						<h4><?php _e( 'Exclude Files From Minify', 'as3cf-assets' ) ?></h4>

						<p class="enable-minify-exclude-desc">
							<?php _e( 'List of files to be excluded from minify. One per line.', 'as3cf-assets' ); ?>
							<?php echo $this->assets_more_info_link( 'minify-excludes' ); ?>
						</p>
						<?php
						$args                    = $this->get_setting_args( 'minify-excludes' );
						$args['minify']          = $minify;
						$args['minify_excludes'] = $minify_excludes;
						$this->render_view( 'minify-excludes-setting', $args );
						?>
					</td>
				</tr>
				<?php $args = $this->get_setting_args( 'enable-gzip' ); ?>
				<tr class="<?php echo $args['tr_class']; ?>">
					<td>
						<?php $this->render_view( 'checkbox', $args ); ?>
					</td>
					<td>
						<?php echo $args['setting_msg']; ?>
						<h4><?php _e( 'Gzip', 'as3cf-assets' ) ?></h4>

						<p class="enable-gzip-desc">
							<?php _e( 'Compress assets to reduce overall file size.', 'as3cf-assets' ); ?>
							<?php echo $this->assets_more_info_link( 'gzip' ); ?>
						</p>
						<?php
						$cdn_msg = __( '<strong>Warning</strong> &mdash; If you are using a CDN which supports automatic compression, you should turn off this option. Enabling compression within your CDN will reduce server load.', 'as3cf-assets' );
						$cdn_msg .= ' ' . $this->more_info_link( 'https://deliciousbrains.com/wp-offload-s3/doc/assets-enable-gzip-compression-in-cloudfront-and-maxcdn/' );

						$cdn_gzip_args = array(
							'message' => $cdn_msg,
							'id'      => 'as3cf-cdn-gzip-notice',
							'inline'  => true,
							'type'    => 'notice-warning',
							'style'   => 'display: none',
						);
						$this->render_view( 'notice', $cdn_gzip_args ); ?>
					</td>
				</tr>
				<?php
				$args          = $this->get_setting_args( 'enable-custom-endpoint' );
				$args['class'] = 'sub-toggle';
				?>
				<tr class="as3cf-border-bottom <?php echo $args['tr_class']; ?>">
					<td>
						<?php $this->render_view( 'checkbox', $args ); ?>
					</td>
					<td>
						<?php echo $args['setting_msg']; ?>
						<h4><?php _e( 'Webhook', 'as3cf-assets' ) ?></h4>
						<?php
						$key = esc_html( $this->get_setting( 'custom-endpoint-key' ) ); ?>
						<p>
							<?php _e( 'Initiate a scan using a URL.', 'as3cf-assets' ); ?>
							<?php echo $this->assets_more_info_link( 'webhook' ); ?>
						</p>

						<div class="as3cf-setting enable-custom-endpoint <?php echo ( $this->get_setting( 'enable-custom-endpoint' ) ) ? '' : 'hide'; // xss ok ?>">
							<p>
								<em class="custom-endpoint-url"><?php echo esc_url( home_url( '/?' . $this->custom_endpoint . '=' ) ); ?><span class="display-custom-endpoint-key"><?php echo $key; ?></span></em>
								<em class="custom-endpoint-url-generating"><?php _e( 'Generating new unique URL', 'as3cf-assets' ); ?>&hellip;</em>
							</p>
							<p><?php _e( 'Initiate a purge and scan using a URL.', 'as3cf-assets' ); ?></p>
							<p>
								<em class="custom-endpoint-url"><?php echo esc_url( home_url( '/?' . $this->custom_endpoint . '=' ) ); ?><span class="display-custom-endpoint-key"><?php echo $key; ?></span>&amp;purge=1</em>
								<em class="custom-endpoint-url-generating"><?php _e( 'Generating new unique URL', 'as3cf-assets' ); ?>&hellip;</em>
							</p>
							<p class="refresh-url-wrap">
								<a id="refresh-url" href="#"><?php _e( 'Generate New URL', 'as3cf-assets' ); ?></a>
							</p>
						</div>

						<input type="hidden" id="custom-endpoint-key" name="custom-endpoint-key" value="<?php echo $key; ?>">
					</td>
				</tr>
			</table>
			<p>
				<button type="submit" class="button button-primary" <?php echo $this->maybe_disable_save_button(); ?>><?php _e( 'Save Changes', 'as3cf-assets' ); ?></button>
			</p>
		</form>
	</div>
	<?php $this->render_view( 'bucket-select', array( 'prefix' => $prefix, 'selected_bucket' => $selected_bucket ) ); ?>
</div>
