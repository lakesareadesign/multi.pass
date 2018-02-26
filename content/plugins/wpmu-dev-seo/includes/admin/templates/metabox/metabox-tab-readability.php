<?php if ( ! Smartcrawl_Settings::get_setting( 'analysis-readability' ) ) { return false; } ?>
<div class="wds-metabox-section">
	<p><?php esc_html_e( 'We’ve analyzed your content to see how readable it is for the average person. Suggestions are based on best practice, but only you can decide what works for you and your readers.', 'wds' ); ?></p>
	<a href="#reload"><?php esc_html_e( 'Reload', 'wds' ); ?></a>

	<p class="wds-readability-legend wds-small-text">
		<span><strong><?php esc_html_e( 'Difficult', 'wds' ); ?></strong> <?php esc_html_e( '= Less than 60', 'wds' ); ?></span>
		<span><strong><?php esc_html_e( 'OK', 'wds' ); ?></strong> <?php esc_html_e( '= 60 to 70', 'wds' ); ?></span>
		<span><strong><?php esc_html_e( 'Easy', 'wds' ); ?></strong> <?php esc_html_e( '= 70+', 'wds' ); ?></span>
	</p>

	<?php do_action( 'wds-editor-metabox-readability-analysis', $post ); ?>
</div>