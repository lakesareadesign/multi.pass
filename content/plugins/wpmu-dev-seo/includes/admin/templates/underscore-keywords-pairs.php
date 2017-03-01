<div class="wds-keyword-pair" data-idx="<%- idx %>">
	<div class="wds-group-field">
		<div class="wds-pair-part wds-keywords">
			<label class="wds-label">
				<%- Wds.l10n('keywords', 'Custom Keywords') %>
				<input type="text" class="wds-field" value="<%- keywords %>" placeholder="<%- Wds.l10n('keywords', 'e.g. Cats, Kittens, Felines') %>" />
			</label>
			<span class="wds-field-legend"><%- Wds.l10n('keywords', 'Add Keywords separated by comma') %></span>
		</div>
	</div>
	<div class="wds-group-field">
		<div class="wds-pair-part wds-url">
			<label class="wds-label">
				<%- Wds.l10n('keywords', 'Link To') %>
				<input type="text" class="wds-field" value="<%- url %>" placeholder="<%- Wds.l10n('keywords', 'e.g. http://cats.com') %>"  />
			</label>
			<span class="wds-field-legend"><%- Wds.l10n('keywords', 'Add URL to link Custom Keywords') %></span>
		</div>
	</div>
<% if (idx) { %>
	<a href="#remove" class="wds-pair-remove"><i class="wdv-icon wdv-icon-fw wdv-icon-remove-sign"></i></a>
<% } %>
</div>