<li data-id="{{- id }}">
	{{ if (is_loaded) { }}
		{{= title }}
		<a href="#remove" class="wds-postlist-list-item-remove"><i class="wdv-icon wdv-icon-fw wdv-icon-remove-sign"></i></a>
	{{ } else { }}
		Loading post {{= id }}...
	{{ } }}
</li>