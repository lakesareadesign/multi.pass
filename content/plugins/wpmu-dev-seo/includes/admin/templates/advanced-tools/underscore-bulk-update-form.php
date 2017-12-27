<dialog class="dev-overlay wds-modal wds-bulk-update-redirects-modal" id="wds-bulk-update-redirects" title="{{- Wds.l10n('redirects', 'Bulk Update') }}">
	<form class="wds-form">

		{{ if(indices) { }}
			<div class="wds-table-fields">
				<div class="label">
					<label class="wds-label">{{- Wds.l10n('redirects', 'New URL') }}</label>
				</div>
				<div class="fields">
					<input class="wds-field" title="" type="text"/>
				</div>
			</div>

			<div class="wds-table-fields">
				<div class="label">
					<label class="wds-label">{{- Wds.l10n('redirects', 'Redirect Type') }}</label>
				</div>
				<div class="fields">
					<select title="">
						<option value="301">{{- Wds.l10n('redirects', 'Permanent (301)') }}</option>
						<option value="302">{{- Wds.l10n('redirects', 'Temporary (302)') }}</option>
					</select>
				</div>
			</div>
		{{ } else { }}
			<p>{{- Wds.l10n('redirects', 'Please select some items to edit them.') }}</p>
		{{ } }}

		<input type="hidden" value="{{- indices }}"/>
		<div class="wds-box-footer">
			<button type="button" class="wds-cancel-button button button-dark-o"><?php esc_html_e('Cancel', 'wds'); ?></button>
			{{ if(indices) { }}
				<button type="button" class="wds-action-button button"><?php esc_html_e('Update', 'wds'); ?></button>
			{{ } }}
		</div>
	</form>
</dialog>