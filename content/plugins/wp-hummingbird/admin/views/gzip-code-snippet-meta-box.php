<?php
$htaccess_written = wphb_is_htaccess_written( 'gzip' );
$htaccess_writable = wphb_is_htaccess_writable();

$disabled = $htaccess_written || ! $htaccess_writable;
?>
<div class="wphb-content">

	<div id="wphb-server-instructions"></div>

	<div id="wphb-server-instructions-apache" class="wphb-server-instructions hidden" data-server="apache">
		<ol class="wphb-listing wphb-listing-ordered">
			<li><?php _e( 'Copy the generated code into your <strong>.htaccess</strong>, <strong>vhosts.conf</strong> or <strong>httpd.conf</strong> file.', 'wphb' ); ?></li>
			<li><?php esc_html_e( 'Look for your site in the file and find the line that starts with <Directory> - add the code above into that section and save the file.', 'wphb' ); ?></li>
			<li><?php _e( 'Reload Apache.', 'wphb' ); ?></li>
		</ol>

		<p><?php _e( 'Still having trouble? ', 'wphb' ); ?><a href="<?php echo esc_url( $support_link ); ?>"><?php _e( 'Open a support ticket.', 'wphb' ); ?></a></p>
	</div>

	<div id="wphb-server-instructions-nginx" class="wphb-server-instructions hidden" data-server="nginx">
		<ol class="wphb-listing wphb-listing-ordered">
			<li><?php _e( 'Copy the generated code into your <strong>nginx.conf</strong> usually located at <strong>/etc/nginx/nginx.conf</strong> or <strong>/usr/local/nginx/conf/nginx.conf</strong>', 'wphb' ); ?></li>
			<li><?php _e( 'Add the code above to the <strong>http</strong> or inside <strong>server</strong> section in the file.', 'wphb' ); ?></li>
			<li><?php _e( 'Reload NGINX.', 'wphb' ); ?></li>
		</ol>

		<p><?php _e( 'If you do not have access to your NGINX config files you will need to contact your hosting provider to make these changes.', 'wphb' ); ?></p>
		<p><?php _e( 'Still having trouble? ', 'wphb' ); ?><a href="<?php echo esc_url( $support_link ); ?>"><?php _e( 'Open a support ticket.', 'wphb' ); ?></a></p>
	</div>

	<div id="wphb-server-instructions-iis" class="wphb-server-instructions hidden" data-server="iis">
	</div>

	<div id="wphb-server-instructions-iis-7" class="wphb-server-instructions hidden" data-server="iis-7">
	</div>

	<script type="text/html" id="tmpl-wphb-server-instructions">
		<p><?php echo sprintf( __('For %s servers:', 'wphb'), '{{{ data.serverName }}}' ); ?></p>

		{{{ data.instructions }}}
	</script>

	<div id="wphb-code-snippet"></div>

	<?php foreach ( $snippets as $server => $snippet ): ?>
		<div id="wphb-code-snippet-<?php echo $server; ?>" class="wphb-code-snippet hidden" data-server="<?php echo $server; ?>">
			<div class="wphb-block-content">
				<pre><?php echo htmlentities2( $snippet ); ?></pre>
			</div>

			<div class="buttons buttons-on-right">
				<?php if ( 'apache' == $server && wphb_is_htaccess_writable() ): ?>
					<button id="wphb-write-htaccess" class="button" <?php disabled( $disabled ); ?>>Write .htaccess</button>
				<?php endif; ?>
			</div>

		</div>
	<?php endforeach; ?>

</div>

<script type="text/html" id="tmpl-wphb-code-snippet">{{{ data.snippet }}}</script>