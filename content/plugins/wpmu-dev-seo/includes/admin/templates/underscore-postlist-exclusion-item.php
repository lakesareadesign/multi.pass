<tr data-id="{{- id }}">
	{{ if (is_loaded) { }}
		<td class="wds-postlist-item-title">{{= title }}</td>
		<td class="wds-postlist-item-type">{{= type }}</td>
		<td class="wds-postlist-item-remove"><a href="#remove" class="wds-postlist-list-item-remove button button-dark-o button-small">{{= Wds.l10n('postlist', 'Remove') }}</a></td>
	{{ } else { }}
		<td colspan="3">Loading post {{= id }}...</td>
	{{ } }}
</tr>