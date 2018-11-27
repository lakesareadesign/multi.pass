<p><?php esc_html_e( "We have encountered an error while importing your data. You may retry the import or contact our support if the problem persists.", 'wds' ); ?></p>
{{ if(error) { }}
<div class="wds-notice wds-notice-error">
    <p>{{- error }}</p>
</div>
{{ } }}

<div class="action wds-box-footer">
    <button type="button" class="button button-dark button-dark-o wds-import-skip">
		<?php esc_html_e( 'Cancel', 'wds' ); ?>
    </button>

    <button class="button wds-import-main-action wds-reattempt-import">
		<?php esc_html_e( 'Try Again', 'wds' ); ?>
    </button>
</div>