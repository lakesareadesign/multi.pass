<?php

// Get the query data.
$query = FLBuilderLoop::query( $settings );

// Render the posts.
if ( $query->have_posts() ) :

	do_action( 'fl_builder_posts_module_before_posts', $settings, $query );

	$paged = ( FLBuilderLoop::get_paged() > 0 ) ? ' fl-paged-scroll-to' : '';

	?>
	<div class="fl-post-<?php echo $module->get_layout_slug() . $paged; ?>"<?php echo FLPostGridModule::print_schema( ' itemscope="itemscope" itemtype="https://schema.org/Blog")' ); ?>>
	<?php

	if ( 'li' == $module->get_posts_container() ) :
		if ( '' != $module->settings->posts_container_ul_class ) {
			echo '<ul class="' . $module->settings->posts_container_ul_class . '">';
		} else {
			echo '<ul>';
		}
	endif;


	while ( $query->have_posts() ) {

		$query->the_post();

		ob_start();

		include apply_filters( 'fl_builder_posts_module_layout_path', $module->dir . 'includes/post-' . $module->get_layout_slug() . '.php', $settings->layout, $settings );

		// Do shortcodes here so they are parsed in context of the current post.
		echo do_shortcode( ob_get_clean() );
	}

	if ( 'li' == $module->get_posts_container() ) :
		echo '</ul>';
	endif;

	?>
	<?php if ( 'grid' == $settings->layout ) : ?>
	<div class="fl-post-grid-sizer"></div>
	<?php endif; ?>
</div>
<div class="fl-clear"></div>
<?php endif; ?>
<?php

do_action( 'fl_builder_posts_module_after_posts', $settings, $query );

// Render the pagination.
if ( 'none' != $settings->pagination && $query->have_posts() && $query->max_num_pages > 1 ) :

	?>
	<div class="fl-builder-pagination"<?php echo ( in_array( $settings->pagination, array( 'scroll', 'load_more' ) ) ) ? ' style="display:none;"' : ''; ?>>
	<?php FLBuilderLoop::pagination( $query ); ?>
	</div>
	<?php if ( 'load_more' == $settings->pagination && $query->max_num_pages > 1 ) : ?>
		<div class="fl-builder-pagination-load-more">
			<?php

			FLBuilder::render_module_html( 'button', $module->get_button_settings() );

			?>
</div>
<?php endif; ?>
<?php endif; ?>
<?php

do_action( 'fl_builder_posts_module_after_pagination', $settings, $query );

// Render the empty message.
if ( ! $query->have_posts() ) :

	?>
<div class="fl-post-grid-empty">
	<p><?php echo $settings->no_results_message; ?></p>
	<?php if ( $settings->show_search ) : ?>
		<?php get_search_form(); ?>
	<?php endif; ?>
</div>

	<?php

endif;

wp_reset_postdata();
