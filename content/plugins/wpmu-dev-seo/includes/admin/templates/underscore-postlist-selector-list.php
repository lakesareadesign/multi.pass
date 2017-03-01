<section class="tab wds-postlist-list">

	<input type="radio" name="tab_postlist_group" id="tab_<%- tab %>" <%= checked %> value="<%-tab %>">
	<label for="tab_<%- tab %>"><%- tab_label %></label>

	<div class="content wds-content-tabs">

		<h2 class="tab-title"><%= tab %></h2>

		<div class="wds-content-tabs-inner">
		<% if (is_loading) { %>
			<p><%= Wds.l10n('postlist', 'Loading post items, please hold on') %></p>
		<% } else { %>
			<ul class="wds-postlist-list-items">
				<%= posts %>
			</ul>
		<% } %>

		<% if (meta.total > 1) { %>
			<div class="wds-postslist-list-pagination">
				<p class="group wds-group wds-group-field">
					<label for="wds-postslist-list-pagination-select" class="wds-label"><%= Wds.l10n('postlist', 'Jump to page') %></label>
					<select id='wds-postslist-list-pagination-select' class="wds-select">
					<% _.each(_.range(1, meta.total+1), function (idx) { %>
						<option
							value="<%- idx %>"
						<% if (meta.page === idx) { %>
							selected="selected"
						<% } %>
						>
								<%= idx %>
						</option>
					<% }) %>
					</select>
					<span class="wds-field-legend"><%= Wds.l10n('postlist', 'Total Pages') %> <%= meta.total %></span>
				</p>
			</div>
		<% } %>

		</div><!-- end wds-content-tabs-inner -->

	</div><!-- end wds-content-tabs -->

</section><!-- end wds-postlist-list -->