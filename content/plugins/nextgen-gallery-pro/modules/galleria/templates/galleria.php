<?php $this->start_element('nextgen_gallery.gallery_container', 'container', $displayed_gallery); ?>
<div class="ngg-galleria-parent <?php echo esc_attr($theme); ?>"
     data-id="<?php echo esc_attr($displayed_gallery_id); ?>"
     id="displayed_gallery_<?php echo esc_attr($displayed_gallery_id); ?>"
     style="text-align: center;">
	<div class="ngg-galleria"></div>
</div>
<?php $this->end_element(); ?>