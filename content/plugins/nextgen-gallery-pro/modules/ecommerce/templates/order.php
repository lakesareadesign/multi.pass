<div class="ngg_pro_order_info">
    <table>
        <?php
        foreach ($images as $image):
            $item_count = count($image->items);
            $item       = array_shift($image->items);
            ?>
            <tr>
                <td class='ngg_order_image_column'>
                    <img src="<?php echo esc_attr($image->thumbnail_url)?>"
                         alt="<?php echo esc_attr($image->alttext)?>"
                         width="<?php echo esc_attr($image->dimensions['width'])?>"
                         height="<?php echo esc_attr($image->dimensions['height'])?>"/>
                    <?php if (current_user_can('manage_options')) { ?>
                    <span class='ngg_order_image_filename'
                          style="max-width: <?php echo esc_attr($image->dimensions['width'])?>px">
                        <?php esc_html_e($image->filename); ?>
                    </span>
                    <?php } ?>
                </td>
                <td class='ngg_order_interior_parent'>
                    <table>
                        <tr>
                            <th><?php esc_html_e($i18n->quantity)?></th>
                            <th><?php esc_html_e($i18n->description)?></th>
                            <th class="ngg_order_price_column"><?php esc_html_e($i18n->price)?></th>
                            <th><?php esc_html_e($i18n->total)?></th>
                        </tr>
                        <tr class='ngg_order_separator'>
                            <td colspan="4"></td>
                        </tr>
                        <tr>
                            <td>
                                <span><?php esc_html_e($item->quantity)?></span>
                            </td>
                            <td>
                                <?php esc_html_e($item->title)?>
                            </td>
                            <td class='ngg_order_price_column'>
                                <?php echo(M_NextGen_Pro_Ecommerce::get_formatted_price($item->price)) ?>
                            </td>
                            <td>
                                <?php echo(M_NextGen_Pro_Ecommerce::get_formatted_price($item->price * $item->quantity))?>
                            </td>
                        </tr>
                        <?php foreach ($image->items as $item): ?>
                            <tr>
                                <td>
                                    <span><?php esc_html_e($item->quantity)?></span>
                                </td>
                                <td>
                                    <?php esc_html_e($item->title)?>
                                </td>
                                <td class='ngg_order_price_column'>
                                    <?php echo(M_NextGen_Pro_Ecommerce::get_formatted_price($item->price)) ?>
                                </td>
                                <td>
                                    <?php echo(M_NextGen_Pro_Ecommerce::get_formatted_price($item->price * $item->quantity))?>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </table>
                </td>
            </tr>
        <?php endforeach ?>
    </table>
</div>
