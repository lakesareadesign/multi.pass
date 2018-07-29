<?php // phpcs:ignoreFile -- underscore template ?>
<dialog class="dev-overlay wds-modal wds-custom-keywords-modal" id="wds-custom-keywords" title="{{- idx == 0 ? Wds.l10n('keywords', 'Add Custom Keywords') : Wds.l10n('keywords', 'Update Custom Keywords') }}">
	<form class="wds-form">
		<input type="hidden" class="wds-custom-idx" value="{{- idx }}"/>
		<label class="wds-label">{{- Wds.l10n('keywords', 'Keyword group') }}</label>
		<p class="wds-label-description">{{- Wds.l10n('keywords', 'choose-your-keywords-and-url') }}</p>

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
				<label class="wds-label">{{- Wds.l10n('keywords', 'Link URL') }} <span>{{- Wds.l10n('keywords', 'internal-external-links-supported') }}</span></label>
			</div>
			<div class="fields">
				<input type="text" class="wds-custom-url" value="{{- url }}" placeholder="{{- Wds.l10n('keywords', 'E.g. /cats') }}"/>
				<p class="wds-field-legend">{{= Wds.l10n('keywords', 'url-formats-explanation') }}</p>
			</div>
		</div>

		<div class="wds-box-footer">
			<button type="button" class="wds-cancel-button button button-dark-o">{{- Wds.l10n('keywords', 'Cancel') }}</button>
			<button type="button" class="wds-action-button button">{{- idx == 0 ? Wds.l10n('keywords', 'Add') : Wds.l10n('keywords', 'Update') }}</button>
		</div>
	</form>
</dialog>