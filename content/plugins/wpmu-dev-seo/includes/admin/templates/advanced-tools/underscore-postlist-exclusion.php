<?php // phpcs:ignoreFile -- underscore template ?>
<div class="wds-postlist-list wds-postlist-list-exclude">
{{ if (loaded) { }}
	<table class="wds-postlist wds-list-table {{= (!!posts ? '' : 'wds-postlist-empty_list') }}">
		<tr>
			<th>{{= Wds.l10n('postlist', 'Post') }}</th>
			<th colspan="2">{{= Wds.l10n('postlist', 'Post Type') }}</th>
		</tr>
		{{= posts }}
	</table>
{{ } else { }}
	<p><i>Loading posts, please hold on</i></p>
{{ } }}
	<div class="wds-postlist-add-post">
		<a href="#wds-postlist-selector" rel="dialog" class="button button-dark">{{= Wds.l10n('postlist', 'Add Posts') }}</a>
	</div>
</div>