<h2><?php esc_html_e($i18n->add_to_cart); ?> <span class="fa fa-shopping-cart"></span></h2>
<div class='nggpl-cart_summary'>
    <a href='#' class='nggpl-cart_count'></a>
    <span class='nggpl-cart_total'></span>
</div>

<!--<span id='ngg_qty_add_desc'><?php esc_html_e($i18n->qty_add_desc); ?></span>-->

<hr/>

<div id='nggpl-items_for_sale'>
    <div class='nggpl-pricelist_source_accordion' class='accordion'>
        <?php foreach($sources as $source) {
            echo $source;
        } ?>
    </div>
    <input class='nggpl-button' type='button' id='ngg_update_cart_btn' value='<?php echo esc_attr($i18n->update_cart); ?>'/>
    <input class='nggpl-button' type='button' id='ngg_checkout_btn' value='<?php echo esc_attr($i18n->checkout); ?>'/>
</div>
<div id='nggpl-not_for_sale'>
    <?php esc_html_e($not_for_sale_msg); ?>
</div>