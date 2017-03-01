<div class="wds-keyword-pairs">

	<div class="wds-keyword-pairs-existing">
	<% if (pairs) { %>
		<%= pairs %>
	<% } else { %>
		<p><%- Wds.l10n('keywords', 'There\'s no custom keywords defined just yet. Why not add some?') %></p>
	<% } %>
	</div>

	<div class="wds-keyword-pair-new">

		<%= template_pair %>

		<div class="wds-overlay">
			<button type="button" class="button button-cta-dark"><%- Wds.l10n('keywords', 'Add Keyword Group') %></button>
		</div>

	</div><!-- end wds-keyword-pair-new -->

</div>