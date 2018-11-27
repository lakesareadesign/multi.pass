<p><?php esc_html_e( 'All done!', 'wds' ); ?></p>
<div class="wds-notice wds-notice-success">
	<p>
		<?php printf( esc_html__( 'Your %s settings have been imported successfully and are now active.', 'wds' ), '{{- plugin_name }}' ); ?>
		{{ if(deactivation_url) { }}
		<?php printf( esc_html__( 'We highly recommend you deactivate %s to avoid potential conflicts.', 'wds' ), '{{- plugin_name }}' ); ?>
		{{ } }}
	</p>
</div>

<div class="action wds-box-footer">
	<button type="button" class="button button-dark button-dark-o wds-import-skip">
		<?php esc_html_e( 'Close', 'wds' ); ?>
	</button>

	{{ if(deactivation_url) { }}
	<a class="button wds-import-main-action" href="{{= deactivation_url }}">
		<?php esc_html_e( 'Deactivate', 'wds' ); ?> {{- plugin_name }}
	</a>
	{{ } }}
</div>