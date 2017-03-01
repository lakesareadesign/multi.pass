<li class="wds-postlist-list-item">
	<p class="group">
		<input
			id="<%- type %>-<%- id %>"
			class="wds-checkbox wds-checkbox-with-label wds-postlist-selector-list-item"
			value='<%- id %>'
			data-id="<%- id %>"
			data-title="<%- title %>"
			data-type="<%- type %>"
			data-date="<%- date %>"
			type='checkbox'
		<% if (existing) { %>
			checked
			readonly
			disabled
		<% } %>
		/>
		<label for="<%- type %>-<%- id %>" class="wds-label wds-label-radio wds-label-inline wds-label-inline-right"><%= title %> (<%= date %>)</label>
	</p>
</li>