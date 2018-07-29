<?php // phpcs:ignoreFile -- underscore template ?>
<div class="wds-keyword-pairs">

	{{ if (pairs) { }}
		<table class="wds-keyword-pairs-existing wds-list-table">
			<tr>
				<th>{{- Wds.l10n('keywords', 'Keyword') }}</th>
				<th colspan="3">{{- Wds.l10n('keywords', 'Auto-Linked URL') }}</th>
			</tr>
			{{= pairs }}
		</table>
	{{ } }}

	<div class="wds-keyword-pair-new">
		<button type="button" class="button button-dark">{{- Wds.l10n('keywords', 'Add New') }}</button>
	</div><!-- end wds-keyword-pair-new -->

</div>