
<fieldset class="inline-edit-col-left">
	<div class="inline-edit-col">
		<label>
			<span class="title metadesc"><?php _e( 'Meta Description', 'wds' ); ?></span>
				<textarea class="ptitle smartcrawl_metadesc" name="wds_metadesc"></textarea>
		</label>
	</div>
	<div class="inline-edit-col long-label">
		<label>
			<span class="title"><?php _e( 'Focus keywords', 'wds' ); ?></span>
			<span class="input-text-wrap">
				<input class="ptitle smartcrawl_focus" type="text" value="" name="wds_focus" />
			</span>
		</label>
	</div>
	<div class="inline-edit-col long-label">
		<label>
			<span class="title"><?php _e( 'Other Keywords', 'wds' ); ?></span>
			<span class="input-text-wrap">
				<input class="ptitle smartcrawl_keywords" type="text" value="" name="wds_keywords" />
			</span>
		</label>
	</div>
</fieldset>
<style>
.inline-edit-col .title.metadesc {
	display: block;
	margin-top: 20px;
	width: 100%;
}
.inline-edit-col.long-label .title {
	width: 10em;
}
.inline-edit-col.long-label .input-text-wrap {
	margin-left: 10em;
}
</style>