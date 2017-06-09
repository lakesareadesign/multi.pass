<div class="wds-postlist-list wds-postlist-list-exclude">
	<p class="wds-list-label">{{= Wds.l10n('postlist', 'Exclude Posts, Pages and CPTs') }}</p>
{{ if (loaded) { }}
	<ul class="wds-postlist {{= (!!posts ? '' : 'wds-postlist-empty_list') }}">
		{{= posts }}
	</ul>
{{ } else { }}
	<p><i>Loading posts, please hold on</i></p>
{{ } }}
	<a href="#wds-postlist-selector" rel="dialog" class="button button-cta-dark">{{= Wds.l10n('postlist', 'Add Posts, Pages and CPTs') }}</a>
</div>