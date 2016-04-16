<div class="ngg_pro_proofing_confirmation">
    <?php foreach ($images as $image) { ?>
        <img src="<?php echo esc_attr($storage->get_image_url($image, 'thumb')); ?>"
             alt="<?php echo esc_attr($image->alttext); ?>"/>
    <?php } ?>
</div>
