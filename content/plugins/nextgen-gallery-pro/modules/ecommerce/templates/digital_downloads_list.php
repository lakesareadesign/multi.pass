<div class="digital_downloads_list">
    <p><?php echo esc_html($i18n->order_info) ?></p>
    <table>
        <tr>
            <th class="image_column"><?php echo esc_html($i18n->image_header) ?></th>
            <th class="desc_column"><?php echo esc_html($i18n->item_description_header) ?></th>
            <th class="resolution_column"><?php echo esc_html($i18n->resolution_header) ?></th>
            <th class="download_column"><?php echo esc_html($i18n->download_header) ?></th>
        </tr>
        <tr>
            <td class="heading_separator" colspan="4"></td>
        </tr>
        <?php foreach ($images as $image): ?>
            <tr>
                <td class="image_column">
                    <img
                        src="<?php echo esc_attr($image->thumbnail_url)?>"
                        alt="<?php echo esc_attr($image->alttext) ?>"
                    />
                </td>

                <td class="desc_column"><?php echo esc_html($image->item_description)?></td>

                <td class="resolution_column"><?php echo esc_html($image->resolution) ?> px</td>

                <td class="download_column">
                    <a href="<?php echo esc_attr($image->download_url)?>" download="<?php echo esc_attr($image->resolution)?>-<?php echo esc_attr($image->filename) ?>">Download</a>
                </td>
            </tr>
        <?php endforeach ?>
    </table>
</div>