<fieldset class="inline-edit-col-left" style="clear:left">
	<div class="inline-edit-col">
		<h4><?php esc_html_e( 'SmartCrawl', 'wds' ); ?></h4>
		<label>
			<span class="title"><?php esc_html_e( 'Title Tag', 'wds' ); ?></span>
			<span class="input-text-wrap">
				<input class="ptitle smartcrawl_title" type="text" value="" name="wds_title"/>
                <input type="hidden"
                       value="<?php echo esc_attr( wp_create_nonce( 'wds-metabox-nonce' ) ); ?>"
                       name="_wds_nonce"/>
			</span>
		</label>
	</div>
</fieldset>