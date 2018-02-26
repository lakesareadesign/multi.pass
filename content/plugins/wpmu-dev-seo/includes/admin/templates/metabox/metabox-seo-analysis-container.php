<?php $post = empty( $post ) ? null : $post; ?>

<div class="wds-seo-analysis-container">
	<label class="wds-label"><?php esc_html_e( 'SEO Analysis', 'wds' ); ?></label>

	<?php
		$this->_render('mascot-message', array(
			'key'     => 'metabox-seo-analysis',
			'message' => esc_html__( 'This tool helps you optimize your content to give it the best chance of being found in search engines when people are looking for it. Start by choosing a few focus keywords that best describe your article, then SmartCrawl will give you recommendations to make sure your content is highly optimized.', 'wds' ),
		));
	?>

	<?php if ( apply_filters( 'wds-metabox-visible_parts-focus_area', true ) ) :  ?>
		<div class="wds-focus-keyword wds-table-fields wds-table-fields-stacked">
			<div class="label">
				<label class="wds-label" for='wds_focus'>
					<?php esc_html_e( 'Focus keyword' , 'wds' ); ?>
					<span><?php esc_html_e( '- Choose a single word, phrase or part of a sentence that people will likely search for.', 'wds' ); ?></span>
				</label>
			</div>
			<div class="fields">
				<input type='text'
					   id='wds_focus'
					   name='wds_focus'
					   value='<?php echo esc_html( smartcrawl_get_value( 'focus-keywords' ) ); ?>'
					   class='wds wds-disabled-during-request' placeholder="<?php esc_html_e( 'E.g. broken iphone screen', 'wds' ); ?>"/>
			</div>
		</div>
	<?php endif; ?>

	<a href="#reload"><?php esc_html_e( 'Reload', 'wds' ); ?></a>
	<?php do_action( 'wds-editor-metabox-seo-analysis', $post ); ?>
</div>