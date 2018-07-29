<?php
$post = empty( $post ) ? null : $post;
?>

<div class="wds-form">
	<div class="wds-metabox-section">
		<?php
		$this->_render( 'metabox/metabox-preview', array(
			'post' => $post,
		) );
		?>

		<?php $this->_render( 'metabox/metabox-meta-edit-form' ); ?>
	</div>

	<?php if ( Smartcrawl_Settings::get_setting( 'analysis-seo' ) ) { ?>
		<div class="wds-metabox-section">
			<?php
			$this->_render( 'metabox/metabox-seo-analysis-container', array(
				'post' => $post,
			) );
			?>
		</div>
	<?php } ?>
</div>