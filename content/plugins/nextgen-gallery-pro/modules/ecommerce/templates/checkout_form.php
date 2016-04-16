<script type="text/javascript">
    jQuery(function($){
        var cart = new Ngg_Pro_Cart.Views.Cart();
    });
</script>
<script type="'text/template" id="ngg_pro_cart_image_tmpl">
    <td class="ngg_pro_cart_image_column">
        <img src='{image.thumbnail_url}' width='{image.width}' height='{image.height}' alt='{image.alttext}' title='{image.alttext}'/>
    </td>
    <td class='ngg_pro_cart_content_column'>
        <table class='ngg_pro_cart_items'>
            <thead>
            <tr class="header">
                <th class="quantity_column"><?php echo esc_html($i18n->quantity_header)?></th>
                <th class="title_column"><?php echo esc_html($i18n->item_header)?></th>
                <th class="price_column"><?php echo esc_html($i18n->price_header)?></th>
                <th class="subtotal_column"><?php echo esc_html($i18n->total_header)?></th>
            </tr>
            </thead>
        </table>
    </td>
</script>
<script type="'text/template" id="ngg_pro_cart_item_tmpl">
    <td class='quantity_column'>
        <input type='number' min='0' name='items[{item.image_id}][{item.id}]' value='{item.quantity}' class='nggpl-quantity_field'/>
        <a class='ngg_pro_delete_item' href='#'>
            <i class='fa fa-times-circle'></i>
        </a>
    </td>
    <td class='title_column'>{item.title}<br/><i>{image.filename}</i></td>
    <td class='price_column'>{item.price_formatted}</td>
    <td class='subtotal_column'>
        <span>{item.subtotal_formatted}</span>
    </td>
</script>
<form id="ngg_pro_checkout" action="<?php echo $_SERVER['REQUEST_URI']?>" method="post">
    <div id="ngg_pro_links_wrapper">
        <?php if ($referrer_url): ?>
            <a class='ngg_pro_btn' href="<?php echo esc_attr($referrer_url)?>" id="ngg_pro_continue_shopping"><?php esc_html_e($i18n->continue_shopping)?></a>
        <?php endif ?>
        <a class='ngg_pro_btn' href="javascript:Ngg_Pro_Cart.get_instance().empty_cart();window.location.reload();"><?php esc_html_e($i18n->empty_cart)?></a>
    </div>
    <table>
        <tbody class="ngg_pro_cart_images">
        </tbody>
        <tfoot>
        <tr id="ngg_pro_no_items">
            <td colspan="2"><?php echo esc_html($i18n->no_items)?></td>
        </tr>
        <tr id="ngg_pro_cart_subitems">
            <td></td>
            <td>
                <table>
                    <tr>
                        <th class='combined_column' colspan="4"><label><?php esc_html_e($i18n->subtotal)?></label></th>
                        <th id="nggpl-subtotal_field">$0.00</th>
                    </tr>
                    <tr id="ship_to_row">
                        <th class="combined_column" colspan="4"><label><?php esc_html_e($i18n->ship_to)?></label></th>
                        <th id="nggpl-ship_to_field">
                            <select name='ship_to'>
                                <option value="1"><?php esc_html_e($country)?></option>
                                <option value="0"><?php esc_html_e($i18n->ship_elsewhere)?></option>
                            </select>
                        </th>
                    </tr>
                    <tr>
                        <th class='combined_column' colspan="4"><label><?php esc_html_e($i18n->shipping)?></label></th>
                        <th id="nggpl-shipping_field">$0.00</th>
                    </tr>
                    <tr>
                        <th class='combined_column' colspan="4"><label><?php esc_html_e($i18n->total)?></label></th>
                        <th id="nggpl-total_field">$0.00</th>
                    </tr>
                </table>
            </td>
        </tr>
        </tfoot>
    </table>
    <div id="ngg_pro_checkout_buttons">
        <?php foreach ($buttons as $button): ?>
            <?php echo $button ?>
        <?php endforeach ?>
    </div>
</form>
