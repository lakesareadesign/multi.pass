<dialog class="dev-overlay wds-modal wds-postlist-selector-modal" id="wds-postlist-selector" title="<?php esc_html_e( 'Choose Posts, Pages & Custom Post Types to exclude', 'wds' ); ?>">
	<div class="box-content wds-postlist-selector">

		<div class="vertical-tabs" id="content-type-excludes">
			{{= lists }}
		</div>

	</div>

	<div class="box-footer buttons">
		<button type="button" class="button button-cta-dark">Add to Excludes</button>
	</div>

</dialog>