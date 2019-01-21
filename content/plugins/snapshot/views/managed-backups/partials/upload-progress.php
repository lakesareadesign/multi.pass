<div id="wps-upload-progress">

	<p><?php esc_html_e( 'Your upload is in progress. If your site is small, this will only take a few minutes, but could take a couple of hours for larger sites.', SNAPSHOT_I18N_DOMAIN ); ?></p>

	<div class="wpmud-box-gray">
		<div class="wps-loading-status wps-total-status wps-spinner">
			<p class="wps-loading-number">0%</p>
			<div class="wps-loading-bar">
				<div class="wps-loader">
					<span style="width: 0%"></span>
				</div>
			</div>
		</div>
	</div>

	<p><a id="wps-cancel"
	      class="button button-outline button-gray">
			<?php esc_html_e( 'Cancel', SNAPSHOT_I18N_DOMAIN ); ?></a>
	</p>

</div>