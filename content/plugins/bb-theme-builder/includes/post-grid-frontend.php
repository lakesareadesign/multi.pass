<?php if ( 'columns' == $settings->layout ) : ?>
<div class="fl-post-column">
<?php endif; ?>

<div <?php $module->render_post_class(); ?> itemscope itemtype="<?php FLPostGridModule::schema_itemtype(); ?>">
	<?php

	FLPostGridModule::schema_meta();

	echo do_shortcode( $settings->custom_post_layout->html );

	?>
</div>

<?php if ( 'columns' == $settings->layout ) : ?>
</div>
<?php endif; ?>
