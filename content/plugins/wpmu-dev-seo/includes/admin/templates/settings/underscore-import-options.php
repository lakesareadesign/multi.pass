<div class="box-content modal">
	<p><?php printf( esc_html__( "Choose what you'd like to import from %s.", 'wds' ), '{{- plugin_name }}' ); ?></p>

	<div class="wds-separator-top wds-import-item">
		<?php $this->_render( 'toggle-item', array(
			'field_name'       => 'import-options',
			'checked'          => 'checked',
			'item_label'       => esc_html__( 'Plugin Options', 'wds' ),
			'item_description' => sprintf( esc_html__( 'Import %s settings that are relevant to SmartCrawl.', 'wds' ), '{{- plugin_name }}' ),
		) ); ?>
	</div>

	<div class="wds-separator-top wds-import-item">
		<?php
		$this->_render( 'toggle-item', array(
			'field_name'       => 'import-term-meta',
			'checked'          => 'checked',
			'item_label'       => esc_html__( 'Term Meta', 'wds' ),
			'item_description' => esc_html__( 'Import your title & meta settings for categories, tags and custom taxonomies.', 'wds' ),
		) );
		?>
	</div>

	<div class="wds-separator-top wds-import-item">
		<?php
		$this->_render( 'toggle-item', array(
			'field_name'       => 'import-post-meta',
			'checked'          => 'checked',
			'attributes'       => array( 'data-dependent' => 'keep-existing-post-meta' ),
			'item_label'       => esc_html__( 'Post Meta', 'wds' ),
			'item_description' => esc_html__( 'Import your title & meta settings for posts and pages.', 'wds' ),
		) );
		?>
	</div>

	<div class="wds-advanced-import-options">
		<span><?php esc_html_e( 'Advanced', 'wds' ); ?></span>
		<div class="wds-advanced-import-options-inner">
			<div class="wds-separator-top wds-import-item">
				<?php
				$this->_render( 'toggle-item', array(
					'field_name'       => 'keep-existing-post-meta',
					'checked'          => '',
					'item_label'       => esc_html__( 'Keep Existing Post Meta', 'wds' ),
					'item_description' => esc_html__( 'If you have already set up SmartCrawl on some posts and pages then enable this option to keep those values from getting overwritten.', 'wds' ),
				) );
				?>
			</div>
		</div>
	</div>
</div>

<div class="action wds-box-footer">
	<button type="button" class="button wds-import-main-action wds-import-start">
		<?php esc_html_e( 'Begin Import', 'wds' ); ?>
	</button>

	<span class="wds-box-footer-description" type="button">
		<?php esc_html_e( 'Note: Importing can take a while if you have a large amount of content on your website.', 'wds' ); ?>
	</span>
</div>