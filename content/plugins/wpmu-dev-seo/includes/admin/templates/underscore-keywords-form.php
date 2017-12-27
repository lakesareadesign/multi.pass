<dialog class="dev-overlay wds-modal wds-custom-keywords-modal" id="wds-custom-keywords" title="{{- idx == 0 ? Wds.l10n('keywords', 'Add Custom Keywords') : Wds.l10n('keywords', 'Update Custom Keywords') }}">
	<form class="wds-form">
		<input type="hidden" class="wds-custom-idx" value="{{- idx }}"/>
		<label class="wds-label">{{- Wds.l10n('keywords', 'Keyword group') }}</label>
		<p class="wds-label-description">{{- Wds.l10n('keywords', 'Choose your keywords, and then specify the URL to auto-link to.') }}</p>

		<div class="wds-table-fields wds-table-fields-stacked">
			<div class="label">
				<label class="wds-label">{{- Wds.l10n('keywords', 'Keyword group') }} <span>{{- Wds.l10n('keywords', '- Usually related terms') }}</span></label>
			</div>
			<div class="fields">
				<input type="text" class="wds-field wds-custom-keywords" value="{{- keywords }}" placeholder="{{- Wds.l10n('keywords', 'E.g. Cats, Kittens, Felines') }}"/>
			</div>
		</div>

		<div class="wds-table-fields wds-table-fields-stacked">
			<div class="label">
				<label class="wds-label">{{- Wds.l10n('keywords', 'Link URL') }} <span>{{- Wds.l10n('keywords', '- Both internal and external links are supported') }}</span></label>
			</div>
			<div class="fields">
				<input type="text" class="wds-custom-url" value="{{- url }}" placeholder="{{- Wds.l10n('keywords', 'E.g. /cats') }}"/>
				<p class="wds-field-legend">{{= Wds.l10n('keywords', 'Formats include relative (E.g. <b>/cats</b>) or absolute URLs (E.g. <b>www.website.com/cats</b> or <b>https://website.com/cats</b>).') }}</p>
			</div>
		</div>

		<div class="wds-box-footer">
			<button type="button" class="wds-cancel-button button button-dark-o">{{- Wds.l10n('keywords', 'Cancel') }}</button>
			<button type="button" class="wds-action-button button">{{- idx == 0 ? Wds.l10n('keywords', 'Add') : Wds.l10n('keywords', 'Update') }}</button>
		</div>
	</form>
</dialog>